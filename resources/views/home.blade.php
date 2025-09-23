@extends('layout.app')

@section('content')
<style>

  .hero-section {
    background: linear-gradient(135deg, #f8f9fa 0%, rgb(239, 229, 209) 100%);
    padding: 0;
    min-height: 650px;
    display: flex;
    align-items: center;
    margin-bottom: 50px;
  }

  .hero-content h1 {
    color: #422D1C;
    font-weight: 800;
    font-size: 40px;
    line-height: 1.2;
    margin-bottom: 1.5rem;
  }

  .hero-content h1 .highlight {
    color: #8B4513;
  }

  .hero-content p {
    color: #666;
    font-weight: 600;
    font-size: 20px;
    line-height: 1.6;
    margin-bottom: 1rem;
    max-width: 90%;
  }

  .btn-primary-custom {
    background-color: #422D1C;
    border-color: #422D1C;
    color: white;
    padding: 15px 35px;
    font-weight: 600;
    border-radius: 8px;
    transition: all 0.3s ease;
    margin-right: 15px;
    text-decoration: none;
    display: inline-block;
    font-size: 1rem;
  }

  .btn-primary-custom:hover {
    background-color: #8B4513;
    border-color: #8B4513;
    transform: translateY(-2px);
    color: white;
  }

  .btn-outline-custom {
    background-color: transparent;
    border: 2px solid #422D1C;
    color: #422D1C;
    padding: 13px 35px;
    font-weight: 600;
    border-radius: 8px;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
    font-size: 1rem;
  }

  .btn-outline-custom:hover {
    background-color: #422D1C;
    color: white;
    transform: translateY(-2px);
  }

  .hero-image {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .hero-image img {
    width: 100%;
    height: 650px;
    object-fit: cover;
  }

  .hero-section .row {
    display: flex;
    align-items: center;
    gap: 0;
    flex-wrap: wrap;
    margin: 0;
  }

  .hero-section .hero-content {
    flex: 1;
    min-width: 300px;
    padding: 60px 40px;
  }

  .hero-section .hero-image {
    flex: 1;
    padding: 0;
  }

  .features-section {
    padding: 80px 0;
    background-color: #f8f9fa;
  }

  .feature-card {
    text-align: center;
    padding: 2rem;
    border-radius: 15px;
    background: white;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    height: 100%;
  }

  .feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
  }

  .feature-icon {
    font-size: 3rem;
    color: #422D1C;
    margin-bottom: 1rem;
  }

  .feature-title {
    color: #422D1C;
    font-weight: 600;
    font-size: 1.2rem;
    margin-bottom: 1rem;
  }

  .cta-section {
    background: linear-gradient(135deg, #f8f9fa 0%, rgb(239, 229, 209) 100%);
    color: #422D1C;
    padding: 60px 0;
    text-align: center;
  }

  .cta-section h2 {
    font-weight: 700;
    margin-bottom: 1rem;
  }

  .cta-section p {
    font-size: 1.1rem;
    margin-bottom: 2rem;
    opacity: 0.9;
  }

  .btn-light-custom {
    background-color: #422D1C;
    color: white;
    border: none;
    padding: 12px 30px;
    font-weight: 600;
    border-radius: 8px;
    transition: all 0.3s ease;
    margin-right: 15px;
  }

  .btn-light-custom:hover {
    background-color: #8B4513;
    color: white;
    transform: translateY(-2px);
  }

  .btn-outline-light-custom {
    background-color: transparent;
    border: 2px solid #422D1C;
    color: #422D1C;
    padding: 12px 30px;
    font-weight: 600;
    border-radius: 8px;
    transition: all 0.3s ease;
    text-decoration: none;
  }

  .btn-outline-light-custom:hover {
    background-color: #422D1C;
    color: white;
    transform: translateY(-2px);
  }

  /* Improved Product Section Styles */
  .products-section {
    padding: 20px 0;
    background-color: #ffffff;
  }

  .section-title {
    text-align: center;
    color: #422D1C;
    font-weight: 700;
    font-size: 2rem;
    margin-bottom: 50px;
  }

  .section-subtitle {
    text-align: center;
    color: #666;
    font-size: 1.1rem;
    margin-bottom: 50px;
    margin-top: -30px;
  }

  /* Product Cards Container with better spacing */
  .products-container {
    max-width: 1200px;
    margin: 0 auto;
  }

  .product-row {
    display: flex;
    flex-wrap: wrap;
    margin: -15px; /* Negative margin to offset column padding */
    justify-content: center;
  }

  .product-col {
    flex: 0 0 25%;
    max-width: 25%;
    padding: 15px; /* Consistent spacing around each product */
  }

  .product-card {
    border: 1px solid #e9ecef;
    overflow: hidden;
    transition: all 0.3s ease;
    background: white;
    height: 100%;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
  }

  .product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
    border-color: #422D1C;
  }

  .product-image {
    width: 100%;
    height: 280px;
    object-fit: cover;
    border-bottom: 1px solid #f0f0f0;
    transition: transform 0.3s ease;
  }

  .product-card:hover .product-image {
    transform: scale(1.05);
  }

  .product-info {
    padding: 20px;
  }

  .product-title {
    font-size: 14px;
    font-weight: 600;
    color: #422D1C;
    margin-bottom: 8px;
    line-height: 1.4;
  }

  .product-price {
    font-size: 1.2rem;
    font-weight: 700;
    color: #8B4513;
    margin-bottom: 15px;
  }

  .product-price-original {
    font-size: 1rem;
    color: #999;
    text-decoration: line-through;
    margin-right: 10px;
  }

  .btn-add-cart {
    background-color: #f8f9fa;
    color: #422D1C;
    border: 2px solid #422D1C;
    padding: 10px 20px;
    border-radius: 6px;
    font-weight: 600;
    transition: all 0.3s ease;
    width: 100%;
    font-size: 0.9rem;
  }

  .btn-add-cart:hover {
    background-color: #422D1C;
    color: white;
    transform: translateY(-2px);
  }

.banner-discount {
    width: 100%;
    height: auto;
    margin: 50px auto;
    display: block;
    max-width: 1200px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    border-radius: 15px;
}

  .load-more-section {
    text-align: center;
    margin: 50px 0;
  }

  /* Responsive Design */
  @media (max-width: 1200px) {
    .product-col {
      flex: 0 0 33.333333%;
      max-width: 33.333333%;
    }
  }

  @media (max-width: 768px) {
    .hero-content h1 {
      font-size: 2.2rem;
    }

    .hero-section {
      padding: 60px 0;
    }

    .features-section {
      padding: 60px 0;
    }

    .products-container {
      padding: 0 10px;
    }

    .product-row {
      margin: -10px;
    }

    .product-col {
      flex: 0 0 50%;
      max-width: 50%;
      padding: 10px;
    }

    .product-image {
      height: 220px;
    }

    .product-info {
      padding: 15px;
    }

    .btn-primary-custom,
    .btn-outline-custom {
      display: block;
      width: 100%;
      margin-bottom: 15px;
      margin-right: 0;
      text-align: center;
    }

    .hero-section .row {
      flex-direction: column;
      gap: 0;
      text-align: center;
      margin: 0;
    }

    .hero-content {
      min-width: auto;
      padding: 20px 20px !important;
      order: 2;
    }

    .hero-image {
      min-width: auto;
      order: 1; 
      padding: 0 !important;
    }

    .hero-content p {
      max-width: 100%;
    }
  }

  @media (max-width: 576px) {
    .product-col {
      flex: 0 0 100%;
      max-width: 100%;
    }
  }
</style>

<!-- Hero Section -->
<div class="hero-section">
    <div class="container-fluid p-0">
    <div class="row align-items-center">
      <div class="col-lg-6 hero-content">
    <h1>
        Temukan baju batik yang cocok dengan dirimu di 
        <span class="highlight">NusantaraShop</span>
    </h1>
    <p>
        Kami menghadirkan koleksi baju batik pilihan yang dirancang untuk membuatmu 
        terhubung dengan budaya lewat kenyamanan
    </p>

    @guest
        <a href="{{ route('register') }}" class="btn-primary-custom">Daftar Sekarang</a>
        <a href="{{ route('login') }}" class="btn-outline-custom">Masuk</a>
    @endguest

    @auth
        <a href="{{ url('/products') }}" class="btn-primary-custom">Beli Sekarang</a>
    @endauth
</div>
        <div class="col-lg-6 hero-image">
            <img src="{{ asset('storage/product_images/heroadat.png') }}" alt="Traditional Indonesian Clothing" class="img-fluid">
        </div>
    </div>
    </div>
</div>
    
<!-- Products Section -->
<div class="products-section">
  <div class="products-container">
    <h2 class="section-title">Koleksi Terbaru Kami</h2>
    
    <div class="row g-3">
      @foreach($products->take(4) as $product)
        <div class="col-6 col-md-3 mb-2">
          @include('partials.product-card', ['product' => $product])
        </div>
      @endforeach
    </div>
  </div>
</div>

<!-- Banner Discount -->
@if(isset($discountBanner) && $discountBanner->banner_image)
    <div class="banner-container text-center">
        <a href="{{ route('promo') }}">
            <img src="{{ $discountBanner->banner_image }}" 
                 alt="Discount Banner - {{ $discountBanner->title }}" 
                 class="banner-discount img-fluid"
                 style="width: 100%; object-fit: cover;">
        </a>
    </div>
@endif


   <!-- Products Section -->
<div class="products-section">
  <div class="products-container">
    <h2 class="section-title">Semua Produk</h2>
    
    <div class="row g-3">
      @foreach($products->take(8) as $product)
        <div class="col-6 col-md-3 mb-2">
          @include('partials.product-card', ['product' => $product])
        </div>
      @endforeach
    </div>
  </div>
</div>


<div class="load-more-section">
  <a href="{{ route('products.index') }}" class="btn btn-primary-custom btn-lg">
    Lihat Semua Produk
  </a>
</div>


<!-- Features Section -->
<div class="features-section">
  <div class="container">
    <div class="text-center mb-5">
      <h2 style="color: #422D1C; font-weight: 700;">Mengapa Memilih NusantaraShop?</h2>
      <p style="color: #666; font-size: 1.1rem;">Bergabunglah dengan ribuan pelanggan yang telah mempercayai kami</p>
    </div>

    <div class="row">
      <div class="col-md-4 mb-4">
        <div class="feature-card">
          <div class="feature-icon">
            <i class="bi bi-truck"></i>
          </div>
          <h5 class="feature-title">Pengiriman Gratis</h5>
          <p class="text-muted">Nikmati pengiriman gratis untuk pembelian di atas Rp 300.000 ke seluruh Indonesia</p>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="feature-card">
          <div class="feature-icon">
            <i class="bi bi-shield-check"></i>
          </div>
          <h5 class="feature-title">Kualitas Terjamin</h5>
          <p class="text-muted">Semua produk batik dipilih langsung dari pengrajin terpercaya dengan standar kualitas tinggi</p>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="feature-card">
          <div class="feature-icon">
            <i class="bi bi-headset"></i>
          </div>
          <h5 class="feature-title">Layanan 24/7</h5>
          <p class="text-muted">Tim customer service kami siap membantu Anda kapan saja untuk pengalaman berbelanja terbaik</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- CTA Section -->
<div class="cta-section">
  <div class="container">
    <h2>Siap Memulai Perjalanan Fashion Anda?</h2>
    <p>Bergabunglah dengan NusantaraShop dan temukan koleksi batik eksklusif yang akan membuat Anda tampil percaya diri</p>
    @guest
    <a href="{{ route('register') }}" class="btn btn-light-custom">Daftar Gratis</a>
    <a href="{{ route('login') }}" class="btn btn-outline-light-custom">Sudah Punya Akun?</a>
    @endguest
  </div>
</div>

@endsection