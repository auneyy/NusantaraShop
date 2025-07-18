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
            return redirect('/home');
        }
        
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Login hanya jika is_active = true
        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password'], 'is_active' => 1])) {
            $request->session()->regenerate();
            
            // Redirect ke home setelah login berhasil
            return redirect('/home')->with('success', 'Selamat datang! Anda berhasil masuk.');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah, atau akun tidak aktif.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Redirect ke halaman utama (/) setelah logout, bukan ke /login
        return redirect('/')->with('success', 'Anda berhasil keluar.');
    }
}