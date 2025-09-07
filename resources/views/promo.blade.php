@extends('layout.app')

@section('content')
<style>
    .discount-page-header {
        background: linear-gradient(135deg, #8B4513 0%, #422D1C 100%);
        color: white;
        padding: 3rem 0;
        text-align: center;
        margin-bottom: 2rem;
    }

    .discount-products-container {
        padding: 2rem 0;
    }

    .no-discount-products {
        text-align: center;
        padding: 3rem;
        background-color: #f8f9fa;
        border-radius: 8px;
    }

    .no-discount-products i {
        font-size: 3rem;
        color: #ccc;
        margin-bottom: 1rem;
    }

    .discount-count {
        font-weight: 600;
        color: #e53935;
    }
</style>

@extends('layout.app')

@section('content')
<div class="container discount-products-container">
    @if($discountCount > 0)
        <div class="row">
            @foreach($discountedProducts as $product)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    {{-- Panggil partials product-card --}}
                    @include('partials.product-card', [
                        'product' => $product,
                        'activeDiscounts' => $activeDiscounts
                    ])
                </div>
            @endforeach
        </div>
    @else
        <div class="no-discount-products">
            <i class="fas fa-tags"></i>
            <h3>Maaf, tidak ada produk diskon saat ini</h3>
            <p>Silakan cek kembali nanti untuk penawaran spesial dari kami</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">Lihat Semua Produk</a>
        </div>
    @endif
</div>
@endsection
