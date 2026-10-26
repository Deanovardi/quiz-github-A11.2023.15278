<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\JadwalPeriksa;
use App\Models\Periksa;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        Carbon::setLocale('id');
        $dokterId = Auth::id();

        $hariIniIndo = Carbon::now('Asia/Jakarta')->translatedFormat('l');
        $hariIniEnglish = Carbon::now('Asia/Jakarta')->format('l');

        $jadwals = JadwalPeriksa::where('id_dokter', $dokterId)
            ->where(function ($query) use ($hariIniIndo, $hariIniEnglish) {
                $query->where('hari', $hariIniIndo)
                    ->orWhere('hari', $hariIniEnglish);
            })
            ->orderBy('jam_mulai')
            ->get();

        $totalPasienHariIni = DaftarPoli::whereHas('jadwalPeriksa', function ($query) use ($dokterId, $hariIniIndo, $hariIniEnglish) {
                $query->where('id_dokter', $dokterId)
                    ->where(function ($q) use ($hariIniIndo, $hariIniEnglish) {
                        $q->where('hari', $hariIniIndo)
                            ->orWhere('hari', $hariIniEnglish);
                    });
            })
            ->whereDoesntHave('periksa')
            ->count();

        $totalRiwayat = Periksa::whereHas('daftarPoli.jadwalPeriksa', function ($query) use ($dokterId, $hariIniIndo, $hariIniEnglish) {
                $query->where('id_dokter', $dokterId)
                    ->where(function ($q) use ($hariIniIndo, $hariIniEnglish) {
                        $q->where('hari', $hariIniIndo)
                            ->orWhere('hari', $hariIniEnglish);
                    });
            })
            ->count();

        return view('dokter.dashboard', [
            'today'               => Carbon::now('Asia/Jakarta')->translatedFormat('l, d F Y'),
            'totalJadwal'         => $jadwals->count(),
            'totalPasienHariIni'  => $totalPasienHariIni,
            'totalRiwayat'        => $totalRiwayat,
            'jadwals'             => $jadwals,
        ]);
    }
}