<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Password Baru - {{ config('app.name') }}</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; display: grid; place-items: center; padding: 20px; background: linear-gradient(160deg, #eef3fb, #eef2f5); font-family: 'Segoe UI', Arial, sans-serif; }
        .card { width: min(420px, 100%); padding: 28px; border-radius: 18px; background: #fff; box-shadow: 0 18px 40px rgba(20, 40, 70, .14); }
        h1 { margin: 0 0 8px; color: #1e3a5f; font-size: 22px; }
        p { margin: 0 0 22px; color: #708099; font-size: 14px; line-height: 1.5; }
        label { display: block; margin-bottom: 8px; color: #334155; font-size: 13.5px; font-weight: 600; }
        input { width: 100%; margin-bottom: 16px; padding: 12px 14px; border: 1.5px solid #e1e7f0; border-radius: 10px; background: #f9fafc; font-size: 14px; }
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear { display: none; }
        .password-field { position: relative; margin-bottom: 16px; }
        .password-field input { margin-bottom: 0; padding-right: 48px; }
        input:focus { outline: none; border-color: #1e3a5f; background: #fff; }
        button { width: 100%; padding: 13px; border: 0; border-radius: 10px; background: linear-gradient(135deg, #1e3a5f, #2c5586); color: #fff; font-size: 15px; font-weight: 700; cursor: pointer; }
        .password-toggle { position: absolute; top: 50%; right: 10px; transform: translateY(-50%); width: auto; display: grid; place-items: center; padding: 6px; border: 0; border-radius: 4px; background: transparent; color: #708099; cursor: pointer; }
        .password-toggle:hover { background: #eef2f5; }
        .password-toggle svg { display: block; width: 19px; height: 19px; }
        .password-toggle[aria-pressed="true"] .password-eye-slash { display: none; }
        .password-toggle:focus-visible { outline: 2px solid #1e3a5f; outline-offset: 2px; }
        .error { margin-bottom: 16px; padding: 10px 12px; border-radius: 8px; background: #fff0f0; color: #a52828; font-size: 13px; }
        .back { display: block; margin-top: 18px; color: #1e3a5f; font-size: 13px; text-align: center; text-decoration: none; }
    </style>
</head>
<body>
    <main class="card">
        <h1>Buat Password Baru</h1>
        <p>Gunakan password baru minimal 8 karakter.</p>

        @if ($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email', $email) }}" autocomplete="email" required autofocus>

            <label for="password">Password baru</label>
            <div class="password-field">
                <input id="password" type="password" name="password" autocomplete="new-password" required>
                <button class="password-toggle" type="button" data-password-toggle="password" aria-label="Lihat password" aria-pressed="false">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/><path class="password-eye-slash" d="M3 3l18 18"/></svg>
                </button>
            </div>

            <label for="password_confirmation">Ulangi password baru</label>
            <div class="password-field">
                <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" required>
                <button class="password-toggle" type="button" data-password-toggle="password_confirmation" aria-label="Lihat password" aria-pressed="false">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/><path class="password-eye-slash" d="M3 3l18 18"/></svg>
                </button>
            </div>

            <button type="submit">Simpan Password Baru</button>
        </form>
        <a class="back" href="{{ route('login') }}">Kembali ke halaman login</a>
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
