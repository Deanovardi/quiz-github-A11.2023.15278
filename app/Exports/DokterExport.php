<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DokterExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return User::with('poli')
            ->where('role', 'dokter')
            ->get()
            ->map(function ($dokter) {
                return [
                    $dokter->nama ?? '-',
                    $dokter->email ?? '-',
                    $dokter->no_ktp ?? '-',
                    $dokter->no_hp ?? '-',
                    $dokter->alamat ?? '-',
                    $dokter->poli->nama_poli ?? '-',
                ];
            });
    }

    public function headings(): array
    {
        return ['Nama Dokter', 'Email', 'No. KTP', 'No. HP', 'Alamat', 'Poli'];
    }
}