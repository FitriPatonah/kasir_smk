<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Pengaturan;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\MutasiStok;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
     * ==========================================
     * HALAMAN KASIR
     * ==========================================
     */
    public function index()
    {

        $produk =
            Produk::orderBy(
                'nama_produk'
            )->get();


        $kategoriProduk =
            self::KATEGORI_PRODUK;


        $pengaturan =
            Pengaturan::ambil();


        return view(
            'kasir.index',
            compact(
                'produk',
                'kategoriProduk',
                'pengaturan'
            )
        );

    }


    /**
     * ==========================================
     * RIWAYAT TRANSAKSI
     * ==========================================
     */
    public function riwayatTransaksi()
    {

        $kasirId =
            Auth::guard(
                'kasir'
            )->id();


        $transaksi =
            Transaksi::with('detail')

                ->where(function ($query) use ($kasirId) {

                    // Transaksi milik kasir yang sedang login...
                    $query->where(
                        'kasir_id',
                        $kasirId
                    )

                        // ...ATAU transaksi lama (sebelum fitur ini
                        // ada) yang kasir_id-nya belum tercatat, TAPI
                        // tetap transaksi ASLI (bukan data simulasi
                        // buat latihan model prediksi stok).
                        ->orWhere(function ($q) {
                            $q->whereNull('kasir_id')
                                ->where('sumber_data', 'asli');
                        });

                })

                ->orderByDesc(
                    'created_at'
                )

                ->get()

                ->map(
                    function ($item) {

                        $item->jumlah_item =
                            $item->detail->sum(
                                'qty'
                            );


                        $item->tanggal =
                            $item->created_at
                                ->translatedFormat(
                                    'd F Y'
                                );


                        $item->jam =
                            $item->created_at
                                ->translatedFormat(
                                    'H:i:s'
                                );


                        return $item;

                    }
                );


        return view(
            'kasir.riwayat',
            compact(
                'transaksi'
            )
        );

    }


    /**
     * ==========================================
     * DOWNLOAD EXCEL RIWAYAT TRANSAKSI (KASIR)
     * ==========================================
     *
     * Memakai kelas export yang sama seperti punya admin
     * (App\Exports\TransaksiExport), supaya format & kolomnya
     * konsisten -- tidak ada dua sumber kebenaran untuk 1 format
     * Excel. Tidak ada filter tanggal di sini karena halaman
     * Riwayat kasir sendiri tidak punya filter tanggal (beda
     * dengan halaman Transaksi admin).
     *
     * Difilter cuma transaksi milik kasir yang sedang login --
     * konsisten dengan apa yang dia lihat di halaman Riwayat-nya.
     */
    public function exportRiwayat()
    {
        $kasirId =
            Auth::guard(
                'kasir'
            )->id();

        return (new \App\Exports\TransaksiExport)->download(null, null, $kasirId);
    }


    /**
     * ==========================================
     * CARI PRODUK BERDASARKAN BARCODE
     * ==========================================
     */
    public function cariProduk(
        Request $request
    ) {

        $barcode =
            trim(
                (string)
                $request->query(
                    'barcode'
                )
            );


        if ($barcode === '') {

            return response()->json([

                'sukses' => false,

                'pesan' =>
                    'Barcode kosong',

            ]);

        }


        $produk =
            Produk::where(
                'barcode',
                $barcode
            )->first();


        if (! $produk) {

            return response()->json([

                'sukses' => false,

                'pesan' =>
                    "Produk dengan barcode \"$barcode\" tidak ditemukan",

            ]);

        }


        if ($produk->stok <= 0) {

            return response()->json([

                'sukses' => false,

                'pesan' =>
                    "Stok produk \"{$produk->nama_produk}\" habis",

            ]);

        }


        return response()->json([

            'sukses' => true,

            'produk' => [

                'id' =>
                    $produk->id,

                'barcode' =>
                    $produk->barcode,

                'nama_produk' =>
                    $produk->nama_produk,

                'kategori' =>
                    $produk->kategori,

                'harga' =>
                    (int) $produk->harga,

                'stok' =>
                    (int) $produk->stok,

                'pajak' =>
                    (int) ($produk->pajak ?? 0),

                'foto' =>
                    $produk->foto
                        ? asset(
                            'storage/' .
                            $produk->foto
                        )
                        : null,

            ],

        ]);

    }


    /**
     * ==========================================
     * CARI PRODUK BERDASARKAN NAMA
     * ==========================================
     */
    public function cariNama(
        Request $request
    ) {

        $kata =
            trim(
                (string)
                $request->query(
                    'q'
                )
            );


        if (
            $kata === '' ||
            strlen($kata) < 2
        ) {

            return response()->json([

                'produk' => [],

            ]);

        }


        $hasil =
            Produk::where(
                'nama_produk',
                'like',
                "%{$kata}%"
            )

            ->orWhere(
                'barcode',
                'like',
                "%{$kata}%"
            )

            ->orderBy(
                'nama_produk'
            )

            ->limit(10)

            ->get()

            ->map(
                function ($produk) {

                    return [

                        'id' =>
                            $produk->id,

                        'barcode' =>
                            $produk->barcode,

                        'nama_produk' =>
                            $produk->nama_produk,

                        'kategori' =>
                            $produk->kategori,

                        'harga' =>
                            (int) $produk->harga,

                        'stok' =>
                            (int) $produk->stok,

                        'pajak' =>
                            (int) ($produk->pajak ?? 0),

                        'foto' =>
                            $produk->foto
                                ? asset(
                                    'storage/' .
                                    $produk->foto
                                )
                                : null,

                    ];

                }
            );


        return response()->json([

            'produk' =>
                $hasil,

        ]);

    }


    /**
     * ==========================================
     * CHECKOUT / PEMBAYARAN
     * ==========================================
     *
     * Pajak diambil dari Pengaturan Admin.
     *
     * Contoh:
     *
     * Harga produk : Rp5.000
     * Pajak Admin  : 1%
     *
     * Pajak:
     * Rp5.000 x 1% = Rp50
     *
     * Total:
     * Rp5.000 + Rp50 = Rp5.050
     */
    public function checkout(
        Request $request
    ) {

        $data =
            $request->validate([

                'keranjang' =>
                    'required|array|min:1',

                'keranjang.*.id' =>
                    'required|integer|exists:produk,id',

                'keranjang.*.nama_produk' =>
                    'required|string',

                'keranjang.*.harga' =>
                    'required|integer|min:0',

                'keranjang.*.qty' =>
                    'required|integer|min:1',

                'total' =>
                    'required|integer|min:0',

                'bayar' =>
                    'required|integer|min:0',

                'metode_pembayaran' =>
                    'required|in:cash,qris,transfer',

            ]);


        /**
         * ==========================================
         * AMBIL PENGATURAN ADMIN
         * ==========================================
         */
        $pengaturan =
            Pengaturan::ambil();


        /**
         * ==========================================
         * CEK METODE PEMBAYARAN
         * ==========================================
         */
        $metodeAktif = [

            'cash' =>
                (bool)
                $pengaturan->metode_cash,

            'qris' =>
                (bool)
                $pengaturan->metode_qris,

            'transfer' =>
                (bool)
                $pengaturan->metode_transfer,

        ];


        if (
            ! (
                $metodeAktif[
                    $data['metode_pembayaran']
                ] ?? false
            )
        ) {

            return response()->json([

                'sukses' =>
                    false,

                'pesan' =>
                    'Metode pembayaran ' .
                    strtoupper(
                        $data['metode_pembayaran']
                    ) .
                    ' sedang dinonaktifkan.',

            ], 422);

        }


        $kasirId =
            Auth::guard(
                'kasir'
            )->id();


        try {

            $hasil =
                DB::transaction(
                    function () use (
                        $data,
                        $kasirId
                    ) {


                        /**
                         * ==========================================
                         * 1. CEK PRODUK + STOK + HITUNG SUB TOTAL & PAJAK
                         * ==========================================
                         *
                         * Harga dan Pajak diambil dari DATABASE.
                         *
                         * Jadi harga dari browser tidak dipercaya
                         * untuk menghitung total transaksi.
                         */
                        $subtotal =
                            0;

                        $totalPajak =
                            0;


                        $produkDipesan =
                            [];


                        foreach (
                            $data['keranjang']
                            as $item
                        ) {

                            $produk =
                                Produk::where(
                                    'id',
                                    $item['id']
                                )

                                ->lockForUpdate()

                                ->first();


                            if (! $produk) {

                                throw ValidationException::withMessages([

                                    'produk' => [
                                        'Produk tidak ditemukan.'
                                    ],

                                ]);

                            }


                            if (
                                $produk->stok <
                                $item['qty']
                            ) {

                                throw ValidationException::withMessages([

                                    'stok' => [
                                        "Stok tidak mencukupi untuk produk: {$produk->nama_produk}"
                                    ],

                                ]);

                            }


                            /**
                             * Harga asli dari database.
                             */
                            $harga =
                                (int)
                                $produk->harga;


                            $qty =
                                (int)
                                $item['qty'];


                            /**
                             * Subtotal produk.
                             */
                            $nilaiSubtotal =
                                $harga * $qty;


                            $subtotal +=
                                $nilaiSubtotal;


                            /**
                             * Pajak per produk.
                             */
                            $persenPajak =
                                (int)
                                ($produk->pajak ?? 0);

                            $pajakItem =
                                (int)
                                round(
                                    $nilaiSubtotal *
                                    $persenPajak /
                                    100
                                );

                            $totalPajak +=
                                $pajakItem;


                            $produkDipesan[] = [

                                'produk' =>
                                    $produk,

                                'qty' =>
                                    $qty,

                                'harga' =>
                                    $harga,

                                'subtotal' =>
                                    $nilaiSubtotal,

                            ];

                        }


                        /**
                         * ==========================================
                         * 2. HITUNG PAJAK & TOTAL AKHIR
                         * ==========================================
                         */
                        $pajak =
                            $totalPajak;


                        /**
                         * ==========================================
                         * 3. HITUNG TOTAL AKHIR
                         * ==========================================
                         */
                        $total =
                            $subtotal +
                            $pajak;


                        /**
                         * ==========================================
                         * 4. CEK PEMBAYARAN
                         * ==========================================
                         */
                        if (
                            $data['bayar'] <
                            $total
                        ) {

                            throw ValidationException::withMessages([

                                'bayar' => [
                                    'Uang yang diberikan kurang dari total belanja.'
                                ],

                            ]);

                        }


                        $kembalian =
                            $data['bayar'] -
                            $total;


                        /**
                         * ==========================================
                         * 5. NOMOR TRANSAKSI
                         * ==========================================
                         *
                         * Format:
                         *
                         * TRX-20260911-000001
                         */
                        $tanggal =
                            now()->format(
                                'Ymd'
                            );


                        $prefix =
                            "TRX-{$tanggal}-";


                        $transaksiTerakhirHariIni =
                            Transaksi::where(
                                'no_transaksi',
                                'like',
                                "{$prefix}%"
                            )

                            ->lockForUpdate()

                            ->orderByDesc(
                                'no_transaksi'
                            )

                            ->first();


                        $nomorUrut =
                            1;


                        if (
                            $transaksiTerakhirHariIni
                        ) {

                            $nomorUrutTerakhir =
                                (int)
                                substr(
                                    $transaksiTerakhirHariIni
                                        ->no_transaksi,
                                    -6
                                );


                            $nomorUrut =
                                $nomorUrutTerakhir +
                                1;

                        }


                        $noTransaksi =
                            $prefix .
                            str_pad(
                                $nomorUrut,
                                6,
                                '0',
                                STR_PAD_LEFT
                            );


                        /**
                         * ==========================================
                         * 6. SIMPAN TRANSAKSI
                         * ==========================================
                         *
                         * Kolom total berisi TOTAL SETELAH PAJAK.
                         */
                        $transaksi =
                            Transaksi::create([

                                'no_transaksi' =>
                                    $noTransaksi,

                                'subtotal' =>
                                    $subtotal,

                                'pajak' =>
                                    $pajak,

                                'total' =>
                                    $total,

                                'bayar' =>
                                    $data['bayar'],

                                'kembalian' =>
                                    $kembalian,

                                'metode_pembayaran' =>
                                    $data[
                                        'metode_pembayaran'
                                    ],

                                'kasir_id' =>
                                    $kasirId,

                            ]);


                        /**
                         * ==========================================
                         * 7. KURANGI STOK + SIMPAN DETAIL
                         * ==========================================
                         */
                        foreach (
                            $produkDipesan
                            as $pesanan
                        ) {

                            $produk =
                                $pesanan['produk'];


                            $qty =
                                $pesanan['qty'];


                            $harga =
                                $pesanan['harga'];


                            $nilaiSubtotal =
                                $pesanan['subtotal'];


                            /**
                             * Kurangi stok.
                             */
                            $produk->decrement(
                                'stok',
                                $qty
                            );


                            /**
                             * Simpan mutasi stok.
                             */
                            MutasiStok::create([

                                'produk_id' =>
                                    $produk->id,

                                'tipe' =>
                                    'keluar',

                                'sumber' =>
                                    'penjualan',

                                'jumlah' =>
                                    $qty,

                                'keterangan' =>
                                    'Penjualan ' .
                                    $noTransaksi,

                                'user_id' =>
                                    $kasirId,

                            ]);


                            /**
                             * Simpan detail transaksi.
                             *
                             * Harga tetap harga produk.
                             * Pajak diterapkan pada total transaksi.
                             */
                            TransaksiDetail::create([

                                'transaksi_id' =>
                                    $transaksi->id,

                                'produk_id' =>
                                    $produk->id,

                                'nama_produk' =>
                                    $produk->nama_produk,

                                'harga' =>
                                    $harga,

                                'qty' =>
                                    $qty,

                                'subtotal' =>
                                    $nilaiSubtotal,

                            ]);

                        }


                        /**
                         * Kembalikan data hasil checkout.
                         */
                        return [

                            'transaksi' =>
                                $transaksi,

                            'subtotal' =>
                                $subtotal,

                            'pajak' =>
                                $pajak,

                            'total' =>
                                $total,

                        ];

                    }
                );


            $transaksi =
                $hasil['transaksi'];


            /**
             * ==========================================
             * RESPONSE KE JAVASCRIPT
             * ==========================================
             */
            return response()->json([

                'sukses' =>
                    true,

                'no_transaksi' =>
                    $transaksi->no_transaksi,

                'subtotal' =>
                    $hasil['subtotal'],

                'pajak' =>
                    $hasil['pajak'],

                'total' =>
                    $hasil['total'],

                'bayar' =>
                    $transaksi->bayar,

                'kembalian' =>
                    $transaksi->kembalian,

                'metode_pembayaran' =>
                    $transaksi->metode_pembayaran,

            ]);


        } catch (
            ValidationException $e
        ) {

            return response()->json([

                'sukses' =>
                    false,

                'pesan' =>
                    collect(
                        $e->errors()
                    )
                    ->flatten()
                    ->first(),

            ], 422);

        }

    }


    /**
     * ==========================================
     * PROFIL KASIR
     * ==========================================
     */
    public function profil()
    {

        $user =
            Auth::guard(
                'kasir'
            )->user();


        return view(
            'kasir.profil',
            compact(
                'user'
            )
        );

    }


    /**
     * ==========================================
     * UPDATE PROFIL / PASSWORD
     * ==========================================
     *
     * Nama dan email tidak diubah oleh
     * kasir melalui halaman profil.
     *
     * Kasir hanya dapat mengganti password.
     */
    public function updateProfil(
        Request $request
    ) {

        $user =
            Auth::guard(
                'kasir'
            )->user();


        $data =
            $request->validate([

                'password_lama' =>
                    [
                        'nullable',
                        'string'
                    ],

                'password' =>
                    [
                        'nullable',
                        'string',
                        'min:6',
                        'confirmed'
                    ],

            ]);


        /**
         * Tidak ada password baru.
         */
        if (
            empty(
                $data['password']
            )
        ) {

            return redirect()
                ->route(
                    'kasir.profil'
                )
                ->with(
                    'success',
                    'Tidak ada perubahan pada profil.'
                );

        }


        /**
         * Password lama wajib benar.
         */
        if (

            empty(
                $data['password_lama']
            )

            ||

            ! Hash::check(
                $data['password_lama'],
                $user->password
            )

        ) {

            throw ValidationException::withMessages([

                'password_lama' => [
                    'Password lama yang Anda masukkan salah.'
                ],

            ]);

        }


        /**
         * Simpan password baru.
         */
        $user->update([

            'password' =>
                Hash::make(
                    $data['password']
                ),

        ]);


        /**
         * Kirim notifikasi ke email kasir sendiri, supaya dia sadar
         * kalau passwordnya baru saja diganti -- kalau ternyata bukan
         * dia yang ganti, dia bisa langsung curiga & lapor ke admin.
         *
         * Dibungkus try-catch: gagal kirim email TIDAK boleh
         * menggagalkan proses ganti password itu sendiri.
         */
        if ($user->email) {
            try {
                \Illuminate\Support\Facades\Mail::to($user->email)->send(
                    new \App\Mail\UserDiubahMail($user, ['Password'])
                );
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning(
                    'Gagal mengirim notifikasi ganti password (kasir): ' . $e->getMessage()
                );
            }
        }


        return redirect()
            ->route(
                'kasir.profil'
            )
            ->with(
                'success',
                'Password berhasil diperbarui.'
            );

    }

}