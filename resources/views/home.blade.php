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
  }

  .btn-primary-custom:hover {
    background-color: #8B4513;
    border-color: #8B4513;
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
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
  }

  .collection-section {
    padding: 80px 0;
  }

  .section-title {
    color: #422D1C;
    font-weight: 700;
    font-size: 2rem;
    margin-bottom: 0.5rem;
  }

  .section-subtitle {
    color: #666;
    font-size: 1.1rem;
    margin-bottom: 3rem;
  }

  .product-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    overflow: hidden;
    height: 100%;
  }

  .product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
  }

  .product-card img {
    height: 280px;
    object-fit: cover;
    transition: transform 0.3s ease;
  }

  .product-card:hover img {
    transform: scale(1.05);
  }

  .product-card .card-body {
    padding: 1.5rem;
    text-align: center;
  }

  .product-title {
    color: #422D1C;
    font-weight: 600;
    font-size: 1.1rem;
    margin-bottom: 0.5rem;
  }

  .product-price {
    color: #8B4513;
    font-weight: 700;
    font-size: 1.2rem;
  }

  .empty-products {
    text-align: center;
    padding: 4rem 0;
  }

  .empty-products h4 {
    color: #422D1C;
    font-weight: 600;
    margin-bottom: 1rem;
  }

  .empty-products p {
    color: #666;
    font-size: 1.1rem;
  }

  @media (max-width: 768px) {
    .hero-content h1 {
      font-size: 2rem;
    }
    
    .hero-section {
      padding: 60px 0;
    }
    
    .collection-section {
      padding: 60px 0;
    }
    
    .section-title {
      font-size: 1.5rem;
    }
  }
</style>

<!-- Hero Section -->
<div class="hero-section">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6 hero-content">
        <h1>Temukan batik yang cocok dengan dirimu di <span style="color: #8B4513;">NusantaraShop</span></h1>
        <p>Kami menghadirkan koleksi batik pilihan yang dirancang untuk menunjang tampilmu dengan budaya dan kenyamanan.</p>
        <a href="{{ url('/products') }}" class="btn btn-primary-custom">Beli Sekarang</a>
      </div>
      <div class="col-lg-6 hero-image">
        <img src="{{ asset('storage/product_images/batik1.png') }}" alt="Batik Banner" class="img-fluid">
      </div>
    </div>
  </div>
</div>

<!-- Collection Section -->
<div class="collection-section">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="section-title">Koleksi Terbaru Kami</h2>
      <p class="section-subtitle">Temukan batik yang sesuai dengan gayamu</p>
    </div>
    
    <div class="row">
      @forelse ($products as $product)
        <div class="col-lg-3 col-md-6 mb-4">
          <div class="card product-card">
            <img src="{{ asset('storage/' . $product->primary_image) }}" class="card-img-top" alt="{{ $product->name }}">
            <div class="card-body">
              <h5 class="product-title">{{ $product->name }}</h5>
              <p class="product-price">IDR {{ number_format($product->price, 0, ',', '.') }}</p>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12">
          <div class="empty-products">
            <h4>Belum ada produk tersedia</h4>
            <p>Koleksi batik terbaru akan segera hadir. Silakan kembali lagi nanti!</p>
          </div>
        </div>
      @endforelse
    </div>
    
    @if($products->count() > 0)
      <div class="text-center mt-5">
        <a href="{{ url('/products') }}" class="btn btn-outline-dark btn-lg">Lihat Semua Koleksi</a>
      </div>
    @endif
  </div>
</div>

<!-- Features Section -->
<div class="py-5" style="background-color: #f8f9fa;">
  <div class="container">
    <div class="row">
      <div class="col-md-4 text-center mb-4">
        <div class="mb-3">
          <i class="bi bi-truck" style="font-size: 3rem; color: #422D1C;"></i>
        </div>
        <h5 style="color: #422D1C;">Pengiriman Gratis</h5>
        <p class="text-muted">Gratis ongkir untuk pembelian di atas Rp 500.000</p>
      </div>
      <div class="col-md-4 text-center mb-4">
        <div class="mb-3">
          <i class="bi bi-shield-check" style="font-size: 3rem; color: #422D1C;"></i>
        </div>
        <h5 style="color: #422D1C;">Kualitas Terjamin</h5>
        <p class="text-muted">Semua produk dipilih dengan standar kualitas tinggi</p>
      </div>
      <div class="col-md-4 text-center mb-4">
        <div class="mb-3">
          <i class="bi bi-headset" style="font-size: 3rem; color: #422D1C;"></i>
        </div>
        <h5 style="color: #422D1C;">Layanan 24/7</h5>
        <p class="text-muted">Customer service siap membantu Anda kapan saja</p>
      </div>
    </div>
  </div>
</div>

@endsection