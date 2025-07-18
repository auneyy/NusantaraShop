<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // Tambahkan import ini
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthController;

Route::get('test', function () {
    return view('test');
})->name('test');

// Route utama - redirect berdasarkan status auth
Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/home');
    }
    return view('home'); // Landing page untuk user yang belum login
});

// Home route (hanya untuk user yang sudah login)
Route::get('/home', [HomeController::class, 'index'])->middleware('auth');

// Auth routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route untuk halaman lain (bisa diakses semua user)
Route::get('/products', function () {
    return view('products');
});

Route::get('/promo', function () {
    return view('promo');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/help', function () {
    return view('help');
});

Route::get('/cart', function () {
    return view('cart');
})->middleware('auth'); // Cart hanya untuk user yang sudah login