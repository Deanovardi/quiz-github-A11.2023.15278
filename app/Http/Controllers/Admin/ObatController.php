<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    public function index()
    {
        $obats = Obat::latest()->get();

        return view('admin.obat.index', compact('obats'));
    }

    public function create()
    {
        return view('admin.obat.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_obat' => 'required|string|max:255',
            'kemasan'   => 'required|string|max:255',
            'harga'     => 'required|integer|min:0',
            'stok'      => 'required|integer|min:0',
        ], [
            'nama_obat.required' => 'Nama obat wajib diisi.',
            'kemasan.required'   => 'Kemasan wajib diisi.',
            'harga.required'     => 'Harga wajib diisi.',
            'harga.integer'      => 'Harga harus berupa angka.',
            'stok.required'      => 'Stok wajib diisi.',
            'stok.integer'       => 'Stok harus berupa angka bulat.',
        ]);

        Obat::create($validated);

        return redirect()
            ->route('admin.obat.index')
            ->with('success', 'Data obat berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $obat = Obat::findOrFail($id);

        return view('admin.obat.show', compact('obat'));
    }

    public function edit(string $id)
    {
        $obat = Obat::findOrFail($id);

        return view('admin.obat.edit', compact('obat'));
    }

    public function update(Request $request, string $id)
    {
        $obat = Obat::findOrFail($id);

        $validated = $request->validate([
            'nama_obat' => 'required|string|max:255',
            'kemasan'   => 'required|string|max:255',
            'harga'     => 'required|integer|min:0',
            'stok'      => 'required|integer|min:0',
        ], [
            'nama_obat.required' => 'Nama obat wajib diisi.',
            'kemasan.required'   => 'Kemasan wajib diisi.',
            'harga.required'     => 'Harga wajib diisi.',
            'harga.integer'      => 'Harga harus berupa angka.',
            'stok.required'      => 'Stok wajib diisi.',
            'stok.integer'       => 'Stok harus berupa angka bulat.',
        ]);

        $obat->update($validated);

        return redirect()
            ->route('admin.obat.index')
            ->with('success', 'Data obat berhasil diupdate.');
    }

    public function destroy(string $id)
    {
        $obat = Obat::findOrFail($id);
        $obat->delete();

        return redirect()
            ->route('admin.obat.index')
            ->with('success', 'Data obat berhasil dihapus.');
    }
}