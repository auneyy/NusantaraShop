<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthController;
// Import dan beri alias yang jelas untuk controller publik dan admin
use App\Http\Controllers\ProductController as PublicProductController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;

// Middleware untuk mencegah back history di seluruh aplikasi
Route::middleware(\App\Http\Middleware\PreventBackHistory::class)->group(function () {

    // ==========================
    // 🏠 PUBLIC ROUTES
    // ==========================

    // Route utama (landing page)
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Halaman umum (dapat diakses semua orang)
    Route::view('/promo', 'promo')->name('promo');
    Route::view('/contact', 'contact')->name('contact');
    Route::view('/help', 'help')->name('help');
    
    // Products Resource (menggunakan controller publik yang benar)
    // Gunakan .except('show') untuk mengecualikan rute show
    Route::resource('products', PublicProductController::class)->except('show');

    // Rute kustom untuk show agar bisa menggunakan slug
    Route::get('/products/{product:slug}', [PublicProductController::class, 'show'])->name('products_show');
    
    // Route untuk pencarian dan filter produk
    Route::get('/search', [PublicProductController::class, 'search'])->name('product.search');
    Route::get('/category/{category}', [PublicProductController::class, 'filterByCategory'])->name('product.category');

    // API Routes untuk AJAX (jika ada)
    Route::prefix('api')->group(function () {
        Route::get('/product/{id}', [PublicProductController::class, 'getProduct'])->name('api.product');
        Route::get('/products', [PublicProductController::class, 'getAllProducts'])->name('api.products');
    });

    // ==========================
    // 🔐 AUTHENTICATION ROUTES
    // ==========================

    // Guest only routes (redirect jika sudah login)
    Route::middleware('guest')->group(function () {
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

    Route::middleware('auth')->group(function () {
        // User Dashboard/Home
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        
        // Cart Routes
        Route::prefix('cart')->name('cart.')->group(function () {
            Route::get('/', [CartController::class, 'index'])->name('index');
            Route::post('/add', [CartController::class, 'add'])->name('add');
            Route::post('/update', [CartController::class, 'update'])->name('update');
            Route::post('/remove', [CartController::class, 'remove'])->name('remove');
            Route::post('/clear', [CartController::class, 'clear'])->name('clear');
            Route::get('/count', [CartController::class, 'getCart'])->name('get');
        });
        
        // User Logout
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });

    // ==========================
    // 🔐 ADMIN ROUTES
    // ==========================

    Route::middleware('isAdmin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            // Admin Dashboard
            Route::get('/dashboard', fn () => view('admin.dashboard'))->name('dashboard');

            // Products
            Route::resource('products', AdminProductController::class);
            Route::delete('/products/images/{id}', [AdminProductController::class, 'deleteImage'])
                ->name('products.deleteImage');
            Route::post('/products/quick-store-category', [AdminProductController::class, 'quickStoreCategory'])
                ->name('products.quickStoreCategory');
            
            // Discounts
            Route::resource('discounts', DiscountController::class);
            Route::patch('/discounts/{discount}/toggle-status', [DiscountController::class, 'toggleStatus'])
                ->name('discounts.toggle-status');
        });

    // Admin Logout
    Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});