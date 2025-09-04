@extends('layout.app')

@section('content')
<style>
    body {
        background-color: #f8f9fa;
    }

    .success-container {
        padding: 3rem 0;
        min-height: 80vh;
    }

    .success-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 30px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .success-header {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        padding: 2rem;
        text-align: center;
    }

    .success-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        animation: bounce 1s infinite alternate;
    }

    @keyframes bounce {
        0% { transform: translateY(0); }
        100% { transform: translateY(-10px); }
    }

    .success-content {
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
        width: 60px;
        height: 60px;
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
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, #422D1C 0%, #8B4513 100%);
        border: none;
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 8px;
        text-decoration: none;
        display: inline-block;
        margin: 0.5rem;
        transition: all 0.3s ease;
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
        margin: 0.5rem;
        transition: all 0.3s ease;
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
        margin: 0.5rem;
        transition: all 0.3s ease;
    }

    .btn-midtrans:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(33, 150, 243, 0.3);
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

    .midtrans-info {
        background: #f8f9fa;
        border-left: 4px solid #2196f3;
        padding: 1rem;
        margin: 1rem 0;
    }

    @media (max-width: 768px) {
        .success-container {
            padding: 1.5rem 0;
        }
        
        .success-content {
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
            display: flex;
            flex-direction: column;
        }
        
        .btn-primary-custom,
        .btn-outline-custom,
        .btn-midtrans {
            margin: 0.25rem 0;
        }
    }
</style>

<div class="success-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="success-card">
                    <!-- Header -->
                    <div class="success-header">
                        <div class="success-icon">✅</div>
                        <h2 class="mb-2">Pesanan Berhasil Dibuat!</h2>
                        <p class="mb-0">Silakan lakukan pembayaran untuk memproses pesanan Anda</p>
                    </div>

                    <div class="success-content">
                        <!-- Informasi Pesanan -->
                        <div class="order-info">
                            <h5 class="mb-3">📋 Detail Pesanan</h5>
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
                                    <span class="badge bg-warning text-dark">{{ $order->status_label }}</span>
                                </span>
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
                                <span class="info-label">Alamat:</span>
                                <span class="info-value">
                                    {{ $order->shipping_address }}, {{ $order->shipping_city }} {{ $order->shipping_postal_code }}
                                </span>
                            </div>
                        </div>

                        <!-- Informasi Pembayaran Midtrans -->
                        <div class="payment-info">
                            <h5 class="mb-3">💳 Informasi Pembayaran</h5>
                            
                            <div class="payment-status">
                                @if(isset($order->payment_status))
                                    @if($order->payment_status === 'pending')
                                        <span class="status-badge status-pending">
                                            ⏳ Menunggu Pembayaran
                                        </span>
                                    @elseif($order->payment_status === 'settlement' || $order->payment_status === 'capture')
                                        <span class="status-badge status-paid">
                                            ✅ Pembayaran Berhasil
                                        </span>
                                    @elseif($order->payment_status === 'failure' || $order->payment_status === 'cancel')
                                        <span class="status-badge status-failed">
                                            ❌ Pembayaran Gagal
                                        </span>
                                    @else
                                        <span class="status-badge status-pending">
                                            ⏳ Menunggu Pembayaran
                                        </span>
                                    @endif
                                @else
                                    <span class="status-badge status-pending">
                                        ⏳ Menunggu Pembayaran
                                    </span>
                                @endif
                            </div>

                            @if(!isset($order->payment_status) || $order->payment_status === 'pending')
                            <div class="midtrans-info">
                                <h6 class="text-primary mb-2">
                                    <i class="bi bi-info-circle"></i> Cara Pembayaran
                                </h6>
                                <p class="mb-2">
                                    1. Klik tombol "Bayar Sekarang" di bawah<br>
                                    2. Pilih metode pembayaran yang Anda inginkan<br>
                                    3. Ikuti instruksi pembayaran yang diberikan<br>
                                    4. Selesaikan pembayaran sebelum batas waktu berakhir
                                </p>
                                <small class="text-muted">
                                    💡 Jika Anda belum menyelesaikan pembayaran, gunakan tombol di bawah untuk melanjutkan
                                </small>
                            </div>

                            <!-- Tombol Bayar Sekarang (jika belum dibayar) -->
                            @if(isset($snapToken))
                            <div class="text-center mt-3">
                                <button class="btn-midtrans" id="pay-button">
                                    <i class="bi bi-credit-card me-2"></i>
                                    Bayar Sekarang - Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                                </button>
                            </div>
                            @endif
                            @elseif($order->payment_status === 'settlement' || $order->payment_status === 'capture')
                            <div class="alert alert-success">
                                <strong>🎉 Pembayaran Berhasil!</strong><br>
                                Terima kasih atas pembayaran Anda. Pesanan akan segera diproses.
                            </div>
                            @elseif($order->payment_status === 'failure' || $order->payment_status === 'cancel')
                            <div class="alert alert-danger">
                                <strong>❌ Pembayaran Gagal</strong><br>
                                Pembayaran tidak dapat diproses. Silakan coba lagi atau hubungi customer service.
                            </div>
                            
                            <!-- Tombol Bayar Ulang jika gagal -->
                            @if(isset($snapToken))
                            <div class="text-center mt-3">
                                <button class="btn-midtrans" id="pay-button">
                                    <i class="bi bi-credit-card me-2"></i>
                                    Bayar Ulang - Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                                </button>
                            </div>
                            @endif
                            @endif

                            <!-- Metode Pembayaran yang Tersedia -->
                            <div class="mt-3">
                                <h6 class="mb-2">Metode Pembayaran Tersedia:</h6>
                                <div class="d-flex justify-content-center align-items-center flex-wrap gap-2">
                                    <span class="badge bg-light text-dark">💳 Kartu Kredit/Debit</span>
                                    <span class="badge bg-light text-dark">🏦 Transfer Bank</span>
                                    <span class="badge bg-light text-dark">📱 GoPay, OVO, DANA</span>
                                    <span class="badge bg-light text-dark">🏪 Indomaret, Alfamart</span>
                                </div>
                            </div>
                        </div>

                        <!-- Timeline Pesanan -->
                        <div class="timeline">
                            <h5 class="mb-3">⏱️ Timeline Pesanan</h5>
                            
                            <div class="timeline-item">
                                <div class="timeline-icon active">✅</div>
                                <div class="timeline-content">
                                    <h6>Pesanan Diterima</h6>
                                    <small>{{ $order->order_date->format('d M Y, H:i') }} WIB</small>
                                </div>
                            </div>
                            
                            <div class="timeline-item">
                                <div class="timeline-icon {{ (!isset($order->payment_status) || $order->payment_status === 'pending') ? 'pending' : (($order->payment_status === 'settlement' || $order->payment_status === 'capture') ? 'active' : 'inactive') }}">
                                    {{ (!isset($order->payment_status) || $order->payment_status === 'pending') ? '⏳' : (($order->payment_status === 'settlement' || $order->payment_status === 'capture') ? '✅' : '❌') }}
                                </div>
                                <div class="timeline-content">
                                    <h6>Pembayaran</h6>
                                    <small>
                                        @if(!isset($order->payment_status) || $order->payment_status === 'pending')
                                            Menunggu pembayaran
                                        @elseif($order->payment_status === 'settlement' || $order->payment_status === 'capture')
                                            Pembayaran berhasil
                                        @else
                                            Pembayaran gagal/dibatalkan
                                        @endif
                                    </small>
                                </div>
                            </div>
                            
                            <div class="timeline-item">
                                <div class="timeline-icon {{ (isset($order->payment_status) && ($order->payment_status === 'settlement' || $order->payment_status === 'capture')) ? 'pending' : 'inactive' }}">📦</div>
                                <div class="timeline-content">
                                    <h6>Pesanan Diproses</h6>
                                    <small>Setelah pembayaran dikonfirmasi</small>
                                </div>
                            </div>
                            
                            <div class="timeline-item">
                                <div class="timeline-icon inactive">🚚</div>
                                <div class="timeline-content">
                                    <h6>Pesanan Dikirim</h6>
                                    <small>Estimasi 2-3 hari kerja</small>
                                </div>
                            </div>
                            
                            <div class="timeline-item">
                                <div class="timeline-icon inactive">✨</div>
                                <div class="timeline-content">
                                    <h6>Pesanan Diterima</h6>
                                    <small>Selamat menikmati produk Anda!</small>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="action-buttons">
                            <a href="{{ route('home') }}" class="btn-primary-custom">
                                🏠 Kembali ke Beranda
                            </a>
                            <a href="{{ route('products.index') }}" class="btn-outline-custom">
                                🛍️ Belanja Lagi
                            </a>
                        </div>

                        <!-- Info Tambahan -->
                        <div class="alert alert-info mt-4">
                            <strong>📞 Butuh Bantuan?</strong><br>
                            Jika ada pertanyaan mengenai pesanan atau pembayaran Anda, silakan hubungi customer service kami di WhatsApp <strong>+62 812-3456-7890</strong> 
                            atau email <strong>cs@tokofashion.com</strong> dengan menyertakan nomor pesanan <strong>{{ $order->order_number }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Midtrans Snap JS -->
@if(isset($snapToken))
<script type="text/javascript" src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function(){
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result){
                console.log('Payment success:', result);
                alert('Pembayaran berhasil!');
                // Redirect atau refresh halaman
                window.location.reload();
            },
            onPending: function(result){
                console.log('Payment pending:', result);
                alert('Pembayaran pending, silakan selesaikan pembayaran Anda');
                // Refresh halaman untuk update status
                window.location.reload();
            },
            onError: function(result){
                console.log('Payment error:', result);
                alert('Pembayaran gagal, silakan coba lagi');
            },
            onClose: function(){
                console.log('Payment popup closed');
                alert('Anda menutup popup pembayaran sebelum menyelesaikan pembayaran');
            }
        });
    };
</script>
@endif

<script>
// Auto refresh halaman setiap 60 detik untuk update status pembayaran
@if(!isset($order->payment_status) || $order->payment_status === 'pending')
setTimeout(function() {
    location.reload();
}, 60000);
@endif

// Check payment status setiap 30 detik jika masih pending
@if(!isset($order->payment_status) || $order->payment_status === 'pending')
setInterval(function() {
    fetch('{{ route("order.check-payment-status", $order->order_number) }}')
        .then(response => response.json())
        .then(data => {
            if (data.status !== 'pending') {
                location.reload();
            }
        })
        .catch(error => console.log('Error checking payment status:', error));
}, 30000);
@endif
</script>
@endsection