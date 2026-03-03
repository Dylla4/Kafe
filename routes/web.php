<?php

use Illuminate\Support\Facades\Route;
use App\Models\Menu;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminOrderController;
use Kreait\Firebase\Factory;

/*
|--------------------------------------------------------------------------
| Helper Firebase
|--------------------------------------------------------------------------
| Pakai config() (bukan env()) agar aman saat config:cache
*/
if (!function_exists('firebaseDatabase')) {
    function firebaseDatabase()
    {
        $credPath = config('firebase.projects.app.credentials');
        $dbUrl    = config('firebase.projects.app.database.url');

        // Kalau credentials sudah absolute dari config/firebase.php (base_path), ini aman.
        // Kalau masih relatif, jadikan absolute:
        if ($credPath && !str_starts_with($credPath, DIRECTORY_SEPARATOR) && !preg_match('/^[A-Za-z]:\\\\/', $credPath)) {
            $credPath = base_path($credPath);
        }

        if (!$credPath || !file_exists($credPath)) {
            abort(500, "File credential tidak ditemukan: " . ($credPath ?? '(null)'));
        }

        if (!$dbUrl) {
            abort(500, "FIREBASE_DATABASE_URL belum diisi di .env");
        }

        $factory = (new Factory)
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
| Admin Orders
|--------------------------------------------------------------------------
*/
Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders');
Route::post('/orders/{id}/status', [AdminOrderController::class, 'nextStatus'])->name('orders.status');

/*
|--------------------------------------------------------------------------
| TEST Firebase
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

/*
|--------------------------------------------------------------------------
| Invoice
|--------------------------------------------------------------------------
*/
Route::get('/invoice/{id}', [OrderController::class, 'printInvoice'])->name('invoice.print');