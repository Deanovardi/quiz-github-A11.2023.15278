<x-layouts.app title="Riwayat Pasien">

    <div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Riwayat Pasien</h1>
    </div>

    <div class="flex items-center gap-2">
        <a href="{{ route('dokter.riwayat-pasien.export') }}"
           class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
            Export Excel
        </a>
    </div>
</div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">No Antrian</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">Nama Pasien</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">Keluhan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">Tanggal Periksa</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">Biaya</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold uppercase text-slate-500">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayatPasien as $item)
                        <tr class="border-t border-slate-100 hover:bg-slate-50 transition">
                            <td class="px-6 py-4 text-slate-600">
                                {{ $item->daftarPoli->no_antrian ?? '-' }}
                            </td>

                            <td class="px-6 py-4 font-medium text-slate-800">
                                {{ $item->daftarPoli->pasien->nama ?? '-' }}
                            </td>

                            <td class="px-6 py-4 text-slate-600">
                                {{ $item->daftarPoli->keluhan ?? '-' }}
                            </td>

                            <td class="px-6 py-4 text-slate-600">
                                {{ \Carbon\Carbon::parse($item->tgl_periksa)->format('d/m/Y') }}
                            </td>

                            <td class="px-6 py-4 text-slate-600">
                                Rp{{ number_format($item->biaya_periksa ?? 0, 0, ',', '.') }}
                            </td>

                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('dokter.riwayat-pasien.show', $item->id) }}"
                                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 transition">
                                    <i class="fas fa-eye"></i>
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center text-slate-400">
                                Belum ada riwayat pasien.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-layouts.app>