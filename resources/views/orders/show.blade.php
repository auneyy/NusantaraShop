@extends('layout.app')

@section('content')
<style>
    /* Reuse most styles from success.blade.php */
    body {
        background-color: #f8f9fa;
    }

    .order-container {
        padding: 2rem 0;
        min-height: 80vh;
    }

    .order-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 30px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .order-header {
        background: linear-gradient(135deg, #EFA942 0%, #8B4513 100%);
        color: white;
        padding: 2rem;
        text-align: center;
    }

    .order-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    .order-content {
        padding: 2rem;
    }

    .order-info {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 1.5rem;
        margin: 1.5rem 0;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
        padding: 0.5rem 0;
    }

    .info-row:last-child {
        margin-bottom: 0;
    }

    .info-label {
        font-weight: 600;
        color: #495057;
    }

    .info-value {
        color: #212529;
    }

    .order-items {
        margin: 1.5rem 0;
    }

    .item-card {
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
        background: white;
    }

    .item-details {
        display: flex;
        align-items: center;
    }

    .item-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 6px;
        margin-right: 1rem;
    }

    .item-info {
        flex: 1;
    }

    .item-name {
        font-weight: 600;
        color: #212529;
        margin-bottom: 0.25rem;
    }

    .item-specs {
        color: #6c757d;
        font-size: 0.9rem;
    }

    .item-price {
        font-weight: 600;
        color: #422D1C;
    }

    .payment-info {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        border: 1px solid #2196f3;
        border-radius: 10px;
        padding: 1.5rem;
        margin: 1.5rem 0;
        text-align: center;
    }

    .payment-status {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .status-pending {
        background-color: #fff3cd;
        color: #856404;
        border: 1px solid #ffeaa7;
    }

    .status-paid {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .status-failed {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .action-buttons {
        text-align: center;
        margin-top: 2rem;
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, #422D1C 0%, #8B4513 100%);
        border: none;
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 8px;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(66, 45, 28, 0.3);
        color: white;
        text-decoration: none;
    }

    .btn-outline-custom {
        border: 2px solid #422D1C;
        color: #422D1C;
        background: transparent;
        padding: 0.75rem 2rem;
        border-radius: 8px;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .btn-outline-custom:hover {
        background: #422D1C;
        color: white;
        text-decoration: none;
    }

    .btn-midtrans {
        background: linear-gradient(135deg, #2196f3 0%, #1976d2 100%);
        border: none;
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 8px;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        cursor: pointer;
        font-weight: 500;
    }

    .btn-midtrans:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(33, 150, 243, 0.3);
        color: white;
        text-decoration: none;
    }

    .btn-danger-custom {
        background: #dc3545;
        border: none;
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 8px;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        cursor: pointer;
        font-weight: 500;
    }

    .btn-danger-custom:hover {
        background: #c82333;
        color: white;
        text-decoration: none;
    }

    .timeline {
        margin: 1.5rem 0;
    }

    .timeline-item {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
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
    }

    .timeline-icon.active {
        background: #28a745;
        color: white;
    }

    .timeline-icon.pending {
        background: #ffc107;
        color: white;
    }

    .timeline-icon.inactive {
        background: #e9ecef;
        color: #6c757d;
    }

    .timeline-content h6 {
        margin-bottom: 0.25rem;
        color: #212529;
    }

    .timeline-content small {
        color: #6c757d;
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

    @media (max-width: 768px) {
        .order-container {
            padding: 1rem 0;
        }
        
        .order-content {
            padding: 1.5rem;
        }
        
        .info-row {
            flex-direction: column;
            gap: 0.25rem;
        }
        
        .item-details {
            flex-direction: column;
            text-align: center;
        }
        
        .item-image {
            margin-right: 0;
            margin-bottom: 1rem;
        }
        
        .action-buttons {
            flex-direction: column;
            align-items: center;
        }
        
        .btn-primary-custom,
        .btn-outline-custom,
        .btn-midtrans,
        .btn-danger-custom {
            width: 100%;
            max-width: 300px;
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

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="order-card">
                    <!-- Header -->
                    <div class="order-header">
                        <div class="order-icon">📦</div>
                        <h2 class="mb-2">Detail Pesanan</h2>
                        <p class="mb-0">{{ $order->order_number }}</p>
                    </div>

                    <div class="order-content">
                        <!-- Informasi Pesanan -->
                        <div class="order-info">
                            <h5 class="mb-3">📋 Informasi Pesanan</h5>
                            <div class="info-row">
                                <span class="info-label">Nomor Pesanan:</span>
                                <span class="info-value"><strong>{{ $order->order_number }}</strong></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Tanggal Pesanan:</span>
                                <span class="info-value">{{ $order->order_date->format('d F Y, H:i') }} WIB</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Status:</span>
                                <span class="info-value">
                                    <span class="badge bg-warning text-dark" id="order-status-badge">{{ $order->status_label }}</span>
                                </span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Metode Pembayaran:</span>
                                <span class="info-value">{{ $order->payment_method_label }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Total Pembayaran:</span>
                                <span class="info-value"><strong>Rp {{ number_format($order->grand_total, 0, ',', '.') }}</strong></span>
                            </div>
                        </div>

                        <!-- Items yang dibeli -->
                        <div class="order-items">
                            <h5 class="mb-3">🛍️ Produk yang Dipesan</h5>
                            @foreach($order->orderItems as $item)
                            <div class="item-card">
                                <div class="item-details">
                                    <img src="{{ $item->product->images->first()->image_path ?? 'path/to/placeholder.jpg' }}" 
                                         alt="{{ $item->product_name }}" class="item-image">
                                    <div class="item-info">
                                        <div class="item-name">{{ $item->product_name }}</div>
                                        <div class="item-specs">
                                            Ukuran: {{ $item->size }} | Qty: {{ $item->quantity }} | 
                                            @{{ number_format($item->product_price, 0, ',', '.') }}
                                        </div>
                                    </div>
                                    <div class="item-price">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                            @endforeach

                            <!-- Order Summary -->
                            <div class="order-info mt-3">
                                <div class="info-row">
                                    <span class="info-label">Subtotal</span>
                                    <span class="info-value">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Ongkos Kirim</span>
                                    <span class="info-value">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                                </div>
                                <div class="info-row" style="border-top: 2px solid #dee2e6; padding-top: 1rem; margin-top: 1rem; font-weight: 600; font-size: 1.1rem; color: #422D1C;">
                                    <span class="info-label">Total</span>
                                    <span class="info-value">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Pengiriman -->
                        <div class="order-info">
                            <h5 class="mb-3">📦 Informasi Pengiriman</h5>
                            <div class="info-row">
                                <span class="info-label">Nama Penerima:</span>
                                <span class="info-value">{{ $order->shipping_name }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">No. Telepon:</span>
                                <span class="info-value">{{ $order->shipping_phone }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Email:</span>
                                <span class="info-value">{{ $order->shipping_email }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Alamat:</span>
                                <span class="info-value">
                                    {{ $order->shipping_address }}, {{ $order->shipping_city }} {{ $order->shipping_postal_code }}
                                </span>
                            </div>
                        </div>

                        <!-- Informasi Pembayaran -->
                        @if($order->payment_method === 'midtrans')
                        <div class="payment-info">
                            <h5 class="mb-3">💳 Status Pembayaran</h5>
                            
                            <div class="payment-status" id="payment-status-container">
                                @if(!isset($order->payment_status) || $order->payment_status === 'pending')
                                    <span class="status-badge status-pending">
                                        ⏳ Menunggu Pembayaran
                                    </span>
                                @elseif($order->payment_status === 'settlement' || $order->payment_status === 'capture')
                                    <span class="status-badge status-paid">
                                        ✅ Pembayaran Berhasil
                                    </span>
                                @else
                                    <span class="status-badge status-failed">
                                        ❌ {{ $order->payment_status_label }}
                                    </span>
                                @endif
                            </div>

                            @if((!isset($order->payment_status) || $order->payment_status === 'pending') && isset($snapToken))
                            <div class="text-center mt-3">
                                <button class="btn-midtrans" id="pay-button">
                                    💳 Bayar Sekarang - Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                                </button>
                            </div>
                            @endif
                        </div>
                        @endif

                        <!-- Timeline Pesanan -->
                        <div class="timeline" id="order-timeline">
                            <h5 class="mb-3">⏱️ Timeline Pesanan</h5>
                            
                            <div class="timeline-item">
                                <div class="timeline-icon active">✅</div>
                                <div class="timeline-content">
                                    <h6>Pesanan Diterima</h6>
                                    <small>{{ $order->order_date->format('d M Y, H:i') }} WIB</small>
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
                                            Pembayaran berhasil - {{ $order->payment_completed_at->format('d M Y, H:i') }} WIB
                                        @else
                                            Pembayaran gagal/dibatalkan
                                        @endif
                                    </small>
                                </div>
                            </div>
                            
                            <div class="timeline-item">
                                <div class="timeline-icon {{ $order->status === 'processing' ? 'active' : (in_array($order->status, ['shipped', 'delivered']) ? 'active' : 'inactive') }}" id="processing-timeline-icon">📦</div>
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
                                            {{ $order->shipped_date->format('d M Y, H:i') }} WIB
                                        @else
                                            Estimasi 2-3 hari kerja setelah pembayaran
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
                                            {{ $order->delivered_date->format('d M Y, H:i') }} WIB
                                        @else
                                            Selamat menikmati produk Anda!
                                        @endif
                                    </small>
                                </div>
                            </div>
                        </div>
                        @endsection