<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index(Request $request, string $role)
    {
        abort_unless(in_array($role, ['admin', 'kasir'], true), 404);

        $data = $request->validate([
            'jenis' => ['nullable', 'in:penjualan'],
            'dari' => ['nullable', 'date'],
            'sampai' => ['nullable', 'date', 'after_or_equal:dari'],
        ]);

        $jenis = $data['jenis'] ?? 'penjualan';
        $dari = $data['dari'] ?? null;
        $sampai = $data['sampai'] ?? null;

        $penjualan = Transaksi::with(['detail', 'kasir'])
            ->when($dari, fn ($query) => $query->whereDate('created_at', '>=', $dari))
            ->when($sampai, fn ($query) => $query->whereDate('created_at', '<=', $sampai))
            ->latest()
            ->limit(100)
            ->get();

        return view('transaksi.index', compact('role', 'jenis', 'dari', 'sampai', 'penjualan'));
    }

    public function export(Request $request)
    {
        $data = $request->validate([
            'dari' => ['nullable', 'date'],
            'sampai' => ['nullable', 'date', 'after_or_equal:dari'],
        ]);

        return (new \App\Exports\TransaksiExport)->download(
            $data['dari'] ?? null,
            $data['sampai'] ?? null,
        );
    }
}
