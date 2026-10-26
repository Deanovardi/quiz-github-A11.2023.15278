<x-layouts.app title="Verifikasi Pembayaran">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Verifikasi Pembayaran</h1>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-700 border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-700 border border-red-200">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Pasien</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Dokter</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Tanggal</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Tagihan</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Status</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Bukti</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-slate-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pembayarans as $item)
                        <tr class="border-t hover:bg-slate-50 transition">
                            <td class="px-6 py-4 text-sm text-slate-700">
                                {{ $item->daftarPoli->pasien->nama ?? '-' }}
                            </td>

                            <td class="px-6 py-4 text-sm text-slate-700">
                                {{ $item->daftarPoli->jadwalPeriksa->dokter->nama ?? '-' }}
                            </td>

                            <td class="px-6 py-4 text-sm text-slate-700">
                                {{ $item->tgl_periksa ? $item->tgl_periksa->format('d/m/Y') : '-' }}
                            </td>

                            <td class="px-6 py-4 text-sm text-slate-700">
                                Rp {{ number_format($item->biaya_periksa ?? 0, 0, ',', '.') }}
                            </td>

                            <td class="px-6 py-4 text-sm">
                                @if($item->status_pembayaran === 'belum_bayar')
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg bg-red-100 text-red-700 font-semibold">
                                        Belum Bayar
                                    </span>
                                @elseif($item->status_pembayaran === 'menunggu_verifikasi')
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg bg-yellow-100 text-yellow-700 font-semibold">
                                        Menunggu Verifikasi
                                    </span>
                                @elseif($item->status_pembayaran === 'ditolak')
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg bg-orange-100 text-orange-700 font-semibold">
                                        Ditolak
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg bg-green-100 text-green-700 font-semibold">
                                        Lunas
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-sm">
                                @if($item->bukti_pembayaran)
                                    <a href="{{ asset('storage/' . $item->bukti_pembayaran) }}"
                                       target="_blank"
                                       class="text-blue-600 hover:underline">
                                        Lihat Bukti
                                    </a>
                                @else
                                    -
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if($item->status_pembayaran === 'menunggu_verifikasi')
                                    <div class="flex items-center justify-center gap-2">
                                        <form action="{{ route('admin.pembayaran.konfirmasi', $item->id) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                                Konfirmasi
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.pembayaran.tolak', $item->id) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                                Tolak
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-6 text-center text-slate-500">
                                Belum ada data pembayaran.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>