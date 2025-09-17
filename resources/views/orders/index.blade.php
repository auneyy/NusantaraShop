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
        background: linear-gradient(135deg, #EFA942 0%, #8B4513 100%);
        color: white;
        padding: 2rem;
        border-radius: 10px;
        margin-bottom: 2rem;
        text-align: center;
    }

    .orders-header h2 {
        margin-bottom: 0.5rem;
        font-weight: 600;
    }

    .filter-tabs {
        background: white;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .nav-pills .nav-link {
        color: #422D1C;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        margin: 0 0.25rem;
        border: 2px solid transparent;
        transition: all 0.3s ease;
    }

    .nav-pills .nav-link:hover {
        background: rgba(66, 45, 28, 0.1);
        border-color: #422D1C;
    }

    .nav-pills .nav-link.active {
        background: linear-gradient(135deg, #422D1C 0%, #8B4513 100%);
        color: white;
        border-color: #422D1C;
    }

    .order-card {
        background: white;
        border-radius: 10px;
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
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
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

    .order-status {
        text-align: right;
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
        margin-bottom: 0.5rem;
        display: inline-block;
    }

    .status-pending {
        background-color: #fff3cd;
        color: #856404;
        border: 1px solid #ffeaa7;
    }

    .status-processing {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .status-shipped {
        background-color: #cce7ff;
        color: #004085;
        border: 1px solid #99d6ff;
    }

    .status-delivered {
        background-color: #d1ecf1;
        color: #0c5460;
        border: 1px solid #bee5eb;
    }

    .status-cancelled {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .payment-status {
        font-size: 0.8rem;
        color: #6c757d;
    }

    .order-card-body {
        padding: 1.5rem;
    }

    .order-items {
        margin-bottom: 1rem;
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
        flex-shrink: 0;
    }

    .item-details {
        flex: 1;
    }

    .item-name {
        font-weight: 500;
        color: #212529;
        margin-bottom: 0.25rem;
        font-size: 0.95rem;
    }

    .item-specs {
        color: #6c757d;
        font-size: 0.85rem;
    }

    .item-price {
        font-weight: 600;
        color: #422D1C;
        text-align: right;
        flex-shrink: 0;
    }

    .order-summary {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }

    .summary-row:last-child {
        margin-bottom: 0;
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
        background: linear-gradient(135deg, #EFA942 0%,rgb(215, 149, 48) 100%);
        color: white;
    }

    .btn-primary-action:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(66, 45, 28, 0.3);
        color: white;
        text-decoration: none;
    }

    .btn-outline-action {
        background: transparent;
        color: #422D1C;
        border: 1px solid #422D1C;
    }

    .btn-outline-action:hover {
        background: #422D1C;
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
        border-radius: 10px;
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

    .empty-text {
        color: #6c757d;
        margin-bottom: 2rem;
    }

    .btn-shop {
        background: linear-gradient(135deg, #422D1C 0%, #8B4513 100%);
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-shop:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(66, 45, 28, 0.3);
        color: white;
        text-decoration: none;
    }

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
        
        .order-status {
            text-align: left;
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
                    <button class="nav-link active" id="all-tab" data-bs-toggle="pill" data-bs-target="#all" type="button" role="tab">
                        Semua ({{ $orders->total() }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pending-tab" data-bs-toggle="pill" data-bs-target="#pending" type="button" role="tab">
                        Pending ({{ $orders->where('status', 'pending')->count() }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="processing-tab" data-bs-toggle="pill" data-bs-target="#processing" type="button" role="tab">
                        Diproses ({{ $orders->where('status', 'processing')->count() }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="shipped-tab" data-bs-toggle="pill" data-bs-target="#shipped" type="button" role="tab">
                        Dikirim ({{ $orders->where('status', 'shipped')->count() }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="completed-tab" data-bs-toggle="pill" data-bs-target="#completed" type="button" role="tab">
                        Selesai ({{ $orders->where('status', 'delivered')->count() }})
                    </button>
                </li>
            </ul>
        </div>

        <!-- Orders List -->
        <div class="tab-content" id="orderTabsContent">
            <div class="tab-pane fade show active" id="all" role="tabpanel">
                @foreach($orders as $order)
                <div class="order-card" data-status="{{ $order->status }}">
                    <div class="order-card-header">
                        <div class="order-info">
                            <div>
                                <div class="order-number">{{ $order->order_number }}</div>
                                <div class="order-date">{{ $order->order_date->format('d F Y, H:i') }} WIB</div>
                            </div>
                            <div class="order-status">
                                <div class="status-badge status-{{ $order->status }}">
                                    {{ $order->status_label }}
                                </div>
                                <div class="payment-status">
                                    💳 {{ $order->payment_status_label }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="order-card-body">
                        <!-- Order Items Preview (max 3) -->
                        <div class="order-items">
                            @foreach($order->orderItems->take(3) as $item)
                            <div class="order-item">
                                <img src="{{ $item->product->images->first()->image_path ?? 'path/to/placeholder.jpg' }}" 
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
                                <div class="text-muted small text-center py-2">
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
                            
                            @if($order->payment_method === 'midtrans' && ($order->payment_status === 'pending' || !isset($order->payment_status)))
                                <a href="{{ route('orders.show', $order->order_number) }}" class="btn-action btn-outline-action">
                                    Bayar Sekarang
                                </a>
                            @endif
                            
                            @if(($order->payment_status === 'pending' || !isset($order->payment_status)) && $order->status !== 'cancelled')
                                <form action="{{ route('orders.cancel', $order->order_number) }}" method="POST" style="display: inline;" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                                    @csrf
                                    <button type="submit" class="btn-action btn-danger-action">
                                        Batalkan
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $orders->links() }}
                </div>
            </div>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter orders by status
    const tabs = document.querySelectorAll('#orderTabs button');
    const orderCards = document.querySelectorAll('.order-card');
    
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const target = this.getAttribute('data-bs-target');
            const status = target.replace('#', '');
            
            if (status === 'all') {
                orderCards.forEach(card => {
                    card.style.display = 'block';
                });
            } else {
                orderCards.forEach(card => {
                    const cardStatus = card.getAttribute('data-status');
                    if (status === 'completed' && cardStatus === 'delivered') {
                        card.style.display = 'block';
                    } else if (cardStatus === status) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            }
        });
    });
    
    // Auto-refresh payment status for pending orders
    const pendingOrders = document.querySelectorAll('[data-status="pending"]');
    if (pendingOrders.length > 0) {
        // Check every 30 seconds
        setInterval(() => {
            pendingOrders.forEach(orderCard => {
                const orderNumber = orderCard.querySelector('.order-number').textContent.trim();
                checkOrderPaymentStatus(orderNumber);
            });
        }, 30000);
    }
});

function checkOrderPaymentStatus(orderNumber) {
    fetch(`/orders/${orderNumber}/check-payment-status`)
        .then(response => response.json())
        .then(data => {
            if (data.status && data.status !== 'pending') {
                // Reload page to show updated status
                window.location.reload();
            }
        })
        .catch(error => {
            console.log('Error checking payment status:', error);
        });
}
</script>

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        alert('{{ session('success') }}');
    });
</script>
@endif

@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        alert('{{ session('error') }}');
    });
</script>
@endif
@endsection