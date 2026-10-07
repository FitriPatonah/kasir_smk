<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Tidak Ditemukan - {{ config('app.name') }}</title>
    <style>
        * { box-sizing: border-box; }
        body {
            min-height: 100vh; margin: 0; padding: 24px; display: grid; place-items: center;
            background: linear-gradient(145deg, #eef3fb, #f5f7fa); color: #26364a;
            font-family: "Segoe UI", Arial, sans-serif;
        }
        .not-found {
            width: min(100%, 560px); padding: 42px 36px; border: 1px solid #e0e7f0;
            border-radius: 18px; background: #fff; text-align: center;
            box-shadow: 0 18px 48px rgba(20, 40, 70, .12);
        }
        .brand-mark {
            width: 48px; height: 48px; margin: 0 auto 18px; display: grid; place-items: center;
            border-radius: 14px; background: #eaf1fb; color: #1e3a5f;
        }
        .brand-mark svg { width: 26px; height: 26px; }
        .code { color: #1e3a5f; font-size: clamp(64px, 15vw, 92px); font-weight: 800; line-height: 1; letter-spacing: -4px; }
        h1 { margin: 18px 0 8px; color: #1e3a5f; font-size: clamp(21px, 5vw, 27px); }
        p { margin: 0; color: #708099; font-size: 15px; line-height: 1.6; }
        .home-link {
            min-height: 44px; margin-top: 26px; padding: 0 20px; display: inline-flex;
            align-items: center; justify-content: center; border-radius: 9px;
            background: linear-gradient(135deg, #1e3a5f, #2c5586); color: #fff;
            font-size: 14px; font-weight: 700; text-decoration: none;
            box-shadow: 0 7px 16px rgba(30, 58, 95, .2);
        }
        .home-link:hover { filter: brightness(1.08); }
        .home-link:focus-visible { outline: 3px solid #9bb9e3; outline-offset: 3px; }
        @media (max-width: 480px) { .not-found { padding: 34px 22px; } }
    </style>
</head>
<body>
    <main class="not-found">
        <div class="brand-mark" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 4h2l2.2 11.2a2 2 0 0 0 2 1.6h8.2a2 2 0 0 0 1.9-1.5L21 8H6"/>
                <circle cx="10" cy="20" r="1.4"/>
                <circle cx="18" cy="20" r="1.4"/>
            </svg>
        </div>
        <div class="code">404</div>
        <h1>Halaman Tidak Ditemukan</h1>
        <p>Alamat yang Anda buka tidak tersedia. Periksa kembali URL atau kembali ke halaman utama.</p>
        <a class="home-link" href="{{ $homeUrl }}">{{ $homeLabel }}</a>
    </main>
</body>
</html>
