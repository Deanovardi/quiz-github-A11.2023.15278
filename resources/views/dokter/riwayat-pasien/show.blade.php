<x-layouts.app title="Detail Riwayat Pasien">

    {{-- HEADER --}}
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">
                Detail Riwayat Pasien
            </h1>

            <p class="text-slate-500 mt-1">
                Informasi hasil pemeriksaan pasien.
            </p>
        </div>

        <a href="{{ route('dokter.riwayat-pasien.index') }}"
           class="inline-flex items-center gap-2 rounded-xl bg-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-300 transition">

            <i class="fas fa-arrow-left"></i>
            Kembali

        </a>
    </div>


    {{-- GRID UTAMA --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ================= KIRI ================= --}}
        <div class="lg:col-span-2 space-y-6">


            {{-- INFORMASI PASIEN --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">

                <h2 class="text-lg font-semibold text-slate-800 mb-4">
                    Informasi Pasien
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">

                    <div>
                        <p class="text-slate-500 mb-1">Nama Pasien</p>
                        <p class="font-semibold text-slate-800">
                            {{ $riwayat->daftarPoli->pasien->nama ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-slate-500 mb-1">No. Antrian</p>
                        <p class="font-semibold text-slate-800">
                            {{ $riwayat->daftarPoli->no_antrian ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-slate-500 mb-1">Keluhan</p>
                        <p class="font-semibold text-slate-800">
                            {{ $riwayat->daftarPoli->keluhan ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-slate-500 mb-1">Poli</p>
                        <p class="font-semibold text-slate-800">
                            {{ $riwayat->daftarPoli->jadwalPeriksa->dokter->poli->nama_poli ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-slate-500 mb-1">Dokter</p>
                        <p class="font-semibold text-slate-800">
                            {{ $riwayat->daftarPoli->jadwalPeriksa->dokter->nama ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-slate-500 mb-1">Tanggal Periksa</p>
                        <p class="font-semibold text-slate-800">
                            {{ \Carbon\Carbon::parse($riwayat->tgl_periksa)->format('d-m-Y H:i') }}
                        </p>
                    </div>

                </div>

            </div>



            {{-- CATATAN DOKTER --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">

                <h2 class="text-lg font-semibold text-slate-800 mb-4">
                    Catatan Dokter
                </h2>

                <div class="rounded-2xl bg-slate-50 border border-slate-100 p-4 text-slate-700">
                    {{ $riwayat->catatan ?? 'Tidak ada catatan.' }}
                </div>

            </div>



            {{-- DAFTAR OBAT --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">

                <h2 class="text-lg font-semibold text-slate-800 mb-4">
                    Daftar Obat
                </h2>

                <div class="overflow-x-auto">

                    <table class="w-full">

                        <thead class="bg-slate-50">

                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                                    No
                                </th>

                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                                    Nama Obat
                                </th>

                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                                    Harga
                                </th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($riwayat->obats as $index => $obat)

                            <tr class="border-t border-slate-100">

                                <td class="px-4 py-3 text-slate-600">
                                    {{ $index + 1 }}
                                </td>

                                <td class="px-4 py-3 font-medium text-slate-800">
                                    {{ $obat->nama_obat }}
                                </td>

                                <td class="px-4 py-3 text-slate-600">
                                    Rp {{ number_format($obat->harga, 0, ',', '.') }}
                                </td>

                            </tr>

                            @empty

                            <tr>

                                <td colspan="3"
                                    class="px-4 py-8 text-center text-slate-400">

                                    Tidak ada obat.

                                </td>

                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>



        {{-- ================= KANAN ================= --}}
        <div>

            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">

                <h2 class="text-lg font-semibold text-slate-800 mb-4">
                    Ringkasan Biaya
                </h2>

                <div class="rounded-2xl bg-blue-50 border border-blue-100 p-5 text-center">

                    <p class="text-sm text-blue-700 mb-2">
                        Total Biaya Pemeriksaan
                    </p>

                    <p class="text-2xl font-bold text-blue-800">
                        Rp {{ number_format($riwayat->biaya_periksa ?? 0, 0, ',', '.') }}
                    </p>

                </div>

            </div>

        </div>

    </div>

</x-layouts.app>