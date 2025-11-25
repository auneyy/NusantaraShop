@extends('layout.app')

@section('title', 'Profil Saya')

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Reset dan Base Styles */
        .profile-container {
            background-color: white !important;
            min-height: 100vh;
            padding: 0 !important;
            margin: 0 !important;
        }

        /* Override container default */
        .profile-container .container {
            max-width: 1400px !important;
            margin: 40px auto !important;
            padding: 0 20px !important;
        }

        /* Main Layout Grid */
        .profile-main-grid {
            display: grid !important;
            grid-template-columns: 400px 1fr !important;
            gap: 40px !important;
            align-items: start !important;
        }

        /* Page Title */
        .profile-page-title {
            grid-column: 1 / -1 !important;
            text-align: center !important;
            margin-bottom: 30px !important;
        }

        .profile-page-title h1 {
            color: #333 !important;
            font-weight: 600 !important;
            margin: 0 !important;
        }

        /* Profile Card - Left Side */
        .profile-main-card {
            background: white !important;
            border-radius: 12px !important;
            padding: 30px !important;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08) !important;
            height: fit-content !important;
            margin: 0 !important;
            max-width: none !important;
        }

        .profile-card-header {
            text-align: center !important;
            margin-bottom: 30px !important;
        }

        .profile-card-header h2 {
            color: #333 !important;
            margin-bottom: 20px !important;
            font-weight: 600 !important;
        }

        /* Profile Avatar */
        .profile-main-avatar {
            width: 120px !important;
            height: 120px !important;
            border-radius: 50% !important;
            margin: 0 auto 20px !important;
            background: linear-gradient(135deg, #8B4513, #D2691E) !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            color: white !important;
            overflow: hidden !important;
            position: relative !important;
        }

        .profile-main-avatar img {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
            border-radius: 50% !important;
        }

        /* Profile Info */
        .profile-main-info {
            text-align: left !important;
        }

        .profile-main-info h3 {
            color: #333 !important;
            margin-bottom: 15px !important;
            font-weight: 600 !important;
        }

        .profile-main-info p {
            color: #666 !important;
            margin-bottom: 12px !important;
            display: flex !important;
            align-items: center !important;
            gap: 10px !important;
        }

        .profile-main-info i {
            width: 16px !important;
            color: #8B4513 !important;
        }

        /* Profile Action Buttons */
        .profile-main-actions {
            display: flex !important;
            gap: 15px !important;
            margin-top: 25px !important;
        }

        .profile-btn {
            padding: 12px 24px !important;
            border-radius: 6px !important;
            text-decoration: none !important;
            font-weight: 500 !important;
            text-align: center !important;
            cursor: pointer !important;
            border: none !important;
            transition: all 0.3s !important;
            flex: 1 !important;
        }

        .profile-btn-primary {
            background-color: #8B4513 !important;
            color: white !important;
        }

        .profile-btn-primary:hover {
            background-color: #7A3F12 !important;
            color: white !important;
            text-decoration: none !important;
        }

        .profile-btn-secondary {
            background-color: white !important;
            color: #666 !important;
            border: 1px solid #ddd !important;
        }

        .profile-btn-secondary:hover {
            background-color: #f5f5f5 !important;
            color: #333 !important;
            text-decoration: none !important;
        }

        /* Content Section - Right Side */
        .profile-content-section {
            background: white !important;
            border-radius: 12px !important;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08) !important;
            overflow: hidden !important;
            display: flex !important;
            flex-direction: column !important;
            padding: 20px !important;
        }

        /* Navigation Tabs */
        .orders-nav {
            display: flex !important;
            justify-content: center !important;
            gap: 32px !important;
            margin-bottom: 24px !important;
            border-bottom: 1px solid #e0e0e0 !important;
            width: 100% !important;
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

        .profile-tab.active,
        .profile-tab:hover {
            color: #333 !important;
            border-bottom-color: #333 !important;
            background-color: #f8f9fa !important;
            text-decoration: none !important;
        }

        /* Tab Content */
        .orders-table-card {
            background: white !important;
            border-radius: 12px !important;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08) !important;
            overflow: hidden !important;
            transition: box-shadow 0.3s ease !important;
            width: 100% !important;
            margin: 0 !important;
        }

        .orders-table-card:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12) !important;
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

        /* Purchase History Table */
        .profile-table-container {
            overflow-x: auto !important;
            background: white !important;
        }

        .profile-purchase-table {
            width: 100% !important;
            border-collapse: collapse !important;
            margin-top: 10px !important;
            background: white !important;
        }

        .profile-purchase-table th {
            background-color: #f8f9fa !important;
            padding: 15px !important;
            text-align: left !important;
            font-weight: 600 !important;
            color: #333 !important;
            border-bottom: 2px solid #e0e0e0 !important;
        }

        .profile-purchase-table td {
            padding: 15px !important;
            border-bottom: 1px solid #e0e0e0 !important;
            vertical-align: middle !important;
            background: white !important;
        }

        .profile-purchase-table tr:hover {
            background-color: #f8f9fa !important;
        }

        .profile-purchase-table tr:hover td {
            background-color: #f8f9fa !important;
        }

        /* Status Badges */
        .profile-status-badge {
            padding: 6px 12px !important;
            border-radius: 20px !important;
            font-weight: 500 !important;
            text-transform: capitalize !important;
            display: inline-block !important;
        }

        .profile-status-selesai {
            background-color: #d4edda !important;
            color: #155724 !important;
        }

        .profile-status-dalam-proses {
            background-color: #fff3cd !important;
            color: #856404 !important;
        }

        .profile-status-delivered {
            background-color: #d1ecf1 !important;
            color: #0c5460 !important;
        }

        /* Empty State */
        .profile-empty-state {
            text-align: center !important;
            color: #999 !important;
            padding: 60px 20px !important;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .profile-main-grid {
                grid-template-columns: 1fr !important;
                gap: 20px !important;
            }

            .profile-main-actions {
                flex-direction: column !important;
            }

            .profile-tabs {
                flex-wrap: wrap !important;
            }

            .profile-tab {
                flex: 1 !important;
                padding: 15px 10px !important;
            }

            .profile-tab-content {
                padding: 20px !important;
            }

            .profile-purchase-table {
                display: none !important;
            }

            .profile-mobile-orders {
                display: block !important;
            }
        }

        /* Hide default mobile view on desktop */
        .profile-mobile-orders {
            display: none !important;
        }

        /* Mobile Order Cards */
        .profile-mobile-order-item {
            background: #f8f9fa !important;
            padding: 15px !important;
            margin-bottom: 10px !important;
            border-radius: 8px !important;
            border-left: 4px solid #8B4513 !important;
        }

        .profile-mobile-order-header {
            display: flex !important;
            justify-content: space-between !important;
            align-items: flex-start !important;
            margin-bottom: 10px !important;
        }

        .profile-mobile-order-product {
            font-weight: 600 !important;
            color: #333 !important;
            margin-bottom: 5px !important;
        }

        .profile-mobile-order-date {
            color: #666 !important;
        }

        .profile-mobile-order-details {
            display: flex !important;
            justify-content: space-between !important;
        }

        .profile-mobile-order-quantity {
            color: #666 !important;
        }

        .profile-mobile-order-price {
            font-weight: 600 !important;
            color: #333 !important;
        }

        /* Override any existing styles */
        .profile-container * {
            box-sizing: border-box !important;
        }

        /* Hide original styling conflicts */
        .profile-container .bg-gray-100,
        .profile-container .bg-gray-300,
        .profile-container .bg-amber-600,
        .profile-container .bg-amber-700 {
            background: transparent !important;
        }
    </style>
@endpush

@section('content')
    <div class="profile-container">
        <div class="container">

            <div class="profile-main-grid">
                <!-- Profile Card - Left Side -->
                <div class="profile-main-card">
                    <div class="profile-card-header">
                        <h3>Profil Saya</h3>
                    </div>

                    <div class="profile-main-avatar">
                        @if($user->profile_image)
                            <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile">
                        @else
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        @endif
                    </div>

                    <div class="profile-main-info">
                        <h3>{{ $user->name }}</h3>
                        <p><i class="fas fa-envelope"></i> {{ $user->email }}</p>
                        <p><i class="fas fa-phone"></i> {{ $user->phone ?? '082143399676' }}</p>
                        <p><i class="fas fa-map-marker-alt"></i> Jalan Kembang</p>
                        <p><i class="fas fa-city"></i> No 19, Kota Malang</p>
                    </div>

                    <div class="profile-main-actions">
                        <a href="{{ route('profile.edit') }}" class="profile-btn profile-btn-primary">Edit Profil</a>
                        <a href="{{ route('profile.password') }}" class="profile-btn profile-btn-secondary">Ubah Password</a>
                    </div>
                </div>

                <!-- Content Section - Right Side -->
                <div class="profile-content-section">
                    <!-- Navigation Tabs -->
                    <div class="orders-nav">
                        <a href="{{ route('profile.index') }}" class="orders-nav-link active">
                            <i class="fas fa-user" style="margin-right: 8px;"></i>
                            Profil Saya
                        </a>
                        <a href="{{ route('profile.orders') }}" class="orders-nav-link">
                            <i class="fas fa-shopping-bag" style="margin-right: 8px;"></i>
                            Riwayat pembelian
                        </a>
                    </div>

                    <div class="orders-table-card">
                        <div class="orders-table-header">
                            <h4>
                                <i class="fas fa-list" style="margin-right: 8px; color: #8B4513;"></i>
                                Riwayat Pembelian
                            </h4>
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
                                        <th>Harga</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                               @forelse ($orders as $index => $order)
    @foreach ($order->orderItems as $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $item->product->name }}</td>
            <td>{{ $order->created_at->format('d-m-Y') }}</td>
            <td>{{ $item->quantity }}</td>
            <td>Rp{{ number_format($item->total_price, 0, ',', '.') }}</td>
            <td>
                <span class="profile-status-badge 
                        @if($order->status == 'Selesai') profile-status-selesai
                        @elseif($order->status == 'Dalam Proses') profile-status-dalam-proses
                        @else profile-status-delivered
                        @endif">
                    {{ $order->status }}
                </span>
            </td>
        </tr>
    @endforeach
@empty
    <tr>
        <td colspan="6" class="profile-empty-state">
            Belum ada riwayat pembelian
        </td>
    </tr>
@endforelse

                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Cards -->
                        <div class="profile-mobile-orders">
                            @forelse($orders as $order)
                                <div class="profile-mobile-order-item">
                                    <div class="profile-mobile-order-header">
                                        <div>
                                            <div class="profile-mobile-order-product">{{ $order->product_name }}</div>
                                            <div class="profile-mobile-order-date">{{ $order->created_at->format('d-m-Y') }}</div>
                                        </div>
                                        <span class="profile-status-badge 
                                                @if($order->status == 'Selesai') profile-status-selesai
                                                @elseif($order->status == 'Dalam Proses') profile-status-dalam-proses
                                                @else profile-status-delivered
                                                @endif">
                                            {{ $order->status }}
                                        </span>
                                    </div>
                                    <div class="profile-mobile-order-details">
                                        <span class="profile-mobile-order-quantity">Jumlah: {{ $order->quantity }}</span>
                                        <span
                                            class="profile-mobile-order-price">Rp{{ number_format($order->total_price, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            @empty
                                <div class="profile-empty-state">
                                    Belum ada riwayat pembelian
                                </div>
                            @endforelse
                        </div>

                        @if(isset($orders) && $orders->hasPages())
                            <div style="padding: 20px; border-top: 1px solid #e0e0e0; background-color: #f8f9fa;">
                                {{ $orders->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection