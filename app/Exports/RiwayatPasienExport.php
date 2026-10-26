<?php

namespace App\Exports;

use App\Models\Periksa;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RiwayatPasienExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Periksa::with(['daftarPoli.pasien', 'daftarPoli.jadwalPeriksa'])
            ->whereHas('daftarPoli.jadwalPeriksa', function ($query) {
                $query->where('id_dokter', Auth::id());
            })
            ->get()
            ->map(function ($item) {
                return [
                    $item->daftarPoli->no_antrian ?? '-',
                    $item->daftarPoli->pasien->nama ?? '-',
                    $item->daftarPoli->keluhan ?? '-',
                    $item->tgl_periksa ? $item->tgl_periksa->format('d/m/Y') : '-',
                    $item->biaya_periksa ?? 0,
                ];
            });
    }

    public function headings(): array
    {
        return ['No Antrian', 'Nama Pasien', 'Keluhan', 'Tanggal Periksa', 'Biaya'];
    }
}