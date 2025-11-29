@extends('layout.app')

@section('title', 'Riwayat Pembelian')

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Reset dan Base Styles */
        .profile-container {
            background-color: #f5f6fa;
            min-height: 100vh;
            padding: 40px 0;
        }

        .profile-container .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Main Layout Grid */
        .profile-main-grid {
            display: grid;
            grid-template-columns: 380px 1fr;
            gap: 24px;
            align-items: start;
        }

        /* Profile Card - Left Side */
        .profile-main-card {
            background: white;
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
            position: sticky;
            top: 20px;
        }

        .profile-card-header {
            text-align: center;
            margin-bottom: 24px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e8e9ed;
        }

        .profile-card-header h3 {
            color: #1a1d2e;
            margin: 0;
            font-weight: 600;
            font-size: 1.35rem;
            letter-spacing: -0.02em;
        }

        /* Profile Avatar */
        .profile-main-avatar {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, #8B4513, #D2691E);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            overflow: hidden;
            font-size: 2rem;
            font-weight: 600;
            box-shadow: 0 8px 16px rgba(139, 69, 19, 0.12);
        }

        .profile-main-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Profile Info */
        .profile-main-info {
            text-align: left;
        }

        .profile-main-info h3 {
            color: #1a1d2e;
            margin-bottom: 20px;
            font-weight: 600;
            font-size: 1.25rem;
            text-align: center;
            letter-spacing: -0.02em;
        }

        .profile-main-info p {
            color: #4a5568;
            margin-bottom: 14px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            line-height: 1.5;
            padding: 10px 0;
            font-size: 0.925rem;
        }

        .profile-main-info p:not(:last-child) {
            border-bottom: 1px solid #f7f8fa;
        }

        .profile-main-info i {
            width: 18px;
            color: #8B4513;
            margin-top: 2px;
            flex-shrink: 0;
            opacity: 0.85;
        }

        /* Profile Action Buttons */
        .profile-main-actions {
            display: flex;
            gap: 10px;
            margin-top: 24px;
            flex-direction: column;
        }

        .profile-btn {
            padding: 13px 20px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 500;
            text-align: center;
            cursor: pointer;
            border: none;
            transition: all 0.2s ease;
            font-size: 0.925rem;
            letter-spacing: -0.01em;
        }

        .profile-btn-primary {
            background-color: #8B4513;
            color: white;
        }

        .profile-btn-primary:hover {
            background-color: #7A3F12;
            color: white;
            text-decoration: none;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(139, 69, 19, 0.25);
        }

        .profile-btn-secondary {
            background-color: #f7f8fa;
            color: #4a5568;
            border: 1px solid #e8e9ed;
        }

        .profile-btn-secondary:hover {
            background-color: #edf0f3;
            color: #1a1d2e;
            text-decoration: none;
            border-color: #d4d7dd;
        }

        /* Content Section - Right Side */
        .profile-content-section {
            background: white;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }

        /* Navigation Tabs */
        .orders-nav {
            display: flex;
            justify-content: center;
            gap: 40px;
            background: #fafbfc;
            padding: 0 32px;
            border-bottom: 1px solid #e8e9ed;
        }

        .orders-nav-link {
            padding: 18px 0;
            text-decoration: none;
            color: #6b7280;
            font-weight: 500;
            border-bottom: 2px solid transparent;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            font-size: 0.925rem;
            letter-spacing: -0.01em;
        }

        .orders-nav-link:hover {
            color: #8B4513;
            text-decoration: none;
        }

        .orders-nav-link.active {
            color: #8B4513;
            border-bottom-color: #8B4513;
            font-weight: 600;
        }

        /* Tab Content */
        .orders-table-card {
            background: white;
        }

        .orders-table-header {
            background-color: #fafbfc;
            padding: 24px 32px;
            border-bottom: 1px solid #e8e9ed;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }

        .orders-table-header h4 {
            font-weight: 600;
            color: #1a1d2e;
            margin: 0;
            font-size: 1.15rem;
            display: flex;
            align-items: center;
            gap: 10px;
            letter-spacing: -0.02em;
        }

        /* Filter Section */
        .filter-section {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .filter-dropdown {
            position: relative;
        }

        .filter-btn {
            padding: 10px 18px;
            background: white;
            border: 1px solid #e8e9ed;
            border-radius: 8px;
            color: #4a5568;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
        }

        .filter-btn:hover {
            border-color: #8B4513;
            color: #8B4513;
        }

        .filter-btn.active {
            background: #8B4513;
            color: white;
            border-color: #8B4513;
        }

        /* Purchase History Table */
        .profile-table-container {
            overflow-x: auto;
            background: white;
        }

        .profile-purchase-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        .profile-purchase-table th {
            background-color: #fafbfc;
            padding: 16px 24px;
            text-align: left;
            font-weight: 600;
            color: #4a5568;
            border-bottom: 1px solid #e8e9ed;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .profile-purchase-table td {
            padding: 20px 24px;
            border-bottom: 1px solid #f7f8fa;
            vertical-align: middle;
            background: white;
            font-size: 0.9rem;
            color: #4a5568;
        }

        .profile-purchase-table tbody tr {
            transition: background-color 0.15s ease;
        }

        .profile-purchase-table tbody tr:hover {
            background-color: #fafbfc;
        }

        .profile-purchase-table tbody tr:hover td {
            background-color: transparent;
        }

        /* Product Image in Table */
        .product-image-container {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            overflow: hidden;
            background: #f7f8fa;
            flex-shrink: 0;
        }

        .product-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-info-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .product-details {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .product-name {
            font-weight: 500;
            color: #1a1d2e;
            line-height: 1.3;
        }

        .product-size {
            color: #9ca3af;
            font-size: 0.825rem;
        }

        /* Status Badges */
        .profile-status-badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 500;
            text-transform: capitalize;
            display: inline-block;
            font-size: 0.8rem;
            letter-spacing: -0.01em;
        }

        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-processing {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .status-shipped, .status-dikirim {
            background-color: #ccfbf1;
            color: #115e59;
        }

        .status-delivered, .status-diterima {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-cancelled {
            background-color: #fee2e2;
            color: #991b1b;
        }

        /* Empty State */
        .profile-empty-state {
            text-align: center;
            color: #9ca3af;
            padding: 80px 20px;
            font-size: 0.95rem;
        }

        .empty-state-icon {
            font-size: 3.5rem;
            margin-bottom: 16px;
            opacity: 0.4;
        }

        /* Order Actions */
        .order-actions {
            display: flex;
            gap: 8px;
        }

        .order-action-btn {
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.825rem;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            letter-spacing: -0.01em;
        }

        .order-action-view {
            background: #8B4513;
            color: white;
        }

        .order-action-view:hover {
            background: #7A3F12;
            color: white;
            text-decoration: none;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(139, 69, 19, 0.2);
        }

        /* Success Messages */
        .alert-success {
            background: #d1fae5;
            border: 1px solid #a7f3d0;
            color: #065f46;
            padding: 16px 24px;
            border-radius: 12px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.925rem;
        }

        .alert-success i {
            font-size: 1.1rem;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .profile-container {
                padding: 20px 0;
            }

            .profile-main-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .profile-main-card {
                padding: 24px;
                position: relative;
                top: 0;
            }

            .profile-main-avatar {
                width: 90px;
                height: 90px;
                font-size: 1.75rem;
            }

            .orders-nav {
                padding: 0 20px;
                gap: 24px;
            }

            .orders-nav-link {
                padding: 14px 0;
                font-size: 0.875rem;
            }

            .orders-table-header {
                padding: 20px;
                flex-direction: column;
                align-items: flex-start;
            }

            .filter-section {
                width: 100%;
                overflow-x: auto;
            }

            .profile-table-container {
                display: none;
            }

            .profile-mobile-orders {
                display: block !important;
                padding: 16px;
            }
        }

        /* Hide mobile view on desktop */
        .profile-mobile-orders {
            display: none;
        }

        /* Mobile Order Cards */
        .profile-mobile-order-item {
            background: #fafbfc;
            padding: 16px;
            margin-bottom: 12px;
            border-radius: 12px;
            border-left: 3px solid #8B4513;
        }

        .profile-mobile-order-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
            gap: 12px;
        }

        .profile-mobile-order-product {
            font-weight: 600;
            color: #1a1d2e;
            margin-bottom: 6px;
            font-size: 0.925rem;
            line-height: 1.4;
        }

        .profile-mobile-order-date {
            color: #6b7280;
            font-size: 0.825rem;
        }

        .profile-mobile-order-details {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .profile-mobile-order-quantity {
            color: #6b7280;
            font-size: 0.825rem;
        }

        .profile-mobile-order-price {
            font-weight: 600;
            color: #1a1d2e;
            font-size: 0.925rem;
        }

        /* Loading State */
        .loading-overlay {
            display: none;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            z-index: 10;
            align-items: center;
            justify-content: center;
        }

        .loading-overlay.active {
            display: flex;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 3px solid #f3f4f6;
            border-top-color: #8B4513;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
@endpush

@section('content')
    <div class="profile-container">
        <div class="container">
            <!-- Success Messages -->
            @if(session('success'))
                <div class="alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="profile-main-grid">
                <!-- Profile Card - Left Side -->
                <div class="profile-main-card">
                    <div class="profile-card-header">
                        <h3>Profil Saya</h3>
                    </div>

                    <div class="profile-main-avatar">
                        @if($user->profile_image)
                            <img src="{{ $user->getProfileImageUrl() }}" alt="Profile">
                        @else
                            {{ $user->getInitials() }}
                        @endif
                    </div>

                    <div class="profile-main-info">
                        <h3>{{ $user->name }}</h3>
                        <p><i class="fas fa-envelope"></i> <span>{{ $user->email }}</span></p>
                        <p><i class="fas fa-phone"></i> <span>{{ $user->phone ?? 'Belum diatur' }}</span></p>
                        
                        @if($user->birth_date)
                            <p><i class="fas fa-birthday-cake"></i> <span>{{ $user->birth_date->format('d F Y') }}</span></p>
                        @endif
                        
                        @if($user->gender)
                            <p><i class="fas fa-venus-mars"></i> 
                                <span>
                                    @if($user->gender == 'male') Laki-laki
                                    @elseif($user->gender == 'female') Perempuan
                                    @else Lainnya
                                    @endif
                                </span>
                            </p>
                        @endif
                        
                        @if($user->address_data && $user->getFormattedAddress())
                            <p><i class="fas fa-map-marker-alt"></i> <span>{{ $user->getFormattedAddress() }}</span></p>
                        @else
                            @php
                                $latestAddress = $user->getLatestShippingAddress();
                            @endphp
                            
                            @if($latestAddress)
                                <p><i class="fas fa-map-marker-alt"></i> <span>{{ $latestAddress['address'] }}</span></p>
                                <p><i class="fas fa-city"></i> 
                                    <span>
                                        {{ $latestAddress['district'] }}, 
                                        {{ $latestAddress['city'] }}, 
                                        {{ $latestAddress['province'] }} 
                                        {{ $latestAddress['postal_code'] }}
                                    </span>
                                </p>
                            @else
                                <p><i class="fas fa-map-marker-alt"></i> <span>Belum ada alamat pengiriman</span></p>
                            @endif
                        @endif
                    </div>
                </div>

                <!-- Content Section - Right Side -->
                <div class="profile-content-section">
                    <!-- Navigation Tabs -->
                    <div class="orders-nav">
                        <a href="{{ route('profile.index') }}" class="orders-nav-link">
                            <i class="fas fa-user" style="margin-right: 8px;"></i>
                            Profil Saya
                        </a>
                        <a href="{{ route('profile.orders') }}" class="orders-nav-link active">
                            <i class="fas fa-shopping-bag" style="margin-right: 8px;"></i>
                            Riwayat Pembelian
                        </a>
                    </div>

                    <div class="orders-table-card" style="position: relative;">
                        <div class="loading-overlay">
                            <div class="spinner"></div>
                        </div>

                        <div class="orders-table-header">
                            <h4>
                                <i class="fas fa-history" style="color: #8B4513;"></i>
                                Riwayat Pembelian
                            </h4>
                            <div class="filter-section">
                                <button class="filter-btn active" data-status="all">
                                    <i class="fas fa-list"></i>
                                    Semua
                                </button>
                                <button class="filter-btn" data-status="pending">
                                    <i class="fas fa-clock"></i>
                                    Pending
                                </button>
                                <button class="filter-btn" data-status="processing">
                                    <i class="fas fa-sync"></i>
                                    Diproses
                                </button>
                                <button class="filter-btn" data-status="shipped">
                                    <i class="fas fa-truck"></i>
                                    Dikirim
                                </button>
                                <button class="filter-btn" data-status="delivered">
                                    <i class="fas fa-check-circle"></i>
                                    Selesai
                                </button>
                            </div>
                        </div>

                        <!-- Desktop Table -->
                        <div class="profile-table-container">
                            <table class="profile-purchase-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Produk</th>
                                        <th>Tanggal</th>
                                        <th>Jumlah</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="orders-tbody">
                                    @forelse ($orders as $index => $order)
                                        @foreach ($order->orderItems as $itemIndex => $item)
                                            <tr data-status="{{ $order->status }}">
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <div class="product-info-wrapper">
                                                        <div class="product-image-container">
                                                            <img src="{{ $item->product->images->first()->image_path ?? '/images/placeholder.jpg' }}" 
                                                                 alt="{{ $item->product->name }}" 
                                                                 class="product-image"
                                                                 onerror="this.src='/images/placeholder.jpg'">
                                                        </div>
                                                        <div class="product-details">
                                                            <div class="product-name">{{ $item->product->name }}</div>
                                                            <small class="product-size">Size: {{ $item->size }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $order->created_at->format('d M Y') }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td style="font-weight: 500; color: #1a1d2e;">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                                <td>
                                                    <span class="profile-status-badge status-{{ $order->status }}">
                                                        {{ $order->getStatusLabelAttribute() }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('orders.show', $order->order_number) }}" 
                                                       class="order-action-btn order-action-view">
                                                        <i style="margin-right: 4px;"></i>Detail
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @empty
                                        <tr id="empty-state-row">
                                            <td colspan="7" class="profile-empty-state">
                                                <div class="empty-state-icon">📦</div>
                                                <div>Belum ada riwayat pembelian</div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Cards -->
                        <div class="profile-mobile-orders" id="mobile-orders">
                            @forelse($orders as $order)
                                @foreach($order->orderItems as $item)
                                    <div class="profile-mobile-order-item" data-status="{{ $order->status }}">
                                        <div class="profile-mobile-order-header">
                                            <div>
                                                <div class="profile-mobile-order-product">{{ $item->product->name }}</div>
                                                <div class="profile-mobile-order-date">{{ $order->created_at->format('d M Y') }}</div>
                                                <small class="product-size">Size: {{ $item->size }}</small>
                                            </div>
                                            <span class="profile-status-badge status-{{ $order->status }}">
                                                {{ $order->getStatusLabelAttribute() }}
                                            </span>
                                        </div>
                                        <div class="profile-mobile-order-details">
                                            <span class="profile-mobile-order-quantity">Jumlah: {{ $item->quantity }}</span>
                                            <span class="profile-mobile-order-price">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="order-actions">
                                            <a href="{{ route('orders.show', $order->order_number) }}" 
                                               class="order-action-btn order-action-view">
                                                <i class="fas fa-eye" style="margin-right: 4px;"></i>Lihat Detail
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            @empty
                                <div class="profile-empty-state" id="mobile-empty-state">
                                    <div class="empty-state-icon">📦</div>
                                    <div>Belum ada riwayat pembelian</div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const tableRows = document.querySelectorAll('#orders-tbody tr[data-status]');
    const mobileOrders = document.querySelectorAll('#mobile-orders .profile-mobile-order-item[data-status]');
    const loadingOverlay = document.querySelector('.loading-overlay');

    // Filter functionality
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const status = this.getAttribute('data-status');
            
            // Show loading
            loadingOverlay.classList.add('active');
            
            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Simulate loading delay for smooth UX
            setTimeout(() => {
                // Filter desktop table
                let visibleCount = 0;
                tableRows.forEach(row => {
                    if (status === 'all' || row.getAttribute('data-status') === status) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Filter mobile cards
                let mobileVisibleCount = 0;
                mobileOrders.forEach(order => {
                    if (status === 'all' || order.getAttribute('data-status') === status) {
                        order.style.display = '';
                        mobileVisibleCount++;
                    } else {
                        order.style.display = 'none';
                    }
                });

                // Show empty state if no results
                const emptyStateRow = document.getElementById('empty-state-row');
                const mobileEmptyState = document.getElementById('mobile-empty-state');
                
                if (emptyStateRow) {
                    emptyStateRow.style.display = visibleCount === 0 ? '' : 'none';
                }
                
                if (mobileEmptyState) {
                    mobileEmptyState.style.display = mobileVisibleCount === 0 ? 'block' : 'none';
                }

                // Hide loading
                loadingOverlay.classList.remove('active');
            }, 300);
        });
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});
</script>
@endpush