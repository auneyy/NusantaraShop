@extends('layout.app')

@section('content')
<style>
    body {
        background-color: #f8f9fa;
    }

    .order-container {
        padding: 2rem 0;
        min-height: 80vh;
    }

    .back-button {
        margin-bottom: 2rem;
    }

    .back-link {
        color: #422D1C;
        text-decoration: none;
        font-weight: 500;
        padding: 0.5rem 1rem;
        border: 1px solid #422D1C;
        border-radius: 6px;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .back-link:hover {
        background: #422D1C;
        color: white;
        text-decoration: none;
    }

    /* Two Column Layout */
    .order-layout {
        display: grid;
        grid-template-columns: 1fr 420px;
        gap: 2rem;
        align-items: start;
    }

    /* Shopping Cart Card */
    .shopping-cart-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 30px rgba(0,0,0,0.1);
        padding: 2.5rem;
    }

    .cart-header {
        font-size: 2rem;
        font-weight: 700;
        color: #212529;
        margin-bottom: 2rem;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Product Table */
    .product-table {
        width: 100%;
        margin-bottom: 2rem;
    }

    .product-table thead {
        border-bottom: 2px solid #e9ecef;
    }

    .product-table th {
        padding: 0.75rem 0.5rem;
        font-size: 0.8rem;
        font-weight: 600;
        color: #6c757d;
        text-transform: uppercase;
        text-align: left;
        letter-spacing: 0.5px;
    }

    .product-table tbody tr {
        border-bottom: 1px solid #f1f3f5;
        transition: background 0.2s;
    }

    .product-table tbody tr:hover {
        background: #f8f9fa;
    }

    .product-table td {
        padding: 1.5rem 0.5rem;
        vertical-align: middle;
    }

    .product-item {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .product-image {
        width: 75px;
        height: 75px;
        object-fit: cover;
        border-radius: 8px;
        background: #f8f9fa;
        border: 1px solid #e9ecef;
    }

    .product-details {
        flex: 1;
    }

    .product-name {
        font-weight: 600;
        color: #212529;
        margin-bottom: 0.3rem;
        font-size: 0.95rem;
    }

    .product-meta {
        color: #6c757d;
        font-size: 0.85rem;
    }

    .size-badge {
        padding: 0.4rem 0.8rem;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        font-size: 0.9rem;
        background: #f8f9fa;
        color: #495057;
        font-weight: 500;
    }

    .quantity-display {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        font-weight: 500;
        color: #495057;
    }

    .price {
        font-weight: 600;
        color: #422D1C;
        font-size: 1rem;
    }

    /* Cart Summary */
    .cart-summary {
        border-top: 2px solid #e9ecef;
        padding-top: 1.5rem;
        margin-top: 1rem;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
    }

    .summary-label {
        color: #6c757d;
        font-weight: 500;
    }

    .summary-value {
        font-weight: 600;
        color: #212529;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        padding-top: 1rem;
        margin-top: 0.5rem;
        border-top: 2px solid #422D1C;
        font-size: 1.1rem;
        font-weight: 700;
    }

    .total-label {
        color: #212529;
    }

    .total-value {
        color: #422D1C;
        font-size: 1.4rem;
    }

    .continue-shopping {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: #422D1C;
        text-decoration: none;
        font-weight: 500;
        margin-top: 1rem;
        transition: all 0.2s;
    }

    .continue-shopping:hover {
        color: #2d1f14;
        text-decoration: none;
        transform: translateX(-4px);
    }

    /* Payment Info Card */
    .payment-card {
        background: linear-gradient(135deg, #422D1C 0%, #8B4513 100%);
        border-radius: 15px;
        box-shadow: 0 8px 40px rgba(66, 45, 28, 0.3);
        padding: 2rem;
        color: white;
        position: sticky;
        top: 2rem;
    }

    .payment-header {
        font-size: 1.6rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Order Information */
    .order-info-section {
        background: rgba(255,255,255,0.1);
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        backdrop-filter: blur(10px);
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.75rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .info-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .info-label {
        color: rgba(255,255,255,0.8);
        font-size: 0.9rem;
        font-weight: 500;
    }

    .info-value {
        color: white;
        font-weight: 600;
        text-align: right;
    }

    .status-badge {
        padding: 0.4rem 0.9rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .status-pending {
        background: #ffc107;
        color: #856404;
    }

    .status-paid {
        background: #28a745;
        color: white;
    }

    /* Payment Status Display */
    .payment-status-display {
        background: rgba(255,255,255,0.15);
        border: 2px solid rgba(255,255,255,0.3);
        border-radius: 10px;
        padding: 1.2rem;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .payment-method-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255,255,255,0.2);
        padding: 0.6rem 1.2rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.95rem;
        margin-bottom: 0.5rem;
    }

    .payment-status-text {
        font-size: 0.85rem;
        color: rgba(255,255,255,0.9);
        margin-top: 0.5rem;
    }

    /* Timeline */
    .timeline {
        margin-bottom: 1.5rem;
    }

    .timeline-item {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
        position: relative;
        padding-left: 0;
    }

    .timeline-item:not(:last-child)::after {
        content: '';
        position: absolute;
        left: 19px;
        top: 45px;
        width: 2px;
        height: calc(100% - 15px);
        background: rgba(255,255,255,0.2);
    }

    .timeline-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        font-size: 1.2rem;
        flex-shrink: 0;
        position: relative;
        z-index: 1;
    }

    .timeline-icon.active {
        background: #EFA942;
        color: white;
        box-shadow: 0 0 0 4px rgba(239, 169, 66, 0.3);
    }

    .timeline-icon.pending {
        background: #ffc107;
        color: white;
        box-shadow: 0 0 0 4px rgba(255, 193, 7, 0.3);
    }

    .timeline-icon.inactive {
        background: rgba(255,255,255,0.1);
        color: rgba(255,255,255,0.5);
    }

    .timeline-content {
        flex: 1;
    }

    .timeline-content h6 {
        margin-bottom: 0.25rem;
        color: white;
        font-size: 0.95rem;
        font-weight: 600;
    }

    .timeline-content small {
        color: rgba(255,255,255,0.7);
        font-size: 0.85rem;
    }

    /* Buttons */
    .checkout-btn {
        width: 100%;
        background: linear-gradient(135deg, #EFA942 0%, #D68910 100%);
        color: white;
        border: none;
        padding: 1rem;
        border-radius: 10px;
        font-size: 1.1rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(239, 169, 66, 0.3);
        margin-bottom: 0.75rem;
    }

    .checkout-btn:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(239, 169, 66, 0.4);
    }

    .checkout-btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }

    .cancel-btn {
        width: 100%;
        background: rgba(220, 53, 69, 0.9);
        color: white;
        border: 2px solid rgba(255,255,255,0.3);
        padding: 0.85rem;
        border-radius: 10px;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .cancel-btn:hover {
        background: #dc3545;
        border-color: rgba(255,255,255,0.5);
    }

    /* Shipping Info */
    .shipping-info-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 30px rgba(0,0,0,0.1);
        padding: 2rem;
        margin-top: 2rem;
    }

    .shipping-header {
        font-size: 1.3rem;
        font-weight: 700;
        color: #212529;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .shipping-details {
        display: grid;
        gap: 1rem;
    }

    .shipping-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .shipping-label {
        font-size: 0.85rem;
        color: #6c757d;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .shipping-value {
        color: #212529;
        font-size: 0.95rem;
        font-weight: 500;
    }

    /* Help Section */
    .help-section {
        background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
        border-left: 4px solid #EFA942;
        border-radius: 10px;
        padding: 1.5rem;
        margin-top: 2rem;
    }

    .help-section strong {
        color: #422D1C;
    }

    /* Custom Modal */
    .custom-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(5px);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 0;
        border: none;
        border-radius: 15px;
        width: 90%;
        max-width: 400px;
        box-shadow: 0 10px 50px rgba(0, 0, 0, 0.3);
        animation: modalSlideIn 0.3s ease-out;
    }

    @keyframes modalSlideIn {
        from {
            transform: translateY(-50px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .modal-header {
        padding: 1.5rem;
        text-align: center;
        border-radius: 15px 15px 0 0;
    }

    .modal-header.success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
    }

    .modal-header.error {
        background: linear-gradient(135deg, #dc3545 0%, #e74c3c 100%);
        color: white;
    }

    .modal-header.pending {
        background: linear-gradient(135deg, #ffc107 0%, #f39c12 100%);
        color: white;
    }

    .modal-body {
        padding: 1.5rem;
        text-align: center;
    }

    .modal-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    .modal-footer {
        padding: 1rem 1.5rem;
        text-align: center;
        background: #f8f9fa;
        border-radius: 0 0 15px 15px;
    }

    .btn-modal {
        background: #422D1C;
        color: white;
        border: none;
        padding: 0.6rem 1.8rem;
        border-radius: 8px;
        cursor: pointer;
        margin: 0.25rem;
        font-weight: 600;
        transition: all 0.2s;
    }

    .btn-modal:hover {
        background: #2d1f14;
    }

    .btn-modal.secondary {
        background: #6c757d;
    }

    .btn-modal.secondary:hover {
        background: #495057;
    }

    .spinner {
        width: 20px;
        height: 20px;
        border: 2px solid #ffffff;
        border-top: 2px solid transparent;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        display: inline-block;
        margin-right: 0.5rem;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .order-layout {
            grid-template-columns: 1fr;
        }

        .payment-card {
            position: static;
        }
    }

    @media (max-width: 768px) {
        .order-container {
            padding: 1rem 0;
        }

        .shopping-cart-card,
        .payment-card,
        .shipping-info-card {
            padding: 1.5rem;
        }

        .cart-header,
        .payment-header {
            font-size: 1.5rem;
        }

        .product-table {
            display: block;
            overflow-x: auto;
        }

        .product-item {
            flex-direction: column;
            text-align: center;
        }

        .product-image {
            margin-bottom: 0.5rem;
        }
    }
</style>

<div class="order-container">
    <div class="container">
        <!-- Back Button -->
        <div class="back-button">
            <a href="{{ route('orders.index') }}" class="back-link">
                ← Kembali ke Daftar Pesanan
            </a>
        </div>

        <div class="order-layout">
            <!-- Left Column: Shopping Cart -->
            <div>
                <div class="shopping-cart-card">
                    <h2 class="cart-header">Keranjang Belanja</h2>

                    <!-- Product Table -->
                    <table class="product-table">
                        <thead>
                            <tr>
                                <th style="width: 50%;">Produk</th>
                                <th style="width: 15%;">Ukuran</th>
                                <th style="width: 15%;">Jumlah</th>
                                <th style="width: 20%;">Harga Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                            <tr>
                                <td>
                                    <div class="product-item">
                                        <img src="{{ $item->product->images->first()->image_path ?? 'path/to/placeholder.jpg' }}" 
                                             alt="{{ $item->product_name }}" 
                                             class="product-image">
                                        <div class="product-details">
                                            <div class="product-name">{{ $item->product_name }}</div>
                                            <div class="product-meta">{{ $item->product->kategori->nama_kategori ?? 'Fashion' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="size-badge">{{ $item->size ?? 'M' }}</span>
                                </td>
                                <td>
                                    <div class="quantity-display">
                                        <span>{{ $item->quantity }} pcs</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="price">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Cart Summary -->
                    <div class="cart-summary">
                        <div class="summary-row">
                            <span class="summary-label">Subtotal</span>
                            <span class="summary-value">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label">Berat Total</span>
                            <span class="summary-value">
                                {{ number_format($order->orderItems->sum(function($item) {
                                    return $item->product->berat * $item->quantity;
                                }), 0, ',', '.') }} gram
                            </span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label">Ongkos Kirim</span>
                            <span class="summary-value">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                        <div class="total-row">
                            <span class="total-label">Total Pembayaran</span>
                            <span class="total-value">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <a href="{{ route('products.index') }}" class="continue-shopping">
                        ← Lanjut Belanja
                    </a>
                </div>

                <!-- Shipping Information -->
                <div class="shipping-info-card">
                    <h3 class="shipping-header">📦 Informasi Pengiriman</h3>
                    <div class="shipping-details">
                        <div class="shipping-item">
                            <span class="shipping-label">Nama Penerima</span>
                            <span class="shipping-value">{{ $order->shipping_name }}</span>
                        </div>
                        <div class="shipping-item">
                            <span class="shipping-label">No. Telepon</span>
                            <span class="shipping-value">{{ $order->shipping_phone }}</span>
                        </div>
                        <div class="shipping-item">
                            <span class="shipping-label">Email</span>
                            <span class="shipping-value">{{ $order->shipping_email }}</span>
                        </div>
                        <div class="shipping-item">
                            <span class="shipping-label">Alamat Lengkap</span>
                            <span class="shipping-value">
                                {{ $order->shipping_address }}, {{ $order->shipping_city }} {{ $order->shipping_postal_code }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Help Section -->
                <div class="help-section">
                    <strong>📞 Butuh Bantuan?</strong><br>
                    Jika ada pertanyaan mengenai pesanan atau pembayaran Anda, silakan hubungi customer service kami di WhatsApp <strong>+62 812-3456-7890</strong> 
                    atau email <strong>cs@tokofashion.com</strong> dengan menyertakan nomor pesanan <strong>{{ $order->order_number }}</strong>
                </div>
            </div>

            <!-- Right Column: Payment Info -->
            <div>
                <div class="payment-card">
                    <h3 class="payment-header">Informasi Pembayaran</h3>

                    <!-- Order Information -->
                    <div class="order-info-section">
                        <div class="info-item">
                            <span class="info-label">Nomor Pesanan</span>
                            <span class="info-value">{{ $order->order_number }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Tanggal Pesanan</span>
                            <span class="info-value">{{ $order->order_date->format('d M Y, H:i') }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Status Pesanan</span>
                            <span class="info-value">
                                <span class="status-badge status-{{ (!isset($order->payment_status) || $order->payment_status === 'pending') ? 'pending' : 'paid' }}" id="order-status-badge">
                                    {{ $order->status_label }}
                                </span>
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Total Pembayaran</span>
                            <span class="info-value" style="font-size: 1.2rem; color: #EFA942;">
                                Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <!-- Payment Method Display -->
                    <div class="payment-status-display">
                        <div class="payment-method-badge">
                            💳 {{ $order->payment_method_label }}
                        </div>
                        <div class="payment-status-text" id="payment-status-text">
                            @if(!isset($order->payment_status) || $order->payment_status === 'pending')
                                Menunggu pembayaran melalui Midtrans
                            @elseif($order->payment_status === 'settlement' || $order->payment_status === 'capture')
                                ✅ Pembayaran telah berhasil dikonfirmasi
                            @else
                                Status: {{ $order->payment_status_label }}
                            @endif
                        </div>
                    </div>

                    <!-- Timeline -->
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-icon active">✅</div>
                            <div class="timeline-content">
                                <h6>Pesanan Diterima</h6>
                                <small>{{ $order->order_date->format('d M Y, H:i') }}</small>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-icon {{ (!isset($order->payment_status) || $order->payment_status === 'pending') ? 'pending' : (($order->payment_status === 'settlement' || $order->payment_status === 'capture') ? 'active' : 'inactive') }}" id="payment-timeline-icon">
                                {{ (!isset($order->payment_status) || $order->payment_status === 'pending') ? '⏳' : (($order->payment_status === 'settlement' || $order->payment_status === 'capture') ? '✅' : '❌') }}
                            </div>
                            <div class="timeline-content">
                                <h6>Pembayaran</h6>
                                <small id="payment-timeline-text">
                                    @if(!isset($order->payment_status) || $order->payment_status === 'pending')
                                        Menunggu pembayaran
                                    @elseif($order->payment_status === 'settlement' || $order->payment_status === 'capture')
                                        Pembayaran berhasil
                                        @if($order->payment_completed_at)
                                            - {{ $order->payment_completed_at->format('d M Y, H:i') }}
                                        @endif
                                    @else
                                        Pembayaran gagal/dibatalkan
                                    @endif
                                </small>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-icon {{ $order->status === 'processing' ? 'active' : (in_array($order->status, ['shipped', 'delivered']) ? 'active' : 'inactive') }}">📦</div>
                            <div class="timeline-content">
                                <h6>Pesanan Diproses</h6>
                                <small>
                                    @if(in_array($order->status, ['processing', 'shipped', 'delivered']))
                                        Pesanan sedang diproses
                                    @else
                                        Setelah pembayaran dikonfirmasi
                                    @endif
                                </small>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-icon {{ $order->status === 'shipped' ? 'active' : ($order->status === 'delivered' ? 'active' : 'inactive') }}">🚚</div>
                            <div class="timeline-content">
                                <h6>Pesanan Dikirim</h6>
                                <small>
                                    @if($order->shipped_date)
                                        {{ $order->shipped_date->format('d M Y, H:i') }}
                                    @else
                                        Estimasi 2-3 hari kerja
                                    @endif
                                </small>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-icon {{ $order->status === 'delivered' ? 'active' : 'inactive' }}">✨</div>
                            <div class="timeline-content">
                                <h6>Pesanan Diterima</h6>
                                <small>
                                    @if($order->delivered_date)
                                        {{ $order->delivered_date->format('d M Y, H:i') }}
                                    @else
                                        Selamat menikmati produk!
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Button or Status -->
                    @if((!isset($order->payment_status) || $order->payment_status === 'pending') && isset($snapToken))
                    <button class="checkout-btn" id="pay-button">
                        💳 Bayar Sekarang - Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                    </button>
                    @elseif($order->payment_status === 'settlement' || $order->payment_status === 'capture')
                    <button class="checkout-btn" disabled style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                        ✅ Pembayaran Selesai
                    </button>
                    @else
                    <button class="checkout-btn" disabled style="background: #6c757d;">
                        {{ $order->payment_status_label }}
                    </button>
                    @endif

                    <!-- Cancel Order Button -->
                    @if($order->status === 'pending' && (!isset($order->payment_status) || $order->payment_status === 'pending'))
                    <form action="{{ route('orders.cancel', $order->order_number) }}" method="POST" 
                          onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="cancel-btn">
                            ❌ Batalkan Pesanan
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom Modal -->
<div id="customModal" class="custom-modal">
    <div class="modal-content">
        <div class="modal-header" id="modalHeader">
            <div class="modal-icon" id="modalIcon">⏳</div>
            <h4 id="modalTitle">Memproses Pembayaran</h4>
        </div>
        <div class="modal-body">
            <p id="modalMessage">Silakan tunggu...</p>
        </div>
        <div class="modal-footer">
            <button class="btn-modal" id="modalPrimaryBtn" onclick="closeModal()">OK</button>
            <button class="btn-modal secondary" id="modalSecondaryBtn" onclick="closeModal()" style="display: none;">Tutup</button>
        </div>
    </div>
</div>

<!-- Midtrans Snap JS -->
@if(isset($snapToken) && $snapToken)
<script type="text/javascript" 
        src="https://app.{{ config('midtrans.is_production') ? 'midtrans' : 'sandbox.midtrans' }}.com/snap/snap.js" 
        data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
    // Modal Functions
    function showModal(type, title, message, callback = null) {
        const modal = document.getElementById('customModal');
        const header = document.getElementById('modalHeader');
        const icon = document.getElementById('modalIcon');
        const titleEl = document.getElementById('modalTitle');
        const messageEl = document.getElementById('modalMessage');
        const primaryBtn = document.getElementById('modalPrimaryBtn');
        const secondaryBtn = document.getElementById('modalSecondaryBtn');

        // Reset classes
        header.className = 'modal-header';
        
        // Set modal type
        switch(type) {
            case 'success':
                header.classList.add('success');
                icon.textContent = '✅';
                primaryBtn.style.background = '#28a745';
                break;
            case 'error':
                header.classList.add('error');
                icon.textContent = '❌';
                primaryBtn.style.background = '#dc3545';
                break;
            case 'pending':
                header.classList.add('pending');
                icon.textContent = '⏳';
                primaryBtn.style.background = '#ffc107';
                break;
            default:
                header.classList.add('pending');
                icon.textContent = '⏳';
        }

        titleEl.textContent = title;
        messageEl.textContent = message;
        
        // Handle callback
        if (callback) {
            primaryBtn.onclick = function() {
                closeModal();
                callback();
            };
            secondaryBtn.style.display = 'inline-block';
            secondaryBtn.onclick = closeModal;
        } else {
            primaryBtn.onclick = closeModal;
            secondaryBtn.style.display = 'none';
        }

        modal.style.display = 'block';
    }

    function closeModal() {
        document.getElementById('customModal').style.display = 'none';
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('customModal');
        if (event.target === modal) {
            closeModal();
        }
    }

    // Update UI function
    function updatePaymentStatus(status) {
        const paymentTimelineIcon = document.getElementById('payment-timeline-icon');
        const paymentTimelineText = document.getElementById('payment-timeline-text');
        const orderStatusBadge = document.getElementById('order-status-badge');
        const paymentStatusText = document.getElementById('payment-status-text');

        switch(status) {
            case 'settlement':
            case 'capture':
                // Update timeline
                if (paymentTimelineIcon) {
                    paymentTimelineIcon.className = 'timeline-icon active';
                    paymentTimelineIcon.textContent = '✅';
                }
                
                if (paymentTimelineText) {
                    paymentTimelineText.textContent = 'Pembayaran berhasil';
                }

                if (orderStatusBadge) {
                    orderStatusBadge.className = 'status-badge status-paid';
                    orderStatusBadge.textContent = 'Dibayar';
                }

                if (paymentStatusText) {
                    paymentStatusText.textContent = '✅ Pembayaran telah berhasil dikonfirmasi';
                }
                break;

            case 'failure':
            case 'cancel':
            case 'expire':
                // Update timeline
                if (paymentTimelineIcon) {
                    paymentTimelineIcon.className = 'timeline-icon inactive';
                    paymentTimelineIcon.textContent = '❌';
                }
                
                if (paymentTimelineText) {
                    paymentTimelineText.textContent = 'Pembayaran gagal/dibatalkan';
                }

                if (paymentStatusText) {
                    paymentStatusText.textContent = '❌ Pembayaran gagal atau dibatalkan';
                }
                break;
        }
    }

    // Function to attach pay button listener
    function attachPayButtonListener(button) {
        if (!button) return;
        
        button.onclick = function() {
            // Disable button and show loading
            button.disabled = true;
            button.innerHTML = '<span class="spinner"></span>Memuat...';
            
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result){
                    console.log('Payment success:', result);
                    
                    showModal('success', 'Pembayaran Berhasil!', 'Terima kasih atas pembayaran Anda. Halaman akan dimuat ulang untuk menampilkan status terbaru.', function() {
                        window.location.reload();
                    });
                    
                    updatePaymentStatus('settlement');
                },
                onPending: function(result){
                    console.log('Payment pending:', result);
                    
                    showModal('pending', 'Pembayaran Sedang Diproses', 'Pembayaran Anda sedang diproses. Mohon tunggu konfirmasi dari sistem pembayaran.', function() {
                        // Check status after 5 seconds
                        setTimeout(checkPaymentStatus, 5000);
                    });
                    
                    // Re-enable button
                    button.disabled = false;
                    button.innerHTML = '💳 Bayar Sekarang - Rp {{ number_format($order->grand_total, 0, ",", ".") }}';
                },
                onError: function(result){
                    console.log('Payment error:', result);
                    
                    showModal('error', 'Pembayaran Gagal', 'Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi atau hubungi customer service jika masalah berlanjut.');
                    
                    updatePaymentStatus('failure');
                    
                    // Re-enable button
                    button.disabled = false;
                    button.innerHTML = '💳 Coba Bayar Lagi - Rp {{ number_format($order->grand_total, 0, ",", ".") }}';
                },
                onClose: function(){
                    console.log('Payment popup closed');
                    
                    // Re-enable button
                    button.disabled = false;
                    button.innerHTML = '💳 Bayar Sekarang - Rp {{ number_format($order->grand_total, 0, ",", ".") }}';
                }
            });
        };
    }

    // Check payment status function
    function checkPaymentStatus() {
        fetch('{{ route("orders.check-payment-status", $order->order_number) }}')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Payment status check:', data);
                if (data.status && data.status !== 'pending') {
                    updatePaymentStatus(data.status);
                    
                    // Show status update modal
                    if (data.status === 'settlement' || data.status === 'capture') {
                        showModal('success', 'Update Status', 'Pembayaran Anda telah berhasil dikonfirmasi!');
                    } else if (data.status === 'failure' || data.status === 'cancel' || data.status === 'expire') {
                        showModal('error', 'Update Status', 'Status pembayaran telah diperbarui. Pembayaran tidak berhasil.');
                    }
                }
            })
            .catch(error => {
                console.log('Error checking payment status:', error);
            });
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        const payButton = document.getElementById('pay-button');
        
        if (payButton) {
            attachPayButtonListener(payButton);
        } else {
            console.log('Pay button not found - payment might be completed or not using Midtrans');
        }

        // Auto check payment status for pending payments
        @if(!isset($order->payment_status) || $order->payment_status === 'pending')
        // Check status every 30 seconds
        const statusCheckInterval = setInterval(() => {
            checkPaymentStatus();
        }, 30000);

        // Show initial check after 5 seconds
        setTimeout(checkPaymentStatus, 5000);
        @endif
    });
</script>
@else
<script>
    console.log('Snap token not available for this order');
    
    // Still check payment status even without snap token
    function checkPaymentStatus() {
        fetch('{{ route("orders.check-payment-status", $order->order_number) }}')
            .then(response => response.json())
            .then(data => {
                console.log('Payment status check:', data);
                if (data.status && data.status !== 'pending') {
                    location.reload();
                }
            })
            .catch(error => {
                console.log('Error checking payment status:', error);
            });
    }

    // Check every 30 seconds for status updates
    @if(!isset($order->payment_status) || $order->payment_status === 'pending')
    setInterval(checkPaymentStatus, 30000);
    @endif
</script>
@endif

<!-- ESC key to close modal -->
<script>
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeModal();
    }
});
</script>

@endsection