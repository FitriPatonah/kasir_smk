<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - {{ config('app.name') }}</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; display: grid; place-items: center; padding: 20px; background: linear-gradient(160deg, #eef3fb, #eef2f5); font-family: 'Segoe UI', Arial, sans-serif; }
        .card { width: min(420px, 100%); padding: 28px; border-radius: 18px; background: #fff; box-shadow: 0 18px 40px rgba(20, 40, 70, .14); }
        h1 { margin: 0 0 8px; color: #1e3a5f; font-size: 22px; }
        p { margin: 0 0 22px; color: #708099; font-size: 14px; line-height: 1.5; }
        label { display: block; margin-bottom: 8px; color: #334155; font-size: 13.5px; font-weight: 600; }
        input { width: 100%; margin-bottom: 16px; padding: 12px 14px; border: 1.5px solid #e1e7f0; border-radius: 10px; background: #f9fafc; font-size: 14px; }
        input:focus { outline: none; border-color: #1e3a5f; background: #fff; }
        button { width: 100%; padding: 13px; border: 0; border-radius: 10px; background: linear-gradient(135deg, #1e3a5f, #2c5586); color: #fff; font-size: 15px; font-weight: 700; cursor: pointer; }
        .error { margin-bottom: 16px; padding: 10px 12px; border-radius: 8px; background: #fff0f0; color: #a52828; font-size: 13px; }
        .status { margin-bottom: 16px; padding: 10px 12px; border-radius: 8px; background: #edf8f0; color: #246b39; font-size: 13px; }
        .back { display: block; margin-top: 18px; color: #1e3a5f; font-size: 13px; text-align: center; text-decoration: none; }
    </style>
</head>
<body>
    <main class="card">
        <h1>Lupa Password</h1>
        <p>Masukkan email yang terdaftar. Jika cocok, kami akan mengirim tautan untuk membuat password baru.</p>

        @if ($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif
        @if (session('status'))
            <div class="status">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" required autofocus>
            <button type="submit">Kirim Tautan Reset</button>
        </form>
        <a class="back" href="{{ route('login') }}">Kembali ke halaman login</a>
    </main>
</body>
</html>
