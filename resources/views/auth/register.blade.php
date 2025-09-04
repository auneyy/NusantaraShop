@extends('layout.app')

@section('content')
<style>
    .register-container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 0;
        background-color:rgb(232, 232, 232);
    }

    .register-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        padding: 2.5rem;
        width: 100%;
        max-width: 500px;
    }

    .register-title {
        color: #422D1C;
        font-weight: 700;
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }

    .register-subtitle {
        color: #666;
        margin-bottom: 2rem;
        font-size: 1rem;
    }

    .form-label {
        color: #422D1C;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .form-control, .form-select {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #422D1C;
        box-shadow: 0 0 0 0.2rem rgba(66, 45, 28, 0.25);
    }

    .form-control::placeholder {
        color: #adb5bd;
    }

    .btn-register {
        background-color: #422D1C;
        border-color: #422D1C;
        color: white;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        border-radius: 10px;
        font-size: 1.1rem;
        transition: all 0.3s ease;
    }

    .btn-register:hover {
        background-color: #8B4513;
        border-color: #8B4513;
        transform: translateY(-2px);
    }

    .alert-danger {
        border-radius: 10px;
        border: none;
        background-color: #f8d7da;
        color: #721c24;
        padding: 1rem;
    }

    .alert-danger ul {
        margin: 0;
        padding-left: 1.5rem;
    }

    .login-link {
        color: #422D1C;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s ease;
    }

    .login-link:hover {
        color: #8B4513;
    }

    .text-muted-custom {
        color: #666;
    }

    .form-row {
        display: flex;
        gap: 1rem;
    }

    .form-row .form-group {
        flex: 1;
    }

    @media (max-width: 768px) {
        .register-card {
            margin: 1rem;
            padding: 2rem;
        }
        
        .register-title {
            font-size: 1.5rem;
        }
        
        .form-row {
            flex-direction: column;
            gap: 0;
        }
    }
</style>

<div class="register-container">
    <div class="register-card">
        <div class="text-center">
            <h3 class="register-title">Registrasi Akun</h3>
            <p class="register-subtitle">Buat akun baru untuk berbelanja batik pilihan</p>
        </div>

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
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" required value="{{ old('name') }}" autofocus placeholder="Masukkan nama lengkap Anda">
            </div>

            <div class="mb-3">
                <label class="form-label">Alamat Email</label>
                <input type="email" name="email" class="form-control" required value="{{ old('email') }}" placeholder="contoh@email.com">
            </div>

            <div class="form-row mb-3">
                <div class="form-group">
                    <label class="form-label">No. Telepon</label>
                    <input type="tel" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx">
                </div>
                <div class="form-group">
                    <label class="form-label">Jenis Kelamin</label>
                    <select name="gender" class="form-select">
                        <option value="">Pilih</option>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Lahir</label>
                <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Kata Sandi</label>
                <input type="password" name="password" class="form-control" required placeholder="Minimal 8 karakter">
            </div>

            <div class="mb-4">
                <label class="form-label">Konfirmasi Kata Sandi</label>
                <input type="password" name="password_confirmation" class="form-control" required placeholder="Ulangi kata sandi">
            </div>

            <button type="submit" class="btn btn-register w-100">Daftar Sekarang</button>

            <div class="text-center mt-4">
                <span class="text-muted-custom">Sudah punya akun?</span>
                <a href="{{ route('login') }}" class="login-link">Masuk di sini</a>
            </div>
        </form>
    </div>
</div>
@endsection