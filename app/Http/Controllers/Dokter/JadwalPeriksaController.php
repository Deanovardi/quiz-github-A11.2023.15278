<?php

namespace App\Http\Controllers\Dokter;

use App\Events\JadwalUpdated;
use App\Http\Controllers\Controller;
use App\Models\JadwalPeriksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalPeriksaController extends Controller
{
    public function index()
    {
        $jadwals = JadwalPeriksa::where('id_dokter', Auth::id())
            ->latest()
            ->get();

        return view('dokter.jadwal-periksa.index', compact('jadwals'));
    }

    public function create()
    {
        return view('dokter.jadwal-periksa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'hari'        => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai'   => ['required', 'date_format:H:i'],
            'jam_selesai' => ['required', 'date_format:H:i', 'after:jam_mulai'],
        ]);

        JadwalPeriksa::create([
            'id_dokter'       => Auth::id(),
            'hari'            => $request->hari,
            'jam_mulai'       => $request->jam_mulai,
            'jam_selesai'     => $request->jam_selesai,
            'current_antrian' => 0,
        ]);

        event(new JadwalUpdated());

        return redirect()
            ->route('dokter.jadwal-periksa.index')
            ->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $jadwal = JadwalPeriksa::where('id', $id)
            ->where('id_dokter', Auth::id())
            ->firstOrFail();

        return view('dokter.jadwal-periksa.edit', compact('jadwal'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'hari'        => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai'   => ['required', 'date_format:H:i'],
            'jam_selesai' => ['required', 'date_format:H:i', 'after:jam_mulai'],
        ]);

        $jadwal = JadwalPeriksa::where('id', $id)
            ->where('id_dokter', Auth::id())
            ->firstOrFail();

        $jadwal->update([
            'hari'        => $request->hari,
            'jam_mulai'   => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ]);

        event(new JadwalUpdated());

        return redirect()
            ->route('dokter.jadwal-periksa.index')
            ->with('success', 'Jadwal berhasil diupdate.');
    }

    public function destroy(string $id)
    {
        $jadwal = JadwalPeriksa::where('id', $id)
            ->where('id_dokter', Auth::id())
            ->firstOrFail();

        $jadwal->delete();

        event(new JadwalUpdated());

        return redirect()
            ->route('dokter.jadwal-periksa.index')
            ->with('success', 'Jadwal berhasil dihapus.');
    }
}