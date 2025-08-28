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
</style>

<a href="{{ route('products_show', $product->slug) }}" class="product-card-link">
    <div class="product-card-wrapper">
        <div class="minimalist-product-card">
            <div class="product-image-container">
                @php
                    $primaryImage = $product->images->firstWhere('is_primary', true);
                    $secondaryImage = $product->images->firstWhere('is_primary', false);
                    $displayImage = $primaryImage ?? $product->images->first();
                @endphp
                
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
                <p class="product-price">
                    Rp {{ number_format($product->harga, 0, ',', '.') }}
                </p>
            </div>
        </div>
    </div>
</a>