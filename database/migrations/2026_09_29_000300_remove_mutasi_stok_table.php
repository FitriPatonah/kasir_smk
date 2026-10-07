<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('mutasi_stok');
    }

    public function down(): void
    {
        // Riwayat mutasi stok sudah tidak digunakan oleh sistem.
    }
};
