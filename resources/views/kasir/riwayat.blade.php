<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Riwayat Transaksi - {{ $namaToko }}</title>
<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
<link rel="stylesheet" href="{{ asset('css/kasir.css') }}">
<style>
    .tabel-riwayat { width: 100%; border-collapse: collapse; }
    .tabel-riwayat th, .tabel-riwayat td { padding: 12px 10px; text-align: left; border-bottom: 1px solid #eee; font-size: 14px; }
    .tabel-riwayat th { background: #f5f7fa; color: #555; font-size: 13px; }
    .empty { color: #999; text-align: center; padding: 40px 0; }
    .badge { display: inline-block; background: #e8f5e9; color: #2e7d32; padding: 5px 10px; border-radius: 99px; font-size: 12px; font-weight: 600; }
    .money { font-weight: 700; white-space: nowrap; }
</style>
</head>
<body>
<div class="app">
<aside class="sidebar">
    <div class="brand"><span class="brand-mark">🛒</span><div><strong>{{ $namaToko }}</strong><small>Kasir</small></div></div>
    <nav class="side-nav">
        <a href="{{ route('kasir.index') }}"><span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l1-6h16l1 6"/><path d="M3 9v10a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V9"/><path d="M9 21v-6h6v6"/></svg></span> Kasir </a>
        <a class="active" href="{{ route('kasir.riwayat') }}"><span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.5 2"/></svg></span> Riwayat</a>
        <a href="{{ route('kasir.stok') }}"><span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="5" rx="1"/><path d="M4 9v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9"/><path d="M10 13h4"/></svg></span> Stok</a>
    </nav>
    <a class="logout-link" href="{{ route('auth.logout', ['role'=>'kasir']) }}"><span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/></svg></span> Keluar</a>
</aside>

<main class="main" style="grid-template-columns: 1fr;">
    <div class="panel">
        <table class="tabel-riwayat">
            <thead>
                <tr>
                    <th>No. Transaksi</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Item</th>
                    <th>Total</th>
                    <th>Bayar</th>
                    <th>Kembalian</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transaksi as $trx)
                    <tr>
                        <td>{{ $trx->no_transaksi }}</td>
                        <td>{{ $trx->tanggal }}</td>
                        <td>{{ $trx->jam }}</td>
                        <td>{{ $trx->jumlah_item }} item</td>
                        <td class="money">Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                        <td class="money">Rp {{ number_format($trx->bayar, 0, ',', '.') }}</td>
                        <td class="money">Rp {{ number_format($trx->kembalian, 0, ',', '.') }}</td>
                        <td><span class="badge">Sukses</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="empty">Belum ada transaksi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>
</div>
</body>
</html>
