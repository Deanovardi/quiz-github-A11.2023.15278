<?php

namespace App\Http\Controllers;

use App\Exports\DokterExport;
use App\Exports\PasienExport;
use App\Exports\ObatExport;
use App\Exports\JadwalPeriksaExport;
use App\Exports\RiwayatPasienExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    // ADMIN

    public function dokter()
    {
        return Excel::download(new DokterExport, 'data-dokter.xlsx');
    }

    public function pasien()
    {
        return Excel::download(new PasienExport, 'data-pasien.xlsx');
    }

    public function obat()
    {
        return Excel::download(new ObatExport, 'data-obat.xlsx');
    }

    // DOKTER

    public function jadwalPeriksa()
    {
        return Excel::download(new JadwalPeriksaExport, 'jadwal-periksa.xlsx');
    }

    public function riwayatPasien()
    {
        return Excel::download(new RiwayatPasienExport, 'riwayat-pasien.xlsx');
    }
}