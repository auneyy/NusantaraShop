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

        .modal-content {
            width: 95%;
            margin: 10% auto;
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
                                        <!-- <div class="item-specs">
                                            Ukuran: {{ $item->size }} | Qty: {{ $item->quantity }} | 
                                            @{{ number_format($item->product_price, 0, ',', '.') }}
                                        </div>
                                    </div>
                                    <div class="item-price">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </div> -->
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
                                <span class="info-label">Total Berat</span>
                                <span class="info-value">
                                    {{ number_format($order->orderItems->sum(function($item) {
                                        return $item->product->berat * $item->quantity;
                                    }), 0, ',', '.') }} gram
                                </span>
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
                                            Pembayaran berhasil
                                            @if($order->payment_completed_at)
                                                - {{ $order->payment_completed_at->format('d M Y, H:i') }} WIB
                                            @endif
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

                        <!-- Action Buttons -->
                        <div class="action-buttons">
                            <a href="{{ route('orders.index') }}" class="btn-primary-custom">
                                ← Kembali ke Daftar Pesanan
                            </a>
                            <a href="{{ route('products.index') }}" class="btn-outline-custom">
                                🛍️ Belanja Lagi
                            </a>
                            
                            @if($order->status === 'pending' && (!isset($order->payment_status) || $order->payment_status === 'pending'))
                            <form action="{{ route('orders.cancel', $order->order_number) }}" method="POST" style="display: inline-block;" 
                                  onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-danger-custom">
                                    ❌ Batalkan Pesanan
                                </button>
                            </form>
                            @endif
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
        const paymentTimelineIcon = document.getElementById('payment-timeline-icon');
        const paymentTimelineText = document.getElementById('payment-timeline-text');
        const processingTimelineIcon = document.getElementById('processing-timeline-icon');
        const orderStatusBadge = document.getElementById('order-status-badge');

        switch(status) {
            case 'settlement':
            case 'capture':
                statusContainer.innerHTML = `
                    <span class="status-badge status-failed">
                        ❌ Pembayaran Gagal
                    </span>
                `;

                // Update timeline
                if (paymentTimelineIcon) {
                    paymentTimelineIcon.className = 'timeline-icon inactive';
                    paymentTimelineIcon.textContent = '❌';
                }
                
                if (paymentTimelineText) {
                    paymentTimelineText.textContent = 'Pembayaran gagal/dibatalkan';
                }
                
                if (processingTimelineIcon) {
                    processingTimelineIcon.className = 'timeline-icon inactive';
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