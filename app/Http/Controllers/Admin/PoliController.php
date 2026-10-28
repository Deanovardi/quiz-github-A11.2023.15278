<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;

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
        $request->merge([
            'nama_poli' => trim((string) $request->input('nama_poli')),
        ]);

        $validated = $request->validate([
            'nama_poli'  => ['required', 'string', 'max:25', Rule::unique('poli', 'nama_poli')],
            'keterangan' => 'nullable|string',
            'tarif'      => 'required|integer|min:0',
        ], [
            'nama_poli.required' => 'Nama poli wajib diisi.',
            'nama_poli.unique'   => 'Nama poli ini sudah terdaftar.',
            'tarif.required'     => 'Tarif wajib diisi.',
            'tarif.integer'      => 'Tarif harus berupa angka.',
        ]);

        $totalPoli = Poli::count();
        $kodePoli = chr(65 + $totalPoli);

        $validated['kode_poli'] = $kodePoli;

        try {
            Poli::create($validated);
        } catch (QueryException $exception) {
            if ($exception->getCode() !== '23000') {
                throw $exception;
            }

            return back()
                ->withErrors(['nama_poli' => 'Nama poli ini sudah terdaftar.'])
                ->withInput();
        }

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
        $poli = Poli::findOrFail($id);
        $request->merge([
            'nama_poli' => trim((string) $request->input('nama_poli')),
        ]);

        $validated = $request->validate([
            'nama_poli'  => ['required', 'string', 'max:25', Rule::unique('poli', 'nama_poli')->ignore($poli->id)],
            'keterangan' => 'nullable|string',
            'tarif'      => 'required|integer|min:0',
        ], [
            'nama_poli.required' => 'Nama poli wajib diisi.',
            'nama_poli.unique'   => 'Nama poli ini sudah terdaftar.',
            'tarif.required'     => 'Tarif wajib diisi.',
            'tarif.integer'      => 'Tarif harus berupa angka.',
        ]);

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