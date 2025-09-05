@extends('layout.app')

@section('content')
<style>
    body {
        background-color: #f8f9fa;
    }

    .cart-container {
        padding: 2rem 0;
        min-height: 80vh;
    }

    .cart-header {
        background: linear-gradient(135deg, #422D1C 0%, #8B4513 100%);
        color: white;
        padding: 1.5rem;
        border-radius: 10px 10px 0 0;
        margin-bottom: 0;
    }

    .cart-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 20px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
    }

    .cart-content {
        padding: 0;
    }

    .cart-item {
        padding: 1.5rem;
        border-bottom: 1px solid #e9ecef;
        transition: background-color 0.3s ease;
    }

    .cart-item:hover {
        background-color: #f8f9fa;
    }

    .cart-item:last-child {
        border-bottom: none;
    }

    .item-details {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .item-image {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
    }

    .item-info {
        flex: 1;
    }

    .item-name {
        font-weight: 600;
        color: #212529;
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
    }

    .item-specs {
        color: #6c757d;
        margin-bottom: 0.5rem;
    }

    .item-price {
        font-weight: 600;
        color: #422D1C;
        font-size: 1.1rem;
    }

    .quantity-controls {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 1rem;
    }

    .qty-btn {
        width: 35px;
        height: 35px;
        border: 1px solid #ccc;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border-radius: 4px;
        transition: all 0.3s ease;
    }

    .qty-btn:hover {
        background: #422D1C;
        color: white;
        border-color: #422D1C;
    }

    .qty-input {
        width: 60px;
        text-align: center;
        border: 1px solid #ccc;
        height: 35px;
        border-radius: 4px;
    }

    .remove-btn {
        background: #dc3545;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 0.5rem;
    }

    .remove-btn:hover {
        background: #c82333;
        transform: translateY(-1px);
    }

    .cart-summary {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 20px rgba(0,0,0,0.1);
        padding: 2rem;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
        padding: 0.5rem 0;
    }

    .summary-row.total {
        font-weight: bold;
        font-size: 1.2rem;
        color: #422D1C;
        border-top: 2px solid #e9ecef;
        padding-top: 1rem;
        margin-top: 1.5rem;
    }

    .checkout-btn {
        background: linear-gradient(135deg, #422D1C 0%, #8B4513 100%);
        border: none;
        color: white;
        font-size: 1.1rem;
        font-weight: 600;
        padding: 1rem 2rem;
        border-radius: 8px;
        width: 100%;
        transition: all 0.3s ease;
        margin-top: 1rem;
    }

    .checkout-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(66, 45, 28, 0.3);
    }

    .checkout-btn:disabled {
        background: #ccc;
        transform: none;
        box-shadow: none;
        cursor: not-allowed;
    }

    .continue-shopping {
        color: #422D1C;
        text-decoration: none;
        font-weight: 500;
        padding: 0.75rem 1.5rem;
        border: 2px solid #422D1C;
        border-radius: 8px;
        display: inline-block;
        margin-top: 1rem;
        width: 100%;
        text-align: center;
        transition: all 0.3s ease;
    }

    .continue-shopping:hover {
        background: #422D1C;
        color: white;
        text-decoration: none;
    }

    .empty-cart {
        text-align: center;
        padding: 3rem 1rem;
        color: #6c757d;
    }

    .empty-cart-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .clear-cart-btn {
        background: #dc3545;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.3s ease;
        float: right;
        margin-bottom: 1rem;
    }

    .clear-cart-btn:hover {
        background: #c82333;
    }

    @media (max-width: 768px) {
        .cart-container {
            padding: 1rem 0;
        }
        
        .item-details {
            flex-direction: column;
            text-align: center;
        }
        
        .item-image {
            margin-bottom: 1rem;
        }
        
        .quantity-controls {
            justify-content: center;
        }
        
        .summary-row {
            font-size: 0.9rem;
        }
        
        .cart-item {
            padding: 1rem;
        }
    }
</style>

<div class="cart-container">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="cart-card">
                    <div class="cart-header">
                        <h3 class="mb-0">🛒 Keranjang Belanja</h3>
                        <p class="mb-0">{{ count($cartItems) }} item dalam keranjang</p>
                    </div>
                    
                    <div class="cart-content">
                        @if(count($cartItems) > 0)
                            <button type="button" class="clear-cart-btn" onclick="clearCart()">
                                <i class="bi bi-trash"></i> Kosongkan Keranjang
                            </button>
                            <div class="clearfix"></div>
                            
                            @foreach($cartItems as $key => $item)
                            <div class="cart-item" id="cart-item-{{ $key }}">
                                <div class="item-details">
                                    <img src="{{ $item['product']->images->first()->image_path ?? 'path/to/placeholder.jpg' }}" 
                                         alt="{{ $item['product']->name }}" class="item-image">
                                    
                                    <div class="item-info">
                                        <div class="item-name">{{ $item['product']->name }}</div>
                                        <div class="item-specs">
                                            Ukuran: {{ $item['size'] }} | 
                                            Harga: Rp {{ number_format($item['product']->harga, 0, ',', '.') }}
                                        </div>
                                        <div class="item-price">
                                            Subtotal: Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                        </div>
                                        
                                        <div class="quantity-controls">
                                            <button type="button" class="qty-btn" onclick="updateQuantity('{{ $key }}', -1)">-</button>
                                            <input type="number" class="qty-input" id="qty-{{ $key }}" 
                                                   value="{{ $item['quantity'] }}" min="1" max="{{ $item['product']->stock_kuantitas }}" readonly>
                                            <button type="button" class="qty-btn" onclick="updateQuantity('{{ $key }}', 1)">+</button>
                                            
                                            <button type="button" class="remove-btn" onclick="removeItem('{{ $key }}')">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="empty-cart">
                                <div class="empty-cart-icon">🛒</div>
                                <h4>Keranjang Belanja Kosong</h4>
                                <p>Belum ada produk dalam keranjang belanja Anda</p>
                                <a href="{{ route('products.index') }}" class="btn btn-primary">
                                    Mulai Berbelanja
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if(count($cartItems) > 0)
        <div class="row">
            <div class="col-lg-8">
                <a href="{{ route('products.index') }}" class="continue-shopping">
                    ← Lanjut Berbelanja
                </a>
            </div>
            
            <div class="col-lg-4">
                <div class="cart-summary">
                    <h5 class="mb-3">📋 Ringkasan Pesanan</h5>
                    
                    <div class="summary-row">
                        <span>Subtotal ({{ array_sum(array_column($cartItems, 'quantity')) }} item)</span>
                        <span id="cart-subtotal">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="summary-row">
                        <span>Ongkos Kirim</span>
                        <span>Rp {{ number_format(15000, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="summary-row total">
                        <span>Total</span>
                        <span id="cart-total">Rp {{ number_format($total + 15000, 0, ',', '.') }}</span>
                    </div>
                    
                    <button type="button" class="checkout-btn" onclick="proceedToCheckout()">
                        <i class="bi bi-credit-card"></i> Lanjut ke Checkout
                    </button>
                    
                    <div class="text-center mt-3">
                        <small class="text-muted">
                            <i class="bi bi-shield-check"></i>
                            Belanja aman dan terpercaya
                        </small>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
function updateQuantity(cartKey, change) {
    const qtyInput = document.getElementById('qty-' + cartKey);
    const currentQty = parseInt(qtyInput.value);
    const newQty = currentQty + change;
    
    if (newQty < 1) return;
    
    // Show loading
    const cartItem = document.getElementById('cart-item-' + cartKey);
    cartItem.style.opacity = '0.6';
    
    fetch('/cart/update', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            cart_key: cartKey,
            quantity: newQty
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            qtyInput.value = newQty;
            // Update subtotal in the item
            const itemPrice = cartItem.querySelector('.item-price');
            itemPrice.innerHTML = 'Subtotal: Rp ' + new Intl.NumberFormat('id-ID').format(data.item_subtotal);
            
            // Update cart total
            updateCartSummary(data.cart_total);
        } else {
            alert(data.message);
        }
        cartItem.style.opacity = '1';
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengupdate keranjang');
        cartItem.style.opacity = '1';
    });
}

function removeItem(cartKey) {
    if (!confirm('Apakah Anda yakin ingin menghapus item ini dari keranjang?')) {
        return;
    }
    
    fetch('/cart/remove', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            cart_key: cartKey
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('cart-item-' + cartKey).remove();
            
            if (data.cart_count === 0) {
                location.reload(); // Reload to show empty cart
            } else {
                updateCartSummary(data.cart_total);
            }
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat menghapus item');
    });
}

function clearCart() {
    if (!confirm('Apakah Anda yakin ingin mengosongkan seluruh keranjang?')) {
        return;
    }
    
    fetch('/cart/clear', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Gagal mengosongkan keranjang');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan');
    });
}

function updateCartSummary(newTotal) {
    const subtotalElement = document.getElementById('cart-subtotal');
    const totalElement = document.getElementById('cart-total');
    
    if (subtotalElement && totalElement) {
        subtotalElement.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(newTotal);
        totalElement.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(newTotal + 15000);
    }
}

function proceedToCheckout() {
    window.location.href = '/checkout';
}
</script>
@endsection