<?php
// Tambahkan ke routes/web.php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/trending', [HomeController::class, 'trending'])->name('trending');
Route::get('/kategori/{gender}', [HomeController::class, 'kategori'])->name('kategori')->whereIn('gender', ['pria', 'wanita', 'anak']);
Route::get('/accessories', [HomeController::class, 'accessories'])->name('accessories');
Route::get('/cari', [HomeController::class, 'cari'])->name('cari');

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class)->except('show');
});

// Di database/seeders/DatabaseSeeder.php, dalam run():
// $this->call(ProductSeeder::class);
