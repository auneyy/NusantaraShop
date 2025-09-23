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

    .btn-secondary {
        background: #f8fafc;
        color: #64748b;
        border-color: #e2e8f0;
        font-size: 0.8rem;
    }

    .btn-secondary:hover,
    .btn-secondary:focus {
        background: #e2e8f0;
        color: var(--primary-color);
        border-color: #e2e8f0;
    }

    /* Table Styling - No Border Radius */
    .table-container {
        background: #fff;
        overflow: hidden;
    }

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

    .order-id {
        font-weight: 600;
        color: var(--primary-color);
    }

    .customer-name {
        font-weight: 500;
        color: #1e293b;
    }

    .product-name {
        color: #64748b;
    }

    .order-total {
        font-weight: 600;
        color: #1e293b;
    }

    .order-time {
        font-size: 0.8rem;
        color: #64748b;
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
            <div class="stat-value">Rp 24,8 Juta</div>
            <div class="stat-change positive">
                <i class="fas fa-arrow-up"></i>
                <span>+12.5% dari kemarin</span>
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
            <div class="stat-value">87</div>
            <div class="stat-change positive">
                <i class="fas fa-arrow-up"></i>
                <span>+8.3% dari kemarin</span>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-title">Pengguna Aktif</div>
                <div class="stat-icon">
                    <i class="fas fa-user-friends"></i>
                </div>
            </div>
            <div class="stat-value">1,234</div>
            <div class="stat-change positive">
                <i class="fas fa-arrow-up"></i>
                <span>+15.2% dari bulan lalu</span>
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
            <div class="stat-value">456</div>
            <div class="stat-change negative">
                <i class="fas fa-arrow-down"></i>
                <span>-2.1% dari kemarin</span>
            </div>
        </div>
    </div>
</div>

<!-- Sales Chart -->
<div class="chart-container mb-4 fade-in">
    <div class="chart-header">
        <div class="chart-title">Grafik Penjualan</div>
        <div class="chart-filters">
            <button class="filter-btn active" data-period="7">7 Hari</button>
            <button class="filter-btn" data-period="30">30 Hari</button>
            <button class="filter-btn" data-period="90">3 Bulan</button>
            <button class="filter-btn" data-period="365">1 Tahun</button>
        </div>
    </div>
    <div class="chart-content">
        <canvas id="salesChart" width="100%" height="300"></canvas>
    </div>
</div>

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
                            <td><span class="customer-name">{{ $order->shipping_name }}</span></td>
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
                                    } elseif($order->status == 'processing') {
                                        $orderStatusClass = 'status-info';
                                    } elseif($order->status == 'shipped') {
                                        $orderStatusClass = 'status-info';
                                    } elseif($order->status == 'pending') {
                                        $orderStatusClass = 'status-warning';
                                    }
                                @endphp
                                <span class="status-badge {{ $orderStatusClass }}">{{ $order->status_label }}</span>
                            </td>
                            <td><span class="order-time">{{ $order->created_at->diffForHumans() }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada pesanan terbaru.</td>
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
    const salesData = {
        '7': {
            labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
            data: [12.5, 19.2, 15.8, 25.1, 22.4, 18.7, 24.8]
        },
        '30': {
            labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
            data: [85.4, 92.1, 78.6, 96.3]
        },
        '90': {
            labels: ['Jan', 'Feb', 'Mar'],
            data: [320.5, 285.7, 412.8]
        },
        '365': {
            labels: ['Q1', 'Q2', 'Q3', 'Q4'],
            data: [1250.4, 1380.2, 1150.8, 1420.6]
        }
    };

    const ctx = document.getElementById('salesChart').getContext('2d');
    let salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: salesData['7'].labels,
            datasets: [{
                label: 'Penjualan (Juta Rupiah)',
                data: salesData['7'].data,
                borderColor: 'var(--primary-color)',
                backgroundColor: 'rgba(67, 56, 202, 0.1)',
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
                            return 'Rp ' + context.parsed.y + ' Juta';
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
                            return 'Rp ' + value + 'Jt';
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

    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const period = this.getAttribute('data-period');
            const data = salesData[period];
            
            salesChart.data.labels = data.labels;
            salesChart.data.datasets[0].data = data.data;
            salesChart.update('active');
            
            console.log('Filter selected:', this.textContent);
        });
    });

    document.querySelectorAll('.stat-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(-2px)';
        });
    });

    document.querySelectorAll('.table tbody tr').forEach(row => {
        row.addEventListener('click', function() {
            document.querySelectorAll('.table tbody tr').forEach(r => r.classList.remove('table-active'));
            this.classList.add('table-active');
        });
    });

    setInterval(function() {
        console.log('Auto-refreshing dashboard data...');
        
        const totalSales = document.querySelector('.stat-value');
        if (totalSales && totalSales.textContent.includes('24,8')) {
            totalSales.style.transition = 'all 0.3s ease';
            totalSales.style.transform = 'scale(1.1)';
            setTimeout(() => {
                totalSales.style.transform = 'scale(1)';
            }, 300);
        }
    }, 30000);
</script>
@endpush