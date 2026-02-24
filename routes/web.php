<?php

use App\Models\Menu;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

// Halaman Depan
Route::get('/', function () {
    $semua_menu = Menu::all();
    return view('welcome', ['menus' => $semua_menu]);
});

// Rute untuk Tambah ke Keranjang
/*Route::post('/cart/add/{id}', [OrderController::class, 'addToCart'])->name('cart.add');*/

// Rute untuk Halaman Keranjang
Route::get('/cart', [OrderController::class, 'showCart'])->name('cart.show');

// Rute untuk Simpan Pesanan (Checkout)
Route::post('/checkout', [OrderController::class, 'simpan'])->name('checkout.simpan');

// Menambah jumlah (digunakan di Home & Keranjang)
Route::post('/cart/add/{id}', [App\Http\Controllers\OrderController::class, 'add'])->name('cart.add');

// Mengurangi jumlah item
Route::post('/cart/decrease/{id}', [App\Http\Controllers\OrderController::class, 'decrease'])->name('cart.decrease');

// Menghapus item sepenuhnya dari keranjang
Route::delete('/cart/remove/{id}', [App\Http\Controllers\OrderController::class, 'remove'])->name('cart.remove');