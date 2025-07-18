<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        // Jika sudah login, redirect ke home
        // if (Auth::check()) {
        //     return redirect('/home');
        // }
        
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validasi lengkap
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|max:255|unique:users',
            'password'   => 'required|string|min:6|confirmed',
            'phone'      => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'gender'     => 'nullable|in:male,female',
        ]);

        // Simpan user
        $user = User::create([
            'name'       => $validated['name'],
            'email'      => $validated['email'],
            'password'   => Hash::make($validated['password']),
            'phone'      => $validated['phone'] ?? null,
            'birth_date' => $validated['birth_date'] ?? null,
            'gender'     => $validated['gender'] ?? null,
            'role'       => 'customer',
            'is_active'  => true,
        ]);

        // Auto login setelah register
        Auth::login($user);

        // Redirect ke home setelah register berhasil
        return redirect('/home')->with('success', 'Selamat datang! Akun Anda berhasil dibuat.');
    }
}