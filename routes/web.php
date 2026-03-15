<?php

use Illuminate\Support\Facades\Route;
use App\Models\Menu;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\UlasanController;

/*
|--------------------------------------------------------------------------
| Halaman Depan & Katalog (Multi-Page)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('beranda');
})->name('home');

Route::get('/ulasan', [UlasanController::class, 'index'])->name('ulasan.index');
Route::post('/ulasan', [UlasanController::class, 'store'])->name('ulasan.store');

Route::get('/menu', function () {
    $menus = Menu::all(); 
    return view('menu', compact('menus'));
})->name('menu');

Route::get('/tentang', function () {
    return view('tentang');
})->name('tentang');

Route::get('/locations', function () {
    return view('kontak');
})->name('kontak');

/*
|--------------------------------------------------------------------------
| Keranjang & Pesanan (Customer)
|--------------------------------------------------------------------------
*/
Route::controller(OrderController::class)->group(function () {
    Route::get('/cart', 'showCart')->name('cart.show');
    Route::post('/cart/add/{id}', 'addToCart')->name('cart.add');
    Route::post('/cart/decrease/{id}', 'decrease')->name('cart.decrease');
    Route::delete('/cart/remove/{id}', 'remove')->name('cart.remove');
    
    Route::post('/checkout', 'simpan')->name('checkout.simpan');
    Route::get('/payment/{id}', 'showPayment')->name('order.payment');
    Route::post('/payment/confirm/{id}', 'confirmPayment')->name('order.pay');
    Route::get('/history', 'history')->name('order.history');
    Route::get('/invoice/{id}', 'printInvoice')->name('invoice.print');
});

/*
|--------------------------------------------------------------------------
| Admin Panel & Authentication
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('logout');

// Lindungi semua rute admin dengan middleware 'auth'
Route::middleware('auth')->prefix('admin')->group(function () {
    
    // 1. Halaman Daftar Pesanan (Semua Transaksi)
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders');
    
    // 2. Halaman Statistik Harian (Baru Ditambahkan)
    Route::get('/statistics', [AdminOrderController::class, 'statistics'])->name('admin.stats');
    
    // 3. Aksi Admin (Update Status & Hapus)
    Route::post('/orders/{id}/status', [AdminOrderController::class, 'nextStatus'])->name('orders.status');
    Route::delete('/orders/{id}', [AdminOrderController::class, 'destroy'])->name('admin.orders.destroy');
});