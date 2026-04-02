<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\Auth\CustomerAuthController;

/*
|--------------------------------------------------------------------------
| 1. HALAMAN PUBLIK
|--------------------------------------------------------------------------
*/
Route::get('/', function () { return view('beranda'); })->name('home');
Route::get('/tentang', function () { return view('tentang'); })->name('tentang'); 

/*
|--------------------------------------------------------------------------
| 2. AREA PELANGGAN (GUARD: WEB / TABEL: USERS)
|--------------------------------------------------------------------------
*/
Route::get('/login', [CustomerAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [CustomerAuthController::class, 'login']);
Route::get('/register', [CustomerAuthController::class, 'showRegister'])->name('customer.register');
Route::post('/register', [CustomerAuthController::class, 'register']);

Route::middleware('auth:web')->group(function () {
    Route::get('/menu', [OrderController::class, 'menu'])->name('menu');
    Route::get('/history', [OrderController::class, 'history'])->name('order.history');
    Route::post('/ulasan', [UlasanController::class, 'store'])->name('ulasan.store');
});

/*
|--------------------------------------------------------------------------
| 3. AREA ADMIN (GUARD: ADMIN / TABEL: ADMINS)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    // Rute Login Admin (Tanpa Proteksi)
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login']);

    // Rute Terproteksi Khusus Admin
    // Menggunakan auth:admin agar tidak terlempar ke login pelanggan
    Route::middleware('auth:admin')->group(function () {
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders');
        Route::post('/orders/{id}/status', [AdminOrderController::class, 'nextStatus'])->name('admin.orders.status');
        Route::delete('/orders/{id}', [AdminOrderController::class, 'destroy'])->name('admin.orders.destroy');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    });
});