@extends('layout.app')

@section('content')
<div class="container mt-5" style="max-width: 600px;">
    <h3 class="mb-4 text-center">Registrasi Akun</h3>

    {{-- Tampilkan pesan error validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label>Nama Lengkap</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name') }}" autofocus placeholder="Masukkan nama lengkap">
        </div>

        <div class="mb-3">
            <label>Alamat Email</label>
            <input type="email" name="email" class="form-control" required value="{{ old('email') }}" placeholder="contoh@email.com">
        </div>

        <div class="mb-3">
            <label>No. Telepon</label>
            <input type="tel" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx">
        </div>

        <div class="mb-3">
            <label>Tanggal Lahir</label>
            <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date') }}">
        </div>

        <div class="mb-3">
            <label>Jenis Kelamin</label>
            <select name="gender" class="form-select">
                <option value="">Pilih</option>
                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Kata Sandi</label>
            <input type="password" name="password" class="form-control" required placeholder="Minimal 6 karakter">
        </div>

        <div class="mb-3">
            <label>Konfirmasi Kata Sandi</label>
            <input type="password" name="password_confirmation" class="form-control" required placeholder="Ulangi kata sandi">
        </div>

        <button type="submit" class="btn btn-dark w-100">Daftar</button>

        <div class="text-center mt-3">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
        </div>
    </form>
</div>
@endsection
