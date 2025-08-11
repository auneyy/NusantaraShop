@extends('layout.app')
@section('content')
<style>
  .cart-section {
    padding: 80px 0;
    background-color: #f8f9fa;
    min-height: 100vh;
  }

  .cart-container {
    background: white;
    border-radius: 15px;
    padding: 40px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
  }

  .cart-header {
    color: #422D1C;
    font-weight: 700;
    font-size: 2rem;
    margin-bottom: 30px;
    text-align: center;
    border-bottom: 3px solid #422D1C;
    padding-bottom: 20px;
  }

  .cart-item {
    border-bottom: 1px solid #e9ecef;
    padding: 25px 0;
    display: flex;
    align-items: center;
    gap: 20px;
    transition: all 0.3s ease;
  }

  .cart-item:hover {
    background-color: #f8f9fa;
    padding-left: 10px;
    border-radius: 10px;
  }

  .cart-item:last-child {
    border-bottom: none;
  }

  .cart-item-image {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
  }

  .cart-item-info {
    flex: 1;
  }

  .cart-item-title {
    font-weight: 600;
    color: #422D1C;
    font-size: 1.2rem;
    margin-bottom: 8px;
  }

  .cart-item-price {
    color: #8B4513;
    font-weight: 600;
    font-size: 1.1rem;
  }

  .quantity-controls {
    display: flex;
    align-items: center;
    gap: 15px;
    background: #f8f9fa;
    padding: 10px;
    border-radius: 10px;
  }

  .quantity-btn {
    background-color: #422D1C;
    color: white;
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-weight: bold;
    transition: all 0.3s ease;
  }

  .quantity-btn:hover {
    background-color: #8B4513;
    transform: scale(1.1);
  }

  .quantity-input {
    width: 60px;
    text-align: center;
    border: 2px solid #422D1C;
    border-radius: 8px;
    padding: 8px;
    font-weight: 600;
    color: #422D1C;
  }

  .remove-btn {
    background-color: #dc3545;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 600;
  }

  .remove-btn:hover {
    background-color: #c82333;
    transform: translateY(-2px);
  }

  .cart-summary {
    background: linear-gradient(135deg, #422D1C 0%, #8B4513 100%);
    color: white;
    border-radius: 15px;
    padding: 30px;
    margin-top: 30px;
  }

  .summary-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 25px;
    text-align: center;
  }

  .summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
    padding-bottom: 15px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.3);
    font-size: 1.1rem;
  }

  .summary-row:last-child {
    border-bottom: 2px solid white;
    font-weight: 700;
    font-size: 1.3rem;
    margin-bottom: 25px;
  }

  .checkout-btn {
    background-color: white;
    color: #422D1C;
    border: none;
    padding: 15px;
    width: 100%;
    border-radius: 10px;
    font-weight: 700;
    font-size: 1.2rem;
    transition: all 0.3s ease;
    text-transform: uppercase;
  }

  .checkout-btn:hover {
    background-color: #f8f9fa;
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
  }

  .empty-cart {
    text-align: center;
    padding: 80px 20px;
    color: #666;
  }

  .empty-cart i {
    font-size: 5rem;
    margin-bottom: 30px;
    color: #422D1C;
  }

  .empty-cart h3 {
    color: #422D1C;
    font-weight: 700;
    margin-bottom: 20px;
  }

  .continue-shopping-btn {
    background-color:rgb(232, 232, 232);
    color: black;
    border: none;
    padding: 15px 30px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
  }

  .continue-shopping-btn:hover {
    background-color: #8B4513;
    transform: translateY(-2px);
    color: white;
  }

  .back-btn {
    background-color: transparent;
    color: #422D1C;
    border: 2px solid #422D1C;
    padding: 12px 25px;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-block;
    margin-bottom: 20px;
  }

  .back-btn:hover {
    background-color: #422D1C;
    color: white;
    transform: translateY(-2px);
  }

  .icon {
    font-size: 1.2rem;
  }

  @media (max-width: 768px) {
    .cart-item {
      flex-direction: column;
      text-align: center;
      gap: 15px;
    }

    .cart-item-image {
      width: 80px;
      height: 80px;
    }

    .quantity-controls {
      justify-content: center;
    }
  }
</style>

<div class="cart-section">
  <div class="container">
    <a href="{{ url()->previous() }}" class="back-btn">
      <i class="bi bi-arrow-left"></i> Kembali Berbelanja
    </a>
    
    <div class="cart-container">
      <h2 class="cart-header">Keranjang Belanja</h2>
      
      <div id="cartItems">
        <!-- Cart items akan diisi oleh JavaScript -->
      </div>
      
      <div id="cartSummary" style="display: none;">
        <div class="cart-summary">
          <h4 class="summary-title">Ringkasan Pesanan</h4>
          <div class="summary-row">
            <span>Subtotal:</span>
            <span id="subtotal">Rp 0</span>
          </div>
          <div class="summary-row">
            <span>Ongkos Kirim:</span>
            <span id="shipping">Rp 15.000</span>
          </div>
          <div class="summary-row">
            <span>Total:</span>
            <span id="total">Rp 15.000</span>
          </div>
          <button class="checkout-btn" onclick="checkout()">
            <i class="bi bi-credit-card me-2"></i>
            Lanjutkan Pembayaran
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
// Format rupiah
function formatRupiah(number) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(number);
}

// Load dan render cart items
function loadCartItems() {
    const cart = JSON.parse(localStorage.getItem('nusantara_cart')) || [];
    const container = document.getElementById('cartItems');
    const summaryContainer = document.getElementById('cartSummary');
    
    if (cart.length === 0) {
        container.innerHTML = `
            <div class="empty-cart">
                <i class="bi bi-cart-x"></i>
                <h3>Keranjang Belanja Kosong</h3>
                <p>Belum ada produk yang ditambahkan ke keranjang</p>
                <a href="{{ url('/') }}" class="continue-shopping-btn">
                    Mulai Berbelanja
                </a>
            </div>
        `;
        summaryContainer.style.display = 'none';
        return;
    }
    
    summaryContainer.style.display = 'block';
    container.innerHTML = '';
    
    cart.forEach(item => {
        const cartItem = `
            <div class="cart-item">
                <img src="${item.image}" alt="${item.name}" class="cart-item-image">
                <div class="cart-item-info">
                    <div class="cart-item-title">${item.name}</div>
                    <div class="cart-item-price">${formatRupiah(item.price)}</div>
                </div>
                <div class="quantity-controls">
                    <button class="quantity-btn" onclick="updateQuantity(${item.id}, -1)">-</button>
                    <input type="number" value="${item.quantity}" class="quantity-input" readonly>
                    <button class="quantity-btn" onclick="updateQuantity(${item.id}, 1)">+</button>
                </div>
                <div class="cart-item-price">${formatRupiah(item.price * item.quantity)}</div>
                <button class="remove-btn" onclick="removeFromCart(${item.id})">
                    <i class="bi bi-trash me-1"></i>Hapus
                </button>
            </div>
        `;
        container.innerHTML += cartItem;
    });
    
    updateCartSummary();
}

// Update quantity
function updateQuantity(productId, change) {
    let cart = JSON.parse(localStorage.getItem('nusantara_cart')) || [];
    const itemIndex = cart.findIndex(item => item.id === productId);
    
    if (itemIndex > -1) {
        cart[itemIndex].quantity += change;
        
        if (cart[itemIndex].quantity <= 0) {
            cart.splice(itemIndex, 1);
        }
        
        localStorage.setItem('nusantara_cart', JSON.stringify(cart));
        loadCartItems();
    }
}

// Remove from cart
function removeFromCart(productId) {
    let cart = JSON.parse(localStorage.getItem('nusantara_cart')) || [];
    cart = cart.filter(item => item.id !== productId);
    localStorage.setItem('nusantara_cart', JSON.stringify(cart));
    loadCartItems();
}

// Update cart summary
function updateCartSummary() {
    const cart = JSON.parse(localStorage.getItem('nusantara_cart')) || [];
    const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    const shipping = subtotal > 0 ? 15000 : 0;
    const total = subtotal + shipping;
    
    document.getElementById('subtotal').textContent = formatRupiah(subtotal);
    document.getElementById('shipping').textContent = formatRupiah(shipping);
    document.getElementById('total').textContent = formatRupiah(total);
}

// Checkout function
function checkout() {
    const cart = JSON.parse(localStorage.getItem('nusantara_cart')) || [];
    
    if (cart.length === 0) {
        alert('Keranjang belanja masih kosong!');
        return;
    }
    
    // Simulasi proses checkout
    const total = document.getElementById('total').textContent;
    const orderDetails = cart.map(item => 
        `${item.name} (${item.quantity}x) - ${formatRupiah(item.price * item.quantity)}`
    ).join('\n');
    
    alert(`Terima kasih atas pesanan Anda!\n\nDetail Pesanan:\n${orderDetails}\n\nTotal: ${total}\n\nAnda akan diarahkan ke halaman pembayaran...`);
    
    // Dalam implementasi nyata, redirect ke payment gateway
    // window.location.href = '/payment';
}

// Load cart saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    loadCartItems();
});
</script>

@endsection