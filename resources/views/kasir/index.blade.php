<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<meta name="csrf-token" content="{{ csrf_token() }}">

<title>Kasir POS - {{ $namaToko }}</title>

<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

<link rel="stylesheet" href="{{ asset('css/kasir.css') }}">
</head>

<body>

<div class="app">

@include('kasir.partials.sidebar', ['active' => 'kasir'])


<main class="main">

    <!-- ==============================
         DAFTAR PRODUK
    =============================== -->

    <div class="panel panel-kiri">

        <div class="produk-header">

            <div>
                <h1>Daftar Produk</h1>

                <small>
                    Pilih produk untuk menambahkannya ke keranjang.
                </small>
            </div>

            <span class="jumlah-produk">
                {{ $produk->count() }} produk
            </span>

        </div>


        <div class="filter-produk">

            <div class="cari-box">

                <input
                    type="text"
                    id="cari-nama"
                    placeholder="Cari produk..."
                    autocomplete="off"
                    autofocus
                >

                <div id="hasil-cari" class="hasil-cari"></div>

            </div>


            <select
                id="filter-kategori"
                class="filter-kategori"
                aria-label="Filter kategori"
            >

                <option value="">
                    Semua Kategori
                </option>

                @foreach($kategoriProduk as $kategori)

                    <option value="{{ $kategori }}">
                        {{ $kategori }}
                    </option>

                @endforeach

            </select>


            <div class="scan-box">

                <button
                    type="button"
                    class="scan-label"
                    onclick="document.getElementById('barcode').focus()"
                >
                    <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-3px;margin-right:6px;"><path d="M3 7V5a2 2 0 0 1 2-2h2"/><path d="M17 3h2a2 2 0 0 1 2 2v2"/><path d="M21 17v2a2 2 0 0 1-2 2h-2"/><path d="M7 21H5a2 2 0 0 1-2-2v-2"/><path d="M4 12h16"/></svg>Scan
                </button>

                <input
                    type="text"
                    id="barcode"
                    placeholder="Scan barcode lalu Enter"
                    autocomplete="off"
                >

                <div id="pesan" class="pesan"></div>

            </div>

        </div>


        <div id="daftar-produk" class="daftar-produk">

            @forelse($produk as $item)

                <button
                    type="button"
                    class="kartu-produk {{ $item->stok <= 0 ? 'habis' : '' }}"
                    data-id="{{ $item->id }}"
                    data-nama="{{ strtolower($item->nama_produk) }}"
                    data-kategori="{{ $item->kategori }}"
                    data-barcode="{{ $item->barcode }}"
                    data-pajak="{{ $item->pajak ?? 0 }}"
                    {{ $item->stok <= 0 ? 'disabled' : '' }}
                >

                    <div class="kartu-produk-gambar">

                        @if($item->foto)

                            <img
                                src="{{ asset('storage/'.$item->foto) }}"
                                alt="{{ $item->nama_produk }}"
                            >

                        @else

                            <span>📦</span>

                        @endif

                    </div>


                    <div class="kartu-produk-info">

                        <strong>
                            {{ $item->nama_produk }}
                        </strong>

                        <span class="harga-produk">
                            Rp {{ number_format($item->harga,0,',','.') }}
                        </span>

                        <small>
                            Stok: {{ $item->stok }}
                        </small>

                    </div>

                </button>

            @empty

                <div class="produk-kosong">
                    Belum ada produk. Admin dapat menambahkan produk dari Dashboard Admin.
                </div>

            @endforelse

        </div>


        <div
            id="hasil-filter-kosong"
            class="produk-kosong"
            style="display:none;"
        >
            Produk tidak ditemukan.
        </div>

    </div>


    <!-- ==============================
         KERANJANG
    =============================== -->

    <div class="panel panel-kanan">

        <div class="ringkasan">

            <h2 class="ringkasan-judul">
                Keranjang
                (<span id="jumlah-keranjang-panel">0</span>)
            </h2>


            <div id="isi-keranjang" class="isi-keranjang">

                <div class="keranjang-kosong">
                    Keranjang kosong
                </div>

            </div>


            <!-- TOTAL + PAJAK -->

            <div class="ringkasan-total">

                <div class="baris">

                    <span>
                        Subtotal
                    </span>

                    <span id="subtotal">
                        Rp 0
                    </span>

                </div>


                <div class="baris">

                    <span id="label-pajak">
                        Pajak
                    </span>

                    <span id="pajak">
                        Rp 0
                    </span>

                </div>


                <div class="baris total-akhir">

                    <strong>
                        Total
                    </strong>

                    <strong id="total">
                        Rp 0
                    </strong>

                </div>

            </div>


            <button
                id="btn-bayar"
                class="btn-bayar"
                disabled
            >
                Bayar
            </button>


            <button
                id="btn-reset"
                class="btn-reset"
            >
                Batal
            </button>

        </div>

    </div>

</main>

</div>


<!-- ==============================
     STRUK
=============================== -->

<div id="struk" class="struk"></div>


<!-- ==============================
     MODAL PEMBAYARAN
=============================== -->

<div
    id="modal-pembayaran"
    class="modal-pembayaran"
    aria-hidden="true"
>

    <div
        class="modal-overlay"
        data-close-payment
    ></div>


    <section
        class="payment-dialog"
        role="dialog"
        aria-modal="true"
        aria-labelledby="judul-pembayaran"
    >

        <button
            type="button"
            class="modal-close"
            data-close-payment
            aria-label="Tutup"
        >
            ×
        </button>


        <h2 id="judul-pembayaran">

            Pembayaran -

            <span id="modal-total">
                Rp 0
            </span>

        </h2>


        <!-- METODE PEMBAYARAN -->

        <div
            class="metode-pembayaran"
            role="tablist"
        >

            <button
                type="button"
                class="metode {{ $pengaturan->metode_cash ? '' : 'nonaktif' }}"
                data-metode="cash"
                {{ $pengaturan->metode_cash ? '' : 'disabled' }}
            >

                <span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="6" width="20" height="12" rx="2"/>
                        <circle cx="12" cy="12" r="2.5"/>
                        <path d="M6 9v6M18 9v6"/>
                    </svg>
                </span>
                Cash

            </button>


            <button
                type="button"
                class="metode {{ $pengaturan->metode_qris ? '' : 'nonaktif' }}"
                data-metode="qris"
                {{ $pengaturan->metode_qris ? '' : 'disabled' }}
            >

                <span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7" rx="1"/>
                        <rect x="14" y="3" width="7" height="7" rx="1"/>
                        <rect x="3" y="14" width="7" height="7" rx="1"/>
                        <path d="M14 14h3v3h-3zM19 14h2v2h-2zM14 19h2v2h-2zM19 19h2v2h-2z" fill="currentColor" stroke="none"/>
                    </svg>
                </span>
                QRIS

            </button>


            <button
                type="button"
                class="metode {{ $pengaturan->metode_transfer ? '' : 'nonaktif' }}"
                data-metode="transfer"
                {{ $pengaturan->metode_transfer ? '' : 'disabled' }}
            >

                <span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M2 10l10-6 10 6"/>
                        <path d="M4 21V10M9 21V10M15 21V10M20 21V10"/>
                        <path d="M3 21h18"/>
                    </svg>
                </span>
                Transfer

            </button>

        </div>


        <label
            class="label-bayar"
            for="bayar"
        >
            Jumlah Bayar
        </label>


        <input
            type="text"
            id="bayar"
            placeholder="Masukkan nominal"
            inputmode="numeric"
            autocomplete="off"
        >


        <div class="nominal-cepat">

            <button
                type="button"
                data-nominal="0"
            >
                Sesuai Total
            </button>

            <button
                type="button"
                data-nominal="10000"
            >
                Rp 10.000
            </button>

            <button
                type="button"
                data-nominal="50000"
            >
                Rp 50.000
            </button>

            <button
                type="button"
                data-nominal="100000"
            >
                Rp 100.000
            </button>

        </div>


        <div class="modal-kembalian">

            <span>
                Kembalian
            </span>

            <strong id="kembalian">
                Rp 0
            </strong>

        </div>


        <div
            id="peringatan-bayar"
            class="peringatan"
        ></div>


        <button
            id="konfirmasi-pembayaran"
            class="konfirmasi-pembayaran"
            disabled
        >
            Konfirmasi Pembayaran
        </button>

    </section>

</div>


<script>

window.KASIR_CONFIG = {

    csrfToken:
        document.querySelector('meta[name="csrf-token"]').content,

    urlCari:
        "{{ route('kasir.cari') }}",

    urlCariNama:
        "{{ route('kasir.cariNama') }}",

    urlCheckout:
        "{{ route('kasir.checkout') }}",

    namaToko:
        @json($namaToko),

    alamatToko:
        @json($pengaturanToko->alamat),

    teleponToko:
        @json($pengaturanToko->telepon),

    rekeningToko:
        @json($pengaturanToko->info_rekening),

    headerStruk:
        @json($pengaturanToko->header_struk),

    footerStruk:
        @json($pengaturanToko->footer_struk),


    metodePembayaran: {

        cash:
            @json((bool) $pengaturanToko->metode_cash),

        qris:
            @json((bool) $pengaturanToko->metode_qris),

        transfer:
            @json((bool) $pengaturanToko->metode_transfer),

    },

};

</script>


<script src="{{ asset('js/kasir-format.js') }}"></script>

<script src="{{ asset('js/kasir.js') }}"></script>

</body>
</html>