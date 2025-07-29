@extends('layout.app')

@section('content')
<style>
  .hero-section {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 80px 0;
    min-height: 500px;
  }

  .hero-content h1 {
    color: #422D1C;
    font-weight: 700;
    font-size: 2.5rem;
    line-height: 1.2;
    margin-bottom: 1.5rem;
  }

  .hero-content p {
    color: #666;
    font-size: 1.1rem;
    line-height: 1.6;
    margin-bottom: 2rem;
  }

  .btn-primary-custom {
    background-color: #422D1C;
    border-color: #422D1C;
    color: white;
    padding: 12px 30px;
    font-weight: 600;
    border-radius: 8px;
    transition: all 0.3s ease;
    margin-right: 15px;
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
    padding: 12px 30px;
    font-weight: 600;
    border-radius: 8px;
    transition: all 0.3s ease;
    text-decoration: none;
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
    max-height: 500px;
    width: auto;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
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
    background-color: #422D1C;
    color: white;
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
    background-color: white;
    color: #422D1C;
    border: none;
    padding: 12px 30px;
    font-weight: 600;
    border-radius: 8px;
    transition: all 0.3s ease;
    margin-right: 15px;
  }

  .btn-light-custom:hover {
    background-color: #f8f9fa;
    color: #422D1C;
    transform: translateY(-2px);
  }

  .btn-outline-light-custom {
    background-color: transparent;
    border: 2px solid white;
    color: white;
    padding: 12px 30px;
    font-weight: 600;
    border-radius: 8px;
    transition: all 0.3s ease;
    text-decoration: none;
  }

  .btn-outline-light-custom:hover {
    background-color: white;
    color: #422D1C;
    transform: translateY(-2px);
  }

  /* New Product Section Styles */
  .product-section {
    padding: 60px 0;
    background-color: #fff;
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

  .product-card {
    border: 1px solid #e9ecef;
    border-radius: 10px;
    overflow: hidden;
    transition: all 0.3s ease;
    background: white;
    margin-bottom: 30px;
  }

  .product-card h5 {
    font-size: 16px;
  }

  .product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
  }

  .product-image {
    width: 100%;
    height: 250px;
    object-fit: cover;
    border-bottom: 1px solid #e9ecef;
  }

  .product-info {
    padding: 20px;
    text-align: center;
  }

  .product-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #422D1C;
    margin-bottom: 10px;
  }

  .product-price {
    font-size: 1.2rem;
    font-weight: 700;
    color: #8B4513;
    margin-bottom: 15px;
  }

  .btn-add-cart {
    background-color: #422D1C;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    font-weight: 600;
    transition: all 0.3s ease;
    width: 100%;
  }

  .btn-add-cart:hover {
    background-color: #8B4513;
    transform: translateY(-2px);
    color: white;
  }

  .category-section {
    padding: 60px 0;
    background-color: #f8f9fa;
  }

  .category-card {
    background: white;
    border-radius: 15px;
    padding: 40px;
    text-align: center;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    height: 100%;
  }

  .category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
  }

  .category-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: #422D1C;
    margin-bottom: 20px;
  }

  .category-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 10px;
    margin-bottom: 20px;
  }

  .discount-banner {
    background: linear-gradient(135deg, #422D1C 0%, #8B4513 100%);
    color: white;
    padding: 120px 0;
    text-align: center;
    margin: 60px 0;
  }

  .discount-title {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 20px;
  }

  .discount-subtitle {
    font-size: 1.2rem;
    opacity: 0.9;
  }

  @media (max-width: 768px) {
    .hero-content h1 {
      font-size: 2rem;
    }

    .hero-section {
      padding: 60px 0;
    }

    .features-section {
      padding: 60px 0;
    }

    .btn-primary-custom,
    .btn-outline-custom {
      display: block;
      width: 100%;
      margin-bottom: 10px;
      margin-right: 0;
    }

    .product-image {
      height: 200px;
    }

    .discount-title {
      font-size: 2rem;
    }
  }
</style>

<!-- Hero Section -->
<div class="hero-section">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6 hero-content">
        <h1>Selamat Datang di <span style="color: #8B4513;">NusantaraShop</span></h1>
        <p>Temukan koleksi batik pilihan terbaik untuk menunjang gaya hidup modern Anda dengan sentuhan budaya Indonesia yang autentik.</p>
        @guest
        <a href="{{ route('register') }}" class="btn btn-primary-custom">Daftar Sekarang</a>
        <a href="{{ route('login') }}" class="btn btn-outline-custom">Masuk</a>
        @endguest
      </div>
      <div class="col-lg-6 hero-image">
        <img src="{{ asset('storage/product_images/batik1.png') }}" alt="Batik Banner" class="img-fluid">
      </div>
    </div>
  </div>
</div>

<!-- Koleksi Terbaru Section -->
<div class="product-section">
  <div class="container">
    <h2 class="section-title">Koleksi Terbaru Kami</h2>
    <p class="section-subtitle">Temukan batik terbaru yang sesuai dengan gaya Anda</p>
    
    <div class="row">
      <div class="col-lg-3 col-md-6 mb-4">
        <div class="product-card">
          <img src="{{ asset('storage/product_images/batik2.png') }}" alt="Batik Kemeja Pria" class="product-image">
          <div class="product-info">
            <h5 class="product-title">Batik Kemeja Pria</h5>
            <p class="product-price">Rp 299.000</p>
            <button class="btn btn-add-cart">Tambah ke Keranjang</button>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 mb-4">
        <div class="product-card">
          <img src="{{ asset('storage/product_images/batik2.png') }}" alt="Batik Kemeja Lengan Panjang" class="product-image">
          <div class="product-info">
            <h5 class="product-title">Batik Kemeja Lengan Panjang</h5>
            <p class="product-price">Rp 349.000</p>
            <button class="btn btn-add-cart">Tambah ke Keranjang</button>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 mb-4">
        <div class="product-card">
          <img src="{{ asset('storage/product_images/batik2.png') }}" alt="Batik Kemeja Casual" class="product-image">
          <div class="product-info">
            <h5 class="product-title">Batik Kemeja Casual</h5>
            <p class="product-price">Rp 279.000</p>
            <button class="btn btn-add-cart">Tambah ke Keranjang</button>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 mb-4">
        <div class="product-card">
          <img src="{{ asset('storage/product_images/batik2.png') }}" alt="Batik Kemeja Formal" class="product-image">
          <div class="product-info">
            <h5 class="product-title">Batik Kemeja Formal</h5>
            <p class="product-price">Rp 399.000</p>
            <button class="btn btn-add-cart">Tambah ke Keranjang</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Category Section -->
<div class="category-section">
  <div class="container">
    <div class="row">
      <div class="col-lg-4 mb-4">
        <div class="category-card">
          <img src="{{ asset('storage/product_images/batik_pria.png') }}" alt="Batik Pria" class="category-image">
          <h3 class="category-title">BATIK PRIA</h3>
        </div>
      </div>
      <div class="col-lg-4 mb-4">
        <div class="category-card">
          <img src="{{ asset('storage/product_images/batik_wanita.png') }}" alt="Batik Wanita" class="category-image">
          <h3 class="category-title">BATIK WANITA</h3>
        </div>
      </div>
      <div class="col-lg-4 mb-4">
        <div class="category-card">
          <img src="{{ asset('storage/product_images/batik_pria.png') }}" alt="Batik Anak" class="category-image">
          <h3 class="category-title">BATIK ANAK</h3>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Semua Produk Section -->
<div class="product-section">
  <div class="container">
    <h2 class="section-title">Semua Produk</h2>
    
    <!-- First Row -->
    <div class="row">
      <div class="col-lg-3 col-md-6 mb-4">
        <div class="product-card">
          <img src="{{ asset('storage/product_images/batik2.png') }}" alt="Batik Kemeja Pria" class="product-image">
          <div class="product-info">
            <h5 class="product-title">Batik Kemeja Pria</h5>
            <p class="product-price">Rp 299.000</p>
            <button class="btn btn-add-cart">Tambah ke Keranjang</button>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 mb-4">
        <div class="product-card">
          <img src="{{ asset('storage/product_images/batik2.png') }}" alt="Batik Kemeja Lengan Panjang" class="product-image">
          <div class="product-info">
            <h5 class="product-title">Batik Kemeja Lengan Panjang</h5>
            <p class="product-price">Rp 349.000</p>
            <button class="btn btn-add-cart">Tambah ke Keranjang</button>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 mb-4">
        <div class="product-card">
          <img src="{{ asset('storage/product_images/batik2.png') }}" alt="Batik Kemeja Casual" class="product-image">
          <div class="product-info">
            <h5 class="product-title">Batik Kemeja Casual</h5>
            <p class="product-price">Rp 279.000</p>
            <button class="btn btn-add-cart">Tambah ke Keranjang</button>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 mb-4">
        <div class="product-card">
          <img src="{{ asset('storage/product_images/batik2.png') }}" alt="Batik Kemeja Formal" class="product-image">
          <div class="product-info">
            <h5 class="product-title">Batik Kemeja Formal</h5>
            <p class="product-price">Rp 399.000</p>
            <button class="btn btn-add-cart">Tambah ke Keranjang</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Second Row -->
    <div class="row">
      <div class="col-lg-3 col-md-6 mb-4">
        <div class="product-card">
          <img src="{{ asset('storage/product_images/batik2.png') }}" alt="Batik Kemeja Executive" class="product-image">
          <div class="product-info">
            <h5 class="product-title">Batik Kemeja Executive</h5>
            <p class="product-price">Rp 429.000</p>
            <button class="btn btn-add-cart">Tambah ke Keranjang</button>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 mb-4">
        <div class="product-card">
          <img src="{{ asset('storage/product_images/batik2.png') }}" alt="Batik Kemeja Premium" class="product-image">
          <div class="product-info">
            <h5 class="product-title">Batik Kemeja Premium</h5>
            <p class="product-price">Rp 459.000</p>
            <button class="btn btn-add-cart">Tambah ke Keranjang</button>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 mb-4">
        <div class="product-card">
          <img src="{{ asset('storage/product_images/batik2.png') }}" alt="Batik Kemeja Classic" class="product-image">
          <div class="product-info">
            <h5 class="product-title">Batik Kemeja Classic</h5>
            <p class="product-price">Rp 319.000</p>
            <button class="btn btn-add-cart">Tambah ke Keranjang</button>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 mb-4">
        <div class="product-card">
          <img src="{{ asset('storage/product_images/batik2.png') }}" alt="Batik Kemeja Modern" class="product-image">
          <div class="product-info">
            <h5 class="product-title">Batik Kemeja Modern</h5>
            <p class="product-price">Rp 369.000</p>
            <button class="btn btn-add-cart">Tambah ke Keranjang</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Load More Button -->
    <div class="text-center mt-4">
      <button class="btn btn-primary-custom btn-lg">Lihat Semua Produk</button>
    </div>
  </div>
</div>

<!-- Discount Banner -->
<div class="discount-banner">
  <div class="container">
    <h2 class="discount-title">DISKON 30%</h2>
    <p class="discount-subtitle">Dapatkan diskon hingga 30% untuk semua produk batik pilihan</p>
    <a href="#" class="btn btn-light-custom btn-lg">Belanja Sekarang</a>
  </div>
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
          <p class="text-muted">Nikmati pengiriman gratis untuk pembelian di atas Rp 500.000 ke seluruh Indonesia</p>
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