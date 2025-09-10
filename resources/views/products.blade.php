@extends('layout.app')

<style>
    body {
        background-color: white !important;
    }
    
    .content-wrapper {
        padding-top: 3rem;
        padding-bottom: 3rem;
    }

     .product-card-wrapper {
        width: 100%;
        max-width: none;
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
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.5);
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
        font-size: 16px !important;
        font-weight: 500;
        color: black;
        margin-bottom: 0.25rem;
    }

    .product-price {
        font-size: 14px !important;
        font-weight: 500;
        color: #8B4513;
        margin-bottom: 0;
    }
</style>

@section('content')
<div class="content-wrapper">
    <div class="container">
        <!-- Tombol Filter -->
        <button class="btn btn-outline-dark mb-3" data-bs-toggle="offcanvas" data-bs-target="#filterSidebar">
            <i class="bi bi-sliders"></i> Filter
        </button>

        <div class="row">

          <!-- Produk -->
<div class="col-md-12">
    <div class="row g-3">
        @foreach($products as $product)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="product-card-wrapper">
                    @include('partials.product-card', ['product' => $product])
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>

        </div>
    </div>
</div>

<!-- Offcanvas untuk mobile -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="filterSidebar">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Filter Kategori</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        @include('partials.sidebar-categories')
    </div>
</div>
@endsection