<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('transaksi', 'kasir_id')) {
            Schema::table('transaksi', function (Blueprint $table) {
                $table->foreignId('kasir_id')->nullable()->after('no_transaksi')->constrained('users')->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('transaksi', 'kasir_id')) {
            Schema::table('transaksi', function (Blueprint $table) {
                $table->dropForeign(['kasir_id']);
                $table->dropColumn('kasir_id');
            });
        }
    }
};
