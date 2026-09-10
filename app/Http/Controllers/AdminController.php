<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
use App\Models\Kategori;
use App\Models\MutasiStok;
use App\Models\Produk;
use App\Models\Supplier;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
    * Dashboard admin berisi statistik singkat.
     */
    public function dashboard()
    {
        $produk = Produk::orderBy('nama_produk')->get();

        $jumlahProduk = $produk->count();
        $totalStok = $produk->sum('stok');
        $jumlahTransaksi = Transaksi::count();
        $transaksiHariIni = Transaksi::whereDate('created_at', today())->count();
        $totalPendapatan = Transaksi::sum('total');
        $omzetHariIni = Transaksi::whereDate('created_at', today())->sum('total');

        // ==========================================
        // GRAFIK PENJUALAN 7 HARI TERAKHIR (data asli, bukan contoh lagi)
        // ==========================================
        $labelHari = [];
        $penjualan7Hari = [];
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = now()->subDays($i);
            $labelHari[] = $tanggal->translatedFormat('D');
            $penjualan7Hari[] = (int) Transaksi::whereDate('created_at', $tanggal->toDateString())->sum('total');
        }
        $maxPenjualan = max(1, max($penjualan7Hari));

        // ==========================================
        // PRODUK TERLARIS BULAN INI (dari data transaksi asli)
        // ==========================================
        $produkTerlaris = DB::table('transaksi_detail')
            ->join('transaksi', 'transaksi.id', '=', 'transaksi_detail.transaksi_id')
            ->whereMonth('transaksi.created_at', now()->month)
            ->whereYear('transaksi.created_at', now()->year)
            ->select('transaksi_detail.nama_produk', DB::raw('SUM(transaksi_detail.qty) as total_qty'))
            ->groupBy('transaksi_detail.nama_produk')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();
        $maxTerlaris = max(1, $produkTerlaris->max('total_qty') ?? 1);

        return view('admin.dashboard', compact(
            'jumlahProduk',
            'totalStok',
            'jumlahTransaksi',
            'transaksiHariIni',
            'totalPendapatan',
            'omzetHariIni',
            'labelHari',
            'penjualan7Hari',
            'maxPenjualan',
            'produkTerlaris',
            'maxTerlaris'
        ));
    }

    /**
     * Halaman khusus untuk mengelola produk.
     */
    public function produk()
    {
        $produk = Produk::orderBy('nama_produk')->get();

        return view('admin.produk', [
            'produk' => $produk,
            'kategoriProduk' => Kategori::orderBy('nama')->pluck('nama'),
        ]);
    }

    /**
     * Form tambah produk pada halaman khusus.
     */
    public function tambahProduk()
    {
        return view('admin.produk-tambah', [
            'kategoriProduk' => Kategori::orderBy('nama')->pluck('nama'),
        ]);
    }

    /**
     * Tampilkan ringkasan kategori produk.
     */
    public function kategori()
    {
        $kategori = Kategori::withCount(['produk as jumlah_produk'])
            ->orderBy('nama')
            ->get();

        return view('admin.kategori', compact('kategori'));
    }

    public function supplier()
    {
        $supplier = Supplier::orderBy('nama')->get();

        return view('admin.supplier', compact('supplier'));
    }

    public function storeSupplier(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:120', 'unique:supplier,nama'],
            'kontak' => ['nullable', 'string', 'max:50'],
            'alamat' => ['nullable', 'string'],
            'catatan' => ['nullable', 'string', 'max:255'],
        ]);

        Supplier::create($data);

        return redirect()->route('admin.supplier')->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function updateSupplier(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:120', Rule::unique('supplier', 'nama')->ignore($supplier->id)],
            'kontak' => ['nullable', 'string', 'max:50'],
            'alamat' => ['nullable', 'string'],
            'catatan' => ['nullable', 'string', 'max:255'],
        ]);

        $supplier->update($data);

        return redirect()->route('admin.supplier')->with('success', 'Supplier berhasil diperbarui.');
    }

    public function destroySupplier($id)
    {
        Supplier::findOrFail($id)->delete();

        return redirect()->route('admin.supplier')->with('success', 'Supplier berhasil dihapus.');
    }

    /**
     * Simpan kategori baru.
     */
    public function storeKategori(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:80', 'unique:kategori,nama'],
            'deskripsi' => ['nullable', 'string', 'max:255'],
        ]);

        Kategori::create($data);

        return redirect()->route('admin.kategori')->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Perbarui kategori dan nama kategori pada produk yang menggunakannya.
     */
    public function updateKategori(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:80', Rule::unique('kategori', 'nama')->ignore($kategori->id)],
            'deskripsi' => ['nullable', 'string', 'max:255'],
        ]);

        DB::transaction(function () use ($kategori, $data) {
            Produk::where('kategori', $kategori->nama)->update(['kategori' => $data['nama']]);
            $kategori->update($data);
        });

        return redirect()->route('admin.kategori')->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Hapus kategori yang belum dipakai produk.
     */
    public function destroyKategori($id)
    {
        $kategori = Kategori::findOrFail($id);

        if ($kategori->produk()->exists()) {
            return redirect()->route('admin.kategori')
                ->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh produk.');
        }

        $kategori->delete();

        return redirect()->route('admin.kategori')->with('success', 'Kategori berhasil dihapus.');
    }

    /**
     * Simpan produk baru.
     */
    public function storeProduk(Request $request)
    {
        $data = $request->validate([
            'barcode' => ['required', 'string', 'max:50', 'unique:produk,barcode'],
            'nama_produk' => ['required', 'string', 'max:150'],
            'kategori' => ['required', 'exists:kategori,nama'],
            'harga' => ['required', 'integer', 'min:0'],
            'stok' => ['required', 'integer', 'min:0'],
            'foto' => ['nullable', 'image', 'max:2048'],
        ], [
            'barcode.unique' => 'Barcode tersebut sudah digunakan oleh produk lain.',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('produk', 'public');
        }

        Produk::create($data);

        return redirect()->route('admin.produk')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Update seluruh data produk.
     */
    public function updateProduk(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $data = $request->validate([
            'barcode' => [
                'required', 'string', 'max:50',
                Rule::unique('produk', 'barcode')->ignore($produk->id),
            ],
            'nama_produk' => ['required', 'string', 'max:150'],
            'kategori' => ['required', 'exists:kategori,nama'],
            'harga' => ['required', 'integer', 'min:0'],
            'stok' => ['required', 'integer', 'min:0'],
            'foto' => ['nullable', 'image', 'max:2048'],
        ], [
            'barcode.unique' => 'Barcode tersebut sudah digunakan oleh produk lain.',
        ]);

        if ($request->hasFile('foto')) {
            if ($produk->foto) {
                Storage::disk('public')->delete($produk->foto);
            }
            $data['foto'] = $request->file('foto')->store('produk', 'public');
        } else {
            unset($data['foto']);
        }

        $produk->update($data);

        return redirect()->route('admin.produk')->with('success', 'Data produk berhasil diperbarui.');
    }

    /**
     * Hapus produk.
     *
     * Produk yang sudah pernah masuk transaksi tidak boleh dihapus agar
     * riwayat transaksi tetap konsisten.
     */
    public function destroyProduk($id)
    {
        $produk = Produk::findOrFail($id);

        if ($produk->transaksiDetail()->exists() || MutasiStok::where('produk_id', $produk->id)->exists()) {
            return redirect()->route('admin.produk')
            ->with('error', 'Produk tidak dapat dihapus karena sudah memiliki riwayat transaksi atau mutasi stok. Silakan edit produknya.');
        }

        $produk->delete();

        return redirect()->route('admin.produk')->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Riwayat transaksi khusus halaman admin.
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

        return view('admin.riwayat', compact('transaksi'));
    }

    /**
     * Detail transaksi untuk admin.
     */
    public function detailTransaksi($id)
    {
        $transaksi = Transaksi::with('detail.produk')->findOrFail($id);

        return view('admin.transaksi-detail', compact('transaksi'));
    }

    /**
     * Tampilkan halaman Pengaturan toko & sistem.
     */
    public function pengaturan()
    {
        $pengaturan = Pengaturan::ambil();

        return view('admin.pengaturan', compact('pengaturan'));
    }

    /**
     * Simpan perubahan pengaturan toko & sistem.
     */
    public function updatePengaturan(Request $request)
    {
        $data = $request->validate([
            'nama_toko' => ['required', 'string', 'max:150'],
            'telepon' => ['nullable', 'string', 'max:30'],
            'alamat' => ['nullable', 'string'],
            'persentase_pajak' => ['required', 'integer', 'min:0', 'max:100'],
            'info_rekening' => ['nullable', 'string', 'max:150'],
            'header_struk' => ['nullable', 'string'],
            'footer_struk' => ['nullable', 'string'],
        ]);

        // Checkbox toggle yang TIDAK dicentang tidak akan dikirim sama sekali
        // oleh browser, makanya dicek manual di sini (bukan lewat validate).
        $data['metode_cash'] = $request->boolean('metode_cash');
        $data['metode_qris'] = $request->boolean('metode_qris');
        $data['metode_transfer'] = $request->boolean('metode_transfer');

        $pengaturan = Pengaturan::ambil();
        $pengaturan->update($data);

        return redirect()->route('admin.pengaturan')->with('success', 'Pengaturan berhasil disimpan.');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('auth.pilihLogin');
    }
}
