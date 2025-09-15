@extends('admin.layout.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Produk Baru</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="name">Nama Produk *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi Produk *</label>
                                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="5" required>{{ old('deskripsi') }}</textarea>
                                    @error('deskripsi')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="sku">SKU *</label>
                                    <input type="text" class="form-control @error('sku') is-invalid @enderror" id="sku" name="sku" value="{{ old('sku') }}" required>
                                    @error('sku')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="category_id">Kategori *</label>
                                    <div class="input-group">
                                        <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                            <option value="">Pilih Kategori</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
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
                                    <label for="harga">Harga (Rp) *</label>
                                    <input type="number" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" value="{{ old('harga') }}" min="0" step="100" required>
                                    @error('harga')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="stock_kuantitas">Stok *</label>
                                    <input type="number" class="form-control @error('stock_kuantitas') is-invalid @enderror" id="stock_kuantitas" name="stock_kuantitas" value="{{ old('stock_kuantitas') }}" min="0" required>
                                    @error('stock_kuantitas')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="berat">Berat (gram)</label>
                                    <input type="number" class="form-control @error('berat') is-invalid @enderror" id="berat" name="berat" value="{{ old('berat') }}" min="0">
                                    @error('berat')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="status">Status *</label>
                                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                        <option value="habis" {{ old('status') == 'habis' ? 'selected' : '' }}>Habis</option>
                                        <option value="pre-order" {{ old('status') == 'pre-order' ? 'selected' : '' }}>Pre-Order</option>
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_featured">Produk Unggulan</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Gambar Produk *</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('images') is-invalid @enderror" id="images" name="images[]" multiple required>
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
                                    <label>Pratinjau Gambar</label>
                                    <div class="row" id="image-preview-container">
                                        <div class="col-12">
                                            <p class="text-muted">Pratinjau gambar akan muncul setelah Anda memilih file</p>
                                        </div>
                                    </div>
                                    <input type="hidden" id="primary_image" name="primary_image" value="0">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan Produk</button>
                        </div>
                    </form>
                </div>
            </div>
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
                    <div class="form-group">
                        <label for="category_slug">Slug (Opsional)</label>
                        <input type="text" class="form-control" id="category_slug" name="slug">
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
            let container = $('#image-preview-container');
            container.empty();
            $('#primary_image').val('');

            if (this.files && this.files.length > 0) {
                for (let i = 0; i < this.files.length; i++) {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        let col = $('<div>').addClass('col-md-3 col-sm-6 mb-3');
                        let img = $('<img>').attr('src', e.target.result).addClass('img-thumbnail');
                        
                        let radioDiv = $('<div>').addClass('custom-control custom-radio mt-2');
                        let radio = $('<input>').attr({
                            type: 'radio',
                            id: 'radio' + i,
                            name: 'primary_image_radio',
                            value: i
                        }).addClass('custom-control-input');
                        let label = $('<label>').addClass('custom-control-label').attr('for', 'radio' + i).text('Gambar Utama');

                        radioDiv.append(radio).append(label);
                        col.append(img).append(radioDiv);
                        container.append(col);

                        if (i === 0) {
                            radio.prop('checked', true);
                            $('#primary_image').val(0);
                        }

                        radio.on('change', function() {
                            $('#primary_image').val($(this).val());
                        });
                    };
                    reader.readAsDataURL(this.files[i]);
                }
            } else {
                container.append('<div class="col-12"><p class="text-muted">Pratinjau gambar akan muncul setelah Anda memilih file</p></div>');
            }
        });

        @if(old('images'))
        @endif
        
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