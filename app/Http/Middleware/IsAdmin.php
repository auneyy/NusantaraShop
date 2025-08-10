<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
   {
    public function handle($request, Closure $next)
    {
        // Pastikan user login dan rolenya admin
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // Kalau bukan admin, arahkan ke halaman utama user
        return redirect()->route('home');
    }
}
