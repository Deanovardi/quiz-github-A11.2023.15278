<x-layouts.app title="Admin Dashboard">

    @php
        \Carbon\Carbon::setLocale('id');
        $today = \Carbon\Carbon::now()->translatedFormat('l, d F Y');
    @endphp

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-slate-800">
            Selamat Datang, Admin 👋
        </h1>
        <p class="text-slate-500 mt-1">
            {{ $today }} - Berikut ringkasan data sistem poliklinik.
        </p>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

        {{-- Total Poli --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 relative overflow-hidden">
            <div class="flex items-center justify-between mb-8">
                <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center">
                    <i class="fas fa-hospital text-lg"></i>
                </div>
                <a href="{{ route('admin.polis.index') }}" class="text-blue-500 text-sm font-semibold">
                    Lihat
                </a>
            </div>
            <h2 class="text-4xl font-bold text-slate-900">{{ $totalPoli ?? 0 }}</h2>
            <p class="text-slate-500 mt-2 text-lg">Total Poli</p>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-blue-500"></div>
        </div>

        {{-- Total Dokter --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 relative overflow-hidden">
            <div class="flex items-center justify-between mb-8">
                <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                    <i class="fas fa-user-doctor text-lg"></i>
                </div>
                <a href="{{ route('admin.dokter.index') }}" class="text-emerald-500 text-sm font-semibold">
                    Lihat
                </a>
            </div>
            <h2 class="text-4xl font-bold text-slate-900">{{ $totalDokter ?? 0 }}</h2>
            <p class="text-slate-500 mt-2 text-lg">Total Dokter</p>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-emerald-500"></div>
        </div>

        {{-- Total Pasien --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 relative overflow-hidden">
            <div class="flex items-center justify-between mb-8">
                <div class="w-14 h-14 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center">
                    <i class="fas fa-bed-pulse text-lg"></i>
                </div>
                <a href="{{ route('admin.pasien.index') }}" class="text-amber-500 text-sm font-semibold">
                    Lihat
                </a>
            </div>
            <h2 class="text-4xl font-bold text-slate-900">{{ $totalPasien ?? 0 }}</h2>
            <p class="text-slate-500 mt-2 text-lg">Total Pasien</p>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-amber-500"></div>
        </div>

        {{-- Total Obat --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 relative overflow-hidden">
            <div class="flex items-center justify-between mb-8">
                <div class="w-14 h-14 rounded-2xl bg-pink-100 text-pink-600 flex items-center justify-center">
                    <i class="fas fa-pills text-lg"></i>
                </div>
                <a href="{{ route('admin.obat.index') }}" class="text-pink-500 text-sm font-semibold">
                    Lihat
                </a>
            </div>
            <h2 class="text-4xl font-bold text-slate-900">{{ $totalObat ?? 0 }}</h2>
            <p class="text-slate-500 mt-2 text-lg">Total Obat</p>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-pink-500"></div>
        </div>

    </div>

    {{-- Bagian bawah --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- Daftar Poli --}}
        <div class="xl:col-span-2 bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100">
                <h3 class="text-2xl font-semibold text-slate-800">Daftar Poli</h3>
                <a href="{{ route('admin.polis.index') }}" class="text-blue-600 font-semibold hover:underline">
                    Lihat Semua →
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead class="bg-slate-50 text-slate-400 uppercase text-sm">
                        <tr>
                            <th class="px-6 py-4">Nama Poli</th>
                            <th class="px-6 py-4">Keterangan</th>
                            <th class="px-6 py-4 text-right">Dokter</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($polis ?? [] as $poli)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 font-semibold text-slate-800">
                                    {{ $poli->nama_poli }}
                                </td>
                                <td class="px-6 py-4 text-slate-500">
                                    {{ $poli->keterangan }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-sky-100 text-sky-600 text-sm font-medium">
                                        {{ $poli->dokters_count ?? 0 }} Dokter
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-10 text-slate-400">
                                    Belum ada data poli
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Akses Cepat --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100">
                <h3 class="text-2xl font-semibold text-slate-800">Akses Cepat</h3>
            </div>

            <div class="p-5 space-y-4">

                <a href="{{ route('admin.polis.create') }}"
                    class="flex items-start gap-4 p-4 rounded-2xl bg-blue-50 hover:bg-blue-100 transition">
                    <div class="text-blue-600 text-xl mt-1">
                        <i class="fas fa-plus"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-800">Tambah Poli</p>
                        <p class="text-sm text-slate-500">Daftarkan poli baru</p>
                    </div>
                </a>

                <a href="{{ route('admin.dokter.create') }}"
                    class="flex items-start gap-4 p-4 rounded-2xl bg-emerald-50 hover:bg-emerald-100 transition">
                    <div class="text-emerald-600 text-xl mt-1">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-800">Tambah Dokter</p>
                        <p class="text-sm text-slate-500">Daftarkan dokter baru</p>
                    </div>
                </a>

                <a href="{{ route('admin.pasien.create') }}"
                    class="flex items-start gap-4 p-4 rounded-2xl bg-amber-50 hover:bg-amber-100 transition">
                    <div class="text-amber-600 text-xl mt-1">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-800">Tambah Pasien</p>
                        <p class="text-sm text-slate-500">Daftarkan pasien baru</p>
                    </div>
                </a>

                <a href="{{ route('admin.obat.create') }}"
                    class="flex items-start gap-4 p-4 rounded-2xl bg-pink-50 hover:bg-pink-100 transition">
                    <div class="text-pink-600 text-xl mt-1">
                        <i class="fas fa-plus"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-800">Tambah Obat</p>
                        <p class="text-sm text-slate-500">Tambahkan data obat baru</p>
                    </div>
                </a>

            </div>
        </div>

    </div>

</x-layouts.app>