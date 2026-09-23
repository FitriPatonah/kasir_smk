{{--
    Sidebar bersama untuk halaman-halaman admin.
    Pakai: @include('admin.partials.sidebar', ['active' => 'dashboard'])
    Nilai $active yang valid:
      'dashboard' | 'produk' | 'kategori' | 'supplier' | 'stok'
      'laporan' (menu "Transaksi") | 'riwayat-transaksi' (menu "Laporan")
      'kelola-user' | 'pengaturan'

    Catatan: resources/views/transaksi/index.blade.php dan
    resources/views/stok/index.blade.php SENGAJA tidak dipindah ke partial
    ini karena keduanya dipakai bersama oleh role admin & kasir (logic-nya
    beda, jadi lebih aman dibiarkan terpisah).
--}}
<aside class="sidebar">
    <div class="brand"><span class="brand-mark">🛒</span><div><strong>{{ $namaToko }}</strong><small>Admin Utama</small></div></div>
    <nav class="nav">
        <a class="{{ $active === 'dashboard' ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg></span><span>Dashboard</span></a>
        <a class="{{ $active === 'produk' ? 'active' : '' }}" href="{{ route('admin.produk') }}"><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 8l-9-5-9 5v8l9 5 9-5V8z"/><path d="M3 8l9 5 9-5"/><path d="M12 13v8"/></svg></span><span>Produk</span></a>
        <a class="{{ $active === 'kategori' ? 'active' : '' }}" href="{{ route('admin.kategori') }}"><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41L11 3.83A2 2 0 0 0 9.5 3H4a1 1 0 0 0-1 1v5.5a2 2 0 0 0 .59 1.41l9.58 9.59a2 2 0 0 0 2.82 0l4.6-4.6a2 2 0 0 0 0-2.99z"/><circle cx="7.5" cy="7.5" r="1.2"/></svg></span><span>Kategori</span></a>
        <a class="{{ $active === 'supplier' ? 'active' : '' }}" href="{{ route('admin.supplier') }}"><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 3v5h-7z"/><circle cx="5.5" cy="18.5" r="2"/><circle cx="18" cy="18.5" r="2"/></svg></span><span>Supplier</span></a>
        <a class="{{ $active === 'stok' ? 'active' : '' }}" href="{{ route('admin.stok') }}"><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="5" rx="1"/><path d="M4 9v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9"/><path d="M10 13h4"/></svg></span><span>Stok</span></a>
        <a class="{{ $active === 'laporan' ? 'active' : '' }}" href="{{ route('admin.transaksi') }}"><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2h9l3 3v17H6z"/><path d="M9 8h6M9 12h6M9 16h4"/></svg></span><span>Transaksi</span></a>
        <a class="{{ $active === 'riwayat-transaksi' ? 'active' : '' }}" href="{{ route('admin.laporan') }}"><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M18 20V10"/><path d="M12 20V4"/><path d="M6 20v-6"/></svg></span><span>Laporan</span></a>
        <a class="{{ $active === 'kelola-user' ? 'active' : '' }}" href="{{ route('admin.kelola-user') }}"><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></span><span>Kelola User</span></a>
        <a class="{{ $active === 'pengaturan' ? 'active' : '' }}" href="{{ route('admin.pengaturan') }}"><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg></span><span>Pengaturan</span></a>
    </nav>
    <div class="sidebar-spacer"></div>
    <div class="logout"><a href="{{ route('auth.logout', ['role' => 'admin']) }}"><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/></svg></span><span>Keluar</span></a></div>
</aside>
