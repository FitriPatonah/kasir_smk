<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\StokController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::prefix('auth')->group(function () {
    Route::get('/pilih-login', [AuthController::class, 'pilihLogin'])->name('auth.pilihLogin');
    Route::get('/login/{role}', [AuthController::class, 'showLogin'])->name('auth.login');
    Route::post('/login/{role}', [AuthController::class, 'login'])->name('auth.login.post');
    Route::get('/logout/{role?}', [AuthController::class, 'logout'])->name('auth.logout');
});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
| Admin mengelola produk (CRUD) dan melihat seluruh riwayat transaksi.
*/
Route::middleware('auth:admin')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/produk', [AdminController::class, 'produk'])->name('admin.produk');
    Route::get('/admin/produk/tambah', [AdminController::class, 'tambahProduk'])->name('admin.produk.tambah');
    Route::get('/admin/kategori', [AdminController::class, 'kategori'])->name('admin.kategori');
    Route::get('/admin/supplier', [AdminController::class, 'supplier'])->name('admin.supplier');
    Route::post('/admin/supplier', [AdminController::class, 'storeSupplier'])->name('admin.supplier.store');
    Route::put('/admin/supplier/{id}', [AdminController::class, 'updateSupplier'])->name('admin.supplier.update');
    Route::delete('/admin/supplier/{id}', [AdminController::class, 'destroySupplier'])->name('admin.supplier.destroy');
    Route::post('/admin/kategori', [AdminController::class, 'storeKategori'])->name('admin.kategori.store');
    Route::put('/admin/kategori/{id}', [AdminController::class, 'updateKategori'])->name('admin.kategori.update');
    Route::delete('/admin/kategori/{id}', [AdminController::class, 'destroyKategori'])->name('admin.kategori.destroy');

    Route::post('/admin/produk', [AdminController::class, 'storeProduk'])->name('admin.produk.store');
    Route::put('/admin/produk/{id}', [AdminController::class, 'updateProduk'])->name('admin.produk.update');
    Route::delete('/admin/produk/{id}', [AdminController::class, 'destroyProduk'])->name('admin.produk.destroy');

    Route::get('/admin/riwayat-transaksi', [AdminController::class, 'laporan'])->name('admin.laporan');
    Route::get('/admin/transaksi/{id}', [AdminController::class, 'detailTransaksi'])->name('admin.transaksi.detail');
    Route::get('/admin/pengaturan', [AdminController::class, 'pengaturan'])->name('admin.pengaturan');
    Route::put('/admin/pengaturan', [AdminController::class, 'updatePengaturan'])->name('admin.pengaturan.update');

    Route::get('/admin/kelola-user', [AdminController::class, 'kelolaUser'])->name('admin.kelola-user');
    Route::post('/admin/kelola-user', [AdminController::class, 'storeUser'])->name('admin.kelola-user.store');
    Route::put('/admin/kelola-user/{id}', [AdminController::class, 'updateUser'])->name('admin.kelola-user.update');
    Route::patch('/admin/kelola-user/{id}/status', [AdminController::class, 'toggleStatusUser'])->name('admin.kelola-user.status');
    Route::delete('/admin/kelola-user/{id}', [AdminController::class, 'destroyUser'])->name('admin.kelola-user.destroy');
    Route::get('/admin/stok', [StokController::class, 'index'])->defaults('role', 'admin')->name('admin.stok');
    Route::get('/admin/stok/masuk', [StokController::class, 'index'])->defaults('role', 'admin')->defaults('mode', 'masuk')->name('admin.stok.masuk');
    Route::get('/admin/stok/keluar', [StokController::class, 'index'])->defaults('role', 'admin')->defaults('mode', 'keluar')->name('admin.stok.keluar');
    Route::post('/admin/stok', [StokController::class, 'store'])->name('admin.stok.store');
    Route::get('/admin/laporan', [TransaksiController::class, 'index'])->defaults('role', 'admin')->name('admin.transaksi');
    Route::get('/admin/laporan/export', [TransaksiController::class, 'export'])->name('admin.transaksi.export');

});

Route::middleware('auth:kasir')->group(function () {
    Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index');
    Route::get('/kasir/riwayat', [KasirController::class, 'riwayatTransaksi'])->name('kasir.riwayat');
    Route::get('/kasir/riwayat/export', [KasirController::class, 'exportRiwayat'])->name('kasir.riwayat.export');
    Route::get('/kasir/stok', [StokController::class, 'index'])->defaults('role', 'kasir')->name('kasir.stok');
    Route::get('/kasir/profil', [KasirController::class, 'profil'])->name('kasir.profil');
    Route::put('/kasir/profil', [KasirController::class, 'updateProfil'])->name('kasir.profil.update');
    

    Route::prefix('api')->group(function () {
        Route::get('/produk/cari', [KasirController::class, 'cariProduk'])->name('kasir.cari');
        Route::get('/produk/cari-nama', [KasirController::class, 'cariNama'])->name('kasir.cariNama');
        Route::post('/checkout', [KasirController::class, 'checkout'])->name('kasir.checkout');
    });
});
