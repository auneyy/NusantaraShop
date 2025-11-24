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

    .rating-input input[type="radio"]:checked~label .far,
    .rating-input input[type="radio"]:checked~label .fas,
    .rating-input:not(:checked)>label:hover .fas,
    .rating-input:not(:checked)>label:hover~label .fas {
        display: inline-block;
    }

    .rating-input:not(:checked)>label:hover .far,
    .rating-input:not(:checked)>label:hover~label .far {
        display: none;
    }

    .rating-input input[type="radio"]:checked~label .far {
        display: none;
    }

    .rating-input input[type="radio"]:checked~label .fas {
        display: inline-block;
    }

    .rating-input label:hover,
    .rating-input input[type="radio"]:checked~label {
        color: #ffc107;
    }

    .review-card {
        border: 1px solid #eee;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        background: #fff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .review-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
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
        scrollbar-width: none;
        /* Firefox */
        -ms-overflow-style: none;
        /* IE and Edge */
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
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
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
        0% {
            transform: scale(0);
            opacity: 0;
        }

        50% {
            transform: scale(1.3);
        }

        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    @keyframes shake {

        0%,
        100% {
            transform: translateX(0);
        }

        25% {
            transform: translateX(-5px);
        }

        75% {
            transform: translateX(5px);
        }
    }

    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.1);
        }
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

    .custom-toast.error {
        border-left-color: #f44336;
    }

    .custom-toast.warning {
        border-left-color: #ff9800;
    }

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

    .toast-icon.success {
        background: #4CAF50;
    }

    .toast-icon.error {
        background: #f44336;
    }

    .toast-icon.warning {
        background: #ff9800;
    }

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
                        {{-- Rating Summary --}}
                        <div class="row mb-4">
                            <div class="col-md-4 text-center mb-4 mb-md-0">
                                <div class="bg-light p-4 rounded">
                                    <h1 class="display-4 fw-bold text-warning mb-0">{{ number_format($averageRating, 1) }}</h1>
                                    <div class="rating-stars mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <=floor($averageRating))
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
                                {{-- ✅ PERBAIKAN: Loop dari 5 ke 1 (descending) --}}
                                @for($rating = 5; $rating >= 1; $rating--)
                                @php
                                $count = $ratingDistribution[$rating] ?? 0;
                                $percentage = $ratingPercentages[$rating] ?? 0;
                                @endphp
                                <div class="rating-row d-flex align-items-center mb-2">
                                    <div class="text-nowrap me-2" style="width: 30px;">
                                        <span class="text-muted">{{ $rating }}</span>
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
                                    <span class="ms-2 text-muted" style="width: 50px; text-align: right;">
                                        {{ $count }} ({{ round($percentage) }}%)
                                    </span>
                                </div>
                                @endfor
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
                                        <label class="form-label">Rating <span class="text-danger">*</span></label>
                                        <div class="rating-input">
                                            @for($i = 5; $i >= 1; $i--)
                                            <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" {{ $i == 5 ? 'checked' : '' }} required>
                                            <label for="star{{ $i }}" title="{{ $i }} bintang">
                                                <i class="far fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </label>
                                            @endfor
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="komentar" class="form-label">Ulasan Anda</label>
                                        <textarea
                                            class="form-control @error('komentar') is-invalid @enderror"
                                            id="komentar"
                                            name="komentar"
                                            rows="4"
                                            maxlength="1000"
                                            placeholder="Bagikan pengalaman Anda menggunakan produk ini...">{{ old('komentar') }}</textarea>
                                        <div class="form-text">Maksimal 1000 karakter (opsional)</div>
                                        @error('komentar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="images" class="form-label">Unggah Foto (Opsional)</label>
                                        <input type="file"
                                            class="form-control @error('images') is-invalid @enderror"
                                            id="images"
                                            name="images[]"
                                            multiple
                                            accept="image/jpeg,image/png,image/jpg">
                                        <div class="form-text">Format: JPG, PNG. Maksimal 2MB per foto, maksimal 3 foto.</div>
                                        @error('images')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary" id="submit-review-btn">
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
                                                @if($i <=$review->rating)
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
// ✅ COMPLETE FIXED VERSION - PRODUCT DETAIL PAGE
(function() {
    'use strict';
    
    console.log('🚀 PRODUCT DETAIL - COMPLETE FIXED VERSION LOADED');

    // ========================================
    // UTILITY FUNCTIONS
    // ========================================
    function waitForElement(selector, timeout = 5000) {
        return new Promise((resolve, reject) => {
            const element = document.querySelector(selector);
            if (element) {
                resolve(element);
                return;
            }
            
            const observer = new MutationObserver((mutations, obs) => {
                const element = document.querySelector(selector);
                if (element) {
                    obs.disconnect();
                    resolve(element);
                }
            });
            
            observer.observe(document.body, {
                childList: true,
                subtree: true
            });
            
            setTimeout(() => {
                observer.disconnect();
                reject(new Error(`Element ${selector} not found within ${timeout}ms`));
            }, timeout);
        });
    }

    // ========================================
    // 1. COUNTDOWN TIMER (Detail Page Only)
    // ========================================
    function initDetailPageCountdown() {
        const productCountdown = document.querySelector('.product-countdown-timer:not(.countdown-timer-card)');
        
        if (!productCountdown || !productCountdown.dataset.endDate) {
            console.log('ℹ️ No active discount countdown on detail page');
            return;
        }

        console.log('⏰ Initializing detail page countdown...');

        function updateCountdown() {
            const endDate = new Date(productCountdown.dataset.endDate);
            const now = new Date();
            const distance = endDate - now;

            if (distance < 0) {
                console.log('⏰ Countdown expired, reloading...');
                location.reload();
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            const daysEl = productCountdown.querySelector('.days');
            const hoursEl = productCountdown.querySelector('.hours');
            const minutesEl = productCountdown.querySelector('.minutes');
            const secondsEl = productCountdown.querySelector('.seconds');

            if (daysEl) daysEl.textContent = String(days).padStart(2, '0');
            if (hoursEl) hoursEl.textContent = String(hours).padStart(2, '0');
            if (minutesEl) minutesEl.textContent = String(minutes).padStart(2, '0');
            if (secondsEl) secondsEl.textContent = String(seconds).padStart(2, '0');
        }

        updateCountdown();
        const intervalId = setInterval(updateCountdown, 1000);
        console.log('✅ Detail page countdown initialized');
        
        return intervalId;
    }

    // ========================================
    // 2. SIZE & QUANTITY CONTROLS
    // ========================================
    function initSizeAndQuantity() {
        console.log('🔄 Initializing size and quantity controls...');
        
        return waitForElement('.size-option')
            .then(() => {
                const sizeOptions = document.querySelectorAll('.size-option');
                const quantityInput = document.getElementById('product-qty');
                const stockValueEl = document.getElementById('stock-value');
                const addToCartBtn = document.getElementById('add-to-cart');
                const buyNowBtn = document.getElementById('buy-now');
                const selectedSizeInput = document.getElementById('selected-size');
                const decreaseBtn = document.getElementById('decrease-qty');
                const increaseBtn = document.getElementById('increase-qty');

                console.log('📦 Elements found:', {
                    sizes: sizeOptions.length,
                    quantityInput: !!quantityInput,
                    addToCartBtn: !!addToCartBtn,
                    buyNowBtn: !!buyNowBtn
                });

                if (sizeOptions.length === 0) {
                    console.error('❌ No size options found!');
                    return;
                }

                let currentStock = 0;

                // Handle size selection
                function handleSizeSelection(selectedOption) {
                    console.log('👉 Size selected:', selectedOption.dataset.size);
                    
                    // Remove active from all
                    sizeOptions.forEach(option => {
                        option.classList.remove('active');
                    });
                    
                    // Add active to selected
                    selectedOption.classList.add('active');
                    
                    // Update hidden input
                    if (selectedSizeInput) {
                        selectedSizeInput.value = selectedOption.dataset.size;
                    }
                    
                    // Update stock
                    currentStock = parseInt(selectedOption.dataset.stock) || 0;
                    if (stockValueEl) stockValueEl.textContent = currentStock;
                    if (quantityInput) {
                        quantityInput.max = currentStock;
                        quantityInput.value = 1; // Reset to 1
                    }
                    
                    // Enable buttons
                    if (addToCartBtn) {
                        addToCartBtn.disabled = false;
                        console.log('✅ Add to cart enabled');
                    }
                    
                    if (buyNowBtn) {
                        buyNowBtn.style.pointerEvents = 'auto';
                        buyNowBtn.style.opacity = '1';
                        console.log('✅ Buy now enabled');
                    }
                }

                // Add click listeners
                sizeOptions.forEach(option => {
                    option.addEventListener('click', function() {
                        if (!this.classList.contains('out-of-stock')) {
                            handleSizeSelection(this);
                        }
                    });
                });

                // Auto-select first available size
                const firstAvailableSize = document.querySelector('.size-option:not(.out-of-stock)');
                if (firstAvailableSize) {
                    console.log('🔄 Auto-selecting first available size');
                    handleSizeSelection(firstAvailableSize);
                } else {
                    console.warn('⚠️ No available sizes found');
                }

                // Quantity controls
                if (decreaseBtn && increaseBtn && quantityInput) {
                    decreaseBtn.addEventListener('click', function() {
                        let currentQty = parseInt(quantityInput.value) || 1;
                        if (currentQty > 1) {
                            quantityInput.value = currentQty - 1;
                        }
                    });

                    increaseBtn.addEventListener('click', function() {
                        let currentQty = parseInt(quantityInput.value) || 1;
                        if (currentQty < currentStock) {
                            quantityInput.value = currentQty + 1;
                        }
                    });
                }

                console.log('✅ Size & quantity initialization completed');
            })
            .catch(error => {
                console.error('❌ Failed to initialize size/quantity:', error);
            });
    }

    // ========================================
    // 3. ADD TO CART
    // ========================================
    function initAddToCart() {
        const addToCartBtn = document.getElementById('add-to-cart');
        const selectedSizeInput = document.getElementById('selected-size');
        const quantityInput = document.getElementById('product-qty');

        if (!addToCartBtn) {
            console.log('ℹ️ Add to cart button not found');
            return;
        }

        addToCartBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('🛒 Add to cart clicked');
            
            // Validation
            if (!selectedSizeInput || !selectedSizeInput.value) {
                showAlert('warning', 'Perhatian', 'Silakan pilih ukuran terlebih dahulu!');
                return;
            }

            const quantity = parseInt(quantityInput?.value) || 1;
            const size = selectedSizeInput.value;

            // Show loading
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="bi bi-hourglass-split"></i> Menambahkan...';
            this.disabled = true;

            // Get form data
            const form = document.getElementById('product-form');
            const formData = new FormData(form);

            // Send to server
            fetch('{{ route("cart.add") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('success', 'Berhasil!', data.message || 'Produk berhasil ditambahkan ke keranjang');
                    
                    // Update cart count if exists
                    const cartCount = document.querySelector('.cart-count');
                    if (cartCount && data.cart_count) {
                        cartCount.textContent = data.cart_count;
                    }
                } else {
                    showAlert('error', 'Gagal', data.message || 'Gagal menambahkan ke keranjang');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('error', 'Error', 'Terjadi kesalahan. Silakan coba lagi.');
            })
            .finally(() => {
                this.innerHTML = originalText;
                this.disabled = false;
            });
        });

        console.log('✅ Add to cart initialized');
    }

    // ========================================
    // 4. BUY NOW
    // ========================================
    function initBuyNow() {
        const buyNowBtn = document.getElementById('buy-now');
        const selectedSizeInput = document.getElementById('selected-size');
        const quantityInput = document.getElementById('product-qty');

        if (!buyNowBtn) {
            console.log('ℹ️ Buy now button not found');
            return;
        }

        buyNowBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('⚡ Buy now clicked');

            if (!selectedSizeInput || !selectedSizeInput.value) {
                showAlert('warning', 'Perhatian', 'Silakan pilih ukuran terlebih dahulu!');
                return;
            }

            const quantity = parseInt(quantityInput?.value) || 1;
            const size = selectedSizeInput.value;
            const productId = document.querySelector('input[name="product_id"]')?.value;

            // Redirect to checkout
            const checkoutUrl = `{{ route('checkout.index') }}?product_id=${productId}&quantity=${quantity}&size=${encodeURIComponent(size)}`;
            console.log('🔀 Redirecting to:', checkoutUrl);
            window.location.href = checkoutUrl;
        });

        console.log('✅ Buy now initialized');
    }

    // ========================================
    // 5. IMAGE GALLERY
    // ========================================
    function initImageGallery() {
        const mainImages = document.querySelectorAll('.main-image');
        const thumbnails = document.querySelectorAll('.thumbnail-gallery img');

        if (thumbnails.length === 0 || mainImages.length === 0) {
            console.log('ℹ️ No image gallery found');
            return;
        }

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

        // Auto-select first thumbnail
        if (thumbnails[0]) {
            thumbnails[0].classList.add('active');
        }

        console.log('✅ Image gallery initialized');
    }

    // ========================================
    // 6. CUSTOM ALERT SYSTEM
    // ========================================
    function showAlert(type, title, message) {
        const overlay = document.getElementById('customAlertOverlay');
        const alert = document.getElementById('customAlert');
        const icon = document.getElementById('alertIcon');
        const titleEl = document.getElementById('alertTitle');
        const messageEl = document.getElementById('alertMessage');
        const button = document.getElementById('alertButton');
        const closeBtn = document.getElementById('alertClose');

        if (!overlay || !alert) {
            console.log('Using fallback alert');
            window.alert(`${title}\n\n${message}`);
            return;
        }

        // Set content
        titleEl.textContent = title;
        messageEl.textContent = message;

        // Set icon
        alert.className = 'custom-alert ' + type;
        const iconMap = {
            success: 'bi-check-lg',
            error: 'bi-x-lg',
            warning: 'bi-exclamation-lg'
        };
        icon.innerHTML = `<i class="bi ${iconMap[type] || iconMap.success}"></i>`;

        // Show
        overlay.style.display = 'flex';
        setTimeout(() => alert.classList.add('show'), 10);

        // Close handlers
        const closeAlert = () => {
            alert.classList.remove('show');
            setTimeout(() => {
                overlay.style.display = 'none';
            }, 300);
        };

        button.onclick = closeAlert;
        closeBtn.onclick = closeAlert;
        overlay.onclick = (e) => {
            if (e.target === overlay) closeAlert();
        };
    }

    // ========================================
    // 7. REVIEW IMAGE MODAL
    // ========================================
    function initReviewImageModal() {
        const modal = document.getElementById('reviewImageModal');
        if (!modal) return;

        const modalImg = document.getElementById('modalImage');
        const closeBtn = modal.querySelector('.close-modal');

        window.showImageModal = function(imageSrc) {
            modal.style.display = 'block';
            modalImg.src = imageSrc;
        };

        closeBtn.onclick = function() {
            modal.style.display = 'none';
        };

        modal.onclick = function(e) {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        };

        console.log('✅ Review image modal initialized');
    }

    // ========================================
    // MAIN INITIALIZATION
    // ========================================
    function init() {
        console.log('🔧 Starting main initialization...');
        
        // 1. Countdown (immediate)
        initDetailPageCountdown();
        
        // 2. Size & Quantity (wait for DOM)
        initSizeAndQuantity();
        
        // 3. Add to Cart
        initAddToCart();
        
        // 4. Buy Now
        initBuyNow();
        
        // 5. Image Gallery
        initImageGallery();
        
        // 6. Review Image Modal
        initReviewImageModal();
        
        console.log('✅ All initializations completed');
    }

    // Run when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();
</script>
@endpush