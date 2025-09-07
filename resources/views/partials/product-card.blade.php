<style>
.product-card-wrapper {
    max-width: 250px;
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
    border: none;
    border-radius: 0;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    background: #ffffff;
    position: relative;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}

.minimalist-product-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}

.product-image-container {
    position: relative;
    width: 100%;
    aspect-ratio: 4 / 5;
    overflow: hidden;
}

.product-image-primary,
.product-image-secondary {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: opacity 0.4s ease;
}

.product-image-secondary {
    opacity: 0;
}

.minimalist-product-card:hover .product-image-primary {
    opacity: 0;
}

.minimalist-product-card:hover .product-image-secondary {
    opacity: 1;
}

.card-body-clean {
    padding: 1rem;
    text-align: center;
}

.product-title {
    font-size: 16px;
    font-weight: 500;
    color: black;
    margin-bottom: 0.25rem;
}

.product-price {
    font-size: 14px;
    font-weight: 500;
    color: #8B4513;
    margin-bottom: 0;
}

.original-price {
    text-decoration: line-through;
    color: #999;
    font-size: 12px;
    margin-right: 8px;
}

.discount-price {
    color: #e53935;
    font-weight: 600;
}

.discount-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    background-color: #e53935;
    color: white;
    font-size: 12px;
    font-weight: bold;
    padding: 4px 8px;
    border-radius: 4px;
    z-index: 10;
}

.price-container {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 5px;
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