@extends('admin.layout.app')

@section('page-title', 'Manajemen Diskon')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Diskon</h1>
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
                <table class="table table-bordered table">
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
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($discounts as $discount)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if($discount->banner_image)
                                        {{-- Mengambil URL gambar langsung dari database --}}
                                        <img src="{{ $discount->banner_image }}" alt="Banner" style="max-width: 100px; max-height: 60px;">
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
                                    @if($discount->is_valid)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Tidak Aktif</span>
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
                                <td colspan="9" class="text-center">Tidak ada data diskon</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection