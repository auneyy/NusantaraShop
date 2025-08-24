@extends('admin.layout.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-4">
        <h1 class="h3">Edit Diskon</h1>
        <a href="{{ route('admin.discounts.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.discounts.update', $discount->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title">Judul Diskon *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $discount->title) }}" required>
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="subtitle">Subjudul</label>
                            <input type="text" class="form-control @error('subtitle') is-invalid @enderror" id="subtitle" name="subtitle" value="{{ old('subtitle', $discount->subtitle) }}">
                            @error('subtitle')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="type">Tipe Diskon *</label>
                            <select class="form-control @error('type') is-invalid @enderror" id="type" name="type" required>
                                <option value="">Pilih Tipe</option>
                                <option value="percentage" {{ old('type', $discount->type) == 'percentage' ? 'selected' : '' }}>Persentase</option>
                                <option value="fixed" {{ old('type', $discount->type) == 'fixed' ? 'selected' : '' }}>Nominal Tetap</option>
                            </select>
                            @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group" id="percentage-field" style="display: {{ old('type', $discount->type) == 'percentage' ? 'block' : 'none' }};">
                            <label for="percentage">Persentase Diskon (%) *</label>
                            <input type="number" class="form-control @error('percentage') is-invalid @enderror" id="percentage" name="percentage" value="{{ old('percentage', $discount->percentage) }}" min="1" max="100">
                            @error('percentage')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group" id="fixed-amount-field" style="display: {{ old('type', $discount->type) == 'fixed' ? 'block' : 'none' }};">
                            <label for="fixed_amount">Nominal Diskon (Rp) *</label>
                            <input type="number" class="form-control @error('fixed_amount') is-invalid @enderror" id="fixed_amount" name="fixed_amount" value="{{ old('fixed_amount', $discount->fixed_amount) }}" min="0">
                            @error('fixed_amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="start_date">Tanggal Mulai *</label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date', $discount->start_date->format('Y-m-d')) }}" required>
                            @error('start_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="end_date">Tanggal Berakhir *</label>
                            <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date', $discount->end_date->format('Y-m-d')) }}" required>
                            @error('end_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="banner_color">Warna Banner *</label>
                            <input type="color" class="form-control @error('banner_color') is-invalid @enderror" id="banner_color" name="banner_color" value="{{ old('banner_color', $discount->banner_color) }}" required>
                            @error('banner_color')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="text_color">Warna Teks *</label>
                            <input type="color" class="form-control @error('text_color') is-invalid @enderror" id="text_color" name="text_color" value="{{ old('text_color', $discount->text_color) }}" required>
                            @error('text_color')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
    <label for="banner_image">Gambar Banner</label>
    <input type="file" class="form-control @error('banner_image') is-invalid @enderror" id="banner_image" name="banner_image" accept="image/*">
    @error('banner_image')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
    <div class="mt-2">
        <img id="image-preview" src="{{ isset($discount) && $discount->banner_image ? asset('storage/'.$discount->banner_image) : '#' }}" 
             alt="Preview Gambar" style="max-height: 200px; display: {{ isset($discount) && $discount->banner_image ? 'block' : 'none' }};">
    </div>
</div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', $discount->is_active) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">Aktif</label>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update Diskon</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Toggle antara percentage dan fixed amount
        $('#type').change(function() {
            toggleDiscountFields();
        });

        // Jalankan saat pertama kali load
        toggleDiscountFields();

        function toggleDiscountFields() {
            const type = $('#type').val();
            
            if (type === 'percentage') {
                $('#percentage-field').show();
                $('#fixed-amount-field').hide();
                $('#percentage').prop('required', true);
                $('#fixed_amount').prop('required', false);
            } else if (type === 'fixed') {
                $('#percentage-field').hide();
                $('#fixed-amount-field').show();
                $('#fixed_amount').prop('required', true);
                $('#percentage').prop('required', false);
            } else {
                $('#percentage-field').hide();
                $('#fixed-amount-field').hide();
                $('#percentage').prop('required', false);
                $('#fixed_amount').prop('required', false);
            }
        }

        // Preview gambar
$('#banner_image').change(function() {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            $('#image-preview').attr('src', e.target.result).show();
        }
        reader.readAsDataURL(file);
    } else {
        $('#image-preview').hide();
    }
});

        // Format input nominal
        $('#fixed_amount').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });
</script>
@endpush