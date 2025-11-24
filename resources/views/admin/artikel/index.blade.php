@extends('admin.layout.app')

@section('page-title', 'Kelola Artikel Bantuan')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">Artikel Bantuan</h2>
                    <p class="text-muted mb-0">Kelola artikel dan panduan untuk pengguna</p>
                </div>
                <a href="{{ route('admin.artikel.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Artikel
                </a>
            </div>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Main Card -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0">Daftar Artikel</h5>
                </div>
                <div class="col-auto">
                    <span class="badge bg-light text-dark">
                        Total: {{ $articles->total() }} artikel
                    </span>
                </div>
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 modern-table">
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
                                <span class="text-muted fw-medium">{{ $articles->firstItem() + $index }}</span>
                            </td>
                            <td>
                                <div class="article-title-wrapper">
                                    <h6 class="article-title mb-1">
                                        {{ $article->title }}
                                        @if($article->is_featured)
                                        <i class="bi bi-star-fill text-warning ms-1" title="Featured"></i>
                                        @endif
                                    </h6>
                                    <p class="article-excerpt text-muted mb-0">
                                        {{ Str::limit(strip_tags($article->content), 60) }}
                                    </p>
                                </div>
                            </td>
                            <td class="text-center">
                                @if($article->category)
                                <span class="badge-category badge-{{ $article->category }}">
                                    {{ $article->category_name }}
                                </span>
                                @else
                                <span class="badge-category badge-uncategorized">
                                    Tanpa Kategori
                                </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="order-badge">{{ $article->order }}</span>
                            </td>
                            <td class="text-center">
                                @if($article->is_published)
                                <span class="status-badge status-active">
                                    <i class="bi bi-check-circle-fill"></i> Aktif
                                </span>
                                @else
                                <span class="status-badge status-inactive">
                                    <i class="bi bi-x-circle-fill"></i> Draft
                                </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="date-text">
                                    {{ $article->created_at->format('d M Y') }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="action-buttons">
                                    <a href="{{ route('admin.artikel.edit', $article) }}" 
                                       class="btn-action btn-action-edit" 
                                       title="Edit"
                                       data-bs-toggle="tooltip">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('admin.artikel.destroy', $article) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus artikel ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn-action btn-action-delete" 
                                                title="Hapus"
                                                data-bs-toggle="tooltip">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="bi bi-inbox"></i>
                                    <h5 class="mt-3">Belum ada artikel</h5>
                                    <p class="text-muted mb-3">Mulai dengan membuat artikel bantuan pertama Anda</p>
                                    <a href="{{ route('admin.artikel.create') }}" class="btn btn-primary">
                                        <i class="bi bi-plus-circle me-2"></i>Tambah Artikel
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($articles->hasPages())
        <div class="card-footer bg-white border-top py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    Menampilkan {{ $articles->firstItem() }} - {{ $articles->lastItem() }} 
                    dari {{ $articles->total() }} artikel
                </div>
                <div>
                    {{ $articles->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
/* Modern Table Styling */
.modern-table {
    font-size: 0.95rem;
}

.modern-table thead {
    background: linear-gradient(180deg, #f8f9fa 0%, #f1f3f5 100%);
}

.modern-table thead th {
    font-weight: 600;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #495057;
    padding: 1rem 0.75rem;
    border-bottom: 2px solid #dee2e6;
}

.modern-table tbody tr {
    transition: all 0.2s ease;
}

.modern-table tbody tr:hover {
    background-color: #f8f9fa;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.modern-table tbody td {
    padding: 1rem 0.75rem;
    vertical-align: middle;
    border-bottom: 1px solid #f1f3f5;
}

/* Article Title */
.article-title-wrapper {
    padding: 0.25rem 0;
}

.article-title {
    font-size: 0.95rem;
    font-weight: 600;
    color: #212529;
    margin-bottom: 0.25rem;
    line-height: 1.4;
}

.article-excerpt {
    font-size: 0.8rem;
    line-height: 1.4;
    color: #6c757d;
}

/* Category Badge */
.badge-category {
    display: inline-block;
    padding: 0.4rem 0.75rem;
    font-size: 0.75rem;
    font-weight: 500;
    border-radius: 6px;
    text-transform: capitalize;
}

.badge-getting-started {
    background-color: #e7f5ff;
    color: #1971c2;
}

.badge-account-billing {
    background-color: #fff3e0;
    color: #e65100;
}

.badge-troubleshooting {
    background-color: #fce4ec;
    color: #c2185b;
}

.badge-uncategorized {
    background-color: #f1f3f5;
    color: #868e96;
}

/* Order Badge */
.order-badge {
    display: inline-block;
    padding: 0.35rem 0.75rem;
    background-color: #f8f9fa;
    color: #495057;
    font-weight: 600;
    font-size: 0.85rem;
    border-radius: 6px;
    border: 1px solid #dee2e6;
}

/* Status Badge */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.4rem 0.75rem;
    font-size: 0.75rem;
    font-weight: 500;
    border-radius: 6px;
}

.status-active {
    background-color: #d3f9d8;
    color: #2b8a3e;
}

.status-inactive {
    background-color: #ffe3e3;
    color: #c92a2a;
}

.status-badge i {
    font-size: 0.85rem;
}

/* Date Text */
.date-text {
    font-size: 0.8rem;
    color: #6c757d;
    font-weight: 500;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 0.35rem;
    justify-content: center;
}

.btn-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border: none;
    border-radius: 6px;
    background: transparent;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 0.9rem;
}

.btn-action-edit {
    color: #f59f00;
    background-color: #fff9db;
}

.btn-action-edit a {
    text-decoration: none;
}


.btn-action-edit:hover {
    background-color: #f59f00;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(245, 159, 0, 0.3);
}

.btn-action-delete {
    color: #e03131;
    background-color: #ffe3e3;
}

.btn-action-delete:hover {
    background-color: #e03131;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(224, 49, 49, 0.3);
}

/* Empty State */
.empty-state {
    padding: 3rem 0;
}

.empty-state i {
    font-size: 4rem;
    color: #dee2e6;
}

.empty-state h5 {
    color: #495057;
    font-weight: 600;
    margin-top: 1rem;
}

.empty-state p {
    color: #868e96;
}

/* Card Styling */
.card {
    border-radius: 12px;
    overflow: hidden;
}

.card-header {
    border-radius: 12px 12px 0 0 !important;
}

/* Responsive */
@media (max-width: 768px) {
    .modern-table {
        font-size: 0.85rem;
    }
    
    .modern-table thead th {
        padding: 0.75rem 0.5rem;
        font-size: 0.75rem;
    }
    
    .modern-table tbody td {
        padding: 0.75rem 0.5rem;
    }
    
    .article-title {
        font-size: 0.85rem;
    }
    
    .article-excerpt {
        font-size: 0.75rem;
    }
}
</style>

@push('scripts')
<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endpush
@endsection