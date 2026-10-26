<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Periksa;
use App\Notifications\PembayaranDiverifikasi;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    public function index()
    {
        $pembayarans = Periksa::with([
                'daftarPoli.pasien',
                'daftarPoli.jadwalPeriksa.dokter'
            ])
            ->where(function ($query) {
                $query->whereNotNull('bukti_pembayaran')
                      ->orWhere('status_pembayaran', 'ditolak');
            })
            ->latest('tgl_pembayaran')
            ->get();

        return view('admin.pembayaran.index', compact('pembayarans'));
    }

    public function konfirmasi(string $id)
    {
        $periksa = Periksa::with('daftarPoli.pasien')->findOrFail($id);

        if (!$periksa->bukti_pembayaran) {
            return back()->with('error', 'Bukti pembayaran belum ada.');
        }

        if ($periksa->status_pembayaran === 'lunas') {
            return back()->with('success', 'Pembayaran sudah pernah dikonfirmasi.');
        }

        $periksa->update([
            'status_pembayaran' => 'lunas',
        ]);

        $periksa->daftarPoli->pasien?->notify(new PembayaranDiverifikasi(
            $periksa->id,
            'lunas',
            'Pembayaran Anda telah berhasil diverifikasi dan status menjadi lunas.'
        ));

        return back()->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }

    public function tolak(string $id)
    {
        $periksa = Periksa::findOrFail($id);

        if (!$periksa->bukti_pembayaran) {
            return back()->with('error', 'Bukti pembayaran tidak ditemukan.');
        }

        if (Storage::disk('public')->exists($periksa->bukti_pembayaran)) {
            Storage::disk('public')->delete($periksa->bukti_pembayaran);
        }

        $periksa->update([
            'bukti_pembayaran'  => null,
            'status_pembayaran' => 'ditolak',
            'tgl_pembayaran'    => null,
        ]);

        $periksa->daftarPoli->pasien->notify(new PembayaranDiverifikasi(
            $periksa->id,
            'ditolak',
            'Bukti pembayaran Anda ditolak. Silakan unggah bukti baru untuk melanjutkan verifikasi.'
        ));

        return back()->with('success', 'Bukti pembayaran ditolak. Pasien bisa upload ulang.');
    }
}