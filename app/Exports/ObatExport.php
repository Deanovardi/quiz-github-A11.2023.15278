<?php

namespace App\Exports;

use App\Models\Obat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ObatExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Obat::all()->map(function ($obat) {

            $harga = 'Rp ' . number_format($obat->harga ?? 0, 0, ',', '.');

            $stok = (int) ($obat->stok ?? 0);

            if ($stok <= 0) {
                $statusStok = 'Habis';
            } elseif ($stok <= 10) {
                $statusStok = $stok . ' (Menipis)';
            } else {
                $statusStok = $stok;
            }

            return [
                $obat->nama_obat ?? '-',
                $obat->kemasan ?? '-',
                $harga,
                $statusStok,
            ];
        });
    }

    public function headings(): array
    {
        return ['Nama Obat', 'Kemasan', 'Harga', 'Stok'];
    }
}