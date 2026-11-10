<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PelangganController;
   use App\Http\Controllers\ProdukTokoController;
   use App\Http\Controllers\ShopController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortofolioController;

Route::get('/', [PortofolioController::class, 'index']);
Route::resource('portofolio', PortofolioController::class);

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post('/question/store', [QuestionController::class, 'store'])
    ->name('question.store');
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');
Route::resource('pelanggan', PelangganController::class);
Route::get('/profil/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profil/foto', [ProfileController::class, 'destroyPhoto'])->name('profile.photo.destroy');
Route::resource('user', UserController::class)->except('show')->names('admin.user');

   // Toko: /toko
   Route::prefix('toko')->name('toko.')->group(function () {
       Route::get('/', [ShopController::class, 'index'])->name('home');
       Route::get('/trending', [ShopController::class, 'trending'])->name('trending');
       Route::get('/kategori/{gender}', [ShopController::class, 'kategori'])->name('kategori')->whereIn('gender', ['pria', 'wanita', 'anak']);
       Route::get('/accessories', [ShopController::class, 'accessories'])->name('accessories');
       Route::get('/cari', [ShopController::class, 'cari'])->name('cari');
   });

   // Admin produk toko: /toko-admin (perlu login)
   Route::prefix('toko-admin')->name('toko.admin.')->middleware('auth')->group(function () {
       Route::redirect('/', '/toko-admin/products');
       Route::resource('products', ProdukTokoController::class)->except('show');
   });