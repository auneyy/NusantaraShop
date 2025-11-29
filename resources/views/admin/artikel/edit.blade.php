@extends('admin.layout.app')

@section('page-title', 'Edit Artikel Bantuan')

@push('styles')
<!-- Summernote CSS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('admin.artikel.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.artikel.update', $artikel) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="title" class="form-label">Judul Artikel <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control @error('title') is-invalid @enderror" 
                           id="title" 
                           name="title" 
                           value="{{ old('title', $artikel->title) }}"
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
                        <option value="getting-started" {{ old('category', $artikel->category) == 'getting-started' ? 'selected' : '' }}>
                            Memulai
                        </option>
                        <option value="account-billing" {{ old('category', $artikel->category) == 'account-billing' ? 'selected' : '' }}>
                            Akun dan Pembayaran
                        </option>
                        <option value="troubleshooting" {{ old('category', $artikel->category) == 'troubleshooting' ? 'selected' : '' }}>
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
                              required>{{ old('content', $artikel->content) }}</textarea>
                    @error('content')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Gunakan toolbar di atas untuk memformat teks artikel Anda</small>
                </div>

                <div class="mb-3">
                    <label for="order" class="form-label">Urutan Tampilan</label>
                    <input type="number" 
                           class="form-control @error('order') is-invalid @enderror" 
                           id="order" 
                           name="order" 
                           value="{{ old('order', $artikel->order) }}"
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
                               value="1"
                               {{ old('is_featured', $artikel->is_featured) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_featured">
                            <i class="fas fa-star text-warning me-1"></i>
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
                               value="1"
                               {{ old('is_published', $artikel->is_published) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_published">
                            Publikasikan Artikel
                        </label>
                    </div>
                    <small class="text-muted">Hanya artikel yang dipublikasikan yang akan tampil di halaman bantuan</small>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Artikel
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
    border-radius: 12px;
}

/* Custom Summernote Styling */
.note-editor {
    border: 1px solid #dee2e6 !important;
    border-radius: 8px !important;
}

.note-toolbar {
    background-color: #f8f9fa !important;
    border-bottom: 1px solid #dee2e6 !important;
    padding: 10px !important;
}

.note-editing-area {
    background: #fff;
}

.note-editable {
    background: #fff;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    font-size: 14px;
    line-height: 1.6;
}

.note-btn {
    background: white !important;
    border: 1px solid #dee2e6 !important;
}

.note-btn:hover {
    background: #f8f9fa !important;
}
</style>
@endsection

@push('scripts')
<!-- Summernote JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

<script>
$(document).ready(function() {
    $('#content').summernote({
        height: 400,
        minHeight: 300,
        maxHeight: 600,
        placeholder: 'Tulis konten artikel di sini...',
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ],
        fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Helvetica', 'Impact', 'Tahoma', 'Times New Roman', 'Verdana', 'Inter'],
        fontNamesIgnoreCheck: ['Inter'],
        fontSizes: ['8', '10', '12', '14', '16', '18', '20', '24', '28', '32', '36'],
        lang: 'id-ID',
        dialogsInBody: true,
        callbacks: {
            onInit: function() {
                console.log('Summernote initialized successfully');
            },
            onImageUpload: function(files) {
                // Handle image upload
                for (let i = 0; i < files.length; i++) {
                    uploadImage(files[i]);
                }
            }
        }
    });

    // Optional: Image upload handler
    function uploadImage(file) {
        let data = new FormData();
        data.append("file", file);
        
        // You can implement your own image upload endpoint here
        // For now, we'll use base64 encoding
        let reader = new FileReader();
        reader.onloadend = function() {
            $('#content').summernote('insertImage', reader.result);
        }
        reader.readAsDataURL(file);
    }

    // Form validation before submit
    $('form').on('submit', function(e) {
        let content = $('#content').summernote('code');
        if (!content || content.trim() === '' || content === '<p><br></p>') {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Konten Kosong',
                text: 'Silakan isi konten artikel terlebih dahulu',
                confirmButtonColor: '#422D1C'
            });
            return false;
        }
    });
});
</script>
@endpush