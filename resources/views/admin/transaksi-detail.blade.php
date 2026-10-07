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
.meta{display:grid;grid-template-columns:repeat(4,1fr);gap:10px;margin-bottom:16px}.meta div{background:#f7f9fb;padding:12px;border-radius:8px}.meta small{display:block;color:#777}.meta strong{display:block;margin-top:4px}
table{width:100%;border-collapse:collapse;margin-top:12px}th,td{padding:11px;border-bottom:1px solid #eee;text-align:left}th{background:#f7f9fb;font-size:13px}.right{text-align:right}.total{font-size:18px;font-weight:800;color:#1e3a5f}
@media(max-width:760px){.sidebar{width:62px;flex-basis:62px}.brand{padding:18px 17px}.brand div,.nav a span:not(.nav-icon),.logout a span{display:none}.nav a{justify-content:center;padding:12px 8px}.main{padding:20px 15px}.heading{display:block}.date{padding-top:12px}.meta{grid-template-columns:1fr}}
</style>
</head>
<body>
<div class="layout">
    @include('admin.partials.sidebar', ['active' => 'riwayat-transaksi'])
    <main class="main">
        <header class="heading"><div><h1>Detail Transaksi</h1><p>{{ $transaksi->no_transaksi }}</p></div><a class="back" href="{{ route('admin.laporan') }}">← Kembali ke Riwayat</a></header>
        <section class="panel">
            <div class="meta">
                <div><small>No. Transaksi</small><strong>{{ $transaksi->no_transaksi }}</strong></div>
                <div><small>Kasir</small><strong>{{ $transaksi->kasir?->username ?? '-' }}</strong></div>
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