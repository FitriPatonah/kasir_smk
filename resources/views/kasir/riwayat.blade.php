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

    .riwayat-heading { display: flex; justify-content: space-between; align-items: flex-start; margin: 0 0 18px; flex-wrap: wrap; gap: 10px; }
    .riwayat-heading h1 { font-size: 22px; margin: 0 0 4px; color: #1e3a5f; }
    .riwayat-heading p { margin: 0; color: #708099; font-size: 14px; }
    .riwayat-heading .tanggal { color: #708099; font-size: 13px; padding-top: 6px; }
</style>
</head>
<body>
<div class="app">
@include('kasir.partials.sidebar', ['active' => 'riwayat'])

<main class="main" style="grid-template-columns: 1fr;">
    <div>
        <header class="riwayat-heading">
            <div>
                <h1>Riwayat Transaksi</h1>
                <p>Daftar seluruh transaksi penjualan yang sudah kamu proses.</p>
            </div>
            <div style="display:flex;align-items:center;gap:14px;">
                <a href="{{ route('kasir.riwayat.export') }}" style="display:inline-flex;align-items:center;gap:8px;padding:10px 16px;border-radius:6px;background:#2e7d32;color:#fff;font-weight:700;font-size:14px;text-decoration:none;white-space:nowrap;">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v12"/><path d="M7 10l5 5 5-5"/><path d="M4 19h16"/></svg>
                    Download Excel
                </a>
                <div class="tanggal">{{ now()->translatedFormat('l, d F Y') }}</div>
            </div>
        </header>

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
    </div>
</main>
</div>
</body>
</html>