@extends('layout.app')

@section('content')
<style>
    body {
        background-color: white !important;
    }

    .product-detail-container {
        padding: 3rem 0;
        background-color: #fff;
    }

    .product-image-section {
        display: flex;
        gap: 20px;
        align-items: flex-start;
        flex-wrap: wrap;
    }

    .thumbnail-gallery { 
        display: flex; 
        flex-direction: column; 
        gap: 15px; 
        overflow-y: auto; 
        height: 100%; 
        max-height: 500px; 
        top: 8rem; 
        padding-right: 10px; 
    } 
    
    .thumbnail-gallery img { 
        width: 80px; 
        height: 80px; 
        cursor: pointer; 
        object-fit: cover; 
        border: 1px solid transparent; 
        transition: border-color 0.2s ease, transform 0.2s ease; 
        margin-top: 2px; 
    }

    .thumbnail-gallery img.active,
    .thumbnail-gallery img:hover {
        border-color: #422D1C;
        transform: translateY(-2px);
    }

    .main-image-display {
        flex: 1;
        min-height: 500px;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        position: relative;
    }

    .main-image {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        display: block;
        transition: transform 0.3s ease;
    }

    .main-image:hover {
        transform: scale(1.05);
        cursor: zoom-in;
    }

    .product-info-wrapper {
        padding-left: 2rem;
        flex: 1;
    }

    .product-title-detail { 
        font-size: 30px !important; 
        font-weight: 500 !important; 
        margin-bottom: 0.5rem; 
    } 
    
    .product-price-detail { 
        font-size: 20px !important; 
        font-weight: 500 !important; 
        color: #8B4513 !important; 
        margin-bottom: 1.5rem; 
    }

    /* Discount Badge on Image */
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

    /* Countdown Timer for Product Detail */
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

    .product-description-detail {
        font-size: 1rem;
        line-height: 1.6;
        color: #555;
        margin-bottom: 2rem;
    }

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

    /* Custom Alert & Toast Styles */
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

    @media (max-width: 768px) {
        .product-image-section {
            flex-direction: column;
        }

        .product-info-wrapper {
            padding-left: 0;
            padding-top: 2rem;
        }

        .main-image-display {
            min-height: 350px;
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
</style>

<div class="product-detail-container">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="product-image-section">
                    @if($product->images->count() > 1)
                        <div class="thumbnail-gallery">
                            @foreach($product->images as $thumb)
                                <img src="{{ $thumb->image_path }}" class="thumbnail" alt="Thumbnail">
                            @endforeach
                        </div>
                    @endif

                    <div class="main-image-display">
                        {{-- Discount Badge on Image --}}
                        @if($activeDiscount && $activeDiscount->is_valid)
                            <div class="discount-badge-overlay">
                                -{{ $activeDiscount->percentage }}%
                            </div>
                        @endif

                        <img id="main-product-image" 
                             src="{{ $product->images->first()->image_path ?? 'path/to/placeholder.jpg' }}" 
                             class="main-image" 
                             alt="{{ $product->name }}">
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="product-info-wrapper">
                    <h1 class="product-title-detail">{{ $product->name }}</h1>

                    {{-- Price with Discount --}}
                    @if($activeDiscount && $activeDiscount->is_valid)
                        <p class="product-price-detail d-flex align-items-center gap-2">
                            <span class="text-muted" style="text-decoration: line-through;">
                                Rp {{ number_format($product->harga, 0, ',', '.') }}
                            </span>
                            <span class="text-danger fw-bold">
                                Rp {{ number_format($discountedPrice, 0, ',', '.') }}
                            </span>
                        </p>
                        <div class="mb-3">
                            <span class="badge bg-success">
                                Hemat Rp {{ number_format($savings, 0, ',', '.') }}
                            </span>
                        </div>

                        {{-- Countdown Timer --}}
                        <div class="product-countdown-timer" data-end-date="{{ $activeDiscount->end_date_iso }}">
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

                    <p class="product-description-detail">{{ $product->deskripsi }}</p>

                    <form id="product-form" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="product_name" value="{{ $product->name }}">
                        <input type="hidden" name="product_price" value="{{ $activeDiscount && $activeDiscount->is_valid ? $discountedPrice : $product->harga }}">
                        <input type="hidden" name="product_image" value="{{ $product->images->first()->image_path ?? '' }}">

                        <div class="mb-4">
                            <h6 class="font-weight-bold mb-2">Pilih Ukuran:</h6>
                            <div class="size-options">
                                @foreach(['S','M','L','XL','XXL'] as $size)
                                    <span class="size-option" data-size="{{ $size }}">{{ $size }}</span>
                                @endforeach
                            </div>
                            <input type="hidden" name="size" id="selected-size" value="">
                        </div>

                        <div class="mb-4">
                            <h6 class="font-weight-bold mb-2">Jumlah:</h6>
                            <div class="quantity-control">
                                <button type="button" class="quantity-btn" id="decrease-qty">-</button>
                                <input type="number" class="quantity-input" name="quantity" id="product-qty" value="1" min="1" max="{{ $product->stock_kuantitas }}" readonly>
                                <button type="button" class="quantity-btn" id="increase-qty">+</button>
                            </div>
                            <p class="text-muted">Stok Tersedia: <span id="stock-value">{{ $product->stock_kuantitas }}</span></p>
                        </div>

                        <div class="action-buttons">
                            <button type="button" class="btn add-to-cart-btn" id="add-to-cart">
                                <i class="bi bi-bag-plus-fill me-2"></i> Tambah ke Keranjang
                            </button>
                            <a href="{{ route('checkout.index', ['product_id' => $product->id, 'quantity' => 1]) }}"
                               class="btn buy-now-btn" id="buy-now">
                               <i class="bi bi-lightning-fill me-2"></i> Beli Sekarang
                            </a>
                        </div>
                    </form>
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
                            @include('partials.product-card', [
                                'product' => $recommendedProduct,
                                'activeDiscounts' => $recommendedDiscounts
                            ])
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

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
    // Countdown Timer untuk Product Detail
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

    // Rest of your JavaScript code...
    const mainImage = document.getElementById('main-product-image');
    const thumbnails = document.querySelectorAll('.thumbnail-gallery img');
    const sizeOptions = document.querySelectorAll('.size-option');
    const decreaseBtn = document.getElementById('decrease-qty');
    const increaseBtn = document.getElementById('increase-qty');
    const quantityInput = document.getElementById('product-qty');
    const stockValue = parseInt(document.getElementById('stock-value').innerText);
    const addToCartBtn = document.getElementById('add-to-cart');
    const buyNowBtn = document.getElementById('buy-now');
    const selectedSizeInput = document.getElementById('selected-size');

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

    // Thumbnail Click
    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', function() {
            mainImage.src = this.src;
            thumbnails.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Size Selection
    sizeOptions.forEach(option => {
        option.addEventListener('click', function() {
            sizeOptions.forEach(o => o.classList.remove('active'));
            this.classList.add('active');
            selectedSizeInput.value = this.dataset.size;
        });
    });
    
    if (sizeOptions.length > 0) {
        sizeOptions[0].classList.add('active');
        selectedSizeInput.value = sizeOptions[0].dataset.size;
    }

    // Quantity Control
    decreaseBtn.addEventListener('click', function() {
        let currentQty = parseInt(quantityInput.value);
        if (currentQty > 1) quantityInput.value = currentQty - 1;
    });
    
    increaseBtn.addEventListener('click', function() {
        let currentQty = parseInt(quantityInput.value);
        if (currentQty < stockValue) quantityInput.value = currentQty + 1;
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
        if (parseInt(quantityInput.value) > stockValue) {
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
});
</script>
@endpush