<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Laporan - {{ $namaToko }}</title>
<style>
:root{--blue:#1e3a5f;--ink:#222;--muted:#708099;--line:#e6ebf2;--page:#eef2f5}
*{box-sizing:border-box}body{margin:0;background:var(--page);font-family:"Segoe UI",Arial,sans-serif;color:var(--ink)}
.layout{display:flex;min-height:100vh}.sidebar{width:234px;flex:0 0 234px;background:var(--blue);color:#fff;display:flex;flex-direction:column;position:sticky;top:0;align-self:flex-start;height:100vh;overflow-y:auto}.brand{height:84px;padding:22px 24px;display:flex;gap:12px;align-items:center}.brand-mark{width:36px;height:36px;display:grid;place-items:center;border-radius:8px;background:rgba(255,255,255,.18);font-size:22px;}.brand strong{display:block;font-size:15px}.brand small{display:block;margin-top:3px;color:#d4e3ff;font-size:12px}.nav{padding:9px 12px}.nav a{display:flex;align-items:center;gap:13px;color:#dce9ff;text-decoration:none;padding:12px 16px;border-radius:9px;font-size:14px;margin:3px 0}.nav a:hover,.nav a.active{background:rgba(255,255,255,.2);color:#fff}.nav-icon{width:18px;text-align:center;font-size:19px}.nav-icon svg{width:18px;height:18px;display:block}.nav-arrow{margin-left:auto;font-size:11px;color:#9db3d1;transition:transform .15s ease}.nav-arrow.down{transform:rotate(90deg)}.nav-submenu{margin:2px 0 6px 33px;display:flex;flex-direction:column;gap:2px}.nav-submenu a{padding:8px 10px;font-size:13px;border-radius:7px;color:#c7d7ee;text-decoration:none;display:block}.nav-submenu a:hover{background:rgba(255,255,255,.12);color:#fff}.nav-submenu a.active{background:rgba(255,255,255,.2);color:#fff;font-weight:700}.sidebar-spacer{flex:1}.logout{border-top:1px solid rgba(255,255,255,.18);padding:14px 12px}.logout a{margin:0;color:#fff;text-decoration:none;display:flex;align-items:center;gap:13px;padding:12px 16px;border-radius:9px;font-size:14px}.logout a:hover{background:rgba(255,255,255,.15)}.main{flex:1;min-width:0;padding:25px 31px 38px}.heading{display:flex;justify-content:space-between;align-items:flex-start;margin:0 0 25px}.heading h1{font-size:27px;margin:0 0 4px}.heading p{margin:0;color:var(--muted);font-size:16px}.date{color:var(--muted);font-size:13px;padding-top:8px}
.tab-laporan{display:inline-flex;background:#f0f4f8;border-radius:9px;padding:4px;gap:4px;margin-bottom:18px}
.tab-btn{border:0;background:transparent;color:var(--muted);font-size:13px;font-weight:600;padding:9px 18px;border-radius:7px;cursor:pointer;transition:all .15s ease}
.tab-btn:hover{color:var(--blue)}
.tab-btn.active{background:var(--blue);color:#fff;box-shadow:0 1px 3px rgba(23,36,58,.18)}
.filter-kasir{display:flex;align-items:flex-end;gap:12px;margin-bottom:18px;flex-wrap:wrap}
.filter-kasir div{display:flex;flex-direction:column;gap:5px}
.filter-kasir label{font-size:12px;color:var(--muted);font-weight:600}
.filter-kasir input[type="date"]{border:1px solid var(--line);border-radius:8px;padding:8px 10px;font-size:13px;color:var(--ink)}
.filter-kasir button{background:var(--blue);color:#fff;border:0;border-radius:8px;padding:9px 18px;font-size:13px;font-weight:600;cursor:pointer}
.filter-kasir .clear{font-size:13px;color:var(--muted);text-decoration:none;padding:9px 4px}
.filter-kasir .clear:hover{color:var(--blue)}
.panel{background:#fff;border-radius:13px;padding:22px;box-shadow:0 2px 5px rgba(23,36,58,.04);border:1px solid var(--line);overflow-x:auto}
table{width:100%;border-collapse:collapse}th,td{padding:12px 10px;border-bottom:1px solid #eee;text-align:left;font-size:14px}th{background:#f7f9fb;color:#555;font-size:13px}.money{font-weight:700;white-space:nowrap}.badge{display:inline-block;background:#e8f5e9;color:#2e7d32;padding:5px 10px;border-radius:20px;font-size:12px;font-weight:700}.detail{color:#1e3a5f;text-decoration:none;font-weight:700}.empty{text-align:center;color:#999;padding:40px}
@media(max-width:760px){.sidebar{width:62px;flex-basis:62px}.brand{padding:18px 17px}.brand div,.nav a span:not(.nav-icon),.logout a span{display:none}.nav a{justify-content:center;padding:12px 8px}.main{padding:20px 15px}.heading{display:block}.date{padding-top:12px}}
</style>
</head>
<body>
<div class="layout">
    @include('admin.partials.sidebar', ['active' => 'riwayat-transaksi'])
    <main class="main">
        <header class="heading">
            <div><h1>Laporan</h1><p>Rekap seluruh transaksi yang dilakukan dari halaman kasir.</p></div>
            <div class="date">{{ now()->translatedFormat('l, d F Y') }}</div>
        </header>

        <div class="tab-laporan">
            <button type="button" class="tab-btn {{ $tabAktif === 'transaksi' ? 'active' : '' }}" data-tab="transaksi" onclick="pindahTabLaporan('transaksi')">Transaksi</button>
            <button type="button" class="tab-btn {{ $tabAktif === 'kasir' ? 'active' : '' }}" data-tab="kasir" onclick="pindahTabLaporan('kasir')">Kasir</button>
        </div>

        <section class="panel" id="panel-transaksi" style="{{ $tabAktif === 'transaksi' ? '' : 'display:none;' }}">
            <table>
                <thead><tr><th>No. Transaksi</th><th>Kasir</th><th>Tanggal</th><th>Jam</th><th>Item</th><th>Total</th><th>Bayar</th><th>Kembalian</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                @forelse($transaksi as $trx)
                    <tr>
                        <td><strong>{{ $trx->no_transaksi }}</strong></td>
                        <td><strong>{{ $trx->kasir?->username ?? '-' }}</strong></td>
                        <td>{{ $trx->tanggal }}</td><td>{{ $trx->jam }}</td>
                        <td>{{ $trx->jumlah_item }} item</td>
                        <td class="money">Rp {{ number_format($trx->total,0,',','.') }}</td>
                        <td class="money">Rp {{ number_format($trx->bayar,0,',','.') }}</td>
                        <td class="money">Rp {{ number_format($trx->kembalian,0,',','.') }}</td>
                        <td><span class="badge">Sukses</span></td>
                        <td><a class="detail" href="{{ route('admin.transaksi.detail',$trx->id) }}">Lihat Detail</a></td>
                    </tr>
                @empty
                    <tr><td colspan="10" class="empty">Belum ada transaksi.</td></tr>
                @endforelse
                </tbody>
            </table>
        </section>

        <section class="panel" id="panel-kasir" style="{{ $tabAktif === 'kasir' ? '' : 'display:none;' }}">
            <p style="font-size:12.5px;color:var(--muted);margin:0 0 12px;">
                Rekap performa penjualan tiap kasir. Hanya transaksi asli yang dihitung (data simulasi untuk model prediksi stok tidak diikutkan).
            </p>

            <form class="filter-kasir" method="GET" action="{{ route('admin.laporan') }}">
                <input type="hidden" name="tab" value="kasir">
                <div>
                    <label for="dari_kasir">Dari tanggal</label>
                    <input id="dari_kasir" type="date" name="dari_kasir" value="{{ $dariKasir }}">
                </div>
                <div>
                    <label for="sampai_kasir">Sampai tanggal</label>
                    <input id="sampai_kasir" type="date" name="sampai_kasir" value="{{ $sampaiKasir }}">
                </div>
                <button type="submit">Terapkan</button>
                @if($dariKasir || $sampaiKasir)
                    <a class="clear" href="{{ route('admin.laporan', ['tab' => 'kasir']) }}">Reset</a>
                @endif
            </form>

            <table>
                <thead><tr><th>Kasir</th><th>Jumlah Transaksi</th><th>Total Penjualan</th><th>Rata-rata / Transaksi</th></tr></thead>
                <tbody>
                @forelse($rekapKasir as $rekap)
                    <tr>
                        <td>
                            <strong>{{ $rekap->nama }}</strong>
                            @if($rekap->username)
                                <div style="font-size:12px;color:var(--muted);">{{ $rekap->username }}</div>
                            @endif
                        </td>
                        <td>{{ number_format($rekap->jumlah_transaksi,0,',','.') }} transaksi</td>
                        <td class="money">Rp {{ number_format($rekap->total_penjualan,0,',','.') }}</td>
                        <td class="money">Rp {{ number_format($rekap->jumlah_transaksi > 0 ? $rekap->total_penjualan / $rekap->jumlah_transaksi : 0,0,',','.') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="empty">Belum ada transaksi.</td></tr>
                @endforelse
                </tbody>
            </table>
        </section>

        <script>
        function pindahTabLaporan(tab) {
            document.getElementById('panel-transaksi').style.display = tab === 'transaksi' ? '' : 'none';
            document.getElementById('panel-kasir').style.display = tab === 'kasir' ? '' : 'none';
            document.querySelectorAll('.tab-btn').forEach(function (btn) {
                btn.classList.toggle('active', btn.dataset.tab === tab);
            });
        }
        </script>
    </main>
</div>
</body>
</html>