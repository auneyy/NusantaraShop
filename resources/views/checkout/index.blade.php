@extends('layout.app')

@section('content')
<style>
    /* Keep your existing styles - tidak perlu diubah */
    body {
        background-color:rgb(233, 233, 233);
    }

    .checkout-container {
        padding: 2rem 0;
        min-height: 80vh;
    }

    .checkout-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 20px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
    }

    .checkout-header {
        background: linear-gradient(135deg, #422D1C 0%, #8B4513 100%);
        color: white;
        padding: 1.5rem;
        border-radius: 10px 10px 0 0;
    }

    .checkout-step {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
    }

    .step-number {
        background: rgba(255,255,255,0.2);
        color: white;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        font-weight: bold;
    }

    .form-section {
        padding: 2rem;
    }

    .section-title {
        color: #422D1C;
        font-weight: 600;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #f0f0f0;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        transition: border-color 0.3s ease;
    }

    .form-control:focus {
        border-color: #422D1C;
        box-shadow: 0 0 0 0.2rem rgba(66, 45, 28, 0.25);
    }

    .form-control.is-invalid {
        border-color: #dc3545;
    }

    .order-summary {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .product-item {
        display: flex;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid #e9ecef;
    }

    .product-item:last-child {
        border-bottom: none;
    }

    .product-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        margin-right: 1rem;
    }

    .product-details {
        flex: 1;
    }

    .product-name {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.25rem;
    }

    .product-specs {
        color: #666;
        font-size: 0.9rem;
    }

    .product-price {
        font-weight: 600;
        color: #422D1C;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
    }

    .summary-row.total {
        font-weight: bold;
        font-size: 1.1rem;
        color: #422D1C;
        border-top: 2px solid #e9ecef;
        padding-top: 1rem;
        margin-top: 1rem;
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
    }

    .checkout-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(66, 45, 28, 0.3);
    }

    .checkout-btn:disabled {
        background: #ccc;
        transform: none;
        box-shadow: none;
    }

    .alert {
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }

    /* FIXED: Style untuk payment method selection */
    .payment-methods {
        margin: 1.5rem 0;
    }

    .payment-method-item {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }

    .payment-method-item:hover {
        border-color: #422D1C;
        box-shadow: 0 2px 10px rgba(66, 45, 28, 0.1);
    }

    .payment-method-item.selected {
        border-color: #422D1C;
        background-color: #f8f9fa;
        box-shadow: 0 2px 10px rgba(66, 45, 28, 0.15);
    }

    .payment-method-item input[type="radio"] {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .payment-method-header {
        display: flex;
        align-items: center;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
    }

    .payment-method-icon {
        font-size: 1.5rem;
        margin-right: 0.75rem;
    }

    .payment-method-desc {
        font-size: 0.9rem;
        color: #666;
        margin-left: 2.25rem;
    }

    /* FIXED: Visual indicator for selected payment */
    .payment-method-item.selected::before {
        content: '✓';
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        width: 24px;
        height: 24px;
        background: #422D1C;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        font-weight: bold;
    }

    /* Loading overlay */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        flex-direction: column;
        color: white;
    }

    .loading-spinner {
        width: 50px;
        height: 50px;
        border: 3px solid rgba(255, 255, 255, 0.3);
        border-top: 3px solid white;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-bottom: 1rem;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    @media (max-width: 768px) {
        .checkout-container {
            padding: 1rem 0;
        }
        
        .form-section {
            padding: 1.5rem;
        }
        
        .product-item {
            flex-direction: column;
            text-align: center;
        }
        
        .product-image {
            margin-right: 0;
            margin-bottom: 1rem;
        }
    }
</style>

<!-- Loading Overlay -->
<div id="loading-overlay" class="loading-overlay" style="display: none;">
    <div class="loading-spinner"></div>
    <div>Memproses pesanan...</div>
</div>

<div class="checkout-container">
    <div class="container">
        <!-- Header -->
        <div class="checkout-card">
            <div class="checkout-header">
                <div class="checkout-step">
                    <div class="step-number">1</div>
                    <h4 class="mb-0">Checkout Pesanan Anda</h4>
                </div>
                <p class="mb-0">Lengkapi informasi pengiriman untuk melanjutkan ke pembayaran</p>
            </div>
        </div>

        <!-- Error Messages -->
        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
            @csrf
            
            <div class="row">
                <!-- Form Checkout -->
                <div class="col-lg-8">
                    <div class="checkout-card">
                        <div class="form-section">
                            <!-- Informasi Pengiriman -->
                            <h5 class="section-title">📦 Informasi Pengiriman</h5>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="shipping_name">Nama Lengkap *</label>
                                        <input type="text" class="form-control" id="shipping_name" 
                                               name="shipping_name" value="{{ old('shipping_name', Auth::user()->name ?? '') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="shipping_phone">Nomor Telepon *</label>
                                        <input type="tel" class="form-control" id="shipping_phone" 
                                               name="shipping_phone" value="{{ old('shipping_phone') }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="shipping_email">Email *</label>
                                <input type="email" class="form-control" id="shipping_email" 
                                       name="shipping_email" value="{{ old('shipping_email', Auth::user()->email ?? '') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="shipping_address">Alamat Lengkap *</label>
                                <textarea class="form-control" id="shipping_address" name="shipping_address" 
                                          rows="3" required placeholder="Masukkan alamat lengkap termasuk RT/RW, Kelurahan, Kecamatan">{{ old('shipping_address') }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="shipping_city">Kota *</label>
                                        <input type="text" class="form-control" id="shipping_city" 
                                               name="shipping_city" value="{{ old('shipping_city') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="shipping_postal_code">Kode Pos *</label>
                                        <input type="text" class="form-control" id="shipping_postal_code" 
                                               name="shipping_postal_code" value="{{ old('shipping_postal_code') }}" required>
                                    </div>
                                </div>
                            </div>

                            <!-- FIXED: Payment Method Selection -->
                            <h5 class="section-title mt-4">💳 Metode Pembayaran</h5>
                            <div class="payment-methods">
                                <div class="payment-method-item selected" data-payment="midtrans">
                                    <input type="radio" name="payment_method" value="midtrans" id="midtrans" 
                                           {{ old('payment_method', 'midtrans') === 'midtrans' ? 'checked' : '' }}>
                                    <div class="payment-method-header">
                                        <div class="payment-method-icon">💳</div>
                                        Midtrans Payment Gateway
                                    </div>
                                    <div class="payment-method-desc">
                                        Kartu Kredit/Debit, E-Wallet (GoPay, OVO, DANA), Transfer Bank, Minimarket
                                    </div>
                                </div>

                                <div class="payment-method-item" data-payment="bank_transfer">
                                    <input type="radio" name="payment_method" value="bank_transfer" id="bank_transfer" 
                                           {{ old('payment_method') === 'bank_transfer' ? 'checked' : '' }}>
                                    <div class="payment-method-header">
                                        <div class="payment-method-icon">🏦</div>
                                        Transfer Bank Manual
                                    </div>
                                    <div class="payment-method-desc">
                                        Transfer ke rekening toko, konfirmasi manual diperlukan
                                    </div>
                                </div>

                                <div class="payment-method-item" data-payment="cod">
                                    <input type="radio" name="payment_method" value="cod" id="cod" 
                                           {{ old('payment_method') === 'cod' ? 'checked' : '' }}>
                                    <div class="payment-method-header">
                                        <div class="payment-method-icon">💵</div>
                                        Bayar di Tempat (COD)
                                    </div>
                                    <div class="payment-method-desc">
                                        Bayar saat barang diterima, tersedia untuk area tertentu
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Catatan -->
                            <h5 class="section-title mt-4">📝 Catatan (Opsional)</h5>
                            <div class="form-group">
                                <textarea class="form-control" name="notes" rows="3" 
                                          placeholder="Catatan khusus untuk pesanan Anda (warna, ukuran, dll)">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ringkasan Pesanan -->
                <div class="col-lg-4">
                    <div class="checkout-card">
                        <div class="form-section">
                            <h5 class="section-title">🛒 Ringkasan Pesanan</h5>
                            
                            <!-- Produk yang dibeli -->
                            @foreach($checkoutItems as $index => $item)
                            <div class="product-item">
                                <img src="{{ $item['product']->images->first()->image_path ?? 'path/to/placeholder.jpg' }}" 
                                     alt="{{ $item['product']->name }}" class="product-image">
                                <div class="product-details">
                                    <div class="product-name">{{ $item['product']->name }}</div>
                                    <div class="product-specs">
                                        Ukuran: {{ $item['size'] }} | Qty: {{ $item['quantity'] }}
                                    </div>
                                    <div class="product-price">
                                        Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Hidden inputs untuk items -->
                            <input type="hidden" name="items[{{ $index }}][product_id]" value="{{ $item['product']->id }}">
                            <input type="hidden" name="items[{{ $index }}][quantity]" value="{{ $item['quantity'] }}">
                            <input type="hidden" name="items[{{ $index }}][size]" value="{{ $item['size'] }}">
                            @endforeach

                            <!-- Summary -->
                            <div class="order-summary mt-3">
                                <div class="summary-row">
                                    <span>Subtotal</span>
                                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                                <div class="summary-row">
                                    <span>Ongkos Kirim</span>
                                    <span>Rp {{ number_format(15000, 0, ',', '.') }}</span>
                                </div>
                                <div class="summary-row total">
                                    <span>Total</span>
                                    <span>Rp {{ number_format($total + 15000, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <!-- Total Amount Hidden Input -->
                            <input type="hidden" name="total_amount" value="{{ $total }}">

                            <button type="submit" class="btn checkout-btn mt-3" id="process-order">
                                <i class="bi bi-credit-card me-2"></i>
                                Proses Pesanan - Rp {{ number_format($total + 15000, 0, ',', '.') }}
                            </button>

                            <div class="text-center mt-3">
                                <small class="text-muted">
                                    🔒 Pembayaran aman dan terenkripsi<br>
                                    Dengan melakukan checkout, Anda menyetujui syarat dan ketentuan kami
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Midtrans Snap JS -->
<script type="text/javascript" 
        src="https://app.sandbox.midtrans.com/snap/snap.js" 
        data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const processOrderBtn = document.getElementById('process-order');
    const checkoutForm = document.getElementById('checkout-form');
    const paymentMethodItems = document.querySelectorAll('.payment-method-item');
    const loadingOverlay = document.getElementById('loading-overlay');

    // Payment method selection handler
    function selectPaymentMethod(method) {
        paymentMethodItems.forEach(item => {
            item.classList.remove('selected');
        });
        
        const selectedItem = document.querySelector(`[data-payment="${method}"]`);
        if (selectedItem) {
            selectedItem.classList.add('selected');
            const radioButton = document.getElementById(method);
            if (radioButton) {
                radioButton.checked = true;
            }
        }
    }

    // Add click event listeners to payment method items
    paymentMethodItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const paymentMethod = this.getAttribute('data-payment');
            selectPaymentMethod(paymentMethod);
        });
    });

    // Set default payment method
    const defaultPaymentMethod = document.querySelector('input[name="payment_method"]:checked');
    if (defaultPaymentMethod) {
        selectPaymentMethod(defaultPaymentMethod.value);
    } else {
        selectPaymentMethod('midtrans');
        document.getElementById('midtrans').checked = true;
    }

    // Form submission handler
    checkoutForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        let isValid = true;
        
        // Basic required field validation
        const requiredFields = checkoutForm.querySelectorAll('[required]');
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });

        checkoutForm.addEventListener('submit', function(e) {
    e.preventDefault();
    
    let isValid = true;
    
    // Basic required field validation
    const requiredFields = checkoutForm.querySelectorAll('[required]');
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            field.classList.add('is-invalid');
            isValid = false;
        } else {
            field.classList.remove('is-invalid');
        }
    });

    // Check if payment method is selected
    const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
    if (!paymentMethod) {
        alert('Mohon pilih metode pembayaran!');
        isValid = false;
    }

    if (!isValid) {
        alert('Mohon lengkapi semua field yang diperlukan!');
        const firstInvalid = checkoutForm.querySelector('.is-invalid');
        if (firstInvalid) {
            firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstInvalid.focus();
        }
        return;
    }

    // Show loading overlay
    loadingOverlay.style.display = 'flex';
    processOrderBtn.disabled = true;
    processOrderBtn.innerHTML = '<i class="spinner-border spinner-border-sm me-2"></i>Memproses pesanan...';

    // Submit form via AJAX
    const formData = new FormData(checkoutForm);
    
    fetch(checkoutForm.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        loadingOverlay.style.display = 'none';
        
        if (data.success) {
            // FIXED: Use correct property names from your controller response
            if (paymentMethod.value === 'midtrans' && data.snap_token) {
                // Buka Midtrans Snap dan tunggu hasilnya
                snap.pay(data.snap_token, {
                    onSuccess: function(result){
                        console.log('Payment success:', result);
                        // Redirect ke success page dengan status success
                        window.location.href = `/checkout/success?order=${data.order_number}&status=success`;
                    },
                    onPending: function(result){
                        console.log('Payment pending:', result);
                        // Redirect dengan status pending
                        window.location.href = `/checkout/success?order=${data.order_number}&status=pending`;
                    },
                    onError: function(result){
                        console.log('Payment error:', result);
                        alert('Pembayaran gagal. Silakan coba lagi.');
                        
                        // Reset form dan jangan redirect
                        processOrderBtn.disabled = false;
                        processOrderBtn.innerHTML = '<i class="bi bi-credit-card me-2"></i>Proses Pesanan - Rp {{ number_format($total + 15000, 0, ",", ".") }}';
                        
                        // Tidak redirect ke success page
                    },
                    onClose: function(){
                        console.log('Payment popup closed by user');
                        
                        // Show informative message instead of alert
                        const closeMessage = document.createElement('div');
                        closeMessage.className = 'alert alert-info mt-3';
                        closeMessage.innerHTML = `
                            <strong>💡 Pembayaran Belum Selesai</strong><br>
                            Pesanan Anda telah tersimpan dengan nomor: <strong>${data.order_number}</strong><br>
                            Anda dapat melanjutkan pembayaran kapan saja dengan klik tombol di bawah.
                        `;
                        
                        // Insert message after the form
                        checkoutForm.parentNode.insertBefore(closeMessage, checkoutForm.nextSibling);
                        
                        // Update button text to indicate continuation
                        processOrderBtn.disabled = false;
                        processOrderBtn.innerHTML = '<i class="bi bi-credit-card me-2"></i>Lanjutkan Pembayaran';
                        
                        // Remove message after 10 seconds
                        setTimeout(() => {
                            if (closeMessage.parentNode) {
                                closeMessage.parentNode.removeChild(closeMessage);
                            }
                        }, 10000);
                        
                        // Tidak redirect ke success page - user tetap di checkout
                    }
                });
            } else {
                // Untuk payment method lain (bank transfer, COD), redirect langsung ke success
                window.location.href = `/checkout/success?order=${data.order_number}&status=pending`;
            }
        } else {
            throw new Error(data.message || 'Checkout failed');
        }
    })
    .catch(error => {
        console.error('Checkout error:', error);
        loadingOverlay.style.display = 'none';
        
        // Reset form
        processOrderBtn.disabled = false;
        processOrderBtn.innerHTML = '<i class="bi bi-credit-card me-2"></i>Proses Pesanan - Rp {{ number_format($total + 15000, 0, ",", ".") }}';
        
        alert('Terjadi kesalahan: ' + error.message);
    });
});

    // Remove invalid class on input
    document.querySelectorAll('.form-control').forEach(input => {
        input.addEventListener('input', function() {
            this.classList.remove('is-invalid');
        });
    });

    // Handle direct radio button clicks
    document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.checked) {
                selectPaymentMethod(this.value);
            }
        });
    });

    console.log('Checkout page initialized successfully');
});
</script>
@endsection