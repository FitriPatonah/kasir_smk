<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dashboard Admin - {{{ $namaToko }}}</title>

<style>
:root{
    --blue:#1e3a5f;
    --ink:#222;
    --muted:#708099;
    --line:#e6ebf2;
    --page:#eef2f5;
}

*{
    box-sizing:border-box;
}

body{
    margin:0;
    background:var(--page);
    font-family:"Segoe UI",Arial,sans-serif;
    color:var(--ink);
}

.layout{
    display:flex;
    min-height:100vh;
}

.sidebar{
    width:234px;
    flex:0 0 234px;
    background:var(--blue);
    color:#fff;
    display:flex;
    flex-direction:column;
    position:sticky;
    top:0;
    align-self:flex-start;
    height:100vh;
    overflow-y:auto;
}

.brand{
    height:84px;
    padding:22px 24px;
    display:flex;
    gap:12px;
    align-items:center;
}

.brand-mark{width:36px;height:36px;display:grid;place-items:center;border-radius:8px;background:rgba(255,255,255,.18);font-size:22px;}

.brand strong{
    display:block;
    font-size:15px;
}

.brand small{
    display:block;
    margin-top:3px;
    color:#d4e3ff;
    font-size:12px;
}

.nav{
    padding:9px 12px;
}

.nav a{
    display:flex;
    align-items:center;
    gap:13px;
    color:#dce9ff;
    text-decoration:none;
    padding:12px 16px;
    border-radius:9px;
    font-size:14px;
    margin:3px 0;
}

.nav a:hover,
.nav a.active{
    background:rgba(255,255,255,.2);
    color:#fff;
}

.nav-icon{
    width:18px;
    text-align:center;
    font-size:19px;
}.nav-icon svg{width:18px;height:18px;display:block}

.nav-arrow{
    margin-left:auto;
    font-size:11px;
    color:#9db3d1;
    transition:transform .15s ease;
}

.nav-arrow.down{
    transform:rotate(90deg);
}

.nav-submenu{
    margin:2px 0 6px 33px;
    display:flex;
    flex-direction:column;
    gap:2px;
}

.nav-submenu a{
    padding:8px 10px;
    font-size:13px;
    border-radius:7px;
    color:#c7d7ee;
    text-decoration:none;
    display:block;
}

.nav-submenu a:hover{
    background:rgba(255,255,255,.12);
    color:#fff;
}

.nav-submenu a.active{
    background:rgba(255,255,255,.2);
    color:#fff;
    font-weight:700;
}

.sidebar-spacer{
    flex:1;
}

.logout{
    border-top:1px solid rgba(255,255,255,.18);
    padding:14px 12px;
}

.logout a{
    margin:0;
    color:#fff;
    text-decoration:none;
    display:flex;
    align-items:center;
    gap:13px;
    padding:12px 16px;
    border-radius:9px;
    font-size:14px;
}

.logout a:hover{
    background:rgba(255,255,255,.15);
}

.main{
    flex:1;
    min-width:0;
    padding:25px 31px 38px;
}

.heading{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    margin:0 0 25px;
}

.heading h1{
    font-size:27px;
    margin:0 0 4px;
}

.heading p{
    margin:0;
    color:var(--muted);
    font-size:16px;
}

.date{
    color:var(--muted);
    font-size:13px;
    padding-top:8px;
}

.stats{
    display:grid;
    grid-template-columns:repeat(4,minmax(0,1fr));
    gap:14px;
    margin-bottom:22px;
}

.stat,
.panel{
    background:#fff;
    border:1px solid var(--line);
    border-radius:13px;
    box-shadow:0 2px 5px rgba(23,36,58,.04);
}

.stat{
    padding:22px 20px;
    min-height:144px;
    position:relative;
}

.stat small{
    display:block;
    color:var(--muted);
    font-size:14px;
    margin-bottom:8px;
}

.stat strong{
    font-size:23px;
}

.stat-icon{
    position:absolute;
    right:20px;
    top:47px;
    width:48px;
    height:48px;
    border-radius:13px;
    display:grid;
    place-items:center;
    font-size:25px;
}

.icon-blue{
    background:#e8f0ff;
    color:#1670f5;
}

.icon-orange{
    background:#fff0e8;
    color:#ff6816;
}

.icon-green{
    background:#dcfae9;
    color:#00ae4f;
}

.icon-purple{
    background:#f1e4ff;
    color:#9329ee;
}

.content-grid{
    display:grid;
    grid-template-columns:minmax(0,2fr) minmax(270px,.95fr);
    gap:22px;
    margin-bottom:22px;
}

.panel{
    padding:25px;
    overflow:hidden;
}

.panel h2{
    font-size:16px;
    margin:0 0 28px;
}

.chart{
    height:234px;
    display:flex;
    align-items:stretch;
    gap:14px;
    position:relative;
    padding:0 4px 27px 34px;
}

.chart:before{
    content:"";
    position:absolute;
    inset:0 0 27px 34px;
    background:repeating-linear-gradient(
        to bottom,
        transparent 0,
        transparent 59px,
        #e3eaf3 60px
    );
    border-left:1px solid #8f9baa;
    border-bottom:1px solid #8f9baa;
}

.y-labels{
    position:absolute;
    left:0;
    top:-5px;
    bottom:27px;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
    color:#7e8997;
    font-size:11px;
}

.bar-item{
    flex:1;
    display:flex;
    flex-direction:column;
    justify-content:flex-end;
    align-items:center;
    z-index:1;
}

.bar{
    width:min(58px,70%);
    background:#2b65e9;
    border-radius:4px 4px 0 0;
    min-height:3px;
}

.bar-label{
    font-size:11px;
    color:#687587;
    margin-top:8px;
}

.chart-note{
    font-size:12px;
    color:var(--muted);
    margin:10px 0 0 34px;
}

.donut-wrap{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:22px;
    min-height:230px;
}

.donut{
    width:158px;
    height:158px;
    border-radius:50%;
    background:conic-gradient(
        #2865e9 0 71%,
        #18bd5b 71% 86%,
        #ff6b19 86% 100%
    );
    position:relative;
}

.donut:after{
    content:"";
    position:absolute;
    background:#fff;
    width:91px;
    height:91px;
    border-radius:50%;
    inset:33.5px;
}

.legend{
    font-size:13px;
    color:#66758a;
    line-height:2;
}

.legend span{
    display:inline-block;
    width:9px;
    height:9px;
    border-radius:2px;
    margin-right:7px;
}

.legend strong{
    color:var(--ink);
    font-weight:600;
}

.product-panel{
    padding:25px;
}

.product-head{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:17px;
}

.product-head h2{
    margin:0;
}

.product-head a{
    color:var(--blue);
    font-size:13px;
    text-decoration:none;
    font-weight:600;
}

.table-wrap{
    overflow-x:auto;
}

table{
    width:100%;
    border-collapse:collapse;
}

th,
td{
    text-align:left;
    padding:13px 10px;
    border-bottom:1px solid #edf0f5;
    font-size:13px;
    white-space:nowrap;
}

th{
    color:#8995a7;
    font-weight:600;
    font-size:12px;
}

td strong{
    font-weight:600;
}

.badge{
    padding:5px 10px;
    border-radius:20px;
    font-size:11px;
    font-weight:700;
}

.badge-ok{
    background:#e5f9ed;
    color:#11914a;
}

.badge-low{
    background:#fff5d9;
    color:#ae7900;
}

.badge-out{
    background:#ffebeb;
    color:#d44343;
}

.actions{
    display:flex;
    gap:7px;
}

.btn{
    border:0;
    border-radius:7px;
    padding:7px 10px;
    font-weight:600;
    cursor:pointer;
    text-decoration:none;
    font-size:12px;
}

.btn-edit{
    background:#eaf1ff;
    color:#2865e9;
}

.btn-danger{
    background:#ffeded;
    color:#d44343;
}

.edit-form{
    display:none;
    background:#f7f9fc;
    padding:12px;
    border-radius:8px;
    margin-top:9px;
    gap:8px;
    align-items:end;
}

.edit-form.show{
    display:grid;
    grid-template-columns:repeat(5,1fr);
}

.field label{
    display:block;
    font-size:11px;
    color:#758196;
    margin-bottom:5px;
}

.field input{
    width:100%;
    padding:8px;
    border:1px solid #d7dfeb;
    border-radius:6px;
}

.btn-primary{
    background:var(--blue);
    color:#fff;
}

.alert{
    padding:12px 15px;
    border-radius:8px;
    margin-bottom:16px;
    font-size:13px;
}

.success{
    background:#e8f8ee;
    color:#168747;
}

.error{
    background:#ffeded;
    color:#c33d3d;
}

.inline{
    display:inline;
}

@media(max-width:1050px){

    .stats{
        grid-template-columns:repeat(2,1fr);
    }

    .content-grid{
        grid-template-columns:1fr;
    }

    .edit-form.show{
        grid-template-columns:repeat(2,1fr);
    }
}

@media(max-width:680px){

    .sidebar{
        width:62px;
        flex-basis:62px;
    }

    .brand{
        padding:18px 17px;
    }

    .brand div,
    .nav a span:not(.nav-icon),
    .logout a span{
        display:none;
    }

    .nav a{
        justify-content:center;
        padding:12px 8px;
    }

    .main{
        padding:20px 15px;
    }

    .heading{
        display:block;
    }

    .date{
        padding-top:12px;
    }

    .stats{
        grid-template-columns:1fr;
    }

    .stat{
        min-height:122px;
    }

    .content-grid{
        gap:15px;
    }

    .panel{
        padding:18px;
    }

    .donut-wrap{
        gap:12px;
    }

    .donut{
        width:125px;
        height:125px;
    }

    .donut:after{
        width:72px;
        height:72px;
        inset:26.5px;
    }

    .edit-form.show{
        grid-template-columns:1fr;
    }
}
</style>

<script>
function toggleEdit(id){
    const element = document.getElementById('edit-' + id);

    if(element){
        element.classList.toggle('show');
    }
}
</script>

</head>

<body>

<div class="layout">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="brand"><span class="brand-mark">🛒</span><div><strong>{{ $namaToko }}</strong><small>Admin Utama</small></div></div>
        <nav class="nav">
            <a class="active" href="{{ route('admin.dashboard') }}"><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg></span><span>Dashboard</span></a>
            <a href="{{ route('admin.produk') }}"><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 8l-9-5-9 5v8l9 5 9-5V8z"/><path d="M3 8l9 5 9-5"/><path d="M12 13v8"/></svg></span><span>Produk</span></a>
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


    <!-- MAIN CONTENT -->
    <main class="main">

        <!-- HEADER -->
        <header class="heading">

            <div>

                <h1>Dashboard</h1>

                <p>Selamat datang, Admin Utama</p>

            </div>

            <div class="date">
                {{ now()->translatedFormat('l, d F Y') }}
            </div>

        </header>


        <!-- ALERT SUCCESS -->
        @if(session('success'))

            <div class="alert success">
                {{ session('success') }}
            </div>

        @endif


        <!-- ALERT ERROR -->
        @if(session('error'))

            <div class="alert error">
                {{ session('error') }}
            </div>

        @endif


        <!-- VALIDATION ERROR -->
        @if($errors->any())

            <div class="alert error">

                <strong>Data belum disimpan:</strong>

                {{ $errors->first() }}

            </div>

        @endif


        <!-- STATISTIK -->
        <section class="stats">

            <!-- Pendapatan Hari Ini -->
            <div class="stat">

                <small>Pendapatan Hari Ini</small>

                <strong>
                    Rp {{ number_format($omzetHariIni,0,',','.') }}
                </strong>

                <span class="stat-icon icon-blue">
                    $
                </span>

            </div>


            <!-- Transaksi Hari Ini -->
            <div class="stat">

                <small>Transaksi Hari Ini</small>

                <strong>
                    {{ number_format($transaksiHariIni,0,',','.') }}
                </strong>

                <span class="stat-icon icon-orange">
                    ⌑
                </span>

            </div>


            <!-- Total Produk -->
            <div class="stat">

                <small>Total Produk</small>

                <strong>
                    {{ number_format($jumlahProduk,0,',','.') }}
                </strong>

                <span class="stat-icon icon-green">
                    ◇
                </span>

            </div>


            <!-- Total Pendapatan -->
            <div class="stat">

                <small>Total Pendapatan</small>

                <strong>
                    Rp {{ number_format($totalPendapatan,0,',','.') }}
                </strong>

                <span class="stat-icon icon-purple">
                    ↗
                </span>

            </div>

        </section>


        <!-- GRAFIK + PRODUK TERLARIS -->
        <section class="content-grid">

            <!-- Grafik Penjualan -->
            <div class="panel">

                <h2>
                    Penjualan 7 Hari Terakhir
                </h2>

                <div class="chart">

                    <div class="y-labels">

                        <span>
                            Rp{{ number_format($maxPenjualan,0,',','.') }}
                        </span>

                        <span>
                            Rp{{ number_format($maxPenjualan*0.75,0,',','.') }}
                        </span>

                        <span>
                            Rp{{ number_format($maxPenjualan*0.5,0,',','.') }}
                        </span>

                        <span>
                            Rp{{ number_format($maxPenjualan*0.25,0,',','.') }}
                        </span>

                        <span>
                            0
                        </span>

                    </div>


                    @foreach($penjualan7Hari as $i => $nilai)

                        <div class="bar-item">

                            <div
                                class="bar"
                                style="height:{{ max(($nilai / $maxPenjualan) * 200, 3) }}px"
                                title="Rp {{ number_format($nilai,0,',','.') }}"
                            ></div>

                            <span class="bar-label">
                                {{ $labelHari[$i] }}
                            </span>

                        </div>

                    @endforeach

                </div>

                <p class="chart-note">
                    Data asli dari transaksi 7 hari terakhir
                </p>

            </div>


            <!-- PRODUK TERLARIS -->
            <div class="panel">

                <h2>
                    🏆 Produk Terlaris Bulan Ini
                </h2>


                @forelse($produkTerlaris as $item)

                    <div style="margin-bottom:14px;">

                        <div
                            style="
                                display:flex;
                                justify-content:space-between;
                                font-size:13px;
                                margin-bottom:5px;
                            "
                        >

                            <span>
                                {{ $item->nama_produk }}
                            </span>

                            <strong>
                                {{ $item->total_qty }} terjual
                            </strong>

                        </div>


                        <div
                            style="
                                background:#f0f3f7;
                                border-radius:6px;
                                height:8px;
                                overflow:hidden;
                            "
                        >

                            <div
                                style="
                                    background:#2b65e9;
                                    height:100%;
                                    width:{{ ($item->total_qty / $maxTerlaris) * 100 }}%;
                                "
                            ></div>

                        </div>

                    </div>

                @empty

                    <p style="color:#999;font-size:13px;">
                        Belum ada transaksi bulan ini.
                    </p>

                @endforelse

            </div>

        </section>

    </main>

</div>

</body>
</html>