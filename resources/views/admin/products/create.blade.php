@extends('admin.layout.app')

@section('page-title', 'Tambah Produk')

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
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="name">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="deskripsi">Deskripsi Produk <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="5" required>{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="sku">SKU <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('sku') is-invalid @enderror" id="sku" name="sku" value="{{ old('sku') }}" required>
                            @error('sku')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="category_id">Kategori <span class="text-danger">*</span></label>
                            <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="harga">Harga (Rp) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" value="{{ old('harga') }}" min="0" step="100" required>
                            @error('harga')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="stock_kuantitas">Stok <span class="text-danger">*</span></label>
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
                            <label for="status">Status <span class="text-danger">*</span></label>
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

                        <div class="form-group">
                            <label>Gambar Produk <span class="text-danger">*</span></label>
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

                <div class="form-group mt-4 text-center">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan Produk</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Image Preview Logic
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
    });
</script>
@endpush