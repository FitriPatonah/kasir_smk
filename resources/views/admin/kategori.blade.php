<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori - {{ $namaToko }}</title>
    <style>
        :root{--blue:#1e3a5f;--ink:#222;--muted:#708099;--line:#e6ebf2;--page:#eef2f5}*{box-sizing:border-box}body{margin:0;background:var(--page);font-family:"Segoe UI",Arial,sans-serif;color:var(--ink)}.layout{display:flex;min-height:100vh}.sidebar{width:234px;flex:0 0 234px;background:var(--blue);color:#fff;display:flex;flex-direction:column;position:sticky;top:0;align-self:flex-start;height:100vh;overflow-y:auto}.brand{height:84px;padding:22px 24px;display:flex;gap:12px;align-items:center}.brand-mark{width:36px;height:36px;display:grid;place-items:center;border-radius:8px;background:rgba(255,255,255,.18);font-size:22px;}.brand strong,.brand small{display:block}.brand strong{font-size:15px}.brand small{margin-top:3px;color:#d4e3ff;font-size:12px}.nav{padding:9px 12px}.nav a,.logout a{display:flex;align-items:center;gap:13px;color:#dce9ff;text-decoration:none;padding:12px 16px;border-radius:9px;font-size:14px;margin:3px 0}.nav a.active,.nav a:hover,.logout a:hover{background:rgba(255,255,255,.2);color:#fff}.nav-icon{width:18px;text-align:center;font-size:19px}.nav-icon svg{width:18px;height:18px;display:block}.nav-arrow{margin-left:auto;font-size:11px;color:#9db3d1;transition:transform .15s ease}.nav-arrow.down{transform:rotate(90deg)}.nav-submenu{margin:2px 0 6px 33px;display:flex;flex-direction:column;gap:2px}.nav-submenu a{padding:8px 10px;font-size:13px;border-radius:7px;color:#c7d7ee;text-decoration:none;display:block}.nav-submenu a:hover{background:rgba(255,255,255,.12);color:#fff}.nav-submenu a.active{background:rgba(255,255,255,.2);color:#fff;font-weight:700}.sidebar-spacer{flex:1}.logout{border-top:1px solid rgba(255,255,255,.18);padding:14px 12px}.logout a{margin:0;color:#fff}.main{flex:1;min-width:0;padding:25px 31px 38px}.heading{display:flex;justify-content:space-between;align-items:flex-start;margin:0 0 25px}.heading h1{font-size:27px;margin:0 0 4px}.heading p{margin:0;color:var(--muted);font-size:16px}.heading-actions{display:flex;gap:10px}.btn-primary{border:0;border-radius:8px;background:var(--blue);color:#fff;padding:11px 16px;font:600 14px inherit;cursor:pointer}.btn-primary:hover{background:#16293f}.alert{padding:12px 15px;border-radius:8px;margin-bottom:16px;font-size:14px}.success{background:#e5f8ed;color:#14733b}.error{background:#fff0f0;color:#a52828}.category-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:16px}.category-card{background:#fff;border:1px solid var(--line);border-radius:13px;padding:25px;min-height:150px;box-shadow:0 2px 5px rgba(23,36,58,.04)}.category-icon{display:inline-flex;width:34px;height:34px;align-items:center;justify-content:center;border-radius:9px;background:#e8f0ff;color:#1670f5;font-size:17px;margin-bottom:18px}.category-card h2{font-size:16px;margin:0 0 8px}.category-card p{margin:0;color:var(--muted);line-height:1.5}.category-count{display:block;margin-top:14px;color:var(--blue);font-size:14px;font-weight:600}.card-actions{display:flex;gap:8px;margin-top:16px}.btn-link{border:0;background:transparent;color:var(--blue);font:600 13px inherit;cursor:pointer;padding:0}.btn-danger{border:0;background:transparent;color:#c33d3d;font:600 13px inherit;cursor:pointer;padding:0}.modal{display:none;position:fixed;inset:0;z-index:10;background:rgba(20,30,45,.55);align-items:center;justify-content:center;padding:16px}.modal.open{display:flex}.modal-panel{width:min(500px,100%);background:#fff;border-radius:10px;padding:24px;box-shadow:0 18px 50px rgba(15,31,52,.28)}.modal-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:18px}.modal-head h2{font-size:19px;margin:0}.modal-close{border:0;background:transparent;color:#708099;font-size:24px;cursor:pointer}.form-field{margin-bottom:14px}.form-field label{display:block;color:#374151;font-size:14px;margin-bottom:6px}.form-field input,.form-field textarea{width:100%;border:1px solid #d7dfeb;border-radius:7px;padding:10px;font:inherit}.form-field textarea{min-height:80px;resize:vertical}.modal-submit{width:100%}@media(max-width:800px){.sidebar{width:200px;flex-basis:200px}.main{padding:24px}.category-grid{grid-template-columns:repeat(2,minmax(0,1fr))}}@media(max-width:560px){.sidebar{width:62px;flex-basis:62px}.brand{padding:18px 17px}.brand div,.nav a span:not(.nav-icon),.logout a span{display:none}.nav a{justify-content:center;padding:12px 8px}.main{padding:20px 15px}.heading{display:block}.heading-actions{margin-top:14px}.category-grid{grid-template-columns:1fr}}
        .trash-icon{width:16px;height:16px;display:block;fill:none;stroke:#f04444;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round}
    </style>
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <div class="brand"><span class="brand-mark">🛒</span><div><strong>{{ $namaToko }}</strong><small>Admin Utama</small></div></div>
        <nav class="nav">
            <a href="{{ route('admin.dashboard') }}"><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg></span><span>Dashboard</span></a>
            <a href="{{ route('admin.produk') }}"><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 8l-9-5-9 5v8l9 5 9-5V8z"/><path d="M3 8l9 5 9-5"/><path d="M12 13v8"/></svg></span><span>Produk</span></a>
            <a class="active" href="{{ route('admin.kategori') }}"><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41L11 3.83A2 2 0 0 0 9.5 3H4a1 1 0 0 0-1 1v5.5a2 2 0 0 0 .59 1.41l9.58 9.59a2 2 0 0 0 2.82 0l4.6-4.6a2 2 0 0 0 0-2.99z"/><circle cx="7.5" cy="7.5" r="1.2"/></svg></span><span>Kategori</span></a>
            <a href="{{ route('admin.supplier') }}"><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 3v5h-7z"/><circle cx="5.5" cy="18.5" r="2"/><circle cx="18" cy="18.5" r="2"/></svg></span><span>Supplier</span></a>
            <a href="{{ route('admin.stok') }}"><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="5" rx="1"/><path d="M4 9v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9"/><path d="M10 13h4"/></svg></span><span>Stok</span></a>
            <a href="{{ route('admin.laporan') }}"><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2h9l3 3v17H6z"/><path d="M9 8h6M9 12h6M9 16h4"/></svg></span><span>Transaksi</span></a>
            <a href="{{ route('admin.riwayat.transaksi') }}"><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M18 20V10"/><path d="M12 20V4"/><path d="M6 20v-6"/></svg></span><span>Laporan</span></a>
            <a href="{{ route('admin.pengaturan') }}"><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg></span><span>Pengaturan</span></a>
        </nav>
        <div class="sidebar-spacer"></div>
        <div class="logout"><a href="{{ route('auth.logout', ['role' => 'admin']) }}"><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/></svg></span><span>Keluar</span></a></div>
    </aside>
    <main class="main">
        <header class="heading"><div><h1>Kategori</h1><p>{{ $kategori->count() }} kategori produk</p></div><div class="heading-actions"><button class="btn-primary" type="button" onclick="bukaModal()">+ Tambah Kategori</button></div></header>
        @if(session('success')) <div class="alert success">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="alert error">{{ session('error') }}</div> @endif
        <section class="category-grid">
            @foreach($kategori as $item)
                <article class="category-card">
                    <span class="category-icon">◇</span>
                    <h2>{{ $item->nama }}</h2>
                    <p>{{ $item->deskripsi ?: 'Kelola produk dalam kategori ini.' }}</p>
                    <span class="category-count">{{ $item->jumlah_produk }} produk</span>
                    <div class="card-actions"><button class="btn-link" type="button" onclick="bukaModal({{ $item->id }}, @js($item->nama), @js($item->deskripsi))">Edit</button><form method="POST" action="{{ route('admin.kategori.destroy', $item->id) }}" onsubmit="return confirm('Hapus kategori {{ addslashes($item->nama) }}?')">@csrf @method('DELETE')<button class="btn-danger" type="submit" title="Hapus kategori" aria-label="Hapus kategori"><svg class="trash-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 7h16M10 11v6M14 11v6M6 7l1 13h10l1-13M9 7l1-3h4l1 3"/></svg></button></form></div>
                </article>
            @endforeach
        </section>
    </main>
</div>
<div id="kategori-modal" class="modal" role="dialog" aria-modal="true" aria-labelledby="modal-title">
    <div class="modal-panel">
        <div class="modal-head"><h2 id="modal-title">Tambah Kategori</h2><button class="modal-close" type="button" onclick="tutupModal()" aria-label="Tutup">&times;</button></div>
        <form id="kategori-form" method="POST" action="{{ route('admin.kategori.store') }}">
            @csrf
            <input id="method-field" type="hidden" name="_method" value="POST">
            <div class="form-field"><label for="nama-kategori">Nama Kategori<span aria-hidden="true">*</span></label><input id="nama-kategori" name="nama" required maxlength="80"></div>
            <div class="form-field"><label for="deskripsi-kategori">Deskripsi</label><textarea id="deskripsi-kategori" name="deskripsi" maxlength="255"></textarea></div>
            <button class="btn-primary modal-submit" type="submit">Simpan</button>
        </form>
    </div>
</div>
<script>
const modalKategori = document.getElementById('kategori-modal');
const formKategori = document.getElementById('kategori-form');
const methodKategori = document.getElementById('method-field');
const namaKategori = document.getElementById('nama-kategori');
const deskripsiKategori = document.getElementById('deskripsi-kategori');
function bukaModal(id = null, nama = '', deskripsi = '') {
    document.getElementById('modal-title').textContent = id ? 'Edit Kategori' : 'Tambah Kategori';
    formKategori.action = id ? '{{ url('/admin/kategori') }}/' + id : '{{ route('admin.kategori.store') }}';
    methodKategori.value = id ? 'PUT' : 'POST';
    namaKategori.value = nama;
    deskripsiKategori.value = deskripsi || '';
    modalKategori.classList.add('open');
    namaKategori.focus();
}
function tutupModal() { modalKategori.classList.remove('open'); }
modalKategori.addEventListener('click', event => { if (event.target === modalKategori) tutupModal(); });
</script>
</body>
</html>