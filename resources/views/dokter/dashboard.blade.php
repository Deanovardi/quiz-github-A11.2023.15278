<x-layouts.app title="Dashboard Dokter">

    @php
        \Carbon\Carbon::setLocale('id');
        $today = \Carbon\Carbon::now()->translatedFormat('l, d F Y');
    @endphp

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-slate-800">Selamat Datang, Dokter 👋</h1>
        <p class="text-slate-500 mt-1">{{ $today }} - Berikut ringkasan aktivitas praktik Anda hari ini.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 relative overflow-hidden">
            <div class="flex items-center justify-between mb-8">
                <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center">
                    <i class="fas fa-calendar-check text-lg"></i>
                </div>
                <a href="{{ route('dokter.jadwal-periksa.index') }}" class="text-blue-500 text-sm font-semibold">
                    Lihat
                </a>
            </div>
            <h2 class="text-4xl font-bold text-slate-900">{{ $totalJadwal ?? 0 }}</h2>
            <p class="text-slate-500 mt-2 text-lg">Total Jadwal</p>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-blue-500"></div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 relative overflow-hidden">
            <div class="flex items-center justify-between mb-8">
                <div class="w-14 h-14 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center">
                    <i class="fas fa-users text-lg"></i>
                </div>
                <a href="{{ route('dokter.periksa-pasien.index') }}" class="text-amber-500 text-sm font-semibold">
                    Lihat
                </a>
            </div>
            <h2 class="text-4xl font-bold text-slate-900">{{ $totalPasienHariIni ?? 0 }}</h2>
            <p class="text-slate-500 mt-2 text-lg">Pasien Menunggu</p>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-amber-500"></div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 relative overflow-hidden">
            <div class="flex items-center justify-between mb-8">
                <div class="w-14 h-14 rounded-2xl bg-pink-100 text-pink-600 flex items-center justify-center">
                    <i class="fas fa-file-medical text-lg"></i>
                </div>
                <a href="{{ route('dokter.riwayat-pasien.index') }}" class="text-pink-500 text-sm font-semibold">
                    Lihat
                </a>
            </div>
            <h2 class="text-4xl font-bold text-slate-900">{{ $totalRiwayat ?? 0 }}</h2>
            <p class="text-slate-500 mt-2 text-lg">Total Riwayat</p>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-pink-500"></div>
        </div>

    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        <div class="xl:col-span-2 bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100">
                <h3 class="text-2xl font-semibold text-slate-800">Jadwal Periksa</h3>
                <a href="{{ route('dokter.jadwal-periksa.index') }}" class="text-blue-600 font-semibold hover:underline">
                    Lihat Semua →
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead class="bg-slate-50 text-slate-400 uppercase text-sm">
                        <tr>
                            <th class="px-6 py-4">Hari</th>
                            <th class="px-6 py-4">Jam Mulai</th>
                            <th class="px-6 py-4">Jam Selesai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jadwals ?? [] as $jadwal)
                            <tr class="hover:bg-slate-50 transition border-t border-slate-100">
                                <td class="px-6 py-4 font-medium text-slate-800">
                                    {{ $jadwal->hari ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-slate-600">
                                    {{ $jadwal->jam_mulai ? \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') : '-' }}
                                </td>
                                <td class="px-6 py-4 text-slate-600">
                                    {{ $jadwal->jam_selesai ? \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-16 text-slate-400">
                                    Belum ada jadwal periksa
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100">
                <h3 class="text-2xl font-semibold text-slate-800">Akses Cepat</h3>
            </div>

            <div class="p-5 space-y-4">

                <a href="{{ route('dokter.jadwal-periksa.index') }}"
                    class="flex items-start gap-4 p-4 rounded-2xl bg-blue-50 hover:bg-blue-100 transition">
                    <div class="text-blue-600 text-xl mt-1">
                        <i class="fas fa-plus"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-800">Tambah Jadwal</p>
                        <p class="text-sm text-slate-500">Tambahkan jadwal periksa baru</p>
                    </div>
                </a>

                <a href="{{ route('dokter.periksa-pasien.index') }}"
                    class="flex items-start gap-4 p-4 rounded-2xl bg-amber-50 hover:bg-amber-100 transition">
                    <div class="text-amber-600 text-xl mt-1">
                        <i class="fas fa-stethoscope"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-800">Periksa Pasien</p>
                        <p class="text-sm text-slate-500">Lihat daftar pasien menunggu</p>
                    </div>
                </a>

                <a href="{{ route('dokter.riwayat-pasien.index') }}"
                    class="flex items-start gap-4 p-4 rounded-2xl bg-pink-50 hover:bg-pink-100 transition">
                    <div class="text-pink-600 text-xl mt-1">
                        <i class="fas fa-file-medical"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-800">Riwayat Pasien</p>
                        <p class="text-sm text-slate-500">Lihat riwayat pemeriksaan</p>
                    </div>
                </a>

            </div>
        </div>

    </div>

</x-layouts.app>