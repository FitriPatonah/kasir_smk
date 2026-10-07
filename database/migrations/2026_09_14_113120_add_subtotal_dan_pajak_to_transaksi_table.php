<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Jalankan migration.
     *
     * Sebelum ini, nominal pajak per transaksi tidak disimpan
     * terpisah -- cuma sudah "ketitip" dijumlah ke kolom `total`
     * saat checkout (total = subtotal + pajak). Ini bikin laporan
     * pajak susah dibuat karena harus dihitung ulang manual.
     *
     * Sekarang subtotal & pajak disimpan eksplisit per transaksi.
     */
    public function up(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->unsignedInteger('subtotal')->nullable()->after('no_transaksi');
            $table->unsignedInteger('pajak')->nullable()->after('subtotal');
        });

        // Isi data transaksi LAMA yang sudah ada, supaya kolom baru ini
        // tidak kosong untuk histori transaksi sebelum migration ini.
        // Pajak dihitung mundur dari selisih total - subtotal item.
        // Dipakai query builder biasa (bukan raw SQL JOIN) supaya jalan
        // di semua driver database, termasuk SQLite untuk testing.
        DB::table('transaksi')
            ->whereNull('subtotal')
            ->orderBy('id')
            ->chunkById(200, function ($rows) {
                foreach ($rows as $row) {
                    $jumlahSubtotal = (int) DB::table('transaksi_detail')
                        ->where('transaksi_id', $row->id)
                        ->sum('subtotal');

                    // Kalau transaksi ini tidak punya detail (kasus langka/data
                    // rusak), anggap saja tidak ada pajak supaya tidak error.
                    $subtotal = $jumlahSubtotal > 0 ? $jumlahSubtotal : (int) $row->total;
                    $pajak = max((int) $row->total - $subtotal, 0);

                    DB::table('transaksi')
                        ->where('id', $row->id)
                        ->update([
                            'subtotal' => $subtotal,
                            'pajak' => $pajak,
                        ]);
                }
            });
    }

    /**
     * Batalkan migration.
     */
    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropColumn(['subtotal', 'pajak']);
        });
    }
};
