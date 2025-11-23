@extends('admin.layout.app')

@section('page-title', 'Pesan Masuk')

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
            <h6 class="m-0 font-weight-bold text-primary">Pencarian Pesan</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.messages.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <input type="text" class="form-control" name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Cari berdasarkan nama, email, subjek, atau isi pesan...">
                    </div>
                    <div class="col-md-2 mb-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                    <div class="col-md-2 mb-3">
                        <a href="{{ route('admin.messages.index') }}" class="btn btn-outline-secondary w-100">
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
            <h6 class="m-0 font-weight-bold text-primary">Filter Pesan</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.messages.index') }}" method="GET">
                <div class="row">
                    {{-- Filter Status --}}
                    <div class="col-md-3 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Semua Status</option>
                            <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>Belum Dibaca</option>
                            <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Sudah Dibaca</option>
                        </select>
                    </div>

                    {{-- Filter Tanggal --}}
                    <div class="col-md-3 mb-3">
                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" 
                               value="{{ request('start_date') }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="end_date" class="form-label">Tanggal Akhir</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" 
                               value="{{ request('end_date') }}">
                    </div>

                    {{-- Action Buttons --}}
                    <div class="col-md-3 mb-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-outline-primary w-100 me-2">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        <a href="{{ route('admin.messages.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-refresh"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Messages Table --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Pesan Masuk</h6>
            <div>
                @php
                    $unreadCount = \App\Models\Message::where('is_read', false)->count();
                @endphp
                @if($unreadCount > 0)
                    <span class="badge bg-danger">Pesan Baru: {{ $unreadCount }}</span>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Subjek</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($messages as $message)
                            <tr class="{{ $message->is_read ? '' : 'table-warning' }}">
                                <td>{{ $loop->iteration + ($messages->currentPage() - 1) * $messages->perPage() }}</td>
                                <td>
                                    <div class="fw-bold">{{ $message->name }}</div>
                                    @if(!$message->is_read)
                                        <span class="badge bg-danger badge-sm">Baru</span>
                                    @endif
                                </td>
                                <td>{{ $message->email }}</td>
                                <td>{{ $message->phone ?? '-' }}</td>
                                <td>
                                    <div class="text-truncate" style="max-width: 200px;" title="{{ $message->subject }}">
                                        {{ $message->subject }}
                                    </div>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $message->created_at->format('d M Y') }}<br>
                                        {{ $message->created_at->format('H:i') }}
                                    </small>
                                </td>
                                <td>
                                    @if($message->is_read)
                                        <span class="badge bg-success">Sudah Dibaca</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Belum Dibaca</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group-vertical btn-group-sm">
                                        <a href="{{ route('admin.messages.show', $message->id) }}" class="btn btn-info mb-1">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                        <div class="btn-group btn-group-sm">
                                            @if($message->is_read)
                                                <form action="{{ route('admin.messages.markAsUnread', $message->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-warning" title="Tandai sebagai belum dibaca">
                                                        <i class="fas fa-envelope"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.messages.markAsRead', $message->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-success" title="Tandai sebagai sudah dibaca">
                                                        <i class="fas fa-envelope-open"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pesan ini?')" title="Hapus pesan">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada pesan masuk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination SAMA PERSIS --}}
            @if($messages->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Menampilkan {{ $messages->firstItem() }} - {{ $messages->lastItem() }} dari {{ $messages->total() }} pesan
                </div>
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm mb-0">
                        {{-- Previous Page Link --}}
                        @if ($messages->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">‹</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $messages->previousPageUrl() }}" rel="prev">‹</a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @php
                            $elements = $messages->links()->elements;
                            $currentPage = $messages->currentPage();
                            $lastPage = $messages->lastPage();
                            
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
                                <a class="page-link" href="{{ $messages->url(1) }}">1</a>
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
                                    <a class="page-link" href="{{ $messages->url($page) }}">{{ $page }}</a>
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
                                <a class="page-link" href="{{ $messages->url($lastPage) }}">{{ $lastPage }}</a>
                            </li>
                        @endif

                        {{-- Next Page Link --}}
                        @if ($messages->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $messages->nextPageUrl() }}" rel="next">›</a>
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
}

.badge-sm {
    font-size: 0.65em;
    padding: 0.2rem 0.4rem;
}

.table-warning {
    background-color: rgba(255, 193, 7, 0.1);
}
</style>
@endsection