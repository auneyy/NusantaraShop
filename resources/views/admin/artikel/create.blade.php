@extends('admin.layout.app')

@section('page-title', 'Tambah Artikel Bantuan')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Tambah Artikel Baru</h2>
                <a href="{{ route('admin.artikel.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.artikel.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="title" class="form-label">Judul Artikel <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control @error('title') is-invalid @enderror" 
                           id="title" 
                           name="title" 
                           value="{{ old('title') }}"
                           placeholder="Masukkan judul artikel"
                           required>
                    @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="category" class="form-label">Kategori</label>
                    <select class="form-select @error('category') is-invalid @enderror" 
                            id="category" 
                            name="category">
                        <option value="">Pilih Kategori</option>
                        <option value="getting-started" {{ old('category') == 'getting-started' ? 'selected' : '' }}>
                            Memulai
                        </option>
                        <option value="account-billing" {{ old('category') == 'account-billing' ? 'selected' : '' }}>
                            Akun dan Pembayaran
                        </option>
                        <option value="troubleshooting" {{ old('category') == 'troubleshooting' ? 'selected' : '' }}>
                            Pemecahan Masalah
                        </option>
                    </select>
                    @error('category')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Konten Artikel <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('content') is-invalid @enderror" 
                              id="content" 
                              name="content" 
                              rows="10"
                              placeholder="Tulis konten artikel di sini..."
                              required>{{ old('content') }}</textarea>
                    @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Anda dapat menggunakan format HTML untuk styling</small>
                </div>

                <div class="mb-3">
                    <label for="order" class="form-label">Urutan Tampilan</label>
                    <input type="number" 
                           class="form-control @error('order') is-invalid @enderror" 
                           id="order" 
                           name="order" 
                           value="{{ old('order', 0) }}"
                           min="0"
                           placeholder="0">
                    @error('order')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Semakin kecil angka, semakin atas posisinya</small>
                </div>

                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" 
                               type="checkbox" 
                               id="is_featured" 
                               name="is_featured"
                               {{ old('is_featured') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_featured">
                            <i class="bi bi-star-fill text-warning me-1"></i>
                            Jadikan Artikel Featured
                        </label>
                    </div>
                    <small class="text-muted">Artikel featured akan ditampilkan di bagian atas halaman bantuan</small>
                </div>

                <div class="mb-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" 
                               type="checkbox" 
                               id="is_published" 
                               name="is_published"
                               {{ old('is_published', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_published">
                            Publikasikan Artikel
                        </label>
                    </div>
                    <small class="text-muted">Hanya artikel yang dipublikasikan yang akan tampil di halaman bantuan</small>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-2"></i>Simpan Artikel
                    </button>
                    <a href="{{ route('admin.artikel.index') }}" class="btn btn-outline-secondary">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.form-label {
    font-weight: 600;
    color: #422D1C;
}
.card {
    border: none;
}
</style>
@endsection