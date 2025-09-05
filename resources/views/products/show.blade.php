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
    }

    .buy-now-btn {
        background: #ff6b35;
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
        background: #e55a2b;
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
                    <p class="product-price-detail">Rp {{ number_format($product->harga,0,',','.') }}</p>
                    <p class="product-description-detail">{{ $product->deskripsi }}</p>

                    <!-- Form untuk checkout -->
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
                        @include('partials.product-card', ['product' => $product])
                    </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>

<div id="zoomed-image-container" class="zoomed-image-container">
    <span class="close-btn">&times;</span>
    <img id="zoomed-image" class="zoomed-image" src="" alt="Zoomed Product Image">
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mainImage = document.getElementById('main-product-image');
    const thumbnails = document.querySelectorAll('.thumbnail-gallery img');
    const sizeOptions = document.querySelectorAll('.size-option');
    const decreaseBtn = document.getElementById('decrease-qty');
    const increaseBtn = document.getElementById('increase-qty');
    const quantityInput = document.getElementById('product-qty');
    const stockValue = parseInt(document.getElementById('stock-value').innerText);
    const zoomedImageContainer = document.getElementById('zoomed-image-container');
    const zoomedImage = document.getElementById('zoomed-image');
    const closeBtn = document.querySelector('.close-btn');
    const addToCartBtn = document.getElementById('add-to-cart');
    const buyNowBtn = document.getElementById('buy-now');
    const selectedSizeInput = document.getElementById('selected-size');

    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', function() {
            mainImage.src = this.src;
            thumbnails.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
        });
    });

    sizeOptions.forEach(option => {
        option.addEventListener('click', function() {
            sizeOptions.forEach(o => o.classList.remove('active'));
            this.classList.add('active');
            selectedSizeInput.value = this.dataset.size;
        });
    });
    // Set default size
    if(sizeOptions.length > 0) {
        sizeOptions[0].classList.add('active');
        selectedSizeInput.value = sizeOptions[0].dataset.size;
    }

    decreaseBtn.addEventListener('click', function() {
        let currentQty = parseInt(quantityInput.value);
        if(currentQty > 1) quantityInput.value = currentQty - 1;
    });
    increaseBtn.addEventListener('click', function() {
        let currentQty = parseInt(quantityInput.value);
        if(currentQty < stockValue) quantityInput.value = currentQty + 1;
    });

    // Zoom functionality
    mainImage.addEventListener('click', function() {
        zoomedImage.src = this.src;
        zoomedImageContainer.style.display = 'flex';
    });
    closeBtn.addEventListener('click', function() {
        zoomedImageContainer.style.display = 'none';
    });
    zoomedImageContainer.addEventListener('click', function(e){
        if(e.target === this) this.style.display = 'none';
    });

    // Validation function
    function validateForm() {
        if (!selectedSizeInput.value) {
            alert('Silakan pilih ukuran produk terlebih dahulu!');
            return false;
        }
        if (parseInt(quantityInput.value) < 1) {
            alert('Jumlah produk minimal 1!');
            return false;
        }
        if (parseInt(quantityInput.value) > stockValue) {
            alert('Jumlah produk melebihi stok yang tersedia!');
            return false;
        }
        return true;
    }

    // Add to cart functionality
    addToCartBtn.addEventListener('click', function() {
        if (!validateForm()) return;

        // Show loading state
        this.classList.add('btn-loading');
        this.disabled = true;
        const originalText = this.innerHTML;
        this.innerHTML = '';

        // Simulate API call - replace with your actual cart API
        const formData = new FormData(document.getElementById('product-form'));
        
        // Example AJAX call to add to cart
        fetch('/cart/add', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                alert('Produk berhasil ditambahkan ke keranjang!');
                // You can also update cart count in navbar here
                updateCartCount();
            } else {
                alert(data.message || 'Gagal menambahkan produk ke keranjang!');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan. Silakan coba lagi!');
        })
        .finally(() => {
            // Remove loading state
            this.classList.remove('btn-loading');
            this.disabled = false;
            this.innerHTML = originalText;
        });
    });

    // Buy now functionality
    buyNowBtn.addEventListener('click', function() {
        if (!validateForm()) return;

        // Show loading state
        this.classList.add('btn-loading');
        this.disabled = true;
        const originalText = this.innerHTML;
        this.innerHTML = '';

        // Create form data for direct checkout
        const formData = new FormData(document.getElementById('product-form'));
        
        // Redirect langsung ke checkout dengan data produk
        const params = new URLSearchParams();
        params.append('product_id', formData.get('product_id'));
        params.append('product_name', formData.get('product_name'));
        params.append('product_price', formData.get('product_price'));
        params.append('product_image', formData.get('product_image'));
        params.append('size', formData.get('size'));
        params.append('quantity', formData.get('quantity'));
        
        window.location.href = '/checkout?' + params.toString();
    });
        
        // Add to cart first, then redirect to checkout
        fetch('/cart/add', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Redirect to checkout page
                window.location.href = '/checkout';
            } else {
                alert(data.message || 'Gagal memproses pesanan!');
                // Remove loading state
                this.classList.remove('btn-loading');
                this.disabled = false;
                this.innerHTML = originalText;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan. Silakan coba lagi!');
            // Remove loading state
            this.classList.remove('btn-loading');
            this.disabled = false;
            this.innerHTML = originalText;
        });
    });

    // Function to update cart count (optional)
    function updateCartCount() {
        fetch('/cart/count')
        .then(response => response.json())
        .then(data => {
            // Update cart count in navbar if exists
            const cartCountElement = document.querySelector('.cart-count');
            if (cartCountElement) {
                cartCountElement.textContent = data.count;
            }
        })
        .catch(error => console.error('Error updating cart count:', error));
    }
});
</script>
@endsection