<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Periksa;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index()
    {
        $dokterId = Auth::id();

        $riwayatPasien = Periksa::with([
                'daftarPoli.pasien',
                'daftarPoli.jadwalPeriksa.dokter.poli'
            ])
            ->whereHas('daftarPoli.jadwalPeriksa', function ($query) use ($dokterId) {
                $query->where('id_dokter', $dokterId);
            })
            ->latest('tgl_periksa')
            ->get();

        return view('dokter.riwayat-pasien.index', compact('riwayatPasien'));
    }

    public function show(string $id)
    {
        $dokterId = Auth::id();

        $riwayat = Periksa::with([
                'daftarPoli.pasien',
                'daftarPoli.jadwalPeriksa.dokter.poli',
                'detailPeriksas.obat'
            ])
            ->whereHas('daftarPoli.jadwalPeriksa', function ($query) use ($dokterId) {
                $query->where('id_dokter', $dokterId);
            })
            ->findOrFail($id);

        return view('dokter.riwayat-pasien.show', compact('riwayat'));
    }
}