<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Poli;
use Illuminate\Http\Request;

class PoliController extends Controller
{
    public function index()
    {
        $polis = Poli::latest()->get();

        return view('admin.polis.index', compact('polis'));
    }

    public function create()
    {
        return view('admin.polis.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_poli'  => 'required|string|max:25',
            'keterangan' => 'nullable|string',
            'tarif'      => 'required|integer|min:0',
        ], [
            'nama_poli.required' => 'Nama poli wajib diisi.',
            'tarif.required'     => 'Tarif wajib diisi.',
            'tarif.integer'      => 'Tarif harus berupa angka.',
        ]);

        $totalPoli = Poli::count();
        $kodePoli = chr(65 + $totalPoli);

        $validated['kode_poli'] = $kodePoli;

        Poli::create($validated);

        return redirect()
            ->route('admin.polis.index')
            ->with('success', 'Poli berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $poli = Poli::findOrFail($id);

        return view('admin.polis.show', compact('poli'));
    }

    public function edit(string $id)
    {
        $poli = Poli::findOrFail($id);

        return view('admin.polis.edit', compact('poli'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nama_poli'  => 'required|string|max:25',
            'keterangan' => 'nullable|string',
            'tarif'      => 'required|integer|min:0',
        ], [
            'nama_poli.required' => 'Nama poli wajib diisi.',
            'tarif.required'     => 'Tarif wajib diisi.',
            'tarif.integer'      => 'Tarif harus berupa angka.',
        ]);

        $poli = Poli::findOrFail($id);
        $poli->update($validated);

        return redirect()
            ->route('admin.polis.index')
            ->with('success', 'Poli berhasil diupdate.');
    }

    public function destroy(string $id)
    {
        $poli = Poli::findOrFail($id);
        $poli->delete();

        return redirect()
            ->route('admin.polis.index')
            ->with('success', 'Poli berhasil dihapus.');
    }
}