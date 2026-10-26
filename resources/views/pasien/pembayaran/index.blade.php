<x-layouts.app title="Pembayaran">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Pembayaran</h1>
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
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">
                            No Antrian
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">
                            Dokter
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">
                            Tanggal Periksa
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">
                            Tagihan
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">
                            Status
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">
                            Bukti Pembayaran
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($tagihans as $item)

                        @php
                            $kodePoli =
                                $item->daftarPoli->jadwalPeriksa->dokter->poli->kode_poli
                                ?? $item->daftarPoli->kode_poli
                                ?? 'B';

                            $nomorAntrianFormatted =
                                ($item->daftarPoli->no_antrian ?? null)
                                ? $kodePoli . '-' . $item->daftarPoli->no_antrian
                                : '-';
                        @endphp

                        <tr class="border-t hover:bg-slate-50 transition align-top">

                            <!-- No Antrian -->
                            <td class="px-6 py-4 text-sm text-slate-700">
                                {{ $nomorAntrianFormatted }}
                            </td>

                            <!-- Dokter -->
                            <td class="px-6 py-4 text-sm text-slate-700">
                                {{ $item->daftarPoli->jadwalPeriksa->dokter->nama ?? '-' }}
                            </td>

                            <!-- Tanggal -->
                            <td class="px-6 py-4 text-sm text-slate-700">
                                {{ $item->tgl_periksa ? $item->tgl_periksa->format('d/m/Y') : '-' }}
                            </td>

                            <!-- Tagihan -->
                            <td class="px-6 py-4 text-sm text-slate-700">
                                Rp {{ number_format($item->biaya_periksa ?? 0, 0, ',', '.') }}
                            </td>

                            <!-- STATUS -->
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
                                        ⚠️ Ditolak — Bukti pembayaran tidak benar
                                    </span>

                                @else

                                    <span class="inline-flex items-center px-3 py-1 rounded-lg bg-green-100 text-green-700 font-semibold">
                                        Lunas
                                    </span>

                                @endif

                            </td>

                            <!-- BUKTI -->
                            <td class="px-6 py-4 text-sm text-slate-700">

                                {{-- SELALU BISA LIHAT BUKTI --}}
                                @if($item->bukti_pembayaran)

                                    <a href="{{ asset('storage/' . $item->bukti_pembayaran) }}"
                                       target="_blank"
                                       class="inline-block mb-2 text-blue-600 hover:underline">

                                        Lihat Bukti Saat Ini

                                    </a>

                                @endif


                                {{-- JIKA LUNAS --}}
                                @if($item->status_pembayaran === 'lunas')

                                    <div class="text-green-600 font-semibold">
                                        Sudah dikonfirmasi
                                    </div>

                                @else

                                    {{-- JIKA DITOLAK --}}
                                    @if($item->status_pembayaran === 'ditolak')

                                        <div class="mb-3 rounded-lg bg-orange-50 border border-orange-200 px-3 py-2 text-orange-700 text-sm">

                                            Bukti pembayaran tidak benar.  
                                            Silakan upload ulang bukti yang sesuai.

                                        </div>

                                    @endif


                                    {{-- FORM UPLOAD --}}
                                    <form action="{{ route('pasien.pembayaran.upload', $item->id) }}"
                                          method="POST"
                                          enctype="multipart/form-data"
                                          class="space-y-2">

                                        @csrf

                                        <input
                                            type="file"
                                            name="bukti_pembayaran"
                                            class="block w-full text-sm"
                                            required
                                        >

                                        <button
                                            type="submit"
                                            class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">

                                            {{ $item->bukti_pembayaran ? 'Upload Ulang Bukti' : 'Upload Bukti' }}

                                        </button>

                                    </form>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="px-6 py-6 text-center text-slate-500">

                                Belum ada tagihan pembayaran.

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>
        </div>
    </div>

</x-layouts.app>