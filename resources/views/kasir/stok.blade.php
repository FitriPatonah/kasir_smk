<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Stok Produk - {{ $namaToko }}</title>
<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
<link rel="stylesheet" href="{{ asset('css/kasir.css') }}">
<style>
    .stok-heading { display: flex; justify-content: space-between; align-items: flex-start; margin: 0 0 18px; flex-wrap: wrap; gap: 10px; }
    .stok-heading h1 { font-size: 22px; margin: 0 0 4px; color: #1e3a5f; }
    .stok-heading p { margin: 0; color: #708099; font-size: 14px; }
    .stok-heading .tanggal { color: #708099; font-size: 13px; padding-top: 6px; }

    .stok-panel-head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 12px; }
    .stok-panel-head h2 { font-size: 15px; margin: 0; color: #222; }
    .stok-search { position: relative; display: flex; align-items: center; background: #fbfcfe; border: 1px solid #d8e0eb; border-radius: 8px; padding: 0 12px; height: 38px; width: 240px; transition: all .2s ease; }
    .stok-search span.ikon { font-size: 13px; color: #8090a6; margin-right: 8px; display: flex; align-items: center; line-height: 1; }
    .stok-search .pemisah { width: 1px; height: 16px; background: #c0cbd9; margin-right: 10px; display: inline-block; flex-shrink: 0; }
    .stok-search input { border: none; outline: none; background: transparent; font-size: 13px; width: 100%; color: #222; }

    .tabel-stok { width: 100%; border-collapse: collapse; }
    .tabel-stok th, .tabel-stok td { padding: 12px 10px; text-align: left; border-bottom: 1px solid #eee; font-size: 14px; white-space: nowrap; }
    .tabel-stok th { background: #f5f7fa; color: #708099; font-size: 12px; font-weight: 600; }
    .tabel-stok .table-wrap { overflow-x: auto; }
    .thumb-stok { width: 40px; height: 40px; object-fit: cover; border-radius: 7px; border: 1px solid #eee; }
    .no-photo { color: #aeb8c7; font-size: 12px; }
    .stock-num { font-weight: 700; font-size: 15px; color: #222; }
    .empty { color: #999; text-align: center; padding: 40px 0; }

    .badge-stok { display: inline-block; border-radius: 20px; padding: 4px 11px; font-size: 12px; font-weight: 600; }
    .badge-out { background: #fff0f0; color: #c53737; }
    .badge-low { background: #fff7df; color: #a26a00; }
    .badge-ok { background: #e5f8ed; color: #14733b; }


</style>
</head>
<body>
<div class="app">
@include('kasir.partials.sidebar', ['active' => 'stok'])

<main class="main" style="grid-template-columns: 1fr;">
    <div>
        <header class="stok-heading">
            <div>
                <h1>Stok Produk</h1>
                <p>Informasi ketersediaan stok produk persediaan toko.</p>
            </div>
            <div class="tanggal">{{ now()->translatedFormat('l, d F Y') }}</div>
        </header>



        <div class="panel">
            <div class="stok-panel-head">
                <h2>Data Stok Produk ({{ $produk->count() }})</h2>
                <div class="stok-search">
                    <span class="ikon"><svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg></span>
                    <span class="pemisah"></span>
                    <input type="text" id="cari-stok" placeholder="Cari produk..." onfocus="this.parentElement.style.borderColor='#1e3a5f';this.parentElement.style.background='#fff'" onblur="this.parentElement.style.borderColor='#d8e0eb';this.parentElement.style.background='#fbfcfe'">
                </div>
            </div>

            <div class="table-wrap">
                <table id="tabel-stok" class="tabel-stok">
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
                                        <img class="thumb-stok" src="{{ asset('storage/'.$item->foto) }}" alt="{{ $item->nama_produk }}">
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
                                        <span class="badge-stok badge-out">Habis</span>
                                    @elseif($item->stok <= 5)
                                        <span class="badge-stok badge-low">Stok Menipis ({{ $item->stok }})</span>
                                    @else
                                        <span class="badge-stok badge-ok">Tersedia</span>
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
        </div>
    </div>
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
