<?php

use Illuminate\Support\Facades\Route;
use App\Models\Menu;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminOrderController;

/*
|--------------------------------------------------------------------------
| Helper Firebase
|--------------------------------------------------------------------------
| Dibungkus function_exists agar tidak terjadi redeclare error
*/

if (!function_exists('firebaseDatabase')) {
    function firebaseDatabase()
    {
        $credPath = base_path(env('FIREBASE_CREDENTIALS'));
        $dbUrl    = env('FIREBASE_DATABASE_URL');

        if (!file_exists($credPath)) {
            abort(500, "File credential tidak ditemukan: $credPath");
        }

        if (!$dbUrl) {
            abort(500, "FIREBASE_DATABASE_URL belum diisi di .env");
        }

        $factory = (new \Kreait\Firebase\Factory)
            ->withServiceAccount($credPath)
            ->withDatabaseUri($dbUrl);

        return $factory->createDatabase();
    }
}

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
| Keranjang
|--------------------------------------------------------------------------
*/

Route::get('/cart', [OrderController::class, 'showCart'])->name('cart.show');
Route::post('/cart/add/{id}', [OrderController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/decrease/{id}', [OrderController::class, 'decrease'])->name('cart.decrease');
Route::delete('/cart/remove/{id}', [OrderController::class, 'remove'])->name('cart.remove');


/*
|--------------------------------------------------------------------------
| Checkout
|--------------------------------------------------------------------------
*/

Route::post('/checkout', [OrderController::class, 'simpan'])->name('checkout.simpan');


/*
|--------------------------------------------------------------------------
| Admin Orders (Halaman + Update Status Manual via Dropdown)
|--------------------------------------------------------------------------
*/

Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders');
Route::post('/orders/{id}/status', [AdminOrderController::class, 'nextStatus'])->name('orders.status');


/*
|--------------------------------------------------------------------------
| TEST Firebase (Optional)
|--------------------------------------------------------------------------
*/

Route::get('/firebase-test', function () {

    $database = firebaseDatabase();

    $database->getReference('test')->set([
        'msg' => 'Halo Realtime Database!',
        'created_at' => now()->toDateTimeString(),
    ]);

    return "✅ Berhasil kirim ke Realtime Database";
});