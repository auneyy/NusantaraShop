@extends('layout.app')

@section('title', 'Riwayat Pembelian')

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
    /* Reset dan Base Styles */
    .orders-container {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
        background-color: #f5f5f5 !important;
        min-height: 100vh;
        padding: 0 !important;
        margin: 0 !important;
    }

    /* Override container default */
    .orders-container .container {
        max-width: 1200px !important;
        margin: 0 auto !important;
        padding: 20px !important;
    }

    /* Page Header */
    .orders-header {
        text-align: center !important;
        margin-bottom: 30px !important;
    }

    .orders-header h1 {
        color: #333 !important;
        font-weight: 600 !important;
        margin: 0 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 12px !important;
    }

    /* Navigation Tabs */
    .orders-nav {
        display: flex !important;
        justify-content: center !important;
        gap: 32px !important;
        margin-bottom: 24px !important;
        border-bottom: 1px solid #e0e0e0 !important;
    }

    .orders-nav-link {
        padding: 12px 0 !important;
        text-decoration: none !important;
        color: #666 !important;
        font-weight: 500 !important;
        border-bottom: 2px solid transparent !important;
        transition: all 0.3s !important;
        display: flex !important;
        align-items: center !important;
    }

    .orders-nav-link:hover {
        color: #8B4513 !important;
        text-decoration: none !important;
    }

    .orders-nav-link.active {
        color: #8B4513 !important;
        border-bottom-color: #8B4513 !important;
    }

    /* Filter Card */
    .orders-filter-card {
        background: white !important;
        border-radius: 12px !important;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08) !important;
        padding: 24px !important;
        margin-bottom: 24px !important;
        transition: box-shadow 0.3s ease !important;
    }

    .orders-filter-card:hover {
        box-shadow: 0 4px 20px rgba(0,0,0,0.12) !important;
    }

    .orders-filter-form {
        display: flex !important;
        flex-wrap: wrap !important;
        gap: 16px !important;
        align-items: end !important;
    }

    .orders-filter-group {
        flex: 1 !important;
        min-width: 200px !important;
    }

    .orders-filter-label {
        display: block !important;
        font-weight: 600 !important;
        color: #333 !important;
        margin-bottom: 6px !important;
    }

    .orders-filter-input,
    .orders-filter-select {
        width: 100% !important;
        padding: 10px 12px !important;
        border: 1px solid #ddd !important;
        border-radius: 6px !important;
        background: white !important;
        transition: all 0.3s !important;
        color: #333 !important;
    }

    .orders-filter-input:focus,
    .orders-filter-select:focus {
        outline: none !important;
        border-color: #8B4513 !important;
        box-shadow: 0 0 0 3px rgba(139, 69, 19, 0.1) !important;
    }

    /* Buttons */
.orders-btn {
    padding: 8px 16px;               /* lebih proporsional */
    border-radius: 6px;
    text-decoration: none;
    font-weight: 500;
    text-align: center;
    cursor: pointer;
    border: none;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;                        /* jarak icon & text lebih kecil */
    line-height: 1.4;                /* biar teks lebih rapi */
}

.orders-btn i, 
.orders-btn svg {
    width: 16px;
    height: 16px;
}


    .orders-btn-primary {
        background-color: #8B4513 !important;
        color: white !important;
    }

    .orders-btn-primary:hover {
        background-color: #7A3F12 !important;
        color: white !important;
        text-decoration: none !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 4px 8px rgba(139, 69, 19, 0.2) !important;
    }

    .orders-btn-secondary {
        background-color: #6c757d !important;
        color: white !important;
    }

    .orders-btn-secondary:hover {
        background-color: #5a6268 !important;
        color: white !important;
        text-decoration: none !important;
        transform: translateY(-1px) !important;
    }

    .orders-btn-outline {
        background-color: white !important;
        color: #666 !important;
        border: 1px solid #ddd !important;
    }

    .orders-btn-outline:hover {
        background-color: #f5f5f5 !important;
        color: #333 !important;
        text-decoration: none !important;
        border-color: #ccc !important;
        transform: translateY(-1px) !important;
    }

    /* Table Card */
    .orders-table-card {
        background: white !important;
        border-radius: 12px !important;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08) !important;
        overflow: hidden !important;
        transition: box-shadow 0.3s ease !important;
    }

    .orders-table-card:hover {
        box-shadow: 0 4px 20px rgba(0,0,0,0.12) !important;
    }

    .orders-table-header {
        background-color: #f8f9fa !important;
        padding: 16px 24px !important;
        border-bottom: 1px solid #e0e0e0 !important;
    }

    .orders-table-header h3 {
        font-weight: 600 !important;
        color: #333 !important;
        margin: 0 !important;
    }

    .orders-table-head {
        background-color: #f8f9fa !important;
        padding: 12px 24px !important;
        border-bottom: 1px solid #e0e0e0 !important;
        display: grid !important;
        grid-template-columns: 60px 1fr 120px 80px 150px 120px 100px !important;
        gap: 16px !important;
        font-weight: 600 !important;
        color: #555 !important;
    }

    .orders-table-body {
        divide-y divide-gray-200 !important;
    }

    .orders-table-row {
        padding: 16px 24px !important;
        border-bottom: 1px solid #f0f0f0 !important;
    }

    .orders-table-row:last-child {
        border-bottom: none !important;
    }

    .orders-table-row:hover {
        background-color: #fafafa !important;
    }

    /* Mobile Layout */
    .orders-mobile-layout {
        display: block !important;
    }

    .orders-mobile-header {
        display: flex !important;
        justify-content: space-between !important;
        align-items: flex-start !important;
        margin-bottom: 12px !important;
    }

    .orders-mobile-left h4 {
        font-weight: 600 !important;
        color: #333 !important;
        margin-bottom: 4px !important;
    }

    .orders-mobile-left p {
        color: #666 !important;
        margin-bottom: 2px !important;
    }

    .orders-mobile-right {
        text-align: right !important;
    }

    .orders-mobile-right p {
        font-weight: 600 !important;
        color: #333 !important;
        margin-bottom: 4px !important;
    }

    .orders-mobile-actions {
        display: flex !important;
        gap: 8px !important;
    }

    .orders-mobile-btn {
        flex: 1 !important;
        padding: 8px 16px !important;
        border-radius: 6px !important;
        font-weight: 500 !important;
        border: none !important;
        cursor: pointer !important;
        transition: all 0.3s !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 4px !important;
    }

    .orders-mobile-btn-primary {
        background-color: rgba(139, 69, 19, 0.1) !important;
        color: #8B4513 !important;
    }

    .orders-mobile-btn-primary:hover {
        background-color: rgba(139, 69, 19, 0.2) !important;
    }

    .orders-mobile-btn-danger {
        background-color: rgba(220, 53, 69, 0.1) !important;
        color: #dc3545 !important;
    }

    .orders-mobile-btn-danger:hover {
        background-color: rgba(220, 53, 69, 0.2) !important;
    }

    /* Desktop Layout */
    .orders-desktop-layout {
        display: grid !important;
        grid-template-columns: 60px 1fr 120px 80px 150px 120px 100px !important;
        gap: 16px !important;
        align-items: center !important;
    }

    .orders-desktop-cell {
        color: #333 !important;
    }

    .orders-desktop-cell-secondary {
        color: #666 !important;
    }

    .orders-desktop-cell-bold {
        font-weight: 600 !important;
        color: #333 !important;
    }

    .orders-desktop-actions {
        display: flex !important;
        gap: 8px !important;
    }

    /* Status Badges */
    .orders-badge {
        display: inline-block !important;
        padding: 4px 8px !important;
        font-weight: 500 !important;
        border-radius: 4px !important;
    }

    .orders-badge-success {
        background-color: #d4edda !important;
        color: #155724 !important;
    }

    .orders-badge-info {
        background-color: #d1ecf1 !important;
        color: #0c5460 !important;
    }

    .orders-badge-warning {
        background-color: #fff3cd !important;
        color: #856404 !important;
    }

    .orders-badge-secondary {
        background-color: #f8f9fa !important;
        color: #6c757d !important;
    }

    /* Action Buttons */
    .orders-action-btn {
        background: none !important;
        border: none !important;
        color: #666 !important;
        cursor: pointer !important;
        padding: 4px 8px !important;
        border-radius: 4px !important;
        transition: all 0.3s !important;
    }

    .orders-action-btn:hover {
        background-color: #f5f5f5 !important;
    }

    .orders-action-btn-primary {
        color: #8B4513 !important;
    }

    .orders-action-btn-primary:hover {
        color: #7A3F12 !important;
        background-color: rgba(139, 69, 19, 0.1) !important;
    }

    .orders-action-btn-danger {
        color: #dc3545 !important;
    }

    .orders-action-btn-danger:hover {
        color: #c82333 !important;
        background-color: rgba(220, 53, 69, 0.1) !important;
    }

    /* Empty State */
    .orders-empty {
        text-align: center !important;
        padding: 48px 24px !important;
        color: #666 !important;
    }

    .orders-empty i {
        color: #ddd !important;
        margin-bottom: 16px !important;
        display: block !important;
    }

    .orders-empty h4 {
        color: #555 !important;
        margin-bottom: 8px !important;
        font-weight: 600 !important;
    }

    .orders-empty p {
        color: #777 !important;
        margin-bottom: 16px !important;
        line-height: 1.5 !important;
    }

    /* Summary Cards */
    .orders-summary {
        display: grid !important;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)) !important;
        gap: 16px !important;
        margin-top: 24px !important;
    }

    .orders-summary-card {
        padding: 20px !important;
        border-radius: 12px !important;
        display: flex !important;
        align-items: center !important;
        gap: 16px !important;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06) !important;
        transition: transform 0.3s ease !important;
    }

    .orders-summary-card:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 16px rgba(0,0,0,0.1) !important;
    }

    .orders-summary-card-blue {
        background-color: #e3f2fd !important;
    }

    .orders-summary-card-green {
        background-color: #e8f5e8 !important;
    }

    .orders-summary-card-yellow {
        background-color: #fff8e1 !important;
    }

    .orders-summary-card-purple {
        background-color: #f3e5f5 !important;
    }

    .orders-summary-icon-blue {
        color: #1976d2 !important;
    }

    .orders-summary-icon-green {
        color: #388e3c !important;
    }

    .orders-summary-icon-yellow {
        color: #f57c00 !important;
    }

    .orders-summary-icon-purple {
        color: #7b1fa2 !important;
    }

    .orders-summary-content p:first-child {
        margin-bottom: 4px !important;
    }

    .orders-summary-content p:last-child {
        font-weight: 700 !important;
        margin: 0 !important;
    }

    .orders-summary-content-blue p:first-child {
        color: #1976d2 !important;
    }

    .orders-summary-content-blue p:last-child {
        color: #0d47a1 !important;
    }

    .orders-summary-content-green p:first-child {
        color: #388e3c !important;
    }

    .orders-summary-content-green p:last-child {
        color: #1b5e20 !important;
    }

    .orders-summary-content-yellow p:first-child {
        color: #f57c00 !important;
    }

    .orders-summary-content-yellow p:last-child {
        color: #e65100 !important;
    }

    .orders-summary-content-purple p:first-child {
        color: #7b1fa2 !important;
    }

    .orders-summary-content-purple p:last-child {
        color: #4a148c !important;
    }

    /* Modal Styles */
    .orders-modal {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        background-color: rgba(0, 0, 0, 0.5) !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        z-index: 1000 !important;
        padding: 16px !important;
    }

    .orders-modal.hidden {
        display: none !important;
    }

    .orders-modal-content {
        background: white !important;
        border-radius: 12px !important;
        padding: 24px !important;
        max-width: 400px !important;
        width: 100% !important;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2) !important;
    }

    .orders-modal-header {
        text-align: center !important;
        margin-bottom: 24px !important;
    }

    .orders-modal-icon {
        margin-bottom: 16px !important;
        display: block !important;
    }

    .orders-modal-icon-warning {
        color: #ff9800 !important;
    }

    .orders-modal-title {
        font-weight: 600 !important;
        color: #333 !important;
        margin-bottom: 8px !important;
    }

    .orders-modal-text {
        color: #666 !important;
        line-height: 1.5 !important;
    }

    .orders-modal-actions {
        display: flex !important;
        gap: 12px !important;
    }

    /* Pagination */
    .orders-pagination {
        padding: 16px 24px !important;
        border-top: 1px solid #e0e0e0 !important;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .orders-container .container {
            padding: 15px !important;
        }
        
        .orders-nav {
            gap: 20px !important;
        }
        
        .orders-filter-card {
            padding: 20px !important;
        }
        
        .orders-filter-form {
            flex-direction: column !important;
            gap: 12px !important;
        }
        
        .orders-filter-group {
            min-width: auto !important;
        }
        
        .orders-table-head {
            display: none !important;
        }
        
        .orders-desktop-layout {
            display: none !important;
        }
        
        .orders-summary {
            grid-template-columns: 1fr !important;
        }

        .orders-header h1 {
    
        }
    }

    @media (min-width: 769px) {
        .orders-mobile-layout {
            display: none !important;
        }
    }

    /* Override any existing styles */
    .orders-container * {
        box-sizing: border-box !important;
    }

    /* Additional hover effects */
    .orders-table-row:hover .orders-action-btn {
        opacity: 1 !important;
    }

    .orders-action-btn {
        opacity: 0.7 !important;
        transition: opacity 0.3s ease !important;
    }
</style>
@endpush

@section('content')
<div class="orders-container">
    <div class="container">

        <!-- Navigation Tabs -->
        <div class="orders-nav">
            <a href="{{ route('profile.index') }}" class="orders-nav-link">
                <i class="fas fa-user" style="margin-right: 8px;"></i>
                Profil Saya
            </a>
            <a href="{{ route('profile.orders') }}" class="orders-nav-link active">
                <i class="fas fa-shopping-bag" style="margin-right: 8px;"></i>
                Riwayat pembelian
            </a>
        </div>

        <!-- Filter Section -->
        <div class="orders-filter-card">
            <form method="GET" action="{{ route('profile.orders') }}" class="orders-filter-form">
                <div class="orders-filter-group">
                    <label class="orders-filter-label">
                        <i class="fas fa-filter" style="margin-right: 6px;"></i>
                        Status Pesanan
                    </label>
                    <select name="status" class="orders-filter-select">
                        <option value="">Semua Status</option>
                        <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="Proses" {{ request('status') == 'Proses' ? 'selected' : '' }}>Proses</option>
                        <option value="Dikirim" {{ request('status') == 'Dikirim' ? 'selected' : '' }}>Dikirim</option>
                        <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="Dibatalkan" {{ request('status') == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                
                <div class="orders-filter-group">
                    <label class="orders-filter-label">
                        <i class="fas fa-calendar-alt" style="margin-right: 6px;"></i>
                        Dari Tanggal
                    </label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="orders-filter-input">
                </div>
                
                <div class="orders-filter-group">
                    <label class="orders-filter-label">
                        <i class="fas fa-calendar-alt" style="margin-right: 6px;"></i>
                        Sampai Tanggal
                    </label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="orders-filter-input">
                </div>
                
                <div>
                    <button type="submit" class="orders-btn orders-btn-primary">
                        <i class="fas fa-search"></i>Filter
                    </button>
                </div>
                
                @if(request()->hasAny(['status', 'date_from', 'date_to']))
                <div>
                    <a href="{{ route('profile.orders') }}" class="orders-btn orders-btn-outline">
                        <i class="fas fa-times"></i>Reset
                    </a>
                </div>
                @endif
            </form>
        </div>

        <!-- Orders Table -->
        <div class="orders-table-card">
            <div class="orders-table-header">
                <h3>
                    <i class="fas fa-list" style="margin-right: 8px; color: #8B4513;"></i>
                    Daftar Pesanan
                </h3>
            </div>
            
            <!-- Table Header - Desktop Only -->
            <div class="orders-table-head">
                <div>No</div>
                <div>Produk</div>
                <div>Tanggal</div>
                <div>Jumlah</div>
                <div>Harga</div>
                <div>Status</div>
                <div>Aksi</div>
            </div>

            <!-- Table Body -->
            <div class="orders-table-body">
                @forelse($orders as $index => $order)
                <div class="orders-table-row">
                    <!-- Mobile Layout -->
                    <div class="orders-mobile-layout">
                        <div class="orders-mobile-header">
                            <div class="orders-mobile-left">
                                <h4>{{ $order->product_name }}</h4>
                                <p><i class="fas fa-calendar" style="margin-right: 4px;"></i>{{ $order->created_at->format('d M Y, H:i') }}</p>
                                <p><i class="fas fa-boxes" style="margin-right: 4px;"></i>Qty: {{ $order->quantity }}</p>
                            </div>
                            <div class="orders-mobile-right">
                                <p>Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                <span class="orders-badge {{ $order->status == 'Selesai' ? 'orders-badge-success' : ($order->status == 'Dikirim' ? 'orders-badge-info' : ($order->status == 'Proses' ? 'orders-badge-warning' : 'orders-badge-secondary')) }}">
                                    {{ $order->status }}
                                </span>
                            </div>
                        </div>
                        <div class="orders-mobile-actions">
                            <button class="orders-mobile-btn orders-mobile-btn-primary">
                                <i class="fas fa-eye"></i> Detail
                            </button>
                            @if(in_array($order->status, ['Menunggu', 'Proses']))
                            <button onclick="cancelOrder({{ $order->id }})" class="orders-mobile-btn orders-mobile-btn-danger">
                                <i class="fas fa-times"></i> Batal
                            </button>
                            @endif
                        </div>
                    </div>

                    <!-- Desktop Layout -->
                    <div class="orders-desktop-layout">
                        <div class="orders-desktop-cell-secondary">{{ ($orders->currentPage() - 1) * $orders->perPage() + $index + 1 }}</div>
                        <div class="orders-desktop-cell-bold">{{ $order->product_name }}</div>
                        <div class="orders-desktop-cell-secondary">{{ $order->created_at->format('d-m-Y') }}</div>
                        <div class="orders-desktop-cell-secondary">{{ $order->quantity }}</div>
                        <div class="orders-desktop-cell-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                        <div>
                            <span class="orders-badge {{ $order->status == 'Selesai' ? 'orders-badge-success' : ($order->status == 'Dikirim' ? 'orders-badge-info' : ($order->status == 'Proses' ? 'orders-badge-warning' : 'orders-badge-secondary')) }}">
                                {{ $order->status }}
                            </span>
                        </div>
                        <div class="orders-desktop-actions">
                            <button class="orders-action-btn orders-action-btn-primary" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                            @if(in_array($order->status, ['Menunggu', 'Proses']))
                            <button onclick="cancelOrder({{ $order->id }})" class="orders-action-btn orders-action-btn-danger" title="Batalkan">
                                <i class="fas fa-times"></i>
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="orders-empty">
                    <i class="fas fa-shopping-bag"></i>
                    <h4>Belum ada riwayat pembelian</h4>
                    <p>Mulai berbelanja sekarang untuk melihat riwayat pesanan Anda di sini</p>
                    <a href="{{ route('products.index') }}" class="orders-btn orders-btn-primary">
                        Mulai Belanja
                    </a>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($orders->hasPages())
            <div class="orders-pagination">
                {{ $orders->appends(request()->query())->links() }}
            </div>
            @endif
        </div>

        <!-- Summary Cards -->
        @if($orders->count() > 0)
        <div class="orders-summary">
            <div class="orders-summary-card orders-summary-card-blue">
                <i class="fas fa-shopping-bag orders-summary-icon orders-summary-icon-blue"></i>
                <div class="orders-summary-content orders-summary-content-blue">
                    <p>Total Pesanan</p>
                    <p>{{ $orders->total() }}</p>
                </div>
            </div>
            
            <div class="orders-summary-card orders-summary-card-green">
                <i class="fas fa-check-circle orders-summary-icon orders-summary-icon-green"></i>
                <div class="orders-summary-content orders-summary-content-green">
                    <p>Selesai</p>
                    <p>{{ $orders->where('status', 'Selesai')->count() }}</p>
                </div>
            </div>
            
            <div class="orders-summary-card orders-summary-card-yellow">
                <i class="fas fa-clock orders-summary-icon orders-summary-icon-yellow"></i>
                <div class="orders-summary-content orders-summary-content-yellow">
                    <p>Proses</p>
                    <p>{{ $orders->whereIn('status', ['Menunggu', 'Proses', 'Dikirim'])->count() }}</p>
                </div>
            </div>
            
            <div class="orders-summary-card orders-summary-card-purple">
                <i class="fas fa-money-bill-wave orders-summary-icon orders-summary-icon-purple"></i>
                <div class="orders-summary-content orders-summary-content-purple">
                    <p>Total Belanja</p>
                    <p>Rp {{ number_format($orders->sum('total_price'), 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Cancel Order Modal -->
<div id="cancelModal" class="orders-modal hidden">
    <div class="orders-modal-content">
        <div class="orders-modal-header">
            <i class="fas fa-exclamation-triangle orders-modal-icon orders-modal-icon-warning"></i>
            <h3 class="orders-modal-title">Batalkan Pesanan</h3>
            <p class="orders-modal-text">Apakah Anda yakin ingin membatalkan pesanan ini? Tindakan ini tidak dapat dibatalkan.</p>
        </div>
        
        <div class="orders-modal-actions">
            <button onclick="closeCancelModal()" class="orders-btn orders-btn-outline" style="flex: 1;">
                <i class="fas fa-times"></i>
                Tidak
            </button>
            <form id="cancelForm" method="POST" style="flex: 1;">
                @csrf
                @method('PATCH')
                <button type="submit" class="orders-btn orders-btn-secondary" style="width: 100%;">
                    <i class="fas fa-check"></i>
                    Ya, Batalkan
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function cancelOrder(orderId) {
    document.getElementById('cancelForm').action = /orders/${orderId}/cancel;
    document.getElementById('cancelModal').classList.remove('hidden');
}

function closeCancelModal() {
    document.getElementById('cancelModal').classList.add('hidden');
}

// Close modal when clicking outside
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('cancelModal');
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeCancelModal();
        }
    });
    
    // Close modal with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeCancelModal();
        }
    });
});
</script>
@endsection