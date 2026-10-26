<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use Illuminate\Support\Facades\Auth;

class RiwayatPendaftaranController extends Controller
{
    public function index()
    {
        $riwayats = DaftarPoli::with([
                'jadwalPeriksa.dokter.poli',
                'periksa'
            ])
            ->where('id_pasien', Auth::id())
            ->latest()
            ->get();

        return view('pasien.riwayat-pendaftaran.index', compact('riwayats'));
    }

    public function show(string $id)
    {
        $riwayat = DaftarPoli::with([
                'jadwalPeriksa.dokter.poli',
                'periksa.detailPeriksas.obat'
            ])
            ->where('id_pasien', Auth::id())
            ->findOrFail($id);

        return view('pasien.riwayat-pendaftaran.show', compact('riwayat'));
    }
}