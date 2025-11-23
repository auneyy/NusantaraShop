@extends('admin.layout.app')

@section('page-title', 'Manajemen Kategori')

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
            <h6 class="m-0 font-weight-bold text-primary">Pencarian Kategori</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.categories.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <input type="text" class="form-control" name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Cari berdasarkan nama kategori atau slug...">
                    </div>
                    <div class="col-md-2 mb-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                    <div class="col-md-2 mb-3">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary w-100">
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
            <h6 class="m-0 font-weight-bold text-primary">Filter Kategori</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.categories.index') }}" method="GET">
                <div class="row">
                    {{-- Filter Status --}}
                    <div class="col-md-3 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Semua Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="col-md-3 mb-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-outline-primary w-100 me-2">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-refresh"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

        {{-- Header dengan Tombol Tambah --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Kategori
        </a>
    </div>
    
    {{-- Categories Table --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Kategori</h6>
            <span class="badge bg-primary">Total: {{ $categories->total() }} kategori</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Slug</th>
                            <th>Jumlah Produk</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->slug }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $category->products_count }} produk</span>
                                </td>
                                <td>
                                    <span class="badge {{ $category->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $category->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada kategori ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination SAMA PERSIS --}}
            @if($categories->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Menampilkan {{ $categories->firstItem() }} - {{ $categories->lastItem() }} dari {{ $categories->total() }} kategori
                </div>
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm mb-0">
                        {{-- Previous Page Link --}}
                        @if ($categories->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">‹</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $categories->previousPageUrl() }}" rel="prev">‹</a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @php
                            $elements = $categories->links()->elements;
                            $currentPage = $categories->currentPage();
                            $lastPage = $categories->lastPage();
                            
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
                                <a class="page-link" href="{{ $categories->url(1) }}">1</a>
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
                                    <a class="page-link" href="{{ $categories->url($page) }}">{{ $page }}</a>
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
                                <a class="page-link" href="{{ $categories->url($lastPage) }}">{{ $lastPage }}</a>
                            </li>
                        @endif

                        {{-- Next Page Link --}}
                        @if ($categories->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $categories->nextPageUrl() }}" rel="next">›</a>
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
</style>
@endsection