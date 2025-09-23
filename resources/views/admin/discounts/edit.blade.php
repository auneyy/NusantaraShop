@extends('admin.layout.app')

@section('page-title', 'Edit Diskon')

@section('content')
<div class="container-fluid">
      <div class="d-flex justify-content-between mb-4">
        <a href="{{ route('admin.discounts.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                
                <div class="card-body">
                    <form action="{{ route('admin.discounts.update', $discount->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="title">Title *</label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $discount->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="subtitle">Subtitle</label>
                            <input type="text" name="subtitle" id="subtitle" class="form-control @error('subtitle') is-invalid @enderror" value="{{ old('subtitle', $discount->subtitle) }}">
                            @error('subtitle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="percentage">Percentage *</label>
                            <input type="number" name="percentage" id="percentage" class="form-control @error('percentage') is-invalid @enderror" value="{{ old('percentage', $discount->percentage) }}" min="1" max="100" required>
                            @error('percentage')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start_date">Tanggal Mulai *</label>
                                    <input type="datetime-local" name="start_date" id="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date', $discount->start_date->format('Y-m-d\TH:i')) }}" required>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="end_date">Tanggal Berakhir *</label>
                                    <input type="datetime-local" name="end_date" id="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date', $discount->end_date->format('Y-m-d\TH:i')) }}" required>
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="banner_image">Banner Image</label>
                            <div class="custom-file">
                                <input type="file" name="banner_image" id="banner_image" class="custom-file-input @error('banner_image') is-invalid @enderror">
                                <label class="custom-file-label" for="banner_image">Choose file</label>
                                @error('banner_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            @if($discount->banner_image)
                                <div class="mt-2">
                                    <img src="{{ $discount->banner_image }}" alt="Current banner" class="img-thumbnail" style="max-height: 150px;">
                                    <p class="text-muted small mt-1">Current banner image</p>
                                </div>
                            @endif
                        </div>

                        <div class="mt-2 mb-4 form-group">
                            <label for="products">Pilih Produk *</label>
                            <select name="products[]" id="products" class="form-control select2 @error('products') is-invalid @enderror" multiple="multiple" required>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ in_array($product->id, old('products', $discount->products->pluck('id')->toArray())) ? 'selected' : '' }}>
                                        {{ $product->name }} - {{ $product->formatted_harga }}
                                    </option>
                                @endforeach
                            </select>
                            @error('products')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                         <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize Select2
        $('#products').select2({
            allowClear: true
        });

        // Show file name in file input
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
    });
</script>
@endpush