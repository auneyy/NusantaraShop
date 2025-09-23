@extends('admin.layout.app')

@section('title', 'Dashboard Admin - NusantaraShop')

@section('page-title', 'Laporan Pendapatan')

@section('content')
<div class="container-fluid px-3">
    <!-- Summary Cards Section -->
    <div class="row g-3 mb-4">
        <!-- Total Pendapatan Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border shadow-sm h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-brown bg-opacity-10 rounded-2 p-2">
                                <svg class="text-brown" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="small text-muted fw-medium mb-1">Total Pendapatan</div>
                            <div class="h5 mb-1 text-dark fw-semibold">Rp 125.750.000</div>
                            <div class="small text-success">
                                <i class="fas fa-arrow-up me-1"></i>12.5%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jumlah Order Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border shadow-sm h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-brown bg-opacity-10 rounded-2 p-2">
                                <svg class="text-brown" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="small text-muted fw-medium mb-1">Jumlah Order</div>
                            <div class="h5 mb-1 text-dark fw-semibold">2,847</div>
                            <div class="small text-success">
                                <i class="fas fa-arrow-up me-1"></i>8.2%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rata-rata Order Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border shadow-sm h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-brown bg-opacity-10 rounded-2 p-2">
                                <svg class="text-brown" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="small text-muted fw-medium mb-1">Rata-rata Order</div>
                            <div class="h5 mb-1 text-dark fw-semibold">Rp 441.750</div>
                            <div class="small text-success">
                                <i class="fas fa-arrow-up me-1"></i>3.7%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pendapatan Bersih Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border shadow-sm h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-brown bg-opacity-10 rounded-2 p-2">
                                <svg class="text-brown" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="small text-muted fw-medium mb-1">Pendapatan Bersih</div>
                            <div class="h5 mb-1 text-dark fw-semibold">Rp 118.925.000</div>
                            <div class="small text-success">
                                <i class="fas fa-arrow-up me-1"></i>15.3%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Rincian Penjualan -->
    <div class="card border shadow-sm">
        <div class="card-header bg-light border-bottom py-3">
            <div class="d-flex align-items-center">
                <svg class="me-2 text-brown" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h2a2 2 0 002-2z"></path>
                </svg>
                <span class="fw-semibold text-dark">Rincian Penjualan</span>
            </div>
        </div>
        <div class="card-body p-0 bg-white">
            <div class="table-responsive">
                <table class="table table-hover table-sm mb-0">
                    <thead class="bg-light border-bottom">
                        <tr>
                            <th class="px-3 py-3 text-muted fw-semibold small border-0">Tanggal</th>
                            <th class="px-3 py-3 text-muted fw-semibold small text-center border-0">Order</th>
                            <th class="px-3 py-3 text-muted fw-semibold small text-end border-0">Pendapatan Kotor</th>
                            <th class="px-3 py-3 text-muted fw-semibold small text-end border-0">Diskon</th>
                            <th class="px-3 py-3 text-muted fw-semibold small text-end border-0">Retur</th>
                            <th class="px-3 py-3 text-muted fw-semibold small text-end border-0">Pendapatan Bersih</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        <tr class="border-bottom">
                            <td class="px-3 py-3 fw-medium small">21 Sep 2024</td>
                            <td class="px-3 py-3 text-center small">125</td>
                            <td class="px-3 py-3 text-end small">Rp 18.750.000</td>
                            <td class="px-3 py-3 text-end text-danger small">-Rp 1.200.000</td>
                            <td class="px-3 py-3 text-end text-danger small">-Rp 350.000</td>
                            <td class="px-3 py-3 text-end fw-semibold text-success small">Rp 17.200.000</td>
                        </tr>
                        <tr class="border-bottom">
                            <td class="px-3 py-3 fw-medium small">20 Sep 2024</td>
                            <td class="px-3 py-3 text-center small">98</td>
                            <td class="px-3 py-3 text-end small">Rp 14.250.000</td>
                            <td class="px-3 py-3 text-end text-danger small">-Rp 850.000</td>
                            <td class="px-3 py-3 text-end text-danger small">-Rp 175.000</td>
                            <td class="px-3 py-3 text-end fw-semibold text-success small">Rp 13.225.000</td>
                        </tr>
                        <tr class="border-bottom">
                            <td class="px-3 py-3 fw-medium small">19 Sep 2024</td>
                            <td class="px-3 py-3 text-center small">142</td>
                            <td class="px-3 py-3 text-end small">Rp 21.500.000</td>
                            <td class="px-3 py-3 text-end text-danger small">-Rp 1.450.000</td>
                            <td class="px-3 py-3 text-end text-danger small">-Rp 275.000</td>
                            <td class="px-3 py-3 text-end fw-semibold text-success small">Rp 19.775.000</td>
                        </tr>
                        <tr class="border-bottom">
                            <td class="px-3 py-3 fw-medium small">18 Sep 2024</td>
                            <td class="px-3 py-3 text-center small">87</td>
                            <td class="px-3 py-3 text-end small">Rp 12.900.000</td>
                            <td class="px-3 py-3 text-end text-danger small">-Rp 650.000</td>
                            <td class="px-3 py-3 text-end text-danger small">-Rp 125.000</td>
                            <td class="px-3 py-3 text-end fw-semibold text-success small">Rp 12.125.000</td>
                        </tr>
                        <tr class="border-bottom">
                            <td class="px-3 py-3 fw-medium small">17 Sep 2024</td>
                            <td class="px-3 py-3 text-center small">156</td>
                            <td class="px-3 py-3 text-end small">Rp 23.800.000</td>
                            <td class="px-3 py-3 text-end text-danger small">-Rp 1.750.000</td>
                            <td class="px-3 py-3 text-end text-danger small">-Rp 450.000</td>
                            <td class="px-3 py-3 text-end fw-semibold text-success small">Rp 21.600.000</td>
                        </tr>
                        <tr class="border-bottom">
                            <td class="px-3 py-3 fw-medium small">16 Sep 2024</td>
                            <td class="px-3 py-3 text-center small">103</td>
                            <td class="px-3 py-3 text-end small">Rp 15.750.000</td>
                            <td class="px-3 py-3 text-end text-danger small">-Rp 950.000</td>
                            <td class="px-3 py-3 text-end text-danger small">-Rp 200.000</td>
                            <td class="px-3 py-3 text-end fw-semibold text-success small">Rp 14.600.000</td>
                        </tr>
                        <tr class="border-bottom">
                            <td class="px-3 py-3 fw-medium small">15 Sep 2024</td>
                            <td class="px-3 py-3 text-center small">119</td>
                            <td class="px-3 py-3 text-end small">Rp 18.250.000</td>
                            <td class="px-3 py-3 text-end text-danger small">-Rp 1.100.000</td>
                            <td class="px-3 py-3 text-end text-danger small">-Rp 325.000</td>
                            <td class="px-3 py-3 text-end fw-semibold text-success small">Rp 16.825.000</td>
                        </tr>
                    </tbody>
                    <!-- Total Row -->
                    <tfoot>
                        <tr class="bg-light border-top border-brown">
                            <td class="px-3 py-3 fw-bold text-dark small">TOTAL</td>
                            <td class="px-3 py-3 text-center fw-bold text-dark small">830</td>
                            <td class="px-3 py-3 text-end fw-bold text-dark small">Rp 125.200.000</td>
                            <td class="px-3 py-3 text-end fw-bold text-danger small">-Rp 7.950.000</td>
                            <td class="px-3 py-3 text-end fw-bold text-danger small">-Rp 1.900.000</td>
                            <td class="px-3 py-3 text-end fw-bold text-success">Rp 115.350.000</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Custom CSS -->
<style>
:root {
    --brown-color: #8B4513;
    --brown-light: rgba(139, 69, 19, 0.1);
    --brown-dark: #5D2E08;
}

body {
    background-color: #f8f9fa;
}

.bg-brown {
    background-color: var(--brown-color) !important;
}

.text-brown {
    color: var(--brown-color) !important;
}

.btn-brown {
    background-color: var(--brown-color);
    border-color: var(--brown-color);
    color: white;
    font-size: 0.875rem;
}

.btn-brown:hover {
    background-color: var(--brown-dark);
    border-color: var(--brown-dark);
    color: white;
}

.btn-outline-brown {
    color: var(--brown-color);
    border-color: var(--brown-color);
    background-color: white;
    font-size: 0.875rem;
}

.btn-outline-brown:hover {
    background-color: var(--brown-color);
    border-color: var(--brown-color);
    color: white;
}

.border-brown {
    border-color: var(--brown-color) !important;
}

.card {
    background-color: white;
    border: 1px solid #e3e6f0;
    border-radius: 0.5rem;
}

.card-header {
    background-color: #f8f9fa !important;
    border-bottom: 1px solid #e3e6f0;
    border-radius: 0.5rem 0.5rem 0 0 !important;
}

.card-body {
    background-color: white;
}

.table {
    background-color: white;
}

.table th {
    background-color: #f8f9fa;
    border-bottom: 1px solid #e3e6f0;
    font-weight: 600;
    font-size: 0.8rem;
    letter-spacing: 0.025em;
    color: #5a5c69;
}

.table td {
    vertical-align: middle;
    border-bottom: 1px solid #f1f3f4;
    font-size: 0.875rem;
    background-color: white;
}

.table-sm th,
.table-sm td {
    padding: 0.75rem;
}

.table-hover tbody tr:hover {
    background-color: rgba(139, 69, 19, 0.02) !important;
}

.shadow-sm {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
}

.rounded-2 {
    border-radius: 0.5rem !important;
}

.bg-opacity-10 {
    background-color: rgba(139, 69, 19, 0.1) !important;
}

.small {
    font-size: 0.875rem;
}

.form-control,
.form-select {
    background-color: white;
    border: 1px solid #d1d3e2;
    border-radius: 0.35rem;
}

.form-control:focus,
.form-select:focus {
    border-color: var(--brown-color);
    box-shadow: 0 0 0 0.2rem rgba(139, 69, 19, 0.25);
}

.form-control-sm,
.form-select-sm {
    padding: 0.25rem 0.75rem;
    font-size: 0.875rem;
    border-radius: 0.25rem;
}

.btn-sm {
    padding: 0.25rem 0.75rem;
    font-size: 0.875rem;
    border-radius: 0.25rem;
}

.border {
    border: 1px solid #e3e6f0 !important;
}

.border-bottom {
    border-bottom: 1px solid #e3e6f0 !important;
}

.border-top {
    border-top: 2px solid var(--brown-color) !important;
}

@media (max-width: 768px) {
    .container-fluid {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    .card-body {
        padding: 1rem !important;
    }
    
    .table-responsive {
        border: none;
    }
    
    .px-3 {
        padding-left: 0.75rem !important;
        padding-right: 0.75rem !important;
    }
    
    .d-flex.gap-2 {
        flex-direction: column;
        gap: 0.5rem !important;
    }
    
    .h5 {
        font-size: 1.125rem;
    }
}

.gap-2 {
    gap: 0.5rem;
}

.fw-medium {
    font-weight: 500;
}

.fw-semibold {
    font-weight: 600;
}

.text-muted {
    color: #5a5c69 !important;
}

.text-dark {
    color: #3a3b45 !important;
}

#date-start-wrapper,
#date-end-wrapper {
    transition: all 0.3s ease;
}
</style>

<!-- JavaScript for Dynamic Date Range and Filter -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const periodeSelect = document.getElementById('periode');
    const dateStartWrapper = document.getElementById('date-start-wrapper');
    const dateEndWrapper = document.getElementById('date-end-wrapper');
    const dateStart = document.getElementById('date_start');
    const dateEnd = document.getElementById('date_end');

    function toggleDateRange() {
        if (periodeSelect.value === 'custom') {
            dateStartWrapper.style.display = 'block';
            dateEndWrapper.style.display = 'block';
            dateStart.disabled = false;
            dateEnd.disabled = false;
            dateStart.required = true;
            dateEnd.required = true;
        } else {
            dateStartWrapper.style.display = 'none';
            dateEndWrapper.style.display = 'none';
            dateStart.disabled = true;
            dateEnd.disabled = true;
            dateStart.required = false;
            dateEnd.required = false;
        }
    }

    // Initialize on page load
    toggleDateRange();

    // Handle periode change
    periodeSelect.addEventListener('change', function() {
        toggleDateRange();
    });

    // Form validation for custom date range
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        if (periodeSelect.value === 'custom') {
            if (!dateStart.value || !dateEnd.value) {
                e.preventDefault();
                alert('Silakan pilih tanggal mulai dan tanggal akhir untuk custom date range.');
                return false;
            }
            
            if (new Date(dateStart.value) > new Date(dateEnd.value)) {
                e.preventDefault();
                alert('Tanggal mulai tidak boleh lebih besar dari tanggal akhir.');
                return false;
            }
        }
    });

    // Set max date to today
    const today = new Date().toISOString().split('T')[0];
    dateStart.max = today;
    dateEnd.max = today;
});
</script>
@endsection