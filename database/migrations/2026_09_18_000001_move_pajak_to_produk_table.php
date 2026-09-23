<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration.
     *
     * Memindahkan pajak dari Pengaturan toko ke masing-masing Produk.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('produk', 'pajak')) {
            Schema::table('produk', function (Blueprint $table) {
                $table->unsignedTinyInteger('pajak')->default(0)->after('stok');
            });
        }

        if (Schema::hasColumn('pengaturan', 'persentase_pajak')) {
            Schema::table('pengaturan', function (Blueprint $table) {
                $table->dropColumn('persentase_pajak');
            });
        }
    }

    /**
     * Batalkan migration.
     */
    public function down(): void
    {
        if (Schema::hasColumn('produk', 'pajak')) {
            Schema::table('produk', function (Blueprint $table) {
                $table->dropColumn('pajak');
            });
        }

        if (!Schema::hasColumn('pengaturan', 'persentase_pajak')) {
            Schema::table('pengaturan', function (Blueprint $table) {
                $table->unsignedTinyInteger('persentase_pajak')->default(0)->after('alamat');
            });
        }
    }
};
