<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminOrderController extends Controller
{
    /**
     * Dashboard Overview (Grafik & Statistik)
     */
public function dashboard(): View
{
    // Menggunakan timezone Asia/Jakarta agar akurat dengan waktu lokal Indonesia
    $today = \Carbon\Carbon::today('Asia/Jakarta');
    
    // Pastikan kolom created_at dibandingkan dengan string tanggal yang tepat
    $ordersToday = \App\Models\Order::whereDate('created_at', $today->toDateString())->get();
    
    // AllOrders tetap mengambil semua data tanpa filter tanggal
    $allOrders = \App\Models\Order::latest()->get();

    // Di AdminOrderController.php
    $hourlyDataRaw = \App\Models\Order::query()
        ->selectRaw('HOUR(created_at) as jam, COUNT(*) as total')
        ->whereDate('created_at', $today)
        ->groupBy('jam')
        ->pluck('total', 'jam')
        ->toArray();

    $chartData = [];
    for ($i = 0; $i < 24; $i++) {
        // Pastikan nilai dikonversi ke integer agar dibaca angka oleh JS
        $chartData[] = (int)($hourlyDataRaw[$i] ?? 0); 
    }

    return view('admin.dashboard', compact('ordersToday', 'allOrders', 'chartData'));
}
    /**
     * List Data Pesanan (Tabel)
     */
    public function index(): View
    {
        $orders = Order::query()->latest()->paginate(10);
        return view('admin.order', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        // Validasi status yang diterima
        $request->validate([
            'status' => 'required|in:diproses,siap,sukses'
        ]);

        // Cari pesanan dan perbarui statusnya
        $order = \App\Models\Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
    }

    /**
     * Hapus Pesanan
     */
    public function destroy(int $id): RedirectResponse
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return back()->with('success', 'Pesanan berhasil dihapus.');
    }

public function reviews()
{
    // Mengambil data ulasan terbaru dari database
    $reviews = \App\Models\Ulasan::latest()->get(); 
    
    // Mengirim variabel $reviews ke file blade
    return view('admin.reviews', compact('reviews')); 
}

public function report()
{
    // Mengambil total penjualan per bulan untuk tahun ini
    $salesData = Order::selectRaw('
            MONTH(created_at) as month, 
            SUM(total_bayar) as total, 
            COUNT(id) as total_orders
        ')
        ->whereYear('created_at', 2026)
        ->groupBy('month')
        ->get();

    return view('admin.report', compact('salesData'));
}

}