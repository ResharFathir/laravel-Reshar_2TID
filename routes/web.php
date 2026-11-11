<?php

use App\Http\Controllers\BumaloController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BumaloController::class, 'index'])->name('shop.index');
Route::get('/produk/{slug}', [BumaloController::class, 'product'])->name('shop.product');
Route::get('/panduan-ukuran', [BumaloController::class, 'sizeGuide'])->name('shop.sizes');
Route::get('/kebijakan-tukar', [BumaloController::class, 'exchangePolicy'])->name('shop.exchange');
Route::get('/keranjang', [BumaloController::class, 'cart'])->name('cart.index');
Route::post('/keranjang', [BumaloController::class, 'addToCart'])->name('cart.add');
Route::patch('/keranjang/{variant}', [BumaloController::class, 'updateCart'])->name('cart.update');
Route::delete('/keranjang/{variant}', [BumaloController::class, 'removeCart'])->name('cart.remove');
Route::get('/checkout', [BumaloController::class, 'checkout'])->name('checkout');
Route::post('/checkout', [BumaloController::class, 'placeOrder'])->name('checkout.store');
Route::get('/pesanan/{code}', [BumaloController::class, 'order'])->name('orders.show');
Route::post('/pesanan/{code}/bukti-pembayaran', [BumaloController::class, 'uploadProof'])->name('orders.proof');

Route::get('/masuk', [BumaloController::class, 'login'])->name('login');
Route::post('/masuk', [BumaloController::class, 'authenticate'])->name('login.store');
Route::get('/daftar', [BumaloController::class, 'register'])->name('register');
Route::post('/daftar', [BumaloController::class, 'storeCustomer'])->name('register.store');
Route::get('/admin/setup', [BumaloController::class, 'adminSetup'])->name('admin.setup');
Route::post('/admin/setup', [BumaloController::class, 'storeFirstAdmin'])->name('admin.setup.store');
Route::post('/keluar', [BumaloController::class, 'logout'])->name('logout');
Route::prefix('admin')->name('admin.')->middleware(['auth', 'bumalo.admin'])->group(function () {
    Route::get('/', [BumaloController::class, 'admin'])->name('dashboard');
    Route::resource('produk', ProductController::class)->except('show')->parameters(['produk' => 'product'])->names('products');
    Route::post('/pesanan/{order}/pembayaran', [BumaloController::class, 'verifyPayment'])->name('payments.verify');
    Route::post('/pesanan/{order}/pengiriman', [BumaloController::class, 'shipOrder'])->name('orders.ship');
    Route::post('/produk/{product}/stok', [BumaloController::class, 'updateStock'])->name('products.stock');
    Route::get('/pesanan/{order}/bukti-pembayaran', [BumaloController::class, 'paymentProof'])->name('payments.proof');
    Route::resource('akun', AccountController::class)->except('show')->parameters(['akun' => 'account'])->names('accounts');
});
Route::post('/pesanan/{code}/selesai', [BumaloController::class, 'completeOrder'])->name('orders.complete');
