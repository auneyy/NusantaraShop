@extends('admin.layout.app')

@section('page-title', 'Manajemen Produk')

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
            <h6 class="m-0 font-weight-bold text-primary">Pencarian Produk</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.products.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <input type="text" class="form-control" name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Cari berdasarkan nama produk, SKU, deskripsi, atau kategori...">
                    </div>
                    <div class="col-md-2 mb-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                    <div class="col-md-2 mb-3">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary w-100">
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
            <h6 class="m-0 font-weight-bold text-primary">Filter Produk</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.products.index') }}" method="GET">
                <div class="row">
                    {{-- Filter Kategori --}}
                    <div class="col-md-3 mb-3">
                        <label for="category_id" class="form-label">Kategori</label>
                        <select class="form-select" id="category_id" name="category_id">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Filter Status --}}
                    <div class="col-md-2 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Semua Status</option>
                            <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="habis" {{ request('status') == 'habis' ? 'selected' : '' }}>Habis</option>
                            <option value="pre-order" {{ request('status') == 'pre-order' ? 'selected' : '' }}>Pre-Order</option>
                        </select>
                    </div>

                    {{-- Filter Stok --}}
                    <div class="col-md-2 mb-3">
                        <label for="stock_status" class="form-label">Status Stok</label>
                        <select class="form-select" id="stock_status" name="stock_status">
                            <option value="">Semua Stok</option>
                            <option value="available" {{ request('stock_status') == 'available' ? 'selected' : '' }}>Tersedia</option>
                            <option value="low" {{ request('stock_status') == 'low' ? 'selected' : '' }}>Stok Menipis</option>
                            <option value="out" {{ request('stock_status') == 'out' ? 'selected' : '' }}>Stok Habis</option>
                        </select>
                    </div>

                    {{-- Filter Featured --}}
                    <div class="col-md-2 mb-3">
                        <label for="is_featured" class="form-label">Featured</label>
                        <select class="form-select" id="is_featured" name="is_featured">
                            <option value="">Semua</option>
                            <option value="1" {{ request('is_featured') == '1' ? 'selected' : '' }}>Featured</option>
                            <option value="0" {{ request('is_featured') == '0' ? 'selected' : '' }}>Non-Featured</option>
                        </select>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="col-md-3 mb-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-outline-primary w-100 me-2">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-refresh"></i>
                        </a>
                    </div>
                </div>

                {{-- Price Range Filter --}}
                <div class="row mt-3">
                    <div class="col-md-3 mb-3">
                        <label for="min_price" class="form-label">Harga Minimum</label>
                        <input type="number" class="form-control" id="min_price" name="min_price" 
                               value="{{ request('min_price') }}" placeholder="0" min="0">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="max_price" class="form-label">Harga Maksimum</label>
                        <input type="number" class="form-control" id="max_price" name="max_price" 
                               value="{{ request('max_price') }}" placeholder="1000000" min="0">
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Header dengan Tombol Tambah --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Produk
        </a>
    </div>

    {{-- Products Table --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Produk</h6>
            <span class="badge bg-primary">Total: {{ $products->total() }} produk</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Featured</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td>{{ $loop->iteration + ($products->currentPage() - 1) * $products->perPage() }}</td>
                            <td>
                                @php
                                    $primaryImage = $product->images->where('is_primary', true)->first();
                                @endphp

                                @if($primaryImage)
                                    <img src="{{ $primaryImage->thumbnail_url ?? $primaryImage->image_path }}"
                                        alt="{{ $product->name }}" width="50" class="img-thumbnail">
                                @else
                                    <span class="text-muted">No image</span>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold">{{ $product->name }}</div>
                                <small class="text-muted">SKU: {{ $product->sku }}</small>
                            </td>
                            <td>{{ $product->category->name }}</td>
                            <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                            <td>
                                @php
                                    $statusClass = 'bg-info';
                                    if ($product->status == 'tersedia') {
                                        $statusClass = 'bg-success';
                                    } elseif ($product->status == 'habis') {
                                        $statusClass = 'bg-secondary';
                                    } elseif ($product->status == 'pre-order') {
                                        $statusClass = 'bg-warning text-dark';
                                    }
                                @endphp
                                <span class="badge {{ $statusClass }}">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </td>
                            <td>
                                @if($product->is_featured)
                                    <span class="badge bg-success"><i class="fas fa-star"></i></span>
                                @else
                                    <span class="badge bg-secondary"><i class="far fa-star"></i></span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">Tidak ada produk yang ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination SAMA PERSIS dengan Order --}}
            @if($products->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Menampilkan {{ $products->firstItem() }} - {{ $products->lastItem() }} dari {{ $products->total() }} produk
                </div>
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm mb-0">
                        {{-- Previous Page Link --}}
                        @if ($products->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">‹</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $products->previousPageUrl() }}" rel="prev">‹</a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @php
                            // Mendapatkan elements dari pagination
                            $elements = $products->links()->elements;
                            $currentPage = $products->currentPage();
                            $lastPage = $products->lastPage();
                            
                            // Tentukan halaman yang akan ditampilkan
                            $start = max(1, $currentPage - 2);
                            $end = min($lastPage, $currentPage + 2);
                            
                            // Adjust jika di awal
                            if ($currentPage <= 3) {
                                $end = min(5, $lastPage);
                            }
                            
                            // Adjust jika di akhir
                            if ($currentPage >= $lastPage - 2) {
                                $start = max(1, $lastPage - 4);
                            }
                        @endphp

                        {{-- First Page Link --}}
                        @if ($start > 1)
                            <li class="page-item">
                                <a class="page-link" href="{{ $products->url(1) }}">1</a>
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
                                    <a class="page-link" href="{{ $products->url($page) }}">{{ $page }}</a>
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
                                <a class="page-link" href="{{ $products->url($lastPage) }}">{{ $lastPage }}</a>
                            </li>
                        @endif

                        {{-- Next Page Link --}}
                        @if ($products->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $products->nextPageUrl() }}" rel="next">›</a>
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