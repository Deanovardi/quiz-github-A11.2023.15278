<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Periksa;
use App\Notifications\PembayaranDiunggah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    public function index()
    {
        $tagihans = Periksa::with([
                'daftarPoli.pasien',
                'daftarPoli.jadwalPeriksa.dokter'
            ])
            ->whereHas('daftarPoli', function ($query) {
                $query->where('id_pasien', Auth::id());
            })
            ->latest('tgl_periksa')
            ->get();

        return view('pasien.pembayaran.index', compact('tagihans'));
    }

    public function upload(Request $request, string $id)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $periksa = Periksa::with('daftarPoli')
            ->whereHas('daftarPoli', function ($query) {
                $query->where('id_pasien', Auth::id());
            })
            ->findOrFail($id);

        if ($periksa->status_pembayaran === 'lunas') {
            return back()->with('error', 'Tagihan ini sudah lunas.');
        }

        if ($periksa->bukti_pembayaran && Storage::disk('public')->exists($periksa->bukti_pembayaran)) {
            Storage::disk('public')->delete($periksa->bukti_pembayaran);
        }

        $path = $request->file('bukti_pembayaran')->store('bukti-pembayaran', 'public');

        $periksa->update([
            'bukti_pembayaran'  => $path,
            'status_pembayaran' => 'menunggu_verifikasi',
            'tgl_pembayaran'    => now(),
        ]);

        $dokter = $periksa->daftarPoli->jadwalPeriksa?->dokter;

        if ($dokter) {
            $dokter->notify(new PembayaranDiunggah(
                $periksa->id,
                $periksa->daftarPoli->pasien->nama,
                $periksa->daftarPoli->jadwalPeriksa->dokter->poli->nama_poli ?? 'Poli'
            ));
        }

        return back()->with('success', 'Bukti pembayaran berhasil diupload.');
    }
}