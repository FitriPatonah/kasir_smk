// ==========================================
// STATE APLIKASI
// ==========================================
let keranjang = []; // { id, barcode, nama_produk, harga, qty }

const { csrfToken, urlCari, urlCariNama, urlCheckout, namaToko, alamatToko, teleponToko, rekeningToko, headerStruk, footerStruk, metodePembayaran: metodeAktif } = window.KASIR_CONFIG;

const inputBarcode   = document.getElementById('barcode');
const inputCariNama  = document.getElementById('cari-nama');
const hasilCari      = document.getElementById('hasil-cari');
const inputBayar     = document.getElementById('bayar');
const isiKeranjang   = document.getElementById('isi-keranjang');
const elTotal        = document.getElementById('total');
const elKembalian    = document.getElementById('kembalian');
const elPesan        = document.getElementById('pesan');
const elPeringatan   = document.getElementById('peringatan-bayar');
const filterKategori = document.getElementById('filter-kategori');
const produkCards = [...document.querySelectorAll('.kartu-produk')];
const hasilFilterKosong = document.getElementById('hasil-filter-kosong');
const jumlahProduk = document.querySelector('.jumlah-produk');
const btnBayar       = document.getElementById('btn-bayar');
const btnReset       = document.getElementById('btn-reset');
const modalPembayaran = document.getElementById('modal-pembayaran');
const konfirmasiPembayaran = document.getElementById('konfirmasi-pembayaran');
const metodeButtons = document.querySelectorAll('.metode');
const daftarMetode = ['cash', 'qris', 'transfer'];
let metodePembayaran = daftarMetode.find(metode => metodeAktif?.[metode] === true) || null;

function filterProdukBerdasarkanKategori() {
    const kategoriDipilih = filterKategori?.value || '';
    let jumlahTerlihat = 0;

    produkCards.forEach(card => {
        const cocok = !kategoriDipilih || card.dataset.kategori === kategoriDipilih;
        card.style.display = cocok ? '' : 'none';
        if (cocok) jumlahTerlihat += 1;
    });

    if (hasilFilterKosong) hasilFilterKosong.style.display = jumlahTerlihat ? 'none' : 'block';
    if (jumlahProduk) jumlahProduk.textContent = `${jumlahTerlihat} produk`;
}

filterKategori?.addEventListener('change', filterProdukBerdasarkanKategori);

const formatRupiah = (angka) =>
    'Rp ' + Number(angka || 0).toLocaleString('id-ID');

const formatInputUang = (value) => {
    const digits = String(value ?? '').replace(/\D/g, '');
    return digits ? Number(digits).toLocaleString('id-ID') : '';
};

const parseInputUang = (value) => Number(String(value ?? '').replace(/\D/g, '')) || 0;

// ==========================================
// SCAN BARCODE (tekan Enter setelah scan/ketik)
// ==========================================
inputBarcode.addEventListener('keypress', async (e) => {
    if (e.key !== 'Enter') return;
    const kode = inputBarcode.value.trim();
    if (!kode) return;

    tampilkanPesan('Mencari produk...', '');

    try {
        const res = await fetch(`${urlCari}?barcode=${encodeURIComponent(kode)}`, {
            headers: { 'Accept': 'application/json' }
        });
        const data = await res.json();

        if (data.sukses) {
            tambahKeKeranjang(data.produk);
            tampilkanPesan(`✔ ${data.produk.nama_produk} ditambahkan`, 'sukses');
        } else {
            tampilkanPesan(`✘ ${data.pesan}`, 'error');
        }
    } catch (err) {
        tampilkanPesan('✘ Gagal terhubung ke server', 'error');
    }

    inputBarcode.value = '';
    inputBarcode.focus();
});

function tampilkanPesan(teks, jenis) {
    elPesan.textContent = teks;
    elPesan.className = 'pesan ' + jenis;
}

// ==========================================
// CARI PRODUK BERDASARKAN NAMA (dengan debounce)
// ==========================================
let timerCariNama = null;

inputCariNama.addEventListener('input', () => {
    clearTimeout(timerCariNama);
    const kata = inputCariNama.value.trim();

    if (kata.length < 2) {
        hasilCari.style.display = 'none';
        hasilCari.innerHTML = '';
        return;
    }

    // Tunggu 300ms setelah user berhenti mengetik, baru kirim request
    // (supaya tidak spam request tiap ketikan huruf)
    timerCariNama = setTimeout(async () => {
        try {
            const res = await fetch(`${urlCariNama}?q=${encodeURIComponent(kata)}`, {
                headers: { 'Accept': 'application/json' }
            });
            const data = await res.json();
            tampilkanHasilCari(data.produk);
        } catch (err) {
            hasilCari.style.display = 'none';
        }
    }, 300);
});

function tampilkanHasilCari(daftarProduk) {
    if (!daftarProduk || daftarProduk.length === 0) {
        hasilCari.innerHTML = `<div class="hasil-cari-kosong">Produk tidak ditemukan</div>`;
        hasilCari.style.display = 'block';
        return;
    }

    hasilCari.innerHTML = daftarProduk.map(p => `
        <div class="hasil-cari-item" data-id="${p.id}">
            <div class="hasil-cari-info">
                <div class="hasil-cari-nama">${p.nama_produk}</div>
                <div class="hasil-cari-meta">${p.barcode} · Stok: ${p.stok}</div>
            </div>
            <div class="hasil-cari-harga">${formatRupiah(p.harga)}</div>
        </div>
    `).join('');

    hasilCari.style.display = 'block';

    // Pasang event klik untuk tiap hasil pencarian
    hasilCari.querySelectorAll('.hasil-cari-item').forEach((el, index) => {
        el.addEventListener('click', () => {
            const produk = daftarProduk[index];
            if (produk.stok <= 0) {
                tampilkanPesan(`✘ Stok "${produk.nama_produk}" habis`, 'error');
                return;
            }
            tambahKeKeranjang(produk);
            tampilkanPesan(`✔ ${produk.nama_produk} ditambahkan`, 'sukses');

            inputCariNama.value = '';
            hasilCari.style.display = 'none';
            hasilCari.innerHTML = '';
            inputCariNama.focus();
        });
    });
}

document.querySelectorAll('.kartu-produk').forEach((kartu) => {
    kartu.addEventListener('click', () => {
        tambahKeKeranjang({
            id: Number(kartu.dataset.id),
            barcode: kartu.dataset.barcode,
            nama_produk: kartu.querySelector('.kartu-produk-info strong').textContent.trim(),
            harga: Number(kartu.querySelector('.harga-produk').textContent.replace(/\D/g, '')),
            stok: Number(kartu.querySelector('.kartu-produk-info small').textContent.replace(/\D/g, '')),
        });
    });
});

// Sembunyikan dropdown hasil pencarian kalau klik di luar area kotak pencarian
document.addEventListener('click', (e) => {
    if (!e.target.closest('.cari-box')) {
        hasilCari.style.display = 'none';
    }
});

// ==========================================
// KELOLA KERANJANG
// ==========================================
function tambahKeKeranjang(produk) {
    const item = keranjang.find(i => i.id === produk.id);
    if (item) {
        if (item.qty + 1 > produk.stok) {
            tampilkanPesan(`✘ Stok "${produk.nama_produk}" tidak mencukupi`, 'error');
            return;
        }
        item.qty += 1;
    } else {
        keranjang.push({
            id: produk.id,
            barcode: produk.barcode,
            nama_produk: produk.nama_produk,
            harga: produk.harga,
            stok: produk.stok,
            qty: 1
        });
    }
    renderKeranjang();
}

function ubahQty(id, delta) {
    const item = keranjang.find(i => i.id === id);
    if (!item) return;
    const qtyBaru = item.qty + delta;

    if (qtyBaru <= 0) {
        keranjang = keranjang.filter(i => i.id !== id);
    } else if (qtyBaru > item.stok) {
        tampilkanPesan(`✘ Stok "${item.nama_produk}" hanya ${item.stok}`, 'error');
        return;
    } else {
        item.qty = qtyBaru;
    }
    renderKeranjang();
}

function hapusItem(id) {
    keranjang = keranjang.filter(i => i.id !== id);
    renderKeranjang();
}

function renderKeranjang() {
    const jumlahItem = keranjang.reduce((jumlah, item) => jumlah + item.qty, 0);
    document.getElementById('jumlah-keranjang-panel').textContent = jumlahItem;
    document.getElementById('subtotal').textContent = formatRupiah(getTotal());
    if (keranjang.length === 0) {
        isiKeranjang.innerHTML = '<div class="keranjang-kosong">Keranjang kosong</div>';
    } else {
        isiKeranjang.innerHTML = keranjang.map(item => `
            <div class="item-keranjang">
                <div class="item-keranjang-info"><strong>${item.nama_produk}</strong><small>${formatRupiah(item.harga)}</small></div>
                <div class="qty-control">
                        <button aria-label="Kurangi ${item.nama_produk}" onclick="ubahQty(${item.id}, -1)">−</button>
                        <span>${item.qty}</span>
                        <button aria-label="Tambah ${item.nama_produk}" onclick="ubahQty(${item.id}, 1)">+</button>
                        <button class="btn-hapus" title="Hapus ${item.nama_produk}" aria-label="Hapus ${item.nama_produk}" onclick="hapusItem(${item.id})"><svg class="trash-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 7h16M10 11v6M14 11v6M6 7l1 13h10l1-13M9 7l1-3h4l1 3"/></svg></button>
                </div>
            </div>
        `).join('');
    }
    hitungTotal();
}

// ==========================================
// HITUNG TOTAL & KEMBALIAN
// ==========================================
function getTotal() {
    return keranjang.reduce((sum, item) => sum + item.harga * item.qty, 0);
}

function hitungTotal() {
    const total = getTotal();
    elTotal.textContent = formatRupiah(total);
    hitungKembalian();
}

function hitungKembalian() {
    const total = getTotal();
    const bayar = parseInputUang(inputBayar.value);
    const kembalian = bayar - total;

    elKembalian.textContent = formatRupiah(Math.max(kembalian, 0));
    elKembalian.classList.toggle('negatif', kembalian < 0);

    if (bayar > 0 && bayar < total) {
        elPeringatan.textContent = 'Uang yang diberikan masih kurang';
        btnBayar.disabled = keranjang.length === 0;
        konfirmasiPembayaran.disabled = true;
    } else {
        elPeringatan.textContent = '';
        btnBayar.disabled = keranjang.length === 0;
        konfirmasiPembayaran.disabled = keranjang.length === 0 || bayar < total;
    }
}

inputBayar.addEventListener('input', (event) => {
    const formatted = formatInputUang(event.target.value);
    event.target.value = formatted;
    hitungKembalian();
});

// ==========================================
// ==========================================
 // SINKRONISASI METODE PEMBAYARAN
 // ==========================================
 function sinkronkanMetodePembayaran() {
     metodeButtons.forEach((button) => {
         const metode = button.dataset.metode;
         const aktif = metodeAktif?.[metode] === true;
         button.disabled = !aktif;
         button.classList.toggle('nonaktif', !aktif);
     });

     if (!metodePembayaran || metodeAktif?.[metodePembayaran] !== true) {
         metodePembayaran = daftarMetode.find(metode => metodeAktif?.[metode] === true) || null;
     }

     metodeButtons.forEach((button) => {
         button.classList.toggle('aktif', button.dataset.metode === metodePembayaran);
     });

     if (!metodePembayaran) {
         elPeringatan.textContent = 'Tidak ada metode pembayaran yang aktif. Silakan hubungi admin.';
         konfirmasiPembayaran.disabled = true;
     }
 }

 sinkronkanMetodePembayaran();

// PROSES PEMBAYARAN
// ==========================================
async function prosesBayar() {
    const total = getTotal();
    const bayar = parseInputUang(inputBayar.value);

    if (keranjang.length === 0) {
        tampilkanPesan('✘ Keranjang masih kosong', 'error');
        return;
    }
    if (!metodePembayaran || metodeAktif?.[metodePembayaran] !== true) {
        tampilkanPesan('✘ Metode pembayaran yang dipilih sedang dinonaktifkan', 'error');
        sinkronkanMetodePembayaran();
        return;
    }
    if (bayar < total) {
        tampilkanPesan('✘ Uang yang diberikan kurang', 'error');
        return;
    }

    btnBayar.disabled = true;
    konfirmasiPembayaran.disabled = true;
    konfirmasiPembayaran.textContent = 'Memproses...';

    try {
        const res = await fetch(urlCheckout, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({ keranjang, total, bayar, metode_pembayaran: metodePembayaran })
        });
        const data = await res.json();

        if (data.sukses) {
            cetakStruk(data);
            keranjang = [];
            inputBayar.value = '';
            renderKeranjang();
            tutupModalPembayaran();
            window.print();
        } else {
            tampilkanPesan(`✘ ${data.pesan}`, 'error');
        }
    } catch (err) {
        tampilkanPesan('✘ Gagal terhubung ke server', 'error');
    }

    konfirmasiPembayaran.textContent = 'Konfirmasi Pembayaran';
    btnBayar.disabled = keranjang.length === 0;
    konfirmasiPembayaran.disabled = keranjang.length === 0 || parseInputUang(inputBayar.value) < getTotal();
    if (keranjang.length === 0) tutupModalPembayaran();
    inputBarcode.focus();
}

function bukaModalPembayaran() {
    if (keranjang.length === 0) return;
    document.getElementById('modal-total').textContent = formatRupiah(getTotal());
    modalPembayaran.classList.add('terbuka');
    modalPembayaran.setAttribute('aria-hidden', 'false');
    inputBayar.focus();
}

function tutupModalPembayaran() {
    modalPembayaran.classList.remove('terbuka');
    modalPembayaran.setAttribute('aria-hidden', 'true');
}

btnBayar.addEventListener('click', bukaModalPembayaran);
konfirmasiPembayaran.addEventListener('click', prosesBayar);
document.querySelectorAll('[data-close-payment]').forEach((element) => element.addEventListener('click', tutupModalPembayaran));
metodeButtons.forEach((button) => {
    button.addEventListener('click', () => {
        const metode = button.dataset.metode;
        if (metodeAktif?.[metode] !== true) return;

        metodePembayaran = metode;
        metodeButtons.forEach((item) => item.classList.remove('aktif'));
        button.classList.add('aktif');
        elPeringatan.textContent = '';
        hitungKembalian();
    });
});
document.querySelectorAll('[data-nominal]').forEach((button) => {
    button.addEventListener('click', () => {
        const nominal = Number(button.dataset.nominal) || getTotal();
        inputBayar.value = formatInputUang(nominal);
        hitungKembalian();
    });
});

btnReset.addEventListener('click', () => {
    if (keranjang.length === 0) return;
    if (confirm('Batalkan seluruh transaksi ini?')) {
        keranjang = [];
        inputBayar.value = '';
        tutupModalPembayaran();
        renderKeranjang();
        tampilkanPesan('', '');
        inputBarcode.focus();
    }
});

// Shortcut keyboard F9 untuk bayar
document.addEventListener('keydown', (e) => {
    if (e.key === 'F9') {
        e.preventDefault();
        if (!btnBayar.disabled) bukaModalPembayaran();
    }
});

// ==========================================
// CETAK STRUK SEDERHANA
// ==========================================
function formatTeksStruk(teks) {
    return String(teks || '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/\"/g, '&quot;')
        .replace(/\n/g, '<br>');
}

function cetakStruk(data) {
    const tanggal = new Date().toLocaleString('id-ID');
    const alamat = formatTeksStruk(alamatToko);
    const telepon = formatTeksStruk(teleponToko);
    const rekening = formatTeksStruk(rekeningToko);
    let baris = keranjang.map(item => `
        <tr class="item-nama">
            <td class="item-qty">${Number(item.qty).toFixed(2).replace('.', ',')}</td>
            <td colspan="2">${formatTeksStruk(item.nama_produk).toUpperCase()}</td>
        </tr>
        <tr class="item-detail">
            <td class="item-unit-price">x ${formatRupiah(item.harga)}</td>
            <td></td>
            <td style="text-align:right">${formatRupiah(item.harga * item.qty)}</td>
        </tr>
    `).join('');

    document.getElementById('struk').innerHTML = `
        <h2>${formatTeksStruk(namaToko || 'TOKO')}</h2>
        ${alamat ? `<p>${alamat}</p>` : ''}
        ${telepon ? `<p>Telp: ${telepon}</p>` : ''}
        <p>${formatTeksStruk(headerStruk || 'Terima kasih sudah berbelanja')}</p>
        <div class="garis"></div>
        <div>No: ${data.no_transaksi}</div>
        <div>${tanggal}</div>
        <div class="garis"></div>
        <table class="item-table"><colgroup><col class="qty-col"><col><col class="amount-col"></colgroup>${baris}</table>
        <div class="garis"></div>
        <table>
            <tr><td>Subtotal</td><td>${formatRupiah(data.total)}</td></tr>
            <tr class="label-total"><td>TOTAL</td><td>${formatRupiah(data.total)}</td></tr>
            <tr><td>Bayar (${data.metode_pembayaran.toUpperCase()})</td><td>${formatRupiah(data.bayar)}</td></tr>
            <tr><td>Kembali</td><td>${formatRupiah(data.kembalian)}</td></tr>
        </table>
        <div class="garis"></div>
        <div class="terima-kasih">${formatTeksStruk(footerStruk || 'Barang yang sudah dibeli tidak dapat ditukar')}</div>
        ${rekening ? `<div class="rekening-struk">Rekening: ${rekening}</div>` : ''}
    `;
}
