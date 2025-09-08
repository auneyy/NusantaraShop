@extends('layout.app')

<style>
    body {
        background-color: white !important;
    }
    
    .content-wrapper {
        padding-top: 3rem;
        padding-bottom: 3rem;
    }

    /* Container dengan padding yang responsif */
    .container {
        padding-left: 20px !important;
        padding-right: 20px !important;
    }

    /* CSS product card yang digabungkan dan diperkuat dengan !important */
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

    /* Responsive margin fixes */
    @media (max-width: 1200px) {
        .container {
            padding-left: 25px !important;
            padding-right: 25px !important;
        }
    }

    @media (max-width: 768px) {
        .container {
            padding-left: 20px !important;
            padding-right: 20px !important;
        }
        
        /* Mengurangi gap pada mobile untuk memberikan ruang margin */
        .row.g-3 {
            --bs-gutter-x: 1rem !important;
        }
        
        .col-6 {
            padding-left: 8px !important;
            padding-right: 8px !important;
        }
    }

    @media (max-width: 576px) {
        .container {
            padding-left: 15px !important;
            padding-right: 15px !important;
        }
        
        .row.g-3 {
            --bs-gutter-x: 0.75rem !important;
        }
        
        .col-6 {
            padding-left: 6px !important;
            padding-right: 6px !important;
        }
        
        .content-wrapper {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }
    }

    @media (max-width: 480px) {
        .container {
            padding-left: 12px !important;
            padding-right: 12px !important;
        }
        
        .row.g-3 {
            --bs-gutter-x: 0.5rem !important;
        }
        
        .col-6 {
            padding-left: 4px !important;
            padding-right: 4px !important;
        }
    }

    /* Perbaikan untuk sidebar agar tidak mengganggu margin */
    @media (max-width: 768px) {
        .col-md-9 {
            width: 100% !important;
            max-width: 100% !important;
        }
    }
</style>

@section('content')
<div class="content-wrapper">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
            </div>
        </div>
    
        <div class="row g-3">
            <div class="col-md-3 d-none d-md-block">
                @include('partials.sidebar-categories')
            </div>
    
            <div class="col-md-9">
                <div class="row g-3">
                    @foreach($products as $product)
                        <div class="col-6 col-md-3 mb-2">
                            @include('partials.product-card', ['product' => $product])
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
@endsection