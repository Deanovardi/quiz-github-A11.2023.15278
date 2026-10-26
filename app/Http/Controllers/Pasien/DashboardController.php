<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $pasien = User::findOrFail(Auth::id());

        $jadwals = DB::table('jadwal_periksa')
            ->join('users', 'jadwal_periksa.id_dokter', '=', 'users.id')
            ->leftJoin('poli', 'users.id_poli', '=', 'poli.id')
            ->select(
                'jadwal_periksa.id',
                'jadwal_periksa.hari',
                'jadwal_periksa.jam_mulai',
                'jadwal_periksa.jam_selesai',
                'jadwal_periksa.current_antrian',
                'users.nama as nama_dokter',
                'users.id_poli',
                'poli.nama_poli',
                'poli.kode_poli'
            )
            ->orderBy('poli.nama_poli')
            ->orderBy('jadwal_periksa.hari')
            ->orderBy('jadwal_periksa.jam_mulai')
            ->get();

        $antrianAktif = DaftarPoli::with([
                'jadwalPeriksa.dokter.poli',
                'periksa'
            ])
            ->where('id_pasien', $pasien->id)
            ->whereDoesntHave('periksa')
            ->latest()
            ->first();

        return view('pasien.dashboard', compact('pasien', 'jadwals', 'antrianAktif'));
    }
}