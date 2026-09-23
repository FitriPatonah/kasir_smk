<?php

namespace App\Exports;

use App\Models\Transaksi;
use App\Models\MutasiStok;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TransaksiExport
{
    public function download(?string $dari = null, ?string $sampai = null, ?int $kasirId = null): StreamedResponse
    {
        $transaksi = Transaksi::with(['detail', 'kasir'])
            ->when($dari, fn ($query) => $query->whereDate('created_at', '>=', $dari))
            ->when($sampai, fn ($query) => $query->whereDate('created_at', '<=', $sampai))
            ->when($kasirId, fn ($query) => $query->where(function ($q) use ($kasirId) {
                // Transaksi milik kasir ini sendiri, ATAU transaksi lama
                // (sebelum kasir_id tercatat) yang tetap ASLI -- bukan
                // data simulasi buat latihan model prediksi stok.
                $q->where('kasir_id', $kasirId)
                    ->orWhere(function ($q2) {
                        $q2->whereNull('kasir_id')->where('sumber_data', 'asli');
                    });
            }))
            ->orderBy('created_at')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Transaksi');

        $headers = ['Kode Transaksi', 'Tanggal', 'Kasir', 'Produk', 'Jumlah', 'Harga', 'Pajak', 'Subtotal', 'Total'];
        foreach ($headers as $i => $header) {
            $kolom = chr(65 + $i); // 65 = 'A', jadi 0->A, 1->B, ... 8->I
            $sheet->setCellValue($kolom . '1', $header);
        }
        $sheet->getStyle('A1:I1')->getFont()->setBold(true);
        $sheet->freezePane('A2');
        $sheet->getAutoFilter()->setRange('A1:I1');

        $row = 2;

        // Kumpulkan SEMUA baris detail dari SEMUA transaksi dulu ke
        // satu array datar, supaya bisa diurutkan berdasarkan nama
        // produk (A-Z) -- bukan lagi dikelompokkan per transaksi.
        $semuaBaris = [];

        foreach ($transaksi as $trx) {
            $kasir = $trx->kasir;
            if (!$kasir) {
                $mutasi = MutasiStok::with('user')
                    ->where('tipe', 'keluar')
                    ->where('sumber', 'penjualan')
                    ->where('keterangan', 'Penjualan ' . $trx->no_transaksi)
                    ->first();
                $kasir = $mutasi?->user;
            }
            $namaKasir = $kasir?->username ?? '-';

            // Kolom pajak sekarang sudah tersimpan asli di database sejak
            // checkout (lihat migration add_subtotal_dan_pajak_to_transaksi_table).
            // Fallback hitung ulang tetap disiapkan untuk jaga-jaga kalau ada
            // baris lama yang entah kenapa kolomnya masih kosong.
            $pajak = $trx->pajak ?? max($trx->total - $trx->detail->sum('subtotal'), 0);

            foreach ($trx->detail as $detail) {
                $semuaBaris[] = [
                    'no_transaksi' => $trx->no_transaksi,
                    'tanggal' => $trx->created_at?->format('d-m-Y H:i:s'),
                    'kasir' => $namaKasir,
                    'nama_produk' => $detail->nama_produk,
                    'qty' => (int) $detail->qty,
                    'harga' => (int) $detail->harga,
                    'pajak' => (int) $pajak,
                    'subtotal' => (int) $detail->subtotal,
                    'total' => (int) $trx->total,
                ];
            }
        }

        // Urutkan A-Z berdasarkan nama produk (case-insensitive, supaya
        // "aqua" dan "Aqua" dianggap sama urutannya).
        usort($semuaBaris, fn ($a, $b) => strcasecmp($a['nama_produk'], $b['nama_produk']));

        foreach ($semuaBaris as $baris) {
            $sheet->setCellValue('A' . $row, $baris['no_transaksi']);
            $sheet->setCellValue('B' . $row, $baris['tanggal']);
            $sheet->setCellValue('C' . $row, $baris['kasir']);
            $sheet->setCellValue('D' . $row, $baris['nama_produk']);
            $sheet->setCellValue('E' . $row, $baris['qty']);
            $sheet->setCellValue('F' . $row, $baris['harga']);
            $sheet->setCellValue('G' . $row, $baris['pajak']);
            $sheet->setCellValue('H' . $row, $baris['subtotal']);
            $sheet->setCellValue('I' . $row, $baris['total']);
            $row++;
        }

        foreach (range('A', 'I') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
        $sheet->getStyle('F2:I' . max(2, $row - 1))->getNumberFormat()->setFormatCode('#,##0');

        return response()->streamDownload(function () use ($spreadsheet) {
            (new Xlsx($spreadsheet))->save('php://output');
        }, 'transaksi-' . now()->format('Y-m-d-His') . '.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
}
