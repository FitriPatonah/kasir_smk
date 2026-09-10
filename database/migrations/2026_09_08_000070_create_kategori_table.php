<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategori', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 80)->unique();
            $table->string('deskripsi')->nullable();
            $table->timestamps();
        });

        $now = now();
        DB::table('kategori')->insert(array_map(fn ($nama) => [
            'nama' => $nama,
            'deskripsi' => null,
            'created_at' => $now,
            'updated_at' => $now,
        ], [
            'Minuman',
            'Mie & Makanan Instan',
            'Bumbu & Masak',
            'Snack',
            'Kebersihan & Toiletries',
            'Lainnya',
        ]));
    }

    public function down(): void
    {
        Schema::dropIfExists('kategori');
    }
};