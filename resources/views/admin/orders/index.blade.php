@extends('admin.layout.app')

@section('page-title', 'Manajemen Pesanan')

@section('content')
<div class="container-fluid">

    {{-- Pesan notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Search Section --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Pencarian Pesanan</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.orders.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <input type="text" class="form-control" name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Cari berdasarkan nomor order / nama customer...">
                    </div>
                    <div class="col-md-2 mb-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                    <div class="col-md-2 mb-3">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-times"></i> Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Filter Section --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Pesanan</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.orders.index') }}" method="GET">
                <div class="row">
                    {{-- Status Filter --}}
                    <div class="col-md-3 mb-3">
                        <label for="status" class="form-label">Status Pesanan</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Diproses</option>
                            <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Dikirim</option>
                            <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Diterima</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>

               {{-- Payment Status Filter --}}
<div class="col-md-3 mb-3">
    <label for="payment_status" class="form-label">Status Pembayaran</label>
    <select class="form-select" id="payment_status" name="payment_status">
        <option value="">Semua Status</option>
        <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Menunggu Pembayaran</option>
        <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Sudah Dibayar</option>
        <option value="settlement" {{ request('payment_status') == 'settlement' ? 'selected' : '' }}>Pembayaran Berhasil</option>
        <option value="challenge" {{ request('payment_status') == 'challenge' ? 'selected' : '' }}>Dalam Review</option>
        <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Gagal</option>
        <option value="deny" {{ request('payment_status') == 'deny' ? 'selected' : '' }}>Ditolak</option>
        <option value="cancel" {{ request('payment_status') == 'cancel' ? 'selected' : '' }}>Dibatalkan</option>
        <option value="expire" {{ request('payment_status') == 'expire' ? 'selected' : '' }}>Kadaluarsa</option>
    </select>
</div>
                    {{-- Date Range --}}
                    <div class="col-md-2 mb-3">
                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" 
                               value="{{ request('start_date') }}">
                    </div>

                    <div class="col-md-2 mb-3">
                        <label for="end_date" class="form-label">Tanggal Akhir</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" 
                               value="{{ request('end_date') }}">
                    </div>

                    {{-- Action Buttons --}}
                    <div class="col-md-2 mb-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-outline-primary w-100 me-2">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-refresh"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Orders Table --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Pesanan</h6>
            <span class="badge bg-primary">Total: {{ $orders->total() }} pesanan</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Order Number</th>
                            <th>Nama Customer</th>
                            <th>Tanggal Order</th>
                            <th>Total</th>
                            <th>Status Pembayaran</th>
                            <th>Status Pesanan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>{{ $order->order_number }}</td>
                                <td>{{ $order->shipping_name }}</td>
                                <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y H:i') }}</td>
                                <td>Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge 
                                        @if(in_array($order->payment_status, ['paid', 'settlement', 'capture']))
                                            bg-success
                                        @elseif(in_array($order->payment_status, ['pending', 'challenge']))
                                            bg-warning text-dark
                                        @elseif(in_array($order->payment_status, ['cancelled', 'expire']))
                                            bg-secondary
                                        @else
                                            bg-danger
                                        @endif">
                                        {{ $order->payment_status_label }}
                                    </span>
                                </td>
                                <td>
                                    @if($order->status === 'cancelled')
                                        <span class="badge bg-danger">Dibatalkan</span>
                                    @else
                                        <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Diproses</option>
                                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Dikirim</option>
                                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Diterima</option>
                                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Batalkan</option>
                                            </select>
                                        </form>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada pesanan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($orders->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Menampilkan {{ $orders->firstItem() }} - {{ $orders->lastItem() }} dari {{ $orders->total() }} pesanan
                </div>
                <div>
                    {{ $orders->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.page-item.active .page-link {
    background-color: #4e73df;
    border-color: #4e73df;
}

.page-link {
    color: #4e73df;
}

.page-link:hover {
    color: #2e59d9;
}

.badge {
    font-size: 0.75em;
}
</style>
@endsection