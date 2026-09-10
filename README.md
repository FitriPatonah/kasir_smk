# Sistem Kasir Supermarket (Laravel + MySQL)

Sistem kasir sederhana berbasis **Laravel**: scan barcode → nama & harga produk
otomatis muncul → input uang pembeli → kembalian dihitung otomatis → transaksi
tersimpan di database.

## Struktur Fitur

- `app/Models/Produk.php`, `Transaksi.php`, `TransaksiDetail.php` — data produk & transaksi
- `app/Http/Controllers/KasirController.php` — logika cari produk & proses checkout
- `routes/web.php` — route halaman kasir + API (`/api/produk/cari`, `/api/checkout`)
- `resources/views/kasir/index.blade.php` — tampilan halaman kasir
- `public/css/kasir.css`, `public/js/kasir.js` — styling & logika frontend (vanilla JS, tanpa build tool)
- `database/migrations/` — struktur tabel `produk`, `transaksi`, `transaksi_detail`
- `database/seeders/ProdukSeeder.php` — 10 produk contoh dengan barcode siap pakai

## Kebutuhan

- PHP >= 8.2
- Composer (https://getcomposer.org/)
- MySQL (bisa pakai XAMPP / Laragon / MySQL Server biasa)

## Cara Instalasi

1. **Extract** folder project ini, lalu buka lewat VS Code atau terminal:
   ```bash
   cd kasir-laravel
   ```

2. **Install dependency Laravel lewat Composer**
   (folder `vendor/` sengaja tidak disertakan di zip supaya ukurannya kecil,
   composer akan mengunduhnya)
   ```bash
   composer install
   ```

3. **Copy file environment**
   ```bash
   cp .env.example .env
   ```
   (Windows PowerShell: `copy .env.example .env`)

4. **Generate application key**
   ```bash
   php artisan key:generate
   ```

5. **Buat database MySQL**
   Buat database kosong bernama `kasir_supermarket` (lewat phpMyAdmin atau CLI):
   ```sql
   CREATE DATABASE kasir_supermarket;
   ```

6. **Cek konfigurasi database** di file `.env`, sesuaikan jika perlu:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=kasir_supermarket
   DB_USERNAME=root
   DB_PASSWORD=
   ```

7. **Jalankan migration + seeder** (bikin tabel + isi data produk contoh)
   ```bash
   php artisan migrate --seed
   ```

8. **Jalankan aplikasi**
   ```bash
   php artisan serve
   ```
   Buka browser: `http://localhost:8000`

## Cara Pakai

1. Klik/fokus ke kotak **"Scan / Ketik Barcode Produk"**.
2. Scan barcode dengan alat scanner (atau ketik manual lalu tekan **Enter**).
3. Produk otomatis masuk ke daftar belanja, harga & total ter-update otomatis.
4. Bisa tambah/kurangi jumlah (qty) atau hapus produk dari keranjang.
5. Masukkan **jumlah uang yang diberikan pembeli** di kolom "Uang Diberikan".
6. **Kembalian** langsung dihitung otomatis (Uang Diberikan − Total).
7. Klik **"Proses Pembayaran"** (atau tekan tombol **F9**) untuk menyimpan
   transaksi dan mencetak struk. Stok produk otomatis berkurang.

## Barcode Contoh untuk Dicoba

| Barcode | Produk | Harga |
|---|---|---|
| 8991001234567 | Indomie Goreng | Rp 3.500 |
| 8991001234568 | Aqua Botol 600ml | Rp 4.000 |
| 8991001234570 | Beras 5kg | Rp 65.000 |
| 8991001234573 | Telur Ayam 1kg | Rp 28.000 |

(daftar lengkap ada di `database/seeders/ProdukSeeder.php`)

## Menambah / Mengedit Produk

Cara paling gampang: edit langsung tabel `produk` lewat phpMyAdmin.

Atau lewat Tinker (`php artisan tinker`):
```php
App\Models\Produk::create([
    'barcode' => '8991009999999',
    'nama_produk' => 'Kopi Sachet',
    'harga' => 2000,
    'stok' => 100,
]);
```

> Kalau nanti mau ditambah halaman admin CRUD produk lewat web (tambah/edit/hapus
> tanpa phpMyAdmin), tinggal bilang saja — tinggal dibuatkan `ProdukController` + view-nya.

## Kenapa Tidak Pakai Vite/Build Tool?

Supaya tetap **simpel**: CSS dan JS ditaruh langsung di `public/css` dan
`public/js`, dipanggil pakai helper `asset()` di Blade — tidak perlu jalankan
`npm install` / `npm run build`. Cukup `composer install` saja sudah bisa jalan.

## Membuka & Mengedit di VS Code

1. **File > Open Folder** → pilih folder `kasir-laravel`.
2. Disarankan install extension:
   - **PHP Intelephense** (auto-complete PHP)
   - **Laravel Blade Snippets** (syntax highlight file `.blade.php`)
3. Jalankan server lewat terminal VS Code dengan `php artisan serve`,
   lalu edit file — cukup refresh browser untuk lihat perubahan (kecuali route/config,
   kadang perlu restart `artisan serve`).

## Catatan Keamanan (untuk pemakaian produksi nanti)

Project ini dibuat simpel untuk belajar/skala kecil. Kalau nanti mau dipakai
di supermarket sungguhan dan diakses banyak kasir sekaligus, sebaiknya tambahkan:
- Login kasir (Laravel Breeze/Fortify untuk autentikasi)
- Hak akses admin vs kasir (role & permission)
- Backup database berkala
- Set `APP_DEBUG=false` di `.env` saat production
- HTTPS jika diakses lewat jaringan/internet
