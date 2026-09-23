<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
use App\Models\Kategori;
use App\Models\MutasiStok;
use App\Models\Produk;
use App\Models\Supplier;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
            'pajak' => ['nullable', 'integer', 'min:0', 'max:100'],
            'foto' => ['nullable', 'image', 'max:2048'],
        ], [
            'barcode.unique' => 'Barcode tersebut sudah digunakan oleh produk lain.',
        ]);

        $data['pajak'] = (int) ($data['pajak'] ?? 0);

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
            'pajak' => ['nullable', 'integer', 'min:0', 'max:100'],
            'foto' => ['nullable', 'image', 'max:2048'],
        ], [
            'barcode.unique' => 'Barcode tersebut sudah digunakan oleh produk lain.',
        ]);

        $data['pajak'] = (int) ($data['pajak'] ?? 0);

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
     * Laporan (riwayat transaksi) khusus halaman admin.
     */
    public function laporan(Request $request)
    {
        // Tab mana yang sedang aktif -- ditentukan di server, supaya
        // begitu halaman dimuat langsung benar, tidak "kedip" ke tab
        // Transaksi dulu sebelum dibetulkan JavaScript.
        $tabAktif = $request->query('tab') === 'kasir' ? 'kasir' : 'transaksi';

        $transaksi = Transaksi::with(['detail', 'kasir'])
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($item) {
                $item->jumlah_item = $item->detail->sum('qty');
                $item->tanggal = $item->created_at->translatedFormat('d F Y');
                $item->jam = $item->created_at->translatedFormat('H:i:s');
                return $item;
            });

        // Filter tanggal KHUSUS untuk rekap kasir -- supaya bisa
        // bandingkan performa per periode (mis. bulan ini, minggu lalu),
        // bukan cuma total sepanjang masa yang kurang adil buat kasir
        // yang baru mulai kerja belakangan.
        $dariKasir = $request->query('dari_kasir');
        $sampaiKasir = $request->query('sampai_kasir');

        // Rekap per kasir: jumlah transaksi & total penjualan tiap kasir.
        // Sengaja HANYA transaksi asli (bukan data simulasi buat latihan
        // model prediksi stok) -- laporan performa kasir harus murni dari
        // penjualan sungguhan.
        $rekapKasir = Transaksi::with('kasir')
            ->where('sumber_data', 'asli')
            ->when($dariKasir, fn ($q) => $q->whereDate('created_at', '>=', $dariKasir))
            ->when($sampaiKasir, fn ($q) => $q->whereDate('created_at', '<=', $sampaiKasir))
            ->get()
            ->groupBy('kasir_id')
            ->map(function ($grup) {
                $kasir = $grup->first()->kasir;
                return (object) [
                    'nama' => $kasir?->name ?? 'Tanpa Kasir (Data Lama)',
                    'username' => $kasir?->username,
                    'jumlah_transaksi' => $grup->count(),
                    'total_penjualan' => $grup->sum('total'),
                ];
            })
            ->sortByDesc('total_penjualan')
            ->values();

        return view('admin.laporan', compact('transaksi', 'rekapKasir', 'dariKasir', 'sampaiKasir', 'tabAktif'));
    }

    /**
     * Detail transaksi untuk admin.
     */
    public function detailTransaksi($id)
    {
        $transaksi = Transaksi::with(['detail.produk', 'kasir'])->findOrFail($id);

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

    /**
     * Tampilkan halaman Kelola User (admin & kasir).
     */
    public function kelolaUser()
    {
        // Admin selalu tampil paling atas, baru diikuti kasir.
        // Di dalam masing-masing grup, yang paling baru bergabung ditaruh duluan.
        $user = User::orderByRaw("CASE WHEN role = 'admin' THEN 0 ELSE 1 END")
            ->orderByDesc('created_at')
            ->get();

        return view('admin.kelola-user', compact('user'));
    }

    /**
     * Simpan user baru (admin atau kasir).
     */
    public function storeUser(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'username' => ['required', 'string', 'max:50', 'alpha_dash', 'unique:users,username'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', 'in:admin,kasir'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'role' => $data['role'],
            'password' => Hash::make($data['password']),
            'aktif' => true,
        ]);

        return redirect()->route('admin.kelola-user')->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Perbarui data user. Password hanya diganti jika diisi.
     */
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'username' => ['required', 'string', 'max:50', 'alpha_dash', Rule::unique('users', 'username')->ignore($user->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'role' => ['required', 'in:admin,kasir'],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        // Admin tidak boleh mengubah role akunnya sendiri (mencegah admin
        // tanpa sengaja menurunkan hak aksesnya sendiri jadi kasir).
        if ($user->id === Auth::guard('admin')->id() && $data['role'] !== 'admin') {
            return redirect()->route('admin.kelola-user')
                ->with('error', 'Anda tidak dapat mengubah role akun Anda sendiri.');
        }

        // Catat email TUJUAN notifikasi & daftar field yang berubah SEBELUM
        // data ditimpa -- supaya kalau emailnya sendiri yang diganti,
        // notifikasi tetap terkirim ke alamat LAMA (pemilik akun yang asli),
        // bukan ke alamat baru yang mungkin dimasukkan orang lain.
        $emailTujuanNotifikasi = $user->email;
        $labelField = [
            'name' => 'Nama',
            'username' => 'Username',
            'email' => 'Email',
            'role' => 'Role',
            'password' => 'Password',
        ];
        $perubahan = [];
        foreach ($data as $field => $nilaiBaru) {
            if ($field === 'password') {
                $perubahan[] = $labelField[$field];
                continue;
            }
            if ((string) $user->{$field} !== (string) $nilaiBaru) {
                $perubahan[] = $labelField[$field] ?? $field;
            }
        }

        $user->update($data);

        if (!empty($perubahan) && $emailTujuanNotifikasi) {
            try {
                \Illuminate\Support\Facades\Mail::to($emailTujuanNotifikasi)
                    ->send(new \App\Mail\UserDiubahMail($user, $perubahan));
            } catch (\Throwable $e) {
                // Gagal kirim email TIDAK boleh menggagalkan penyimpanan
                // data user -- cukup dicatat ke log supaya admin bisa cek.
                \Illuminate\Support\Facades\Log::warning(
                    'Gagal mengirim notifikasi email perubahan user: ' . $e->getMessage()
                );
            }
        }

        return redirect()->route('admin.kelola-user')->with('success', 'Data user berhasil diperbarui.');
    }

    /**
     * Aktifkan / nonaktifkan user (mencegah user login sementara tanpa dihapus).
     */
    public function toggleStatusUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::guard('admin')->id()) {
            return redirect()->route('admin.kelola-user')
                ->with('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri.');
        }

        $user->update(['aktif' => ! $user->aktif]);

        return redirect()->route('admin.kelola-user')
            ->with('success', $user->aktif ? 'User berhasil diaktifkan.' : 'User berhasil dinonaktifkan.');
    }

    /**
     * Hapus user. Admin tidak dapat menghapus akunnya sendiri atau
     * menghapus admin terakhir yang tersisa di sistem.
     */
    public function destroyUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::guard('admin')->id()) {
            return redirect()->route('admin.kelola-user')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
            return redirect()->route('admin.kelola-user')
                ->with('error', 'Tidak dapat menghapus admin terakhir.');
        }

        $user->delete();

        return redirect()->route('admin.kelola-user')->with('success', 'User berhasil dihapus.');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('auth.pilihLogin');
    }
}