@extends('admin.layout.app')

@section('page-title', 'Kelola Artikel Bantuan')

@section('content')
<div class="container-fluid">

    {{-- Pesan notifikasi --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- Header dengan Tombol Tambah --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('admin.artikel.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Artikel
        </a>
    </div>

    {{-- Main Card - Daftar Artikel --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Artikel</h6>
            <span class="badge bg-primary">Total: {{ $articles->total() }} artikel</span>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 5%;" class="text-center">No</th>
                            <th style="width: 40%;">Judul</th>
                            <th style="width: 15%;" class="text-center">Kategori</th>
                            <th style="width: 8%;" class="text-center">Urutan</th>
                            <th style="width: 12%;" class="text-center">Status</th>
                            <th style="width: 12%;" class="text-center">Tanggal</th>
                            <th style="width: 8%;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($articles as $index => $article)
                        <tr>
                            <td class="text-center">
                                {{ $articles->firstItem() + $index }}
                            </td>
                            <td>
                                <div class="article-title-wrapper">
                                    <div class="fw-bold mb-1">
                                        {{ $article->title }}
                                        @if($article->is_featured)
                                        <i class="fas fa-star text-warning ms-1" title="Featured" data-bs-toggle="tooltip"></i>
                                        @endif
                                    </div>
                                    <small class="text-muted article-excerpt">
                                        {{ Str::limit(strip_tags($article->content), 60) }}
                                    </small>
                                </div>
                            </td>
                            <td class="text-center">
                                @if($article->category)
                                    @php
                                        // Menyesuaikan badge color berdasarkan kategori (contoh, bisa disesuaikan lebih lanjut)
                                        $categoryClass = match($article->category) {
                                            'getting-started' => 'bg-info',
                                            'account-billing' => 'bg-warning text-dark',
                                            'troubleshooting' => 'bg-danger',
                                            default => 'bg-secondary',
                                        };
                                    @endphp
                                    <span class="badge {{ $categoryClass }}">
                                        {{ $article->category_name }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        Tanpa Kategori
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark border">{{ $article->order }}</span>
                            </td>
                            <td class="text-center">
                                @if($article->is_published)
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle"></i> Aktif
                                </span>
                                @else
                                <span class="badge bg-secondary">
                                    <i class="fas fa-times-circle"></i> Draft
                                </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <small class="text-muted">{{ $article->created_at->format('d M Y') }}</small>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('admin.artikel.edit', $article) }}" 
                                       class="btn btn-sm btn-primary me-1" 
                                       title="Edit"
                                       data-bs-toggle="tooltip">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.artikel.destroy', $article) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus artikel ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-danger" 
                                                title="Hapus"
                                                data-bs-toggle="tooltip">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-inbox fa-4x text-muted"></i>
                                    <h5 class="mt-3">Belum ada artikel</h5>
                                    <p class="text-muted mb-3">Mulai dengan membuat artikel bantuan pertama Anda</p>
                                    <a href="{{ route('admin.artikel.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Tambah Artikel
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination SAMA PERSIS dengan Order/Produk --}}
        @if($articles->hasPages())
        <div class="card-footer bg-white border-top py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    Menampilkan {{ $articles->firstItem() }} - {{ $articles->lastItem() }} 
                    dari {{ $articles->total() }} artikel
                </div>
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm mb-0">
                        {{-- Previous Page Link --}}
                        @if ($articles->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">‹</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $articles->previousPageUrl() }}" rel="prev">‹</a>
                            </li>
                        @endif

                        {{-- Pagination Elements (logic disederhanakan, atau bisa menggunakan yang kompleks seperti contoh Produk) --}}
                        @php
                            $currentPage = $articles->currentPage();
                            $lastPage = $articles->lastPage();
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
                                <a class="page-link" href="{{ $articles->url(1) }}">1</a>
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
                                    <a class="page-link" href="{{ $articles->url($page) }}">{{ $page }}</a>
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
                                <a class="page-link" href="{{ $articles->url($lastPage) }}">{{ $lastPage }}</a>
                            </li>
                        @endif

                        {{-- Next Page Link --}}
                        @if ($articles->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $articles->nextPageUrl() }}" rel="next">›</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">›</span>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
/* Styling Tambahan untuk Meniru Tampilan Produk */
.card-header.py-3 {
    padding-top: 0.75rem !important;
    padding-bottom: 0.75rem !important;
}

.table-bordered {
    border-color: #e3e6f0 !important;
}

.table th, .table td {
    padding: 0.75rem; /* Menyesuaikan padding tabel */
    border-top: 1px solid #e3e6f0;
}

.table-hover tbody tr:hover {
    color: #6e707e;
    background-color: rgba(0, 0, 0, 0.075);
}

.badge {
    font-size: 0.75em;
    padding: 0.35em 0.65em;
}

.empty-state i {
    color: #d1d3e2 !important; /* Warna ikon AdminLTE */
}

/* Pagination Styling dari contoh Produk */
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

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
    margin: 0.1rem;
}

</style>

@push('scripts')
<script>
    // Initialize tooltips (membutuhkan Bootstrap JS)
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endpush
@endsection