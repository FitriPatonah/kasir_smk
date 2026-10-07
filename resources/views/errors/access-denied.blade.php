<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Ditolak</title>
    <style>
        * { box-sizing: border-box; }
        body { min-height: 100vh; margin: 0; display: grid; place-items: center; padding: 24px; background: #eef2f5; color: #222; font-family: "Segoe UI", Arial, sans-serif; }
        .access-denied { width: min(100%, 460px); padding: 32px; border: 1px solid #e1e7ee; border-radius: 10px; background: #fff; text-align: center; box-shadow: 0 12px 36px rgba(23, 36, 58, .1); }
        .access-denied-code { color: #1e3a5f; font-size: 13px; font-weight: 700; }
        h1 { margin: 10px 0; font-size: 25px; }
        p { margin: 0; color: #708099; font-size: 15px; line-height: 1.6; }
        .access-denied-actions { display: flex; justify-content: center; gap: 10px; flex-wrap: wrap; margin-top: 25px; }
        .access-denied-actions a { min-height: 40px; display: inline-flex; align-items: center; justify-content: center; padding: 0 15px; border: 1px solid #1e3a5f; border-radius: 6px; color: #1e3a5f; font-size: 14px; font-weight: 600; text-decoration: none; }
        .access-denied-actions a:hover { background: #1e3a5f; color: #fff; }
    </style>
</head>
<body>
    <main class="access-denied" role="alert">
        <div class="access-denied-code">403</div>
        <h1>Akses Ditolak</h1>
        <p>Anda tidak memiliki izin untuk mengakses halaman ini.</p>
        <div class="access-denied-actions">
            <a href="{{ $dashboardUrl }}">{{ $dashboardLabel }}</a>
            <a href="{{ $logoutUrl }}">Keluar</a>
        </div>
    </main>
    @include('partials.logout-confirmation')
</body>
</html>