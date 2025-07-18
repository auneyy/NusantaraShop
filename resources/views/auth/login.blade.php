@extends('layout.app')

@section('content')
<style>
    .login-container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 0;
    }

    .login-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        padding: 3rem;
        width: 100%;
        max-width: 450px;
    }

    .login-title {
        color: #422D1C;
        font-weight: 700;
        font-size: 2.2rem;
        margin-bottom: 0.5rem;
    }

    .login-subtitle {
        color: #666;
        margin-bottom: 2.5rem;
        font-size: 1rem;
    }

    .form-label {
        color: #422D1C;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #422D1C;
        box-shadow: 0 0 0 0.2rem rgba(66, 45, 28, 0.25);
    }

    .form-control::placeholder {
        color: #adb5bd;
    }

    .btn-login {
        background-color: #422D1C;
        border-color: #422D1C;
        color: white;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        border-radius: 10px;
        font-size: 1.1rem;
        transition: all 0.3s ease;
    }

    .btn-login:hover {
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
        margin-bottom: 1.5rem;
    }

    .register-link {
        color: #422D1C;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s ease;
    }

    .register-link:hover {
        color: #8B4513;
    }

    .text-muted-custom {
        color: #666;
    }

    .divider {
        display: flex;
        align-items: center;
        text-align: center;
        margin: 1.5rem 0;
    }

    .divider::before,
    .divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #e9ecef;
    }

    .divider:not(:empty)::before {
        margin-right: 0.5rem;
    }

    .divider:not(:empty)::after {
        margin-left: 0.5rem;
    }

    .forgot-password {
        color: #8B4513;
        text-decoration: none;
        font-size: 0.9rem;
        transition: color 0.3s ease;
    }

    .forgot-password:hover {
        color: #422D1C;
    }

    .welcome-text {
        background: linear-gradient(135deg, #422D1C 0%, #8B4513 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 700;
    }

    @media (max-width: 768px) {
        .login-card {
            margin: 1rem;
            padding: 2rem;
        }
        
        .login-title {
            font-size: 1.8rem;
        }
    }
</style>

<div class="login-container">
    <div class="login-card">
        <div class="text-center">
            <h2 class="login-title">Selamat Datang</h2>
            <p class="login-subtitle">Masuk ke akun <span class="welcome-text">NusantaraShop</span> Anda</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Alamat Email</label>
                <input type="email" name="email" id="email" class="form-control" required autofocus value="{{ old('email') }}" placeholder="contoh@email.com">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Kata Sandi</label>
                <input type="password" name="password" id="password" class="form-control" required placeholder="Masukkan kata sandi Anda">
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="rememberMe">
                    <label class="form-check-label text-muted-custom" for="rememberMe">
                        Ingat saya
                    </label>
                </div>
                <a href="#" class="forgot-password">Lupa kata sandi?</a>
            </div>

            <button type="submit" class="btn btn-login w-100 mb-3">Masuk</button>

            <div class="divider text-muted-custom">atau</div>

            <div class="text-center">
                <span class="text-muted-custom">Belum punya akun?</span>
                <a href="{{ route('register') }}" class="register-link">Daftar sekarang</a>
            </div>
        </form>
    </div>
</div>
@endsection