@extends('admin.layout.app')

@section('page-title', 'Manajemen Pesanan')

@section('content')
<div class="container-fluid">

    {{-- Pesan notifikasi ditempatkan di luar card --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow mb-4">
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
                                        @else
                                            bg-danger
                                        @endif">
                                        {{ $order->payment_status_label }}
                                    </span>
                                </td>
                                <td>
                                    <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Diproses</option>
                                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Dikirim</option>
                                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Diterima</option>
                                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                        </select>
                                    </form>
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
        </div>
    </div>
</div>
@endsection