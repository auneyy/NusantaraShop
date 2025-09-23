@extends('layout.app')

@section('content')
<style>
  /* Hero Carousel Styles - Compact Version */
  .hero-carousel {
    position: relative;
    height: 70vh;
    overflow: hidden;
    margin-bottom: 30px;
  }

  .hero-carousel .carousel-item {
    height: 70vh;
    position: relative;
  }

  .hero-carousel .carousel-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    transform: scale(1);
  }

  .hero-carousel .carousel-item.active img {
    transform: scale(1.02);
  }

  /* Dark overlay for better text readability */
  .hero-carousel .carousel-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.4);
    z-index: 1;
    transition: background-color 0.8s cubic-bezier(0.4, 0, 0.2, 1);
  }

  /* Carousel caption styling - Compact */
  .hero-carousel .carousel-caption {
    position: absolute;
    top: 55%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 2;
    text-align: center;
    width: 85%;
    max-width: 600px;
    padding: 15px;
  }

  .hero-carousel .carousel-caption h1 {
    font-size: 2.2rem;
    font-weight: 700;
    color: white;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
    margin-bottom: 0.8rem;
    line-height: 1.2;
  }

  .hero-carousel .carousel-caption p {
    font-size: 1rem;
    color: white;
    text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.7);
    margin-bottom: 1.2rem;
    font-weight: 400;
    line-height: 1.5;
  }

  /* Custom button styles - Compact with smoother animations */
  .btn-primary-custom {
    background-color: #422D1C;
    border-color: #422D1C;
    color: white;
    padding: 10px 24px;
    font-weight: 600;
    border-radius: 6px;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    margin-right: 10px;
    text-decoration: none;
    display: inline-block;
    font-size: 0.9rem;
    box-shadow: 0 3px 10px rgba(66, 45, 28, 0.3);
  }

  .btn-primary-custom:hover {
    background-color: #8B4513;
    border-color: #8B4513;
    transform: translateY(-3px);
    color: white;
    box-shadow: 0 8px 20px rgba(139, 69, 19, 0.4);
  }

  .btn-outline-custom {
    background-color: transparent;
    border: 2px solid white;
    color: white;
    padding: 8px 24px;
    font-weight: 600;
    border-radius: 6px;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    text-decoration: none;
    display: inline-block;
    font-size: 0.9rem;
    margin-left: 8px;
  }

  .btn-outline-custom:hover {
    background-color: white;
    color: #422D1C;
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(255, 255, 255, 0.3);
  }

  .btn-secondary-custom {
    background-color: rgba(255, 255, 255, 0.2);
    border: 2px solid rgba(255, 255, 255, 0.8);
    color: white;
    padding: 8px 24px;
    font-weight: 600;
    border-radius: 6px;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    text-decoration: none;
    display: inline-block;
    font-size: 0.9rem;
    backdrop-filter: blur(10px);
  }

  .btn-secondary-custom:hover {
    background-color: rgba(255, 255, 255, 0.9);
    color: #422D1C;
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(255, 255, 255, 0.3);
  }

  /* Custom carousel controls - Compact with smoother animations */
  .hero-carousel .carousel-control-prev,
  .hero-carousel .carousel-control-next {
    width: 40px;
    height: 40px;
    background-color: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    top: 50%;
    transform: translateY(-50%);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .hero-carousel .carousel-control-prev {
    left: 20px;
  }

  .hero-carousel .carousel-control-next {
    right: 20px;
  }

  .hero-carousel .carousel-control-prev:hover,
  .hero-carousel .carousel-control-next:hover {
    background-color: rgba(255, 255, 255, 0.25);
    transform: translateY(-50%) scale(1.08);
    box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2);
  }

  .hero-carousel .carousel-control-prev-icon,
  .hero-carousel .carousel-control-next-icon {
    width: 16px;
    height: 16px;
    background-size: contain;
  }

  /* Custom carousel indicators - Compact with smoother animations */
  .hero-carousel .carousel-indicators {
    bottom: 20px;
    margin-bottom: 0;
  }

  .hero-carousel .carousel-indicators button {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    margin: 0 4px;
    background-color: rgba(255, 255, 255, 0.5);
    border: 1px solid rgba(255, 255, 255, 0.8);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .hero-carousel .carousel-indicators button.active {
    background-color: white;
    transform: scale(1.4);
    box-shadow: 0 0 12px rgba(255, 255, 255, 0.8);
  }

  .hero-carousel .carousel-indicators button:hover {
    background-color: rgba(255, 255, 255, 0.8);
    transform: scale(1.2);
  }

  /* Animate.css integration - Smoother animations */
  .carousel-caption .animate__animated {
    animation-duration: 1.2s;
    animation-delay: 0.2s;
    animation-fill-mode: both;
    animation-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
  }

  .carousel-caption h1.animate__animated {
    animation-delay: 0.2s;
    animation-duration: 1s;
  }

  .carousel-caption p.animate__animated {
    animation-delay: 0.2s;
    animation-duration: 1s;
  }

  .carousel-caption .btn.animate__animated {
    animation-delay: 0.2s;
    animation-duration: 1s;
  }

  /* Additional smooth transitions with enhanced animations */
  .carousel-fade .carousel-item {
    opacity: 0;
    transition: opacity 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    transform: none;
  }

  .carousel-fade .carousel-item.active,
  .carousel-fade .carousel-item-next.carousel-item-start,
  .carousel-fade .carousel-item-prev.carousel-item-end {
    z-index: 1;
    opacity: 1;
  }

  .carousel-fade .active.carousel-item-start,
  .carousel-fade .active.carousel-item-end {
    z-index: 0;
    opacity: 0;
    transition: opacity 0s 0.8s;
  }

  /* Features Section */
  .features-section {
    padding: 80px 0;
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

  /* CTA Section */
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

  /* Product Section Styles */
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

  .products-container {
    max-width: 1200px;
    margin: 0 auto;
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
  }

  .load-more-section {
    text-align: center;
    margin: 50px 0;
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .hero-carousel {
      height: 60vh;
    }

    .hero-carousel .carousel-item {
      height: 60vh;
    }

    .hero-carousel .carousel-caption h1 {
      font-size: 1.8rem;
      margin-bottom: 0.6rem;
    }

    .hero-carousel .carousel-caption p {
      font-size: 0.9rem;
      margin-bottom: 1rem;
    }

    .btn-primary-custom,
    .btn-outline-custom,
    .btn-secondary-custom {
      display: block;
      width: 70%;
      margin: 8px auto;
      text-align: center;
      font-size: 0.85rem;
      padding: 8px 20px;
    }

    .hero-carousel .carousel-control-prev,
    .hero-carousel .carousel-control-next {
      width: 35px;
      height: 35px;
    }

    .hero-carousel .carousel-control-prev {
      left: 15px;
    }

    .hero-carousel .carousel-control-next {
      right: 15px;
    }

    .hero-carousel .carousel-control-prev-icon,
    .hero-carousel .carousel-control-next-icon {
      width: 14px;
      height: 14px;
    }

    .hero-carousel .carousel-indicators button {
      width: 6px;
      height: 6px;
      margin: 0 3px;
    }

    .features-section {
      padding: 60px 0;
    }

    .products-container {
      padding: 0 10px;
    }

    .product-image {
      height: 220px;
    }

    .product-info {
      padding: 15px;
    }
  }

  @media (max-width: 576px) {
    .hero-carousel {
      height: 55vh;
    }

    .hero-carousel .carousel-item {
      height: 55vh;
    }

    .hero-carousel .carousel-caption h1 {
      font-size: 1.5rem;
    }

    .hero-carousel .carousel-caption p {
      font-size: 0.85rem;
    }

    .hero-carousel .carousel-caption {
      width: 90%;
    }

    .btn-primary-custom,
    .btn-outline-custom,
    .btn-secondary-custom {
      width: 80%;
      font-size: 0.8rem;
      padding: 8px 16px;
    }
  }
</style>

<!-- Include Animate.css CDN for animations -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

<!-- Hero Slider -->
<div id="heroCarousel" class="carousel slide carousel-fade hero-carousel" data-bs-ride="carousel" data-bs-interval="5000">
  <div class="carousel-inner">

    <!-- Slide 1 -->
    <div class="carousel-item active">
      <img src="{{ asset('storage/product_images/macambatik.jpg') }}" class="d-block w-100" alt="Elegant Batik Collection">
      <div class="carousel-caption">
        <h1 class="animate__animated animate__fadeInDown">Temukan baju adat yang cocok dengan dirimu di NusantaraShop</h1>
        <p class="animate__animated animate__fadeInUp">Membuatmu terhubung dengan budaya lewat kenyamanan</p>
        <div class="animate__animated animate__fadeInUp">
          @guest
            <a href="{{ route('register') }}" class="btn btn-primary-custom">Daftar Sekarang</a>
            <a href="{{ route('login') }}" class="btn btn-outline-custom">Masuk</a>
          @endguest
          @auth
            <a href="{{ url('/products') }}" class="btn btn-primary-custom">Beli Sekarang</a>
          @endauth
        </div>
      </div>
    </div>

    <!-- Slide 2 -->
    <div class="carousel-item">
      <img src="{{ asset('storage/product_images/batik2.jpg') }}" class="d-block w-100" alt="Comfort and Style">
      <div class="carousel-caption">
        <h1 class="animate__animated animate__fadeInDown">Siap Menemani Momenmu</h1>
        <p class="animate__animated animate__fadeInUp">Dibuat dari bahan pilihan yang lembut dan tahan lama, batik kami siap nemenin setiap momenmu.</p>
      </div>
    </div>

    <!-- Slide 3 -->
    <!-- <div class="carousel-item">
      <img src="{{ asset('storage/product_images/batik2.jpg') }}" class="d-block w-100" alt="Batik for Every Moment">
      <div class="carousel-caption">
        <h1 class="animate__animated animate__fadeInDown">Warna, Motif, dan Cerita</h1>
        <p class="animate__animated animate__fadeInUp">Setiap goresan batik mempunyai makna, Setiap motif punya cerita, setiap helai membawa budaya.</p>
      </div>
    </div> -->

    
    <!-- Slide 4 -->
    <div class="carousel-item">
      <img src="{{ asset('storage/product_images/macambatik1.jpg') }}" class="d-block w-100" alt="Traditional Heritage">
      <div class="carousel-caption">
        <h1 class="animate__animated animate__fadeInDown">Saatnya Temukan Favoritmu</h1>
        <p class="animate__animated animate__fadeInUp">Setiap orang punya gaya unik. Yuk, cari yang paling cocok buat kamu di sini.</p>
      </div>
    </div>


  </div>

  <!-- Controls -->
  <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>

  <!-- Indicators -->
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <!-- <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button> -->
    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 4"></button>
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