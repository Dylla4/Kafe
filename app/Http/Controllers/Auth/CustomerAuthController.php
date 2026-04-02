<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CustomerAuthController extends Controller
{
    public function showLogin() {
        return view('auth.login'); // Pastikan Anda punya file resources/views/auth/login.blade.php
    }

    public function showRegister() {
        return view('auth.register'); // Pastikan Anda punya file resources/views/auth/register.blade.php
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Cek Role setelah login
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.stats'); // Ke Dashboard Admin
            }

            return redirect()->route('menu'); // Ke Halaman Kopi Pelanggan
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Berhasil daftar, silakan login.');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}