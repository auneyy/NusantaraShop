<style>
.product-card-wrapper {
    max-width: 280px;
    margin: 0 auto;
}

.product-card-link {
    text-decoration: none;
    color: inherit;
    display: block;
}

.product-card-link:hover {
    text-decoration: none;
}

.minimalist-product-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 24px;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.23, 1, 0.320, 1);
    position: relative;
    box-shadow: 
        0 4px 20px rgba(0, 0, 0, 0.05),
        0 1px 3px rgba(0, 0, 0, 0.1);
}

.minimalist-product-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 
        0 20px 40px rgba(0, 0, 0, 0.1),
        0 8px 16px rgba(0, 0, 0, 0.08);
    border-color: rgba(255, 255, 255, 0.4);
}

.product-image-container {
    position: relative;
    width: 100%;
    aspect-ratio: 1;
    overflow: hidden;
    border-radius: 20px 20px 0 0;
}

.product-image-primary,
.product-image-secondary {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: all 0.6s cubic-bezier(0.23, 1, 0.320, 1);
}

.product-image-secondary {
    opacity: 0;
    transform: scale(1.1);
}

.minimalist-product-card:hover .product-image-primary {
    opacity: 0;
    transform: scale(0.95);
}

.minimalist-product-card:hover .product-image-secondary {
    opacity: 1;
    transform: scale(1);
}

.card-body-clean {
    padding: 24px 20px;
    text-align: center;
}

.product-title {
    font-size: 18px;
    font-weight: 600;
    color: #1a1a1a;
    margin-bottom: 12px;
    line-height: 1.3;
    letter-spacing: -0.02em;
}

.product-price {
    font-size: 16px;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0;
    letter-spacing: -0.01em;
}

.original-price {
    font-size: 14px;
    color: #a0aec0;
    text-decoration: line-through;
    font-weight: 400;
    margin-right: 8px;
}

.discount-price {
    font-size: 16px;
    color: #e53e3e;
    font-weight: 700;
    letter-spacing: -0.01em;
}

.discount-badge {
    position: absolute;
    top: 16px;
    left: 16px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    font-size: 11px;
    font-weight: 700;
    padding: 6px 12px;
    border-radius: 20px;
    z-index: 10;
    letter-spacing: 0.02em;
    text-transform: uppercase;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.price-container {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 8px;
    margin-top: 4px;
}

/* Additional modern touches */
.minimalist-product-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
    opacity: 0;
    transition: opacity 0.4s ease;
}

.minimalist-product-card:hover::before {
    opacity: 1;
}

/* Smooth loading animation */
.minimalist-product-card {
    animation: fadeInUp 0.6s cubic-bezier(0.23, 1, 0.320, 1);
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Enhanced placeholder image styling */
.d-flex.align-items-center.justify-content-center.bg-light {
    background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important;
    width: 100%;
    height: 100%;
    color: #cbd5e0;
}

.d-flex.align-items-center.justify-content-center.bg-light .fa-image {
    color: #cbd5e0 !important;
    font-size: 48px !important;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .product-card-wrapper {
        max-width: 250px;
    }
    
    .card-body-clean {
        padding: 20px 16px;
    }
    
    .product-title {
        font-size: 16px;
    }
    
    .product-price,
    .discount-price {
        font-size: 15px;
    }
}
</style>    

@php
// Pastikan Anda mengirimkan data diskon dari controller
// Contoh: $activeDiscounts = $discountController->getActiveDiscountsForProducts($products);
@endphp

<a href="{{ route('products.show', $product->slug) }}" class="product-card-link">
    <div class="product-card-wrapper">
        <div class="minimalist-product-card">
            <div class="product-image-container">
                @php
                    $primaryImage = $product->images->firstWhere('is_primary', true);
                    $secondaryImage = $product->images->firstWhere('is_primary', false);
                    $displayImage = $primaryImage ?? $product->images->first();
                    
                    // Cek apakah produk memiliki diskon aktif
                    $hasActiveDiscount = false;
                    $discountPercentage = 0;
                    $discountedPrice = $product->harga;
                    
                    if (isset($activeDiscounts)) {
                        foreach ($activeDiscounts as $discount) {
                            if ($discount->products->contains('id', $product->id)) {
                                $hasActiveDiscount = true;
                                $discountPercentage = $discount->percentage;
                                $discountedPrice = $product->harga - ($product->harga * $discount->percentage / 100);
                                break;
                            }
                        }
                    }
                @endphp
                
                @if($hasActiveDiscount)
                    <div class="discount-badge">-{{ $discountPercentage }}%</div>
                @endif
                
                @if($displayImage)
                    <img src="{{ $displayImage->image_path }}" 
                         alt="{{ $product->name }}"
                         class="product-image-primary">
                    @if($secondaryImage)
                        <img src="{{ $secondaryImage->image_path }}" 
                             alt="{{ $product->name }}"
                             class="product-image-secondary">
                    @endif
                @else
                    <div class="d-flex align-items-center justify-content-center bg-light" style="width: 100%; height: 100%;">
                        <i class="fas fa-image fa-3x text-muted"></i>
                    </div>
                @endif
            </div>

            <div class="card-body-clean">
                <h5 class="product-title">{{ $product->name }}</h5>
                <div class="price-container">
                    @if($hasActiveDiscount)
                        <span class="original-price">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                        <span class="discount-price">Rp {{ number_format($discountedPrice, 0, ',', '.') }}</span>
                    @else
                        <span class="product-price">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</a>