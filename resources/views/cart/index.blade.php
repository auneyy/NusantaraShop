@extends('layout.app')

@section('content')
<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .cart-container {
        padding: 2rem 0;
        min-height: 80vh;
    }

    .cart-main-section {
        background: white;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        padding: 0;
        margin-bottom: 2rem;
    }

    .cart-header-simple {
        padding: 1.5rem;
        border-bottom: 1px solid #e9ecef;
    }

    .cart-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #212529;
        margin: 0;
    }

    .cart-item-count {
        color: #6c757d;
        font-size: 0.9rem;
        margin: 0;
    }

    .cart-table {
        width: 100%;
        margin: 0;
    }

    .cart-table-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
    }

    .cart-table-header th {
        padding: 1rem 1.5rem;
        font-weight: 600;
        color: #495057;
        font-size: 0.9rem;
        text-align: left;
        border: none;
    }

    .cart-table-header th:last-child {
        text-align: center;
    }

    .cart-item-row {
        border-bottom: 1px solid #f1f3f4;
        transition: background-color 0.2s ease;
    }

    .cart-item-row:hover {
        background-color: #f8f9fa;
    }

    .cart-item-row:last-child {
        border-bottom: none;
    }

    .cart-item-row td {
        padding: 1.5rem;
        vertical-align: middle;
        border: none;
    }

    .product-detail {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .product-image {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid #e9ecef;
    }

    .product-info {
        flex: 1;
    }

    .product-name {
        font-weight: 600;
        color: #212529;
        margin: 0 0 0.25rem 0;
        font-size: 0.95rem;
    }

    .product-size {
        color: #6c757d;
        font-size: 0.85rem;
        margin: 0;
    }

    .quantity-cell {
        text-align: center;
    }

    .quantity-selector {
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e9ecef;
        border-radius: 4px;
        overflow: hidden;
        width: fit-content;
        margin: 0 auto;
    }

    .qty-btn-new {
        background: #f8f9fa;
        border: none;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #495057;
        font-weight: 600;
        transition: background-color 0.2s ease;
    }

    .qty-btn-new:hover {
        background: #e9ecef;
    }

    .qty-display {
        background: white;
        border: none;
        width: 50px;
        height: 32px;
        text-align: center;
        font-weight: 500;
        color: #212529;
        border-left: 1px solid #e9ecef;
        border-right: 1px solid #e9ecef;
    }

    .price-cell {
        text-align: right;
        font-weight: 600;
        color: #212529;
    }

    .total-cell {
        text-align: right;
        font-weight: 600;
        color: #212529;
    }

    .delete-btn {
        background: none;
        border: none;
        color: #dc3545;
        cursor: pointer;
        padding: 0.25rem;
        border-radius: 3px;
        transition: background-color 0.2s ease;
    }

    .delete-btn:hover {
        background: #f8d7da;
    }

    .continue-shopping-link {
        color: #422D1C;
        text-decoration: none;
        font-weight: 500;
        padding: 0.75rem 0;
        display: inline-block;
    }

    .continue-shopping-link:hover {
        color: #8B4513;
        text-decoration: none;
    }

    .summary-section {
        background: white;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        padding: 1.5rem;
        height: fit-content;
    }

    .summary-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #212529;
        margin: 0 0 1.5rem 0;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        color: #495057;
    }

    .summary-row:last-child {
        margin-bottom: 0;
    }

    .summary-label {
        font-size: 0.9rem;
    }

    .summary-value {
        font-weight: 500;
    }

    .delivery-section {
        margin: 1.5rem 0;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 6px;
    }

    .delivery-title {
        font-size: 0.9rem;
        font-weight: 600;
        color: #495057;
        margin: 0 0 0.5rem 0;
    }

    .delivery-option {
        display: flex;
        justify-content: space-between;
        color: #6c757d;
        font-size: 0.85rem;
        margin: 0;
    }

    .promo-section {
        margin: 1.5rem 0;
    }

    .promo-title {
        font-size: 0.9rem;
        font-weight: 600;
        color: #495057;
        margin: 0 0 0.75rem 0;
    }

    .promo-input-group {
        display: flex;
        gap: 0.5rem;
    }

    .promo-input {
        flex: 1;
        padding: 0.5rem 0.75rem;
        border: 1px solid #e9ecef;
        border-radius: 4px;
        font-size: 0.85rem;
    }

    .promo-btn {
        background: #8B4513;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 4px;
        font-size: 0.85rem;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .promo-btn:hover {
        background: #6d3410;
    }

    .total-section {
        border-top: 2px solid #e9ecef;
        padding-top: 1rem;
        margin-top: 1rem;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 1.1rem;
        font-weight: 700;
        color: #212529;
    }

    .checkout-btn {
        background: #8B4513;
        color: white;
        border: none;
        width: 100%;
        padding: 0.875rem;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        margin-top: 1.5rem;
        font-size: 0.95rem;
        transition: background-color 0.2s ease;
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }

    .checkout-btn:hover {
        background: #6d3410;
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

    .btn-brown {
    background-color: #422D1C;
    color: white;
    border: none;
    padding: 0.75rem 1.25rem;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.2s ease;
    text-decoration: none;
    display: inline-block;
}

.btn-brown:hover {
    background-color: #6d4c32; /* versi lebih terang/dark untuk hover */
    color: white;
    text-decoration: none;
}

    @media (max-width: 768px) {
        .cart-container {
            padding: 1rem 0;
        }
        
        .cart-table-header {
            display: none;
        }
        
        .cart-item-row {
            display: block;
            border-bottom: 1px solid #e9ecef;
            padding: 1rem;
        }
        
        .cart-item-row td {
            display: block;
            padding: 0.5rem 0;
            border: none;
        }
        
        .product-detail {
            margin-bottom: 1rem;
        }
        
        .quantity-cell,
        .price-cell,
        .total-cell {
            text-align: left;
        }
        
        .quantity-cell::before,
        .price-cell::before,
        .total-cell::before {
            content: attr(data-label);
            font-weight: 600;
            margin-right: 1rem;
            color: #495057;
        }
    }
</style>

<div class="cart-container">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="cart-main-section">
                    <div class="cart-header-simple">
                        <h2 class="cart-title">Keranjang</h2>
                        <p class="cart-item-count">{{ count($cartItems) }} Items</p>
                    </div>
                    
                    @if(count($cartItems) > 0)
                        <table class="cart-table">
                            <thead class="cart-table-header">
                                <tr>
                                    <th>Detail Produk</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartItems as $key => $item)
                                <tr class="cart-item-row" id="cart-item-{{ $key }}">
                                    <td>
                                        <div class="product-detail">
                                            <img src="{{ $item['product']->images->first()->image_path ?? 'path/to/placeholder.jpg' }}" 
                                                 alt="{{ $item['product']->name }}" class="product-image">
                                            <div class="product-info">
                                                <p class="product-name">{{ $item['product']->name }}</p>
                                                <p class="product-size">Ukuran: {{ $item['size'] }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="quantity-cell" data-label="Jumlah: ">
                                        <div class="quantity-selector">
                                            <button class="qty-btn-new" onclick="updateQuantity('{{ $key }}', -1)">-</button>
                                            <input type="text" class="qty-display" id="qty-{{ $key }}" 
                                                   value="{{ $item['quantity'] }}" readonly>
                                            <button class="qty-btn-new" onclick="updateQuantity('{{ $key }}', 1)">+</button>
                                        </div>
                                    </td>
                                    <td class="price-cell" data-label="Harga: ">
                                        Rp {{ number_format($item['product']->harga, 0, ',', '.') }}
                                    </td>
                                    <td class="total-cell" data-label="Total: ">
                                        <span id="item-total-{{ $key }}">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                                    </td>
                                    <td>
                                        <button class="delete-btn" onclick="removeItem('{{ $key }}')">
                                            <span style="color: red; font-weight: bold;">Hapus</span>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        <div style="padding: 1.5rem;">
                            <a href="{{ route('products.index') }}" class="continue-shopping-link">
                                ← Lanjutkan Belanja
                            </a>
                        </div>
                    @else
                        <div class="empty-cart">
                            <div class="empty-cart-icon">🛒</div>
                            <h4>Keranjang Belanja Kosong</h4>
                            <p>Belum ada produk dalam keranjang belanja Anda</p>
                            <a href="{{ route('products.index') }}" class="btn-brown">
                                Mulai Berbelanja
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            
            @if(count($cartItems) > 0)
            <div class="col-lg-4">
                <div class="summary-section">
                    <h3 class="summary-title">Rangkuman Pemesanan</h3>
                    
                    <div class="summary-row">
                        <span class="summary-label">Items {{ array_sum(array_column($cartItems, 'quantity')) }}</span>
                        <span class="summary-value" id="cart-subtotal">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="promo-section">
                        <p class="promo-title">Promo Code</p>
                        <div class="promo-input-group">
                            <input type="text" class="promo-input" placeholder="Masukkan kodemu">
                            <button class="promo-btn">Terapkan</button>
                        </div>
                    </div>
                    
                    <div class="total-section">
                        <div class="total-row">
                            <span>Total Harga</span>
                            <span id="cart-total">Rp {{ number_format($total + 15000, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                   <!-- UPDATED: Checkout button menuju halaman checkout -->
                   <a href="{{ route('checkout.index') }}" class="checkout-btn">
                        Lanjut Pembayaran
                   </a>
                </div>
            </div>
            @endif
        </div>
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
            // Update item total
            const itemTotal = document.getElementById('item-total-' + cartKey);
            itemTotal.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(data.item_subtotal);
            
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
</script>
@endsection