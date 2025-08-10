<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - NusantaraShop</title>
    <style>
        * {margin:0;padding:0;box-sizing:border-box}
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f4f4;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
        }
        .login-container {
            background: #fff;
            border-radius: 10px;
            padding: 35px 25px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 360px;
        }
        .logo {
            font-size: 1.8rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 5px;
            color: #422D1C;
        }
        .tagline {
            text-align: center;
            font-size: 0.85rem;
            color: #777;
            margin-bottom: 20px;
        }
        .admin-title {
            text-align: center;
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 6px;
        }
        .admin-subtitle {
            text-align: center;
            font-size: 0.85rem;
            color: #777;
            margin-bottom: 20px;
        }
        .form-group {margin-bottom: 15px;}
        label {
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 5px;
            display: block;
        }
        input {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid #ddd;
            border-radius: 6px;
            font-size: 0.95rem;
            outline: none;
            transition: 0.2s;
        }
        input:focus {
            border-color: #422D1C;
            box-shadow: 0 0 0 3px rgba(66, 45, 28, 0.1);
        }
        .login-btn {
            width: 100%;
            padding: 12px;
            background: #422D1C;
            border: none;
            border-radius: 6px;
            color: #fff;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-btn:hover {
            background: #523a27;
        }
        .loading-spinner {
            display: none;
            width: 16px;
            height: 16px;
            border: 2px solid #fff;
            border-top: 2px solid transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 6px;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        .loading .loading-spinner {
            display: inline-block;
        }
        .alert {
            padding: 10px;
            margin-bottom: 15px;
            font-size: 0.85rem;
            border-radius: 5px;
        }
        .alert-danger {
            background: #ffe5e5;
            color: #c33;
            border: 1px solid #f5b5b5;
        }
        .login-footer {
            text-align: center;
            font-size: 0.75rem;
            color: #777;
            margin-top: 15px;
            border-top: 1px solid #eee;
            padding-top: 12px;
        }
    </style>
</head>
<body>
<div class="login-container">
    <h1 class="logo">NusantaraShop</h1>
    <hr>
    <h2 class="admin-title">Login Admin</h2>

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
            <label for="email">Email</label>
            <input 
                type="email" 
                name="email" 
                id="email" 
                value="{{ old('email') }}" 
                required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input 
                type="password" 
                name="password" 
                id="password" 
                required>
        </div>
        <button type="submit" class="login-btn" id="loginBtn">
            <span class="loading-spinner"></span>
            <span id="btnText">Login</span>
        </button>
    </form>

    <div class="login-footer">
        &copy; 2024 NusantaraShop<br>
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
