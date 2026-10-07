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
        .login-page { width: min(420px, 100%); }
        .login-brand {
            position: relative; overflow: hidden; padding: 24px 22px 22px; border-radius: 20px 20px 0 0;
            background: linear-gradient(135deg, #14263f, #1e3a5f 55%, #2c5586); color: #fff; text-align: center;
        }
        .login-brand::after {
            content: ''; position: absolute; top: -72px; right: -48px; width: 180px; height: 180px;
            border-radius: 50%; background: radial-gradient(circle, rgba(120,170,255,.3), transparent 70%);
            pointer-events: none;
        }
        .login-brand-logo {
            position: relative; z-index: 1; display: inline-grid; place-items: center; width: 52px; height: 46px;
            border: 1px solid rgba(255,255,255,.25); border-radius: 10px;
            background: rgba(255,255,255,.12); color: #fff;
        }
        .login-brand-logo svg { width: 29px; height: 29px; }
        .login-brand h2 { position: relative; z-index: 1; margin: 9px 0 3px; color: #fff; font-size: 19px; line-height: 1.2; }
        .login-brand p { position: relative; z-index: 1; margin: 0; color: #cfe0ff; font-size: 11px; line-height: 1.4; }
        .login-card {
            width: 100%; background: #fff; border-radius: 20px;
            box-shadow: 0 18px 40px rgba(20, 40, 70, .14); overflow: hidden;
        }
        .login-body { padding: 24px 26px 30px; }
        .label { display: block; margin-bottom: 8px; font-weight: 600; font-size: 13.5px; color: #334155; }
        .input-wrap { position: relative; margin-bottom: 18px; }
        .input-wrap > svg:first-child {
            position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
            width: 17px; height: 17px; color: #9aa8bd; pointer-events: none;
        }
        .input {
            width: 100%; border: 1.5px solid #e1e7f0; border-radius: 12px; padding: 12px 14px 12px 40px;
            font-size: 14.5px; background: #f9fafc; transition: border-color .15s, background .15s;
        }
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear { display: none; }
        .input.password-input { padding-right: 44px; }
        .input:focus { outline: none; border-color: #1e3a5f; background: #fff; }
        .password-toggle {
            position: absolute; top: 50%; right: 12px; transform: translateY(-50%);
            display: grid; place-items: center; padding: 4px; border: 0; background: transparent;
            color: #708099; cursor: pointer;
        }
        .password-toggle svg { width: 19px; height: 19px; }
        .password-toggle[aria-pressed="true"] .password-eye-slash { display: none; }
        .password-toggle:focus-visible { outline: 2px solid #1e3a5f; outline-offset: 2px; border-radius: 4px; }
        .btn {
            width: 100%; border: none; border-radius: 12px; padding: 13px; font-weight: 700; font-size: 15px;
            cursor: pointer; color: #fff; background: linear-gradient(135deg, #1e3a5f, #2c5586);
            box-shadow: 0 8px 18px rgba(30, 58, 95, .28); transition: filter .15s;
        }
        .btn:hover { filter: brightness(1.08); }
        .error { background: #fff0f0; color: #a52828; border-radius: 8px; padding: 10px 12px; font-size: 13px; margin-bottom: 16px; }
        .status { background: #edf8f0; color: #246b39; border-radius: 8px; padding: 10px 12px; font-size: 13px; margin-bottom: 16px; }
        .forgot-link { display: block; margin-top: 14px; color: #1e3a5f; font-size: 13px; text-align: right; text-decoration: none; }
        .forgot-link:hover { text-decoration: underline; }
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

    <main class="login-page">
        <section class="login-card">
            <header class="login-brand">
                <div class="login-brand-logo">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M3 4h2l2.2 11.2a2 2 0 0 0 2 1.6h8.2a2 2 0 0 0 1.9-1.5L21 8H6"/>
                        <circle cx="10" cy="20" r="1.4"/>
                        <circle cx="18" cy="20" r="1.4"/>
                    </svg>
                </div>
                <h2>Sistem Kasir &amp; Simulasi POS</h2>
                <p>Bisnis Daring dan Pemasaran (BDP)<br>SMK Darul Hikam Pendeuy</p>
            </header>
            <div class="login-body">
                @if ($errors->any())
                    <div class="error">{{ $errors->first() }}</div>
                @endif
                @if (session('status'))
                    <div class="status">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ $loginRoute }}">
                    @csrf
                    @if(isset($role) && in_array($role, ['admin', 'kasir'], true))
                        <input type="hidden" name="role" value="{{ $role }}">
                    @endif

                    <label class="label" for="username">Username atau Email</label>
                    <div class="input-wrap">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <input class="input" type="text" name="username" id="username" placeholder="Masukkan username atau email" value="{{ old('username') }}" autocomplete="username" required autofocus>
                    </div>

                    <label class="label" for="password">Password</label>
                    <div class="input-wrap">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        <input class="input password-input" type="password" name="password" id="password" placeholder="Masukkan password" autocomplete="current-password" required>
                        <button class="password-toggle" type="button" data-password-toggle="password" aria-label="Lihat password" aria-pressed="false">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/><path class="password-eye-slash" d="M3 3l18 18"/></svg>
                        </button>
                    </div>

                    <button class="btn" type="submit">Masuk</button>
                </form>
                <a class="forgot-link" href="{{ route('password.request') }}">Lupa password?</a>

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
        </section>
    </main>
    <script>
        document.querySelectorAll('[data-password-toggle]').forEach((button) => {
            const input = document.getElementById(button.dataset.passwordToggle);

            button.addEventListener('click', () => {
                const showPassword = input.type === 'password';
                input.type = showPassword ? 'text' : 'password';
                button.setAttribute('aria-pressed', String(showPassword));
                button.setAttribute('aria-label', showPassword ? 'Sembunyikan password' : 'Lihat password');
                input.focus();
            });
        });
    </script>
</body>
</html>