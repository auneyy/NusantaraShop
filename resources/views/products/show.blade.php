@extends('layout.app')

@section('content')

<style>
/* ========================================
   REVIEWS SECTION STYLES
   ======================================== */
.rating-stars {
    color: #ffc107;
    font-size: 1.25rem;
    line-height: 1;
}

.rating-input {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
    margin-bottom: 0.5rem;
}

.rating-input input[type="radio"] {
    display: none;
}

.rating-input label {
    color: #ddd;
    font-size: 1.5rem;
    padding: 0 2px;
    cursor: pointer;
    position: relative;
}

.rating-input label .fas {
    display: none;
    position: absolute;
    left: 0;
    top: 0;
}

.rating-input input[type="radio"]:checked ~ label .far,
.rating-input input[type="radio"]:checked ~ label .fas,
.rating-input:not(:checked) > label:hover .fas,
.rating-input:not(:checked) > label:hover ~ label .fas {
    display: inline-block;
}

.rating-input:not(:checked) > label:hover .far,
.rating-input:not(:checked) > label:hover ~ label .far {
    display: none;
}

.rating-input input[type="radio"]:checked ~ label .far {
    display: none;
}

.rating-input input[type="radio"]:checked ~ label .fas {
    display: inline-block;
}

.rating-input label:hover,
.rating-input input[type="radio"]:checked ~ label {
    color: #ffc107;
}

.review-card {
    border: 1px solid #eee;
    border-radius: 8px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    background: #fff;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.review-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.review-header {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
}

.review-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background-color: #f0f0f0;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    font-size: 1.5rem;
    color: #666;
    font-weight: bold;
    text-transform: uppercase;
}

.review-user {
    flex: 1;
}

.review-user-name {
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.review-date {
    font-size: 0.875rem;
    color: #6c757d;
}

.review-images {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 1rem;
}

.review-image {
    width: 100px;
    height: 100px;
    border-radius: 8px;
    object-fit: cover;
    cursor: pointer;
    transition: transform 0.2s ease;
}

.review-image:hover {
    transform: scale(1.05);
}

.review-pagination {
    margin-top: 2rem;
    display: flex;
    justify-content: center;
}

.no-reviews {
    text-align: center;
    padding: 2rem;
    background: #f8f9fa;
    border-radius: 8px;
    color: #6c757d;
}

/* Image Modal */
.review-image-modal {
    display: none;
    position: fixed;
    z-index: 2000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.9);
    overflow: auto;
}

.modal-content {
    margin: auto;
    display: block;
    max-width: 90%;
    max-height: 80vh;
    margin-top: 10vh;
}

.close-modal {
    position: absolute;
    top: 20px;
    right: 30px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    cursor: pointer;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .rating-row {
        font-size: 0.875rem;
    }
    
    .review-card {
        padding: 1rem;
    }
    
    .review-avatar {
        width: 40px;
        height: 40px;
        font-size: 1.25rem;
    }
    
    .review-images {
        gap: 8px;
    }
    
    .review-image {
        width: 80px;
        height: 80px;
    }
}

/* ========================================
   PRODUCT DETAIL PAGE - VERTICAL IMAGE SCROLL
   ======================================== */

body {
    background-color: white !important;
}

.product-detail-container {
    padding: 3rem 0;
    background-color: #fff;
}

/* ========================================
   IMAGE SECTION - VERTICAL DISPLAY WITH THUMBNAILS
   ======================================== */

.product-image-section {
    display: flex;
    gap: 20px;
    align-items: flex-start;
    width: 100%;
}

/* Thumbnail Gallery - Show Again */
.thumbnail-gallery { 
    display: flex;
    flex-direction: column;
    gap: 15px;
    flex-shrink: 0;
    position: sticky;
    top: 20px;
    align-self: flex-start;
    max-height: calc(100vh - 80px);
    overflow-y: auto;
    overflow-x: hidden;
    padding-right: 10px;
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none; /* IE and Edge */
}

/* Hide scrollbar for thumbnails */
.thumbnail-gallery::-webkit-scrollbar {
    display: none;
}

.thumbnail-gallery img { 
    width: 80px;
    height: 80px;
    cursor: pointer;
    object-fit: cover;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.thumbnail-gallery img.active,
.thumbnail-gallery img:hover {
    border-color: #422D1C;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(66, 45, 28, 0.2);
}

/* Main Image Display - Show All Images Vertically */
.main-image-display {
    flex: 1;
    width: 100%;
    min-height: auto;
    display: flex;
    flex-direction: column;
    gap: 15px;
    position: relative;
    background-color: transparent;
    border: none;
    border-radius: 0;
    overflow: visible;
    padding-right: 10px;
}

/* Each Image Container - NO BORDER */
.main-image {
    width: 100%;
    height: auto;
    max-height: 700px;
    object-fit: contain;
    object-position: center;
    display: block;
    transition: transform 0.3s ease;
    background-color: transparent;
    border: none;
    border-radius: 0;
    padding: 0;
    scroll-margin-top: 20px;
}

.main-image:hover {
    transform: scale(1.02);
    cursor: zoom-in;
}

/* Discount Badge Overlay */
.discount-badge-overlay {
    position: absolute;
    top: 20px;
    left: 20px;
    background: linear-gradient(135deg, rgb(229, 98, 62) 0%, rgb(224, 13, 6) 100%);
    color: white;
    font-size: 14px;
    font-weight: 700;
    padding: 8px 16px;
    border-radius: 25px;
    z-index: 10;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    box-shadow: 0 4px 12px rgba(229, 62, 62, 0.4);
}

/* ========================================
   PRODUCT INFO SECTION - STICKY (NO SCROLL)
   ======================================== */

.product-info-wrapper {
    padding-left: 2rem;
    position: sticky;
    top: 20px;
    align-self: flex-start;
    max-height: none;
    overflow: visible;
}

.product-title-detail { 
    font-size: 30px !important; 
    font-weight: 500 !important; 
    margin-bottom: 0.5rem;
    line-height: 1.3;
} 

.product-price-detail { 
    font-size: 20px !important; 
    font-weight: 500 !important; 
    color: #8B4513 !important; 
    margin-bottom: 1.5rem; 
}

.product-description-detail {
    font-size: 1rem;
    line-height: 1.6;
    color: #555;
    margin-bottom: 2rem;
}

/* ========================================
   COUNTDOWN TIMER
   ======================================== */

.product-countdown-timer {
    background: rgba(0, 0, 0, 0.85);
    backdrop-filter: blur(10px);
    color: white;
    padding: 12px 20px;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 600;
    display: inline-flex;
    gap: 12px;
    align-items: center;
    margin-top: 10px;
    margin-bottom: 0.5rem !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
}

.countdown-unit {
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: 40px;
}

.countdown-value {
    font-size: 18px;
    font-weight: 700;
    line-height: 1;
    color: #fff;
}

.countdown-label {
    font-size: 9px;
    color: rgba(255, 255, 255, 0.7);
    text-transform: uppercase;
    margin-top: 3px;
}

.countdown-separator {
    font-size: 18px;
    font-weight: 700;
    color: rgba(255, 255, 255, 0.5);
}

/* ========================================
   SIZE & QUANTITY CONTROLS
   ======================================== */

.size-option {
    display: inline-block;
    padding: 8px 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-right: 10px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.size-option.active,
.size-option:hover {
    background-color: #422D1C;
    color: #fff;
    border-color: #422D1C;
}

.size-option.out-of-stock {
    opacity: 0.5;
    cursor: not-allowed;
    background-color: #f5f5f5;
}

.quantity-control {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
}

.quantity-btn {
    background: #f0f0f0;
    border: 1px solid #ccc;
    width: 40px;
    height: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    transition: all 0.2s ease;
}

.quantity-btn:hover {
    background: #e0e0e0;
}

.quantity-input {
    width: 60px;
    text-align: center;
    border: 1px solid #ccc;
    border-left: none;
    border-right: none;
    height: 40px;
}

.quantity-input::-webkit-outer-spin-button,
.quantity-input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* ========================================
   ACTION BUTTONS
   ======================================== */

.action-buttons {
    display: flex;
    gap: 1rem;
    margin-top: 1.5rem;
}

.add-to-cart-btn {
    background: #422D1C;
    border: none;
    color: white;
    font-size: 1.1rem;
    font-weight: 600;
    padding: 1rem 2.5rem;
    border-radius: 4px;
    transition: all 0.3s ease;
    flex: 1;
}

.add-to-cart-btn:hover {
    background: #8B4513;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    color: white;
}

.buy-now-btn {
    background: #8B4513;
    border: none;
    color: white;
    font-size: 1.1rem;
    font-weight: 600;
    padding: 1rem 2.5rem;
    border-radius: 4px;
    transition: all 0.3s ease;
    flex: 1;
}

.buy-now-btn:hover {
    background: #422D1C;
    color: white;
    box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
    transform: translateY(-2px);
}

.btn-loading {
    position: relative;
    pointer-events: none;
}

.btn-loading::after {
    content: '';
    position: absolute;
    width: 16px;
    height: 16px;
    top: 50%;
    left: 50%;
    margin-left: -8px;
    margin-top: -8px;
    border: 2px solid transparent;
    border-top-color: #ffffff;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* ========================================
   CUSTOM ALERT MODAL
   ======================================== */

.custom-alert-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 9999;
    display: none;
    justify-content: center;
    align-items: center;
    backdrop-filter: blur(2px);
}

.custom-alert {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    text-align: center;
    max-width: 400px;
    width: 90%;
    position: relative;
    transform: scale(0.7);
    opacity: 0;
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.custom-alert.show {
    transform: scale(1);
    opacity: 1;
}

.custom-alert.success .alert-icon {
    background: linear-gradient(135deg, #4CAF50, #45a049);
    color: white;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.5rem;
    animation: checkmark 0.6s ease-in-out;
}

.custom-alert.error .alert-icon {
    background: linear-gradient(135deg, #f44336, #d32f2f);
    color: white;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.5rem;
    animation: shake 0.6s ease-in-out;
}

.custom-alert.warning .alert-icon {
    background: linear-gradient(135deg, #ff9800, #f57c00);
    color: white;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.5rem;
    animation: pulse 1s infinite;
}

@keyframes checkmark {
    0% { transform: scale(0); opacity: 0; }
    50% { transform: scale(1.3); }
    100% { transform: scale(1); opacity: 1; }
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

.alert-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #333;
}

.alert-message {
    color: #666;
    font-size: 0.95rem;
    margin-bottom: 1.5rem;
    line-height: 1.5;
}

.alert-button {
    background: linear-gradient(135deg, #422D1C, #8B4513);
    color: white;
    border: none;
    padding: 0.75rem 2rem;
    border-radius: 8px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.95rem;
}

.alert-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(66, 45, 28, 0.3);
}

.alert-close {
    position: absolute;
    top: 15px;
    right: 15px;
    background: none;
    border: none;
    font-size: 1.2rem;
    color: #999;
    cursor: pointer;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all 0.2s ease;
}

.alert-close:hover {
    background: #f5f5f5;
    color: #666;
}

/* ========================================
   TOAST NOTIFICATIONS
   ======================================== */

.toast-container {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 10000;
}

.custom-toast {
    background: white;
    border-radius: 12px;
    padding: 1rem 1.25rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
    margin-bottom: 10px;
    min-width: 300px;
    max-width: 400px;
    display: flex;
    align-items: center;
    gap: 12px;
    transform: translateX(100%);
    opacity: 0;
    transition: all 0.3s cubic-bezier(0.4, 0.0, 0.2, 1);
    border-left: 4px solid #4CAF50;
}

.custom-toast.show {
    transform: translateX(0);
    opacity: 1;
}

.custom-toast.error { border-left-color: #f44336; }
.custom-toast.warning { border-left-color: #ff9800; }

.toast-icon {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.75rem;
    flex-shrink: 0;
}

.toast-icon.success { background: #4CAF50; }
.toast-icon.error { background: #f44336; }
.toast-icon.warning { background: #ff9800; }

.toast-content {
    flex-grow: 1;
}

.toast-title {
    font-weight: 600;
    font-size: 0.9rem;
    margin-bottom: 2px;
    color: #333;
}

.toast-message {
    font-size: 0.8rem;
    color: #666;
    margin: 0;
}

.toast-close {
    background: none;
    border: none;
    color: #999;
    cursor: pointer;
    padding: 0;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all 0.2s ease;
    flex-shrink: 0;
}

.toast-close:hover {
    background: #f5f5f5;
    color: #666;
}

/* ========================================
   RESPONSIVE DESIGN
   ======================================== */

@media (max-width: 768px) {
    .product-info-wrapper {
        padding-left: 0;
        padding-top: 2rem;
        position: relative;
        top: 0;
        max-height: none;
    }

    .main-image {
        max-height: 400px;
    }

    .action-buttons {
        flex-direction: column;
    }

    .add-to-cart-btn,
    .buy-now-btn {
        width: 100%;
        padding: 0.8rem;
    }

    .custom-alert {
        margin: 1rem;
        max-width: none;
    }

    .toast-container {
        top: 10px;
        right: 10px;
        left: 10px;
    }

    .custom-toast {
        min-width: auto;
        max-width: none;
    }
}

@media (min-width: 769px) and (max-width: 1024px) {
    .main-image {
        max-height: 600px;
    }

    .product-info-wrapper {
        top: 80px;
    }
}
</style>

<div class="product-detail-container">
    <div class="container">
        <div class="row">
                <div class="col-md-6">
                <div class="product-image-section">
                    {{-- Thumbnail Gallery --}}
                    @if($product->images->count() > 1)
                        <div class="thumbnail-gallery">
                            @foreach($product->images as $thumb)
                                <img src="{{ $thumb->image_path }}" class="thumbnail" alt="Thumbnail">
                            @endforeach
                        </div>
                    @endif

                    {{-- Main Images Display - ALL IMAGES VERTICALLY --}}
                    <div class="main-image-display">
                        @foreach($product->images as $image)
                            <img src="{{ $image->image_path }}" 
                                 class="main-image" 
                                 alt="{{ $product->name }}">
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="product-info-wrapper">
                    <h1 class="product-title-detail">{{ $product->name }}</h1>

                    {{-- Price with Discount --}}
                    @if($product->has_active_discount)
                        <p class="product-price-detail d-flex align-items-center gap-2">
                            <span class="text-muted" style="text-decoration: line-through;">
                                Rp {{ number_format($product->harga, 0, ',', '.') }}
                            </span>
                            <span class="text-danger fw-bold">
                                Rp {{ number_format($product->discounted_price, 0, ',', '.') }}
                            </span>
                        </p>
                        <div class="mb-3">
                            <span class="badge bg-success">
                                Hemat Rp {{ number_format($product->savings_amount, 0, ',', '.') }}
                            </span>
                        </div>

                        {{-- Countdown Timer with Space --}}
                        <div class="product-countdown-timer mb-4" data-end-date="{{ $product->discount_end_date_iso }}" style="margin-bottom: 0.5rem !important;">
                            <span style="font-size: 12px; opacity: 0.9;">⏰ Berakhir dalam:</span>
                            <div class="countdown-unit">
                                <span class="countdown-value days">00</span>
                                <span class="countdown-label">Hari</span>
                            </div>
                            <span class="countdown-separator">:</span>
                            <div class="countdown-unit">
                                <span class="countdown-value hours">00</span>
                                <span class="countdown-label">Jam</span>
                            </div>
                            <span class="countdown-separator">:</span>
                            <div class="countdown-unit">
                                <span class="countdown-value minutes">00</span>
                                <span class="countdown-label">Menit</span>
                            </div>
                            <span class="countdown-separator">:</span>
                            <div class="countdown-unit">
                                <span class="countdown-value seconds">00</span>
                                <span class="countdown-label">Detik</span>
                            </div>
                        </div>
                    @else
                        <p class="product-price-detail">
                            Rp {{ number_format($product->harga, 0, ',', '.') }}
                        </p>
                    @endif

                    {{-- Product Description with Space --}}
                    <p class="product-description-detail mt-3">{{ $product->deskripsi }}</p>

                    <form id="product-form" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="product_name" value="{{ $product->name }}">
                        <input type="hidden" name="product_price" value="{{ $product->has_active_discount ? $product->discounted_price : $product->harga }}">
                        <input type="hidden" name="product_image" value="{{ $product->images->first()->image_path ?? '' }}">

                        {{-- SIZE SELECTION --}}
                        <div class="mb-4">
                            <h6 class="font-weight-bold mb-2">Pilih Ukuran: <span class="text-danger">*</span></h6>
                            <div class="size-options">
                                @if($product->sizes->count() > 0)
                                    @foreach($product->sizes as $size)
                                        <span class="size-option {{ $size->stock == 0 ? 'out-of-stock' : '' }}" 
                                              data-size="{{ $size->size }}" 
                                              data-stock="{{ $size->stock }}"
                                              {{ $size->stock == 0 ? 'disabled' : '' }}>
                                            {{ $size->size }}
                                            @if($size->stock == 0)
                                                <small class="stock-label">(Habis)</small>
                                            @endif
                                        </span>
                                    @endforeach
                                @else
                                    <p class="text-danger">Size tidak tersedia</p>
                                @endif
                            </div>
                            <input type="hidden" name="size" id="selected-size" value="" required>
                            <div class="invalid-feedback" id="size-error">Silakan pilih ukuran</div>
                        </div>

                        {{-- QUANTITY --}}
                        <div class="mb-4">
                            <h6 class="font-weight-bold mb-2">Jumlah:</h6>
                            <div class="quantity-control">
                                <button type="button" class="quantity-btn" id="decrease-qty">-</button>
                                <input type="number" class="quantity-input" name="quantity" id="product-qty" value="1" min="1" max="1" readonly>
                                <button type="button" class="quantity-btn" id="increase-qty">+</button>
                            </div>
                            <p class="text-muted">Stok Tersedia: <span id="stock-value">0</span></p>
                            <div class="invalid-feedback" id="quantity-error">Jumlah tidak valid</div>
                        </div>

                        <div class="action-buttons">
                            <button type="button" class="btn add-to-cart-btn" id="add-to-cart" disabled>
                                <i class="bi bi-bag-plus-fill me-2"></i> Tambah ke Keranjang
                            </button>
                            <a href="#" class="btn buy-now-btn" id="buy-now" style="pointer-events: none; opacity: 0.6;">
                               <i class="bi bi-lightning-fill me-2"></i> Beli Sekarang
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>{{-- Tutup row --}}

        {{-- Reviews Section --}}
        <div class="row mt-5">
    <div class="col-12">
        <hr class="my-5">

        {{-- Show success/error messages --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

        <div class="reviews-section">
            <div class="reviews-header mb-4">
                <h3 class="mb-4">Ulasan Produk</h3>
                
                {{-- Rating Summary --}}
                <div class="row mb-4">
                    <div class="col-md-4 text-center mb-4 mb-md-0">
                        <div class="bg-light p-4 rounded">
                            <h1 class="display-4 fw-bold text-warning mb-0">{{ number_format($averageRating, 1) }}</h1>
                            <div class="rating-stars mb-2">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($averageRating))
                                        <i class="fas fa-star text-warning"></i>
                                    @elseif($i - 0.5 <= $averageRating)
                                        <i class="fas fa-star-half-alt text-warning"></i>
                                    @else
                                        <i class="far fa-star text-warning"></i>
                                    @endif
                                @endfor
                            </div>
                            <p class="text-muted mb-0">Berdasarkan {{ $totalReviews }} ulasan</p>
                        </div>
                    </div>
                    <div class="col-md-8">
                        @foreach($ratingPercentages as $rating => $percentage)
                            <div class="rating-row d-flex align-items-center mb-2">
                                <div class="text-nowrap me-2" style="width: 30px;">
                                    <span class="text-muted">{{ 6 - $rating }}</span>
                                    <i class="fas fa-star text-warning"></i>
                                </div>
                                <div class="progress flex-grow-1" style="height: 10px;">
                                    <div class="progress-bar bg-warning" role="progressbar" 
                                         style="width: {{ $percentage }}%" 
                                         aria-valuenow="{{ $percentage }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100">
                                    </div>
                                </div>
                                <span class="ms-2 text-muted" style="width: 40px;">{{ round($percentage) }}%</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                {{-- Review Form --}}
                @auth
                    @if(auth()->user()->canReviewProduct($product->id))
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Tulis Ulasan</h5>
                                <form id="review-form" action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="order_id" value="{{ auth()->user()->getOrderIdForReview($product->id) }}">
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Rating</label>
                                        <div class="rating-input">
                                            @for($i = 5; $i >= 1; $i--)
                                                <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" {{ $i == 5 ? 'checked' : '' }}>
                                                <label for="star{{ $i }}" title="{{ $i }} bintang">
                                                    <i class="far fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </label>
                                            @endfor
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="komentar" class="form-label">Ulasan Anda</label>
                                        <textarea class="form-control" id="komentar" name="komentar" rows="3" maxlength="1000"></textarea>
                                        <div class="form-text">Maksimal 1000 karakter</div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="images" class="form-label">Unggah Foto (Maksimal 5)</label>
                                        <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*">
                                        <div class="form-text">Format: JPG, PNG. Maksimal 2MB per foto.</div>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane"></i> Kirim Ulasan
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <a href="{{ route('login') }}" class="text-primary">Masuk</a> atau 
                        <a href="{{ route('register') }}" class="text-primary">Daftar</a> untuk memberikan ulasan
                    </div>
                @endauth
            </div>
            
            {{-- Reviews List --}}
            <div class="reviews-list mt-4">
                <h4 class="mb-4">Semua Ulasan ({{ $totalReviews }})</h4>
                
                @if($reviews->count() > 0)
                    @foreach($reviews as $review)
                        <div class="review-card mb-4">
                            <div class="review-header">
                                <div class="review-avatar">
                                    {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                </div>
                                <div class="review-user">
                                    <div class="review-user-name">{{ $review->user->name }}</div>
                                    <div class="d-flex align-items-center">
                                        <div class="rating-stars me-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    <i class="fas fa-star text-warning"></i>
                                                @else
                                                    <i class="far fa-star text-warning"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <span class="review-date">{{ $review->created_at->diffForHumans() }}</span>
                                    </div>
                                    @if($review->is_verified)
                                        <span class="badge bg-success mt-1" style="font-size: 0.7rem;">
                                            <i class="fas fa-check-circle"></i> Verified Purchase
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            @if($review->komentar)
                                <div class="review-comment mt-3">
                                    <p class="mb-0" style="line-height: 1.6; color: #333;">{{ $review->komentar }}</p>
                                </div>
                            @endif
                            
                            @if($review->images)
                                <div class="review-images mt-3">
                                    @php
                                        $images = is_array($review->images) ? $review->images : json_decode($review->images, true);
                                    @endphp
                                    @if($images)
                                        @foreach($images as $image)
                                            <img src="{{ asset('storage/' . $image) }}" 
                                                 alt="Review Image" 
                                                 class="review-image" 
                                                 onclick="showImageModal('{{ asset('storage/' . $image) }}')">
                                        @endforeach
                                    @endif
                                </div>
                            @endif

                            <div class="review-footer mt-3 pt-3 border-top" style="border-color: #f0f0f0 !important;">
                                <small class="text-muted">
                                    <i class="far fa-calendar"></i> {{ $review->created_at->format('d M Y, H:i') }}
                                </small>
                            </div>
                        </div>
                    @endforeach

                    {{-- Pagination --}}
                    @if($reviews->hasPages())
                        <div class="review-pagination mt-4 d-flex justify-content-center">
                            {{ $reviews->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                @else
                    <div class="no-reviews">
                        <div class="text-center py-5">
                            <i class="fas fa-comments" style="font-size: 3rem; color: #dee2e6; margin-bottom: 1rem;"></i>
                            <h5 style="color: #6c757d;">Belum Ada Ulasan</h5>
                            <p class="text-muted">Jadilah yang pertama memberikan ulasan untuk produk ini!</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

        {{-- Recommended Products --}}
        @if($recommendedProducts->count() > 0)
            <div class="mt-5">
                <hr class="my-5">
                <h3 class="text-center mb-5">Produk Rekomendasi Untukmu</h3>
                <div class="row g-3">
                    @foreach($recommendedProducts as $recommendedProduct)
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            @include('partials.product-card', ['product' => $recommendedProduct])
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        <!-- Review Image Modal -->
        <div id="reviewImageModal" class="review-image-modal">
    <span class="close-modal">&times;</span>
    <img class="modal-content" id="modalImage">
</div>
</div>{{-- Tutup container --}}
</div>{{-- Tutup product-detail-container --}}

<!-- Custom Alert Modal -->
<div class="custom-alert-overlay" id="customAlertOverlay">
    <div class="custom-alert" id="customAlert">
        <button class="alert-close" id="alertClose">&times;</button>
        <div class="alert-icon" id="alertIcon">
            <i class="bi bi-check-lg"></i>
        </div>
        <h4 class="alert-title" id="alertTitle">Berhasil!</h4>
        <p class="alert-message" id="alertMessage">Produk berhasil ditambahkan ke keranjang</p>
        <button class="alert-button" id="alertButton">OK</button>
    </div>
</div>

<!-- Toast Container -->
<div class="toast-container" id="toastContainer"></div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ========================================
    // COUNTDOWN TIMER
    // ========================================
    const productCountdown = document.querySelector('.product-countdown-timer');
    
    if (productCountdown) {
        const endDate = new Date(productCountdown.dataset.endDate).getTime();
        
        const daysEl = productCountdown.querySelector('.days');
        const hoursEl = productCountdown.querySelector('.hours');
        const minutesEl = productCountdown.querySelector('.minutes');
        const secondsEl = productCountdown.querySelector('.seconds');
        
        function updateProductCountdown() {
            const now = new Date().getTime();
            const distance = endDate - now;
            
            if (distance < 0) {
                location.reload();
                return;
            }
            
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            daysEl.textContent = String(days).padStart(2, '0');
            hoursEl.textContent = String(hours).padStart(2, '0');
            minutesEl.textContent = String(minutes).padStart(2, '0');
            secondsEl.textContent = String(seconds).padStart(2, '0');
        }
        
        updateProductCountdown();
        setInterval(updateProductCountdown, 1000);
    }

    // ========================================
    // SIZE & QUANTITY SELECTION
    // ========================================
    const sizeOptions = document.querySelectorAll('.size-option:not(.out-of-stock)');
    const decreaseBtn = document.getElementById('decrease-qty');
    const increaseBtn = document.getElementById('increase-qty');
    const quantityInput = document.getElementById('product-qty');
    const stockValueEl = document.getElementById('stock-value');
    const addToCartBtn = document.getElementById('add-to-cart');
    const buyNowBtn = document.getElementById('buy-now');
    const selectedSizeInput = document.getElementById('selected-size');

    let currentStock = 0;

    // Custom Alert Functions
    function showCustomAlert(type, title, message, callback = null) {
        const overlay = document.getElementById('customAlertOverlay');
        const alert = document.getElementById('customAlert');
        const icon = document.getElementById('alertIcon');
        const titleEl = document.getElementById('alertTitle');
        const messageEl = document.getElementById('alertMessage');
        const button = document.getElementById('alertButton');
        const closeBtn = document.getElementById('alertClose');

        alert.className = 'custom-alert ' + type;
        titleEl.textContent = title;
        messageEl.textContent = message;
        
        if (type === 'success') {
            icon.innerHTML = '<i class="bi bi-check-lg"></i>';
        } else if (type === 'error') {
            icon.innerHTML = '<i class="bi bi-x-lg"></i>';
        } else if (type === 'warning') {
            icon.innerHTML = '<i class="bi bi-exclamation-lg"></i>';
        }

        overlay.style.display = 'flex';
        setTimeout(() => alert.classList.add('show'), 10);

        const closeAlert = () => {
            alert.classList.remove('show');
            setTimeout(() => {
                overlay.style.display = 'none';
                if (callback) callback();
            }, 300);
        };

        button.onclick = closeAlert;
        closeBtn.onclick = closeAlert;
        overlay.onclick = (e) => { if (e.target === overlay) closeAlert(); };
    }

    function showToast(type, title, message, duration = 4000) {
        const container = document.getElementById('toastContainer');
        const toast = document.createElement('div');
        toast.className = `custom-toast ${type}`;
        
        const iconClass = type === 'success' ? 'bi-check-lg' : 
                         type === 'error' ? 'bi-x-lg' : 'bi-exclamation-lg';
        
        toast.innerHTML = `
            <div class="toast-icon ${type}">
                <i class="bi ${iconClass}"></i>
            </div>
            <div class="toast-content">
                <div class="toast-title">${title}</div>
                <div class="toast-message">${message}</div>
            </div>
            <button class="toast-close">&times;</button>
        `;
        
        container.appendChild(toast);
        setTimeout(() => toast.classList.add('show'), 10);
        
        const closeToast = () => {
            toast.classList.remove('show');
            setTimeout(() => {
                if (container.contains(toast)) container.removeChild(toast);
            }, 300);
        };
        
        toast.querySelector('.toast-close').onclick = closeToast;
        setTimeout(closeToast, duration);
    }

    // Size Selection
    sizeOptions.forEach(option => {
        option.addEventListener('click', function() {
            if (this.classList.contains('out-of-stock')) return;
            
            sizeOptions.forEach(o => o.classList.remove('active'));
            this.classList.add('active');
            selectedSizeInput.value = this.dataset.size;
            
            currentStock = parseInt(this.dataset.stock);
            stockValueEl.textContent = currentStock;
            quantityInput.max = currentStock;
            quantityInput.value = Math.min(1, currentStock);
            
            addToCartBtn.disabled = false;
            buyNowBtn.style.pointerEvents = 'auto';
            buyNowBtn.style.opacity = '1';
        });
    });
    
    if (sizeOptions.length > 0) {
        sizeOptions[0].click();
    }

    // Quantity Control
    decreaseBtn.addEventListener('click', function() {
        let currentQty = parseInt(quantityInput.value);
        if (currentQty > 1) quantityInput.value = currentQty - 1;
    });
    
    increaseBtn.addEventListener('click', function() {
        let currentQty = parseInt(quantityInput.value);
        if (currentQty < currentStock) quantityInput.value = currentQty + 1;
    });

    // Validation
    function validateForm() {
        if (!selectedSizeInput.value) {
            showCustomAlert('warning', 'Pilih Ukuran', 'Silakan pilih ukuran produk terlebih dahulu!');
            return false;
        }
        if (parseInt(quantityInput.value) < 1) {
            showCustomAlert('warning', 'Jumlah Tidak Valid', 'Jumlah produk minimal 1!');
            return false;
        }
        if (parseInt(quantityInput.value) > currentStock) {
            showCustomAlert('error', 'Stok Tidak Mencukupi', 'Jumlah produk melebihi stok yang tersedia!');
            return false;
        }
        return true;
    }

    // Add to Cart
    addToCartBtn.addEventListener('click', function() {
        if (!validateForm()) return;

        this.classList.add('btn-loading');
        this.disabled = true;
        const originalText = this.innerHTML;
        this.innerHTML = '<span>Menambahkan...</span>';

        const formData = {
            product_id: document.querySelector('input[name="product_id"]').value,
            quantity: quantityInput.value,
            size: selectedSizeInput.value,
            _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        };

        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': formData._token,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('success', 'Berhasil!', 'Produk berhasil ditambahkan ke keranjang');
                updateCartCount(data.cart_count);
            } else {
                showCustomAlert('error', 'Gagal!', data.message || 'Gagal menambahkan produk ke keranjang!');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showCustomAlert('error', 'Terjadi Kesalahan', 'Silakan coba lagi dalam beberapa saat!');
        })
        .finally(() => {
            this.classList.remove('btn-loading');
            this.disabled = false;
            this.innerHTML = originalText;
        });
    });

    // Buy Now
    buyNowBtn.addEventListener('click', function(e) {
        e.preventDefault();
        if (!validateForm()) return;

        const productId = document.querySelector('input[name="product_id"]').value;
        const quantity = quantityInput.value;
        const size = selectedSizeInput.value;

        window.location.href = `/checkout?product_id=${productId}&quantity=${quantity}&size=${size}`;
    });

    // Update Cart Count
    function updateCartCount(count) {
        const cartCountElements = document.querySelectorAll('.cart-count, .cart-badge');
        cartCountElements.forEach(element => {
            if (element) {
                element.textContent = count || 0;
                if (count > 0) {
                    element.style.display = 'inline';
                } else {
                    element.style.display = 'none';
                }
            }
        });
    }

    // Keyboard Support
    document.addEventListener('keydown', function(e) {
        const overlay = document.getElementById('customAlertOverlay');
        if (overlay.style.display === 'flex' && e.key === 'Escape') {
            const alert = document.getElementById('customAlert');
            alert.classList.remove('show');
            setTimeout(() => {
                overlay.style.display = 'none';
            }, 300);
        }
    });

    // ========================================
    // THUMBNAIL & IMAGE GALLERY
    // ========================================
    const mainImages = document.querySelectorAll('.main-image');
    const thumbnails = document.querySelectorAll('.thumbnail-gallery img');

    thumbnails.forEach((thumbnail, index) => {
        thumbnail.addEventListener('click', function() {
            thumbnails.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            if (mainImages[index]) {
                mainImages[index].scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'center' 
                });
            }
        });
    });

    const observerOptions = {
        root: null,
        rootMargin: '-50% 0px -50% 0px',
        threshold: 0
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const index = Array.from(mainImages).indexOf(entry.target);
                thumbnails.forEach(t => t.classList.remove('active'));
                if (thumbnails[index]) {
                    thumbnails[index].classList.add('active');
                }
            }
        });
    }, observerOptions);

    mainImages.forEach(img => observer.observe(img));

    if (thumbnails.length > 0) {
        thumbnails[0].classList.add('active');
    }

    // ========================================
    // REVIEW IMAGE MODAL - ✅ TARUH DI SINI
    // ========================================
    const reviewImageModal = document.getElementById('reviewImageModal');
    const modalImg = document.getElementById('modalImage');
    const closeModal = document.querySelector('.close-modal');

    // Function to show image in modal
    window.showImageModal = function(imageSrc) {
        if (reviewImageModal && modalImg) {
            reviewImageModal.style.display = 'block';
            modalImg.src = imageSrc;
            document.body.style.overflow = 'hidden';
        }
    };

    // Close modal when clicking the close button
    if (closeModal) {
        closeModal.addEventListener('click', function() {
            reviewImageModal.style.display = 'none';
            document.body.style.overflow = 'auto';
        });
    }

    // Close modal when clicking outside the image
    window.addEventListener('click', function(e) {
        if (e.target === reviewImageModal) {
            reviewImageModal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    });

    // ========================================
    // REVIEW FORM VALIDATION - ✅ TARUH DI SINI
    // ========================================
    const reviewForm = document.getElementById('review-form');
    if (reviewForm) {
        reviewForm.addEventListener('submit', function(e) {
            const fileInput = document.getElementById('images');
            
            // Validate file count
            if (fileInput && fileInput.files.length > 5) {
                e.preventDefault();
                showCustomAlert('warning', 'Terlalu Banyak File', 'Maksimal 5 foto yang dapat diunggah!');
                return false;
            }
            
            // Validate file size (max 2MB per file)
            if (fileInput) {
                for (let i = 0; i < fileInput.files.length; i++) {
                    if (fileInput.files[i].size > 2 * 1024 * 1024) {
                        e.preventDefault();
                        showCustomAlert('warning', 'File Terlalu Besar', 'Setiap foto maksimal 2MB!');
                        return false;
                    }
                }
            }
            
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                const originalBtnText = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Mengirim...';
            }
            
            // Allow form to submit normally (will reload page)
            return true;
        });
    }

    // ========================================
    // SCROLL TO REVIEWS ON SUCCESS/ERROR - ✅ TARUH DI SINI
    // ========================================
    const urlParams = new URLSearchParams(window.location.search);
    
    // Check if we should scroll to reviews
    if (urlParams.has('review_success') || urlParams.has('review_error')) {
        setTimeout(() => {
            const reviewsSection = document.querySelector('.reviews-section');
            if (reviewsSection) {
                reviewsSection.scrollIntoView({ 
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }, 300);
    }
    
    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            if (typeof bootstrap !== 'undefined' && bootstrap.Alert) {
                const bsAlert = bootstrap.Alert.getInstance(alert) || new bootstrap.Alert(alert);
                bsAlert.close();
            } else {
                alert.style.display = 'none';
            }
        }, 5000);
    });
});
</script>
@endpush