<?php

namespace App\Http\Controllers;

use App\Models\{Brand, Category, Order, OrderItem, Payment, Product, ProductVariant, Shipment, StockMovement, User};
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BumaloController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['brand', 'category', 'variants'])->where('is_active', true)
            ->when($request->filled('q'), fn ($q) => $q->where('name', 'like', '%'.$request->string('q').'%'))
            ->when($request->filled('kategori'), fn ($q) => $q->whereHas('category', fn ($c) => $c->where('name', $request->kategori)))
            ->when($request->filled('brand'), fn ($q) => $q->where('brand_id', $request->integer('brand')))
            ->when($request->boolean('ready_stock'), fn ($q) => $q->whereHas('variants', fn ($v) => $v->where('stock', '>', 0)))
            ->when($request->filled('price'), function ($q) use ($request) {
                match ($request->input('price')) {
                    'low' => $q->orderBy('price'),
                    'high' => $q->orderByDesc('price'),
                    'name' => $q->orderBy('name'),
                    default => $q->latest(),
                };
            }, fn ($q) => $q->latest())
            ->get();
        return view('bumalo.home', ['products' => $products, 'categories' => Category::orderBy('name')->get(), 'brands' => Brand::whereHas('products', fn ($query) => $query->where('is_active', true))->orderBy('name')->get(), 'cartCount' => array_sum(session('cart', []))]);
    }

    public function product(string $slug)
    {
        $product = Product::with(['brand', 'category', 'variants'])->where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('bumalo.product', compact('product'));
    }

    public function sizeGuide() { return view('bumalo.info', ['title' => 'Panduan ukuran', 'kind' => 'sizes']); }
    public function exchangePolicy() { return view('bumalo.info', ['title' => 'Panduan tukar ukuran', 'kind' => 'exchange']); }

    public function addToCart(Request $request)
    {
        $data = $request->validate(['variant_id' => 'required|exists:product_variants,id', 'quantity' => 'required|integer|min:1|max:5']);
        $variant = ProductVariant::with('product')->findOrFail($data['variant_id']);
        abort_unless($variant->product->is_active, 404);
        if ($variant->stock < ($data['quantity'] + (int) session("cart.{$variant->id}", 0))) return back()->withErrors(['stock' => 'Stok ukuran tersebut tidak mencukupi.']);
        session()->put("cart.{$variant->id}", (int) session("cart.{$variant->id}", 0) + $data['quantity']);
        return redirect()->route('cart.index')->with('success', 'Sepatu ditambahkan ke keranjang.');
    }

    private function cartItems()
    {
        $cart = session('cart', []);
        return ProductVariant::with('product.brand')->whereIn('id', array_keys($cart))->get()
            ->map(fn ($v) => ['variant' => $v, 'quantity' => min((int) $cart[$v->id], $v->stock), 'line' => $v->product->price * min((int) $cart[$v->id], $v->stock)])
            ->filter(fn ($item) => $item['quantity'] > 0)->values();
    }

    public function cart() { $items = $this->cartItems(); return view('bumalo.cart', ['items' => $items, 'subtotal' => $items->sum('line')]); }
    public function updateCart(Request $request, ProductVariant $variant)
    {
        $qty = $request->validate(['quantity' => 'required|integer|min:1|max:5'])['quantity'];
        if ($qty > $variant->stock) return back()->withErrors(['stock' => 'Jumlah melebihi stok tersedia.']);
        session()->put("cart.{$variant->id}", $qty); return back()->with('success', 'Keranjang diperbarui.');
    }
    public function removeCart(ProductVariant $variant) { session()->forget("cart.{$variant->id}"); return back()->with('success', 'Produk dihapus dari keranjang.'); }
    public function checkout() { $items = $this->cartItems(); if ($items->isEmpty()) return redirect()->route('cart.index'); return view('bumalo.checkout', ['items' => $items, 'subtotal' => $items->sum('line')]); }

    public function placeOrder(Request $request)
    {
        $data = $request->validate(['customer_name' => 'required|string|max:120', 'email' => 'nullable|email|max:190', 'phone' => 'required|string|max:30', 'address' => 'required|string|max:1200', 'city' => 'required|string|max:100', 'postal_code' => 'nullable|string|max:12']);
        $cart = session('cart', []); if (empty($cart)) return redirect()->route('cart.index');
        $order = DB::transaction(function () use ($cart, $data, $request) {
            $rows = [];
            foreach ($cart as $id => $qty) {
                $variant = ProductVariant::with('product')->lockForUpdate()->findOrFail($id);
                if (!$variant->product->is_active || $variant->stock < $qty) throw \Illuminate\Validation\ValidationException::withMessages(['stock' => "Stok {$variant->product->name} ukuran {$variant->size} berubah. Periksa keranjang."]);
                $rows[] = [$variant, (int) $qty];
            }
            $subtotal = collect($rows)->sum(fn ($row) => $row[0]->product->price * $row[1]);
            $order = Order::create($data + ['code' => 'BM'.now()->format('ymd').Str::upper(Str::random(6)), 'user_id' => $request->user()?->id, 'subtotal' => $subtotal, 'shipping_cost' => 0, 'total' => $subtotal, 'status' => 'pending_payment', 'payment_due_at' => now()->addHours(24)]);
            foreach ($rows as [$variant, $qty]) {
                OrderItem::create(['order_id' => $order->id, 'variant_id' => $variant->id, 'product_name' => $variant->product->name, 'size' => $variant->size, 'price' => $variant->product->price, 'quantity' => $qty]);
                $variant->decrement('stock', $qty);
                StockMovement::create(['variant_id' => $variant->id, 'change' => -$qty, 'reason' => 'Reservasi pesanan '.$order->code, 'user_id' => $request->user()?->id]);
            }
            Payment::create(['order_id' => $order->id, 'amount' => $subtotal, 'status' => 'unsubmitted']);
            $order->shipment()->create();
            DB::table('order_status_logs')->insert(['order_id' => $order->id, 'status' => 'pending_payment', 'note' => 'Pesanan dibuat', 'created_at' => now(), 'updated_at' => now()]);
            return $order;
        });
        session()->forget('cart');
        session()->put("order_access.{$order->code}", true);
        return redirect()->route('orders.show', $order->code)->with('success', 'Pesanan berhasil dibuat. Transfer sesuai instruksi lalu unggah bukti pembayaran.');
    }

    private function findOrder(string $code): Order
    {
        return Order::with(['items', 'payment', 'shipment'])->where('code', $code)->firstOrFail();
    }
    public function order(Request $request, string $code)
    {
        $order = $this->findOrder($code);
        if (!session("order_access.{$code}") && $request->isMethod('get') && $request->filled('phone') && hash_equals($order->phone, (string) $request->phone)) session()->put("order_access.{$code}", true);
        return view('bumalo.order', ['order' => $order, 'authorized' => (bool) session("order_access.{$code}")]);
    }
    public function uploadProof(Request $request, string $code)
    {
        $data = $request->validate(['proof' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096']);
        $order = $this->findOrder($code);
        abort_unless(session("order_access.{$code}"), 403);
        abort_unless($order->status === 'pending_payment', 403);
        $path = $data['proof']->store('payment-proofs');
        $order->payment()->update(['proof_path' => $path, 'status' => 'submitted']);
        $order->update(['status' => 'payment_review']);
        $this->logStatus($order, 'payment_review', 'Bukti pembayaran diunggah');
        return back()->with('success', 'Bukti pembayaran diterima dan menunggu verifikasi admin.');
    }

    public function login() { return view('bumalo.login'); }
    public function register()
    {
        if (auth()->check()) return redirect()->route(auth()->user()->role === 'customer' ? 'shop.index' : 'admin.dashboard');
        return view('bumalo.register');
    }
    public function storeCustomer(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120', 'email' => 'required|email|max:190|unique:users,email',
            'phone' => 'nullable|string|max:30', 'password' => 'required|string|min:8|confirmed',
        ]);
        $data['role'] = 'customer';
        $user = User::create($data);
        auth()->login($user);
        $request->session()->regenerate();
        return redirect()->route('shop.index')->with('success', 'Akun berhasil dibuat. Selamat berbelanja!');
    }
    public function adminSetup()
    {
        if (User::whereIn('role', ['admin', 'owner'])->exists()) return redirect()->route('login')->with('success', 'Admin sudah terdaftar. Silakan masuk.');
        return view('bumalo.admin-setup');
    }
    public function storeFirstAdmin(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120', 'email' => 'required|email|max:190|unique:users,email',
            'phone' => 'nullable|string|max:30', 'password' => 'required|string|min:8|confirmed',
        ]);
        $user = DB::transaction(function () use ($data) {
            abort_if(User::whereIn('role', ['admin', 'owner'])->lockForUpdate()->exists(), 403, 'Admin pertama sudah terdaftar.');
            return User::create($data + ['role' => 'owner']);
        });
        auth()->login($user);
        $request->session()->regenerate();
        return redirect()->route('admin.dashboard')->with('success', 'Akun pemilik pertama berhasil dibuat.');
    }
    public function authenticate(Request $request)
    {
        $credentials = $request->validate(['email' => 'required|email', 'password' => 'required|string']);
        if (!auth()->attempt($credentials, $request->boolean('remember'))) return back()->withErrors(['email' => 'Email atau kata sandi tidak cocok.'])->onlyInput('email');
        $request->session()->regenerate();
        if (in_array($request->user()->role, ['admin', 'owner', 'warehouse'], true)) {
            return redirect()->intended(route('admin.dashboard'));
        }
        return redirect()->route('shop.index')->with('success', 'Berhasil masuk.');
    }
    public function logout(Request $request) { auth()->logout(); $request->session()->invalidate(); $request->session()->regenerateToken(); return redirect()->route('shop.index'); }

    public function admin(Request $request)
    {
        $orders = Order::with(['items', 'payment', 'shipment'])->latest()->limit(40)->get();
        $products = Product::with(['brand', 'variants'])->orderBy('name')->get();
        $revenueStatuses = ['processing', 'shipped', 'completed'];
        $period = in_array($request->input('period'), ['day', 'month', 'year'], true) ? $request->input('period') : 'month';
        $dateValue = (string) $request->input('date', '');
        $dateIsValid = match ($period) {
            'day' => preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $dateValue, $parts) && checkdate((int) $parts[2], (int) $parts[3], (int) $parts[1]),
            'month' => preg_match('/^(\d{4})-(\d{2})$/', $dateValue, $parts) && checkdate((int) $parts[2], 1, (int) $parts[1]),
            default => preg_match('/^\d{4}$/', $dateValue) && (int) $dateValue >= 1900 && (int) $dateValue <= 9999,
        };
        if (! $dateIsValid) {
            $dateValue = now()->format(['day' => 'Y-m-d', 'month' => 'Y-m', 'year' => 'Y'][$period]);
        }
        $start = match ($period) {
            'day' => Carbon::createFromFormat('!Y-m-d', $dateValue)->startOfDay(),
            'month' => Carbon::createFromFormat('!Y-m', $dateValue)->startOfMonth(),
            default => Carbon::createFromFormat('!Y', $dateValue)->startOfYear(),
        };
        $end = match ($period) {
            'day' => $start->copy()->endOfDay(),
            'month' => $start->copy()->endOfMonth(),
            default => $start->copy()->endOfYear(),
        };

        $driver = DB::getDriverName();
        $bucketExpression = match ([$period, $driver]) {
            ['day', 'mysql'] => "DATE_FORMAT(created_at, '%Y-%m-%d %H')",
            ['day', 'sqlite'] => "strftime('%Y-%m-%d %H', created_at)",
            ['year', 'mysql'] => "DATE_FORMAT(created_at, '%Y-%m')",
            ['year', 'sqlite'] => "strftime('%Y-%m', created_at)",
            default => 'DATE(created_at)',
        };
        $salesBuckets = Order::whereIn('status', $revenueStatuses)->whereBetween('created_at', [$start, $end])
            ->selectRaw($bucketExpression.' as bucket, SUM(total) as total')->groupBy('bucket')->pluck('total', 'bucket');
        $orderBuckets = Order::whereBetween('created_at', [$start, $end])
            ->selectRaw($bucketExpression.' as bucket, COUNT(*) as total')->groupBy('bucket')->pluck('total', 'bucket');
        $bucketCount = match ($period) { 'day' => 24, 'month' => $start->daysInMonth, default => 12 };
        $chart = collect(range(0, $bucketCount - 1))->map(function (int $index) use ($period, $start, $salesBuckets, $orderBuckets) {
            $point = match ($period) {
                'day' => $start->copy()->addHours($index),
                'month' => $start->copy()->addDays($index),
                default => $start->copy()->addMonths($index),
            };
            $key = match ($period) { 'day' => $point->format('Y-m-d H'), 'month' => $point->toDateString(), default => $point->format('Y-m') };
            $label = match ($period) { 'day' => $point->format('H'), 'month' => $point->format('d'), default => $point->translatedFormat('M') };
            return ['label' => $label, 'total' => (int) $salesBuckets->get($key, 0), 'orders' => (int) $orderBuckets->get($key, 0)];
        });
        $sales = (int) $chart->sum('total');
        $periodOrderCount = (int) $chart->sum('orders');
        $topProducts = OrderItem::query()->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->whereIn('orders.status', $revenueStatuses)->whereBetween('orders.created_at', [$start, $end])
            ->selectRaw('order_items.product_name, SUM(order_items.quantity) as quantity')
            ->groupBy('order_items.product_name')->orderByDesc('quantity')->limit(5)->get();
        $insight = $topProducts->isNotEmpty()
            ? $topProducts->first()->product_name.' menjadi produk terlaris dengan '.$topProducts->first()->quantity.' pasang terjual pada periode ini.'
            : 'Belum ada penjualan terverifikasi pada periode ini. Bagikan koleksi unggulan untuk mulai menarik pelanggan.';
        return view('bumalo.admin', [
            'orders' => $orders, 'products' => $products,
            'sales' => $sales, 'periodSales' => $sales, 'periodOrderCount' => $periodOrderCount,
            'period' => $period, 'dateValue' => $dateValue, 'chart' => $chart, 'topProducts' => $topProducts, 'insight' => $insight,
            'orderCount' => Order::count(), 'pendingPayments' => Order::where('status', 'payment_review')->count(),
            'customerCount' => User::where('role', 'customer')->count(), 'staffCount' => User::whereIn('role', ['admin', 'owner', 'warehouse'])->count(),
            'productCount' => Product::count(), 'stockUnits' => ProductVariant::sum('stock'),
            'lowStock' => ProductVariant::with('product')->where('stock', '<=', 3)->orderBy('stock')->get(),
            'statusCounts' => Order::selectRaw('status, COUNT(*) as total')->groupBy('status')->pluck('total', 'status'),
        ]);
    }
    public function verifyPayment(Request $request, Order $order)
    {
        abort_unless(auth()->user()->role === 'admin' || auth()->user()->role === 'owner', 403);
        $data = $request->validate(['decision' => 'required|in:approve,reject', 'note' => 'nullable|string|max:500']);
        abort_unless($order->status === 'payment_review', 422);
        $status = $data['decision'] === 'approve' ? 'processing' : 'pending_payment';
        $order->payment()->update(['status' => $data['decision'] === 'approve' ? 'verified' : 'rejected', 'note' => $data['note'] ?? null, 'verified_by' => auth()->id(), 'verified_at' => now()]);
        $order->update(['status' => $status, 'admin_note' => $data['note'] ?? null]); $this->logStatus($order, $status, $data['note'] ?? null);
        return back()->with('success', 'Status pembayaran diperbarui.');
    }
    public function shipOrder(Request $request, Order $order)
    {
        abort_unless(in_array(auth()->user()->role, ['admin','owner','warehouse'], true), 403);
        $data = $request->validate(['courier' => 'required|string|max:60', 'tracking_number' => 'required|string|max:100']);
        abort_unless($order->status === 'processing', 422);
        $order->shipment()->update($data + ['shipped_at' => now()]); $order->update(['status' => 'shipped']);
        $this->logStatus($order, 'shipped', 'Pesanan diserahkan ke kurir'); return back()->with('success', 'Resi tersimpan.');
    }
    public function completeOrder(string $code)
    {
        $order = $this->findOrder($code);
        abort_unless(session("order_access.{$code}") && $order->status === 'shipped', 403);
        $order->update(['status' => 'completed']); $this->logStatus($order, 'completed', 'Pelanggan mengonfirmasi pesanan diterima');
        return back()->with('success', 'Terima kasih. Pesanan ditandai selesai.');
    }
    public function paymentProof(Order $order)
    {
        abort_unless(in_array(auth()->user()->role, ['admin', 'owner'], true), 403);
        abort_unless($order->payment?->proof_path && Storage::exists($order->payment->proof_path), 404);
        return Storage::response($order->payment->proof_path);
    }
    public function updateStock(Request $request, Product $product)
    {
        abort_unless(in_array(auth()->user()->role, ['admin','owner'], true), 403);
        $data = $request->validate(['variant_id' => 'required|exists:product_variants,id', 'stock' => 'required|integer|min:0|max:10000']);
        $variant = $product->variants()->findOrFail($data['variant_id']); $change = $data['stock'] - $variant->stock;
        $variant->update(['stock' => $data['stock']]);
        StockMovement::create(['variant_id' => $variant->id, 'change' => $change, 'reason' => 'Penyesuaian stok admin', 'user_id' => auth()->id()]);
        return back()->with('success', 'Stok ukuran '.$variant->size.' diperbarui.');
    }
    private function logStatus(Order $order, string $status, ?string $note): void
    {
        DB::table('order_status_logs')->insert(['order_id' => $order->id, 'status' => $status, 'user_id' => auth()->id(), 'note' => $note, 'created_at' => now(), 'updated_at' => now()]);
    }
}
