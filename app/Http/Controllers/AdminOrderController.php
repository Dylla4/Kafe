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
        // Menggunakan Order::query() membantu indexing Intelephense
        $totalOrders = Order::query()->count('*'); 
        $today = Carbon::today()->toDateString();
        
        // Menghitung jumlah pesanan hari ini dengan parameter eksplisit
        //$ordersTodayCount = Order::query()

        $ordersTodayCount = Order::where('created_at', '>=', $today . ' 00:00:00')->count();
        
        $recentOrders = Order::latest()->limit(5)->get();

        // Statistik per jam
        $hourlyData = Order::query()
            ->selectRaw('HOUR(created_at) as jam, COUNT(*) as total')
            ->whereDate('created_at', '=', $today)
            ->groupBy('jam')
            ->orderBy('jam', 'asc')
            ->get();

        // Statistik per bulan$recentOrders
        $currentYear = (int) Carbon::now()->year;
        $monthlyData = Order::query()
            ->selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->whereYear('created_at', '=', $currentYear)
            ->groupBy('bulan')
            ->orderBy('bulan', 'asc')
            ->get();

        return view('admin.dashboard', compact(
            'totalOrders', 
            'ordersTodayCount', 
            'recentOrders', 
            'hourlyData', 
            'monthlyData'
        ));
    }

    /**
     * List Data Pesanan (Tabel)
     */
    public function index(): View
    {
        $orders = Order::query()->latest()->paginate(10);
        return view('admin.order', compact('orders'));
    }

    /**
     * Update Status Pesanan
     */
    public function updateStatus(Request $request, int $id): RedirectResponse
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'status' => 'required|in:diproses,siap,sukses'
        ]);

        $order->status = $request->status;
        $order->save();

        return back()->with('success', "Status pesanan #{$id} berhasil diperbarui.");
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
    // Jika Anda punya model Review, bisa ambil data di sini
    // $reviews = Review::latest()->get();
    // return view('admin.reviews', compact('reviews'));

    return view('admin.reviews'); // Sementara tampilkan view saja
}

public function report()
{
    // Mengambil total penjualan per bulan untuk tahun ini
    $salesData = Order::selectRaw('MONTH(created_at) as month, SUM(total_bayar) as total')
        ->whereYear('created_at', date('Y'))
        ->groupBy('month')
        ->orderBy('month')
        ->get();

    return view('admin.report', compact('salesData'));
}

}