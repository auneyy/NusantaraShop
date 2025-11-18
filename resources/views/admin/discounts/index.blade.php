@extends('admin.layout.app')

@section('page-title', 'Manajemen Diskon')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('admin.discounts.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Diskon
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
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
                                data-end-date="{{ $discount->end_date->toIso8601String() }}"
                                data-start-date="{{ $discount->start_date->toIso8601String() }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if($discount->banner_image)
                                        <img src="{{ $discount->banner_image }}" alt="Banner" style="max-width: 100px; max-height: 60px;" class="img-thumbnail">
                                    @else
                                        <span class="text-muted">Tidak ada gambar</span>
                                    @endif
                                </td>
                                <td>{{ $discount->title }}</td>
                                <td>{{ $discount->subtitle ?? '-' }}</td>
                                <td>{{ $discount->percentage }}%</td>
                                <td>{{ $discount->start_date->format('d M Y H:i') }}</td>
                                <td>{{ $discount->end_date->format('d M Y H:i') }}</td>
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
                                            'active' => 'Active',
                                            'upcoming' => 'Upcoming',
                                            'expired' => 'Expired',
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
                                    <div class="btn-group">
                                        <a href="{{ route('admin.discounts.show', $discount->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.discounts.edit', $discount->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.discounts.destroy', $discount->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus diskon ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
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
        </div>
    </div>
</div>
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
                statusText = 'Upcoming';
                countdownCell.innerHTML = '<small class="text-warning"><i class="fas fa-calendar-alt"></i> Belum dimulai</small>';
            } else if (now >= startDate && now <= endDate) {
                status = 'active';
                statusClass = 'bg-success';
                statusText = 'Active';
                
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
                statusText = 'Expired';
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

@push('styles')
<style>
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
@endpush