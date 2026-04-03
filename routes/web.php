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
| 2. AUTH PELANGGAN (GUEST)
|--------------------------------------------------------------------------
*/
Route::middleware('guest:web')->group(function () {
    Route::get('/login', [CustomerAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [CustomerAuthController::class, 'login']);
    Route::get('/register', [CustomerAuthController::class, 'showRegister'])->name('customer.register');
    Route::post('/register', [CustomerAuthController::class, 'register']);
});
Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('customer.logout');

/*
|--------------------------------------------------------------------------
| 3. AREA PELANGGAN TERPROTEKSI (GUARD: WEB)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:web')->group(function () {
    // Menu & Keranjang
    Route::get('/menu', [OrderController::class, 'menu'])->name('menu');
    Route::get('/cart', [OrderController::class, 'showCart'])->name('cart.show');
    Route::post('/cart/add/{id}', [OrderController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/decrease/{id}', [OrderController::class, 'decrease'])->name('cart.decrease');
    Route::post('/cart/remove/{id}', [OrderController::class, 'remove'])->name('cart.remove');

    // Checkout & Pembayaran
    Route::post('/checkout/simpan', [OrderController::class, 'simpan'])->name('checkout.simpan');
    Route::get('/payment/{id}', [OrderController::class, 'showPayment'])->name('order.payment');
    Route::post('/payment/confirm/{id}', [OrderController::class, 'confirmPayment'])->name('payment.confirm');
    Route::get('/invoice/{id}', [OrderController::class, 'printInvoice'])->name('invoice.print');
    Route::get('/history', [OrderController::class, 'history'])->name('order.history');

    // Ulasan
    Route::get('/ulasan', [UlasanController::class, 'index'])->name('ulasan.index'); 
    Route::post('/ulasan', [UlasanController::class, 'store'])->name('ulasan.store');
});

/*
|--------------------------------------------------------------------------
| 4. AREA ADMIN (GUARD: ADMIN)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    //login admin
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    // Tambahkan ->name('admin.login.submit') agar jelas bedanya
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

    // Admin Terproteksi
    Route::middleware('auth:admin')->group(function () {
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders');
        Route::post('/orders/{id}/status', [AdminOrderController::class, 'nextStatus'])->name('admin.orders.status');
        Route::delete('/orders/{id}', [AdminOrderController::class, 'destroy'])->name('admin.orders.destroy');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    });
});