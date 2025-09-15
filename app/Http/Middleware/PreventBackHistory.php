<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreventBackHistory
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        // Header untuk mencegah cache dan back button
        $response->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate, private')
                 ->header('Pragma', 'no-cache')
                 ->header('Expires', 'Sat, 01 Jan 1990 00:00:00 GMT')
                 ->header('Last-Modified', gmdate('D, d M Y H:i:s') . ' GMT');
        
        // Jika user tidak terautentikasi dan mencoba akses halaman yang butuh auth
       if (!Auth::check() && $request->is('cart*', 'profile*', 'dashboard*')) {
    return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
}
        return $response;
    }
}