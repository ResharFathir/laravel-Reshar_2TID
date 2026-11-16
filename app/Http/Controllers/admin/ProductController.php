<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(15);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create', ['product' => new Product(['type' => 'sepatu', 'color_1' => '#14213D', 'color_2' => '#D9F24B'])]);
    }

    public function store(Request $request)
    {
        Product::create($this->data($request));

        return redirect()->route('admin.products.index')->with('success', 'Produk ditambahkan');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $product->update($this->data($request));

        return redirect()->route('admin.products.index')->with('success', 'Produk diperbarui');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk dihapus');
    }

    private function data(Request $request): array
    {
        $data = $request->validate([
            'name'    => 'required|string|max:120',
            'type'    => 'required|in:sepatu,accessory',
            'brand'   => 'nullable|required_if:type,sepatu|in:' . implode(',', Product::BRANDS),
            'gender'  => 'nullable|required_if:type,sepatu|in:pria,wanita,anak',
            'group'   => 'nullable|string|max:60',
            'price'   => 'required|integer|min:0',
            'stock'   => 'required|integer|min:0',
            'color_1' => 'required|string|max:9',
            'color_2' => 'nullable|string|max:9',
        ]);
        $data['is_trending'] = $request->boolean('is_trending');

        if ($data['type'] === 'accessory') {
            $data['brand'] = $data['gender'] = null;
        }

        return $data;
    }
}
