<?php

namespace App\Http\Controllers;

use App\Models\Ulasan;
use Illuminate\Http\Request;

class UlasanController extends Controller
{
    public function index()
    {
        // Mengambil data ulasan terbaru dari database
        $ulasans = Ulasan::latest()->get();
        return view('ulasan', compact('ulasans'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nama'     => 'required|string|max:255',
            'komentar' => 'required|string',
            'rating'   => 'required|integer|min:1|max:5',
            'foto'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048' // Batas 2MB
        ]);

        // 2. Ambil data teks saja terlebih dahulu
        $data = $request->only(['nama', 'komentar', 'rating']);

        // 3. Logika Upload Foto
        if ($request->hasFile('foto')) {
            // Simpan file ke storage/app/public/ulasan
            $path = $request->file('foto')->store('ulasan', 'public');
            
            // Masukkan path hasil simpan ke dalam array data untuk database
            $data['foto'] = $path;
        }

        // 4. Simpan ke Database
        // Pastikan kolom 'foto' ada di $fillable pada Model Ulasan.php
        Ulasan::create($data);

        return redirect()->back()->with('success', 'Terima kasih! Ulasan Anda berhasil terkirim.');
    }
}