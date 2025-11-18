@extends('layout.app')

@section('content')
<style>
    body {
        background-color: #f8f9fa;
    }

    .orders-container {
        padding: 2rem 0;
        min-height: 80vh;
    }

    .orders-header {
        margin-bottom: 2rem;
    }

    .orders-title {
        font-size: 2rem;
        font-weight: 700;
        color: #212529;
        margin-bottom: 1.5rem;
    }

    /* Filter Tabs */
    .filter-tabs {
        background: white;
        border-radius: 12px;
        padding: 0.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .tab-button {
        padding: 0.75rem 1.5rem;
        border: none;
        background: transparent;
        color: #6c757d;
        font-weight: 600;
        font-size: 0.95rem;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .tab-button:hover {
        background: rgba(66, 45, 28, 0.05);
        color: #422D1C;
    }

    .tab-button.active {
        background: linear-gradient(135deg, #422D1C 0%, #8B4513 100%);
        color: white;
    }

    .tab-count {
        margin-left: 0.5rem;
        padding: 0.2rem 0.6rem;
        background: rgba(255,255,255,0.2);
        border-radius: 12px;
        font-size: 0.85rem;
    }

    .tab-button:not(.active) .tab-count {
        background: #e9ecef;
        color: #6c757d;
    }

    /* Orders Table */
    .orders-table-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .orders-table {
        width: 100%;
        border-collapse: collapse;
    }

    .orders-table thead {
        background: #f8f9fa;
        border-bottom: 2px solid #e9ecef;
    }

    .orders-table th {
        padding: 1.25rem 1.5rem;
        text-align: left;
        font-size: 0.9rem;
        font-weight: 700;
        color: #495057;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .orders-table tbody tr {
        border-bottom: 1px solid #f1f3f5;
        transition: background 0.2s ease;
    }

    .orders-table tbody tr:hover {
        background: #f8f9fa;
    }

    .orders-table tbody tr:last-child {
        border-bottom: none;
    }

    .orders-table td {
        padding: 1.5rem 1.5rem;
        vertical-align: middle;
    }

    /* Item Column */
    .item-cell {
        display: flex;
        align-items: center;
        gap: 1rem;
        min-width: 300px;
    }

    .item-image {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #e9ecef;
        flex-shrink: 0;
    }

    .item-info {
        flex: 1;
    }

    .item-name {
        font-weight: 600;
        color: #212529;
        margin-bottom: 0.25rem;
        font-size: 0.95rem;
    }

    .item-meta {
        color: #6c757d;
        font-size: 0.85rem;
    }

    .order-number {
        color: #6c757d;
        font-size: 0.8rem;
        margin-top: 0.25rem;
    }

    /* Status Column */
    .status-cell {
        min-width: 150px;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
        white-space: nowrap;
    }

    .status-pending {
        background: #fff3cd;
        color: #856404;
    }

    .status-processing {
        background: #cfe2ff;
        color: #084298;
    }

    .status-shipped {
        background: #d1ecf1;
        color: #0c5460;
    }

    .status-delivered {
        background: #d4edda;
        color: #155724;
    }

    .status-cancelled {
        background: #f8d7da;
        color: #721c24;
    }

    .payment-badge {
        display: block;
        margin-top: 0.5rem;
        font-size: 0.8rem;
        color: #6c757d;
    }

    /* Total Column */
    .total-cell {
        font-weight: 700;
        color: #422D1C;
        font-size: 1.05rem;
        min-width: 120px;
    }

    /* Details Column */
    .details-cell {
        text-align: right;
        min-width: 150px;
    }

    .btn-details {
        padding: 0.6rem 1.5rem;
        background: linear-gradient(135deg, #EFA942 0%, #d68910 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn-details:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        color: white;
        text-decoration: none;
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
        justify-content: flex-end;
        flex-wrap: wrap;
    }

    .btn-pay {
        padding: 0.5rem 1rem;
        background: #4f46e5;
        color: white;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn-pay:hover {
        background: #d68910;
        color: white;
        text-decoration: none;
    }

    .btn-cancel {
        padding: 0.5rem 1rem;
        background: transparent;
        color: #dc3545;
        border: 1px solid #dc3545;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-cancel:hover {
        background: #dc3545;
        color: white;
    }

    /* Top Actions */
    .top-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .btn-invoice,
    .btn-view-order {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        border: none;
    }

    .btn-invoice {
        background: white;
        color: #422D1C;
        border: 2px solid #e9ecef;
    }

    .btn-invoice:hover {
        border-color: #422D1C;
        color: #422D1C;
        text-decoration: none;
    }

    .btn-view-order {
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        color: white;
    }

    .btn-view-order:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        color: white;
        text-decoration: none;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
    }

    .empty-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .empty-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
    }

    .empty-text {
        color: #6c757d;
        margin-bottom: 2rem;
    }

    .btn-shop {
        padding: 0.75rem 2rem;
        background: linear-gradient(135deg, #422D1C 0%, #8B4513 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn-shop:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(66, 45, 28, 0.3);
        color: white;
        text-decoration: none;
    }

    /* No Results */
    .no-results {
        text-align: center;
        padding: 3rem 2rem;
        background: white;
        border-radius: 12px;
        color: #6c757d;
    }

    .no-results-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
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
        backdrop-filter: blur(5px);
    }

    .modal-overlay.show {
        display: flex;
    }

    .modal-content {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        max-width: 400px;
        width: 90%;
        text-align: center;
        animation: modalSlideIn 0.3s ease;
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

    .modal-icon {
        font-size: 3rem;
        color: #dc3545;
        margin-bottom: 1rem;
    }

    .modal-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #212529;
        margin-bottom: 0.5rem;
    }

    .modal-text {
        color: #6c757d;
        margin-bottom: 2rem;
        line-height: 1.6;
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
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
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

    /* Toast */
    .toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1100;
    }

    .toast {
        background: white;
        border-radius: 10px;
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
    }

    /* Pagination */
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
        font-weight: 600;
    }

    .pagination .page-link:hover {
        background: #EFA942;
        color: white;
        border-color: #EFA942;
    }

    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #422D1C 0%, #8B4513 100%);
        color: white;
        border-color: #422D1C;
    }

    .pagination .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
        background: #f8f9fa;
    }

    .pagination-icon {
        width: 16px;
        height: 16px;
        fill: currentColor;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .orders-table-container {
            overflow-x: auto;
        }

        .orders-table {
            min-width: 900px;
        }
    }

    @media (max-width: 768px) {
        .orders-container {
            padding: 1rem 0;
        }

        .orders-title {
            font-size: 1.5rem;
        }

        .filter-tabs {
            overflow-x: auto;
            flex-wrap: nowrap;
        }

        .tab-button {
            padding: 0.6rem 1.2rem;
            font-size: 0.9rem;
        }

        .top-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .btn-invoice,
        .btn-view-order {
            width: 100%;
            text-align: center;
        }
    }
</style>

<div class="orders-container">
    <div class="container">
        <!-- Header -->
        <div class="orders-header">
            <h2 class="orders-title">Riwayat Pesanan</h2>
        </div>

        @if($orders->count() > 0)
        <!-- Filter Tabs -->
        <div class="filter-tabs">
            <button class="tab-button active" data-filter="all">
                Semua Pesanan<span class="tab-count">{{ $orders->total() }}</span>
            </button>
            <button class="tab-button" data-filter="pending">
                Pending<span class="tab-count">{{ $orders->where('status', 'pending')->count() }}</span>
            </button>
            <button class="tab-button" data-filter="processing">
                Diproses<span class="tab-count">{{ $orders->where('status', 'processing')->count() }}</span>
            </button>
            <button class="tab-button" data-filter="delivered">
                Selesai<span class="tab-count">{{ $orders->where('status', 'delivered')->count() }}</span>
            </button>
            <button class="tab-button" data-filter="cancelled">
                Dibatalkan<span class="tab-count">{{ $orders->where('status', 'cancelled')->count() }}</span>
            </button>
        </div>

        <!-- Orders Table -->
        <div class="orders-table-container">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody id="ordersTableBody">
                    @foreach($orders as $order)
                    <tr class="order-row" data-status="{{ $order->status }}">
                        <td>
                            <div class="item-cell">
                                @php
                                    $firstItem = $order->orderItems->first();
                                @endphp
                                <img src="{{ $firstItem->product->images->first()->image_path ?? 'https://via.placeholder.com/70x70?text=No+Image' }}" 
                                     alt="{{ $firstItem->product_name }}" 
                                     class="item-image">
                                <div class="item-info">
                                    <div class="item-name">{{ $firstItem->product_name }}</div>
                                    <div class="item-meta">Qty: {{ $order->orderItems->sum('quantity') }}</div>
                                    <div class="order-number">{{ $order->order_number }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="status-cell">
                            <div>
                                <span class="status-badge status-{{ $order->status }}">
                                    @switch($order->status)
                                        @case('pending')
                                            Pending
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
                                </span>
                                <span class="payment-badge">
                                    {{ $order->order_date->diffForHumans() }}
                                </span>
                            </div>
                        </td>
                        <td class="total-cell">
                            Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                        </td>
                        <td class="details-cell">
                            <div class="action-buttons">
                                <a href="{{ route('orders.show', $order->order_number) }}" class="btn-details">
                                    Order Details
                                </a>
                                
                                @if($order->payment_method === 'midtrans' && ($order->payment_status === 'pending' || !isset($order->payment_status)) && $order->status !== 'cancelled')
                                    <a href="{{ route('orders.show', $order->order_number) }}" class="btn-pay">
                                        Bayar
                                    </a>
                                @endif
                                
                                @if(($order->payment_status === 'pending' || !isset($order->payment_status)) && $order->status !== 'cancelled')
                                    <form action="{{ route('orders.cancel', $order->order_number) }}" method="POST" style="display: inline;" 
                                          class="cancel-form" data-order-number="{{ $order->order_number }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-cancel">
                                            Batalkan
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- No Results Message -->
            <div id="noResultsMessage" class="no-results" style="display: none;">
                <div class="no-results-icon">📋</div>
                <h4>Tidak ada pesanan</h4>
                <p>Tidak ada pesanan dengan status yang dipilih.</p>
            </div>
        </div>

        <!-- Pagination -->
        @if ($orders->hasPages())
            <nav aria-label="Pagination Navigation">
                <ul class="pagination">
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
        
        @else
        <!-- Empty State -->
        <div class="empty-state">
            <div class="empty-icon">📦</div>
            <h3 class="empty-title">Belum Ada Pesanan</h3>
            <p class="empty-text">Anda belum memiliki pesanan. Mulai berbelanja sekarang!</p>
            <a href="{{ route('products.index') }}" class="btn-shop">
                Mulai Belanja
            </a>
        </div>
        @endif
    </div>
</div>

<!-- Cancel Modal -->
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
    initializeFilterTabs();
    initializeCancelForms();

    // Auto-refresh for pending orders
    const pendingRows = document.querySelectorAll('[data-status="pending"]');
    if (pendingRows.length > 0) {
        setInterval(() => {
            pendingRows.forEach(row => {
                const orderNumber = row.querySelector('.order-number').textContent.trim();
                checkOrderPaymentStatus(orderNumber);
            });
        }, 30000);
    }

    // Close modal handlers
    document.getElementById('cancelModal').addEventListener('click', function(e) {
        if (e.target === this) hideCancelModal();
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') hideCancelModal();
    });
});

function initializeFilterTabs() {
    const tabs = document.querySelectorAll('.tab-button');
    
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');
            
            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            filterOrders(filter);
            currentFilter = filter;
        });
    });
}

function filterOrders(filter) {
    const rows = document.querySelectorAll('.order-row');
    const noResults = document.getElementById('noResultsMessage');
    const tbody = document.getElementById('ordersTableBody');
    let visibleCount = 0;
    
    rows.forEach(row => {
        const status = row.getAttribute('data-status');
        const shouldShow = filter === 'all' || status === filter;
        
        row.style.display = shouldShow ? '' : 'none';
        if (shouldShow) visibleCount++;
    });
    
    if (visibleCount === 0) {
        tbody.style.display = 'none';
        noResults.style.display = 'block';
    } else {
        tbody.style.display = '';
        noResults.style.display = 'none';
    }
}

function initializeCancelForms() {
    const forms = document.querySelectorAll('.cancel-form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            showCancelModal(this);
        });
    });
}

function showCancelModal(form) {
    currentCancelForm = form;
    document.getElementById('cancelModal').classList.add('show');
}

function hideCancelModal() {
    document.getElementById('cancelModal').classList.remove('show');
    currentCancelForm = null;
}

function confirmCancel() {
    if (!currentCancelForm) return;
    
    const formData = new FormData(currentCancelForm);
    const action = currentCancelForm.getAttribute('action');
    const orderNumber = currentCancelForm.getAttribute('data-order-number');
    
    hideCancelModal();
    showToast('Sedang memproses pembatalan...', 'info');
    
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
            const row = currentCancelForm.closest('.order-row');
            if (row) {
                row.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                row.style.opacity = '0';
                row.style.transform = 'translateX(-20px)';
                
                setTimeout(() => {
                    row.remove();
                    updateTabCounts();
                    filterOrders(currentFilter);
                    checkEmptyState();
                }, 300);
            }
            
            showToast(data.message || 'Pesanan berhasil dibatalkan', 'success');
        } else {
            showToast(data.message || 'Gagal membatalkan pesanan', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Terjadi kesalahan saat membatalkan pesanan', 'error');
    });
}

function updateTabCounts() {
    const tabs = document.querySelectorAll('.tab-button');
    const rows = document.querySelectorAll('.order-row');
    
    const counts = {
        all: rows.length,
        pending: 0,
        processing: 0,
        shipped: 0,
        delivered: 0,
        cancelled: 0
    };
    
    rows.forEach(row => {
        const status = row.getAttribute('data-status');
        if (counts.hasOwnProperty(status)) {
            counts[status]++;
        }
    });
    
    tabs.forEach(tab => {
        const filter = tab.getAttribute('data-filter');
        const count = counts[filter] || 0;
        const countSpan = tab.querySelector('.tab-count');
        
        if (countSpan) {
            countSpan.textContent = count;
        }
    });
}

function checkEmptyState() {
    const rows = document.querySelectorAll('.order-row');
    
    if (rows.length === 0) {
        const container = document.querySelector('.orders-container .container');
        container.innerHTML = `
            <div class="orders-header">
                <h2 class="orders-title">Riwayat Pesanan</h2>
            </div>
            <div class="empty-state">
                <div class="empty-icon">📦</div>
                <h3 class="empty-title">Belum Ada Pesanan</h3>
                <p class="empty-text">Anda belum memiliki pesanan. Mulai berbelanja sekarang!</p>
                <a href="${window.location.origin}/products" class="btn-shop">
                    Mulai Belanja
                </a>
            </div>
        `;
    }
}

function showToast(message, type = 'success') {
    const container = document.getElementById('toastContainer');
    
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
    
    container.appendChild(toast);
    
    setTimeout(() => toast.classList.add('show'), 100);
    setTimeout(() => closeToast(toast.querySelector('.toast-close')), 5000);
}

function closeToast(button) {
    const toast = button.closest('.toast');
    if (toast) {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 300);
    }
}

function checkOrderPaymentStatus(orderNumber) {
    fetch(`/orders/${orderNumber}/check-payment-status`)
        .then(response => response.json())
        .then(data => {
            if (data.status && data.status !== 'pending') {
                showToast('Status pembayaran telah diperbarui!', 'success');
                setTimeout(() => window.location.reload(), 2000);
            }
        })
        .catch(error => {
            console.log('Error checking payment status:', error);
        });
}
</script>

@endsection