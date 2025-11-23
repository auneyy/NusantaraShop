@extends('admin.layout.app')

@section('title', 'Dashboard Admin - NusantaraShop')

@section('page-title', 'Beranda')

@push('styles')
<style>
    /* Stats Cards */
    .stat-card {
        background: #fff;
        padding: 24px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        transition: all 0.2s ease;
        height: 100%;
    }

    .stat-card:hover {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 16px;
    }

    .stat-title {
        font-size: 0.9rem;
        color: #64748b;
        font-weight: 500;
    }

    .stat-icon {
        width: 40px;
        height: 40px;
        background: #f8fafc;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: var(--primary-color);
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 8px;
    }

    .stat-change {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: 0.8rem;
    }

    .stat-change.positive {
        color: #059669;
    }

    .stat-change.negative {
        color: #dc2626;
    }

    .stat-change.neutral {
        color: #64748b;
    }

    /* Chart Container */
    .chart-container {
        background: #fff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .chart-header {
        padding: 24px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #fafbfc;
    }

    .chart-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #1e293b;
    }

    .filter-btn {
        padding: 6px 12px;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        background: #fff;
        color: #64748b;
        font-size: 0.8rem;
        cursor: pointer;
        transition: all 0.2s ease;
        margin-left: 8px;
    }

    .filter-btn.active {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .filter-btn:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
    }

    .filter-btn.active:hover {
        background: #352318;
        border-color: #352318;
    }

    .chart-content {
        padding: 24px;
        height: 400px;
        position: relative;
    }

    /* Data Section - Table */
    .data-section {
        background: #fff;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .section-header {
        padding: 24px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #fafbfc;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1e293b;
    }

    .btn-primary {
        background: var(--primary-color);
        border-color: var(--primary-color);
        font-weight: 500;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary:hover,
    .btn-primary:focus {
        background: #352318;
        border-color: #352318;
        transform: translateY(-1px);
    }

    /* Table Styling */
    .table {
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table th {
        background: #f8fafc;
        font-weight: 600;
        color: #374151;
        font-size: 0.9rem;
        border-bottom: 2px solid #e2e8f0;
        border-top: none;
        border-left: none;
        border-right: none;
        padding: 16px 12px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-size: 0.8rem;
    }

    .table td {
        font-size: 0.9rem;
        border-bottom: 1px solid #f1f5f9;
        border-top: none;
        border-left: none;
        border-right: none;
        padding: 16px 12px;
        vertical-align: middle;
    }

    .table tbody tr {
        transition: background-color 0.15s ease;
    }

    .table tbody tr:hover {
        background: #fafbfc;
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-block;
    }

    .status-success {
        background: #dcfce7;
        color: #166534;
    }

    .status-warning {
        background: #fef3c7;
        color: #92400e;
    }

    .status-danger {
        background: #fee2e2;
        color: #991b1b;
    }

    .status-info {
        background: #dbeafe;
        color: #1e40af;
    }

    .order-id {
        font-weight: 600;
        color: var(--primary-color);
    }

    .customer-name {
        font-weight: 500;
        color: #1e293b;
    }

    .order-total {
        font-weight: 600;
        color: #1e293b;
    }

    .order-time {
        font-size: 0.8rem;
        color: #64748b;
    }

    .loading-spinner {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 2px solid #f3f3f3;
        border-top: 2px solid var(--primary-color);
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    @media (max-width: 768px) {
        .section-header {
            flex-direction: column;
            gap: 16px;
            align-items: flex-start;
        }

        .chart-header {
            flex-direction: column;
            gap: 16px;
            align-items: flex-start;
        }

        .table-responsive {
            font-size: 0.8rem;
        }
    }
</style>
@endpush

@section('content')
<!-- Stats Grid -->
<div class="row g-4 mb-4 fade-in">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <div>
                    <div class="stat-title">Total Penjualan Hari Ini</div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
            </div>
            <div class="stat-value">Rp {{ number_format($totalSalesToday, 0, ',', '.') }}</div>
            <div class="stat-change {{ $salesChange >= 0 ? 'positive' : 'negative' }}">
                <i class="fas fa-arrow-{{ $salesChange >= 0 ? 'up' : 'down' }}"></i>
                <span>{{ abs(round($salesChange, 1)) }}% dari kemarin</span>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-title">Pesanan Baru</div>
                <div class="stat-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>
            <div class="stat-value">{{ $newOrdersToday }}</div>
            <div class="stat-change {{ $ordersChange >= 0 ? 'positive' : 'negative' }}">
                <i class="fas fa-arrow-{{ $ordersChange >= 0 ? 'up' : 'down' }}"></i>
                <span>{{ abs(round($ordersChange, 1)) }}% dari kemarin</span>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-title">Pengguna Baru</div>
                <div class="stat-icon">
                    <i class="fas fa-user-friends"></i>
                </div>
            </div>
            <div class="stat-value">{{ $newUsersToday }}</div>
            <div class="stat-change {{ $usersChange >= 0 ? 'positive' : 'negative' }}">
                <i class="fas fa-arrow-{{ $usersChange >= 0 ? 'up' : 'down' }}"></i>
                <span>{{ abs(round($usersChange, 1)) }}% dari kemarin</span>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-title">Produk Terjual</div>
                <div class="stat-icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
            </div>
            <div class="stat-value">{{ $productsSoldToday }}</div>
            <div class="stat-change {{ $productsChange >= 0 ? 'positive' : 'negative' }}">
                <i class="fas fa-arrow-{{ $productsChange >= 0 ? 'up' : 'down' }}"></i>
                <span>{{ abs(round($productsChange, 1)) }}% dari kemarin</span>
            </div>
        </div>
    </div>
</div>

<!-- Sales Chart -->
<div class="chart-container mb-4 fade-in">
    <div class="chart-header">
        <div class="chart-title">Grafik Penjualan 7 Hari Terakhir</div>
        <div class="chart-filters">
            <button class="filter-btn active" data-days="7">7 Hari</button>
            <button class="filter-btn" data-days="30">30 Hari</button>
            <button class="filter-btn" data-days="90">3 Bulan</button>
        </div>
    </div>
    <div class="chart-content">
        <canvas id="salesChart" width="100%" height="300"></canvas>
    </div>
</div>

<!-- Recent Orders -->
<div class="data-section fade-in">
    <div class="section-header">
        <div class="section-title">Pesanan Terbaru</div>
        <div class="button">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-primary">
                <i class="fas fa-eye"></i> Lihat Semua
            </a>
        </div>
    </div>
    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Status Pembayaran</th>
                        <th>Status Pesanan</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                        <tr>
                            <td><span class="order-id">#{{ $order->order_number }}</span></td>
                            <td>
                                <span class="customer-name">{{ $order->shipping_name }}</span>
                                @if($order->user)
                                    <br><small class="text-muted">{{ $order->user->email }}</small>
                                @endif
                            </td>
                            <td><span class="order-total">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span></td>
                            <td>
                                @php
                                    $paymentStatusClass = 'status-danger';
                                    if(in_array($order->payment_status, ['paid', 'settlement', 'capture'])) {
                                        $paymentStatusClass = 'status-success';
                                    } elseif(in_array($order->payment_status, ['pending', 'challenge'])) {
                                        $paymentStatusClass = 'status-warning';
                                    }
                                @endphp
                                <span class="status-badge {{ $paymentStatusClass }}">{{ $order->payment_status_label }}</span>
                            </td>
                            <td>
                                @php
                                    $orderStatusClass = 'status-danger';
                                    if($order->status == 'delivered') {
                                        $orderStatusClass = 'status-success';
                                    } elseif(in_array($order->status, ['processing', 'shipped'])) {
                                        $orderStatusClass = 'status-info';
                                    } elseif($order->status == 'pending') {
                                        $orderStatusClass = 'status-warning';
                                    }
                                @endphp
                                <span class="status-badge {{ $orderStatusClass }}">{{ $order->status_label }}</span>
                            </td>
                            <td><span class="order-time">{{ $order->order_date->diffForHumans() }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                Tidak ada pesanan terbaru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>

<script>
    // Inisialisasi chart dengan data dari controller
    const ctx = document.getElementById('salesChart').getContext('2d');
    let salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartData['labels']),
            datasets: [{
                label: 'Penjualan (Juta Rupiah)',
                data: @json($chartData['sales']),
                borderColor: 'var(--primary-color)',
                backgroundColor: 'rgba(66, 45, 28, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: 'var(--primary-color)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#1e293b',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: '#e2e8f0',
                    borderWidth: 1,
                    cornerRadius: 8,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.parsed.y.toFixed(1) + ' Juta';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f1f5f9',
                        drawBorder: false
                    },
                    ticks: {
                        color: '#64748b',
                        font: {
                            size: 12
                        },
                        callback: function(value) {
                            return 'Rp ' + value.toFixed(0) + 'Jt';
                        }
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        color: '#64748b',
                        font: {
                            size: 12
                        }
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });

    // Filter chart data
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const days = this.getAttribute('data-days');
            
            // Show loading
            this.innerHTML = '<span class="loading-spinner"></span> Loading...';
            
            // Fetch new data
            fetch(`{{ route('admin.chart.data') }}?days=${days}`)
                .then(response => response.json())
                .then(data => {
                    // Update chart
                    salesChart.data.labels = data.labels;
                    salesChart.data.datasets[0].data = data.sales;
                    salesChart.update('active');
                    
                    // Reset button text
                    this.textContent = this.getAttribute('data-days') + ' Hari';
                    if (days === '7') this.textContent = '7 Hari';
                    if (days === '30') this.textContent = '30 Hari';
                    if (days === '90') this.textContent = '3 Bulan';
                })
                .catch(error => {
                    console.error('Error fetching chart data:', error);
                    this.textContent = this.getAttribute('data-days') + ' Hari';
                });
        });
    });

    // Auto refresh stats every 30 seconds
    setInterval(function() {
        // You can implement auto-refresh here if needed
        // For now, we'll just log to console
        console.log('Dashboard stats would refresh now...');
    }, 30000);

    // Hover effects
    document.querySelectorAll('.stat-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(-2px)';
        });
    });
</script>
@endpush