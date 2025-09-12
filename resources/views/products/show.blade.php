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

  .thumbnail-gallery { display: flex; flex-direction: column; gap: 15px; overflow-y: auto; height: 100%; max-height: 500px; top: 8rem; padding-right: 10px; } 
  .thumbnail-gallery img { width: 80px; height: 80px; cursor: pointer; object-fit: cover; border: 1px solid transparent; transition: border-color 0.2s ease, transform 0.2s ease; margin-top: 2px; }

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

.product-title-detail { font-size: 30px !important; font-weight: 500 !important; margin-bottom: 0.5rem; } 
.product-price-detail { font-size: 20px !important; font-weight: 500 !important; color: #8B4513 !important; margin-bottom: 1.5rem; }

    .product-description-detail {
        font-size: 1rem;
        line-height: 1.6;
        color: #555;
        margin-bottom: 2rem;
    }

    /* Tombol aksi */
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

    /* Pilihan ukuran */
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

    .zoomed-image-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.85);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 1050;
    }

    .zoomed-image {
        max-width: 90%;
        max-height: 90%;
        object-fit: contain;
    }

    .close-btn {
        position: absolute;
        top: 20px;
        right: 30px;
        color: white;
        font-size: 2.5rem;
        cursor: pointer;
        opacity: 0.8;
        transition: opacity 0.2s ease;
    }

    .close-btn:hover {
        opacity: 1;
    }

    /* Loading states */
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

    /* Custom Alert Styles */
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

    /* Toast Notification */
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

    /* Responsive */
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
                    @php
                        $discount = $activeDiscounts->firstWhere('products.0.id', $product->id);
                    @endphp

                    @if($discount)
                        @php
                            $discountedPrice = $product->harga - ($product->harga * $discount->percentage / 100);
                        @endphp
                      <p class="product-price-detail d-flex align-items-center gap-2">
    <span class="text-muted" style="text-decoration: line-through;">
        Rp {{ number_format($product->harga, 0, ',', '.') }}
    </span>
    <span class="text-danger fw-bold">
        Rp {{ number_format($discountedPrice, 0, ',', '.') }}
    </span>
</p>
                    @else
                        <p class="product-price-detail">
                            Rp {{ number_format($product->harga,0,',','.') }}
                        </p>
                    @endif

                    <p class="product-description-detail">{{ $product->deskripsi }}</p>

                    <form id="product-form" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="product_name" value="{{ $product->name }}">
                        <input type="hidden" name="product_price" value="{{ $product->harga }}">
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

        @if($recommendedProducts->count() > 0)
            <div class="mt-5">
                <hr class="my-5">
                <h3 class="text-center mb-5">Produk Rekomendasi Untukmu</h3>
                <div class="row g-3">
                    @foreach($recommendedProducts as $product)
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            @include('partials.product-card', [
                                'product' => $product,
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

<script>
document.addEventListener('DOMContentLoaded', function() {
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

    /** ---------------- Custom Alert Functions ---------------- **/
    function showCustomAlert(type, title, message, callback = null) {
        const overlay = document.getElementById('customAlertOverlay');
        const alert = document.getElementById('customAlert');
        const icon = document.getElementById('alertIcon');
        const titleEl = document.getElementById('alertTitle');
        const messageEl = document.getElementById('alertMessage');
        const button = document.getElementById('alertButton');
        const closeBtn = document.getElementById('alertClose');

        // Reset classes
        alert.className = 'custom-alert ' + type;
        
        // Set content
        titleEl.textContent = title;
        messageEl.textContent = message;
        
        // Set icon based on type
        if (type === 'success') {
            icon.innerHTML = '<i class="bi bi-check-lg"></i>';
        } else if (type === 'error') {
            icon.innerHTML = '<i class="bi bi-x-lg"></i>';
        } else if (type === 'warning') {
            icon.innerHTML = '<i class="bi bi-exclamation-lg"></i>';
        }

        // Show overlay
        overlay.style.display = 'flex';
        
        // Add show class with slight delay for animation
        setTimeout(() => {
            alert.classList.add('show');
        }, 10);

        // Handle close events
        const closeAlert = () => {
            alert.classList.remove('show');
            setTimeout(() => {
                overlay.style.display = 'none';
                if (callback) callback();
            }, 300);
        };

        button.onclick = closeAlert;
        closeBtn.onclick = closeAlert;
        
        // Close on overlay click
        overlay.onclick = (e) => {
            if (e.target === overlay) closeAlert();
        };
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
        
        // Show toast
        setTimeout(() => {
            toast.classList.add('show');
        }, 10);
        
        // Close button
        const closeBtn = toast.querySelector('.toast-close');
        const closeToast = () => {
            toast.classList.remove('show');
            setTimeout(() => {
                if (container.contains(toast)) {
                    container.removeChild(toast);
                }
            }, 300);
        };
        
        closeBtn.onclick = closeToast;
        
        // Auto close
        setTimeout(closeToast, duration);
    }

    /** ---------------- Thumbnail Click ---------------- **/
    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', function() {
            mainImage.src = this.src;
            thumbnails.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
        });
    });

    /** ---------------- Size Selection ---------------- **/
    sizeOptions.forEach(option => {
        option.addEventListener('click', function() {
            sizeOptions.forEach(o => o.classList.remove('active'));
            this.classList.add('active');
            selectedSizeInput.value = this.dataset.size;
        });
    });
    // Default pilih size pertama
    if (sizeOptions.length > 0) {
        sizeOptions[0].classList.add('active');
        selectedSizeInput.value = sizeOptions[0].dataset.size;
    }

    /** ---------------- Quantity Control ---------------- **/
    decreaseBtn.addEventListener('click', function() {
        let currentQty = parseInt(quantityInput.value);
        if (currentQty > 1) quantityInput.value = currentQty - 1;
    });
    increaseBtn.addEventListener('click', function() {
        let currentQty = parseInt(quantityInput.value);
        if (currentQty < stockValue) quantityInput.value = currentQty + 1;
    });

    /** ---------------- Zoom Image (jika ada container zoom) ---------------- **/
    const zoomedImageContainer = document.getElementById('zoomed-image-container');
    const zoomedImage = document.getElementById('zoomed-image');
    const closeBtn = document.querySelector('.close-btn');
    
    if (zoomedImageContainer && zoomedImage && closeBtn) {
        mainImage.addEventListener('click', function() {
            zoomedImage.src = this.src;
            zoomedImageContainer.style.display = 'flex';
        });
        closeBtn.addEventListener('click', function() {
            zoomedImageContainer.style.display = 'none';
        });
        zoomedImageContainer.addEventListener('click', function(e) {
            if (e.target === this) this.style.display = 'none';
        });
    }

    /** ---------------- Validation ---------------- **/
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

    /** ---------------- Add to Cart ---------------- **/
    addToCartBtn.addEventListener('click', function() {
        if (!validateForm()) return;

        // Disable button dan show loading
        this.classList.add('btn-loading');
        this.disabled = true;
        const originalText = this.innerHTML;
        this.innerHTML = '<span>Menambahkan...</span>';

        // Siapkan data
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
                // Tampilkan toast notification
                showToast('success', 'Berhasil!', 'Produk berhasil ditambahkan ke keranjang');
                
                // Update cart count
                updateCartCount(data.cart_count);
                
                // Atau gunakan custom alert (pilih salah satu)
                // showCustomAlert('success', 'Berhasil!', 'Produk berhasil ditambahkan ke keranjang');
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

    /** ---------------- Buy Now ---------------- **/
    buyNowBtn.addEventListener('click', function(e) {
        e.preventDefault();
        if (!validateForm()) return;

        const productId = document.querySelector('input[name="product_id"]').value;
        const quantity = quantityInput.value;
        const size = selectedSizeInput.value;

        // Redirect langsung ke checkout dengan parameters
        window.location.href = `/checkout?product_id=${productId}&quantity=${quantity}&size=${size}`;
    });

    /** ---------------- Update Cart Count ---------------- **/
    function updateCartCount(count) {
        const cartCountElements = document.querySelectorAll('.cart-count, .cart-badge');
        cartCountElements.forEach(element => {
            if (element) {
                element.textContent = count || 0;
                // Show badge if count > 0
                if (count > 0) {
                    element.style.display = 'inline';
                } else {
                    element.style.display = 'none';
                }
            }
        });
    }

    /** ---------------- Keyboard Support ---------------- **/
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