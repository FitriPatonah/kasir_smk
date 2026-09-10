<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom `sumber` supaya setiap baris mutasi_stok jelas
     * asalnya: 'manual' (diinput admin lewat halaman Stok) atau
     * 'penjualan' (otomatis dikurangi saat kasir checkout).
     *
     * Sebelumnya sistem menebak asal mutasi dari teks `keterangan`
     * (misal cek awalan "Penjualan ..."), yang rapuh dan ambigu.
     * Kolom eksplisit ini menggantikan logika tebak-tebakan tersebut.
     */
    public function up(): void
    {
        Schema::table('mutasi_stok', function (Blueprint $table) {
            $table->enum('sumber', ['manual', 'penjualan'])
                ->default('manual')
                ->after('tipe');
        });

        // Backfill data lama: mutasi keluar yang keterangannya diawali
        // "Penjualan" (dibuat oleh KasirController::checkout) ditandai
        // sebagai 'penjualan', sisanya (semua stok masuk + stok keluar
        // manual lama) tetap 'manual'.
        DB::table('mutasi_stok')
            ->where('tipe', 'keluar')
            ->where('keterangan', 'like', 'Penjualan %')
            ->update(['sumber' => 'penjualan']);

        Schema::table('mutasi_stok', function (Blueprint $table) {
            $table->index(['tipe', 'sumber']);
        });
    }

    public function down(): void
    {
        Schema::table('mutasi_stok', function (Blueprint $table) {
            $table->dropIndex(['tipe', 'sumber']);
            $table->dropColumn('sumber');
        });
    }
};
