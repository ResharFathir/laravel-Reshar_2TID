<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PelangganController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortofolioController;

Route::redirect('/', '/portofolio');
Route::resource('portofolio', PortofolioController::class);

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post('/question/store', [QuestionController::class, 'store'])
    ->name('question.store');
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');
Route::resource('pelanggan', PelangganController::class);
Route::put('/pelanggan/{id}', [PelangganController::class, 'update'])->name('pelanggan.update');
Route::delete('/pelanggan/{id}', [PelangganController::class, 'destroy'])->name('pelanggan.destroy');
Route::get('/', function () {
    return redirect()->route('portofolio.index');
});

Route::resource('pelanggan', PelangganController::class);
Route::resource('portofolio', PortofolioController::class);
Route::get('/profil/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profil/foto', [ProfileController::class, 'destroyPhoto'])->name('profile.photo.destroy');
Route::resource('user', UserController::class)->except('show')->names('admin.user');