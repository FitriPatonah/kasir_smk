<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';

    protected $fillable = [
        'barcode',
        'nama_produk',
        'kategori',
        'harga',
        'stok',
        'pajak',
        'foto',
    ];

    protected $casts = [
        'harga' => 'integer',
        'stok' => 'integer',
        'pajak' => 'integer',
    ];

    public function transaksiDetail()
    {
        return $this->hasMany(TransaksiDetail::class, 'produk_id');
    }
}
