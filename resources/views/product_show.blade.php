@extends('layout.app')

@section('content')
<style>
    body {
        background-color: white !important;
    }
    
    .content-wrapper {
        padding-top: 3rem;
        padding-bottom: 3rem;
    }

    .product-detail-container {
        padding-top: 3rem;
        padding-bottom: 3rem;
        background-color: #fff;
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

    .main-image-display {
        position: relative;
        overflow: hidden;
        text-align: center;
        flex-grow: 1;
    }

    .main-image {
        max-width: 100%;
        height: auto;
        max-height: 500px;
        object-fit: contain;
        transition: transform 0.3s ease;
    }

    .main-image:hover {
        transform: scale(1.05);
    }
    
    .product-image-section {
        display: flex;
        gap: 20px;
        align-items: flex-start;
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
    
    .zoomed-image-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.85);
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
    
    .product-info-wrapper {
        padding-left: 3rem;
    }

    .product-title-detail {
        font-size: 2.5rem;
        font-weight: 700;
        color: #222;
        margin-bottom: 0.5rem;
    }

    .product-price-detail {
        font-size: 2rem;
        font-weight: 600;
        color: #422D1C;
        margin-bottom: 1.5rem;
    }
    
    .product-description-detail {
        font-size: 1rem;
        line-height: 1.6;
        color: #555;
        margin-bottom: 2rem;
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
    }

    .add-to-cart-btn:hover {
        background: #8B4513;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        color: white;
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
        background-color: #f0f0f0;
        border-color: #422D1C;
    }
    
    .size-option.active {
        background-color: #422D1C;
        color: #fff;
    }

    /* Tombol kuantitas */
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
        align-items: center;
        justify-content: center;
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
        -moz-appearance: textfield;
    }

    .quantity-input::-webkit-outer-spin-button,
    .quantity-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    @media (max-width: 768px) {
        .product-info-wrapper {
            padding-left: 0;
            padding-top: 2rem;
        }

        .product-title-detail {
            font-size: 2rem;
        }

        .product-price-detail {
            font-size: 1.5rem;
        }

        .main-image {
            height: 350px;
        }

        .add-to-cart-btn {
            width: 100%;
            padding: 0.8rem;
        }
    }
</style>

<div class="product-detail-container">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-4 mb-md-0">
                <div class="product-image-section">
                    @if($product->images->count() > 1)
                    <div class="thumbnail-gallery">
                        @foreach($product->images as $image)
                            <img src="{{ $image->image_url }}" alt="{{ $product->name }} Thumbnail" class="{{ $loop->first ? 'active' : '' }}">
                        @endforeach
                    </div>
                    @endif

                    <div class="main-image-display">
                        <img id="main-product-image" src="{{ $product->images->first()->image_url ?? 'path/to/placeholder.jpg' }}" alt="{{ $product->name }}" class="main-image">
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="product-info-wrapper">
                    <h1 class="product-title-detail">{{ $product->name }}</h1>
                    <p class="product-price-detail">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>

                    <p class="product-description-detail">{{ $product->deskripsi }}</p>

                    <div class="mb-4">
                        <h6 class="font-weight-bold mb-2">Pilih Ukuran:</h6>
                        <div class="size-options">
                            @foreach(['S', 'M', 'L', 'XL', 'XXL'] as $size)
                                <span class="size-option">{{ $size }}</span>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="font-weight-bold mb-2">Jumlah:</h6>
                        <div class="quantity-control">
                            <button class="quantity-btn" id="decrease-qty">-</button>
                            <input type="number" class="quantity-input" id="product-qty" value="1" min="1" max="{{ $product->stock_kuantitas }}" readonly>
                            <button class="quantity-btn" id="increase-qty">+</button>
                        </div>
                        <p class="text-muted mt-2">Stok Tersedia: <span id="stock-value">{{ $product->stock_kuantitas }}</span></p>
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn add-to-cart-btn" id="add-to-cart">
                            <i class="bi bi-bag-plus-fill me-2"></i> Tambah ke Keranjang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($recommendedProducts->count() > 0)
<div class="container mt-5 mb-5">
    <hr class="my-5">
    <h3 class="text-center mb-5 recommended-title">Produk Rekomendasi Untukmu</h3>
    <div class="row g-3">
        @foreach($recommendedProducts as $product)
            {{-- Mengubah kelas kolom agar menampilkan 4 produk per baris --}}
            <div class="col-lg-3 col-md-3 col-sm-6 mb-4">
                @include('partials.product-card', ['product' => $product])
            </div>
        @endforeach
    </div>
</div>
@else
    <p class="text-center mt-5 mb-5">bentar, produk rekomendasi bakal muncul kalau nambahin produk.</p>
@endif

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
            });
        });
        
        if(sizeOptions.length > 0) {
            sizeOptions[0].classList.add('active');
        }

        decreaseBtn.addEventListener('click', function() {
            let currentQty = parseInt(quantityInput.value);
            if (currentQty > 1) {
                quantityInput.value = currentQty - 1;
            }
        });

        increaseBtn.addEventListener('click', function() {
            let currentQty = parseInt(quantityInput.value);
            if (currentQty < stockValue) {
                quantityInput.value = currentQty + 1;
            }
        });

        mainImage.addEventListener('click', function() {
            zoomedImage.src = this.src;
            zoomedImageContainer.style.display = 'flex';
        });

        closeBtn.addEventListener('click', function() {
            zoomedImageContainer.style.display = 'none';
        });

        zoomedImageContainer.addEventListener('click', function(e) {
            if (e.target === this) {
                this.style.display = 'none';
            }
        });
    });
</script>
@endsection