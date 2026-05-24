<?php

namespace App\Http\Controllers;

use App\Models\Ulasan;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UlasanController extends Controller
{
    public function indexAdmin()
    {
        $ulasan = Ulasan::latest('created_at')->get();
        return view('Admin.ulasan', compact('ulasan')); 
    }

    public function create(Request $request)
    {
        // 1. Ambil order_id dari URL (query string)
        $order_id = $request->query('order_id');
        $order = null;

        // 2. Jika ada order_id, cari datanya di database
        if ($order_id) {
            $order = Order::where('id', $order_id)
                          ->where('user_id', Auth::id())
                          ->first();
        }

        // 3. Ambil semua ulasan untuk ditampilkan di bawah form
        $ulasan = Ulasan::latest()->get();

        // 4. Kirim variabel 'order' ke view agar @isset($order) bernilai true
        return view('ulasan', compact('ulasan', 'order'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        // Cek apakah order_id ini sudah pernah membuat ulasan di tabel ulasans
        $sudahReview = Ulasan::where('order_id', $request->order_id)->exists();

        if ($sudahReview) {
            // Menggunakan back() agar kembali ke URL dengan order_id yang sama + membawa pesan error
            return redirect()->back()
                             ->with('error', 'Maaf, pesanan ini sudah pernah diberikan ulasan sebelumnya.');
        }

        // Ambil data order untuk mendapatkan nama pemesan yang asli
        $order = Order::find($request->order_id);

        $ulasan = new Ulasan();
        $ulasan->order_id = $request->order_id;
        
        // Memastikan user_id terisi agar tidak SQLSTATE[HY000]
        $ulasan->user_id = Auth::id(); 
        
        // Menggunakan nama pemesan dari tabel orders jika ada, fallback ke nama akun / Tamu
        $ulasan->nama = $order ? $order->nama_pemesan : (Auth::check() ? Auth::user()->name : 'Tamu');
        
        $ulasan->rating = $request->rating;
        $ulasan->komentar = $request->komentar;

        // Sesuaikan dengan nama kolom di database: 'foto_ulasan'
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('ulasan', 'public');
            $ulasan->foto_ulasan = $path; 
        }

        $ulasan->save();

        return redirect()->route('ulasan.create')->with('success', 'Ulasan Anda berhasil terkirim!');
    }
}