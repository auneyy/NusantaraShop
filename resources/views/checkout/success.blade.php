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
        cursor: pointer;
    }

    .btn-midtrans:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(33, 150, 243, 0.3);
        color: white;
        text-decoration: none;
    }

    .btn-midtrans:disabled {
        background: #ccc;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
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

    /* Custom Modal Styles */
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
        background: #007bff;
        color: white;
        border: none;
        padding: 0.5rem 1.5rem;
        border-radius: 8px;
        cursor: pointer;
        margin: 0.25rem;
    }

    .btn-modal:hover {
        background: #0056b3;
    }

    .btn-modal.secondary {
        background: #6c757d;
    }

    .btn-modal.secondary:hover {
        background: #495057;
    }

    /* Loading Spinner */
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

        .modal-content {
            width: 95%;
            margin: 10% auto;
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
                                    <span class="badge bg-warning text-dark" id="order-status-badge">{{ $order->status_label }}</span>
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
                            
                            <div class="payment-status" id="payment-status-container">
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

                            <div id="payment-content">
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
                            </div>

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
                                            Pembayaran berhasil
                                        @else
                                            Pembayaran gagal/dibatalkan
                                        @endif
                                    </small>
                                </div>
                            </div>
                            
                            <div class="timeline-item">
                                <div class="timeline-icon {{ (isset($order->payment_status) && ($order->payment_status === 'settlement' || $order->payment_status === 'capture')) ? 'pending' : 'inactive' }}" id="processing-timeline-icon">📦</div>
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
        const statusContainer = document.getElementById('payment-status-container');
        const paymentContent = document.getElementById('payment-content');
        const paymentTimelineIcon = document.getElementById('payment-timeline-icon');
        const paymentTimelineText = document.getElementById('payment-timeline-text');
        const processingTimelineIcon = document.getElementById('processing-timeline-icon');
        const orderStatusBadge = document.getElementById('order-status-badge');

        switch(status) {
            case 'settlement':
            case 'capture':
                // Update payment status
                statusContainer.innerHTML = `
                    <span class="status-badge status-paid">
                        ✅ Pembayaran Berhasil
                    </span>
                `;
                
                // Update payment content
                paymentContent.innerHTML = `
                    <div class="alert alert-success">
                        <strong>🎉 Pembayaran Berhasil!</strong><br>
                        Terima kasih atas pembayaran Anda. Pesanan akan segera diproses.
                    </div>
                `;

                // Update timeline
                paymentTimelineIcon.className = 'timeline-icon active';
                paymentTimelineIcon.textContent = '✅';
                paymentTimelineText.textContent = 'Pembayaran berhasil';
                
                processingTimelineIcon.className = 'timeline-icon pending';
                
                // Update order status
                orderStatusBadge.className = 'badge bg-success text-white';
                orderStatusBadge.textContent = 'Sedang Diproses';
                break;
                
            case 'failure':
            case 'cancel':
            case 'expire':
                // Update payment status
                statusContainer.innerHTML = `
                    <span class="status-badge status-failed">
                        ❌ Pembayaran Gagal
                    </span>
                `;
                
                // Update payment content
                paymentContent.innerHTML = `
                    <div class="alert alert-danger">
                        <strong>❌ Pembayaran Gagal</strong><br>
                        Pembayaran tidak dapat diproses. Silakan coba lagi atau hubungi customer service.
                    </div>
                    @if(isset($snapToken))
                    <div class="text-center mt-3">
                        <button class="btn-midtrans" id="pay-button-retry">
                            <i class="bi bi-credit-card me-2"></i>
                            Bayar Ulang - Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                        </button>
                    </div>
                    @endif
                `;

                // Update timeline
                paymentTimelineIcon.className = 'timeline-icon inactive';
                paymentTimelineIcon.textContent = '❌';
                paymentTimelineText.textContent = 'Pembayaran gagal/dibatalkan';
                
                processingTimelineIcon.className = 'timeline-icon inactive';
                
                // Re-attach event listener for retry button
                setTimeout(() => {
                    const retryBtn = document.getElementById('pay-button-retry');
                    if (retryBtn) {
                        attachPayButtonListener(retryBtn);
                    }
                }, 100);
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
                    button.innerHTML = '<i class="bi bi-credit-card me-2"></i>Bayar Sekarang - Rp {{ number_format($order->grand_total, 0, ",", ".") }}';
                },
                onError: function(result){
                    console.log('Payment error:', result);
                    
                    showModal('error', 'Pembayaran Gagal', 'Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi atau hubungi customer service jika masalah berlanjut.');
                    
                    updatePaymentStatus('failure');
                    
                    // Re-enable button
                    button.disabled = false;
                    button.innerHTML = '<i class="bi bi-credit-card me-2"></i>Coba Bayar Lagi - Rp {{ number_format($order->grand_total, 0, ",", ".") }}';
                },
                onClose: function(){
                    console.log('Payment popup closed');
                    
                    // Re-enable button
                    button.disabled = false;
                    button.innerHTML = '<i class="bi bi-credit-card me-2"></i>Bayar Sekarang - Rp {{ number_format($order->grand_total, 0, ",", ".") }}';
                }
            });
        };
    }

    // Check payment status function
    function checkPaymentStatus() {
        fetch('{{ route("checkout.check-payment-status", $order->order_number) }}')
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
                        showModal('success', 'Status Update', 'Pembayaran Anda telah berhasil dikonfirmasi!');
                    } else if (data.status === 'failure' || data.status === 'cancel' || data.status === 'expire') {
                        showModal('error', 'Status Update', 'Status pembayaran telah diperbarui. Pembayaran tidak berhasil.');
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
            console.error('Pay button not found');
        }

        // Auto check payment status for pending payments
        @if(!isset($order->payment_status) || $order->payment_status === 'pending')
        // Check status every 15 seconds for first 2 minutes, then every 30 seconds
        let checkCount = 0;
        const statusCheckInterval = setInterval(() => {
            checkPaymentStatus();
            checkCount++;
            
            // After 8 checks (2 minutes), change to 30 second intervals
            if (checkCount >= 8) {
                clearInterval(statusCheckInterval);
                
                // Continue checking every 30 seconds for another 5 minutes
                let extendedCheckCount = 0;
                const extendedInterval = setInterval(() => {
                    checkPaymentStatus();
                    extendedCheckCount++;
                    
                    // Stop after 10 more checks (5 minutes)
                    if (extendedCheckCount >= 10) {
                        clearInterval(extendedInterval);
                        
                        // Show final reminder modal
                        showModal('pending', 'Pemeriksaan Status Otomatis Berhenti', 'Sistem berhenti memeriksa status pembayaran secara otomatis. Anda dapat menyegarkan halaman secara manual untuk melihat status terbaru.', function() {
                            window.location.reload();
                        });
                    }
                }, 30000);
            }
        }, 15000);

        // Show initial reminder for pending payments
        setTimeout(() => {
            showModal('pending', 'Reminder Pembayaran', 'Jangan lupa untuk menyelesaikan pembayaran Anda. Status akan diperbarui secara otomatis setelah pembayaran berhasil.');
        }, 5000);
        @endif
    });
</script>
@else
<script>
    console.log('Snap token not available:', {!! json_encode($snapToken ?? 'undefined') !!});
    
    // Still check payment status even without snap token
    function checkPaymentStatus() {
        fetch('{{ route("checkout.check-payment-status", $order->order_number) }}')
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

    // Check every 30 seconds for non-Midtrans orders
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