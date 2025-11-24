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
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
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
        background: rgba(255, 255, 255, 0.2);
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
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
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

    .btn-pay,
    .btn-received,
    .btn-confirm-delivery,
    .btn-add-review {
        padding: 0.5rem 1rem;
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 500;
        transition: all 0.3s ease;
        font-weight: 500;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-pay {
        background: #4f46e5;
    }

    .btn-received {
        background: #10b981;
    }

    .btn-received:hover {
        background: #0d9f6e;
    }

    .btn-received:disabled {
        background: #d1fae5;
        cursor: not-allowed;
    }

    /* Review Form Styles */
    .review-form {
        margin-top: 1.5rem;
        padding: 1.5rem;
        background: #f8f9fa;
        border-radius: 8px;
        border: 1px solid #e9ecef;
    }

    .review-form h5 {
        margin-bottom: 1rem;
        color: #212529;
        font-weight: 600;
    }

    .rating-stars {
        margin-bottom: 1rem;
    }

    .rating-stars i {
        font-size: 1.5rem;
        color: #ffc107;
        cursor: pointer;
        margin-right: 0.25rem;
    }

    .review-textarea {
        width: 100%;
        min-height: 100px;
        padding: 0.75rem;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        margin-bottom: 1rem;
        resize: vertical;
    }

    .review-images-preview {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }

    .review-image-preview {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid #dee2e6;
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
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
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
        background:rgb(36, 194, 11);
        color: white;
    }

    .modal-btn-confirm:hover {
        background:rgb(43, 200, 35);
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


    .btn-confirm-delivery {
        padding: 0.5rem 1rem;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .btn-confirm-delivery:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .btn-confirm-delivery:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    /* Status Badge Delivered */
    .status-delivered {
        background: #d4edda;
        color: #155724;
    }

    /* Button untuk Review */
    .btn-add-review {
        padding: 0.5rem 1rem;
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-add-review:hover {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
    }

    /* Spinner untuk loading */
    .btn-loading {
        position: relative;
        pointer-events: none;
    }

    .btn-loading::after {
        content: '';
        position: absolute;
        width: 16px;
        height: 16px;
        top: 50%;
        left: 50%;
        margin-left: -8px;
        margin-top: -8px;
        border: 2px solid transparent;
        border-top-color: #ffffff;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    /* Button Batalkan - YANG HILANG! */
.btn-cancel {
    padding: 0.5rem 1rem;
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.btn-cancel:hover {
    background: linear-gradient(135deg, #c82333 0%, #bd2130 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
}

.btn-cancel:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
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
                        <th>Aksi</th>
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
                        {{-- Update bagian Action Buttons di dalam tbody --}}
                        <td class="details-cell">
                            <div class="action-buttons">
                                <a href="{{ route('orders.show', $order->order_number) }}" class="btn-details">
                                    Order Details
                                </a>

                                {{-- Tombol Bayar untuk Midtrans --}}
                                @if($order->payment_method === 'midtrans' && ($order->payment_status === 'pending' || !isset($order->payment_status)) && $order->status !== 'cancelled')
                                <a href="{{ route('orders.show', $order->order_number) }}" class="btn-pay">
                                    Bayar
                                </a>
                                @endif

                                {{-- Tombol Konfirmasi Penerimaan - BAGIAN BARU --}}
                                @if(in_array($order->status, ['dikirim', 'shipped']))
                                <button onclick="confirmDelivery('{{ $order->order_number }}')"
                                    class="btn-confirm-delivery"
                                    id="confirm-btn-{{ $order->order_number }}">
                                    Konfirmasi Diterima
                                </button>
                                {{-- Status Diterima dengan tombol Review --}}
                                @elseif(in_array($order->status, ['diterima', 'delivered']))
                                <div class="d-flex flex-column gap-2">
                                    <span class="status-badge status-delivered">✓ Pesanan Diterima</span>
                                    {{-- Check if any item can be reviewed --}}
                                    @php
                                    $hasUnreviewedItems = false;
                                    foreach($order->orderItems as $item) {
                                    if(!$order->hasReviewForProduct($item->product_id)) {
                                    $hasUnreviewedItems = true;
                                    break;
                                    }
                                    }
                                    @endphp

                                    @if($hasUnreviewedItems)
                                    <button onclick="showReviewModal('{{ $order->id }}')"
                                        class="btn-add-review">
                                        📝 Beri Ulasan
                                    </button>
                                    @else
                                    <small class="text-muted">Semua produk sudah direview</small>
                                    @endif
                                </div>
                                {{-- Tombol Batalkan untuk pending --}}
                                @elseif(($order->payment_status === 'pending' || !isset($order->payment_status)) && $order->status !== 'cancelled')
                                <form action="{{ route('orders.cancel', $order->order_number) }}"
                                    method="POST"
                                    style="display: inline;"
                                    class="cancel-form"
                                    data-order-number="{{ $order->order_number }}">
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
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </li>
                @else
                <li class="page-item">
                    <a class="page-link" href="{{ $orders->previousPageUrl() }}">
                        <svg class="pagination-icon" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
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
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </li>
                @else
                <li class="page-item disabled">
                    <span class="page-link">
                        <svg class="pagination-icon" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
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

<!-- Delivery Confirmation Modal -->
<div id="deliveryConfirmationModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-icon">📦</div>
        <h4 class="modal-title">Konfirmasi Penerimaan</h4>
        <p class="modal-text">Apakah Anda yakin pesanan sudah diterima dengan baik?</p>
        <div class="modal-buttons">
            <button type="button" class="modal-btn modal-btn-cancel" id="cancelDeliveryBtn">
                Batal
            </button>
            <button type="button" class="modal-btn modal-btn-confirm" id="confirmDeliveryBtn">
                Ya, Konfirmasi
            </button>
        </div>
    </div>
</div>

<!-- Review Modal -->
<div id="reviewModal" class="modal-overlay">
    <div class="modal-content" style="max-width: 600px;">
        <span class="close-modal" style="cursor: pointer; float: right; font-size: 28px; font-weight: bold;">&times;</span>
        <h4 class="modal-title">Beri Ulasan</h4>
        <div class="modal-body">
            <form id="reviewForm" class="review-form" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="order_id" id="reviewOrderId">
                <input type="hidden" name="product_id" id="reviewProductId">

                <div class="mb-3">
                    <label class="form-label">Rating</label>
                    <div class="rating-stars">
                        <i class="fas fa-star" data-rating="1"></i>
                        <i class="fas fa-star" data-rating="2"></i>
                        <i class="fas fa-star" data-rating="3"></i>
                        <i class="fas fa-star" data-rating="4"></i>
                        <i class="fas fa-star" data-rating="5"></i>
                        <input type="hidden" name="rating" id="ratingInput" value="5" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="komentar" class="form-label">Ulasan Anda</label>
                    <textarea name="komentar" id="komentar" class="review-textarea" placeholder="Bagaimana pengalaman Anda dengan produk ini?" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="reviewImages" class="form-label">Unggah Foto (Maks. 3)</label>
                    <input type="file" name="images[]" id="reviewImages" class="form-control" multiple accept="image/*">
                    <small class="text-muted">Format: JPG, PNG, maksimal 2MB per gambar</small>

                    <div class="review-images-preview mt-2" id="imagePreview"></div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-outline-secondary" id="cancelReview">Batal</button>
                    <button type="submit" class="btn btn-primary">Kirim Ulasan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Toast Container -->
<div class="toast-container" id="toastContainer"></div>

<script>
(function() {
    'use strict';
    
    console.log('🚀 Orders Page - Initializing...');

    let currentRating = 5;
    let selectedOrderId = null;
    let selectedProductId = null;
    let currentCancelForm = null;
    let currentFilter = 'all';
    let currentOrderNumber = null;

    // ========================================
    // 1. TAB FILTERING - YANG HILANG!
    // ========================================
    function initTabFiltering() {
        const tabs = document.querySelectorAll('.tab-button');
        const ordersTableBody = document.getElementById('ordersTableBody');
        const noResultsMessage = document.getElementById('noResultsMessage');
        
        if (!tabs || tabs.length === 0) {
            console.log('ℹ️ No tabs found');
            return;
        }

        console.log('🔄 Initializing tab filtering...');

        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const filter = this.getAttribute('data-filter');
                console.log('📋 Filter selected:', filter);
                
                // Update active state
                tabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                
                // Filter orders
                filterOrders(filter);
                currentFilter = filter;
            });
        });

        console.log('✅ Tab filtering initialized');
    }

    function filterOrders(filter) {
        const rows = document.querySelectorAll('.order-row');
        const noResultsMessage = document.getElementById('noResultsMessage');
        let visibleCount = 0;

        rows.forEach(row => {
            const status = row.getAttribute('data-status');
            
            if (filter === 'all' || status === filter) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Show/hide no results message
        if (visibleCount === 0) {
            if (noResultsMessage) noResultsMessage.style.display = 'block';
        } else {
            if (noResultsMessage) noResultsMessage.style.display = 'none';
        }

        console.log(`Filtered: ${visibleCount} orders visible`);
    }

    // ========================================
    // 2. RATING STARS
    // ========================================
    function initRatingStars() {
        const stars = document.querySelectorAll('.rating-stars i');
        
        if (stars.length === 0) {
            console.log('ℹ️ No rating stars found');
            return;
        }

        stars.forEach(star => {
            star.addEventListener('click', function() {
                const rating = parseInt(this.getAttribute('data-rating'));
                currentRating = rating;
                const ratingInput = document.getElementById('ratingInput');
                if (ratingInput) {
                    ratingInput.value = rating;
                }

                // Update stars display
                stars.forEach((s, index) => {
                    if (index < rating) {
                        s.classList.add('fas');
                        s.classList.remove('far');
                    } else {
                        s.classList.add('far');
                        s.classList.remove('fas');
                    }
                });
            });

            // Hover effect
            star.addEventListener('mouseenter', function() {
                const rating = parseInt(this.getAttribute('data-rating'));
                stars.forEach((s, index) => {
                    if (index < rating) {
                        s.style.color = '#ffc107';
                    } else {
                        s.style.color = '#ddd';
                    }
                });
            });
        });

        // Reset on mouse leave
        const starsContainer = document.querySelector('.rating-stars');
        if (starsContainer) {
            starsContainer.addEventListener('mouseleave', function() {
                const ratingInput = document.getElementById('ratingInput');
                const currentValue = ratingInput ? parseInt(ratingInput.value) : 5;
                stars.forEach((s, index) => {
                    if (index < currentValue) {
                        s.style.color = '#ffc107';
                    } else {
                        s.style.color = '#ddd';
                    }
                });
            });
        }

        console.log('✅ Rating stars initialized');
    }

    // ========================================
    // 3. IMAGE PREVIEW
    // ========================================
    function handleImagePreview(input) {
        const preview = document.getElementById('imagePreview');
        if (!preview) return;

        preview.innerHTML = '';

        if (input.files.length > 3) {
            showToast('error', 'Error', 'Maksimal 3 gambar yang dapat diunggah');
            input.value = '';
            return;
        }

        Array.from(input.files).forEach(file => {
            if (!file.type.match('image.*')) {
                showToast('error', 'Error', 'Hanya file gambar yang diizinkan');
                input.value = '';
                return;
            }

            if (file.size > 2 * 1024 * 1024) {
                showToast('error', 'Error', 'Ukuran file maksimal 2MB');
                input.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'review-image-preview';
                preview.appendChild(img);
            }
            reader.readAsDataURL(file);
        });
    }

    // ========================================
    // 4. REVIEW MODAL
    // ========================================
    window.showReviewModal = function(orderId) {
        console.log('📝 Opening review modal for order:', orderId);

        selectedOrderId = orderId;

        fetch(`/orders/${orderId}/items`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.items && data.items.length > 0) {
                const unreviewed = data.items.find(item => !item.has_review);

                if (unreviewed) {
                    selectedProductId = unreviewed.product_id;
                    document.getElementById('reviewOrderId').value = orderId;
                    document.getElementById('reviewProductId').value = unreviewed.product_id;

                    const modalTitle = document.querySelector('#reviewModal .modal-title');
                    if (modalTitle) {
                        modalTitle.textContent = `Beri Ulasan - ${unreviewed.product_name}`;
                    }

                    const modal = document.getElementById('reviewModal');
                    modal.classList.add('show');
                    modal.style.display = 'flex';
                } else {
                    showToast('info', 'Info', 'Semua produk sudah direview');
                }
            } else {
                showToast('error', 'Error', 'Tidak ada produk yang dapat direview');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('error', 'Error', 'Gagal memuat data produk');
        });
    };

    function closeReviewModal() {
        const modal = document.getElementById('reviewModal');
        if (modal) {
            modal.classList.remove('show');
            modal.style.display = 'none';
        }

        const form = document.getElementById('reviewForm');
        if (form) form.reset();

        const preview = document.getElementById('imagePreview');
        if (preview) preview.innerHTML = '';

        currentRating = 5;
        selectedOrderId = null;
        selectedProductId = null;

        const stars = document.querySelectorAll('.rating-stars i');
        stars.forEach((star, index) => {
            if (index < 5) {
                star.classList.add('fas');
                star.classList.remove('far');
            }
            star.style.color = '#ffc107';
        });
    }

    function handleReviewSubmit(event) {
        event.preventDefault();

        const form = event.target;
        const submitButton = form.querySelector('button[type="submit"]');
        
        if (submitButton.disabled) return;

        const buttonText = submitButton.innerHTML;
        submitButton.disabled = true;
        submitButton.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Mengirim...';

        const formData = new FormData(form);

        fetch('{{ route("reviews.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('success', 'Berhasil!', 'Ulasan berhasil dikirim');
                closeReviewModal();
                setTimeout(() => window.location.reload(), 2000);
            } else {
                throw new Error(data.message || 'Gagal mengirim ulasan');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('error', 'Error', error.message);
            submitButton.disabled = false;
            submitButton.innerHTML = buttonText;
        });
    }

    // ========================================
    // 5. CANCEL ORDER
    // ========================================
    function initCancelForms() {
        const forms = document.querySelectorAll('.cancel-form');
        
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                showCancelModal(this);
            });
        });

        console.log(`✅ Cancel forms initialized: ${forms.length}`);
    }

    function showCancelModal(form) {
        currentCancelForm = form;
        const modal = document.getElementById('cancelModal');
        if (modal) {
            modal.classList.add('show');
            modal.style.display = 'flex';
        }
    }

    window.hideCancelModal = function() {
        const modal = document.getElementById('cancelModal');
        if (modal) {
            modal.classList.remove('show');
            modal.style.display = 'none';
        }
        currentCancelForm = null;
    };

    window.confirmCancel = function() {
        if (!currentCancelForm) return;

        const formData = new FormData(currentCancelForm);
        const action = currentCancelForm.getAttribute('action');

        hideCancelModal();
        showToast('info', 'Memproses', 'Sedang membatalkan pesanan...');

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
                    row.style.transition = 'opacity 0.3s ease';
                    row.style.opacity = '0';
                    setTimeout(() => {
                        row.remove();
                        updateTabCounts();
                        filterOrders(currentFilter);
                        checkEmptyState();
                    }, 300);
                }
                showToast('success', 'Berhasil', data.message || 'Pesanan berhasil dibatalkan');
            } else {
                showToast('error', 'Gagal', data.message || 'Gagal membatalkan pesanan');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('error', 'Error', 'Terjadi kesalahan');
        });
    };

    // ========================================
    // 6. DELIVERY CONFIRMATION
    // ========================================
    window.confirmDelivery = function(orderNumber) {
        currentOrderNumber = orderNumber;
        const modal = document.getElementById('deliveryConfirmationModal');
        if (modal) {
            modal.classList.add('show');
            modal.style.display = 'flex';
        }
    };

    function hideDeliveryConfirmation() {
        const modal = document.getElementById('deliveryConfirmationModal');
        if (modal) {
            modal.classList.remove('show');
            modal.style.display = 'none';
        }
        currentOrderNumber = null;
    }

    function processDeliveryConfirmation(orderNumber) {
        const button = document.getElementById('confirm-btn-' + orderNumber);
        const confirmBtn = document.getElementById('confirmDeliveryBtn');
        
        if (button) {
            button.disabled = true;
            button.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Memproses...';
        }
        
        if (confirmBtn) {
            confirmBtn.disabled = true;
            confirmBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Memproses...';
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        
        fetch(`/orders/${orderNumber}/mark-delivered`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({})
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('success', 'Berhasil!', data.message);
                setTimeout(() => window.location.reload(), 1500);
            } else {
                throw new Error(data.message || 'Gagal memproses konfirmasi');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            hideDeliveryConfirmation();
            showToast('error', 'Gagal', error.message);
            if (button) button.disabled = false;
        });
    }

    // ========================================
    // 7. UTILITY FUNCTIONS
    // ========================================
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
            if (container) {
                container.innerHTML = `
                    <div class="orders-header">
                        <h2 class="orders-title">Riwayat Pesanan</h2>
                    </div>
                    <div class="empty-state">
                        <div class="empty-icon">📦</div>
                        <h3 class="empty-title">Belum Ada Pesanan</h3>
                        <p class="empty-text">Anda belum memiliki pesanan. Mulai berbelanja sekarang!</p>
                        <a href="/products" class="btn-shop">Mulai Belanja</a>
                    </div>
                `;
            }
        }
    }

    window.showToast = function(type, title, message) {
        const container = document.getElementById('toastContainer');
        if (!container) {
            alert(`${title}: ${message}`);
            return;
        }

        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;

        const iconMap = {
            success: '✅',
            error: '❌',
            info: 'ℹ️'
        };

        toast.innerHTML = `
            <div class="toast-icon">${iconMap[type] || 'ℹ️'}</div>
            <div class="toast-content">
                <div class="toast-title">${title}</div>
                <div class="toast-message">${message}</div>
            </div>
            <button class="toast-close" onclick="closeToast(this)">×</button>
        `;

        container.appendChild(toast);
        setTimeout(() => toast.classList.add('show'), 100);
        setTimeout(() => closeToast(toast.querySelector('.toast-close')), 5000);
    };

    window.closeToast = function(button) {
        const toast = button.closest('.toast');
        if (toast) {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }
    };

    // ========================================
    // MAIN INITIALIZATION
    // ========================================
    function init() {
        console.log('🔧 Starting orders page initialization...');

        // 1. Tab filtering
        initTabFiltering();

        // 2. Rating stars
        initRatingStars();

        // 3. Cancel forms
        initCancelForms();

        // 4. Review form
        const reviewForm = document.getElementById('reviewForm');
        if (reviewForm) {
            reviewForm.addEventListener('submit', handleReviewSubmit);
        }

        // 5. Review modal close buttons
        const cancelReviewBtn = document.getElementById('cancelReview');
        if (cancelReviewBtn) {
            cancelReviewBtn.addEventListener('click', closeReviewModal);
        }

        const closeModalBtn = document.querySelector('#reviewModal .close-modal');
        if (closeModalBtn) {
            closeModalBtn.addEventListener('click', closeReviewModal);
        }

        const reviewModal = document.getElementById('reviewModal');
        if (reviewModal) {
            reviewModal.addEventListener('click', function(e) {
                if (e.target === this) closeReviewModal();
            });
        }

        // 6. Image preview
        const imageInput = document.getElementById('reviewImages');
        if (imageInput) {
            imageInput.addEventListener('change', function() {
                handleImagePreview(this);
            });
        }

        // 7. Delivery confirmation buttons
        const confirmDeliveryBtn = document.getElementById('confirmDeliveryBtn');
        if (confirmDeliveryBtn) {
            confirmDeliveryBtn.addEventListener('click', function() {
                if (currentOrderNumber) {
                    processDeliveryConfirmation(currentOrderNumber);
                }
            });
        }

        const cancelDeliveryBtn = document.getElementById('cancelDeliveryBtn');
        if (cancelDeliveryBtn) {
            cancelDeliveryBtn.addEventListener('click', hideDeliveryConfirmation);
        }

        const deliveryModal = document.getElementById('deliveryConfirmationModal');
        if (deliveryModal) {
            deliveryModal.addEventListener('click', function(e) {
                if (e.target === this) hideDeliveryConfirmation();
            });
        }

        // 8. ESC key to close modals
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeReviewModal();
                hideDeliveryConfirmation();
                hideCancelModal();
            }
        });

        console.log('✅ Orders page initialization completed');
    }

    // Run when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();
</script>

@endsection