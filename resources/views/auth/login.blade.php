<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang - {{ $namaToko }}</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0; min-height: 100vh; display: flex; align-items: center; justify-content: center;
            background: linear-gradient(160deg, #eef3fb, #eef2f5); font-family: 'Segoe UI', Arial, sans-serif;
            padding: 20px;
        }
        .login-card {
            width: min(420px, 100%); background: #fff; border-radius: 20px;
            box-shadow: 0 18px 40px rgba(20, 40, 70, .14); overflow: hidden;
        }
        .login-head {
            position: relative; overflow: hidden;
            background: linear-gradient(135deg, #14263f, #1e3a5f 55%, #2c5586);
            padding: 26px 26px 30px; color: #fff;
            display: flex; align-items: flex-start; justify-content: space-between; gap: 14px;
        }
        .login-head::after {
            content: ''; position: absolute; width: 160px; height: 160px; border-radius: 50%;
            background: radial-gradient(circle, rgba(120,170,255,.35), transparent 70%);
            top: -50px; right: -40px;
        }
        .login-head h1 { margin: 0 0 6px; font-size: 21px; position: relative; z-index: 1; }
        .login-head p { margin: 0; font-size: 13.5px; color: #cfe0ff; line-height: 1.5; max-width: 260px; position: relative; z-index: 1; }
        .login-icon {
            flex: 0 0 auto; width: 52px; height: 52px; border-radius: 14px;
            background: rgba(255,255,255,.16); border: 1px solid rgba(255,255,255,.25);
            display: grid; place-items: center; font-size: 24px; position: relative; z-index: 1;
        }

        .login-body { padding: 28px 26px 30px; }
        .label { display: block; margin-bottom: 8px; font-weight: 600; font-size: 13.5px; color: #334155; }
        .input-wrap { position: relative; margin-bottom: 18px; }
        .input-wrap svg {
            position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
            width: 17px; height: 17px; color: #9aa8bd; pointer-events: none;
        }
        .input {
            width: 100%; border: 1.5px solid #e1e7f0; border-radius: 12px; padding: 12px 14px 12px 40px;
            font-size: 14.5px; background: #f9fafc; transition: border-color .15s, background .15s;
        }
        .input:focus { outline: none; border-color: #1e3a5f; background: #fff; }
        .btn {
            width: 100%; border: none; border-radius: 12px; padding: 13px; font-weight: 700; font-size: 15px;
            cursor: pointer; color: #fff; background: linear-gradient(135deg, #1e3a5f, #2c5586);
            box-shadow: 0 8px 18px rgba(30, 58, 95, .28); transition: filter .15s;
        }
        .btn:hover { filter: brightness(1.08); }
        .error { background: #fff0f0; color: #a52828; border-radius: 8px; padding: 10px 12px; font-size: 13px; margin-bottom: 16px; }
        .small-note { margin-top: 18px; font-size: 12px; color: #8592a6; text-align: center; }

        .demo-akun {
            margin-top: 18px; background: #f5f8fc; border: 1px solid #e1e8f1; border-radius: 12px;
            padding: 12px 14px; font-size: 12.5px; color: #4a5b73;
        }
        .demo-akun .judul { display: flex; align-items: center; gap: 6px; font-weight: 700; color: #1e3a5f; margin-bottom: 10px; }
        .demo-akun .grid-akun { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .demo-akun .kolom-akun { display: flex; flex-direction: column; gap: 4px; background: #fff; border: 1px solid #e1e8f1; border-radius: 8px; padding: 8px 10px; }
        .demo-akun .peran { color: #708099; font-size: 11.5px; font-weight: 600; text-transform: uppercase; letter-spacing: .3px; }
        .demo-akun code { background: #f5f8fc; border: 1px solid #e1e8f1; border-radius: 5px; padding: 2px 7px; font-size: 12px; color: #1e3a5f; font-weight: 600; }
    </style>
</head>
<body>
    @php
        $subtitle = match($role ?? null) {
            'admin' => 'Masuk sebagai Admin untuk mengelola toko',
            'kasir' => 'Masuk sebagai Kasir untuk mulai transaksi',
            default => 'Masuk untuk melanjutkan ke sistem kasir',
        };
        $loginRoute = isset($role) && in_array($role, ['admin', 'kasir'], true)
            ? route('auth.login.post', ['role' => $role])
            : route('login.post');
    @endphp

    <div class="login-card">
        <div class="login-head">
            <div>
                <h1>Selamat Datang</h1>
                <p>{{ $subtitle }}</p>
            </div>
            <div class="login-icon">🛒</div>
        </div>

        <div class="login-body">
            @if ($errors->any())
                <div class="error">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ $loginRoute }}">
                @csrf
                @if(isset($role) && in_array($role, ['admin', 'kasir'], true))
                    <input type="hidden" name="role" value="{{ $role }}">
                @endif

                <label class="label" for="username">Username</label>
                <div class="input-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <input class="input" type="text" name="username" id="username" placeholder="Masukkan username" value="{{ old('username') }}" required autofocus>
                </div>

                <label class="label" for="password">Password</label>
                <div class="input-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    <input class="input" type="password" name="password" id="password" placeholder="Masukkan password" required>
                </div>

                <button class="btn" type="submit">Masuk</button>
            </form>

            <div class="demo-akun">
                <div class="judul">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
                    Akun Demo
                </div>
                <div class="grid-akun">
                    <div class="kolom-akun">
                        <span class="peran">Admin</span>
                        <span><code>admin</code>/<code>admin123</code></span>
                    </div>
                    <div class="kolom-akun">
                        <span class="peran">Kasir</span>
                        <span><code>kasir1</code>/<code>kasir1</code></span>
                    </div>
                </div>
            </div>

            <div class="small-note">Sistem Kasir {{ $namaToko }} &middot; &copy; {{ date('Y') }}</div>
        </div>
    </div>
</body>
</html>