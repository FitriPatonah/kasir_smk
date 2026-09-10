<?php

namespace App\Http\Controllers;

use App\Models\MutasiStok;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StokController extends Controller
{
    public function index(string $role = 'admin', string $mode = 'masuk')
    {
        if (!in_array($role, ['admin', 'kasir'], true)) {
            $role = 'admin';
        }

        $produk = Produk::orderBy('nama_produk')->get();

        return view('stok.index', compact('produk', 'role'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'produk_id' => ['required', 'integer', 'exists:produk,id'],
            // Admin sekarang boleh mencatat stok keluar manual (rusak, hilang,
            // kadaluarsa, retur ke supplier, dll), bukan cuma stok masuk.
            // Stok keluar dari penjualan TETAP hanya dibuat otomatis oleh
            // KasirController::checkout, tidak lewat form ini.
            'tipe' => ['required', 'in:masuk,keluar'],
            'jumlah' => ['required', 'integer', 'min:1'],
            // Untuk stok keluar manual, alasan wajib diisi supaya riwayatnya
            // bisa dipertanggungjawabkan saat audit (kenapa stok berkurang
            // padahal bukan dari transaksi kasir).
            'keterangan' => ['nullable', 'string', 'max:255', 'required_if:tipe,keluar'],
            'role' => ['required', 'in:admin'],
        ], [
            'keterangan.required_if' => 'Alasan stok keluar wajib diisi (contoh: rusak, hilang, kadaluarsa, retur ke supplier).',
        ]);

        abort_unless(Auth::guard('admin')->check(), 403);
        $user = Auth::guard('admin')->user();

        try {
            DB::transaction(function () use ($data, $user) {
                $produk = Produk::whereKey($data['produk_id'])->lockForUpdate()->firstOrFail();

                if ($data['tipe'] === 'keluar' && $produk->stok < $data['jumlah']) {
                    throw ValidationException::withMessages([
                        'jumlah' => "Stok {$produk->nama_produk} hanya tersisa {$produk->stok}.",
                    ]);
                }

                $perubahan = $data['tipe'] === 'masuk' ? $data['jumlah'] : -$data['jumlah'];
                $produk->increment('stok', $perubahan);

                MutasiStok::create([
                    'produk_id' => $produk->id,
                    'tipe' => $data['tipe'],
                    // Selalu 'manual' di sini secara sengaja: form ini cuma
                    // dipakai admin. Nilainya TIDAK diambil dari input request,
                    // supaya tidak bisa dipalsukan jadi seolah-olah 'penjualan'.
                    'sumber' => 'manual',
                    'jumlah' => $data['jumlah'],
                    'keterangan' => $data['keterangan'] ?? null,
                    'user_id' => $user->id,
                ]);
            });
        } catch (ValidationException $exception) {
            return back()->withErrors($exception->errors())->withInput();
        }

        $pesan = $data['tipe'] === 'masuk' ? 'Stok masuk berhasil dicatat.' : 'Stok keluar berhasil dicatat.';

        return redirect()->route($data['tipe'] === 'masuk' ? 'admin.stok.masuk' : 'admin.stok.keluar')
            ->with('success', $pesan);
    }
}
