<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalShoes'       => Product::shoes()->count(),
            'totalAccessories' => Product::accessories()->count(),
            'totalTrending'    => Product::where('is_trending', true)->count(),
            'latest'           => Product::latest()->take(5)->get(),
        ]);
    }
}
