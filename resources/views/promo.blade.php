@extends('layout.app')

@section('content')
<style>
    .discount-hero {
    background-image: url('/storage/product_images/banner-promo.png');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    padding: 180px 0 120px 0;
    height: 70vh;
    min-height: 600px;
    text-align: center;
    position: relative;
    display: flex;
    align-items: center;
    overflow: hidden;
    }

    .discount-hero-content {
        position: relative;
        z-index: 2;
        max-width: 600px;
        margin: 0 auto;
    }

    .discount-hero-content h1 {
    color: #ffffff;
    font-weight: 700;
    font-size: 3.2rem;
    margin-bottom: 1.5rem;
    text-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
    position: relative;
    z-index: 2;
    letter-spacing: -0.02em;
  }

  .discount-hero-content p {
    color: rgba(248, 249, 250, 0.95);
    font-size: 1.25rem;
    font-weight: 300;
    max-width: 650px;
    margin: 0 auto;
    position: relative;
    z-index: 2;
    line-height: 1.7;
  }

    .discount-badge {
        display: inline-block;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        padding: 0.5rem 1.5rem;
        border-radius: 50px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        margin-bottom: 2rem;
    }

    .products-section {
        padding: 4rem 0;
        background: #f8fafc;
        min-height: 60vh;
    }

    .section-title {
        text-align: center;
        margin-bottom: 3rem;
    }

    .section-title h2 {
        font-size: 2.5rem;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 0.5rem;
    }

    .section-subtitle {
        color: #718096;
        font-size: 1.1rem;
        max-width: 500px;
        margin: 0 auto;
        line-height: 1.6;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }

    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        text-align: center;
        max-width: 500px;
        margin: 0 auto;
    }


    .empty-state h3 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 1rem;
    }

    .empty-state p {
        color: #ffffff;
        margin-bottom: 2rem;
        line-height: 1.6;
    }

    .cta-button {
        background: linear-gradient(135deg, #422D1C 0%, #8B4513 100%);
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 50px;
        color: white;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .cta-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(102, 126, 234, 0.4);
        color: white;
        text-decoration: none;
    }

    .discount-stats {
        display: flex;
        justify-content: center;
        gap: 3rem;
        margin-top: 2rem;
        flex-wrap: wrap;
    }

    .stat-item {
        text-align: center;
        color: rgba(255, 255, 255, 0.9);
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        display: block;
    }

    .stat-label {
        font-size: 0.9rem;
        opacity: 0.8;
    }

    .floating-shapes {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        overflow: hidden;
        pointer-events: none;
    }

    .shape {
        position: absolute;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .shape:nth-child(1) {
        width: 80px;
        height: 80px;
        top: 20%;
        left: 10%;
        animation: float 6s ease-in-out infinite;
    }

    .shape:nth-child(2) {
        width: 60px;
        height: 60px;
        top: 60%;
        right: 10%;
        animation: float 8s ease-in-out infinite reverse;
    }

    .shape:nth-child(3) {
        width: 40px;
        height: 40px;
        top: 80%;
        left: 20%;
        animation: float 7s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(180deg); }
    }

    @media (max-width: 768px) {
        .discount-hero {
            padding: 80px 0 60px 0;
            height: 60vh;
            min-height: 500px;
            background-attachment: scroll;
        }
        
        .discount-hero h1 {
            font-size: 2rem;
        }
        
        .section-title h2 {
            font-size: 2rem;
        }
        
        .discount-stats {
            gap: 1.5rem;
        }
        
        .products-grid {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }
    }
</style>

<!-- Hero Section -->
<section class="discount-hero">
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    
    <div class="discount-hero-content">
        <h1>Penawaran Terbaik</h1>
        <p class="lead mb-4">Dapatkan produk berkualitas dengan harga yang tak tertandingi</p>
        
    </div>
</section>

<!-- Products Section -->
<section class="products-section">
    <div class="container">
        @if($discountCount > 0)
            <div class="section-title">
                <h2>Produk Pilihan</h2>
                <p class="section-subtitle">
                    Jangan lewatkan kesempatan untuk mendapatkan produk favorit dengan harga spesial
                </p>
            </div>
            
            <div class="products-grid">
                @foreach($discountedProducts as $product)
                    {{-- Panggil partials product-card --}}
                    @include('partials.product-card', [
                        'product' => $product,
                        'activeDiscounts' => $activeDiscounts
                    ])
                @endforeach
            </div>
        @else
            <div class="section-title">
                <h2>Promo Akan Segera Hadir</h2>
                <p class="section-subtitle">
                    Kami sedang mempersiapkan penawaran menarik untuk Anda
                </p>
            </div>
            
            <div class="empty-state">
                <h3>Belum Ada Promo Aktif</h3>
                <p>
                    Maaf, saat ini belum ada produk yang sedang dalam masa promo. 
                    Pantau terus halaman ini untuk mendapatkan penawaran terbaik dari kami.
                </p>
                <a href="{{ route('products.index') }}" class="cta-button">
                    <i class="fas fa-shopping-bag me-2"></i>
                    Jelajahi Semua Produk
                </a>
            </div>
        @endif
    </div>
</section>
@endsection