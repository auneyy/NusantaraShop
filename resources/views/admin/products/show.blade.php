@extends('admin.layout.app')

@section('page-title', 'Detail Produk')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-4">
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">{{ $product->name }}</h6>
            <div>
                @php
                    $statusClass = [
                        'tersedia' => 'success',
                        'habis' => 'danger',
                        'pre-order' => 'info'
                    ];
                @endphp
                <span class="badge badge-{{ $statusClass[$product->status] }}">
                    {{ ucfirst(str_replace('-', ' ', $product->status)) }}
                </span>
                
                @if($product->is_featured)
                <span class="badge badge-warning ml-1">Produk Unggulan</span>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-5">
                    <div class="product-gallery">
                        @if($product->images->count() > 0)
                        <div class="row">
                            @foreach($product->images as $image)
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                  <img src="{{ $image->thumbnail_url ?? $image->image_path }}" 
     class="card-img-top" 
     style="height: 200px; object-fit: cover;"
     onerror="this.src='{{ $image->image_path }}'">
                                    <div class="card-body text-center">
                                        @if($image->is_primary)
                                        <span class="badge badge-success">Gambar Utama</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="alert alert-warning">Tidak ada gambar produk</div>
                        @endif
                    </div>
                </div>
                <div class="col-md-7">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">SKU</th>
                            <td>{{ $product->sku }}</td>
                        </tr>
                        <tr>
                            <th>Slug</th>
                            <td>{{ $product->slug }}</td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td>{{ $product->category->name }}</td>
                        </tr>
                        <tr>
                            <th>Harga</th>
                            <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Stok</th>
                            <td>{{ $product->stock_kuantitas }}</td>
                        </tr>
                        <tr>
                            <th>Berat</th>
                            <td>{{ $product->berat ?? '-' }} gram</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                <h5>Deskripsi Produk</h5>
                <div class="border p-3">
                    {!! $product->deskripsi !!}
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>
    </div>
</div>
@endsection