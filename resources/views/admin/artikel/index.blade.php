@extends('admin.layout.app')

@section('page-title', 'Kelola Artikel Bantuan')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Artikel Bantuan</h2>
                <a href="{{ route('admin.artikel.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Artikel
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="30%">Judul</th>
                            <th width="15%">Kategori</th>
                            <th width="10%">Urutan</th>
                            <th width="10%">Featured</th>
                            <th width="10%">Status</th>
                            <th width="10%">Tanggal</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($articles as $index => $article)
                        <tr>
                            <td>{{ $articles->firstItem() + $index }}</td>
                            <td>
                                <strong>{{ $article->title }}</strong>
                                <br>
                                <small class="text-muted">{{ Str::limit($article->content, 60) }}</small>
                            </td>
                            <td>
                                @if($article->category)
                                <span class="badge bg-info">{{ $article->category_name }}</span>
                                @else
                                <span class="badge bg-secondary">Belum dikategorikan</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $article->order }}</span>
                            </td>
                            <td>
                                @if($article->is_featured)
                                <span class="badge bg-warning">
                                    <i class="bi bi-star-fill"></i> Featured
                                </span>
                                @else
                                <span class="badge bg-light text-dark">-</span>
                                @endif
                            </td>
                            <td>
                                @if($article->is_published)
                                <span class="badge bg-success">Aktif</span>
                                @else
                                <span class="badge bg-danger">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>{{ $article->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.artikel.edit', $article) }}" 
                                       class="btn btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.artikel.destroy', $article) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus artikel ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                                <p class="mt-3 mb-0 text-muted">Belum ada artikel</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $articles->links() }}
            </div>
        </div>
    </div>
</div>
@endsection