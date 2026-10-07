<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Produk;

class StokController extends Controller
{
    public function index(string $role = 'admin')
    {
        if (!in_array($role, ['admin', 'kasir'], true)) {
            $role = 'admin';
        }

        $produk = Produk::orderBy('nama_produk')->get();

        if ($role === 'kasir') {
            return view('kasir.stok', compact('produk'));
        }

        return view('stok.index', compact('produk', 'role'));
    }

    public function adjust(Request $request, int $id)
    {
        $data = $request->validate([
            'aksi' => ['required', 'in:tambah,kurangi'],
        ]);

        $hasil = DB::transaction(function () use ($data, $id) {
            $produk = Produk::whereKey($id)->lockForUpdate()->firstOrFail();

            if ($data['aksi'] === 'kurangi' && $produk->stok < 1) {
                return false;
            }

            $produk->stok += $data['aksi'] === 'tambah' ? 1 : -1;
            $produk->save();

            return true;
        });

        if (! $hasil) {
            return redirect()->route('admin.stok')->with('error', 'Stok produk sudah 0 dan tidak dapat dikurangi lagi.');
        }

        return redirect()->route('admin.stok')->with('success', 'Stok produk berhasil diperbarui.');
    }
}
