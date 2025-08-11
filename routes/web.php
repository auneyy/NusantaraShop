<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;

// ==========================
// 🏠 PUBLIC ROUTES
// ==========================

// Route utama → langsung pakai controller
Route::get('/', [HomeController::class, 'index'])
    ->name('home.landing')
    ->middleware(\App\Http\Middleware\PreventBackHistory::class);

// Halaman umum (dapat diakses semua orang)
Route::middleware(\App\Http\Middleware\PreventBackHistory::class)->group(function () {
    Route::view('/products', 'products')->name('products');
    Route::view('/promo', 'promo')->name('promo');
    Route::view('/contact', 'contact')->name('contact');
    Route::view('/help', 'help')->name('help');
});

// ==========================
// 🔐 AUTHENTICATION ROUTES
// ==========================

// Guest only routes (redirect jika sudah login)
Route::middleware(['guest', \App\Http\Middleware\PreventBackHistory::class])->group(function () {
    // User Registration
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    // User Login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    // Admin Login
    Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
});

// ==========================
// 🛡️ USER AUTHENTICATED ROUTES
// ==========================

Route::middleware(['auth', \App\Http\Middleware\PreventBackHistory::class])->group(function () {
    // User Dashboard/Home
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    // Cart Routes - Hanya user yang login bisa akses cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/cart/count', [CartController::class, 'getCart'])->name('cart.get');
    
    // User Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// ==========================
// 🔐 ADMIN ROUTES
// ==========================

Route::middleware(['auth', 'isAdmin', \App\Http\Middleware\PreventBackHistory::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Admin Dashboard
        Route::get('/dashboard', fn () => view('admin.dashboard'))->name('dashboard');
        
        // Tambahkan admin routes lainnya di sini
        // Route::resource('products', ProductController::class);
        // Route::resource('users', UserController::class);
        // Route::resource('orders', OrderController::class);
    });

// Admin Logout - bisa diakses tanpa middleware auth karena sudah ada pengecekan di controller
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])
    ->name('admin.logout')
    ->middleware(\App\Http\Middleware\PreventBackHistory::class);

// ==========================
// 🚨 FALLBACK ROUTE (Opsional)
// ==========================

// Route::fallback(function () {
//     return view('errors.404');
// });