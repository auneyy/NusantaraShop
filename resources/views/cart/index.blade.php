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

    /* Modern Alert Styles */
    .modern-alert-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(5px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    .modern-alert-overlay.show {
        opacity: 1;
        visibility: visible;
    }

    .modern-alert-box {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        max-width: 400px;
        width: 90%;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        transform: scale(0.9) translateY(20px);
        transition: all 0.3s ease;
        text-align: center;
    }

    .modern-alert-overlay.show .modern-alert-box {
        transform: scale(1) translateY(0);
    }

    .alert-icon {
        width: 60px;
        height: 60px;
        margin: 0 auto 1.5rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .alert-icon.warning {
        background: linear-gradient(135deg, #ff6b6b, #ff8e8e);
        color: white;
    }

    .alert-icon.success {
        background: linear-gradient(135deg, #51cf66, #69db7c);
        color: white;
    }

    .alert-icon.error {
        background: linear-gradient(135deg, #ff6b6b, #ff5252);
        color: white;
    }

    .alert-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #212529;
        margin-bottom: 0.5rem;
    }

    .alert-message {
        color: #6c757d;
        margin-bottom: 1.5rem;
        line-height: 1.5;
    }

    .alert-buttons {
        display: flex;
        gap: 0.75rem;
        justify-content: center;
    }

    .alert-btn {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 0.9rem;
    }

    .alert-btn.primary {
        background: #dc3545;
        color: white;
    }

    .alert-btn.primary:hover {
        background: #c82333;
        transform: translateY(-2px);
    }

    .alert-btn.secondary {
        background: #f8f9fa;
        color: #495057;
        border: 1px solid #e9ecef;
    }

    .alert-btn.secondary:hover {
        background: #e9ecef;
        transform: translateY(-2px);
    }

    /* Toast Notification */
    .toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 10000;
    }

    .toast-notification {
        background: white;
        border-radius: 12px;
        padding: 1rem 1.5rem;
        margin-bottom: 0.75rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        border-left: 4px solid #28a745;
        display: flex;
        align-items: center;
        gap: 1rem;
        transform: translateX(400px);
        opacity: 0;
        transition: all 0.3s ease;
        max-width: 350px;
    }

    .toast-notification.show {
        transform: translateX(0);
        opacity: 1;
    }

    .toast-notification.success {
        border-left-color: #28a745;
    }

    .toast-notification.error {
        border-left-color: #dc3545;
    }

    .toast-icon {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        color: white;
        flex-shrink: 0;
    }

    .toast-icon.success {
        background: #28a745;
    }

    .toast-icon.error {
        background: #dc3545;
    }

    .toast-content {
        flex: 1;
    }

    .toast-title {
        font-weight: 600;
        color: #212529;
        margin-bottom: 0.25rem;
        font-size: 0.9rem;
    }

    .toast-message {
        color: #6c757d;
        font-size: 0.8rem;
        line-height: 1.4;
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

        .modern-alert-box {
            padding: 1.5rem;
        }

        .toast-container {
            top: 10px;
            right: 10px;
            left: 10px;
        }

        .toast-notification {
            max-width: none;
        }
    }
</style>

<!-- Modern Alert HTML -->
<div class="modern-alert-overlay" id="modernAlert">
    <div class="modern-alert-box">
        <div class="alert-icon warning" id="alertIcon">
            ⚠️
        </div>
        <h3 class="alert-title" id="alertTitle">Konfirmasi</h3>
        <p class="alert-message" id="alertMessage">Apakah Anda yakin ingin melanjutkan?</p>
        <div class="alert-buttons">
            <button class="alert-btn secondary" id="alertCancel">Batal</button>
            <button class="alert-btn primary" id="alertConfirm">Ya, Hapus</button>
        </div>
    </div>
</div>

<!-- Toast Container -->
<div class="toast-container" id="toastContainer"></div>

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
                                        <button class="delete-btn" onclick="confirmRemoveItem('{{ $key }}', '{{ $item['product']->name }}')">
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
// Modern Alert Functions
let currentCartKey = null;

function showModernAlert(title, message, type = 'warning', onConfirm = null) {
    const overlay = document.getElementById('modernAlert');
    const alertIcon = document.getElementById('alertIcon');
    const alertTitle = document.getElementById('alertTitle');
    const alertMessage = document.getElementById('alertMessage');
    const confirmBtn = document.getElementById('alertConfirm');
    const cancelBtn = document.getElementById('alertCancel');

    // Set icon based on type
    const icons = {
        warning: '⚠️',
        success: '✅',
        error: '❌',
        info: 'ℹ️'
    };

    alertIcon.textContent = icons[type] || icons.warning;
    alertIcon.className = `alert-icon ${type}`;
    alertTitle.textContent = title;
    alertMessage.textContent = message;

    // Show alert
    overlay.classList.add('show');

    // Handle confirm button
    const newConfirmBtn = confirmBtn.cloneNode(true);
    confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);
    
    if (onConfirm) {
        newConfirmBtn.onclick = () => {
            hideModernAlert();
            onConfirm();
        };
    }

    // Handle cancel button
    const newCancelBtn = cancelBtn.cloneNode(true);
    cancelBtn.parentNode.replaceChild(newCancelBtn, cancelBtn);
    newCancelBtn.onclick = hideModernAlert;

    // Close on overlay click
    overlay.onclick = (e) => {
        if (e.target === overlay) {
            hideModernAlert();
        }
    };
}

function hideModernAlert() {
    const overlay = document.getElementById('modernAlert');
    overlay.classList.remove('show');
}

function showToast(title, message, type = 'success', duration = 4000) {
    const container = document.getElementById('toastContainer');
    const toast = document.createElement('div');
    toast.className = `toast-notification ${type}`;
    
    const icon = type === 'success' ? '✓' : '✗';
    
    toast.innerHTML = `
        <div class="toast-icon ${type}">${icon}</div>
        <div class="toast-content">
            <div class="toast-title">${title}</div>
            <div class="toast-message">${message}</div>
        </div>
    `;

    container.appendChild(toast);

    // Show toast
    setTimeout(() => {
        toast.classList.add('show');
    }, 100);

    // Hide and remove toast
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => {
            if (container.contains(toast)) {
                container.removeChild(toast);
            }
        }, 300);
    }, duration);
}

function confirmRemoveItem(cartKey, productName) {
    currentCartKey = cartKey;
    showModernAlert(
        'Hapus Produk',
        `Apakah Anda yakin ingin menghapus "${productName}" dari keranjang?`,
        'warning',
        () => removeItem(cartKey)
    );
}

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
            
            // Show success toast
            showToast('Berhasil!', 'Jumlah produk berhasil diupdate', 'success', 3000);
        } else {
            showToast('Error!', data.message, 'error');
        }
        cartItem.style.opacity = '1';
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Error!', 'Terjadi kesalahan saat mengupdate keranjang', 'error');
        cartItem.style.opacity = '1';
    });
}

function removeItem(cartKey) {
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
            // Animate item removal
            const cartItem = document.getElementById('cart-item-' + cartKey);
            cartItem.style.transform = 'translateX(-100%)';
            cartItem.style.opacity = '0';
            
            setTimeout(() => {
                cartItem.remove();
                
                if (data.cart_count === 0) {
                    location.reload(); // Reload to show empty cart
                } else {
                    updateCartSummary(data.cart_total);
                }
                
                // Show success toast
                showToast('Berhasil!', 'Produk berhasil dihapus dari keranjang', 'success');
            }, 300);
        } else {
            showToast('Error!', data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Error!', 'Terjadi kesalahan saat menghapus item', 'error');
    });
}

function clearCart() {
    showModernAlert(
        'Kosongkan Keranjang',
        'Apakah Anda yakin ingin mengosongkan seluruh keranjang belanja?',
        'warning',
        () => {
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
                    showToast('Berhasil!', 'Keranjang berhasil dikosongkan', 'success');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    showToast('Error!', 'Gagal mengosongkan keranjang', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Error!', 'Terjadi kesalahan', 'error');
            });
        }
    );
}

function updateCartSummary(newTotal) {
    const subtotalElement = document.getElementById('cart-subtotal');
    const totalElement = document.getElementById('cart-total');
    
    if (subtotalElement && totalElement) {
        subtotalElement.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(newTotal);
        totalElement.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(newTotal + 15000);
    }
}

// Close alert with Escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        hideModernAlert();
    }
});
</script>
@endsection