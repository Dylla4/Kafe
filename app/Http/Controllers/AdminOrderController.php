<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request; // Pastikan ini ada

class AdminOrderController extends Controller
{
    public function index()
    {
        // 1. Ambil semua data order untuk tabel (Riwayat Pesanan)
        $orders = Order::orderBy('created_at', 'desc')->get();
        
        // 2. Data untuk Header (Ringkasan hari ini)
        $ordersToday = Order::whereDate('created_at', date('Y-m-d'))->get();

        // 3. LOGIKA GRAFIK HARIAN (ARUS KAS PER JAM)
        $rawHourly = Order::select(
                DB::raw('HOUR(created_at) as jam'),
                DB::raw('SUM(total_harga) as total')
            )
            ->whereDate('created_at', date('Y-m-d'))
            ->groupBy('jam')
            ->pluck('total', 'jam')
            ->toArray();

        $hourlyData = collect();
        for ($i = 0; $i < 24; $i++) {
            $hourlyData->push((object)[
                'jam' => $i,
                'total' => (int)($rawHourly[$i] ?? 0)
            ]);
        }

        // 4. LOGIKA GRAFIK BULANAN (TREN PENJUALAN)
        $rawMonthlyData = Order::select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('CAST(SUM(total_harga) AS UNSIGNED) as total')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        $monthlyData = collect();
        for ($i = 1; $i <= 12; $i++) {
            $monthlyData->push((object)[
                'bulan' => $i,
                'total' => (int)($rawMonthlyData[$i] ?? 0) 
            ]);
        }

        // 5. KIRIM SEMUA VARIABEL KE VIEW
        return view('admin.orders', compact('orders', 'monthlyData', 'ordersToday', 'hourlyData'));
    } // <--- KURUNG TUTUP INI YANG TADI HILANG

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