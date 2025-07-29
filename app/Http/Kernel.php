<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    // Ini middleware global (untuk semua request)
    protected $middleware = [
        // Biarkan kosong atau sesuai dengan yang sudah ada di project Anda
    ];

    // Ini middleware grup, misalnya untuk web atau API
    protected $middlewareGroups = [
        'web' => [
            // Biarkan sesuai dengan yang sudah ada di project Anda
        ],

        'api' => [
            // Biarkan sesuai dengan yang sudah ada di project Anda
        ],
    ];

    // ✅ Yang penting hanya bagian ini - tambahkan saja prevent-back-history
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'prevent-back-history' => \App\Http\Middleware\PreventBackHistory::class,
        // Middleware lain yang sudah ada di project Anda...
    ];
}