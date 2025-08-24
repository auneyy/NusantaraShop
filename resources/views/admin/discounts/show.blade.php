@extends('admin.layout.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-4">
        <h1 class="h3">Detail Diskon</h1>
        <a href="{{ route('admin.discounts.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">{{ $discount->title }}</h6>
            <div>
                <span class="badge badge-{{ $discount->is_active ? 'success' : 'secondary' }}">
                    {{ $discount->is_active ? 'Aktif' : 'Nonaktif' }}
                </span>
                @if($discount->is_valid)
                <span class="badge badge-success ml-1">Berlaku</span>
                @else
                <span class="badge badge-secondary ml-1">Kadaluarsa</span>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Subjudul</th>
                            <td>{{ $discount->subtitle ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Tipe Diskon</th>
                            <td>{{ ucfirst($discount->type) }}</td>
                        </tr>
                        <tr>
                            <th>Nilai Diskon</th>
                            <td>
                                @if($discount->type == 'percentage')
                                    {{ $discount->percentage }}%
                                @else
                                    Rp {{ number_format($discount->fixed_amount, 0, ',', '.') }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Periode</th>
                            <td>
                                {{ $discount->start_date->format('d M Y') }} - 
                                {{ $discount->end_date->format('d M Y') }}
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <div class="p-3 rounded" style="background-color: {{ $discount->banner_color }}; color: {{ $discount->text_color }};">
                        <h4 class="text-center">{{ $discount->title }}</h4>
                        @if($discount->subtitle)
                        <p class="text-center mb-0">{{ $discount->subtitle }}</p>
                        @endif
                        <div class="text-center mt-2">
                            @if($discount->type == 'percentage')
                            <span class="badge badge-light" style="font-size: 1.2rem;">
                                {{ $discount->percentage }}% OFF
                            </span>
                            @else
                            <span class="badge badge-light" style="font-size: 1.2rem;">
                                Rp {{ number_format($discount->fixed_amount, 0, ',', '.') }} OFF
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.discounts.edit', $discount->id) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>
    </div>
</div>
@endsection