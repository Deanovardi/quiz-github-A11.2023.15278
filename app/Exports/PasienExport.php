<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PasienExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return User::where('role', 'pasien')
            ->get()
            ->map(function ($pasien) {
                return [
                    'nama'   => $pasien->nama ?? '-',
                    'email'  => $pasien->email ?? '-',
                    'no_ktp' => $pasien->no_ktp ?? '-',
                    'no_hp'  => $pasien->no_hp ?? '-',
                    'alamat' => $pasien->alamat ?? '-',
                    'no_rm'  => $pasien->no_rm ?? '-',
                ];
            });
    }

    public function headings(): array
    {
        return ['Nama Pasien', 'Email', 'No. KTP', 'No. HP', 'Alamat', 'No. RM'];
    }
}