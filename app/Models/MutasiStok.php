<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MutasiStok extends Model
{
    protected $table = 'mutasi_stok';

    protected $fillable = [
        'produk_id',
        'tipe',
        'sumber',
        'jumlah',
        'keterangan',
        'user_id',
    ];

    /**
     * 'manual'    = diinput admin lewat halaman Stok Masuk/Stok Keluar.
     * 'penjualan' = otomatis dibuat sistem saat kasir checkout.
     */
    public function isOtomatis(): bool
    {
        return $this->sumber === 'penjualan';
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
