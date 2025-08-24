@extends('layout.app')
@section('content')
<style>
  .cart-section {
    padding: 40px 0;
    background-color: #f5f5f5;
    min-height: 100vh;
  }
  
  .cart-wrapper {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 30px;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
  }

  .cart-main {
    background: white;
    border-radius: 8px;
    padding: 30px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  }

  .cart-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 1px solid #e0e0e0;
  }

  .cart-title {
    font-size: 1.8rem;
    font-weight: 600;
    color: #333;
    margin: 0;
  }

  .cart-count {
    color: #666;
    font-size: 1rem;
  }

  .cart-items-header {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1fr;
    gap: 20px;
    padding: 15px 0;
    border-bottom: 1px solid #e0e0e0;
    margin-bottom: 20px;
  }

  .cart-items-header span {
    font-weight: 600;
    color: #666;
    font-size: 0.9rem;
    text-transform: uppercase;
  }

  .cart-item {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1fr;
    gap: 20px;
    align-items: center;
    padding: 20px 0;
    border-bottom: 1px solid #f0f0f0;
  }

  .cart-item:last-child {
    border-bottom: none;
  }

  .product-info {
    display: flex;
    align-items: center;
    gap: 15px;
  }

  .product-image {
    width: 80px;
    height: 80px;
    border-radius: 8px;
    object-fit: cover;
  }

  .product-details h4 {
    margin: 0 0 5px 0;
    font-size: 1.1rem;
    font-weight: 600;
    color: #333;
  }

  .product-details p {
    margin: 0;
    font-size: 0.9rem;
    color: #666;
  }

  /* Size Selection Styles */
  .size-selection {
    margin: 10px 0;
  }

  .size-label {
    font-size: 0.85rem;
    color: #666;
    margin-bottom: 5px;
    display: block;
  }

  .size-select {
    padding: 5px 8px;
    border: 1px solid #e0e0e0;
    border-radius: 4px;
    font-size: 0.85rem;
    background: white;
    cursor: pointer;
    min-width: 80px;
  }

  .size-select:focus {
    outline: none;
    border-color: #6c5ce7;
  }

  .current-size {
    font-size: 0.85rem;
    color: #666;
    margin-top: 5px;
  }

  .size-badge {
    display: inline-block;
    background: #f0f0f0;
    color: #666;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 500;
    margin-top: 3px;
  }

  .quantity-container {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .quantity-btn {
    background: #f0f0f0;
    border: none;
    width: 30px;
    height: 30px;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 1.2rem;
    color: #666;
    transition: all 0.2s ease;
  }

  .quantity-btn:hover {
    background: #e0e0e0;
  }

  .quantity-input {
    width: 50px;
    text-align: center;
    border: 1px solid #e0e0e0;
    border-radius: 4px;
    padding: 8px 5px;
    font-weight: 600;
  }

  .price {
    font-weight: 600;
    color: #333;
    font-size: 1.1rem;
  }

  .total-price {
    font-weight: 700;
    color: #333;
    font-size: 1.1rem;
  }

  .remove-link {
    color: #666;
    text-decoration: underline;
    font-size: 0.9rem;
    cursor: pointer;
    margin-top: 5px;
    display: block;
  }

  .remove-link:hover {
    color: #333;
  }

  .continue-shopping {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #666;
    text-decoration: none;
    font-size: 0.9rem;
    margin-top: 20px;
  }

  .continue-shopping:hover {
    color: #333;
  }

  /* Order Summary */
  .order-summary {
    background: white;
    border-radius: 8px;
    padding: 30px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    height: fit-content;
  }

  .summary-title {
    font-size: 1.3rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 25px;
  }

  .summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
    font-size: 0.95rem;
  }

  .summary-row.shipping {
    margin-bottom: 20px;
  }

  .shipping-select {
    width: 100%;
    padding: 10px;
    border: 1px solid #e0e0e0;
    border-radius: 4px;
    font-size: 0.9rem;
    margin-top: 5px;
  }

  .promo-section {
    margin: 25px 0;
  }

  .promo-title {
    font-size: 0.95rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 10px;
    text-transform: uppercase;
  }

  .promo-input-group {
    display: flex;
    gap: 10px;
  }

  .promo-input {
    flex: 1;
    padding: 10px;
    border: 1px solid #e0e0e0;
    border-radius: 4px;
    font-size: 0.9rem;
  }

  .apply-btn {
    background: #ff6b6b;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 0.9rem;
    text-transform: uppercase;
    font-weight: 600;
  }

  .apply-btn:hover {
    background: #ff5252;
  }

  .total-section {
    border-top: 1px solid #e0e0e0;
    padding-top: 20px;
    margin-top: 25px;
  }

  .total-row {
    display: flex;
    justify-content: space-between;
    font-size: 1.2rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 25px;
  }

  .checkout-btn {
    width: 100%;
    background: #6c5ce7;
    color: white;
    border: none;
    padding: 15px;
    border-radius: 6px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    text-transform: uppercase;
    transition: all 0.3s ease;
  }

  .checkout-btn:hover {
    background: #5f4fcf;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(108, 92, 231, 0.4);
  }

  .empty-cart {
    grid-column: 1 / -1;
    text-align: center;
    padding: 80px 20px;
    background: white;
    border-radius: 8px;
  }

  .empty-cart i {
    font-size: 4rem;
    color: #ddd;
    margin-bottom: 20px;
  }

  .empty-cart h3 {
    color: #666;
    margin-bottom: 15px;
  }

  .empty-cart p {
    color: #999;
    margin-bottom: 30px;
  }

  .start-shopping-btn {
    background: #6c5ce7;
    color: white;
    padding: 12px 30px;
    text-decoration: none;
    border-radius: 6px;
    font-weight: 600;
    display: inline-block;
    transition: all 0.3s ease;
  }

  .start-shopping-btn:hover {
    background: #5f4fcf;
    transform: translateY(-2px);
  }

  @media (max-width: 968px) {
    .cart-wrapper {
      grid-template-columns: 1fr;
      gap: 20px;
    }

    .cart-item {
      grid-template-columns: 1fr;
      gap: 15px;
      text-align: center;
    }

    .cart-items-header {
      display: none;
    }

    .product-info {
      flex-direction: column;
      text-align: center;
    }

    .quantity-container {
      justify-content: center;
    }
  }
</style>

<div class="cart-section">
  <div class="cart-wrapper">
    <div class="cart-main">
      <div class="cart-header">
        <h2 class="cart-title">Shopping Cart</h2>
        <span class="cart-count" id="itemCount">0 Items</span>
      </div>
      
      <div id="cartContent">
        <div class="cart-items-header">
          <span>Product Details</span>
          <span>Quantity</span>
          <span>Price</span>
          <span>Total</span>
        </div>
        
        <div id="cartItems">
          <!-- Cart items akan diisi oleh JavaScript -->
        </div>
      </div>
      
      <a href="{{ url('/') }}" class="continue-shopping">
        <i class="bi bi-arrow-left"></i>
        Continue Shopping
      </a>
    </div>

    <div class="order-summary">
      <h3 class="summary-title">Order Summary</h3>
      
      <div class="summary-row">
        <span>Items <span id="summaryItemCount">0</span></span>
        <span id="summarySubtotal">Rp 0</span>
      </div>
      
      <div class="summary-row shipping">
        <div style="width: 100%;">
          <span>Shipping</span>
          <select class="shipping-select" id="shippingSelect">
            <option value="15000">Standard Delivery - Rp 15.000</option>
            <option value="25000">Express Delivery - Rp 25.000</option>
            <option value="0">Free Shipping - Rp 0</option>
          </select>
        </div>
      </div>
      
      <div class="promo-section">
        <div class="promo-title">Promo Code</div>
        <div class="promo-input-group">
          <input type="text" class="promo-input" placeholder="Enter your code" id="promoInput">
          <button class="apply-btn" onclick="applyPromo()">Apply</button>
        </div>
      </div>
      
      <div class="total-section">
        <div class="total-row">
          <span>Total Cost</span>
          <span id="totalCost">Rp 0</span>
        </div>
        
        <button class="checkout-btn" onclick="checkout()">
          Checkout
        </button>
      </div>
    </div>
  </div>
</div>

<script>
const availableSizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];

function formatRupiah(number) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(number);
}

function getCartItemKey(productId, size) {
    return `${productId}_${size}`;
}

function loadCartItems() {
    const cart = JSON.parse(localStorage.getItem('nusantara_cart')) || [];
    const container = document.getElementById('cartItems');
    const itemCount = document.getElementById('itemCount');
    const summaryItemCount = document.getElementById('summaryItemCount');
    
    if (cart.length === 0) {
        document.querySelector('.cart-wrapper').innerHTML = `
            <div class="empty-cart">
                <i class="bi bi-cart-x"></i>
                <h3>Your cart is empty</h3>
                <p>Looks like you haven't added anything to your cart yet</p>
                <a href="{{ url('/') }}" class="start-shopping-btn">
                    Start Shopping
                </a>
            </div>
        `;
        return;
    }
    
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    itemCount.textContent = `${totalItems} Items`;
    summaryItemCount.textContent = totalItems;
    
    container.innerHTML = '';
    
    cart.forEach((item, index) => {
        if (!item.size) {
            item.size = 'M';
        }
        
        const sizeOptions = availableSizes.map(size => 
            `<option value="${size}" ${item.size === size ? 'selected' : ''}>${size}</option>`
        ).join('');
        
        const cartItem = `
            <div class="cart-item">
                <div class="product-info">
                    <img src="${item.image}" alt="${item.name}" class="product-image">
                    <div class="product-details">
                        <h4>${item.name}</h4>
                        <p>Premium Quality</p>
                        <div class="size-selection">
                            <label class="size-label">Size:</label>
                            <select class="size-select" onchange="changeSizeInCart(${index}, this.value)">
                                ${sizeOptions}
                            </select>
                        </div>
                        <span class="remove-link" onclick="removeFromCart(${index})">Remove</span>
                    </div>
                </div>
                <div class="quantity-container">
                    <button class="quantity-btn" onclick="updateQuantity(${index}, -1)">−</button>
                    <input type="number" value="${item.quantity}" class="quantity-input" readonly>
                    <button class="quantity-btn" onclick="updateQuantity(${index}, 1)">+</button>
                </div>
                <div class="price">${formatRupiah(item.price)}</div>
                <div class="total-price">${formatRupiah(item.price * item.quantity)}</div>
            </div>
        `;
        container.innerHTML += cartItem;
    });
    
    updateOrderSummary();
}

function changeSizeInCart(itemIndex, newSize) {
    let cart = JSON.parse(localStorage.getItem('nusantara_cart')) || [];
    
    if (itemIndex >= 0 && itemIndex < cart.length) {
        const item = cart[itemIndex];
        
        const existingItemIndex = cart.findIndex((cartItem, index) => 
            index !== itemIndex && 
            cartItem.id === item.id && 
            cartItem.size === newSize
        );
        
        if (existingItemIndex !== -1) {
            cart[existingItemIndex].quantity += item.quantity;
            cart.splice(itemIndex, 1);
        } else {
            cart[itemIndex].size = newSize;
        }
        
        localStorage.setItem('nusantara_cart', JSON.stringify(cart));
        loadCartItems();
    }
}

function updateQuantity(itemIndex, change) {
    let cart = JSON.parse(localStorage.getItem('nusantara_cart')) || [];
    
    if (itemIndex >= 0 && itemIndex < cart.length) {
        cart[itemIndex].quantity += change;
        
        if (cart[itemIndex].quantity <= 0) {
            cart.splice(itemIndex, 1);
        }
        
        localStorage.setItem('nusantara_cart', JSON.stringify(cart));
        loadCartItems();
    }
}

// Remove from cart menggunakan index
function removeFromCart(itemIndex) {
    let cart = JSON.parse(localStorage.getItem('nusantara_cart')) || [];
    
    if (itemIndex >= 0 && itemIndex < cart.length) {
        cart.splice(itemIndex, 1);
        localStorage.setItem('nusantara_cart', JSON.stringify(cart));
        loadCartItems();
    }
}

// Update order summary
function updateOrderSummary() {
    const cart = JSON.parse(localStorage.getItem('nusantara_cart')) || [];
    const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    const shippingSelect = document.getElementById('shippingSelect');
    const shipping = parseInt(shippingSelect.value) || 0;
    const total = subtotal + shipping;
    
    document.getElementById('summarySubtotal').textContent = formatRupiah(subtotal);
    document.getElementById('totalCost').textContent = formatRupiah(total);
}

// Apply promo code
function applyPromo() {
    const promoInput = document.getElementById('promoInput');
    const promoCode = promoInput.value.trim().toUpperCase();
    
    if (promoCode === 'DISKON10') {
        alert('Promo code applied! 10% discount');
        // Implementasi diskon bisa ditambahkan di sini
    } else if (promoCode === '') {
        alert('Please enter a promo code');
    } else {
        alert('Invalid promo code');
    }
    
    promoInput.value = '';
}

// Checkout function
function checkout() {
    const cart = JSON.parse(localStorage.getItem('nusantara_cart')) || [];
    
    if (cart.length === 0) {
        alert('Your cart is empty!');
        return;
    }
    
    const total = document.getElementById('totalCost').textContent;
    const orderDetails = cart.map(item => 
        `${item.name} - Size: ${item.size} (${item.quantity}x) - ${formatRupiah(item.price * item.quantity)}`
    ).join('\n');
    
    alert(`Thank you for your order!\n\nOrder Details:\n${orderDetails}\n\nTotal: ${total}\n\nRedirecting to payment...`);
    
    // Dalam implementasi nyata, redirect ke payment gateway
    // window.location.href = '/payment';
}

// Function helper untuk add to cart dari halaman lain (dengan size)
function addToCart(product, selectedSize = 'M') {
    let cart = JSON.parse(localStorage.getItem('nusantara_cart')) || [];
    
    // Cari item yang sudah ada dengan id dan size yang sama
    const existingItemIndex = cart.findIndex(item => 
        item.id === product.id && item.size === selectedSize
    );
    
    if (existingItemIndex !== -1) {
        // Jika sudah ada, tambah quantity
        cart[existingItemIndex].quantity += 1;
    } else {
        // Jika belum ada, tambah item baru dengan size
        const newItem = {
            ...product,
            size: selectedSize,
            quantity: 1
        };
        cart.push(newItem);
    }
    
    localStorage.setItem('nusantara_cart', JSON.stringify(cart));
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    loadCartItems();
    
    // Update total when shipping changes
    document.getElementById('shippingSelect').addEventListener('change', updateOrderSummary);
});
</script>

@endsection