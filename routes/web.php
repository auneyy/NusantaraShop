<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthController;

// 🏠 Route utama → langsung pakai controller
Route::get('/', [HomeController::class, 'index'])
    ->name('home.landing')
    ->middleware(\App\Http\Middleware\PreventBackHistory::class);

// 🛡️ Route khusus user login (kalau mau tetap pisah halaman dashboard)
Route::middleware(['auth', \App\Http\Middleware\PreventBackHistory::class])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    Route::get('/cart', function () {
        return view('cart');
    })->name('cart');
});

// 🔐 Auth routes
Route::middleware(['guest', \App\Http\Middleware\PreventBackHistory::class])->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// 🚪 Logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware(\App\Http\Middleware\PreventBackHistory::class);

// 🌐 Halaman umum
Route::view('/products', 'products')->name('products')->middleware(\App\Http\Middleware\PreventBackHistory::class);
Route::view('/promo', 'promo')->name('promo')->middleware(\App\Http\Middleware\PreventBackHistory::class);
Route::view('/contact', 'contact')->name('contact')->middleware(\App\Http\Middleware\PreventBackHistory::class);
Route::view('/help', 'help')->name('help')->middleware(\App\Http\Middleware\PreventBackHistory::class);
