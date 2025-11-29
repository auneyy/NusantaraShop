@extends('admin.layout.app')

@section('title', 'Dashboard Admin - NusantaraShop')

@section('page-title', 'Laporan Pendapatan')

@section('content')
<div class="container-fluid px-3">

    {{-- Pesan notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Search Section --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Pencarian Transaksi</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.laporan.pendapatan') }}" method="GET">
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <input type="text" class="form-control" name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Cari berdasarkan nomor order atau nama customer...">
                    </div>
                    <div class="col-md-2 mb-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                    <div class="col-md-2 mb-3">
                        <a href="{{ route('admin.laporan.pendapatan') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-times"></i> Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card border shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.laporan.pendapatan') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-2">
                        <label class="form-label">Periode</label>
                        <select class="form-select" name="periode" id="periode">
                            <option value="minggu_ini" {{ $periode == 'minggu_ini' ? 'selected' : '' }}>Minggu Ini</option>
                            <option value="bulan_ini" {{ $periode == 'bulan_ini' ? 'selected' : '' }}>Bulan Ini</option>
                            <option value="tahun_ini" {{ $periode == 'tahun_ini' ? 'selected' : '' }}>Tahun Ini</option>
                            <option value="custom" {{ $periode == 'custom' ? 'selected' : '' }}>Custom</option>
                        </select>
                    </div>
                    <div class="col-md-2" id="date-start-wrapper" style="{{ $periode != 'custom' ? 'display:none' : '' }}">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" name="start_date" 
                               value="{{ $startDate->format('Y-m-d') }}" {{ $periode == 'custom' ? 'required' : '' }}>
                    </div>
                    <div class="col-md-2" id="date-end-wrapper" style="{{ $periode != 'custom' ? 'display:none' : '' }}">
                        <label class="form-label">Tanggal Akhir</label>
                        <input type="date" class="form-control" name="end_date" 
                               value="{{ $endDate->format('Y-m-d') }}" {{ $periode == 'custom' ? 'required' : '' }}>
                    </div>

                    {{-- Filter Status Order --}}
                    <div class="col-md-2">
                        <label class="form-label">Status Order</label>
                        <select class="form-select" name="order_status">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('order_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ request('order_status') == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ request('order_status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ request('order_status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ request('order_status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    {{-- Filter Payment Method --}}
                    <div class="col-md-2">
                        <label class="form-label">Metode Bayar</label>
                        <select class="form-select" name="payment_method">
                            <option value="">Semua Metode</option>
                            <option value="bank_transfer" {{ request('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Transfer Bank</option>
                            <option value="cod" {{ request('payment_method') == 'cod' ? 'selected' : '' }}>COD</option>
                            <option value="ewallet" {{ request('payment_method') == 'ewallet' ? 'selected' : '' }}>E-Wallet</option>
                            <option value="midtrans" {{ request('payment_method') == 'midtrans' ? 'selected' : '' }}>Midtrans</option>
                        </select>
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-brown me-2 w-100">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Summary Cards (3 Cards Only - TANPA DISKON) -->
    <div class="row g-3 mb-4">
        <!-- Total Pendapatan Kotor Card -->
        <div class="col-xl-4 col-md-6">
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
                            <div class="small text-muted fw-medium mb-1">Pendapatan Kotor</div>
                            <div class="h5 mb-1 text-dark fw-semibold">Rp {{ number_format($totalPendapatanKotor, 0, ',', '.') }}</div>
                            <div class="small text-success">
                                <i class="fas fa-arrow-up me-1"></i>Produk + Ongkir
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pendapatan Bersih Card -->
        <div class="col-xl-4 col-md-6">
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
                            <div class="h5 mb-1 text-dark fw-semibold">Rp {{ number_format($totalPendapatanBersih, 0, ',', '.') }}</div>
                            <div class="small text-success">
                                <i class="fas fa-arrow-up me-1"></i>Hanya dari Produk
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jumlah Order Card -->
        <div class="col-xl-4 col-md-6">
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
                            <div class="h5 mb-1 text-dark fw-semibold">{{ $jumlahOrder }}</div>
                            <div class="small text-success">
                                <i class="fas fa-arrow-up me-1"></i>Real-time
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Breakdown (TANPA INFO DISKON) -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border shadow-sm">
                <div class="card-header bg-light border-bottom py-3">
                    <h6 class="mb-0 fw-semibold text-dark">
                        <i class="fas fa-chart-pie me-2 text-brown"></i>
                        Detail Breakdown Pendapatan
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td class="border-0 ps-0"><strong>Pendapatan dari Produk:</strong></td>
                                    <td class="border-0 text-end text-success fw-semibold">Rp {{ number_format($totalPendapatanProduk, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td class="border-0 ps-0"><strong>Pendapatan dari Ongkir:</strong></td>
                                    <td class="border-0 text-end">Rp {{ number_format($totalShipping, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td class="border-0 ps-0"><strong>Total Pendapatan Kotor:</strong></td>
                                    <td class="border-0 text-end text-info fw-semibold">Rp {{ number_format($totalPendapatanKotor, 0, ',', '.') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td class="border-0 ps-0"><strong>Pendapatan Bersih (Tanpa Ongkir):</strong></td>
                                    <td class="border-0 text-end text-success fw-semibold">Rp {{ number_format($totalPendapatanBersih, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td class="border-0 ps-0"><strong>Rata-rata per Order:</strong></td>
                                    <td class="border-0 text-end">Rp {{ number_format($rataRataOrder, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td class="border-0 ps-0"><strong>Total Transaksi:</strong></td>
                                    <td class="border-0 text-end fw-semibold">{{ $jumlahOrder }} order</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Rincian (TANPA KOLOM DISKON) -->
    <div class="card border shadow-sm">
        <div class="card-header bg-light border-bottom py-3">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <svg class="me-2 text-brown" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h2a2 2 0 002-2z"></path>
                    </svg>
                    <span class="fw-semibold text-dark">Rincian Penjualan 
                        ({{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }})</span>
                </div>
                <div class="text-muted small">
                    {{ $orders->total() }} transaksi ditemukan
                </div>
            </div>
        </div>
        <div class="card-body p-0 bg-white">
            <div class="table-responsive">
                <table class="table table-hover table-sm mb-0">
                    <thead class="bg-light border-bottom">
                        <tr>
                            <th class="px-3 py-3 text-muted fw-semibold small border-0">Tanggal</th>
                            <th class="px-3 py-3 text-muted fw-semibold small text-center border-0">Order ID</th>
                            <th class="px-3 py-3 text-muted fw-semibold small border-0">Customer</th>
                            <th class="px-3 py-3 text-muted fw-semibold small text-end border-0">Subtotal Produk</th>
                            <th class="px-3 py-3 text-muted fw-semibold small text-end border-0">Biaya Kirim</th>
                            <th class="px-3 py-3 text-muted fw-semibold small text-end border-0">Total</th>
                            <th class="px-3 py-3 text-muted fw-semibold small text-center border-0">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @forelse($orders as $order)
                        @php
                            $orderSubtotal = $order->orderItems->sum('subtotal');
                        @endphp
                        <tr class="border-bottom">
                            <td class="px-3 py-3 fw-medium small">{{ $order->order_date->format('d M Y') }}</td>
                            <td class="px-3 py-3 text-center small">
                                <span class="badge bg-light text-dark">{{ $order->order_number }}</span>
                            </td>
                            <td class="px-3 py-3 small">
                                <div>{{ $order->user->name ?? 'Guest' }}</div>
                                <small class="text-muted">{{ $order->orderItems->count() }} item(s)</small>
                            </td>
                            <td class="px-3 py-3 text-end small">
                                Rp {{ number_format($orderSubtotal, 0, ',', '.') }}
                            </td>
                            <td class="px-3 py-3 text-end small">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</td>
                            <td class="px-3 py-3 text-end fw-semibold text-success small">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
                            <td class="px-3 py-3 text-center small">
                                <span class="badge bg-success">{{ $order->payment_status_label }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                Tidak ada data transaksi untuk periode yang dipilih.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    @if($orders->count() > 0)
                    <tfoot>
                        <tr class="bg-light border-top border-brown">
                            <td class="px-3 py-3 fw-bold text-dark small">TOTAL</td>
                            <td class="px-3 py-3 text-center fw-bold text-dark small">{{ $orders->count() }}</td>
                            <td class="px-3 py-3 fw-bold text-dark small">-</td>
                            <td class="px-3 py-3 text-end fw-bold text-dark small">
                                Rp {{ number_format($totalPendapatanProduk, 0, ',', '.') }}
                            </td>
                            <td class="px-3 py-3 text-end fw-bold text-dark small">
                                Rp {{ number_format($totalShipping, 0, ',', '.') }}
                            </td>
                            <td class="px-3 py-3 text-end fw-bold text-success">
                                Rp {{ number_format($totalPendapatanKotor, 0, ',', '.') }}
                            </td>
                            <td class="px-3 py-3 text-center fw-bold text-dark small">-</td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>

            {{-- Pagination --}}
            @if($orders->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4 p-3">
                <div class="text-muted">
                    Menampilkan {{ $orders->firstItem() }} - {{ $orders->lastItem() }} dari {{ $orders->total() }} transaksi
                </div>
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm mb-0">
                        {{-- Previous Page Link --}}
                        @if ($orders->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">‹</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $orders->previousPageUrl() }}" rel="prev">‹</a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @php
                            $elements = $orders->links()->elements;
                            $currentPage = $orders->currentPage();
                            $lastPage = $orders->lastPage();
                            
                            $start = max(1, $currentPage - 2);
                            $end = min($lastPage, $currentPage + 2);
                            
                            if ($currentPage <= 3) {
                                $end = min(5, $lastPage);
                            }
                            
                            if ($currentPage >= $lastPage - 2) {
                                $start = max(1, $lastPage - 4);
                            }
                        @endphp

                        {{-- First Page Link --}}
                        @if ($start > 1)
                            <li class="page-item">
                                <a class="page-link" href="{{ $orders->url(1) }}">1</a>
                            </li>
                            @if ($start > 2)
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            @endif
                        @endif

                        {{-- Page Numbers --}}
                        @for ($page = $start; $page <= $end; $page++)
                            @if ($page == $currentPage)
                                <li class="page-item active" aria-current="page">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $orders->url($page) }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endfor

                        {{-- Last Page Link --}}
                        @if ($end < $lastPage)
                            @if ($end < $lastPage - 1)
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            @endif
                            <li class="page-item">
                                <a class="page-link" href="{{ $orders->url($lastPage) }}">{{ $lastPage }}</a>
                            </li>
                        @endif

                        {{-- Next Page Link --}}
                        @if ($orders->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $orders->nextPageUrl() }}" rel="next">›</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">›</span>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- JavaScript untuk toggle date range -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const periodeSelect = document.getElementById('periode');
    const dateStartWrapper = document.getElementById('date-start-wrapper');
    const dateEndWrapper = document.getElementById('date-end-wrapper');

    function toggleDateRange() {
        if (periodeSelect.value === 'custom') {
            dateStartWrapper.style.display = 'block';
            dateEndWrapper.style.display = 'block';
        } else {
            dateStartWrapper.style.display = 'none';
            dateEndWrapper.style.display = 'none';
        }
    }

    // Initialize
    toggleDateRange();
    
    // Handle change
    periodeSelect.addEventListener('change', toggleDateRange);
});
</script>

<style>
.pagination {
    margin-bottom: 0;
}

.page-item .page-link {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    color: #6c757d;
    border: 1px solid #dee2e6;
}

.page-item.active .page-link {
    background-color: #4e73df;
    border-color: #4e73df;
    color: white;
}

.page-item:not(.active) .page-link:hover {
    background-color: #e9ecef;
    color: #2e59d9;
}

.page-item.disabled .page-link {
    color: #6c757d;
    background-color: #f8f9fa;
}

.badge {
    font-size: 0.75em;
}

.table-responsive {
    border-radius: 0.35rem;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
}
</style>
@endsection