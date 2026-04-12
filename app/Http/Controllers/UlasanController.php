<?php

namespace App\Http\Controllers;

use App\Models\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UlasanController extends Controller
{
    /**
     * Menampilkan daftar ulasan milik user yang sedang login.
     */
    public function index()
    {
        // Filter berdasarkan user_id agar ulasan tidak tercampur dengan akun lain
        $ulasans = Ulasan::where('user_id', Auth::id())
                         ->latest()
                         ->get();

        return view('ulasan', compact('ulasans'));
    }

    /**
     * Menyimpan ulasan baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'komentar' => 'required|string|min:5',
            'rating'   => 'required|integer|min:1|max:5',
            'foto'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // 2. Persiapkan Data (Nama & User ID diambil langsung dari Auth untuk keamanan)
        $data = [
            'user_id'  => Auth::id(),
            'nama'     => Auth::user()->name,
            'komentar' => $request->komentar,
            'rating'   => $request->rating,
        ];

        // 3. Logika Upload Foto
        if ($request->hasFile('foto')) {
            // Simpan file ke folder 'public/ulasan'
            $path = $request->file('foto')->store('ulasan', 'public');
            $data['foto'] = $path;
        }

        // 4. Simpan ke Database
        Ulasan::create($data);

        return redirect()->back()->with('success', 'Terima kasih! Ulasan Anda berhasil terkirim.');
    }
}