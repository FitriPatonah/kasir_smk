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

.brand-mark{
    width:36px;
    height:36px;
    display:grid;
    place-items:center;
    border-radius:8px;
    background:rgba(255,255,255,.18);
    font-size:22px;
}

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
}

.nav-icon svg{
    width:18px;
    height:18px;
    display:block;
}

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
    grid-template-columns:minmax(0,1.7fr) minmax(340px,1.15fr);
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


/* =========================================================
   GRAFIK PENJUALAN
   ========================================================= */

.chart{
    height:215px;
    display:flex;
    align-items:stretch;
    gap:14px;
    position:relative;
    padding:10px 4px 30px 72px;
}


/* Area garis grafik grid */
.chart::before{
    content:"";
    position:absolute;

    top:10px;
    right:4px;
    bottom:30px;
    left:72px;

    /*
       Garis horizontal 100%, 75%, 50%, 25%
       berwarna HITAM dan putus-putus.
    */
    background:
        repeating-linear-gradient(
            to right,
            #000 0,
            #000 5px,
            transparent 5px,
            transparent 10px
        )
        0 0 / 100% 1px no-repeat,

        repeating-linear-gradient(
            to right,
            #000 0,
            #000 5px,
            transparent 5px,
            transparent 10px
        )
        0 25% / 100% 1px no-repeat,

        repeating-linear-gradient(
            to right,
            #000 0,
            #000 5px,
            transparent 5px,
            transparent 10px
        )
        0 50% / 100% 1px no-repeat,

        repeating-linear-gradient(
            to right,
            #000 0,
            #000 5px,
            transparent 5px,
            transparent 10px
        )
        0 75% / 100% 1px no-repeat;

    /* Garis vertikal kiri sumbu Y (hitam) */
    border-left:1.5px solid #000;

    pointer-events:none;
    z-index:1;
}


/* Garis dasar (sumbu X / garis 0) ditegaskan dengan hitam & z-index tinggi agar TIDAK tertutup batang */
.chart::after{
    content:"";
    position:absolute;

    left:72px;
    right:4px;
    bottom:30px;

    height:2px;
    background:#000;

    pointer-events:none;
    z-index:10;
}


/* Label nilai Y */

.y-labels{
    position:absolute;

    left:0;
    top:4px;
    bottom:30px;

    width:64px;

    text-align:right;
    padding-right:8px;

    box-sizing:border-box;

    display:flex;
    flex-direction:column;
    justify-content:space-between;

    color:#000;
    font-size:11px;
    font-weight:600;

    z-index:10;
}


/* Batang grafik */

.bar-item{
    flex:1;

    display:flex;
    flex-direction:column;
    justify-content:flex-end;
    align-items:center;

    position:relative;

    z-index:2;
}

.bar{
    width:min(52px,65%);

    background:var(--bar-color,#1e3a5f);

    border-radius:6px 6px 0 0;

    min-height:3px;

    transition:transform .2s ease, opacity .2s ease;
}

.bar:hover{
    opacity:.88;
    transform:translateY(-2px);
}

.bar-label{
    position:absolute;
    top:calc(100% + 8px);

    font-size:12px;
    font-weight:600;
    color:#000;

    white-space:nowrap;
    text-align:center;
    z-index:10;
}

.chart-note{
    font-size:12px;
    color:var(--muted);
    margin:14px 0 0 72px;
}


/* =========================================================
   DONUT
   ========================================================= */

.donut-wrap{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:18px;
    min-height:230px;
    width:100%;
}

.donut{
    width:158px;
    height:158px;
    min-width:158px;
    min-height:158px;
    flex:0 0 158px;
    aspect-ratio:1 / 1;

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


.donut-tooltip{
    position:fixed;
    z-index:9999;
    display:none;
    pointer-events:none;
    background:#1f2937;
    color:#fff;
    padding:7px 10px;
    border-radius:6px;
    font-size:12px;
    line-height:1.35;
    white-space:nowrap;
    box-shadow:0 4px 12px rgba(0,0,0,.15);
}

.donut-tooltip strong{
    font-weight:600;
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


/* =========================================================
   PRODUK TERLARIS (RANKING LIST)
   ========================================================= */

.top-product-list{
    display:flex;
    flex-direction:column;
    gap:16px;
}

.top-product-item{
    display:flex;
    flex-direction:column;
    gap:7px;
}

.top-product-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:12px;
}

.top-product-info{
    display:flex;
    align-items:center;
    gap:10px;
    min-width:0;
    flex:1;
}

.rank-badge{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    font-size:16px;
    line-height:1;
    flex-shrink:0;
}

.rank-1{
    font-size:20px;
    filter:drop-shadow(0 1px 2px rgba(234,179,8,0.45));
}

.rank-2{
    font-size:20px;
    filter:drop-shadow(0 1px 2px rgba(148,163,184,0.45));
}

.rank-3{
    font-size:20px;
    filter:drop-shadow(0 1px 2px rgba(180,83,9,0.45));
}

.rank-normal{
    font-size:13px;
    font-weight:700;
    color:var(--muted);
    min-width:20px;
    text-align:center;
}

.top-product-name{
    font-size:14px;
    font-weight:600;
    color:var(--ink);
    overflow:hidden;
    text-overflow:ellipsis;
    white-space:nowrap;
}

.top-product-qty{
    font-size:13px;
    color:var(--ink);
    white-space:nowrap;
    text-align:right;
    flex-shrink:0;
}

.top-product-qty strong{
    font-weight:700;
    color:#1e3a5f;
    font-size:14px;
}

.top-product-qty small{
    color:var(--muted);
    font-size:12px;
    margin-left:2px;
}

.top-product-track{
    background:#eef2f6;
    border-radius:999px;
    height:9px;
    overflow:hidden;
    width:100%;
    position:relative;
}

.top-product-fill{
    background:#1e3a5f;
    height:100%;
    border-radius:999px;
    transition:width 0.4s ease;
}

.top-product-empty{
    text-align:center;
    padding:28px 16px;
    color:var(--muted);
}

.top-product-empty .empty-icon{
    font-size:28px;
    display:block;
    margin-bottom:8px;
    opacity:0.6;
}

.top-product-empty p{
    margin:0;
    font-size:13px;
    color:var(--muted);
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


/* =========================================================
   RESPONSIVE
   ========================================================= */

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

    const element =
        document.getElementById('edit-' + id);

    if(element){
        element.classList.toggle('show');
    }
}
</script>

</head>


<body>

<div class="layout">


    <!-- SIDEBAR -->

    @include('admin.partials.sidebar', [
        'active' => 'dashboard'
    ])


    <!-- MAIN CONTENT -->

    <main class="main">


        <!-- HEADER -->

        <header class="heading">

            <div>

                <h1>Dashboard</h1>

                <p>
                    Selamat datang, Admin Utama
                </p>

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

                <strong>
                    Data belum disimpan:
                </strong>

                {{ $errors->first() }}

            </div>

        @endif


        <!-- STATISTIK -->

        <section class="stats">


            <!-- Pendapatan Hari Ini -->

            <div class="stat">

                <small>
                    Pendapatan Hari Ini
                </small>

                <strong>
                    Rp {{ number_format(
                        $omzetHariIni,
                        0,
                        ',',
                        '.'
                    ) }}
                </strong>

                <span class="stat-icon icon-blue">

                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        width="24"
                        height="24"
                    >

                        <line
                            x1="12"
                            y1="1"
                            x2="12"
                            y2="23"
                        />

                        <path
                            d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"
                        />

                    </svg>

                </span>

            </div>


            <!-- Transaksi Hari Ini -->

            <div class="stat">

                <small>
                    Transaksi Hari Ini
                </small>

                <strong>
                    {{ number_format(
                        $transaksiHariIni,
                        0,
                        ',',
                        '.'
                    ) }}
                </strong>

                <span class="stat-icon icon-orange">

                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        width="24"
                        height="24"
                    >

                        <path d="M6 2h9l3 3v17H6z"/>

                        <path
                            d="M9 8h6M9 12h6M9 16h4"
                        />

                    </svg>

                </span>

            </div>


            <!-- Total Produk -->

            <div class="stat">

                <small>
                    Total Produk
                </small>

                <strong>
                    {{ number_format(
                        $jumlahProduk,
                        0,
                        ',',
                        '.'
                    ) }}
                </strong>

                <span class="stat-icon icon-green">

                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        width="24"
                        height="24"
                    >

                        <path
                            d="M21 8l-9-5-9 5v8l9 5 9-5V8z"
                        />

                        <path
                            d="M3 8l9 5 9-5"
                        />

                        <path
                            d="M12 13v8"
                        />

                    </svg>

                </span>

            </div>


            <!-- Total Pendapatan -->

            <div class="stat">

                <small>
                    Total Pendapatan
                </small>

                <strong>
                    Rp {{ number_format(
                        $totalPendapatan,
                        0,
                        ',',
                        '.'
                    ) }}
                </strong>

                <span class="stat-icon icon-purple">

                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        width="24"
                        height="24"
                    >

                        <path
                            d="M22 7l-8.5 8.5-5-5L2 17"
                        />

                        <path
                            d="M16 7h6v6"
                        />

                    </svg>

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


                    <!-- LABEL Y -->

                    <div class="y-labels">

                        <span>
                            Rp{{ number_format(
                                $maxPenjualan,
                                0,
                                ',',
                                '.'
                            ) }}
                        </span>

                        <span>
                            Rp{{ number_format(
                                $maxPenjualan * 0.75,
                                0,
                                ',',
                                '.'
                            ) }}
                        </span>

                        <span>
                            Rp{{ number_format(
                                $maxPenjualan * 0.5,
                                0,
                                ',',
                                '.'
                            ) }}
                        </span>

                        <span>
                            Rp{{ number_format(
                                $maxPenjualan * 0.25,
                                0,
                                ',',
                                '.'
                            ) }}
                        </span>

                        <span>
                            0
                        </span>

                    </div>


                    <!-- WARNA GRAFIK -->

                    @php

                        $warnaGrafik = [

                            '#2563eb',
                            '#16a34a',
                            '#f59e0b',
                            '#9333ea',
                            '#dc2626',
                            '#0891b2',
                            '#e11d48',

                        ];

                    @endphp


                    <!-- DATA GRAFIK -->

                    @foreach($penjualan7Hari as $i => $nilai)

                        <div class="bar-item">

                            <div
                                class="bar"
                                style="
                                    height:
                                    {{ $maxPenjualan > 0 ? max(round(($nilai / $maxPenjualan) * 165), 4) : 4 }}px;

                                    --bar-color:
                                    {{ $warnaGrafik[
                                        $i % count($warnaGrafik)
                                    ] }};
                                "

                                title="
                                    Rp {{
                                        number_format(
                                            $nilai,
                                            0,
                                            ',',
                                            '.'
                                        )
                                    }}
                                "
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

                @php
                    $warnaPie = [
                        '#2563eb',
                        '#16a34a',
                        '#f59e0b',
                    ];
                    $totalTerlaris = $produkTerlaris->sum('total_qty');
                    $offsetPie = 0;
                    $gradientPie = [];
                @endphp

                @forelse($produkTerlaris as $item)
                    @php
                        $persenPie = $totalTerlaris > 0
                            ? ($item->total_qty / $totalTerlaris) * 100
                            : 0;
                        $akhirPie = $offsetPie + $persenPie;
                        $warnaItemPie = $warnaPie[$loop->index % count($warnaPie)];
                        $gradientPie[] = $warnaItemPie . ' ' . $offsetPie . '% ' . $akhirPie . '%';
                        $offsetPie = $akhirPie;
                    @endphp
                @empty
                @endforelse

                @if($produkTerlaris->count() > 0)
                    <div class="donut-wrap">
                        <div
                            class="donut"
                            id="produkTerlarisDonut"
                            style="background:conic-gradient({{ implode(', ', $gradientPie) }});"
                            aria-label="Diagram produk terlaris bulan ini"
                        ></div>
                        <div class="donut-tooltip" id="donutTooltip"></div>

                        <div class="legend">
                            @foreach($produkTerlaris as $item)
                                <div>
                                    <span style="background:{{ $warnaPie[$loop->index % count($warnaPie)] }};"></span>
                                    <strong>{{ $item->nama_produk }}</strong>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="top-product-empty">
                        <span class="empty-icon">📦</span>
                        <p>Belum ada transaksi bulan ini.</p>
                    </div>
                @endif

            </div>

        </section>

    </main>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const donut = document.getElementById('produkTerlarisDonut');
    const tooltip = document.getElementById('donutTooltip');

    if (!donut || !tooltip) return;

    const products = @json($produkTerlaris->map(function ($item) use ($totalTerlaris) {
        return [
            'nama' => $item->nama_produk,
            'persen' => $totalTerlaris > 0
                ? ($item->total_qty / $totalTerlaris) * 100
                : 0,
        ];
    })->values());

    const total = products.reduce((sum, item) => sum + Number(item.persen), 0);

    function hideTooltip() {
        tooltip.style.display = 'none';
    }

    donut.addEventListener('mousemove', function (event) {
        if (!products.length || total <= 0) {
            hideTooltip();
            return;
        }

        const rect = donut.getBoundingClientRect();
        const centerX = rect.left + rect.width / 2;
        const centerY = rect.top + rect.height / 2;
        const x = event.clientX - centerX;
        const y = event.clientY - centerY;
        const radius = Math.sqrt((x * x) + (y * y));

        // Hanya tampilkan tooltip saat kursor berada di bagian cincin,
        // bukan pada lubang putih di tengah.
        const outerRadius = Math.min(rect.width, rect.height) / 2;
        const innerRadius = outerRadius * (91 / 158);
        if (radius < innerRadius || radius > outerRadius) {
            hideTooltip();
            return;
        }

        let angle = Math.atan2(y, x) * 180 / Math.PI + 90;
        if (angle < 0) angle += 360;

        const position = (angle / 360) * total;
        let accumulated = 0;
        let selected = products[products.length - 1];

        for (const product of products) {
            accumulated += Number(product.persen);
            if (position <= accumulated) {
                selected = product;
                break;
            }
        }

        const persen = Number(selected.persen).toLocaleString('id-ID', {
            minimumFractionDigits: 1,
            maximumFractionDigits: 1
        });

        tooltip.innerHTML = '<strong>' + escapeHtml(selected.nama) + '</strong>: ' + persen + '%';
        tooltip.style.display = 'block';

        // Letakkan tooltip dekat kursor, tetapi tetap di dalam layar.
        const offset = 12;
        let left = event.clientX + offset;
        let top = event.clientY + offset;
        const tooltipRect = tooltip.getBoundingClientRect();

        if (left + tooltipRect.width > window.innerWidth - 8) {
            left = event.clientX - tooltipRect.width - offset;
        }
        if (top + tooltipRect.height > window.innerHeight - 8) {
            top = event.clientY - tooltipRect.height - offset;
        }

        tooltip.style.left = Math.max(8, left) + 'px';
        tooltip.style.top = Math.max(8, top) + 'px';
    });

    donut.addEventListener('mouseleave', hideTooltip);

    function escapeHtml(value) {
        const div = document.createElement('div');
        div.textContent = value;
        return div.innerHTML;
    }
});
</script>

</body>
</html>

