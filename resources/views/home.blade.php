@extends('layout.app')

@section('content')
<style>

  .hero-section {
    background: linear-gradient(135deg, #f8f9fa 0%, rgb(239, 229, 209) 100%);
    padding: 0;
    min-height: 600px;
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
    height: auto;
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
    min-width: 400px;
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
    height: 100%;
    margin: 50px auto;
    display: block;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
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
            <h1>Temukan baju batik yang cocok dengan dirimu di <span class="highlight">NusantaraShop</span></h1>
            <p>Kami menghadirkan koleksi baju batik pilihan yang dirancang untuk membuatmu terhubung dengan budaya lewat kenyamanan</p>
            @guest
            <a href="{{ route('register') }}" class="btn-primary-custom">Daftar Sekarang</a>
            <a href="{{ route('login') }}" class="btn-outline-custom">Masuk</a>
            @endguest
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
    
    <!-- Featured Products Row -->
    <div class="product-row">
      <div class="product-col">
        <div class="product-card">
          <img src="{{ asset('storage/product_images/batik1.png') }}" alt="Batik Kemeja Pria" class="product-image">
          <div class="product-info">
            <h5 class="product-title">Batik Malang Pria</h5>
            <p class="product-price">Rp 399.000</p>
            <button class="btn btn-add-cart" onclick="addToCart(1)">Tambah ke Keranjang</button>
          </div>
        </div>
      </div>
      
      <div class="product-col">
        <div class="product-card">
          <img src="{{ asset('storage/product_images/batik2.png') }}" alt="Batik Kemeja Lengan Panjang" class="product-image">
          <div class="product-info">
            <h5 class="product-title">Batik Malang Wanita</h5>
            <p class="product-price">Rp 349.000</p>
            <button class="btn btn-add-cart" onclick="addToCart(2)">Tambah ke Keranjang</button>
          </div>
        </div>
      </div>
      
      <div class="product-col">
        <div class="product-card">
          <img src="{{ asset('storage/product_images/batik1.png') }}" alt="Batik Kemeja Casual" class="product-image">
          <div class="product-info">
            <h5 class="product-title">Batik Pekalongan Pria</h5>
            <p class="product-price">Rp 379.000</p>
            <button class="btn btn-add-cart" onclick="addToCart(3)">Tambah ke Keranjang</button>
          </div>
        </div>
      </div>
      
      <div class="product-col">
        <div class="product-card">
          <img src="{{ asset('storage/product_images/batik2.png') }}" alt="Batik Kemeja Formal" class="product-image">
          <div class="product-info">
            <h5 class="product-title">Batik Pekalongan Wanita</h5>
            <p class="product-price">Rp 399.000</p>
            <button class="btn btn-add-cart" onclick="addToCart(4)">Tambah ke Keranjang</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Banner Discount -->
    <img src="{{ asset('storage/product_images/discount.png') }}" alt="Discount Banner" class="banner-discount">

    <!-- All Products Section -->
    <h2 class="section-title" style="margin-top: 80px;">Semua Produk</h2>
    
    <!-- First Row -->
    <div class="product-row">
      <div class="product-col">
        <div class="product-card">
          <img src="{{ asset('storage/product_images/batik1.png') }}" alt="Batik Kemeja Executive" class="product-image">
          <div class="product-info">
            <h5 class="product-title">Batik Yogyakarta Pria</h5>
            <p class="product-price">Rp 229.000</p>
            <button class="btn btn-add-cart" onclick="addToCart(5)">Tambah ke Keranjang</button>
          </div>
        </div>
      </div>
      
      <div class="product-col">
        <div class="product-card">
          <img src="{{ asset('storage/product_images/batik2.png') }}" alt="Batik Kemeja Premium" class="product-image">
          <div class="product-info">
            <h5 class="product-title">Batik Yogyakarta Wanita</h5>
            <p class="product-price">Rp 259.000</p>
            <button class="btn btn-add-cart" onclick="addToCart(6)">Tambah ke Keranjang</button>
          </div>
        </div>
      </div>
      
      <div class="product-col">
        <div class="product-card">
          <img src="{{ asset('storage/product_images/batik1.png') }}" alt="Batik Kemeja Classic" class="product-image">
          <div class="product-info">
            <h5 class="product-title">Batik Madura Pria</h5>
            <p class="product-price">Rp 319.000</p>
            <button class="btn btn-add-cart" onclick="addToCart(7)">Tambah ke Keranjang</button>
          </div>
        </div>
      </div>
      
      <div class="product-col">
        <div class="product-card">
          <img src="{{ asset('storage/product_images/batik2.png') }}" alt="Batik Kemeja Modern" class="product-image">
          <div class="product-info">
            <h5 class="product-title">Batik Madura Wanita</h5>
            <p class="product-price">Rp 269.000</p>
            <button class="btn btn-add-cart" onclick="addToCart(8)">Tambah ke Keranjang</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Second Row -->
    <div class="product-row">
      <div class="product-col">
        <div class="product-card">
          <img src="{{ asset('storage/product_images/batik1.png') }}" alt="Batik Kemeja Elegant" class="product-image">
          <div class="product-info">
            <h5 class="product-title">Batik Cirebon Pria</h5>
            <p class="product-price">Rp 389.000</p>
            <button class="btn btn-add-cart" onclick="addToCart(9)">Tambah ke Keranjang</button>
          </div>
        </div>
      </div>
      
      <div class="product-col">
        <div class="product-card">
          <img src="{{ asset('storage/product_images/batik2.png') }}" alt="Batik Kemeja Traditional" class="product-image">
          <div class="product-info">
            <h5 class="product-title">Batik Cirenbon Wanita</h5>
            <p class="product-price">Rp 329.000</p>
            <button class="btn btn-add-cart" onclick="addToCart(10)">Tambah ke Keranjang</button>
          </div>
        </div>
      </div>
      
      <div class="product-col">
        <div class="product-card">
          <img src="{{ asset('storage/product_images/batik1.png') }}" alt="Batik Kemeja Stylish" class="product-image">
          <div class="product-info">
            <h5 class="product-title">Batik Bali Pria</h5>
            <p class="product-price">Rp 349.000</p>
            <button class="btn btn-add-cart" onclick="addToCart(11)">Tambah ke Keranjang</button>
          </div>
        </div>
      </div>
      
      <div class="product-col">
        <div class="product-card">
          <img src="{{ asset('storage/product_images/batik2.png') }}" alt="Batik Kemeja Luxury" class="product-image">
          <div class="product-info">
            <h5 class="product-title">Batik Bali Wanita</h5>
            <p class="product-price">Rp 299.000</p>
            <button class="btn btn-add-cart" onclick="addToCart(12)">Tambah ke Keranjang</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Load More Button -->
    <div class="load-more-section">
      <button class="btn btn-primary-custom btn-lg">Lihat Semua Produk</button>
    </div>
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

<!-- JavaScript -->
<script>
// Data produk - sesuaikan dengan produk yang ada di halaman Anda
const products = {
    1: { id: 1, name: "Batik Malang Pria", price: 399000, image: "{{ asset('storage/product_images/batik1.png') }}" },
    2: { id: 2, name: "Baju Malang Wanita", price: 349000, image: "{{ asset('storage/product_images/batik2.png') }}" },
    3: { id: 3, name: "Batik Pekalongan Pria", price: 379000, image: "{{ asset('storage/product_images/batik1.png') }}" },
    4: { id: 4, name: "Baju Pekalongan Wanita", price: 399000, image: "{{ asset('storage/product_images/batik2.png') }}" },
    5: { id: 5, name: "Batik Yogyakarta Pria", price: 229000, image: "{{ asset('storage/product_images/batik1.png') }}" },
    6: { id: 6, name: "Batik Yogyakarta Wanita", price: 259000, image: "{{ asset('storage/product_images/batik2.png') }}" },
    7: { id: 7, name: "Batik Madura Pria", price: 319000, image: "{{ asset('storage/product_images/batik1.png') }}" },
    8: { id: 8, name: "Batik Madura Wanita", price: 269000, image: "{{ asset('storage/product_images/batik2.png') }}" },
    9: { id: 9, name: "Batik Cirebon Pria", price: 389000, image: "{{ asset('storage/product_images/batik1.png') }}" },
    10: { id: 10, name: "Batik Cirebon Wanita", price: 329000, image: "{{ asset('storage/product_images/batik2.png') }}" },
    11: { id: 11, name: "Batik Bali Pria", price: 349000, image: "{{ asset('storage/product_images/batik1.png') }}" },
    12: { id: 12, name: "Batik Bali Wanita", price: 299000, image: "{{ asset('storage/product_images/batik2.png') }}" }
};

// Function untuk menambahkan produk ke keranjang
function addToCart(productId) {
    const product = products[productId];
    if (!product) {
        console.error('Produk tidak ditemukan');
        return;
    }
    
    let cart = JSON.parse(localStorage.getItem('nusantara_cart')) || [];
    const existingItemIndex = cart.findIndex(item => item.id === productId);
    
    if (existingItemIndex > -1) {
        cart[existingItemIndex].quantity += 1;
    } else {
        cart.push({
            id: product.id,
            name: product.name,
            price: product.price,
            image: product.image,
            quantity: 1,
            size: 'M',
            color: 'default'
        });
    }
    
    localStorage.setItem('nusantara_cart', JSON.stringify(cart));
    showAddToCartMessage(product.name);
    updateCartBadge();
}

// Function untuk navigasi ke detail produk
function goToProductDetail(productId) {
    window.location.href = `/product/${productId}`;
}

// Function untuk show success message
function showAddToCartMessage(productName) {
    const message = document.createElement('div');
    message.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: #28a745;
        color: white;
        padding: 15px 20px;
        border-radius: 5px;
        z-index: 9999;
        font-weight: 600;
    `;
    message.textContent = `${productName} berhasil ditambahkan ke keranjang!`;
    
    document.body.appendChild(message);
    
    setTimeout(() => {
        if (message.parentNode) {
            document.body.removeChild(message);
        }
    }, 3000);
}

// Function untuk update cart badge
function getCartItemCount() {
    const cart = JSON.parse(localStorage.getItem('nusantara_cart')) || [];
    return cart.reduce((total, item) => total + item.quantity, 0);
}

function updateCartBadge() {
    const badge = document.getElementById('cartBadge');
    if (badge) {
        badge.textContent = getCartItemCount();
    }
}

// Initialize saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    updateCartBadge();
    
    // Tambahkan event listener ke semua product cards
    document.querySelectorAll('.product-card').forEach((card, index) => {
        // Tambahkan cursor pointer
        card.style.cursor = 'pointer';
        
        // Event listener untuk klik card
        card.addEventListener('click', function(e) {
            // Jangan redirect jika yang diklik adalah tombol add to cart
            if (e.target.closest('.btn-add-cart')) {
                e.stopPropagation();
                return;
            }
            
            // Redirect ke halaman detail (index + 1 karena ID mulai dari 1)
            const productId = index + 1;
            goToProductDetail(productId);
        });
    });
});

</script>

@endsection