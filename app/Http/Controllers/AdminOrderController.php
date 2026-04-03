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

    public function nextStatus($id)
    {
        $order = Order::findOrFail($id);
        
        // Logika sederhana untuk mengubah status
        if ($order->status == 'menunggu_pembayaran') {
            $order->status = 'diproses';
        } elseif ($order->status == 'diproses') {
            $order->status = 'selesai';
        }
        
        $order->save();
        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->back()->with('success', 'Pesanan berhasil dihapus');
    }
} // HANYA SATU KURUNG TUTUP DI AKHIR FILE