<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB; // WAJIB TAMBAHKAN INI agar DB::raw bisa jalan

class AdminOrderController extends Controller
{
public function index()
{
    // 1. Ambil semua data pesanan untuk tabel utama
    $orders = Order::latest()->get();

    // 2. Ambil data pesanan KHUSUS hari ini (sebagai koleksi/collection)
    // Ini agar bisa di-count() dan di-sum() di Blade kamu
    $ordersToday = Order::whereDate('created_at', \Carbon\Carbon::today())->get();

    // 3. Data Grafik Per Jam
    $hourlyData = Order::select(
        DB::raw('HOUR(created_at) as jam'),
        DB::raw('COUNT(*) as total')
    )
    ->whereDate('created_at', \Carbon\Carbon::today())
    ->groupBy('jam')
    ->orderBy('jam')
    ->get();

    // 4. Data Grafik Per Bulan
    $monthlyData = Order::select(
        DB::raw('MONTH(created_at) as bulan'),
        DB::raw('COUNT(*) as total')
    )
    ->whereYear('created_at', date('Y'))
    ->groupBy('bulan')
    ->orderBy('bulan')
    ->get();

    // Kirim SEMUA variabel ke view
    return view('admin.orders', compact('orders', 'ordersToday', 'hourlyData', 'monthlyData'));
}

    // Ganti fungsi nextStatus menjadi ini:
public function updateStatus(Request $request, $id)
{
    $order = Order::findOrFail($id);
    
    // Validasi agar status yang masuk sesuai dengan pilihan yang ada
    $request->validate([
        'status' => 'required|in:diproses,siap,sukses'
    ]);

    $order->status = $request->status;
    $order->save();

    return back()->with('success', 'Status pesanan #' . $id . ' berhasil diubah ke ' . $request->status);
}

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->back()->with('success', 'Pesanan berhasil dihapus');
    }
} // HANYA SATU KURUNG TUTUP DI AKHIR FILE