<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sistem</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0; min-height: 100vh; display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, #edf3ff, #eef2f5); font-family: 'Segoe UI', Arial, sans-serif;
        }
        .login-box {
            width: min(420px, 92vw); background: #fff; border-radius: 18px; box-shadow: 0 12px 30px rgba(0,0,0,0.10);
            padding: 30px 26px;
        }
        .login-box h2 { text-align: center; margin-bottom: 20px; color: #1e3a5f; }
        .label { display: block; margin-bottom: 8px; font-weight: 600; color: #334155; }
        .input {
            width: 100%; border: 1px solid #d8e1ee; border-radius: 10px; padding: 12px 14px; font-size: 15px; margin-bottom: 16px;
        }
        .btn {
            width: 100%; border: none; border-radius: 10px; padding: 12px; font-weight: 700; font-size: 15px;
            cursor: pointer; color: white; background: #1e3a5f;
        }
        .error { color: #c62828; font-size: 13px; margin-bottom: 12px; }
        .small-note { margin-top: 14px; font-size: 12px; color: #64748b; text-align: center; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Login</h2>

        @if ($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        @php
            $loginRoute = isset($role) && in_array($role, ['admin', 'kasir'], true)
                ? route('auth.login.post', ['role' => $role])
                : route('login.post');
        @endphp

        <form method="POST" action="{{ $loginRoute }}">
            @csrf
            @if(isset($role) && in_array($role, ['admin', 'kasir'], true))
                <input type="hidden" name="role" value="{{ $role }}">
            @endif

            <label class="label" for="username">Username</label>
            <input class="input" type="text" name="username" id="username" value="{{ old('username') }}" required autofocus>

            <label class="label" for="password">Password</label>
            <input class="input" type="password" name="password" id="password" required>

            <button class="btn" type="submit">Masuk</button>
        </form>

        <div class="small-note">Login admin dan kasir menggunakan form yang sama.</div>
    </div>
</body>
</html>
