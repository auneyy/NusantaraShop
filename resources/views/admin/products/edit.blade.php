@extends('admin.layout.app')

@section('page-title', 'Edit Produk')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Kembali
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
            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="name">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $product->name) }}" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="deskripsi">Deskripsi Produk <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="5" required>{{ old('deskripsi', $product->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="sku">SKU <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('sku') is-invalid @enderror" id="sku" name="sku" value="{{ old('sku', $product->sku) }}" required>
                            @error('sku')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="category_id">Kategori <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCategoryModal"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                            @error('category_id')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="harga">Harga (Rp) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" value="{{ old('harga', $product->harga) }}" min="0" step="100" required>
                            @error('harga')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="stock_kuantitas">Stok <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('stock_kuantitas') is-invalid @enderror" id="stock_kuantitas" name="stock_kuantitas" value="{{ old('stock_kuantitas', $product->stock_kuantitas) }}" min="0" required>
                            @error('stock_kuantitas')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="berat">Berat (gram)</label>
                            <input type="number" class="form-control @error('berat') is-invalid @enderror" id="berat" name="berat" value="{{ old('berat', $product->berat) }}" min="0">
                            @error('berat')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="status">Status <span class="text-danger">*</span></label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="tersedia" {{ old('status', $product->status) == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="habis" {{ old('status', $product->status) == 'habis' ? 'selected' : '' }}>Habis</option>
                                <option value="pre-order" {{ old('status', $product->status) == 'pre-order' ? 'selected' : '' }}>Pre-Order</option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_featured">Produk Unggulan</label>
                            </div>
                        </div>

                        <h5 class="mb-3">Manajemen Gambar Produk</h5>

                        <div class="form-group">
                            <label>Gambar Saat Ini</label>
                            <div class="row" id="existing-images-container">
                                @forelse($product->images as $image)
                                    <div class="col-md-3 col-sm-6 mb-3 image-item" id="image-{{ $image->id }}">
                                        <img src="{{ $image->image_path }}" class="img-thumbnail mb-2" style="height: 100px; width: auto;">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="primary-radio-{{ $image->id }}" name="primary_image" value="{{ $image->id }}" class="custom-control-input" {{ $image->is_primary ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="primary-radio-{{ $image->id }}">Utama</label>
                                        </div>
                                        <div class="custom-control custom-checkbox mt-1">
                                            <input type="checkbox" id="delete-check-{{ $image->id }}" name="delete_images[]" value="{{ $image->id }}" class="custom-control-input delete-image-checkbox">
                                            <label class="custom-control-label" for="delete-check-{{ $image->id }}">Hapus</label>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12"><p class="text-muted">Tidak ada gambar yang terunggah.</p></div>
                                @endforelse
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Tambah Gambar Baru</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('images') is-invalid @enderror" id="images" name="images[]" multiple>
                                <label class="custom-file-label" for="images">Pilih gambar (bisa lebih dari satu)</label>
                            </div>
                            <small class="form-text text-muted">Format: JPEG, PNG, JPG, GIF, WEBP. Maksimal 2MB per gambar.</small>
                            @error('images')
                                <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                            @error('images.*')
                                <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Pratinjau Gambar Baru</label>
                            <div class="row" id="new-image-preview-container">
                                <div class="col-12">
                                    <p class="text-muted">Pratinjau gambar baru akan muncul di sini</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                </div>

            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Tambah Kategori Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="quick-add-category">
                    @csrf
                    <div class="form-group">
                        <label for="category_name">Nama Kategori</label>
                        <input type="text" class="form-control" id="category_name" name="name" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="save-category">Simpan</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#images').on('change', function() {
            let container = $('#new-image-preview-container');
            container.empty();
            let newFiles = this.files;
            
            if (newFiles && newFiles.length > 0) {
                container.find('p.text-muted').remove();

                for (let i = 0; i < newFiles.length; i++) {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        let col = $('<div>').addClass('col-md-3 col-sm-6 mb-3');
                        let img = $('<img>').attr('src', e.target.result).addClass('img-thumbnail');
                        
                        let radioDiv = $('<div>').addClass('custom-control custom-radio mt-2');
                        let radio = $('<input>').attr({
                            type: 'radio',
                            id: 'new-radio-' + i,
                            name: 'primary_image',
                            value: 'new-' + i
                        }).addClass('custom-control-input');
                        let label = $('<label>').addClass('custom-control-label').attr('for', 'new-radio-' + i).text('Gambar Utama');

                        radioDiv.append(radio).append(label);
                        col.append(img).append(radioDiv);
                        container.append(col);

                        if ($('input[name="primary_image"]:checked').length === 0) {
                            radio.prop('checked', true);
                        }
                    };
                    reader.readAsDataURL(newFiles[i]);
                }
            } else {
                container.append('<div class="col-12"><p class="text-muted">Pratinjau gambar baru akan muncul di sini</p></div>');
            }
        });

        $('#save-category').click(function() {
            let form = $('#quick-add-category');
            let name = $('#category_name').val();
            if (!name) {
                alert('Nama kategori wajib diisi');
                return;
            }
            $.ajax({
                url: '{{ route("admin.products.quickStoreCategory") }}',
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    if (response.success) {
                        $('#category_id').append($('<option>', {
                            value: response.category.id,
                            text: response.category.name,
                            selected: true
                        }));
                        form.trigger('reset');
                        $('#addCategoryModal').modal('hide');
                        alert('Kategori berhasil ditambahkan');
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorMsg = '';
                    for (let field in errors) {
                        errorMsg += errors[field][0] + '\n';
                    }
                    alert(errorMsg || 'Terjadi kesalahan saat menambahkan kategori');
                }
            });
        });
        
        $('#category_name').on('blur', function() {
            let name = $(this).val();
            if (name && !$('#category_slug').val()) {
                $('#category_slug').val(name.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, ''));
            }
        });
    });
</script>
@endpush