@extends('layout.app')

@section('content')
<style>
  .hero-section {
    background: linear-gradient(135deg, #f8f9fa 0%,rgb(239, 229, 209) 100%);
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

  .product-price-original {
    font-size: 1rem;
    color: #999;
    text-decoration: line-through;
    margin-right: 10px;
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
    cursor: pointer;
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
    padding: 120px 0;
    text-align: center;
    margin: 60px 0;
    color: white;
    background: linear-gradient(135deg, var(--banner-color, #FFDD00) 0%, #8B4513 100%);
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
        <p>Temukan koleksi baju adat pilihan terbaik untuk menunjang gaya hidup modern Anda dengan sentuhan budaya Indonesia yang autentik.</p>
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
@if($latestProducts->count() > 0)
<div class="product-section">
  <div class="container">
    <h2 class="section-title">Koleksi Terbaru Kami</h2>
    <p class="section-subtitle">Temukan batik terbaru yang sesuai dengan gaya Anda</p>
    
    <div class="row">
      @foreach($latestProducts as $product)
      <div class="col-lg-3 col-md-6 mb-4">
        <div class="product-card">
          <img src="{{ asset('storage/product_images/' . $product->primary_image) }}" alt="{{ $product->name }}" class="product-image">
          <div class="product-info">
            <h5 class="product-title">{{ $product->name }}</h5>
            <div class="product-price">
              @if($product->harga_jual)
                <span class="product-price-original">{{ $product->formatted_harga }}</span>
                {{ 'Rp ' . number_format($product->harga_jual, 0, ',', '.') }}
              @else
                {{ $product->formatted_harga }}
              @endif
            </div>
            @auth
            <button class="btn btn-add-cart" data-id="{{ $product->id }}" onclick="addToCart(this)">
                Tambah ke Keranjang
            </button>
            @else
            <a href="{{ route('login') }}" class="btn btn-add-cart">Login untuk Belanja</a>
            @endauth
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>
@endif

<!-- Category Section -->
@if($categories->count() > 0)
<div class="category-section">
  <div class="container">
    <div class="row">
      @foreach($categories as $category)
      <div class="col-lg-4 mb-4">
      <div class="category-card" data-link="{{ route('products') }}?category={{ $category->slug }}" onclick="goToCategory(this)">
          <img src="{{ asset('storage/category_images/' . ($category->image_path ?? 'default-category.png')) }}" alt="{{ $category->name }}" class="category-image">
          <h3 class="category-title">{{ strtoupper($category->name) }}</h3>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>
@endif

<!-- Semua Produk Section -->
@if($allProducts->count() > 0)
<div class="product-section">
  <div class="container">
    <h2 class="section-title">Semua Produk</h2>
    
    <div class="row">
      @foreach($allProducts as $product)
      <div class="col-lg-3 col-md-6 mb-4">
        <div class="product-card">
          <img src="{{ asset('storage/product_images/' . $product->primary_image) }}" alt="{{ $product->name }}" class="product-image">
          <div class="product-info">
            <h5 class="product-title">{{ $product->name }}</h5>
            <div class="product-price">
              @if($product->harga_jual)
                <span class="product-price-original">{{ $product->formatted_harga }}</span>
                {{ 'Rp ' . number_format($product->harga_jual, 0, ',', '.') }}
              @else
                {{ $product->formatted_harga }}
              @endif
            </div>
            <button class="btn btn-add-cart" data-id="{{ $product->id }}" onclick="addToCart(this)">
          </div>
        </div>
      </div>
      @endforeach
    </div>

    <!-- Load More Button -->
    <div class="text-center mt-4">
      <a href="{{ route('products') }}" class="btn btn-primary-custom btn-lg">Lihat Semua Produk</a>
    </div>
  </div>
</div>
@endif

<!-- Discount Banner -->
@if($currentDiscount)
<div class="discount-banner">
  <div class="container">
    <h2 class="discount-title">{{ $currentDiscount->title }}</h2>
    <p class="discount-subtitle">{{ $currentDiscount->subtitle }}</p>
    <a href="{{ route('products') }}" class="btn btn-light-custom btn-lg">Belanja Sekarang</a>
  </div>
</div>
@endif

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

<script>
function addToCart(productId) {
    // Implementasi add to cart
    alert('Produk berhasil ditambahkan ke keranjang! (ID: ' + productId + ')');
    // Nanti bisa diintegrasikan dengan sistem cart yang sebenarnya
}
</script>

@endsection