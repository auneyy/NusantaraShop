<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthController;

// 🔍 Route untuk testing (sementara)
Route::get('/test', function () {
    return view('test');
})->name('test');

// 🏠 Route utama (landing page untuk tamu / redirect ke home jika sudah login)
Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/home');
    }
    return view('home'); // Landing page
})->middleware(\App\Http\Middleware\PreventBackHistory::class);

// 🛡️ Route khusus user yang sudah login
Route::middleware(['auth', \App\Http\Middleware\PreventBackHistory::class])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    Route::get('/cart', function () {
        return view('cart');
    })->name('cart');
    
    // Tambahkan route lain yang hanya bisa diakses saat login di sini
});

// 🔐 Auth routes (Login & Register)
Route::middleware(['guest', \App\Http\Middleware\PreventBackHistory::class])->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// 🚪 Logout route (dengan middleware prevent-back-history)
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware(\App\Http\Middleware\PreventBackHistory::class);

// 🌐 Halaman umum (bisa diakses siapa saja)
Route::view('/products', 'products')->name('products')->middleware(\App\Http\Middleware\PreventBackHistory::class);
Route::view('/promo', 'promo')->name('promo')->middleware(\App\Http\Middleware\PreventBackHistory::class);
Route::view('/contact', 'contact')->name('contact')->middleware(\App\Http\Middleware\PreventBackHistory::class);
Route::view('/help', 'help')->name('help')->middleware(\App\Http\Middleware\PreventBackHistory::class);