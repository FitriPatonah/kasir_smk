<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Detail Transaksi {{ $transaksi->no_transaksi }} - {{{ $namaToko }}}</title>
<style>
:root{--blue:#1e3a5f;--ink:#222;--muted:#708099;--line:#e6ebf2;--page:#eef2f5}
*{box-sizing:border-box}body{margin:0;background:var(--page);font-family:"Segoe UI",Arial,sans-serif;color:var(--ink)}
.layout{display:flex;min-height:100vh}.sidebar{width:234px;flex:0 0 234px;background:var(--blue);color:#fff;display:flex;flex-direction:column;position:sticky;top:0;align-self:flex-start;height:100vh;overflow-y:auto}.brand{height:84px;padding:22px 24px;display:flex;gap:12px;align-items:center}.brand-mark{width:36px;height:36px;display:grid;place-items:center;border-radius:8px;background:rgba(255,255,255,.18);font-size:22px;}.brand strong{display:block;font-size:15px}.brand small{display:block;margin-top:3px;color:#d4e3ff;font-size:12px}.nav{padding:9px 12px}.nav a{display:flex;align-items:center;gap:13px;color:#dce9ff;text-decoration:none;padding:12px 16px;border-radius:9px;font-size:14px;margin:3px 0}.nav a:hover,.nav a.active{background:rgba(255,255,255,.2);color:#fff}.nav-icon{width:18px;text-align:center;font-size:19px}.nav-icon svg{width:18px;height:18px;display:block}.nav-arrow{margin-left:auto;font-size:11px;color:#9db3d1;transition:transform .15s ease}.nav-arrow.down{transform:rotate(90deg)}.nav-submenu{margin:2px 0 6px 33px;display:flex;flex-direction:column;gap:2px}.nav-submenu a{padding:8px 10px;font-size:13px;border-radius:7px;color:#c7d7ee;text-decoration:none;display:block}.nav-submenu a:hover{background:rgba(255,255,255,.12);color:#fff}.nav-submenu a.active{background:rgba(255,255,255,.2);color:#fff;font-weight:700}.sidebar-spacer{flex:1}.logout{border-top:1px solid rgba(255,255,255,.18);padding:14px 12px}.logout a{margin:0;color:#fff;text-decoration:none;display:flex;align-items:center;gap:13px;padding:12px 16px;border-radius:9px;font-size:14px}.logout a:hover{background:rgba(255,255,255,.15)}.main{flex:1;min-width:0;padding:25px 31px 38px}.heading{display:flex;justify-content:space-between;align-items:flex-start;margin:0 0 25px}.heading h1{font-size:27px;margin:0 0 4px}.heading p{margin:0;color:var(--muted);font-size:16px}.date{color:var(--muted);font-size:13px;padding-top:8px}
.panel{background:#fff;border-radius:13px;padding:22px;box-shadow:0 2px 5px rgba(23,36,58,.04);border:1px solid var(--line);max-width:850px}
.back{color:var(--blue);text-decoration:none;font-size:13px;font-weight:600}
.meta{display:grid;grid-template-columns:repeat(3,1fr);gap:10px;margin-bottom:16px}.meta div{background:#f7f9fb;padding:12px;border-radius:8px}.meta small{display:block;color:#777}.meta strong{display:block;margin-top:4px}
table{width:100%;border-collapse:collapse;margin-top:12px}th,td{padding:11px;border-bottom:1px solid #eee;text-align:left}th{background:#f7f9fb;font-size:13px}.right{text-align:right}.total{font-size:18px;font-weight:800;color:#1e3a5f}
@media(max-width:760px){.sidebar{width:62px;flex-basis:62px}.brand{padding:18px 17px}.brand div,.nav a span:not(.nav-icon),.logout a span{display:none}.nav a{justify-content:center;padding:12px 8px}.main{padding:20px 15px}.heading{display:block}.date{padding-top:12px}.meta{grid-template-columns:1fr}}
</style>
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <div class="brand"><span class="brand-mark">🛒</span><div><strong>{{ $namaToko }}</strong><small>Admin Utama</small></div></div>
        <nav class="nav">
            <a href="{{ route('admin.dashboard') }}"><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg></span><span>Dashboard</span></a>
            <a href="{{ route('admin.produk') }}"><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 8l-9-5-9 5v8l9 5 9-5V8z"/><path d="M3 8l9 5 9-5"/><path d="M12 13v8"/></svg></span><span>Produk</span></a>
            <a href="{{ route('admin.kategori') }}"><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41L11 3.83A2 2 0 0 0 9.5 3H4a1 1 0 0 0-1 1v5.5a2 2 0 0 0 .59 1.41l9.58 9.59a2 2 0 0 0 2.82 0l4.6-4.6a2 2 0 0 0 0-2.99z"/><circle cx="7.5" cy="7.5" r="1.2"/></svg></span><span>Kategori</span></a>
            <a href="{{ route('admin.supplier') }}"><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 3v5h-7z"/><circle cx="5.5" cy="18.5" r="2"/><circle cx="18" cy="18.5" r="2"/></svg></span><span>Supplier</span></a>
            <a href="{{ route('admin.stok') }}"><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="5" rx="1"/><path d="M4 9v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9"/><path d="M10 13h4"/></svg></span><span>Stok</span><span class="nav-arrow">▸</span></a>
            <a href="{{ route('admin.laporan') }}">← Kembali ke Riwayat</a>
            <a class="active" href="{{ route('admin.riwayat.transaksi') }}"><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M18 20V10"/><path d="M12 20V4"/><path d="M6 20v-6"/></svg></span><span>Laporan</span></a>
            <a href="{{ route('admin.pengaturan') }}"><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg></span><span>Pengaturan</span></a>
        </nav>
        <div class="sidebar-spacer"></div>
        <div class="logout"><a href="{{ route('auth.logout', ['role' => 'admin']) }}"><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/></svg></span><span>Keluar</span></a></div>
    </aside>
    <main class="main">
        <header class="heading"><div><h1>Detail Transaksi</h1><p>{{ $transaksi->no_transaksi }}</p></div><a class="back" href="{{ route('admin.riwayat.transaksi') }}">← Kembali ke Riwayat</a></header>
        <section class="panel">
            <div class="meta">
                <div><small>No. Transaksi</small><strong>{{ $transaksi->no_transaksi }}</strong></div>
                <div><small>Tanggal</small><strong>{{ $transaksi->created_at->translatedFormat('d F Y') }}</strong></div>
                <div><small>Jam</small><strong>{{ $transaksi->created_at->translatedFormat('H:i:s') }}</strong></div>
            </div>
            <table>
                <thead><tr><th>Produk</th><th>Barcode</th><th class="right">Harga</th><th class="right">Qty</th><th class="right">Subtotal</th></tr></thead>
                <tbody>
                @foreach($transaksi->detail as $detail)
                    <tr>
                        <td>{{ $detail->nama_produk }}</td><td>{{ $detail->produk->barcode ?? '-' }}</td>
                        <td class="right">Rp {{ number_format($detail->harga,0,',','.') }}</td><td class="right">{{ $detail->qty }}</td>
                        <td class="right">Rp {{ number_format($detail->subtotal,0,',','.') }}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr><td colspan="4" class="right"><strong>Total</strong></td><td class="right total">Rp {{ number_format($transaksi->total,0,',','.') }}</td></tr>
                    <tr><td colspan="4" class="right">Bayar</td><td class="right">Rp {{ number_format($transaksi->bayar,0,',','.') }}</td></tr>
                    <tr><td colspan="4" class="right">Kembalian</td><td class="right">Rp {{ number_format($transaksi->kembalian,0,',','.') }}</td></tr>
                </tfoot>
            </table>
        </section>
    </main>
</div>
</body>
</html>