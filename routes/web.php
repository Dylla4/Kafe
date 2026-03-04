<?php

use Illuminate\Support\Facades\Route;
use App\Models\Menu;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminOrderController;

/*
|--------------------------------------------------------------------------
| Halaman Depan
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $menus = Menu::all();
    return view('welcome', compact('menus'));
})->name('home');

/*
|--------------------------------------------------------------------------
| Keranjang (Cart)
|--------------------------------------------------------------------------
*/
Route::get('/cart', [OrderController::class, 'showCart'])->name('cart.show');
Route::post('/cart/add/{id}', [OrderController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/decrease/{id}', [OrderController::class, 'decrease'])->name('cart.decrease');
Route::delete('/cart/remove/{id}', [OrderController::class, 'remove'])->name('cart.remove');

/*
|--------------------------------------------------------------------------
| Pesanan & Pembayaran (Customer)
|--------------------------------------------------------------------------
*/
Route::post('/checkout', [OrderController::class, 'simpan'])->name('checkout.simpan');
Route::get('/payment/{id}', [OrderController::class, 'showPayment'])->name('order.payment');
Route::post('/payment/confirm/{id}', [OrderController::class, 'confirmPayment'])->name('order.pay');

/*
|--------------------------------------------------------------------------
| Riwayat & Invoice
|--------------------------------------------------------------------------
*/
Route::get('/history', [OrderController::class, 'history'])->name('order.history');
Route::get('/invoice/{id}', [OrderController::class, 'printInvoice'])->name('invoice.print');

/*
|--------------------------------------------------------------------------
| Admin Panel (Kelola Pesanan MySQL)
|--------------------------------------------------------------------------
*/
Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders');
Route::post('/orders/{id}/status', [AdminOrderController::class, 'nextStatus'])->name('orders.status');

// TAMBAHKAN INI: Agar tombol hapus di Admin Panel berfungsi
Route::delete('/admin/orders/{id}', [AdminOrderController::class, 'destroy'])->name('admin.orders.destroy');