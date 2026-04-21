<?php

namespace App\Http\Controllers;

use App\Models\Ulasan;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UlasanController extends Controller
{
    /**
     * Menampilkan halaman ulasan berdasarkan pesanan tertentu.
     */
    public function create(Request $request)
    {
        // 1. Ambil order_id dari URL
        $orderId = $request->query('order_id');

        // 2. Jika diakses langsung tanpa order_id, redirect ke riwayat pesanan
        if (!$orderId) {
            return redirect()->route('order.history')->with('error', 'Pilih pesanan yang ingin diulas terlebih dahulu.');
        }

        // 3. Pastikan data order ditemukan
        $order = Order::findOrFail($orderId);

        // 4. Ambil semua ulasan untuk ditampilkan di daftar bawah
        $ulasans = Ulasan::latest()->get();

        // 5. Kirim variabel ke view
        return view('ulasan', compact('order', 'ulasans'));
    }

    /**
     * Menyimpan ulasan baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input (Tambahkan order_id ke validasi)
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'komentar' => 'required|string|min:5',
            'rating'   => 'required|integer|min:1|max:5',
            'foto'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // 2. Persiapkan Data
        $data = [
            'user_id'  => Auth::id(),
            'order_id' => $request->order_id, // Masukkan order_id agar ulasan terikat ke pesanan
            'nama'     => Auth::user()->name,
            'komentar' => $request->komentar,
            'rating'   => $request->rating,
        ];

        // 3. Logika Upload Foto
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('ulasan', 'public');
            $data['foto'] = $path;
        }

        // 4. Simpan ke Database
        Ulasan::create($data);

        // Redirect ke history dengan pesan sukses
        return redirect()->route('order.history')->with('success', 'Terima kasih! Ulasan berhasil disimpan.');
    }
}