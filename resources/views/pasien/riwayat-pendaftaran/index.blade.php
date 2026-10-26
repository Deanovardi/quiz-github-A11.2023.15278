<x-layouts.app title="Riwayat Pendaftaran">

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-slate-800">Riwayat Pendaftaran</h1>
        
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">No</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">Poli</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">Dokter</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">Jadwal</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">No. Antrian</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">Status</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold uppercase text-slate-500">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($riwayats as $index => $riwayat)
                        @php
                            $sudahDiperiksa = !is_null($riwayat->periksa);

                            $kodePoli =
                                $riwayat->jadwalPeriksa->dokter->poli->kode_poli
                                ?? $riwayat->kode_poli
                                ?? 'B';

                            $nomorAntrianFormatted = $riwayat->no_antrian
                                ? $kodePoli . '-' . $riwayat->no_antrian
                                : '-';
                        @endphp

                        <tr class="border-t border-slate-100 hover:bg-slate-50 transition">
                            <td class="px-6 py-4 text-slate-600">{{ $index + 1 }}</td>

                            <td class="px-6 py-4 font-medium text-slate-800">
                                {{ $riwayat->jadwalPeriksa->dokter->poli->nama_poli ?? '-' }}
                            </td>

                            <td class="px-6 py-4 text-slate-600">
                                {{ $riwayat->jadwalPeriksa->dokter->nama ?? '-' }}
                            </td>

                            <td class="px-6 py-4 text-slate-600">
                                {{ $riwayat->jadwalPeriksa->hari ?? '-' }},
                                {{ \Carbon\Carbon::parse($riwayat->jadwalPeriksa->jam_mulai)->format('H:i') }}
                                -
                                {{ \Carbon\Carbon::parse($riwayat->jadwalPeriksa->jam_selesai)->format('H:i') }}
                            </td>

                            {{-- NOMOR ANTRIAN --}}
                            <td class="px-6 py-4">
                                @if($sudahDiperiksa)
                                    <span class="inline-flex items-center justify-center min-w-[40px] px-3 py-1 rounded-lg bg-green-100 text-green-700 font-bold text-sm">
                                        {{ $nomorAntrianFormatted }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center justify-center min-w-[40px] px-3 py-1 rounded-lg bg-red-100 text-red-700 font-bold text-sm">
                                        {{ $nomorAntrianFormatted }}
                                    </span>
                                @endif
                            </td>

                            {{-- STATUS --}}
                            <td class="px-6 py-4">
                                @if($sudahDiperiksa)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-green-100 px-3 py-1 text-sm font-semibold text-green-700">
                                        <i class="fas fa-circle text-[8px]"></i>
                                        Selesai Diperiksa
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 rounded-full bg-red-100 px-3 py-1 text-sm font-semibold text-red-700">
                                        <i class="fas fa-circle text-[8px]"></i>
                                        Belum Diperiksa
                                    </span>
                                @endif
                            </td>

                            {{-- AKSI --}}
                            <td class="px-6 py-4 text-right">
                                @if($sudahDiperiksa)
                                    <a href="{{ route('pasien.riwayat-pendaftaran.show', $riwayat->id) }}"
                                       class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition">
                                        <i class="fas fa-eye"></i>
                                        Detail
                                    </a>
                                @else
                                    <span class="text-sm text-slate-400">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center text-slate-400">
                                    <i class="fas fa-folder-open text-4xl mb-4"></i>
                                    <p class="text-base">Belum ada riwayat pendaftaran.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-layouts.app>