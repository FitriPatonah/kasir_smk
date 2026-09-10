<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Pengaturan;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
use App\Models\MutasiStok;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class KasirController extends Controller
{
    private const KATEGORI_PRODUK = [
        'Minuman',
        'Mie & Makanan Instan',
        'Bumbu & Masak',
        'Snack',
        'Kebersihan & Toiletries',
        'Lainnya',
    ];

    /**
     * Tampilkan halaman kasir.
     */
    public function index()
    {
        $produk = Produk::orderBy('nama_produk')->get();
        $kategoriProduk = self::KATEGORI_PRODUK;
        $pengaturan = Pengaturan::ambil();

        return view('kasir.index', compact('produk', 'kategoriProduk', 'pengaturan'));
    }

    /**
     * Tampilkan riwayat semua transaksi.
     */
    public function riwayatTransaksi()
    {
        $transaksi = Transaksi::with('detail')
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($item) {
                $item->jumlah_item = $item->detail->sum('qty');
                $item->tanggal = $item->created_at->translatedFormat('d F Y');
                $item->jam = $item->created_at->translatedFormat('H:i:s');
                return $item;
            });

        return view('kasir.riwayat', compact('transaksi'));
    }

    /**
     * Cari produk berdasarkan barcode (dipanggil lewat AJAX saat scan).
     */
    public function cariProduk(Request $request)
    {
        $barcode = trim((string) $request->query('barcode'));

        if ($barcode === '') {
            return response()->json([
                'sukses' => false,
                'pesan' => 'Barcode kosong',
            ]);
        }

        $produk = Produk::where('barcode', $barcode)->first();

        if (! $produk) {
            return response()->json([
                'sukses' => false,
                'pesan' => "Produk dengan barcode \"$barcode\" tidak ditemukan",
            ]);
        }

        if ($produk->stok <= 0) {
            return response()->json([
                'sukses' => false,

                'pesan' => "Stok produk \"{$produk->nama_produk}\" habis",
            ]);
        }

        return response()->json([
            'sukses' => true,
            'produk' => [
                'id' => $produk->id,
                'barcode' => $produk->barcode,
                'nama_produk' => $produk->nama_produk,
                'kategori' => $produk->kategori,
                'harga' => (int) $produk->harga,
                'stok' => (int) $produk->stok,
                'foto' => $produk->foto ? asset('storage/'.$produk->foto) : null,
            ],
        ]);
    }

    /**
     * Cari produk berdasarkan nama (untuk kotak pencarian / autocomplete).
     * Dipanggil lewat AJAX setiap kali kasir mengetik di kotak "Cari Nama Produk".
     */
    public function cariNama(Request $request)
    {
        $kata = trim((string) $request->query('q'));

        if ($kata === '' || strlen($kata) < 2) {
            return response()->json(['produk' => []]);
        }

        $hasil = Produk::where('nama_produk', 'like', "%{$kata}%")
            ->orWhere('barcode', 'like', "%{$kata}%")
            ->orderBy('nama_produk')
            ->limit(10)
            ->get()
            ->map(function ($produk) {
                return [
                    'id' => $produk->id,
                    'barcode' => $produk->barcode,
                    'nama_produk' => $produk->nama_produk,
                    'kategori' => $produk->kategori,
                    'harga' => (int) $produk->harga,
                    'stok' => (int) $produk->stok,
                    'foto' => $produk->foto ? asset('storage/'.$produk->foto) : null,
                ];
            });

        return response()->json(['produk' => $hasil]);
    }

    /**
     * Proses pembayaran: simpan transaksi, detail item, dan kurangi stok.
     */
    public function checkout(Request $request)
    {
        $data = $request->validate([
            'keranjang' => 'required|array|min:1',
            'keranjang.*.id' => 'required|integer|exists:produk,id',
            'keranjang.*.nama_produk' => 'required|string',
            'keranjang.*.harga' => 'required|integer|min:0',
            'keranjang.*.qty' => 'required|integer|min:1',
            'total' => 'required|integer|min:0',
            'bayar' => 'required|integer|min:0',
            'metode_pembayaran' => 'required|in:cash,qris,transfer',
        ]);

        // Pastikan metode yang dipilih masih aktif di pengaturan admin.
        $pengaturan = Pengaturan::ambil();

        $metodeAktif = [
            'cash' => (bool) $pengaturan->metode_cash,
            'qris' => (bool) $pengaturan->metode_qris,
            'transfer' => (bool) $pengaturan->metode_transfer,
        ];

        if (! ($metodeAktif[$data['metode_pembayaran']] ?? false)) {
            return response()->json([
                'sukses' => false,
                'pesan' => 'Metode pembayaran ' . strtoupper($data['metode_pembayaran']) . ' sedang dinonaktifkan.',
            ], 422);
        }

        if ($data['bayar'] < $data['total']) {
            return response()->json([
                'sukses' => false,
                'pesan' => 'Uang yang diberikan kurang dari total belanja',
            ]);
        }

        $kembalian = $data['bayar'] - $data['total'];
        $kasirId = Auth::guard('kasir')->id();
        try {
            $transaksi = DB::transaction(function () use ($data, $kembalian, $kasirId) {
                // Buat nomor transaksi format: TRX-20260910-000001
                // Nomor urutnya berdasarkan tanggal HARI INI, dikunci (lockForUpdate)
                // supaya aman kalau ada beberapa transaksi checkout hampir bersamaan.
                $tanggal = now()->format('Ymd');
                $prefix = "TRX-{$tanggal}-";

                $transaksiTerakhirHariIni = Transaksi::where('no_transaksi', 'like', "{$prefix}%")
                    ->lockForUpdate()
                    ->orderByDesc('no_transaksi')
                    ->first();

                $nomorUrut = 1;
                if ($transaksiTerakhirHariIni) {
                    $nomorUrutTerakhir = (int) substr($transaksiTerakhirHariIni->no_transaksi, -6);
                    $nomorUrut = $nomorUrutTerakhir + 1;
                }

                $noTransaksi = $prefix.str_pad($nomorUrut, 6, '0', STR_PAD_LEFT);

                $transaksi = Transaksi::create([
                    'no_transaksi' => $noTransaksi,
                    'total' => $data['total'],
                    'bayar' => $data['bayar'],
                    'kembalian' => $kembalian,
                    'metode_pembayaran' => $data['metode_pembayaran'],
                ]);

                foreach ($data['keranjang'] as $item) {
                    $produk = Produk::where('id', $item['id'])
                        ->lockForUpdate()
                        ->first();

                    if (! $produk || $produk->stok < $item['qty']) {
                        throw ValidationException::withMessages([
                            'stok' => "Stok tidak mencukupi untuk produk: {$item['nama_produk']}",
                        ]);
                    }

                    $produk->decrement('stok', $item['qty']);

                    MutasiStok::create([
                        'produk_id' => $produk->id,
                        'tipe' => 'keluar',
                        'sumber' => 'penjualan',
                        'jumlah' => $item['qty'],
                        'keterangan' => 'Penjualan ' . $noTransaksi,
                        'user_id' => $kasirId,
                    ]);

                    TransaksiDetail::create([
                        'transaksi_id' => $transaksi->id,
                        'produk_id' => $item['id'],
                        'nama_produk' => $item['nama_produk'],
                        'harga' => $item['harga'],
                        'qty' => $item['qty'],
                        'subtotal' => $item['harga'] * $item['qty'],
                    ]);
                }

                return $transaksi;
            });

            return response()->json([
                'sukses' => true,
                'no_transaksi' => $transaksi->no_transaksi,
                'total' => $transaksi->total,
                'bayar' => $transaksi->bayar,
                'kembalian' => $transaksi->kembalian,
                'metode_pembayaran' => $transaksi->metode_pembayaran,
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'sukses' => false,
                'pesan' => collect($e->errors())->flatten()->first(),
            ]);
        }
    }
}
