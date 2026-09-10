<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $table = 'pengaturan';

    protected $fillable = [
        'nama_toko',
        'telepon',
        'alamat',
        'persentase_pajak',
        'metode_cash',
        'metode_qris',
        'metode_transfer',
        'info_rekening',
        'header_struk',
        'footer_struk',
    ];

    protected $casts = [
        'metode_cash' => 'boolean',
        'metode_qris' => 'boolean',
        'metode_transfer' => 'boolean',
        'persentase_pajak' => 'integer',
    ];

    /**
     * Ambil baris pengaturan yang aktif. Kalau belum ada sama sekali
     * (misal baru pertama kali install), otomatis buat 1 baris default.
     */
    public static function ambil(): self
    {
        return static::firstOrCreate(['id' => 1], [
            'nama_toko' => 'Toko Saya',
            'header_struk' => 'Terima kasih telah berbelanja!',
            'footer_struk' => 'Barang yang sudah dibeli tidak dapat ditukar',
        ]);
    }
}
