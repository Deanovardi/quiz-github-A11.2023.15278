<?php

namespace App\Http\Controllers\Dokter;

use App\Events\AntrianUpdated;
use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\DetailPeriksa;
use App\Models\Obat;
use App\Models\Periksa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PeriksaController extends Controller
{
    public function index()
    {
        $dokterId = Auth::id();

        Carbon::setLocale('id');

        $hariIniIndo = Carbon::now('Asia/Jakarta')->translatedFormat('l');
        $hariIniEnglish = Carbon::now('Asia/Jakarta')->format('l');

        $daftarPolis = DaftarPoli::with([
                'pasien',
                'jadwalPeriksa.dokter.poli',
                'periksa'
            ])
            ->whereHas('jadwalPeriksa', function ($query) use ($dokterId, $hariIniIndo, $hariIniEnglish) {
                $query->where('id_dokter', $dokterId)
                    ->where(function ($q) use ($hariIniIndo, $hariIniEnglish) {
                        $q->where('hari', $hariIniIndo)
                            ->orWhere('hari', $hariIniEnglish);
                    });
            })
            ->leftJoin('periksa', 'daftar_poli.id', '=', 'periksa.id_daftar_poli')
            ->select('daftar_poli.*')
            ->orderByRaw('CASE WHEN periksa.id IS NULL THEN 0 ELSE 1 END ASC')
            ->orderBy('daftar_poli.no_antrian', 'asc')
            ->get();

        return view('dokter.periksa-pasien.index', compact('daftarPolis'));
    }

    public function create(string $id)
    {
        $daftar = DaftarPoli::with([
                'pasien',
                'jadwalPeriksa.dokter.poli'
            ])
            ->whereDoesntHave('periksa')
            ->findOrFail($id);

        if ($daftar->jadwalPeriksa->id_dokter != Auth::id()) {
            abort(403, 'Anda tidak berhak memeriksa pasien ini.');
        }

        $jadwal = $daftar->jadwalPeriksa;

        $jadwal->update([
            'current_antrian' => $daftar->no_antrian
        ]);

        broadcast(new AntrianUpdated(
            $jadwal->id,
            $daftar->no_antrian
        ));

        $obats = Obat::orderBy('nama_obat')->get();

        return view('dokter.periksa-pasien.create', compact('daftar', 'obats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_daftar_poli' => 'required|exists:daftar_poli,id',
            'catatan'        => 'nullable|string',
            'obat'           => 'required|array|min:1',
            'obat.*'         => 'exists:obat,id',
        ]);

        $daftar = DaftarPoli::with([
                'jadwalPeriksa.dokter.poli',
                'periksa'
            ])
            ->findOrFail($request->id_daftar_poli);

        if ($daftar->jadwalPeriksa->id_dokter != Auth::id()) {
            abort(403, 'Anda tidak berhak memeriksa pasien ini.');
        }

        if ($daftar->periksa) {
            return redirect()
                ->route('dokter.periksa-pasien.index')
                ->with('error', 'Pasien ini sudah diperiksa sebelumnya.');
        }

        try {
            DB::transaction(function () use ($request, $daftar) {
                $obats = Obat::whereIn('id', $request->obat)
                    ->lockForUpdate()
                    ->get();

                foreach ($obats as $obat) {
                    if ($obat->stok <= 0) {
                        throw new \Exception("Maaf, stok obat '{$obat->nama_obat}' habis.");
                    }
                }

                $totalHargaObat = $obats->sum('harga');
                $biayaJasaDokter = $daftar->jadwalPeriksa->dokter->poli->tarif ?? 0;
                $totalBiaya = $totalHargaObat + $biayaJasaDokter;

                $periksa = Periksa::create([
                    'id_daftar_poli' => $daftar->id,
                    'tgl_periksa'    => now(),
                    'catatan'        => $request->catatan,
                    'biaya_periksa'  => $totalBiaya,
                ]);

                foreach ($obats as $obat) {
                    DetailPeriksa::create([
                        'id_periksa' => $periksa->id,
                        'id_obat'    => $obat->id,
                    ]);

                    $obat->decrement('stok', 1);
                }
            });

            return redirect()
                ->route('dokter.periksa-pasien.index')
                ->with('success', 'Pasien berhasil diperiksa.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }
}