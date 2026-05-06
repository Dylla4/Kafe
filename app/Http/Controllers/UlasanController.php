<?php

namespace App\Http\Controllers;

use App\Models\Ulasan; // Pastikan model Ulasan di-import
use Illuminate\Http\Request;

class UlasanController extends Controller
{

public function indexAdmin()
{
    $ulasan = Ulasan::latest('created_at')->get();
    return view('Admin.ulasan', compact('ulasan')); 
}

// Baris 20 (Ganti 'reviews' menjadi 'ulasan')
public function create()
{
    $ulasan = Ulasan::latest()->get();
    return view('ulasan', compact('ulasan'));
}
}