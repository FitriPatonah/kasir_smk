<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaturan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_toko', 150)->default('Toko Saya');
            $table->string('telepon', 30)->nullable();
            $table->text('alamat')->nullable();
            $table->unsignedTinyInteger('persentase_pajak')->default(0);
            $table->boolean('metode_cash')->default(true);
            $table->boolean('metode_qris')->default(true);
            $table->boolean('metode_transfer')->default(true);
            $table->string('info_rekening', 150)->nullable();
            $table->text('header_struk')->nullable();
            $table->text('footer_struk')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturan');
    }
};
