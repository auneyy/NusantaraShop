<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RajaOngkirController;
use App\Http\Controllers\ProductController as PublicProductController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ArtikelController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HelpController;

// Middleware untuk mencegah back history di seluruh aplikasi
Route::middleware(\App\Http\Middleware\PreventBackHistory::class)->group(function () {

    // ==========================
    // 🏠 PUBLIC ROUTES
    // ==========================

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Route utama (landing page)
    Route::get('/', function () {return redirect('/home');});

    // Halaman umum (dapat diakses semua orang)
    Route::get('/promo', [PromoController::class, 'index'])->name('promo');
    Route::view('/contact', 'contact')->name('contact');
    
    // Help & Article Routes
    Route::get('/help', [HelpController::class, 'index'])->name('help');
    Route::get('/help/article/{slug}', [HelpController::class, 'show'])->name('help.article');
    Route::get('/help/category/{category}', [HelpController::class, 'category'])->name('help.category');

    // Products Resource (menggunakan controller publik yang benar)
    Route::get('/products', [PublicProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product:slug}', [PublicProductController::class, 'show'])->name('products.show');

    // API Routes untuk AJAX (jika ada)
    Route::prefix('api')->group(function () {
        Route::get('/product/{id}', [PublicProductController::class, 'getProduct'])->name('api.product');
        Route::get('/products', [PublicProductController::class, 'getAllProducts'])->name('api.products');
    });

    // RajaOngkir API Routes (dapat diakses publik untuk keperluan checkout)
    Route::prefix('rajaongkir')->name('rajaongkir.')->group(function () {
        Route::get('/provinces', [RajaOngkirController::class, 'index'])->name('provinces');
        Route::get('/cities/{provinceId}', [RajaOngkirController::class, 'getCities'])->name('cities');
        Route::get('/districts/{cityId}', [RajaOngkirController::class, 'getDistricts'])->name('districts');
        Route::post('/check-ongkir', [RajaOngkirController::class, 'checkOngkir'])->name('check-ongkir');
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

        // Check discount status
        Route::get('/api/discounts/check-status', [DiscountController::class, 'checkStatus'])->name('api.discounts.check-status');
        
        // Cart Routes
        Route::prefix('cart')->name('cart.')->group(function () {
            Route::get('/', [CartController::class, 'index'])->name('index');
            Route::post('/add', [CartController::class, 'add'])->name('add');
            Route::post('/update', [CartController::class, 'update'])->name('update');
            Route::post('/remove', [CartController::class, 'remove'])->name('remove');
            Route::post('/clear', [CartController::class, 'clear'])->name('clear');
            Route::get('/count', [CartController::class, 'getCart'])->name('count');
        });

        // Profile Routes
        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/', [ProfileController::class, 'index'])->name('index');
            Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
            Route::put('/update', [ProfileController::class, 'update'])->name('update');
            Route::get('/orders', [ProfileController::class, 'orders'])->name('orders');
            Route::get('/password', [ProfileController::class, 'showChangePassword'])->name('password');
            Route::put('/update-password', [ProfileController::class, 'updatePassword'])->name('update-password');
            Route::get('/settings', [ProfileController::class, 'settings'])->name('settings');
            Route::post('/settings/notifications', [ProfileController::class, 'updateNotifications'])->name('settings.notifications');
            Route::post('/settings/preferences', [ProfileController::class, 'updatePreferences'])->name('settings.preferences');
            Route::delete('/delete', [ProfileController::class, 'deleteAccount'])->name('delete');
        });
        
        // Orders Routes
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('index');
            Route::get('/{orderNumber}', [OrderController::class, 'show'])->name('show');
            Route::match(['POST', 'DELETE'], '/{orderNumber}/cancel', [OrderController::class, 'cancel'])->name('cancel');
            Route::patch('/{order}/cancel', [ProfileController::class, 'cancelOrder'])->name('cancel.profile');
            Route::get('/{orderNumber}/check-payment-status', [OrderController::class, 'checkPaymentStatus'])->name('check-payment-status');
        });
        
        // Checkout Routes
        Route::prefix('checkout')->name('checkout.')->group(function () {
            Route::get('/', [CheckoutController::class, 'index'])->name('index');
            Route::post('/process', [CheckoutController::class, 'process'])->name('process');
            Route::get('/success', [CheckoutController::class, 'success'])->name('success');
            Route::get('/check-payment-status/{orderNumber}', [CheckoutController::class, 'checkPaymentStatus'])->name('check-payment-status');
            Route::post('/midtrans/notification', [CheckoutController::class, 'midtransNotification'])->name('midtrans.notification');
        });

        // AI Chat Routes
        Route::prefix('api/ai-chat')->name('ai-chat.')->group(function () {
            Route::post('/send', [App\Http\Controllers\AIChatController::class, 'chat'])->name('send');
            Route::get('/suggestions', [App\Http\Controllers\AIChatController::class, 'getProductSuggestions'])->name('suggestions');
            Route::get('/test', [App\Http\Controllers\AIChatController::class, 'testConnection'])->name('test');
        });

        // Contact Form
        Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
        
        // User Logout
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });

    // TAMBAHAN: Route untuk webhook Midtrans (tanpa middleware auth karena dipanggil oleh Midtrans server)
    Route::post('/webhook/midtrans', [CheckoutController::class, 'midtransNotification'])->name('webhook.midtrans');

    // ==========================
    // 👑 ADMIN ROUTES
    // ==========================

    Route::middleware('isAdmin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            // Admin Dashboard
            Route::get('/dashboard', [AdminOrderController::class, 'dashboard'])->name('dashboard');

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

            // Kategori
            Route::resource('categories', CategoryController::class)->except(['show']);

            // Artikel Help
            Route::resource('artikel', ArtikelController::class);
           
            // Pesanan
            Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
            Route::get('/orders/{orderNumber}', [AdminOrderController::class, 'show'])->name('orders.show');
            Route::patch('/orders/{orderNumber}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');

            // Messages/Pesan Masuk
            Route::resource('messages', MessageController::class)->only(['index','show']);

            // Laporan Pendapatan
            Route::get('/pendapatan', fn () => view('admin.pendapatan'))->name('pendapatan');
                
            // Admin Logout
            Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        });
});