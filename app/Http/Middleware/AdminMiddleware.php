<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Jangan lupa import Auth
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login DAN rolenya adalah 'admin'
        if (Auth::check() && Auth::user()->role === 'admin') {
            // Jika ya, izinkan akses ke halaman berikutnya
            return $next($request);
        }

        // Jika tidak, tolak akses dan tampilkan halaman error 403 (Forbidden)
        abort(403, 'Unauthorized Access');
    }
}
