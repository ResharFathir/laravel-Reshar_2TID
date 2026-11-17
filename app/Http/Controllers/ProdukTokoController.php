<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProdukTokoController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['brand', 'category', 'variants'])
            ->when($request->filled('q'), fn ($query) => $query->where('name', 'like', '%'.$request->string('q').'%'))
            ->when($request->filled('category'), fn ($query) => $query->where('category_id', $request->integer('category')))
            ->when($request->input('status') === 'inactive', fn ($query) => $query->where('is_active', false), fn ($query) => $query->where('is_active', true))
            ->latest()->paginate(12)->withQueryString();

        return view('bumalo.admin.products.index', [
            'products' => $products,
            'categories' => Category::orderBy('name')->get(),
            'activeCount' => Product::where('is_active', true)->count(),
            'stockCount' => ProductVariant::whereHas('product', fn ($query) => $query->where('is_active', true))->sum('stock'),
        ]);
    }

    public function create()
    {
        return view('bumalo.admin.products.create', $this->formData(new Product(['is_active' => true])));
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $image = $request->file('image')?->store('products', 'public');

        DB::transaction(function () use ($data, $image) {
            $product = Product::create([
                'name' => $data['name'], 'slug' => $this->uniqueSlug($data['name']),
                'brand_id' => $data['brand_id'], 'category_id' => $data['category_id'],
                'description' => $data['description'] ?? null, 'price' => $data['price'],
                'image' => $image, 'is_active' => $data['is_active'],
            ]);
            $this->saveVariants($product, $data['variants']);
        });

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $product->load('variants');
        return view('bumalo.admin.products.edit', $this->formData($product));
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validatedData($request);
        $oldImage = $product->image;
        $newImage = $request->file('image')?->store('products', 'public');

        DB::transaction(function () use ($data, $product, $newImage) {
            $product->update([
                'name' => $data['name'], 'slug' => $this->uniqueSlug($data['name'], $product->id),
                'brand_id' => $data['brand_id'], 'category_id' => $data['category_id'],
                'description' => $data['description'] ?? null, 'price' => $data['price'],
                'image' => $newImage ?: $product->image, 'is_active' => $data['is_active'],
            ]);
            $this->saveVariants($product, $data['variants']);
        });

        if ($newImage && $oldImage) {
            Storage::disk('public')->delete($oldImage);
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $hasOrderHistory = $product->variants()->whereHas('orderItems')->exists();

        if ($hasOrderHistory) {
            $product->update(['is_active' => false]);
            $product->variants()->update(['stock' => 0]);
            $message = 'Produk dinonaktifkan karena sudah memiliki riwayat pesanan.';
        } else {
            if ($product->image) Storage::disk('public')->delete($product->image);
            $product->delete();
            $message = 'Produk berhasil dihapus.';
        }

        return redirect()->route('admin.products.index')->with('success', $message);
    }

    private function formData(Product $product): array
    {
        return [
            'product' => $product,
            'brands' => Brand::orderBy('name')->get(),
            'categories' => Category::orderBy('name')->get(),
            'variants' => old('variants', $product->variants->map(fn ($variant) => ['size' => $variant->size, 'stock' => $variant->stock])->all() ?: [['size' => '', 'stock' => 0]]),
        ];
    }

    private function validatedData(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:160'],
            'brand_id' => ['required', 'integer', 'exists:brands,id'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'description' => ['nullable', 'string', 'max:3000'],
            'price' => ['required', 'integer', 'min:0', 'max:100000000'],
            'is_active' => ['nullable', 'boolean'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'variants' => ['required', 'array', 'min:1', 'max:20'],
            'variants.*.size' => ['required', 'string', 'max:8'],
            'variants.*.stock' => ['required', 'integer', 'min:0', 'max:10000'],
        ]);

        $sizes = array_map(fn ($variant) => trim($variant['size']), $data['variants']);
        if (count($sizes) !== count(array_unique($sizes))) {
            throw \Illuminate\Validation\ValidationException::withMessages(['variants' => 'Ukuran produk tidak boleh duplikat.']);
        }
        $data['variants'] = array_map(fn ($variant) => ['size' => trim($variant['size']), 'stock' => (int) $variant['stock']], $data['variants']);
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }

    private function saveVariants(Product $product, array $variants): void
    {
        $sizes = collect($variants)->pluck('size')->all();
        $product->variants()->whereNotIn('size', $sizes)->update(['stock' => 0]);

        foreach ($variants as $variant) {
            $existing = $product->variants()->where('size', $variant['size'])->first();
            $sku = $existing?->sku ?? strtoupper(Str::limit(Str::slug($product->slug), 18, '').'-'.$variant['size'].'-'.Str::random(5));
            $product->variants()->updateOrCreate(
                ['size' => $variant['size']],
                ['stock' => $variant['stock'], 'sku' => $sku],
            );
        }
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'produk';
        $slug = $base;
        $suffix = 2;

        while (Product::where('slug', $slug)->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }
}
