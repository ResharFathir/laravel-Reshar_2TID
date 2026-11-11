<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    private function authorizeManager(): void
    {
        abort_unless(in_array(auth()->user()->role, ['admin', 'owner'], true), 403);
    }

    private function formData(Product $product): array
    {
        return ['product' => $product->load('variants'), 'brands' => Brand::orderBy('name')->get(), 'categories' => Category::orderBy('name')->get()];
    }

    public function index(Request $request)
    {
        $this->authorizeManager();
        $products = Product::with(['brand', 'category', 'variants'])
            ->when($request->filled('q'), fn ($query) => $query->where('name', 'like', '%'.$request->string('q').'%'))
            ->latest()->paginate(12)->withQueryString();
        return view('bumalo.products.index', compact('products'));
    }

    public function create()
    {
        $this->authorizeManager();
        return view('bumalo.products.form', $this->formData(new Product(['is_active' => true])) + ['editing' => false]);
    }

    public function store(Request $request)
    {
        $this->authorizeManager();
        $data = $this->validateProduct($request);
        $sizes = $data['sizes'];
        unset($data['sizes']);
        $data['slug'] = $this->uniqueSlug($data['name']);
        $data['image'] = $request->file('image')?->store('products', 'public');
        $product = DB::transaction(function () use ($data, $sizes) {
            $product = Product::create($data);
            foreach ($sizes as $variant) {
                $product->variants()->create([
                    'size' => (string) $variant['size'], 'stock' => $variant['stock'],
                    'sku' => strtoupper($product->slug.'-'.$variant['size']),
                ]);
            }
            return $product;
        });
        return redirect()->route('admin.products.edit', $product)->with('success', 'Produk baru berhasil dibuat.');
    }

    public function edit(Product $product)
    {
        $this->authorizeManager();
        return view('bumalo.products.form', $this->formData($product) + ['editing' => true]);
    }

    public function update(Request $request, Product $product)
    {
        $this->authorizeManager();
        $data = $this->validateProduct($request, $product);
        $sizes = $data['sizes'];
        unset($data['sizes']);
        if ($request->boolean('remove_image') && $product->image) Storage::disk('public')->delete($product->image);
        if ($request->hasFile('image')) {
            if ($product->image) Storage::disk('public')->delete($product->image);
            $data['image'] = $request->file('image')->store('products', 'public');
        } elseif ($request->boolean('remove_image')) {
            $data['image'] = null;
        }

        DB::transaction(function () use ($product, $data, $sizes) {
            $product->update($data);
            $keptSizes = [];
            foreach ($sizes as $variantData) {
                $size = (string) $variantData['size'];
                $keptSizes[] = $size;
                $variant = $product->variants()->firstOrNew(['size' => $size]);
                $oldStock = (int) ($variant->stock ?? 0);
                $variant->sku = strtoupper($product->slug.'-'.$size);
                $variant->stock = $variantData['stock'];
                $variant->save();
                if ($oldStock !== $variant->stock) {
                    StockMovement::create(['variant_id' => $variant->id, 'change' => $variant->stock - $oldStock, 'reason' => 'Pembaruan stok dari form produk', 'user_id' => auth()->id()]);
                }
            }
            $product->variants()->whereNotIn('size', $keptSizes)->delete();
        });
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $this->authorizeManager();
        DB::transaction(function () use ($product) {
            if ($product->image) Storage::disk('public')->delete($product->image);
            $product->delete();
        });
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }

    private function validateProduct(Request $request, ?Product $product = null): array
    {
        $data = $request->validate([
            'name' => 'required|string|max:180', 'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id', 'price' => 'required|integer|min:1|max:100000000',
            'description' => 'nullable|string|max:5000', 'is_active' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'remove_image' => 'nullable|boolean',
            'sizes' => 'required|array|min:1', 'sizes.*.size' => 'required|integer|min:30|max:50|distinct',
            'sizes.*.stock' => 'required|integer|min:0|max:10000',
        ]);
        $data['is_active'] = $request->boolean('is_active');
        return $data;
    }

    private function uniqueSlug(string $name): string
    {
        $base = Str::slug($name) ?: 'produk';
        $slug = $base;
        $suffix = 2;
        while (Product::where('slug', $slug)->exists()) $slug = $base.'-'.$suffix++;
        return $slug;
    }
}
