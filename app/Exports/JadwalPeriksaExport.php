<?php

namespace App\Exports;

use App\Models\JadwalPeriksa;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class JadwalPeriksaExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return JadwalPeriksa::where('id_dokter', Auth::id())
            ->get()
            ->map(function ($jadwal) {
                return [
                    'id'          => $jadwal->id,
                    'hari'        => $jadwal->hari ?? '-',
                    'jam_mulai'   => $jadwal->jam_mulai ?? '-',
                    'jam_selesai' => $jadwal->jam_selesai ?? '-',
                ];
            });
    }

    public function headings(): array
    {
        return ['ID', 'Hari', 'Jam Mulai', 'Jam Selesai'];
    }
}