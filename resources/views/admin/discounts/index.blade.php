@extends('admin.layout.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Discount</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.discounts.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Discount
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Banner</th>
                                <th>Title</th>
                                <th>Subtitle</th>
                                <th>Percentage</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Berakhir</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($discounts as $discount)
                                <tr>
                                    <td>{{ $discount->id }}</td>
                                    <td>
                                        @if($discount->banner_image)
                                            <img src="{{ $discount->banner_image }}" alt="Banner" style="max-width: 100px; max-height: 60px;">
                                        @else
                                            <span class="text-muted">No image</span>
                                        @endif
                                    </td>
                                    <td>{{ $discount->title }}</td>
                                    <td>{{ $discount->subtitle ?? '-' }}</td>
                                    <td>{{ $discount->percentage }}%</td>
                                    <td>{{ $discount->start_date->format('d M Y H:i') }}</td>
                                    <td>{{ $discount->end_date->format('d M Y H:i') }}</td>
                                    <td>
                                        @if($discount->is_valid)
                                            <span class="badge badge-success">Aktif</span>
                                        @else
                                            <span class="badge badge-secondary">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.discounts.show', $discount->id) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.discounts.edit', $discount->id) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.discounts.destroy', $discount->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus discount ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">Tidak ada data discount</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{ $discounts->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection