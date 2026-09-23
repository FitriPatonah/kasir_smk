<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->foreignId('kasir_id')
                ->nullable()
                ->after('no_transaksi')
                ->constrained('users')
                ->nullOnDelete();
        });

        // Isi kasir untuk transaksi lama berdasarkan mutasi stok penjualan.
        DB::table('transaksi')->orderBy('id')->eachById(function ($transaksi) {
            $kasirId = DB::table('mutasi_stok')
                ->where('keterangan', 'Penjualan ' . $transaksi->no_transaksi)
                ->whereNotNull('user_id')
                ->value('user_id');

            if ($kasirId) {
                DB::table('transaksi')
                    ->where('id', $transaksi->id)
                    ->update(['kasir_id' => $kasirId]);
            }
        });
    }

    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropForeign(['kasir_id']);
            $table->dropColumn('kasir_id');
        });
    }
};
