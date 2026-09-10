<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Login</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #eaf1ff, #eef2f5);
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
        }
        .wrap {
            width: min(900px, 90vw);
            background: #fff; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,.12);
            padding: 40px 32px;
        }
        .grid {
            display: grid; grid-template-columns: repeat(2, minmax(220px, 1fr)); gap: 24px;
        }
        .card {
            border: 1px solid #dfe8f5; border-radius: 16px; padding: 28px 20px; text-align: center; background: #f8fbff;
        }
        .card h2 { margin-bottom: 12px; color: #1e3a5f; }
        .card p { color: #5c6979; margin-bottom: 18px; }
        .btn {
            display: inline-block; text-decoration: none; padding: 12px 20px; border-radius: 10px; font-weight: 700;
            color: #fff; background: #1e3a5f;
        }
        .btn.admin { background: #1e3a5f; }
        .btn.kasir { background: #2e7d32; }
        @media (max-width: 640px) {
            .grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="grid">
            <div class="card">
                <h2>👑 Admin / Owner</h2>
                <p>Kelola stok, harga barang, serta pengaturan produk.</p>
                <a class="btn admin" href="{{ route('auth.login', ['role' => 'admin']) }}">Login Admin</a>
            </div>
            <div class="card">
                <h2>💼 Kasir</h2>
                <p>Transaksi penjualan dan pencarian produk cepat.</p>
                <a class="btn kasir" href="{{ route('auth.login', ['role' => 'kasir']) }}">Login Kasir</a>
            </div>
        </div>
    </div>
</body>
</html>
