<x-layouts.app title="Periksa Pasien">

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-slate-800">Periksa Pasien</h1>
       
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 rounded-xl bg-green-100 text-green-700 border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">Pasien</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">Keluhan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">No Antrian</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold uppercase text-slate-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($daftarPolis as $daftar)
                        <tr class="transition {{ $daftar->periksa ? 'bg-slate-50/50 opacity-60' : 'hover:bg-blue-50/30' }}">
                            <td class="px-6 py-4 text-slate-600">
                                {{ $daftar->id }}
                            </td>

                            <td class="px-6 py-4 font-medium text-slate-800">
                                {{ $daftar->pasien->nama ?? '-' }}
                                @if(!$daftar->periksa)
                                    <span class="ml-2 px-2 py-0.5 text-[10px] bg-blue-100 text-blue-600 rounded-lg">Antrian</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-slate-600">
                                {{ $daftar->keluhan ?? '-' }}
                            </td>

                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full {{ $daftar->periksa ? 'bg-slate-200 text-slate-500' : 'bg-blue-100 text-blue-700' }} text-sm font-semibold">
                                    {{ $daftar->jadwalPeriksa->dokter->poli->kode_poli ?? 'A' }}-{{ $daftar->no_antrian }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-right">
                                @if($daftar->periksa)
                                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-green-100 text-green-700 text-sm font-semibold">
                                        <i class="fas fa-circle-check"></i>
                                        Sudah Diperiksa
                                    </span>
                                @else
                                    <a href="{{ route('dokter.periksa.create', $daftar->id) }}"
                                       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 transition shadow-sm">
                                        <i class="fas fa-stethoscope"></i>
                                        Periksa
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center text-slate-400">
                                    <i class="fas fa-folder-open text-4xl mb-4"></i>
                                    <p class="text-base">Tidak ada data pasien</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-layouts.app>