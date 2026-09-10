<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Produk - {{{ $namaToko }}}</title>
<style>
:root{--blue:#1e3a5f;--ink:#222;--muted:#708099;--line:#e6ebf2;--page:#eef2f5}
*{box-sizing:border-box}body{margin:0;background:var(--page);font-family:"Segoe UI",Arial,sans-serif;color:var(--ink)}
.layout{display:flex;min-height:100vh}.sidebar{width:234px;flex:0 0 234px;background:var(--blue);color:#fff;display:flex;flex-direction:column;position:sticky;top:0;align-self:flex-start;height:100vh;overflow-y:auto}
.brand{height:84px;padding:22px 24px;display:flex;gap:12px;align-items:center}
.brand-mark{width:36px;height:36px;display:grid;place-items:center;border-radius:8px;background:rgba(255,255,255,.18);font-size:22px;}.brand strong{display:block;font-size:15px}.brand small{display:block;margin-top:3px;color:#d4e3ff;font-size:12px}.nav{padding:9px 12px}.nav a{display:flex;align-items:center;gap:13px;color:#dce9ff;text-decoration:none;padding:12px 16px;border-radius:9px;font-size:14px;margin:3px 0}.nav a:hover,.nav a.active{background:rgba(255,255,255,.2);color:#fff}.nav-icon{width:18px;text-align:center;font-size:19px}.nav-icon svg{width:18px;height:18px;display:block}.nav-arrow{margin-left:auto;font-size:11px;color:#9db3d1;transition:transform .15s ease}.nav-arrow.down{transform:rotate(90deg)}.nav-submenu{margin:2px 0 6px 33px;display:flex;flex-direction:column;gap:2px}.nav-submenu a{padding:8px 10px;font-size:13px;border-radius:7px;color:#c7d7ee;text-decoration:none;display:block}.nav-submenu a:hover{background:rgba(255,255,255,.12);color:#fff}.nav-submenu a.active{background:rgba(255,255,255,.2);color:#fff;font-weight:700}.sidebar-spacer{flex:1}.logout{border-top:1px solid rgba(255,255,255,.18);padding:14px 12px}.logout a{margin:0;color:#fff;text-decoration:none;display:flex;align-items:center;gap:13px;padding:12px 16px;border-radius:9px;font-size:14px}.logout a:hover{background:rgba(255,255,255,.15)}.main{flex:1;min-width:0;padding:25px 31px 38px}.heading{display:flex;justify-content:space-between;align-items:flex-start;margin:0 0 25px}.heading h1{font-size:27px;margin:0 0 4px}.heading p{margin:0;color:var(--muted);font-size:16px}.date{color:var(--muted);font-size:13px;padding-top:8px}.panel{background:#fff;border:1px solid var(--line);border-radius:13px;box-shadow:0 2px 5px rgba(23,36,58,.04);padding:25px;overflow:hidden}.product-head{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px}.panel h2{font-size:16px;margin:0}.product-head a{color:#fff;background:var(--blue);text-decoration:none;border-radius:8px;padding:10px 14px;font-size:13px;font-weight:600}.alert{border-radius:8px;padding:12px 15px;margin-bottom:18px;font-size:14px}.success{background:#e5f8ed;color:#14733b}.error{background:#fff0f0;color:#a52828}.edit-form{display:none;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px;margin-top:14px;padding:15px;background:#f8faff;border:1px solid var(--line);border-radius:9px}.edit-form.show{display:grid}.field{display:flex;flex-direction:column;gap:6px}.field label{font-size:12px;color:var(--muted);font-weight:600}.field input{border:1px solid #d8e0eb;border-radius:7px;padding:10px;font:inherit;color:var(--ink);background:#fff}.field input:focus{outline:2px solid #c9dcff;border-color:var(--blue)}.file-field{grid-column:1/-1}.btn{border:0;border-radius:7px;padding:9px 12px;font:inherit;font-size:13px;cursor:pointer}.btn-primary{background:var(--blue);color:#fff;align-self:end}.btn-edit{background:#e8f0ff;color:#1765d1}.btn-danger{background:#fff0f0;color:#c53737}.inline{display:inline}.actions{display:flex;gap:7px;align-items:center}.table-wrap{overflow-x:auto}table{width:100%;border-collapse:collapse}th,td{padding:13px 10px;border-bottom:1px solid var(--line);text-align:left;font-size:14px;white-space:nowrap}th{color:var(--muted);font-size:12px;font-weight:600;background:#fbfcfe}.thumb{width:42px;height:42px;object-fit:cover;border-radius:7px;border:1px solid var(--line)}.no-photo{color:#aeb8c7;font-size:12px}.badge{display:inline-block;border-radius:20px;padding:5px 10px;font-size:12px;font-weight:600}.badge-out{background:#fff0f0;color:#c53737}.badge-low{background:#fff7df;color:#a26a00}.badge-ok{background:#e5f8ed;color:#14733b}.empty{text-align:center;padding:32px;color:#999}
@media(max-width:760px){.sidebar{width:62px;flex-basis:62px}.brand{padding:18px 17px}.brand div,.nav a span:not(.nav-icon),.logout a span{display:none}.nav a{justify-content:center;padding:12px 8px}.main{padding:20px 15px}.heading{display:block}.date{padding-top:12px}.panel{padding:18px}.product-head{align-items:flex-start;gap:12px}.edit-form{grid-template-columns:1fr}.file-field{grid-column:auto}}
 .table-wrap{display:none}.admin-product-grid{display:grid;grid-template-columns:repeat(3,minmax(150px,1fr));gap:12px}.admin-product-card{background:#fff;border:1px solid #e1e8f1;border-radius:11px;padding:11px;min-width:0}.admin-product-image{height:120px;border-radius:8px;background:#f0f4f8;display:grid;place-items:center;overflow:hidden;margin-bottom:9px}.admin-product-image img{width:100%;height:100%;object-fit:cover}.admin-product-image span{font-size:30px}.admin-product-name{display:block;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-size:14px}.admin-product-price{display:block;color:#1e3a5f;font-size:15px;font-weight:700;margin-top:6px}.admin-product-stock{display:block;color:#8090a6;font-size:12px;margin-top:5px}.admin-product-actions{display:flex;gap:7px;margin-top:11px}.admin-product-actions .btn{flex:1}.admin-product-card .edit-form{grid-template-columns:1fr;margin-top:11px}.admin-product-card .edit-form.show{display:grid}@media(max-width:900px){.admin-product-grid{grid-template-columns:repeat(2,minmax(150px,1fr))}}@media(max-width:560px){.admin-product-grid{grid-template-columns:repeat(2,minmax(120px,1fr));gap:8px}.admin-product-image{height:95px}}
<style>
.trash-icon{width:16px;height:16px;display:block;fill:none;stroke:#f04444;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round}
</style>
<style>
.edit-form.show { display: grid; position: fixed; z-index: 1001; top: 50%; left: 50%; width: min(620px, calc(100vw - 32px)); max-height: calc(100vh - 32px); overflow-y: auto; margin: 0; padding: 24px; transform: translate(-50%, -50%); background: #fff; border: 0; border-radius: 12px; box-shadow: 0 18px 50px rgba(15, 31, 52, .28); }
body.editing-product::before { content: ''; position: fixed; inset: 0; z-index: 1000; background: rgba(20, 30, 45, .58); }
.edit-modal-title { grid-column: 1 / -1; display: flex; justify-content: space-between; align-items: center; color: var(--blue); font-size: 19px; font-weight: 700; }
.edit-modal-close { border: 0; background: transparent; color: #708099; font-size: 25px; line-height: 1; cursor: pointer; padding: 0 2px; }
.edit-modal-close:hover { color: #222; }
@media(max-width:760px){.edit-form.show{grid-template-columns:1fr;padding:20px}.edit-modal-title{grid-column:auto}}
</style>
<script>
function closeEdit() {
    document.querySelectorAll('.edit-form.show').forEach(form => form.classList.remove('show'));
    document.body.classList.remove('editing-product');
}
function toggleEdit(id) {
    const form = document.getElementById('edit-' + id);
    if (!form) return;
    closeEdit();
    form.classList.add('show');
    document.body.classList.add('editing-product');
    form.querySelector('input[name="nama_produk"]')?.focus();
}
document.addEventListener('DOMContentLoaded', function(){
    const notice = document.querySelector('.alert.success');
    if (notice) setTimeout(function(){ notice.remove(); }, 3000);
    document.addEventListener('keydown', function(event){ if (event.key === 'Escape') closeEdit(); });
    document.addEventListener('click', function(event){
        if (document.body.classList.contains('editing-product') && !event.target.closest('.edit-form') && !event.target.closest('.btn-edit')) closeEdit();
    });
    document.querySelectorAll('.edit-form').forEach(form => {
        const title = document.createElement('div');
        title.className = 'edit-modal-title';
        title.innerHTML = '<span>Edit Produk</span><button type="button" class="edit-modal-close" aria-label="Tutup">&times;</button>';
        form.prepend(title);
        title.querySelector('button').addEventListener('click', closeEdit);
    });
});
</script>
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <div class="brand"><span class="brand-mark">🛒</span><div><strong>{{ $namaToko }}</strong><small>Admin Utama</small></div></div>
        <nav class="nav">
            <a href="{{ route('admin.dashboard') }}"><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg></span><span>Dashboard</span></a>
            <a class="active" href="{{ route('admin.produk') }}"><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 8l-9-5-9 5v8l9 5 9-5V8z"/><path d="M3 8l9 5 9-5"/><path d="M12 13v8"/></svg></span><span>Produk</span></a>
            <a href="{{ route('admin.kategori') }}"><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41L11 3.83A2 2 0 0 0 9.5 3H4a1 1 0 0 0-1 1v5.5a2 2 0 0 0 .59 1.41l9.58 9.59a2 2 0 0 0 2.82 0l4.6-4.6a2 2 0 0 0 0-2.99z"/><circle cx="7.5" cy="7.5" r="1.2"/></svg></span><span>Kategori</span></a>
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
        <header class="heading"><div><h1>Produk</h1><p>Kelola data produk, stok, harga, dan foto.</p></div><div class="date">{{ now()->translatedFormat('l, d F Y') }}</div></header>
        @if(session('success')) <div class="alert success" role="status">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="alert error">{{ session('error') }}</div> @endif
        @if($errors->any()) <div class="alert error"><strong>Data belum disimpan:</strong> {{ $errors->first() }}</div> @endif
        <section class="panel">
            <div class="product-head">
                <h2>Data Produk</h2>
                <div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap">
                    <div class="admin-search-wrapper" style="position:relative;display:flex;align-items:center;background:#fbfcfe;border:1px solid #d8e0eb;border-radius:8px;padding:0 12px;height:38px;width:240px;transition:all .2s ease;">
                        <span style="font-size:13px;color:#8090a6;margin-right:8px;display:flex;align-items:center;line-height:1;">🔍</span>
                        <span style="width:1px;height:16px;background:#c0cbd9;margin-right:10px;display:inline-block;flex-shrink:0;"></span>
                        <input type="text" id="cari-produk-admin" placeholder="Cari produk..." style="border:none;outline:none;background:transparent;font-size:13px;width:100%;color:var(--ink);" onfocus="this.parentElement.style.borderColor='#1e3a5f';this.parentElement.style.background='#fff'" onblur="this.parentElement.style.borderColor='#d8e0eb';this.parentElement.style.background='#fbfcfe'">
                    </div>
                    <select id="filter-kategori-admin" style="border:1px solid #d8e0eb;border-radius:8px;padding:0 12px;height:38px;font-size:13px;outline:none;background:#fbfcfe;color:var(--ink);">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoriProduk as $k)
                            <option value="{{ $k }}">{{ $k }}</option>
                        @endforeach
                    </select>
                    <a href="{{ route('admin.produk.tambah') }}">+ Tambah Produk</a>
                </div>
            </div>
            <div class="admin-product-grid">
            @forelse($produk as $item)
                <article class="admin-product-card" data-kategori="{{ $item->kategori }}">
                    <div class="admin-product-image">@if($item->foto)<img src="{{ asset('storage/'.$item->foto) }}" alt="{{ $item->nama_produk }}">@else<span>📦</span>@endif</div>
                    <strong class="admin-product-name">{{ $item->nama_produk }}</strong>
                    <span class="admin-product-price">Rp {{ number_format($item->harga,0,',','.') }}</span>
                    <span class="admin-product-stock">{{ $item->kategori }}</span>
                    <span class="admin-product-stock">Stok: {{ $item->stok }}</span>
                    <div class="admin-product-actions"><button type="button" class="btn btn-edit" onclick="toggleEdit({{ $item->id }})">Edit</button><form class="inline" method="POST" action="{{ route('admin.produk.destroy',$item->id) }}" onsubmit="return confirm('Hapus produk {{ addslashes($item->nama_produk) }}?')">@csrf @method('DELETE')<button class="btn btn-danger" type="submit" title="Hapus produk" aria-label="Hapus produk"><svg class="trash-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 7h16M10 11v6M14 11v6M6 7l1 13h10l1-13M9 7l1-3h4l1 3"/></svg></button></form></div>
                    <form id="edit-{{ $item->id }}" class="edit-form" method="POST" action="{{ route('admin.produk.update',$item->id) }}" enctype="multipart/form-data">@csrf @method('PUT')<div class="field"><label>Barcode</label><input name="barcode" value="{{ $item->barcode }}" required></div><div class="field"><label>Nama Produk</label><input name="nama_produk" value="{{ $item->nama_produk }}" required></div><div class="field"><label>Harga</label><input type="number" name="harga" value="{{ $item->harga }}" required></div><div class="field"><label>Stok</label><input type="number" name="stok" value="{{ $item->stok }}" required></div><div class="field file-field"><label>Ganti Foto</label><input type="file" name="foto" accept="image/*"></div><button class="btn btn-primary" type="submit">Simpan</button></form>
                </article>
            @empty
                <div class="empty">Belum ada produk.</div>
            @endforelse
            </div>
            <div class="table-wrap"><table><thead><tr><th>#</th><th>Foto</th><th>Barcode</th><th>Nama Produk</th><th>Harga</th><th>Stok</th><th>Aksi</th></tr></thead><tbody>
            @forelse($produk as $i => $item)
                <tr><td>{{ $i+1 }}</td><td>@if($item->foto)<img class="thumb" src="{{ asset('storage/'.$item->foto) }}" alt="{{ $item->nama_produk }}">@else<span class="no-photo">Tanpa foto</span>@endif</td><td>{{ $item->barcode }}</td><td><strong>{{ $item->nama_produk }}</strong></td><td>Rp {{ number_format($item->harga,0,',','.') }}</td><td>@if($item->stok <= 0)<span class="badge badge-out">Habis</span>@elseif($item->stok <= 7)<span class="badge badge-low">{{ $item->stok }}</span>@else<span class="badge badge-ok">{{ $item->stok }}</span>@endif</td><td><div class="actions"><button type="button" class="btn btn-edit" onclick="toggleEdit({{ $item->id }})">Edit</button><form class="inline" method="POST" action="{{ route('admin.produk.destroy',$item->id) }}" onsubmit="return confirm('Hapus produk {{ addslashes($item->nama_produk) }}?')">@csrf @method('DELETE')<button class="btn btn-danger" type="submit" title="Hapus produk" aria-label="Hapus produk"><svg class="trash-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 7h16M10 11v6M14 11v6M6 7l1 13h10l1-13M9 7l1-3h4l1 3"/></svg></button></form></div><form id="edit-{{ $item->id }}" class="edit-form" method="POST" action="{{ route('admin.produk.update',$item->id) }}" enctype="multipart/form-data">@csrf @method('PUT')<div class="field"><label>Barcode</label><input name="barcode" value="{{ $item->barcode }}" required></div><div class="field"><label>Nama Produk</label><input name="nama_produk" value="{{ $item->nama_produk }}" required></div><div class="field"><label>Harga</label><input type="number" name="harga" value="{{ $item->harga }}" required></div><div class="field"><label>Stok</label><input type="number" name="stok" value="{{ $item->stok }}" required></div><div class="field file-field"><label>Ganti Foto</label><input type="file" name="foto" accept="image/*"></div><button class="btn btn-primary" type="submit">Simpan</button></form></td></tr>
            @empty
                <tr><td colspan="7" class="empty">Belum ada produk.</td></tr>
            @endforelse
            </tbody></table></div>
        </section>
    </main>
</div>
<script>
const kategoriProduk = @json($kategoriProduk);
document.querySelectorAll('.edit-form').forEach(form => {
    const namaField = form.querySelector('[name="nama_produk"]')?.closest('.field');
    if (!namaField) return;
    const field = document.createElement('div');
    field.className = 'field';
    field.innerHTML = '<label>Kategori</label><select name="kategori" required>' + kategoriProduk.map(kategori => `<option value="${kategori}">${kategori}</option>`).join('') + '</select>';
    namaField.after(field);
    field.querySelector('select').value = form.closest('.admin-product-card')?.dataset.kategori || 'Lainnya';
});

// Fitur Pencarian & Filter Kategori Real-Time Produk Admin
const inputCariAdmin = document.getElementById('cari-produk-admin');
const filterKatAdmin = document.getElementById('filter-kategori-admin');

function filterProdukAdmin() {
    const q = (inputCariAdmin?.value || '').toLowerCase().trim();
    const kat = (filterKatAdmin?.value || '').toLowerCase().trim();
    let visibleGridCount = 0;

    const cards = document.querySelectorAll('.admin-product-card');
    cards.forEach(card => {
        const nama = (card.querySelector('.admin-product-name')?.textContent || '').toLowerCase();
        const barcode = (card.querySelector('input[name="barcode"]')?.value || '').toLowerCase();
        const kategori = (card.dataset.kategori || '').toLowerCase();

        const matchQ = !q || nama.includes(q) || barcode.includes(q);
        const matchKat = !kat || kategori === kat;

        const isMatch = matchQ && matchKat;
        card.style.display = isMatch ? '' : 'none';
        if (isMatch) visibleGridCount++;
    });

    let emptyGrid = document.getElementById('grid-empty-search');
    if (!emptyGrid && cards.length > 0) {
        emptyGrid = document.createElement('div');
        emptyGrid.id = 'grid-empty-search';
        emptyGrid.className = 'empty';
        emptyGrid.style.gridColumn = '1 / -1';
        emptyGrid.style.display = 'none';
        emptyGrid.textContent = 'Produk tidak ditemukan.';
        document.querySelector('.admin-product-grid')?.appendChild(emptyGrid);
    }
    if (emptyGrid) {
        emptyGrid.style.display = (visibleGridCount === 0 && cards.length > 0) ? 'block' : 'none';
    }

    const tableRows = document.querySelectorAll('.table-wrap table tbody tr');
    tableRows.forEach(row => {
        if (row.querySelector('.empty')) return;
        const text = row.textContent.toLowerCase();
        const matchQ = !q || text.includes(q);
        row.style.display = matchQ ? '' : 'none';
    });
}

inputCariAdmin?.addEventListener('input', filterProdukAdmin);
filterKatAdmin?.addEventListener('change', filterProdukAdmin);
</script>
</body>
</html>