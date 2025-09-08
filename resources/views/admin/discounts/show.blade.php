@extends('admin.layout.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detail Discount</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.discounts.edit', $discount->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">ID</th>
                                    <td>{{ $discount->id }}</td>
                                </tr>
                                <tr>
                                    <th>Title</th>
                                    <td>{{ $discount->title }}</td>
                                </tr>
                                <tr>
                                    <th>Subtitle</th>
                                    <td>{{ $discount->subtitle ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Percentage</th>
                                    <td>{{ $discount->percentage }}%</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Mulai</th>
                                    <td>{{ $discount->start_date->format('d M Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Berakhir</th>
                                    <td>{{ $discount->end_date->format('d M Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if($discount->is_valid)
                                            <span class="badge badge-success">Aktif</span>
                                        @else
                                            <span class="badge badge-secondary">Tidak Aktif</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            @if($discount->banner_image)
                                <div class="text-center">
                                    <img src="{{ $discount->banner_image }}" alt="Banner" class="img-fluid rounded" style="max-height: 300px;">
                                    <p class="text-muted mt-2">Banner Image</p>
                                </div>
                            @else
                                <p class="text-muted text-center">No banner image</p>
                            @endif
                        </div>
                    </div>

                    <div class="mt-4">
                        <h4>Produk Terkait</h4>
                        @if($discount->products->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nama</th>
                                            <th>Harga</th>
                                            <th>Harga Jual</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($discount->products as $product)
                                            <tr>
                                                <td>{{ $product->id }}</td>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->formatted_harga }}</td>
                                                <td>{{ $product->formatted_harga_jual ?? '-' }}</td>
                                                <td>
                                                    <span class="badge badge-{{ $product->status == 'active' ? 'success' : 'secondary' }}">
                                                        {{ $product->status }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">Tidak ada produk yang terkait dengan discount ini.</p>
                        @endif
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.discounts.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection