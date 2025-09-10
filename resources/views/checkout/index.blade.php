@extends('layout.app')

@section('content')
<style>
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

    .payment-info {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        border: 1px solid #2196f3;
        border-radius: 10px;
        padding: 1.5rem;
        margin: 1.5rem 0;
        text-align: center;
    }

    .midtrans-logo {
        width: 120px;
        height: auto;
        margin-bottom: 1rem;
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
                            <h5 class="section-title">🛍️ Ringkasan Pesanan</h5>
                            
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

                            <!-- Payment Method Hidden Input -->
                            <input type="hidden" name="payment_method" value="midtrans">
                            <input type="hidden" name="total_amount" value="{{ $total }}">

                            <!-- Payment Information -->
                            <div class="payment-info mt-3">
                                <h6 class="text-primary mb-2">💳 Pembayaran via Midtrans</h6>
                                <p class="mb-2 small text-muted">
                                    BELUM JADI MIDTRANSNYA
                                </p>
                                <div class="d-flex justify-content-center align-items-center flex-wrap gap-2">
                                    <span class="badge bg-light text-dark">💳 Kartu Kredit</span>
                                    <span class="badge bg-light text-dark">🏦 Transfer Bank</span>
                                    <span class="badge bg-light text-dark">📱 E-Wallet</span>
                                    <span class="badge bg-light text-dark">🏪 Minimarket</span>
                                </div>
                            </div>

                            <button type="submit" class="btn checkout-btn mt-3" id="process-order">
                                <i class="bi bi-credit-card me-2"></i>
                                Bayar Sekarang - Rp {{ number_format($total + 15000, 0, ',', '.') }}
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const processOrderBtn = document.getElementById('process-order');
    const checkoutForm = document.getElementById('checkout-form');

    // Form validation before submit
    checkoutForm.addEventListener('submit', function(e) {
        // Basic form validation
        const requiredFields = checkoutForm.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert('Mohon lengkapi semua field yang diperlukan!');
            return;
        }

        // Show loading state
        processOrderBtn.disabled = true;
        processOrderBtn.innerHTML = '<i class="spinner-border spinner-border-sm me-2"></i>Memproses pembayaran...';
    });

    // Remove invalid class on input
    document.querySelectorAll('.form-control').forEach(input => {
        input.addEventListener('input', function() {
            this.classList.remove('is-invalid');
        });
    });
});
</script>

@endsection