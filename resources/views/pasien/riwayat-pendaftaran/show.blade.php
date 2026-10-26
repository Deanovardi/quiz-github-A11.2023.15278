<x-layouts.app title="Detail Riwayat Pendaftaran">

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">Detail Riwayat Pendaftaran</h1>
            <p class="text-slate-500 mt-1">Informasi hasil pemeriksaan pasien.</p>
        </div>

        <a href="{{ route('pasien.riwayat-pendaftaran.index') }}"
           class="inline-flex items-center gap-2 rounded-xl bg-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-300 transition">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>
    </div>

    @php
        $kodePoli =
            $riwayat->jadwalPeriksa->dokter->poli->kode_poli
            ?? $riwayat->kode_poli
            ?? 'B';

        $nomorAntrianFormatted = $riwayat->no_antrian
            ? $kodePoli . '-' . $riwayat->no_antrian
            : '-';

        $statusPembayaran = strtolower($riwayat->periksa->status_pembayaran ?? 'belum_dibayar');

        $isLunas = in_array($statusPembayaran, ['lunas', 'sudah_dibayar', 'dibayar']);
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">
                <h2 class="text-lg font-semibold text-slate-800 mb-4">Informasi Pendaftaran</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-slate-500 mb-1">Poli</p>
                        <p class="font-semibold text-slate-800">
                            {{ $riwayat->jadwalPeriksa->dokter->poli->nama_poli ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-slate-500 mb-1">Dokter</p>
                        <p class="font-semibold text-slate-800">
                            {{ $riwayat->jadwalPeriksa->dokter->nama ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-slate-500 mb-1">Hari</p>
                        <p class="font-semibold text-slate-800">
                            {{ $riwayat->jadwalPeriksa->hari ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-slate-500 mb-1">Jam</p>
                        <p class="font-semibold text-slate-800">
                            {{ \Carbon\Carbon::parse($riwayat->jadwalPeriksa->jam_mulai)->format('H:i') }}
                            -
                            {{ \Carbon\Carbon::parse($riwayat->jadwalPeriksa->jam_selesai)->format('H:i') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-slate-500 mb-1">Nomor Antrian</p>
                        <p class="font-semibold text-slate-800">
                            {{ $nomorAntrianFormatted }}
                        </p>
                    </div>

                    <div>
                        <p class="text-slate-500 mb-1">Tanggal Periksa</p>
                        <p class="font-semibold text-slate-800">
                            {{ $riwayat->periksa?->tgl_periksa ? \Carbon\Carbon::parse($riwayat->periksa->tgl_periksa)->format('d-m-Y H:i') : '-' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">
                <h2 class="text-lg font-semibold text-slate-800 mb-4">Catatan Dokter</h2>

                <div class="rounded-2xl bg-slate-50 border border-slate-100 p-4 text-slate-700">
                    {{ $riwayat->periksa->catatan ?? 'Tidak ada catatan.' }}
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">
                <h2 class="text-lg font-semibold text-slate-800 mb-4">Daftar Obat</h2>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">No</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Nama Obat</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Kemasan</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayat->periksa->detailPeriksas ?? [] as $index => $detail)
                                <tr class="border-t border-slate-100">
                                    <td class="px-4 py-3 text-slate-600">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3 font-medium text-slate-800">{{ $detail->obat->nama_obat ?? '-' }}</td>
                                    <td class="px-4 py-3 text-slate-600">{{ $detail->obat->kemasan ?? '-' }}</td>
                                    <td class="px-4 py-3 text-slate-600">
                                        Rp {{ number_format($detail->obat->harga ?? 0, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-slate-400">
                                        Tidak ada data obat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">
                <h2 class="text-lg font-semibold text-slate-800 mb-4">Ringkasan Biaya</h2>

                <div class="rounded-2xl bg-blue-50 border border-blue-100 p-5">
                    <p class="text-sm text-blue-700 mb-2">Total Biaya Pemeriksaan</p>
                    <p class="text-2xl font-bold text-blue-800">
                        Rp {{ number_format($riwayat->periksa->biaya_periksa ?? 0, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">
                <h2 class="text-lg font-semibold text-slate-800 mb-4">Status Pembayaran</h2>

                @if($isLunas)
                    <div class="rounded-2xl border border-green-200 bg-green-50 p-5">
                        <div class="flex items-start gap-3">
                            <div class="mt-1 text-green-600">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-green-700 mb-1">
                                    Sudah Dibayar
                                </p>
                                <p class="text-sm text-green-600">
                                    Pembayaran untuk pemeriksaan ini sudah dikonfirmasi.
                                </p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="rounded-2xl border border-red-200 bg-red-50 p-5">
                        <div class="flex items-start gap-3">
                            <div class="mt-1 text-red-600">
                                <i class="fas fa-exclamation-circle"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-red-700 mb-1">
                                    Belum Dibayar
                                </p>
                                <p class="text-sm text-red-600">
                                    Pembayaran untuk pemeriksaan ini masih belum dilakukan atau belum dikonfirmasi admin.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>

</x-layouts.app>