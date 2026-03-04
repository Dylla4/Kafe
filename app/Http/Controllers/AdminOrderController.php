<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    /**
     * Menampilkan daftar pesanan dari database MySQL.
     */
    public function index()
    {
        // Mengambil semua data order, diurutkan dari yang terbaru
        $orders = Order::orderBy('created_at', 'desc')->get();
        
        return view('admin.orders', compact('orders'));
    }

    /**
     * Mengubah status pesanan secara manual dari Admin Panel.
     */
    public function nextStatus($id)
    {
        // Mengambil status baru dari request dropdown
        $status = request('status');

        // Menambahkan 'menunggu_pembayaran' ke daftar validasi agar sesuai fitur QRIS
        $valid = ['menunggu_pembayaran', 'diproses', 'siap', 'selesai'];

        if (!in_array($status, $valid, true)) {
            return redirect()->back()->with('error', 'Status tidak valid');
        }

        // Mencari data di tabel MySQL menggunakan Eloquent
        $order = Order::findOrFail($id);

        // Update status di database MySQL
        $order->update([
            'status' => $status,
        ]);

        return redirect()->back()->with('success', "Status pesanan #{$id} berhasil diubah ke {$status}");
    }

    /**
     * Menghapus pesanan (Opsional)
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->back()->with('success', 'Pesanan berhasil dihapus');
    }
}