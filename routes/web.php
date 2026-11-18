
<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PortofolioController;
use App\Http\Controllers\ProdukTokoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\BumaloController;
use Illuminate\Support\Facades\Route;

// Halaman utama
Route::get('/', [BumaloController::class, 'index'])->name('shop.index');

// Portofolio
Route::resource('portofolio', PortofolioController::class);

// Home dan Dashboard
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::post('/question/store', [QuestionController::class, 'store'])
    ->name('question.store');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

// Pelanggan
Route::resource('pelanggan', PelangganController::class);

// Profil
Route::get('/profil/edit', [ProfileController::class, 'edit'])
    ->name('profile.edit');

Route::put('/profil', [ProfileController::class, 'update'])
    ->name('profile.update');

Route::delete('/profil/foto', [ProfileController::class, 'destroyPhoto'])
    ->name('profile.photo.destroy');

// User Admin
Route::resource('user', UserController::class)
    ->except('show')
    ->names('admin.user');

// Toko
Route::prefix('toko')->name('toko.')->group(function () {
    // Grup toko disiapkan untuk pengembangan selanjutnya
});

// Katalog dan produk
Route::get('/toko', fn () => redirect()->route('shop.index'));

Route::get('/produk/{slug}', [BumaloController::class, 'product'])
    ->name('shop.product');

Route::get('/panduan-ukuran', [BumaloController::class, 'sizeGuide'])
    ->name('shop.sizes');

Route::get('/panduan-tukar', [BumaloController::class, 'exchangePolicy'])
    ->name('shop.exchange');

// Keranjang
Route::get('/keranjang', [BumaloController::class, 'cart'])
    ->name('cart.index');

Route::post('/keranjang', [BumaloController::class, 'addToCart'])
    ->name('cart.add');

Route::patch('/keranjang/{variant}', [BumaloController::class, 'updateCart'])
    ->name('cart.update');

Route::delete('/keranjang/{variant}', [BumaloController::class, 'removeCart'])
    ->name('cart.remove');

// Checkout
Route::get('/checkout', [BumaloController::class, 'checkout'])
    ->name('checkout');

Route::post('/checkout', [BumaloController::class, 'placeOrder'])
    ->name('checkout.store');

// Pesanan
Route::get('/pesanan/{code}', [BumaloController::class, 'order'])
    ->name('orders.show');

Route::post('/pesanan/{code}/bukti', [BumaloController::class, 'uploadProof'])
    ->name('orders.proof');

Route::post('/pesanan/{code}/selesai', [BumaloController::class, 'completeOrder'])
    ->name('orders.complete');

// Autentikasi pelanggan
Route::get('/masuk', [BumaloController::class, 'login'])
    ->name('login');

Route::post('/masuk', [BumaloController::class, 'authenticate'])
    ->name('login.store');

Route::get('/daftar', [BumaloController::class, 'register'])
    ->name('register');

Route::post('/daftar', [BumaloController::class, 'storeCustomer'])
    ->name('register.store');

Route::post('/keluar', [BumaloController::class, 'logout'])
    ->name('logout');

// Setup admin
Route::get('/admin/setup', [BumaloController::class, 'adminSetup'])
    ->name('admin.setup');

Route::post('/admin/setup', [BumaloController::class, 'storeFirstAdmin'])
    ->name('admin.setup.store');

// Dashboard admin
Route::get('/admin', [BumaloController::class, 'admin'])
    ->middleware(['auth', 'bumalo.admin'])
    ->name('admin.dashboard');

Route::get('/admin/orders', [BumaloController::class, 'orders'])
    ->middleware(['auth', 'bumalo.admin'])
    ->name('admin.orders.index');

// Manajemen produk admin
Route::resource('/admin/products', ProdukTokoController::class)
    ->except('show')
    ->names('admin.products')
    ->middleware(['auth', 'bumalo.admin']);

// Manajemen akun admin
Route::resource('/admin/accounts', AccountController::class)
    ->except('show')
    ->parameters(['accounts' => 'account'])
    ->names('admin.accounts')
    ->middleware(['auth', 'bumalo.admin']);

// Pengiriman pesanan
Route::post('/admin/orders/{order}/ship', [BumaloController::class, 'shipOrder'])
    ->middleware(['auth', 'bumalo.admin'])
    ->name('admin.orders.ship');

// Verifikasi pembayaran
Route::post('/admin/payments/{order}/verify', [BumaloController::class, 'verifyPayment'])
    ->middleware(['auth', 'bumalo.admin'])
    ->name('admin.payments.verify');

Route::get('/admin/payments/{order}/proof', [BumaloController::class, 'paymentProof'])
    ->middleware(['auth', 'bumalo.admin'])
    ->name('admin.payments.proof');

// Toko Admin
Route::prefix('toko-admin')
    ->name('toko.admin.')
    ->middleware(['auth', 'bumalo.admin'])
    ->group(function () {

        Route::redirect('/', '/toko-admin/products');

        Route::resource('products', ProdukTokoController::class)
            ->except('show');
    });
