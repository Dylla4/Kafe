<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsAdmin
{
public function handle(Request $request, Closure $next)
{
    // Cek apakah yang login adalah admin menggunakan guard 'admin'
    if (!Auth::guard('admin')->check()) {
        // JANGAN arahkan ke route('login'), tapi ke admin.login
        return redirect()->route('admin.login')->with('error', 'Silakan login sebagai admin.');
    }

    return $next($request);
}
}