@extends('admin.layout.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-4">
        <h1 class="h3">Daftar Diskon</h1>
        <a href="{{ route('admin.discounts.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Diskon
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Judul</th>
                            <th>Tipe</th>
                            <th>Diskon</th>
                            <th>Periode</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($discounts as $discount)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $discount->title }}</td>
                            <td>{{ ucfirst($discount->type) }}</td>
                            <td>
                                @if($discount->type == 'percentage')
                                    {{ $discount->percentage }}%
                                @else
                                    Rp {{ number_format($discount->fixed_amount, 0, ',', '.') }}
                                @endif
                            </td>
                            <td>
                                {{ $discount->start_date->format('d M Y') }} - 
                                {{ $discount->end_date->format('d M Y') }}
                            </td>
                            <td>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input toggle-status" 
                                           id="status_{{ $discount->id }}" data-id="{{ $discount->id }}"
                                           {{ $discount->is_active ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="status_{{ $discount->id }}">
                                        {{ $discount->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </label>
                                </div>
                                @if($discount->is_valid)
                                <span class="badge badge-success">Berlaku</span>
                                @else
                                <span class="badge badge-secondary">Kadaluarsa</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.discounts.show', $discount->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.discounts.edit', $discount->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.discounts.destroy', $discount->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus diskon ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                {{ $discounts->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize Toastr
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000"
        };

        // Toggle Status Diskon
        $('.toggle-status').change(function() {
            const discountId = $(this).data('id');
            const isActive = $(this).is(':checked');
            
            $.ajax({
                url: '/admin/discounts/' + discountId + '/toggle-status',
                type: 'PATCH',
                data: {
                    _token: '{{ csrf_token() }}',
                    is_active: isActive ? 1 : 0
                },
                success: function(response) {
                    toastr.success(response.message);
                    // Update label status
                    const label = $('label[for="status_' + discountId + '"]');
                    label.text(isActive ? 'Aktif' : 'Nonaktif');
                    
                    // Update badge status
                    const badge = label.siblings('.badge');
                    if (response.data.is_valid) {
                        badge.removeClass('badge-secondary').addClass('badge-success').text('Berlaku');
                    } else {
                        badge.removeClass('badge-success').addClass('badge-secondary').text('Kadaluarsa');
                    }
                },
                error: function(xhr) {
                    toastr.error('Terjadi kesalahan saat mengubah status');
                    // Kembalikan toggle ke state sebelumnya
                    $(this).prop('checked', !isActive);
                }
            });
        });
    });
</script>
@endpush