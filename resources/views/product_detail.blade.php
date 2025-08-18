@extends('layout.app')

@section('content')
<style>
  .product-detail-section {
    padding: 80px 0;
    background-color: #ffffff;
  }

  .breadcrumb-nav {
    background: transparent;
    padding: 20px 0;
    margin-bottom: 0;
  }

  .breadcrumb {
    background: transparent;
    padding: 0;
    margin: 0;
  }

  .breadcrumb-item a {
    color: #422D1C;
    text-decoration: none;
  }

  .breadcrumb-item a:hover {
    color: #8B4513;
  }

  .breadcrumb-item.active {
    color: #666;
  }

  .product-gallery {
    position: relative;
  }

  .main-image {
    width: 100%;
    height: 500px;
    object-fit: cover;
    border-radius: 15px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
  }

  .thumbnail-gallery {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
  }

  .thumbnail {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
    cursor: pointer;
    border: 2px solid transparent;
    transition: all 0.3s ease;
  }

  .thumbnail:hover,
  .thumbnail.active {
    border-color: #422D1C;
    transform: scale(1.05);
  }

  .product-info {
    padding-left: 40px;
  }

  .product-title {
    color: #422D1C;
    font-weight: 700;
    font-size: 2.2rem;
    margin-bottom: 15px;
    line-height: 1.3;
  }

  .product-price {
    font-size: 2rem;
    font-weight: 700;
    color: #8B4513;
    margin-bottom: 20px;
  }

  .product-price-original {
    font-size: 1.3rem;
    color: #999;
    text-decoration: line-through;
    margin-right: 15px;
  }

  .discount-badge {
    background-color: #dc3545;
    color: white;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
    margin-left: 10px;
  }

  .product-description {
    color: #666;
    font-size: 1rem;
    line-height: 1.7;
    margin-bottom: 30px;
  }

  .product-options {
    margin-bottom: 30px;
  }

  .option-group {
    margin-bottom: 20px;
  }

  .option-label {
    font-weight: 600;
    color: #422D1C;
    margin-bottom: 10px;
    display: block;
  }

  .size-options {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
  }

  .size-option {
    width: 45px;
    height: 45px;
    border: 2px solid #ddd;
    background: white;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-weight: 600;
    color: #422D1C;
    transition: all 0.3s ease;
  }

  .size-option:hover,
  .size-option.active {
    border-color: #422D1C;
    background-color: #422D1C;
    color: white;
  }

  .color-options {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
  }

  .color-option {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    cursor: pointer;
    border: 3px solid transparent;
    transition: all 0.3s ease;
    position: relative;
  }

  .color-option:hover,
  .color-option.active {
    border-color: #422D1C;
    transform: scale(1.1);
  }

  .quantity-selector {
    display: flex;
    align-items: center;
    margin-bottom: 30px;
  }

  .quantity-label {
    font-weight: 600;
    color: #422D1C;
    margin-right: 15px;
  }

  .quantity-controls {
    display: flex;
    align-items: center;
    border: 2px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
  }

  .quantity-btn {
    background: #f8f9fa;
    border: none;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-weight: bold;
    color: #422D1C;
    transition: background-color 0.3s ease;
  }

  .quantity-btn:hover {
    background-color: #422D1C;
    color: white;
  }

  .quantity-input {
    border: none;
    width: 60px;
    height: 40px;
    text-align: center;
    font-weight: 600;
    color: #422D1C;
  }

  .quantity-input:focus {
    outline: none;
  }

  .action-buttons {
    display: flex;
    gap: 15px;
    margin-bottom: 30px;
  }

  .btn-add-cart-large {
    background-color: #422D1C;
    color: white;
    border: none;
    padding: 15px 40px;
    font-weight: 600;
    border-radius: 8px;
    transition: all 0.3s ease;
    font-size: 1.1rem;
    flex: 1;
  }

  .btn-add-cart-large:hover {
    background-color: #8B4513;
    transform: translateY(-2px);
    color: white;
  }

  .btn-buy-now {
    background-color: #8B4513;
    color: white;
    border: none;
    padding: 15px 40px;
    font-weight: 600;
    border-radius: 8px;
    transition: all 0.3s ease;
    font-size: 1.1rem;
    flex: 1;
  }

  .btn-buy-now:hover {
    background-color: #422D1C;
    transform: translateY(-2px);
    color: white;
  }

  .product-features {
    border-top: 1px solid #eee;
    padding-top: 30px;
  }

  .feature-item {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
  }

  .feature-icon {
    color: #422D1C;
    font-size: 1.2rem;
    margin-right: 15px;
  }

  .related-products {
    padding: 80px 0;
    background-color: #f8f9fa;
  }

  .section-title {
    text-align: center;
    color: #422D1C;
    font-weight: 700;
    font-size: 2rem;
    margin-bottom: 50px;
  }

  .product-card {
    border: 1px solid #e9ecef;
    overflow: hidden;
    transition: all 0.3s ease;
    background: white;
    height: 100%;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    border-radius: 10px;
  }

  .product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
    border-color: #422D1C;
  }

  .product-image-small {
    width: 100%;
    height: 250px;
    object-fit: cover;
    transition: transform 0.3s ease;
  }

  .product-card:hover .product-image-small {
    transform: scale(1.05);
  }

  .product-info-small {
    padding: 20px;
  }

  .product-title-small {
    font-size: 1rem;
    font-weight: 600;
    color: #422D1C;
    margin-bottom: 8px;
    line-height: 1.4;
  }

  .product-price-small {
    font-size: 1.1rem;
    font-weight: 700;
    color: #8B4513;
    margin-bottom: 15px;
  }

  .btn-add-cart-small {
    background-color: #f8f9fa;
    color: #422D1C;
    border: 2px solid #422D1C;
    padding: 8px 16px;
    border-radius: 6px;
    font-weight: 600;
    transition: all 0.3s ease;
    width: 100%;
    font-size: 0.9rem;
  }

  .btn-add-cart-small:hover {
    background-color: #422D1C;
    color: white;
    transform: translateY(-2px);
  }

  .stock-status {
    margin-bottom: 20px;
  }

  .in-stock {
    color: #28a745;
    font-weight: 600;
  }

  .out-of-stock {
    color: #dc3545;
    font-weight: 600;
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .product-info {
      padding-left: 0;
      margin-top: 30px;
    }

    .product-title {
      font-size: 1.8rem;
    }

    .product-price {
      font-size: 1.6rem;
    }

    .main-image {
      height: 400px;
    }

    .action-buttons {
      flex-direction: column;
    }

    .btn-add-cart-large,
    .btn-buy-now {
      width: 100%;
      margin-bottom: 10px;
    }
  }
</style>

<!-- Breadcrumb -->
<div class="breadcrumb-nav">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route('products') }}">Produk</a></li>
        <li class="breadcrumb-item active" aria-current="page" id="product-breadcrumb">Detail Produk</li>
      </ol>
    </nav>
  </div>
</div>

<!-- Product Detail Section -->
<div class="product-detail-section">
  <div class="container">
    <div class="row">
      <!-- Product Gallery -->
      <div class="col-lg-6">
        <div class="product-gallery">
          <img id="mainImage" src="" alt="Product Image" class="main-image">
          <div class="thumbnail-gallery">
            <img src="" alt="Thumbnail 1" class="thumbnail active" onclick="changeMainImage(this)">
            <img src="" alt="Thumbnail 2" class="thumbnail" onclick="changeMainImage(this)">
            <img src="" alt="Thumbnail 3" class="thumbnail" onclick="changeMainImage(this)">
            <img src="" alt="Thumbnail 4" class="thumbnail" onclick="changeMainImage(this)">
          </div>
        </div>
      </div>

      <!-- Product Info -->
      <div class="col-lg-6">
        <div class="product-info">
          <h1 class="product-title" id="productTitle">Loading...</h1>
          
          <div class="stock-status">
            <span class="in-stock">✓ Stok Tersedia</span>
          </div>

          <div class="product-price">
            <span id="productPrice">Rp 0</span>
            <span class="discount-badge">-15%</span>
          </div>

          <div class="product-description">
            <p id="productDescription">
              Baju adat tradisional Indonesia yang dibuat dengan kualitas premium menggunakan bahan berkualitas tinggi. 
              Cocok untuk acara formal, pernikahan, atau perayaan budaya. Didesain dengan detail yang memperhatikan 
              keaslian budaya Indonesia namun tetap nyaman digunakan.
            </p>
          </div>

          <!-- Size Options -->
          <div class="product-options">
            <div class="option-group">
              <label class="option-label">Ukuran:</label>
              <div class="size-options">
                <div class="size-option" data-size="S" onclick="selectSize('S')">S</div>
                <div class="size-option active" data-size="M" onclick="selectSize('M')">M</div>
                <div class="size-option" data-size="L" onclick="selectSize('L')">L</div>
                <div class="size-option" data-size="XL" onclick="selectSize('XL')">XL</div>
                <div class="size-option" data-size="XXL" onclick="selectSize('XXL')">XXL</div>
              </div>
            </div>

            <!-- Color Options -->
            <div class="option-group">
              <label class="option-label">Warna:</label>
              <div class="color-options">
                <div class="color-option active" data-color="default" onclick="selectColor('default')" 
                     style="background: linear-gradient(45deg, #8B4513, #D2691E);" title="Coklat Tradisional"></div>
                <div class="color-option" data-color="blue" onclick="selectColor('blue')" 
                     style="background: linear-gradient(45deg, #1e3a8a, #3b82f6);" title="Biru Klasik"></div>
                <div class="color-option" data-color="green" onclick="selectColor('green')" 
                     style="background: linear-gradient(45deg, #166534, #22c55e);" title="Hijau Emerald"></div>
                <div class="color-option" data-color="maroon" onclick="selectColor('maroon')" 
                     style="background: linear-gradient(45deg, #7f1d1d, #dc2626);" title="Merah Maroon"></div>
              </div>
            </div>
          </div>

          <!-- Quantity Selector -->
          <div class="quantity-selector">
            <span class="quantity-label">Jumlah:</span>
            <div class="quantity-controls">
              <button class="quantity-btn" onclick="decreaseQuantity()">-</button>
              <input type="number" id="quantity" class="quantity-input" value="1" min="1" max="10">
              <button class="quantity-btn" onclick="increaseQuantity()">+</button>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="action-buttons">
            <button class="btn btn-add-cart-large" onclick="addToCartDetail()">
              <i class="bi bi-cart-plus me-2"></i>Tambah ke Keranjang
            </button>
            <button class="btn btn-buy-now" onclick="buyNow()">
              <i class="bi bi-lightning-fill me-2"></i>Beli Sekarang
            </button>
          </div>

          <!-- Product Features -->
          <div class="product-features">
            <div class="feature-item">
              <i class="bi bi-truck feature-icon"></i>
              <span>Gratis ongkir untuk pembelian di atas Rp 500.000</span>
            </div>
            <div class="feature-item">
              <i class="bi bi-shield-check feature-icon"></i>
              <span>Garansi kualitas 30 hari</span>
            </div>
            <div class="feature-item">
              <i class="bi bi-arrow-repeat feature-icon"></i>
              <span>Mudah ditukar dalam 7 hari</span>
            </div>
            <div class="feature-item">
              <i class="bi bi-award feature-icon"></i>
              <span>Produk asli dari pengrajin terpercaya</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Product Details Tabs -->
<div class="container mb-5">
  <div class="row">
    <div class="col-12">
      <nav>
        <div class="nav nav-tabs justify-content-center" id="nav-tab" role="tablist">
          <button class="nav-link active" id="nav-description-tab" data-bs-toggle="tab" data-bs-target="#nav-description" 
                  style="color: #422D1C; border-color: #422D1C;">Deskripsi</button>
          <button class="nav-link" id="nav-size-tab" data-bs-toggle="tab" data-bs-target="#nav-size" 
                  style="color: #422D1C;">Panduan Ukuran</button>
          <button class="nav-link" id="nav-care-tab" data-bs-toggle="tab" data-bs-target="#nav-care" 
                  style="color: #422D1C;">Perawatan</button>
        </div>
      </nav>
      <div class="tab-content mt-4" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-description" role="tabpanel">
          <div class="p-4">
            <h5 style="color: #422D1C; font-weight: 600;">Detail Produk</h5>
            <p style="color: #666; line-height: 1.7;">
              Baju adat tradisional Indonesia yang menggabungkan keindahan warisan budaya dengan kenyamanan modern. 
              Dibuat dengan bahan berkualitas tinggi dan teknik tradisional yang telah diwariskan turun-temurun. 
              Setiap detail pada pakaian ini mencerminkan kekayaan budaya Nusantara yang memukau.
            </p>
            <ul style="color: #666;">
              <li>Bahan: Katun premium dengan motif tradisional</li>
              <li>Proses: Dibuat oleh pengrajin berpengalaman</li>
              <li>Kualitas: Tahan lama dan nyaman digunakan</li>
              <li>Cocok untuk: Acara formal, pernikahan, dan perayaan budaya</li>
            </ul>
          </div>
        </div>
        <div class="tab-pane fade" id="nav-size" role="tabpanel">
          <div class="p-4">
            <h5 style="color: #422D1C; font-weight: 600;">Panduan Ukuran</h5>
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead style="background-color: #f8f9fa;">
                  <tr>
                    <th>Ukuran</th>
                    <th>Lingkar Dada (cm)</th>
                    <th>Panjang (cm)</th>
                    <th>Lingkar Pinggang (cm)</th>
                  </tr>
                </thead>
                <tbody>
                  <tr><td>S</td><td>88-92</td><td>68</td><td>74-78</td></tr>
                  <tr><td>M</td><td>92-96</td><td>70</td><td>78-82</td></tr>
                  <tr><td>L</td><td>96-100</td><td>72</td><td>82-86</td></tr>
                  <tr><td>XL</td><td>100-104</td><td>74</td><td>86-90</td></tr>
                  <tr><td>XXL</td><td>104-108</td><td>76</td><td>90-94</td></tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="nav-care" role="tabpanel">
          <div class="p-4">
            <h5 style="color: #422D1C; font-weight: 600;">Panduan Perawatan</h5>
            <ul style="color: #666; line-height: 1.8;">
              <li>Cuci dengan tangan menggunakan deterjen lembut</li>
              <li>Hindari penggunaan pemutih</li>
              <li>Jemur di tempat teduh, hindari sinar matahari langsung</li>
              <li>Setrika dengan suhu sedang</li>
              <li>Simpan di tempat kering dengan gantungan</li>
              <li>Dry clean jika diperlukan untuk perawatan maksimal</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Related Products -->
<div class="related-products">
  <div class="container">
    <h2 class="section-title">Produk Serupa</h2>
    <div class="row" id="relatedProducts">
      <!-- Related products will be populated by JavaScript -->
    </div>
  </div>
</div>

<!-- JavaScript -->
<script>
// Data produk yang sama dengan halaman utama
const products = {
    1: { id: 1, name: "Batik Malang Pria", price: 399000, image: "{{ asset('storage/product_images/batik1.png') }}", category: "pria" },
    2: { id: 2, name: "Batik Malang Wanita", price: 349000, image: "{{ asset('storage/product_images/batik2.png') }}", category: "wanita" },
    3: { id: 3, name: "Batik Pekalongan Pria", price: 379000, image: "{{ asset('storage/product_images/batik1.png') }}", category: "pria" },
    4: { id: 4, name: "Batik Pekalongan Wanita", price: 399000, image: "{{ asset('storage/product_images/batik2.png') }}", category: "wanita" },
    5: { id: 5, name: "Batik Yogyakarta Pria", price: 229000, image: "{{ asset('storage/product_images/batik1.png') }}", category: "pria" },
    6: { id: 6, name: "Batik Yogyakarta Wanita", price: 259000, image: "{{ asset('storage/product_images/batik2.png') }}", category: "wanita" },
    7: { id: 7, name: "Batik Madura Pria", price: 319000, image: "{{ asset('storage/product_images/batik1.png') }}", category: "pria" },
    8: { id: 8, name: "Batik Madura Wanita", price: 269000, image: "{{ asset('storage/product_images/batik2.png') }}", category: "wanita" },
    9: { id: 9, name: "Batik Cirebon Pria", price: 389000, image: "{{ asset('storage/product_images/batik1.png') }}", category: "pria" },
    10: { id: 10, name: "Batik Cirebon Wanita", price: 329000, image: "{{ asset('storage/product_images/batik2.png') }}", category: "wanita" },
    11: { id: 11, name: "Batik Bali Pria", price: 349000, image: "{{ asset('storage/product_images/batik1.png') }}", category: "pria" },
    12: { id: 12, name: "Batik Bali Wanita", price: 299000, image: "{{ asset('storage/product_images/batik2.png') }}", category: "wanita" }
};

let currentProduct = null;
let selectedSize = 'M';
let selectedColor = 'default';

// Fungsi untuk mendapatkan ID produk dari URL
function getProductIdFromUrl() {
    const path = window.location.pathname;
    const matches = path.match(/\/product\/(\d+)/);
    return matches ? parseInt(matches[1]) : 1;
}

// Fungsi untuk load data produk
function loadProductData() {
    const productId = getProductIdFromUrl();
    currentProduct = products[productId];
    
    if (!currentProduct) {
        // Redirect ke halaman utama jika produk tidak ditemukan
        window.location.href = '/';
        return;
    }

    // Update informasi produk
    document.getElementById('productTitle').textContent = currentProduct.name;
    document.getElementById('productPrice').textContent = `Rp ${currentProduct.price.toLocaleString('id-ID')}`;
    document.getElementById('product-breadcrumb').textContent = currentProduct.name;

    // Update gambar utama dan thumbnails
    const mainImage = document.getElementById('mainImage');
    const thumbnails = document.querySelectorAll('.thumbnail');
    
    mainImage.src = currentProduct.image;
    mainImage.alt = currentProduct.name;
    
    // Set semua thumbnail dengan gambar yang sama (dalam implementasi nyata, ini bisa berbeda)
    thumbnails.forEach(thumb => {
        thumb.src = currentProduct.image;
        thumb.alt = currentProduct.name;
    });

    // Load produk serupa
    loadRelatedProducts();
}

// Fungsi untuk mengganti gambar utama
function changeMainImage(thumbnail) {
    const mainImage = document.getElementById('mainImage');
    mainImage.src = thumbnail.src;
    
    // Update active thumbnail
    document.querySelectorAll('.thumbnail').forEach(thumb => {
        thumb.classList.remove('active');
    });
    thumbnail.classList.add('active');
}

// Fungsi untuk memilih ukuran
function selectSize(size) {
    selectedSize = size;
    document.querySelectorAll('.size-option').forEach(option => {
        option.classList.remove('active');
    });
    document.querySelector(`[data-size="${size}"]`).classList.add('active');
}

// Fungsi untuk memilih warna
function selectColor(color) {
    selectedColor = color;
    document.querySelectorAll('.color-option').forEach(option => {
        option.classList.remove('active');
    });
    document.querySelector(`[data-color="${color}"]`).classList.add('active');
}

// Fungsi untuk mengatur jumlah
function increaseQuantity() {
    const input = document.getElementById('quantity');
    const currentValue = parseInt(input.value);
    if (currentValue < 10) {
        input.value = currentValue + 1;
    }
}

function decreaseQuantity() {
    const input = document.getElementById('quantity');
    const currentValue = parseInt(input.value);
    if (currentValue > 1) {
        input.value = currentValue - 1;
    }
}

// Fungsi untuk menambah ke keranjang dari detail produk
function addToCartDetail() {
    if (!currentProduct) return;
    
    const quantity = parseInt(document.getElementById('quantity').value);
    let cart = JSON.parse(localStorage.getItem('nusantara_cart')) || [];
    
    const existingItemIndex = cart.findIndex(item => 
        item.id === currentProduct.id && 
        item.size === selectedSize && 
        item.color === selectedColor
    );
    
    if (existingItemIndex > -1) {
        cart[existingItemIndex].quantity += quantity;
    } else {
        cart.push({
            id: currentProduct.id,
            name: currentProduct.name,
            price: currentProduct.price,
            image: currentProduct.image,
            quantity: quantity,
            size: selectedSize,
            color: selectedColor
        });
    }
    
    localStorage.setItem('nusantara_cart', JSON.stringify(cart));
    showAddToCartMessage(currentProduct.name, quantity);
    updateCartBadge();
}

// Fungsi beli sekarang
function buyNow() {
    addToCartDetail();
    // Redirect ke halaman checkout setelah delay singkat
    setTimeout(() => {
        window.location.href = '/checkout';
    }, 1000);
}

// Fungsi untuk load produk serupa
function loadRelatedProducts() {
    if (!currentProduct) return;
    
    const relatedContainer = document.getElementById('relatedProducts');
    const relatedProducts = Object.values(products)
        .filter(product => product.id !== currentProduct.id && product.category === currentProduct.category)
        .slice(0, 4);
    
    relatedContainer.innerHTML = relatedProducts.map(product => `
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="product-card" onclick="goToProductDetail(${product.id})">
                <img src="${product.image}" alt="${product.name}" class="product-image-small">
                <div class="product-info-small">
                    <h5 class="product-title-small">${product.name}</h5>
                    <p class="product-price-small">Rp ${product.price.toLocaleString('id-ID')}</p>
                    <button class="btn btn-add-cart-small" onclick="event.stopPropagation(); addToCartFromRelated(${product.id})">
                        Tambah ke Keranjang
                    </button>
                </div>
            </div>
        </div>
    `).join('');
}

// Fungsi untuk menambah produk serupa ke keranjang
function addToCartFromRelated(productId) {
    const product = products[productId];
    if (!product) return;
    
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
    showAddToCartMessage(product.name, 1);
    updateCartBadge();
}

// Fungsi untuk navigasi ke detail produk
function goToProductDetail(productId) {
    window.location.href = `/product/${productId}`;
}

// Fungsi untuk menampilkan pesan sukses
function showAddToCartMessage(productName, quantity) {
    const message = document.createElement('div');
    message.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: #28a745;
        color: white;
        padding: 15px 20px;
        border-radius: 8px;
        z-index: 9999;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    `;
    message.innerHTML = `
        <i class="bi bi-check-circle-fill me-2"></i>
        ${quantity}x ${productName} berhasil ditambahkan ke keranjang!
    `;
    
    document.body.appendChild(message);
    
    setTimeout(() => {
        if (message.parentNode) {
            document.body.removeChild(message);
        }
    }, 3000);
}

// Fungsi untuk update cart badge
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

// Fungsi untuk back to products
function backToProducts() {
    window.location.href = '/';
}

// Initialize saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    loadProductData();
    updateCartBadge();
    
    // Validasi input quantity
    const quantityInput = document.getElementById('quantity');
    quantityInput.addEventListener('input', function() {
        let value = parseInt(this.value);
        if (isNaN(value) || value < 1) {
            this.value = 1;
        } else if (value > 10) {
            this.value = 10;
        }
    });
    
    // Handle tab navigation
    const navTabs = document.querySelectorAll('.nav-link');
    navTabs.forEach(tab => {
        tab.addEventListener('shown.bs.tab', function(e) {
            // Reset active states
            navTabs.forEach(t => {
                t.style.backgroundColor = 'transparent';
                t.style.borderBottomColor = '#dee2e6';
            });
            
            // Set active tab style
            this.style.backgroundColor = '#422D1C';
            this.style.color = 'white';
            this.style.borderBottomColor = '#422D1C';
        });
    });
    
    // Set initial active tab style
    const activeTab = document.querySelector('.nav-link.active');
    if (activeTab) {
        activeTab.style.backgroundColor = '#422D1C';
        activeTab.style.color = 'white';
        activeTab.style.borderBottomColor = '#422D1C';
    }
});

// Handle browser back/forward buttons
window.addEventListener('popstate', function(event) {
    loadProductData();
});
</script>

@endsection