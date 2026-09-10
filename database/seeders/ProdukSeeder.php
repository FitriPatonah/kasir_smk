<?php

namespace Database\Seeders;

use App\Models\Produk;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        $produkList = [
            ['barcode' => '8991001234567', 'nama_produk' => 'Indomie Goreng',      'harga' => 3500,  'stok' => 100],
            ['barcode' => '8991001234568', 'nama_produk' => 'Aqua Botol 600ml',    'harga' => 4000,  'stok' => 100],
            ['barcode' => '8991001234569', 'nama_produk' => 'Teh Botol Sosro',     'harga' => 5000,  'stok' => 100],
            ['barcode' => '8991001234570', 'nama_produk' => 'Beras 5kg',           'harga' => 65000, 'stok' => 50],
            ['barcode' => '8991001234571', 'nama_produk' => 'Minyak Goreng 1L',    'harga' => 18000, 'stok' => 50],
            ['barcode' => '8991001234572', 'nama_produk' => 'Gula Pasir 1kg',      'harga' => 15000, 'stok' => 50],
            ['barcode' => '8991001234573', 'nama_produk' => 'Telur Ayam 1kg',      'harga' => 28000, 'stok' => 50],
            ['barcode' => '8991001234574', 'nama_produk' => 'Sabun Mandi Lifebuoy','harga' => 5500,  'stok' => 80],
            ['barcode' => '8991001234575', 'nama_produk' => 'Shampo Sachet',       'harga' => 1500,  'stok' => 200],
            ['barcode' => '8991001234576', 'nama_produk' => 'Roti Tawar',          'harga' => 15000, 'stok' => 40],
        ];

        foreach ($produkList as $produk) {
            Produk::updateOrCreate(['barcode' => $produk['barcode']], $produk);
        }
    }
}
