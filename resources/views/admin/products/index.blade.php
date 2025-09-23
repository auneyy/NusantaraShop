@extends('admin.layout.app')

@section('page-title', 'Manajemen Produk')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-4">
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Produk
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                {{-- Mengganti 'hover' dengan 'table-hover' --}}
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
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
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                            <td>{{ $product->stock_kuantitas }}</td>
                            <td>
                                {{-- Mengganti 'text-bg-*' dengan 'bg-*' --}}
                                @php
                                    $statusClass = 'bg-info'; // Default
                                    if ($product->status == 'tersedia') {
                                        $statusClass = 'bg-success';
                                    } elseif ($product->status == 'habis') {
                                        $statusClass = 'bg-secondary';
                                    }
                                @endphp
                                <span class="badge {{ $statusClass }}">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection