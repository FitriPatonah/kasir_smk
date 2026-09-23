<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Stok Produk - {{ $namaToko }}</title>
    <style>
        :root {
            --blue: #1e3a5f;
            --ink: #222;
            --muted: #708099;
            --line: #e6ebf2;
            --page: #eef2f5;
        }
        * { box-sizing: border-box; }
        body { margin: 0; background: var(--page); font-family: "Segoe UI", Arial, sans-serif; color: var(--ink); }
        .layout { display: flex; min-height: 100vh; }
        .sidebar { width: 234px; flex: 0 0 234px; background: var(--blue); color: #fff; display: flex; flex-direction: column; position: sticky; top: 0; align-self: flex-start; height: 100vh; overflow-y: auto; }
        .brand { display: flex; align-items: center; gap: 11px; padding: 2px 10px 25px; }
        .brand-mark{width:36px;height:36px;display:grid;place-items:center;border-radius:8px;background:rgba(255,255,255,.18);font-size:22px;}
        .brand strong, .brand small { display: block; }
        .brand strong { font-size: 15px; }
        .brand small { margin-top: 3px; color: #d4e3ff; font-size: 12px; }
        .nav { padding: 9px 12px; }
        .nav a, .logout a { display: flex; align-items: center; gap: 13px; color: #dce9ff; text-decoration: none; padding: 12px 16px; border-radius: 9px; font-size: 14px; margin: 3px 0; }
        .nav a:hover, .nav a.active, .logout a:hover { background: rgba(255, 255, 255, .2); color: #fff; }
        .nav-icon { width: 18px; text-align: center; font-size: 19px; }.nav-icon svg{width:18px;height:18px;display:block}
        .sidebar-spacer { flex: 1; }
        .logout { border-top: 1px solid rgba(255, 255, 255, .18); padding: 14px 12px; }
        .logout a { margin: 0; color: #fff; }

        .main { flex: 1; min-width: 0; padding: 25px 31px 38px; }
        .heading { display: flex; justify-content: space-between; align-items: flex-start; margin: 0 0 22px; }
        .heading h1 { font-size: 27px; margin: 0 0 4px; }
        .heading p { margin: 0; color: var(--muted); font-size: 16px; }
        .date { color: var(--muted); font-size: 13px; padding-top: 8px; }

        .panel { background: #fff; border: 1px solid var(--line); border-radius: 13px; box-shadow: 0 2px 5px rgba(23, 36, 58, .04); padding: 25px; }
        .panel-head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 12px; }
        .panel h2 { font-size: 16px; margin: 0; color: var(--ink); }

        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 13px 12px; border-bottom: 1px solid var(--line); text-align: left; font-size: 14px; white-space: nowrap; }
        th { color: var(--muted); font-size: 12px; font-weight: 600; background: #fbfcfe; }

        .thumb { width: 42px; height: 42px; object-fit: cover; border-radius: 7px; border: 1px solid var(--line); }
        .no-photo { color: #aeb8c7; font-size: 12px; }

        .badge { display: inline-block; border-radius: 20px; padding: 4px 11px; font-size: 12px; font-weight: 600; }
        .badge-out { background: #fff0f0; color: #c53737; }
        .badge-low { background: #fff7df; color: #a26a00; }
        .badge-ok { background: #e5f8ed; color: #14733b; }
        .stock-num { font-weight: 700; font-size: 15px; color: var(--ink); }

        .empty { text-align: center; padding: 32px; color: #94a3b8; font-size: 14px; }



        @media(max-width: 760px) {
            .sidebar { width: 62px; flex-basis: 62px; }
            .brand { padding: 18px 17px; }
            .brand div, .nav a span:not(.nav-icon), .logout a span { display: none; }
            .nav a { justify-content: center; padding: 12px 8px; }
            .main { padding: 20px 15px; }
            .heading { display: block; }
            .date { padding-top: 12px; }
        }
    </style>
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <div class="brand" style="{{ $role === 'admin' ? 'height:84px;padding:22px 24px;gap:12px;' : 'padding:2px 10px 25px;gap:11px;' }}"><span class="brand-mark">🛒</span><div><strong>{{ $namaToko }}</strong><small>{{ $role === 'admin' ? 'Admin Utama' : auth('kasir')->user()->name }}</small></div></div>
        <nav class="nav">
            <a href="{{ $role === 'admin' ? route('admin.dashboard') : route('kasir.index') }}"><span class="nav-icon">{!! $role === 'admin' ? '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg>' : '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l1-6h16l1 6"/><path d="M3 9v10a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V9"/><path d="M9 21v-6h6v6"/></svg>' !!}</span><span>{{ $role === 'admin' ? 'Dashboard' : 'Kasir' }}</span></a>
            @if($role === 'admin')
                <a href="{{ route('admin.produk') }}"><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 8l-9-5-9 5v8l9 5 9-5V8z"/><path d="M3 8l9 5 9-5"/><path d="M12 13v8"/></svg></span><span>Produk</span></a>
                <a href="{{ route('admin.kategori') }}"><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41L11 3.83A2 2 0 0 0 9.5 3H4a1 1 0 0 0-1 1v5.5a2 2 0 0 0 .59 1.41l9.58 9.59a2 2 0 0 0 2.82 0l4.6-4.6a2 2 0 0 0 0-2.99z"/><circle cx="7.5" cy="7.5" r="1.2"/></svg></span><span>Kategori</span></a>
                <a href="{{ route('admin.supplier') }}"><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 3v5h-7z"/><circle cx="5.5" cy="18.5" r="2"/><circle cx="18" cy="18.5" r="2"/></svg></span><span>Supplier</span></a>
            @else
                <a href="{{ route('kasir.riwayat') }}"><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.5 2"/></svg></span><span>Riwayat</span></a>
            @endif
            <a class="active" href="{{ $role === 'admin' ? route('admin.stok') : route('kasir.stok') }}"><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="5" rx="1"/><path d="M4 9v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9"/><path d="M10 13h4"/></svg></span><span>Stok</span></a>
            @if($role === 'kasir')
                <a href="{{ route('kasir.profil') }}"><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></span><span>Profil</span></a>
            @endif
            @if($role === 'admin')
                <a href="{{ route('admin.transaksi') }}"><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2h9l3 3v17H6z"/><path d="M9 8h6M9 12h6M9 16h4"/></svg></span><span>Transaksi</span></a>
                <a href="{{ route('admin.laporan') }}"><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M18 20V10"/><path d="M12 20V4"/><path d="M6 20v-6"/></svg></span><span>Laporan</span></a>
                <a href="{{ route('admin.kelola-user') }}"><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></span><span>Kelola User</span></a><a href="{{ route('admin.pengaturan') }}"><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg></span><span>Pengaturan</span></a>
            @endif
        </nav>
        <div class="sidebar-spacer"></div>
        <div class="logout"><a href="{{ route('auth.logout', ['role' => $role]) }}"><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/></svg></span><span>Keluar</span></a></div>
    </aside>

    <main class="main">
        <header class="heading">
            <div>
                <h1>Stok Produk</h1>
                <p>Informasi ketersediaan stok produk persediaan toko.</p>
            </div>
            <div class="date">{{ now()->translatedFormat('l, d F Y') }}</div>
        </header>



        <section class="panel">
            <div class="panel-head">
                <h2>Data Stok Produk ({{ $produk->count() }})</h2>
                <div class="admin-search-wrapper" style="position:relative;display:flex;align-items:center;background:#fbfcfe;border:1px solid #d8e0eb;border-radius:8px;padding:0 12px;height:38px;width:240px;transition:all .2s ease;">
                    <span style="font-size:13px;color:#8090a6;margin-right:8px;display:flex;align-items:center;line-height:1;"><svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg></span>
                    <span style="width:1px;height:16px;background:#c0cbd9;margin-right:10px;display:inline-block;flex-shrink:0;"></span>
                    <input type="text" id="cari-stok" placeholder="Cari produk..." style="border:none;outline:none;background:transparent;font-size:13px;width:100%;color:var(--ink);" onfocus="this.parentElement.style.borderColor='#1e3a5f';this.parentElement.style.background='#fff'" onblur="this.parentElement.style.borderColor='#d8e0eb';this.parentElement.style.background='#fbfcfe'">
                </div>
            </div>

            <div class="table-wrap">
                <table id="tabel-stok">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Foto</th>
                            <th>Barcode</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok Tersedia</th>

                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($produk as $i => $item)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>
                                    @if($item->foto)
                                        <img class="thumb" src="{{ asset('storage/'.$item->foto) }}" alt="{{ $item->nama_produk }}">
                                    @else
                                        <span class="no-photo">Tanpa foto</span>
                                    @endif
                                </td>
                                <td>{{ $item->barcode }}</td>
                                <td><strong>{{ $item->nama_produk }}</strong></td>
                                <td>{{ $item->kategori }}</td>
                                <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                <td><span class="stock-num">{{ number_format($item->stok, 0, ',', '.') }}</span></td>

                                <td>
                                    @if($item->stok <= 0)
                                        <span class="badge badge-out">Habis</span>
                                    @elseif($item->stok <= 5)
                                        <span class="badge badge-low">Stok Menipis ({{ $item->stok }})</span>
                                    @else
                                        <span class="badge badge-ok">Tersedia</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="empty" colspan="8">Belum ada produk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</div>

<script>
const inputCariStok = document.getElementById('cari-stok');
if (inputCariStok) {
    inputCariStok.addEventListener('input', function() {
        const q = this.value.toLowerCase().trim();
        const rows = document.querySelectorAll('#tabel-stok tbody tr');
        rows.forEach(row => {
            if (row.querySelector('.empty')) return;
            const text = row.textContent.toLowerCase();
            row.style.display = (!q || text.includes(q)) ? '' : 'none';
        });
    });
}
</script>
</body>
</html>