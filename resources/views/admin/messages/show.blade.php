@extends('admin.layout.app')

@section('title', 'Dashboard Admin - NusantaraShop')
@section('page-title', 'Detail Pesan')

@section('content')
<div class="container-fluid">

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary text-white">
            <h5 class="card-title mb-0">Subjek: {{ $message->subject }}</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <p class="mb-0"><strong>Nama:</strong> {{ $message->name }}</p>
                </div>
                <div class="col-md-6">
                    <p class="mb-0"><strong>Email:</strong> {{ $message->email }}</p>
                </div>
                <div class="col-md-6">
                    <p class="mb-0"><strong>Telepon:</strong> {{ $message->phone ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <p class="mb-0">
                        <strong>Status:</strong> 
                        @if($message->is_read)
                            <span class="badge bg-success">Sudah Dibaca</span>
                        @else
                            <span class="badge bg-warning text-dark">Belum Dibaca</span>
                        @endif
                    </p>
                </div>
            </div>

            <hr class="my-4">
            
            <p><strong>Isi Pesan:</strong></p>
            <div class="border p-3 rounded bg-light">
                <p class="mb-0">{{ $message->message }}</p>
            </div>
            <p class="text-muted small mt-2">Diterima pada: {{ $message->created_at->format('d M Y, H:i') }}</p>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <a href="{{ route('admin.messages.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection