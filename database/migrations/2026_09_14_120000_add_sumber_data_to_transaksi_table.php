<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * PENTING: kolom ini adalah penanda transparansi data.
     *
     * 'asli'     = transaksi sungguhan, dibuat lewat proses checkout kasir.
     * 'simulasi' = data buatan (lihat DemoSeeder.php) untuk melatih model
     *              prediksi stok karena riwayat transaksi asli masih
     *              sedikit. TIDAK PERNAH dimaksudkan untuk disamarkan
     *              sebagai transaksi asli.
     */
    public function up(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->enum('sumber_data', ['asli', 'simulasi'])
                ->default('asli')
                ->after('kasir_id');
        });
    }

    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropColumn('sumber_data');
        });
    }
};
