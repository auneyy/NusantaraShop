<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - NusantaraShop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #ffffff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .login-container {
            background: #ffffff;
            padding: 0;
            box-shadow: 0 20px 60px rgba(66, 45, 28, 0.15), 
                        0 8px 25px rgba(66, 45, 28, 0.1);
            width: 100%;
            max-width: 420px;
            overflow: hidden;
            position: relative;
        }

        .login-header {
            background: #ffffff;
            padding: 40px 40px 30px;
            text-align: center;
            position: relative;
        }

        .login-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .login-subtitle {
            font-size: 15px;
            color: #718096;
            font-weight: 400;
        }

        .login-form {
            padding: 0 40px 40px;
        }

        .form-group {
            margin-bottom: 24px;
            position: relative;
        }

        .input-group {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
            font-size: 18px;
            z-index: 2;
        }

        input {
            width: 100%;
            padding: 16px 16px 16px 50px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            background: #f8fafc;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            outline: none;
            color: #2d3748;
            box-shadow: 0 2px 8px rgba(66, 45, 28, 0.08);
        }

        input::placeholder {
            color: #a0aec0;
            font-weight: 400;
        }

        input:focus {
            background: #ffffff;
            box-shadow: 0 4px 15px rgba(66, 45, 28, 0.15);
        }

        input:focus + .input-icon {
            color: #422D1C;
        }

        .login-btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #422D1C 0%, #5a3d2a 100%);
            border: none;
            border-radius: 12px;
            color: white;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            margin-top: 8px;
            box-shadow: 0 4px 15px rgba(66, 45, 28, 0.2);
        }

        .login-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .login-btn:hover::before {
            left: 100%;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(66, 45, 28, 0.3);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .loading-spinner {
            display: none;
            width: 18px;
            height: 18px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top: 2px solid #ffffff;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin-right: 8px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .loading .loading-spinner {
            display: inline-block;
        }

        .alert {
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 14px;
            border-radius: 10px;
            border-left: 4px solid #e53e3e;
            background: linear-gradient(135deg, #fed7d7 0%, #feb2b2 100%);
            color: #742a2a;
            box-shadow: 0 2px 8px rgba(229, 62, 62, 0.1);
        }

        .login-footer {
            text-align: center;
            padding: 20px 40px;
            font-size: 13px;
            color: #718096;
            background: #f7fafc;
            border-top: 1px solid #e2e8f0;
        }

        .forgot-password {
            text-align: center;
            margin-top: 20px;
        }

        .forgot-password a {
            color: #422D1C;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .forgot-password a:hover {
            color: #8B4513;
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-container {
                margin: 20px;
                max-width: none;
                border-radius: 20px;
                box-shadow: 0 15px 45px rgba(66, 45, 28, 0.12), 
                            0 6px 20px rgba(66, 45, 28, 0.08);
            }

            .login-header {
                padding: 30px 30px 25px;
            }

            .login-form {
                padding: 0 30px 30px;
            }

            .login-footer {
                padding: 15px 30px;
            }

            .logo-container {
                width: 70px;
                height: 70px;
            }

            .logo-icon {
                font-size: 32px;
            }

            .login-title {
                font-size: 24px;
            }
        }

        /* Loading state */
        .login-btn:disabled {
            cursor: not-allowed;
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
                <div class="logo-icon">
   <img src="{{ asset('storage/product_images/logoaja.png') }}" 
     alt="logo" 
     class="logonusantara"
     style="width:80px; height:auto;">
</div>
            <h1 class="login-title">Login</h1>
            <p class="login-subtitle">Akses admin dashboard</p>
        </div>

        <div class="login-form">
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}" id="loginForm">
                @csrf
                <div class="form-group">
                    <div class="input-group">
                        <input 
                            type="email" 
                            name="email" 
                            id="email" 
                            value="{{ old('email') }}" 
                            placeholder="Masukkan email"
                            required>
                        <div class="input-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            placeholder="Masukkan password"
                            required>
                        <div class="input-icon">
                            <i class="fas fa-lock"></i>
                        </div>
                    </div>
                </div>

                <button type="submit" class="login-btn" id="loginBtn">
                    <span class="loading-spinner"></span>
                    <span id="btnText">Login</span>
                </button>
            </form>
        </div>

        <div class="login-footer">
            &copy; 2025 NusantaraShop. All rights reserved.
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function() {
            const btn = document.getElementById('loginBtn');
            btn.classList.add('loading');
            btn.disabled = true;
            document.getElementById('btnText').textContent = 'Memproses...';
        });
        document.getElementById('email').focus();
    </script>
</body>
</html>