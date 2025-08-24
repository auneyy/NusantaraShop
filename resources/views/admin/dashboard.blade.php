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
    }

    .chart-header {
        padding: 24px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
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

    .chart-content {
        padding: 24px;
        height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        color: #64748b;
        font-size: 1rem;
    }

    .data-section {
        background: #fff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
    }

    .section-header {
        padding: 24px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
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

    .table th {
        background: #f8fafc;
        font-weight: 600;
        color: #374151;
        font-size: 0.9rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .table td {
        font-size: 0.9rem;
        border-bottom: 1px solid #f1f5f9;
    }

    .table tbody tr:hover {
        background: #fafbfc;
    }

    .status-badge {
        padding: 4px 8px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
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

    @media (max-width: 768px) {
        .section-header {
            flex-direction: column;
            gap: 16px;
            align-items: flex-start;
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

<div class="chart-container mb-4 fade-in">
    <div class="chart-header">
        <div class="chart-title">Grafik Penjualan</div>
        <div class="chart-filters">
            <button class="filter-btn active">7 Hari</button>
            <button class="filter-btn">30 Hari</button>
            <button class="filter-btn">3 Bulan</button>
            <button class="filter-btn">1 Tahun</button>
        </div>
    </div>
    <div class="chart-content">
      <i class="fas fa-chart-line" style="font-size: 3rem; margin-bottom: 16px; color: #808080;"></i>
        <div>Grafik Penjualan akan ditampilkan di sini</div>
        <small style="margin-top: 8px; display: block;">Integrasi dengan Chart.js atau library grafik lainnya</small>
    </div>
</div>

<div class="data-section fade-in">
    <div class="section-header">
        <div class="section-title">Pesanan Terbaru</div>
        <button class="btn btn-primary">
            <i class="fas fa-eye"></i>
            Lihat Semua
        </button>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>ID Pesanan</th>
                    <th>Pelanggan</th>
                    <th>Produk</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Waktu</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>#NUS-001</td>
                    <td>Ahmad Santoso</td>
                    <td>Batik Jogja Premium</td>
                    <td>Rp 250.000</td>
                    <td><span class="status-badge status-success">Lunas</span></td>
                    <td>2 menit lalu</td>
                    <td><button class="btn btn-secondary btn-sm">Detail</button></td>
                </tr>
                <tr>
                    <td>#NUS-002</td>
                    <td>Sari Dewi</td>
                    <td>Kerajinan Bali Set</td>
                    <td>Rp 180.000</td>
                    <td><span class="status-badge status-warning">Pending</span></td>
                    <td>15 menit lalu</td>
                    <td><button class="btn btn-secondary btn-sm">Detail</button></td>
                </tr>
                <tr>
                    <td>#NUS-003</td>
                    <td>Budi Pranoto</td>
                    <td>Songket Palembang</td>
                    <td>Rp 320.000</td>
                    <td><span class="status-badge status-danger">Gagal</span></td>
                    <td>1 jam lalu</td>
                    <td><button class="btn btn-secondary btn-sm">Detail</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
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
</script>
@endpush