<?php

namespace App\Http\Controllers;

use App\Models\Menu; // Pastikan Model Menu sudah di-import
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Mengambil 3 menu secara acak untuk ditampilkan di Home
        $featuredMenus = Menu::inRandomOrder()->take(3)->get();

        return view('beranda', compact('featuredMenus'));
    }
}