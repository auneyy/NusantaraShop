<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        // Jika sudah login, redirect ke home
        if (Auth::check()) {
    return redirect()->intended('/home');
}
        
        return view('auth.login');
    }

   public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt([
        'email' => $credentials['email'],
        'password' => $credentials['password'],
        'is_active' => 1
    ])) {
        $request->session()->regenerate();

        // ✅ Redirect ke halaman yang user coba akses sebelumnya
        return redirect()->intended('/home')->with('success', 'Selamat datang!');
    }

    return back()->withErrors([
        'email' => 'Email atau password salah, atau akun tidak aktif.',
    ])->withInput();
}

    public function logout(Request $request)
    {
        // Hapus semua session data
        Auth::logout();
        
        // Invalidate session sepenuhnya
        $request->session()->invalidate();
        
        // Regenerate CSRF token untuk keamanan
        $request->session()->regenerateToken();
        
        // Flush semua session data (tambahan untuk memastikan)
        $request->session()->flush();
        
        // Hapus session cookie secara manual
        if ($request->hasCookie(config('session.cookie'))) {
            $cookie = cookie()->forget(config('session.cookie'));
            return redirect('/')->with('success', 'Anda berhasil keluar.')->withCookie($cookie);
        }
        
        // Response dengan header no-cache untuk mencegah back button
        $response = redirect('/')->with('success', 'Anda berhasil keluar.');
        
        return $response->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
                      ->header('Pragma', 'no-cache')
                      ->header('Expires', 'Sat, 01 Jan 1990 00:00:00 GMT');
    }
}