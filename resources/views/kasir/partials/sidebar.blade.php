{{--
    Sidebar bersama untuk semua halaman kasir.
    Pakai: @include('kasir.partials.sidebar', ['active' => 'kasir'])
    Nilai $active yang valid: 'kasir', 'riwayat', 'stok', 'profil'
--}}
<aside class="sidebar">
    <div class="brand"><span class="brand-mark">🛒</span><div><strong>{{ $namaToko }}</strong><small>{{ auth('kasir')->user()->name }}</small></div></div>
    <nav class="side-nav">
        <a class="{{ $active === 'kasir' ? 'active' : '' }}" href="{{ route('kasir.index') }}"><span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 4h2l2.2 12.4a2 2 0 0 0 2 1.6h8.1a2 2 0 0 0 2-1.6L21 8H6.2"/><circle cx="9.5" cy="20.5" r="1.4"/><circle cx="17" cy="20.5" r="1.4"/></svg></span> Kasir</a>
        <a class="{{ $active === 'riwayat' ? 'active' : '' }}" href="{{ route('kasir.riwayat') }}"><span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.5 2"/></svg></span> Riwayat</a>
        <a class="{{ $active === 'stok' ? 'active' : '' }}" href="{{ route('kasir.stok') }}"><span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="5" rx="1"/><path d="M4 9v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9"/><path d="M10 13h4"/></svg></span> Stok</a>
        <a class="{{ $active === 'profil' ? 'active' : '' }}" href="{{ route('kasir.profil') }}"><span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></span> Profil</a>
    </nav>
    <div class="logout-wrapper">
        <a class="logout-link" href="{{ route('auth.logout', ['role'=>'kasir']) }}"><span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/></svg></span> Keluar</a>
    </div>
</aside>
