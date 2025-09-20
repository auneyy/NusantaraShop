@extends('layout.app')

@section('content')
<style>
    .orders-container {
        padding: 2rem 0;
        min-height: 80vh;
    }

    .orders-header {
        background: linear-gradient(135deg, #EFA942 0%, #8B4513 100%);
        color: white;
        padding: 2rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        text-align: center;
    }

    .orders-header h2 {
        margin: 0 0 0.5rem 0;
        font-weight: 600;
    }

    .filter-tabs {
        background: white;
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .nav-pills .nav-link {
        color: #8B4513;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        margin: 0 0.25rem;
        transition: all 0.3s ease;
        font-weight: 500;
        border: none;
        background: none;
        cursor: pointer;
    }

    .nav-pills .nav-link:hover {
        background: rgba(66, 45, 28, 0.1);
    }

    .nav-pills .nav-link.active {
        background: #EFA942;
        color: white;
    }

    .order-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        margin-bottom: 1.5rem;
        overflow: hidden;
        transition: transform 0.2s ease;
    }

    .order-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 25px rgba(0,0,0,0.15);
    }

    .order-card-header {
        background: #f8f9fa;
        padding: 1.5rem;
        border-bottom: 1px solid #dee2e6;
    }

    .order-info {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .order-number {
        font-size: 1.1rem;
        font-weight: 600;
        color: #422D1C;
        margin-bottom: 0.5rem;
    }

    .order-date {
        color: #6c757d;
        font-size: 0.9rem;
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
        margin-bottom: 0.5rem;
        display: inline-block;
    }

    .status-pending { background: #fff3cd; color: #856404; }
    .status-processing { background: #d4edda; color: #155724; }
    .status-shipped { background: #cce7ff; color: #004085; }
    .status-delivered { background: #d1ecf1; color: #0c5460; }
    .status-cancelled { background: #f8d7da; color: #721c24; }

    .payment-status {
        font-size: 0.8rem;
        color: #6c757d;
    }

    .order-card-body {
        padding: 1.5rem;
    }

    .order-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .order-item:last-child {
        border-bottom: none;
    }

    .item-image {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 6px;
        margin-right: 1rem;
    }

    .item-details {
        flex: 1;
    }

    .item-name {
        font-weight: 500;
        margin-bottom: 0.25rem;
    }

    .item-specs {
        color: #6c757d;
        font-size: 0.85rem;
    }

    .item-price {
        font-weight: 600;
        color: #422D1C;
    }

    .order-summary {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
        margin: 1rem 0;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }

    .summary-row.total {
        font-weight: 600;
        font-size: 1rem;
        color: #422D1C;
        border-top: 1px solid #dee2e6;
        padding-top: 0.5rem;
        margin-top: 0.5rem;
    }

    .order-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .btn-action {
        padding: 0.5rem 1rem;
        border-radius: 6px;
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 500;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
    }

    .btn-primary-action {
        background: #EFA942;
        color: white;
    }

    .btn-primary-action:hover {
        background:rgb(222, 140, 17);
        color: white;
        text-decoration: none;
    }

    .btn-outline-action {
        background: transparent;
        color: #EFA942;
        border: 1px solid #EFA942;
    }

    .btn-outline-action:hover {
        background: #EFA942;
        color: white;
        text-decoration: none;
    }

    .btn-danger-action {
        background: #dc3545;
        color: white;
    }

    .btn-danger-action:hover {
        background: #c82333;
        color: white;
        text-decoration: none;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.1);
    }

    .empty-icon {
        font-size: 4rem;
        color: #dee2e6;
        margin-bottom: 1rem;
    }

    .empty-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #6c757d;
        margin-bottom: 0.5rem;
    }

    .btn-shop {
        background: #EFA942;
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-shop:hover {
        background: rgb(222, 140, 17);
        color: white;
        text-decoration: none;
    }

    .more-items {
        text-align: center;
        padding: 0.75rem;
        color: #6c757d;
        font-size: 0.85rem;
        background: rgba(108, 117, 125, 0.1);
        border-radius: 6px;
        margin-top: 0.5rem;
    }

    /* Custom Modal */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 1000;
        animation: fadeIn 0.3s ease;
    }

    .modal-overlay.show {
        display: flex;
    }

    .modal-content {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        max-width: 400px;
        width: 90%;
        text-align: center;
        transform: scale(0.8);
        animation: modalShow 0.3s ease forwards;
    }

    .modal-icon {
        font-size: 3rem;
        color: #dc3545;
        margin-bottom: 1rem;
    }

    .modal-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #212529;
        margin-bottom: 0.5rem;
    }

    .modal-text {
        color: #6c757d;
        margin-bottom: 2rem;
        line-height: 1.5;
    }

    .modal-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
    }

    .modal-btn {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 8px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-block;
        min-width: 100px;
    }

    .modal-btn-cancel {
        background: #6c757d;
        color: white;
    }

    .modal-btn-cancel:hover {
        background: #545b62;
    }

    .modal-btn-confirm {
        background: #dc3545;
        color: white;
    }

    .modal-btn-confirm:hover {
        background: #c82333;
    }

    /* Toast Notification */
    .toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1100;
    }

    .toast {
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        padding: 1rem 1.5rem;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        min-width: 300px;
        transform: translateX(400px);
        transition: transform 0.3s ease;
    }

    .toast.show {
        transform: translateX(0);
    }

    .toast-success {
        border-left: 4px solid #28a745;
    }

    .toast-error {
        border-left: 4px solid #dc3545;
    }

    .toast-info {
        border-left: 4px solid #17a2b8;
    }

    .toast-icon {
        font-size: 1.25rem;
    }

    .toast-success .toast-icon {
        color: #28a745;
    }

    .toast-error .toast-icon {
        color: #dc3545;
    }

    .toast-info .toast-icon {
        color: #17a2b8;
    }

    .toast-content {
        flex: 1;
    }

    .toast-title {
        font-weight: 600;
        margin-bottom: 0.25rem;
        font-size: 0.9rem;
    }

    .toast-message {
        color: #6c757d;
        font-size: 0.85rem;
    }

    .toast-close {
        background: none;
        border: none;
        font-size: 1.25rem;
        color: #6c757d;
        cursor: pointer;
        padding: 0;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .toast-close:hover {
        color: #495057;
    }

    /* Hidden class for filtering */
    .order-card.hidden {
        display: none !important;
    }

    /* Filter result message */
    .filter-result {
        text-align: center;
        padding: 2rem;
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        color: #6c757d;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes modalShow {
        to { transform: scale(1); }
    }

    /* Custom Pagination */
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
        margin: 2rem 0;
    }

    .pagination .page-item {
        list-style: none;
    }

    .pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        color: #422D1C;
        text-decoration: none;
        transition: all 0.2s ease;
        background: white;
    }

    .pagination .page-link:hover {
        background: #EFA942;
        color: white;
        border-color: #EFA942;
    }

    .pagination .page-item.active .page-link {
        background: #EFA942;
        color: white;
        border-color: #EFA942;
    }

    .pagination .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
        background: #f8f9fa;
    }

    /* Pagination SVG Icons */
    .pagination-icon {
        width: 16px;
        height: 16px;
        fill: currentColor;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .orders-container {
            padding: 1rem 0;
        }
        
        .orders-header {
            padding: 1.5rem 1rem;
        }
        
        .order-info {
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .order-item {
            flex-wrap: wrap;
        }
        
        .item-image {
            width: 50px;
            height: 50px;
        }
        
        .order-actions {
            justify-content: center;
        }
        
        .nav-pills {
            flex-wrap: wrap;
        }
        
        .nav-pills .nav-link {
            margin: 0.25rem;
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
        }
    }
</style>

<div class="orders-container">
    <div class="container">
        <!-- Header -->
        <div class="orders-header">
            <h2>📋 Pesanan Saya</h2>
            <p class="mb-0">Kelola dan pantau semua pesanan Anda</p>
        </div>

        @if($orders->count() > 0)
        <!-- Filter Tabs -->
        <div class="filter-tabs">
            <ul class="nav nav-pills justify-content-center" id="orderTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" data-filter="all" type="button">
                        Semua ({{ $orders->total() }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-filter="pending" type="button">
                        Pending ({{ $orders->where('status', 'pending')->count() }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-filter="processing" type="button">
                        Diproses ({{ $orders->where('status', 'processing')->count() }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-filter="shipped" type="button">
                        Dikirim ({{ $orders->where('status', 'shipped')->count() }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-filter="delivered" type="button">
                        Selesai ({{ $orders->where('status', 'delivered')->count() }})
                    </button>
                </li>
            </ul>
        </div>

        <!-- Orders List -->
        <div id="ordersContainer">
            @foreach($orders as $order)
            <div class="order-card" data-status="{{ $order->status }}" data-payment-status="{{ $order->payment_status ?? 'pending' }}">
                <div class="order-card-header">
                    <div class="order-info">
                        <div>
                            <div class="order-number">{{ $order->order_number }}</div>
                            <div class="order-date">{{ $order->order_date->format('d F Y, H:i') }} WIB</div>
                        </div>
                        <div class="order-status">
                            <div class="status-badge status-{{ $order->status }}">
                                @switch($order->status)
                                    @case('pending')
                                        Menunggu Pembayaran
                                        @break
                                    @case('processing')
                                        Diproses
                                        @break
                                    @case('shipped')
                                        Dikirim
                                        @break
                                    @case('delivered')
                                        Selesai
                                        @break
                                    @case('cancelled')
                                        Dibatalkan
                                        @break
                                    @default
                                        {{ ucfirst($order->status) }}
                                @endswitch
                            </div>
                            <div class="payment-status">
                                💳 
                                @switch($order->payment_status ?? 'pending')
                                    @case('pending')
                                        Belum Dibayar
                                        @break
                                    @case('paid')
                                        Sudah Dibayar
                                        @break
                                    @case('failed')
                                        Pembayaran Gagal
                                        @break
                                    @case('expired')
                                        Kedaluwarsa
                                        @break
                                    @default
                                        {{ ucfirst($order->payment_status ?? 'pending') }}
                                @endswitch
                            </div>
                        </div>
                    </div>
                </div>

                <div class="order-card-body">
                    <!-- Order Items Preview (max 3) -->
                    <div class="order-items">
                        @foreach($order->orderItems->take(3) as $item)
                        <div class="order-item">
                            <img src="{{ $item->product->images->first()->image_path ?? 'https://via.placeholder.com/60x60?text=No+Image' }}" 
                                 alt="{{ $item->product_name }}" class="item-image">
                            <div class="item-details">
                                <div class="item-name">{{ $item->product_name }}</div>
                                <div class="item-specs">
                                    Ukuran: {{ $item->size }} | Qty: {{ $item->quantity }}
                                </div>
                            </div>
                            <div class="item-price">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </div>
                        </div>
                        @endforeach
                        
                        @if($order->orderItems->count() > 3)
                            <div class="more-items">
                                +{{ $order->orderItems->count() - 3 }} produk lainnya
                            </div>
                        @endif
                    </div>

                    <!-- Order Summary -->
                    <div class="order-summary">
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-row">
                            <span>Ongkos Kirim</span>
                            <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-row total">
                            <span>Total</span>
                            <span>Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="order-actions">
                        <a href="{{ route('orders.show', $order->order_number) }}" class="btn-action btn-primary-action">
                            Detail Pesanan
                        </a>
                        
                        @if($order->payment_method === 'midtrans' && ($order->payment_status === 'pending' || !isset($order->payment_status)) && $order->status !== 'cancelled')
                            <a href="{{ route('orders.show', $order->order_number) }}" class="btn-action btn-outline-action">
                                Bayar Sekarang
                            </a>
                        @endif
                        
                        @if(($order->payment_status === 'pending' || !isset($order->payment_status)) && $order->status !== 'cancelled')
                            <form action="{{ route('orders.cancel', $order->order_number) }}" method="POST" style="display: inline;" 
                                  class="cancel-form" data-order-number="{{ $order->order_number }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-danger-action">
                                    Batalkan
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach

            <!-- No results message (initially hidden) -->
            <div id="noResultsMessage" class="filter-result" style="display: none;">
                <div style="font-size: 2rem; margin-bottom: 1rem;">📋</div>
                <h4>Tidak ada pesanan</h4>
                <p>Tidak ada pesanan dengan status yang dipilih.</p>
            </div>
        </div>

        <!-- Custom Pagination -->
        <div class="d-flex justify-content-center mt-4">
            @if ($orders->hasPages())
                <nav aria-label="Pagination Navigation">
                    <ul class="pagination">
                        {{-- Previous Page Link --}}
                        @if ($orders->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">
                                    <svg class="pagination-icon" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $orders->previousPageUrl() }}">
                                    <svg class="pagination-icon" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                            @if ($page == $orders->currentPage())
                                <li class="page-item active">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($orders->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $orders->nextPageUrl() }}">
                                    <svg class="pagination-icon" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">
                                    <svg class="pagination-icon" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </span>
                            </li>
                        @endif
                    </ul>
                </nav>
            @endif
        </div>
        
        @else
        <!-- Empty State -->
        <div class="empty-state">
            <div class="empty-icon">📦</div>
            <h3 class="empty-title">Belum Ada Pesanan</h3>
            <p class="empty-text">Anda belum memiliki pesanan. Mulai berbelanja sekarang untuk melihat pesanan Anda di sini.</p>
            <a href="{{ route('products.index') }}" class="btn-shop">
                Mulai Belanja
            </a>
        </div>
        @endif
    </div>
</div>

<!-- Custom Modal for Cancel Confirmation -->
<div id="cancelModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-icon">⚠️</div>
        <h4 class="modal-title">Batalkan Pesanan</h4>
        <p class="modal-text">Apakah Anda yakin ingin membatalkan pesanan ini? Tindakan ini tidak dapat dibatalkan.</p>
        <div class="modal-buttons">
            <button type="button" class="modal-btn modal-btn-cancel" onclick="hideCancelModal()">
                Batal
            </button>
            <button type="button" class="modal-btn modal-btn-confirm" onclick="confirmCancel()">
                Ya, Batalkan
            </button>
        </div>
    </div>
</div>

<!-- Toast Container -->
<div class="toast-container" id="toastContainer"></div>

<script>
let currentCancelForm = null;
let currentFilter = 'all';

document.addEventListener('DOMContentLoaded', function() {
    // Initialize filter tabs
    initializeFilterTabs();
    
    // Initialize cancel forms
    initializeCancelForms();
    
    // Auto-refresh payment status for pending orders
    const pendingOrders = document.querySelectorAll('[data-status="pending"]');
    if (pendingOrders.length > 0) {
        setInterval(() => {
            pendingOrders.forEach(orderCard => {
                const orderNumber = orderCard.querySelector('.order-number').textContent.trim();
                checkOrderPaymentStatus(orderNumber);
            });
        }, 30000);
    }

    // Close modal when clicking outside
    document.getElementById('cancelModal').addEventListener('click', function(e) {
        if (e.target === this) {
            hideCancelModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            hideCancelModal();
        }
    });
});

function initializeFilterTabs() {
    const tabs = document.querySelectorAll('#orderTabs button[data-filter]');
    
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');
            
            // Update active tab
            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            // Filter orders
            filterOrders(filter);
            currentFilter = filter;
        });
    });
}

function initializeCancelForms() {
    const cancelForms = document.querySelectorAll('.cancel-form');
    
    cancelForms.forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            showCancelModal(this);
        });
    });
}

function filterOrders(filter) {
    const orderCards = document.querySelectorAll('.order-card');
    const noResultsMessage = document.getElementById('noResultsMessage');
    let visibleCount = 0;
    
    orderCards.forEach(card => {
        const cardStatus = card.getAttribute('data-status');
        let shouldShow = false;
        
        if (filter === 'all') {
            shouldShow = true;
        } else if (filter === 'delivered' && cardStatus === 'delivered') {
            shouldShow = true;
        } else if (cardStatus === filter) {
            shouldShow = true;
        }
        
        if (shouldShow) {
            card.classList.remove('hidden');
            visibleCount++;
        } else {
            card.classList.add('hidden');
        }
    });
    
    // Show/hide no results message
    if (visibleCount === 0 && filter !== 'all') {
        noResultsMessage.style.display = 'block';
    } else {
        noResultsMessage.style.display = 'none';
    }
}

function showCancelModal(form) {
    currentCancelForm = form;
    const modal = document.getElementById('cancelModal');
    modal.classList.add('show');
}

function hideCancelModal() {
    const modal = document.getElementById('cancelModal');
    modal.classList.remove('show');
    currentCancelForm = null;
}

function confirmCancel() {
    if (currentCancelForm) {
        const submitButton = currentCancelForm.querySelector('button[type="submit"]');
        const originalContent = submitButton.innerHTML;
        
        // Add loading state
        submitButton.innerHTML = '<span style="display: inline-flex; align-items: center; gap: 0.5rem;"><svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10" fill="none" stroke="currentColor" stroke-width="2"/><path d="M12 6v6l4 2" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>Membatalkan...</span>';
        submitButton.disabled = true;
        
        // Hide modal
        hideCancelModal();
        
        // Show processing toast
        showToast('Sedang memproses pembatalan...', 'info');
        
        // Get order number for removal after success
        const orderNumber = currentCancelForm.getAttribute('data-order-number');
        
        // Submit form via AJAX to handle response
        const formData = new FormData(currentCancelForm);
        const action = currentCancelForm.getAttribute('action');
        
        fetch(action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove the order card from DOM
                const orderCard = currentCancelForm.closest('.order-card');
                if (orderCard) {
                    orderCard.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                    orderCard.style.opacity = '0';
                    orderCard.style.transform = 'translateY(-20px)';
                    
                    setTimeout(() => {
                        orderCard.remove();
                        
                        // Update tab counts
                        updateTabCounts();
                        
                        // Reapply current filter
                        filterOrders(currentFilter);
                        
                        // Check if no orders left
                        checkEmptyState();
                    }, 300);
                }
                
                showToast(data.message || 'Pesanan berhasil dibatalkan', 'success');
            } else {
                showToast(data.message || 'Gagal membatalkan pesanan', 'error');
                // Restore button
                submitButton.innerHTML = originalContent;
                submitButton.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Terjadi kesalahan saat membatalkan pesanan', 'error');
            // Restore button
            submitButton.innerHTML = originalContent;
            submitButton.disabled = false;
        });
    }
}

function updateTabCounts() {
    const tabs = document.querySelectorAll('#orderTabs button[data-filter]');
    const orderCards = document.querySelectorAll('.order-card');
    
    // Count orders by status
    const counts = {
        all: orderCards.length,
        pending: 0,
        processing: 0,
        shipped: 0,
        delivered: 0,
        cancelled: 0
    };
    
    orderCards.forEach(card => {
        const status = card.getAttribute('data-status');
        if (counts.hasOwnProperty(status)) {
            counts[status]++;
        }
    });
    
    // Update tab text
    tabs.forEach(tab => {
        const filter = tab.getAttribute('data-filter');
        const count = counts[filter] || 0;
        
        let label = '';
        switch(filter) {
            case 'all':
                label = `Semua (${count})`;
                break;
            case 'pending':
                label = `Pending (${count})`;
                break;
            case 'processing':
                label = `Diproses (${count})`;
                break;
            case 'shipped':
                label = `Dikirim (${count})`;
                break;
            case 'delivered':
                label = `Selesai (${count})`;
                break;
        }
        
        tab.textContent = label;
    });
}

function checkEmptyState() {
    const orderCards = document.querySelectorAll('.order-card');
    const container = document.querySelector('.orders-container .container');
    
    if (orderCards.length === 0) {
        // Replace entire content with empty state
        container.innerHTML = `
            <div class="orders-header">
                <h2>📋 Pesanan Saya</h2>
                <p class="mb-0">Kelola dan pantau semua pesanan Anda</p>
            </div>
            <div class="empty-state">
                <div class="empty-icon">📦</div>
                <h3 class="empty-title">Belum Ada Pesanan</h3>
                <p class="empty-text">Anda belum memiliki pesanan. Mulai berbelanja sekarang untuk melihat pesanan Anda di sini.</p>
                <a href="${window.location.origin}/products" class="btn-shop">
                    Mulai Belanja
                </a>
            </div>
        `;
    }
}

function showToast(message, type = 'success') {
    const toastContainer = document.getElementById('toastContainer');
    
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    
    let icon = '';
    let title = '';
    
    switch(type) {
        case 'success':
            icon = '✅';
            title = 'Berhasil';
            break;
        case 'error':
            icon = '❌';
            title = 'Error';
            break;
        case 'info':
            icon = 'ℹ️';
            title = 'Info';
            break;
    }
    
    toast.innerHTML = `
        <div class="toast-icon">${icon}</div>
        <div class="toast-content">
            <div class="toast-title">${title}</div>
            <div class="toast-message">${message}</div>
        </div>
        <button class="toast-close" onclick="closeToast(this)">×</button>
    `;
    
    toastContainer.appendChild(toast);
    
    // Show toast
    setTimeout(() => {
        toast.classList.add('show');
    }, 100);
    
    // Auto hide after 5 seconds
    setTimeout(() => {
        closeToast(toast.querySelector('.toast-close'));
    }, 5000);
}

function closeToast(button) {
    const toast = button.closest('.toast');
    if (toast) {
        toast.classList.remove('show');
        setTimeout(() => {
            toast.remove();
        }, 300);
    }
}

function checkOrderPaymentStatus(orderNumber) {
    fetch(`/orders/${orderNumber}/check-payment-status`)
        .then(response => response.json())
        .then(data => {
            if (data.status && data.status !== 'pending') {
                showToast('Status pembayaran telah diperbarui!', 'success');
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            }
        })
        .catch(error => {
            console.log('Error checking payment status:', error);
        });
}
</script>

@endsection