<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminOrderController extends Controller
{
    /**
     * HALAMAN 1: DAFTAR PESANAN
     */
    public function index()
    {
        // 1. Ambil semua data order untuk list transaksi
        $orders = Order::orderBy('created_at', 'desc')->get();
        
        // 2. Ambil data asli dari Database per bulan (Pastikan casting ke integer/double)
        $rawMonthlyData = Order::select(
            DB::raw('MONTH(created_at) as bulan'),
            DB::raw('CAST(SUM(total_harga) AS UNSIGNED) as total') // Memastikan hasil SUM adalah angka
        )
        ->whereYear('created_at', date('Y'))
        ->groupBy('bulan')
        ->pluck('total', 'bulan')
        ->toArray();

        // 3. Padding data agar grafik selalu menampilkan 12 bulan (Jan-Des)
        $monthlyData = collect();
        for ($i = 1; $i <= 12; $i++) {
            $monthlyData->push((object)[
                'bulan' => $i,
                'total' => (int)($rawMonthlyData[$i] ?? 0) // Pastikan diconvert ke Integer
            ]);
        }

        return view('admin.orders', compact('orders', 'monthlyData'));
    }

    /**
     * HALAMAN 2: STATISTIK HARIAN
     */
    public function statistics()
    {
        $ordersToday = Order::whereDate('created_at', today())->get();

        $hourlyData = Order::whereDate('created_at', today())
            ->select(
                DB::raw('HOUR(created_at) as jam'),
                DB::raw('CAST(SUM(total_harga) AS UNSIGNED) as total')
            )
            ->groupBy('jam')
            ->orderBy('jam', 'asc')
            ->get();

        return view('admin.statistics', compact('ordersToday', 'hourlyData'));
    }

    public function nextStatus($id)
    {
        $status = request('status');
        $valid = ['menunggu_pembayaran', 'diproses', 'siap', 'selesai'];

        if (!in_array($status, $valid, true)) {
            return redirect()->back()->with('error', 'Status tidak valid');
        }

        $order = Order::findOrFail($id);
        $order->update(['status' => $status]);

        return redirect()->back()->with('success', "Status pesanan #{$id} berhasil diperbarui.");
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->back()->with('success', 'Pesanan berhasil dihapus');
    }
}