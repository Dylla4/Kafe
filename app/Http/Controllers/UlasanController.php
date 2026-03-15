<?php

namespace App\Http\Controllers;

use App\Models\Ulasan;
use Illuminate\Http\Request;

class UlasanController extends Controller
{
    public function index()
    {
        $ulasans = Ulasan::latest()->get();
        return view('ulasan', compact('ulasans'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'komentar' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        // Simpan ke database
        Ulasan::create($validated);

        // Kembali ke halaman dengan pesan sukses
        return redirect()->route('ulasan.index')->with('success', 'Ulasan berhasil dikirim!');
    }
}