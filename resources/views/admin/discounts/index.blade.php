@extends('admin.layout.app')

@section('page-title', 'Manajemen Diskon')

@section('content')
<div class="container-fluid">

    {{-- Pesan notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Search Section --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Pencarian Diskon</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.discounts.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <input type="text" class="form-control" name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Cari berdasarkan judul, subjudul, atau nama produk...">
                    </div>
                    <div class="col-md-2 mb-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                    <div class="col-md-2 mb-3">
                        <a href="{{ route('admin.discounts.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-times"></i> Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Filter Section --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Diskon</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.discounts.index') }}" method="GET">
                <div class="row">
                    {{-- Filter Status --}}
                    <div class="col-md-2 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Semua Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="upcoming" {{ request('status') == 'upcoming' ? 'selected' : '' }}>Akan Datang</option>
                            <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Kadaluarsa</option>
                        </select>
                    </div>

                    {{-- Filter Percentage Range --}}
                    <div class="col-md-2 mb-3">
                        <label for="min_percentage" class="form-label">Persentase Min</label>
                        <input type="number" class="form-control" id="min_percentage" name="min_percentage" 
                               value="{{ request('min_percentage') }}" placeholder="0" min="1" max="100">
                    </div>

                    <div class="col-md-2 mb-3">
                        <label for="max_percentage" class="form-label">Persentase Max</label>
                        <input type="number" class="form-control" id="max_percentage" name="max_percentage" 
                               value="{{ request('max_percentage') }}" placeholder="100" min="1" max="100">
                    </div>

                    {{-- Filter Date Range --}}
                    <div class="col-md-2 mb-3">
                        <label for="start_date_filter" class="form-label">Mulai Dari</label>
                        <input type="date" class="form-control" id="start_date_filter" name="start_date_filter" 
                               value="{{ request('start_date_filter') }}">
                    </div>

                    <div class="col-md-2 mb-3">
                        <label for="end_date_filter" class="form-label">Sampai Dengan</label>
                        <input type="date" class="form-control" id="end_date_filter" name="end_date_filter" 
                               value="{{ request('end_date_filter') }}">
                    </div>

                    {{-- Action Buttons --}}
                    <div class="col-md-2 mb-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-outline-primary w-100 me-2">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        <a href="{{ route('admin.discounts.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-refresh"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Header dengan Tombol Tambah --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('admin.discounts.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Diskon
        </a>
    </div>

    {{-- Discounts Table --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Diskon</h6>
            <span class="badge bg-primary">Total: {{ $discounts->total() }} diskon</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Banner</th>
                            <th>Judul</th>
                            <th>Subjudul</th>
                            <th>Persentase</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Berakhir</th>
                            <th>Status</th>
                            <th>Countdown</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($discounts as $discount)
                            <tr data-discount-id="{{ $discount->id }}" 
                                data-end-date="{{ $discount->end_date_iso }}"
                                data-start-date="{{ $discount->start_date_iso }}">
                                <td>{{ $loop->iteration + ($discounts->currentPage() - 1) * $discounts->perPage() }}</td>
                                <td>
                                    @if($discount->banner_image)
                                        <img src="{{ $discount->banner_image }}" alt="Banner" style="max-width: 100px; max-height: 60px;" class="img-thumbnail">
                                    @else
                                        <span class="text-muted">Tidak ada gambar</span>
                                    @endif
                                </td>
                                <td>{{ $discount->title }}</td>
                                <td>{{ $discount->subtitle ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ $discount->percentage }}%</span>
                                </td>
                                <td>{{ $discount->formatted_start_date }}</td>
                                <td>{{ $discount->formatted_end_date }}</td>
                                <td>
                                    @php
                                        $status = $discount->status;
                                        $statusClass = match($status) {
                                            'active' => 'bg-success',
                                            'upcoming' => 'bg-warning',
                                            'expired' => 'bg-secondary',
                                            default => 'bg-secondary'
                                        };
                                        $statusText = match($status) {
                                            'active' => 'Aktif',
                                            'upcoming' => 'Akan Datang',
                                            'expired' => 'Kadaluarsa',
                                            default => 'Unknown'
                                        };
                                    @endphp
                                    <span class="badge {{ $statusClass }} status-badge">
                                        {{ $statusText }}
                                    </span>
                                </td>
                                <td class="countdown-cell">
                                    @if($discount->is_valid)
                                        <small class="text-muted countdown-text">
                                            <i class="fas fa-clock"></i>
                                            <span class="time-remaining">Calculating...</span>
                                        </small>
                                    @elseif($discount->status === 'upcoming')
                                        <small class="text-warning">
                                            <i class="fas fa-calendar-alt"></i> Belum dimulai
                                        </small>
                                    @else
                                        <small class="text-muted">-</small>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.discounts.show', $discount->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                    <a href="{{ route('admin.discounts.edit', $discount->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.discounts.destroy', $discount->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus diskon ini?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">Tidak ada data diskon</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination SAMA PERSIS --}}
            @if($discounts->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Menampilkan {{ $discounts->firstItem() }} - {{ $discounts->lastItem() }} dari {{ $discounts->total() }} diskon
                </div>
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm mb-0">
                        {{-- Previous Page Link --}}
                        @if ($discounts->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">‹</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $discounts->previousPageUrl() }}" rel="prev">‹</a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @php
                            $elements = $discounts->links()->elements;
                            $currentPage = $discounts->currentPage();
                            $lastPage = $discounts->lastPage();
                            
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
                                <a class="page-link" href="{{ $discounts->url(1) }}">1</a>
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
                                    <a class="page-link" href="{{ $discounts->url($page) }}">{{ $page }}</a>
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
                                <a class="page-link" href="{{ $discounts->url($lastPage) }}">{{ $lastPage }}</a>
                            </li>
                        @endif

                        {{-- Next Page Link --}}
                        @if ($discounts->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $discounts->nextPageUrl() }}" rel="next">›</a>
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
    margin: 0.1rem;
}

.countdown-cell {
    min-width: 120px;
}

.time-remaining {
    font-weight: 600;
    color: #4a5568;
}

.status-badge {
    min-width: 80px;
    display: inline-block;
    text-align: center;
}
</style>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const rows = document.querySelectorAll('tr[data-discount-id]');
    
    rows.forEach(row => {
        const endDate = new Date(row.dataset.endDate).getTime();
        const startDate = new Date(row.dataset.startDate).getTime();
        const statusBadge = row.querySelector('.status-badge');
        const countdownCell = row.querySelector('.countdown-cell');
        const timeRemaining = countdownCell.querySelector('.time-remaining');
        
        function updateStatus() {
            const now = new Date().getTime();
            
            // Cek status
            let status, statusClass, statusText;
            
            if (now < startDate) {
                status = 'upcoming';
                statusClass = 'bg-warning';
                statusText = 'Akan Datang';
                countdownCell.innerHTML = '<small class="text-warning"><i class="fas fa-calendar-alt"></i> Belum dimulai</small>';
            } else if (now >= startDate && now <= endDate) {
                status = 'active';
                statusClass = 'bg-success';
                statusText = 'Aktif';
                
                // Hitung countdown
                const distance = endDate - now;
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                
                let timeText = '';
                if (days > 0) {
                    timeText = `${days}h ${hours}j ${minutes}m`;
                } else if (hours > 0) {
                    timeText = `${hours}j ${minutes}m ${seconds}d`;
                } else if (minutes > 0) {
                    timeText = `${minutes}m ${seconds}d`;
                } else {
                    timeText = `${seconds}d`;
                }
                
                if (timeRemaining) {
                    timeRemaining.textContent = timeText;
                }
            } else {
                status = 'expired';
                statusClass = 'bg-secondary';
                statusText = 'Kadaluarsa';
                countdownCell.innerHTML = '<small class="text-muted">-</small>';
            }
            
            // Update badge
            statusBadge.className = `badge ${statusClass} status-badge`;
            statusBadge.textContent = statusText;
        }
        
        // Update immediately
        updateStatus();
        
        // Update every second
        setInterval(updateStatus, 1000);
    });
});
</script>
@endpush