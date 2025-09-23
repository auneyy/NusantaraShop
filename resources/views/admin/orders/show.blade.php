@extends('admin.layout.app')

@section('page-title', 'Detail Pesanan')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-4">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h4 class="m-0 font-weight-bold">Detail Pesanan #{{ $order->order_number }}</h4>
            <div>
                <span class="badge 
                    @if(in_array($order->payment_status, ['paid', 'settlement', 'capture']))
                        badge-success
                    @elseif(in_array($order->payment_status, ['pending', 'challenge']))
                        badge-warning
                    @else
                        badge-danger
                    @endif">
                    {{ ucfirst($order->payment_status) }}
                </span>
                <span class="badge 
                    @if($order->status == 'delivered') badge-success
                    @elseif($order->status == 'processing') badge-primary
                    @elseif($order->status == 'shipped') badge-info
                    @elseif($order->status == 'pending') badge-warning
                    @else badge-danger
                    @endif">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Info Pesanan</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">Order Number</th>
                                    <td>{{ $order->order_number }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Order</th>
                                    <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Metode Pembayaran</th>
                                    <td>{{ $order->payment_method_label }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Data Customer</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">Nama</th>
                                    <td>{{ $order->shipping_name }}</td>
                                </tr>
                                <tr>
                                    <th>Telepon</th>
                                    <td>{{ $order->shipping_phone }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $order->shipping_email }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>{{ $order->shipping_address }}, {{ $order->shipping_city }}, {{ $order->shipping_postal_code }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0">Produk yang Dibeli</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Size</th>
                                    <th>Qty</th>
                                    <th>Harga</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                    <tr>
                                        <td>{{ $item->product_name }}</td>
                                        <td>{{ $item->size }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>Rp {{ number_format($item->product_price, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Ringkasan Biaya</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="60%">Total Produk</th>
                                    <td class="text-end">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Ongkos Kirim</th>
                                    <td class="text-end">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</td>
                                </tr>
                                <tr class="fw-bold">
                                    <th>Total</th>
                                    <td class="text-end">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                @if($order->notes)
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Catatan Customer</h6>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">{{ $order->notes }}</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection