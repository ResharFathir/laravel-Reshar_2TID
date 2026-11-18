<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $featured = Product::shoes()->orderByDesc('is_trending')->latest('id')->take(10)->get();

        return view('bumalo.home', compact('featured'));
    }

    public function trending()
    {
        $products = Product::shoes()->where('is_trending', true)->get();

        return view('bumalo.trending', compact('products'));
    }

    public function kategori(Request $request, string $gender)
    {
        abort_unless(array_key_exists($gender, Product::GENDERS), 404);

        $brand = $request->query('brand');
        $products = Product::shoes()
            ->where('gender', $gender)
            ->when(in_array($brand, Product::BRANDS), fn ($q) => $q->where('brand', $brand))
            ->get();

        return view('bumalo.kategori', [
            'gender'   => $gender,
            'title'    => 'Sepatu ' . Product::GENDERS[$gender],
            'brands'   => Product::BRANDS,
            'brand'    => $brand,
            'products' => $products,
        ]);
    }

    public function accessories()
    {
        $products = Product::accessories()->get();

        return view('bumalo.accessories', compact('products'));
    }

    public function cari(Request $request)
    {
        $q = trim((string) $request->query('q'));
        $products = Product::shoes()
            ->where(fn ($w) => $w->where('name', 'like', "%{$q}%")->orWhere('brand', 'like', "%{$q}%"))
            ->get();

        return view('bumalo.cari', compact('q', 'products'));
    }
}
