<x-layouts.app title="Dashboard Pasien">

    @php
        $hariMap = [
            'monday' => 'senin',
            'tuesday' => 'selasa',
            'wednesday' => 'rabu',
            'thursday' => 'kamis',
            'friday' => 'jumat',
            'saturday' => 'sabtu',
            'sunday' => 'minggu',
        ];

        $now = \Carbon\Carbon::now('Asia/Jakarta');
        $hariSekarang = strtolower($hariMap[strtolower($now->format('l'))] ?? $now->format('l'));
    @endphp

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-slate-800">
            Dashboard Pasien
        </h1>
    </div>

    {{-- BANNER ANTRIAN AKTIF --}}
    @if($antrianAktif)
        @php
            $kodePoliAktif =
                $antrianAktif->jadwalPeriksa->dokter->poli->kode_poli
                ?? $antrianAktif->kode_poli
                ?? 'B';

            $hariJadwalAktif = strtolower(trim($antrianAktif->jadwalPeriksa->hari ?? ''));

            $jamMulaiAktif = \Carbon\Carbon::today('Asia/Jakarta')
                ->setTimeFromTimeString($antrianAktif->jadwalPeriksa->jam_mulai);

            $jamSelesaiAktif = \Carbon\Carbon::today('Asia/Jakarta')
                ->setTimeFromTimeString($antrianAktif->jadwalPeriksa->jam_selesai);

            if ($hariJadwalAktif !== $hariSekarang) {
                $sedangDilayaniAktif = 'Belum mulai';
            } elseif ($now->lt($jamMulaiAktif)) {
                $sedangDilayaniAktif = 'Belum mulai';
            } elseif ($now->between($jamMulaiAktif, $jamSelesaiAktif)) {
                $sedangDilayaniAktif = $kodePoliAktif . '-' . ($antrianAktif->jadwalPeriksa->current_antrian ?? 0);
            } else {
                $sedangDilayaniAktif = 'Selesai';
            }
        @endphp

        <div class="mb-6 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-3xl shadow-sm p-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

                <div>
                    <p class="text-sm uppercase tracking-wider text-blue-100 mb-2">
                        Antrian Aktif Anda
                    </p>

                    <h2 class="text-2xl font-bold mb-2">
                        {{ $antrianAktif->jadwalPeriksa->dokter->poli->nama_poli ?? '-' }}
                    </h2>

                    <div class="space-y-1 text-sm text-blue-50">
                        <p>
                            Dokter:
                            {{ $antrianAktif->jadwalPeriksa->dokter->nama ?? '-' }}
                        </p>

                        <p>
                            Jadwal:
                            {{ $antrianAktif->jadwalPeriksa->hari ?? '-' }},
                            {{ \Carbon\Carbon::parse($antrianAktif->jadwalPeriksa->jam_mulai)->format('H:i') }}
                            -
                            {{ \Carbon\Carbon::parse($antrianAktif->jadwalPeriksa->jam_selesai)->format('H:i') }}
                        </p>

                        <p>
                            No. RM:
                            {{ $pasien->no_rm ?? '-' }}
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 min-w-[260px]">

                    {{-- NOMOR ANDA --}}
                    <div class="bg-white/15 rounded-2xl p-4 text-center border border-white/10">
                        <div class="text-sm text-blue-100 mb-1">
                            NOMOR ANDA
                        </div>

                        <div class="text-3xl font-bold">
                            {{ $kodePoliAktif }}-{{ $antrianAktif->no_antrian }}
                        </div>
                    </div>

                    {{-- SEDANG DILAYANI --}}
                    <div class="bg-sky-400/30 rounded-2xl p-4 text-center border-2 border-sky-300 shadow-sm">
                        <div class="text-sm text-sky-100 font-semibold mb-1">
                            SEDANG DILAYANI
                        </div>

                        <div class="text-3xl font-bold"
                             id="current-antrian-banner"
                             data-jadwal-id="{{ $antrianAktif->id_jadwal }}"
                             data-kode-poli="{{ $kodePoliAktif }}"
                             data-current-antrian="{{ $antrianAktif->jadwalPeriksa->current_antrian ?? 0 }}"
                             data-hari="{{ strtolower(trim($antrianAktif->jadwalPeriksa->hari ?? '')) }}"
                             data-jam-mulai="{{ \Carbon\Carbon::parse($antrianAktif->jadwalPeriksa->jam_mulai)->format('H:i:s') }}"
                             data-jam-selesai="{{ \Carbon\Carbon::parse($antrianAktif->jadwalPeriksa->jam_selesai)->format('H:i:s') }}">
                            {{ $sedangDilayaniAktif }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @else
        <div class="mb-6 bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
            <p class="text-slate-500">
                Anda belum memiliki antrian aktif.
            </p>
        </div>
    @endif

    {{-- TABEL JADWAL --}}
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">

        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold text-slate-800">
                    Daftar Jadwal Poliklinik
                </h2>

                <p class="text-sm text-slate-500">
                    Informasi dokter, jadwal, dan nomor antrian aktif.
                </p>
            </div>

            <a href="{{ route('pasien.daftar-poli.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 transition">
                <i class="fas fa-plus"></i>
                Daftar Poli
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">
                            No
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">
                            Poli
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">
                            Dokter
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">
                            Hari
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">
                            Jam Periksa
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">
                            Sedang Dilayani
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($jadwals as $index => $jadwal)
                        @php
                            $kodePoliJadwal =
                                $jadwal->kode_poli
                                ?? $jadwal->jadwalPeriksa->dokter->poli->kode_poli
                                ?? 'B';

                            $hariJadwal = strtolower(trim($jadwal->hari ?? ''));

                            $jamMulai = \Carbon\Carbon::today('Asia/Jakarta')
                                ->setTimeFromTimeString($jadwal->jam_mulai);

                            $jamSelesai = \Carbon\Carbon::today('Asia/Jakarta')
                                ->setTimeFromTimeString($jadwal->jam_selesai);

                            if ($hariJadwal !== $hariSekarang) {
                                $labelAntrian = 'Belum mulai';
                            } elseif ($now->lt($jamMulai)) {
                                $labelAntrian = 'Belum mulai';
                            } elseif ($now->between($jamMulai, $jamSelesai)) {
                                $labelAntrian = $kodePoliJadwal . '-' . ($jadwal->current_antrian ?? 0);
                            } else {
                                $labelAntrian = 'Selesai';
                            }
                        @endphp

                        <tr class="border-t border-slate-100 hover:bg-slate-50 transition">

                            <td class="px-6 py-4 text-slate-600">
                                {{ $index + 1 }}
                            </td>

                            <td class="px-6 py-4 font-medium text-slate-800">
                                {{ $jadwal->nama_poli ?? '-' }}
                            </td>

                            <td class="px-6 py-4 text-slate-600">
                                {{ $jadwal->nama_dokter ?? '-' }}
                            </td>

                            <td class="px-6 py-4 text-slate-600">
                                {{ $jadwal->hari ?? '-' }}
                            </td>

                            <td class="px-6 py-4 text-slate-600">
                                {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}
                                -
                                {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                            </td>

                            <td class="px-6 py-4">
                                <span class="current-antrian-table px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-sm font-bold border border-blue-100"
                                      data-jadwal-id="{{ $jadwal->id }}"
                                      data-kode-poli="{{ $kodePoliJadwal }}"
                                      data-current-antrian="{{ $jadwal->current_antrian ?? 0 }}"
                                      data-hari="{{ strtolower(trim($jadwal->hari ?? '')) }}"
                                      data-jam-mulai="{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i:s') }}"
                                      data-jam-selesai="{{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i:s') }}">
                                    {{ $labelAntrian }}
                                </span>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center text-slate-400">
                                Belum ada jadwal.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const hariMapJs = {
                sunday: 'minggu',
                monday: 'senin',
                tuesday: 'selasa',
                wednesday: 'rabu',
                thursday: 'kamis',
                friday: 'jumat',
                saturday: 'sabtu'
            };

            function getJakartaNow() {
                const now = new Date();
                const jakartaString = now.toLocaleString('en-US', { timeZone: 'Asia/Jakarta' });
                return new Date(jakartaString);
            }

            function pad(num) {
                return String(num).padStart(2, '0');
            }

            function getHariSekarangJakarta(dateObj) {
                const englishDay = dateObj.toLocaleDateString('en-US', { weekday: 'long' }).toLowerCase();
                return hariMapJs[englishDay] || englishDay;
            }

            function getTimeString(dateObj) {
                return `${pad(dateObj.getHours())}:${pad(dateObj.getMinutes())}:${pad(dateObj.getSeconds())}`;
            }

            function updateElementByTime(el) {
                const hari = (el.dataset.hari || '').toLowerCase().trim();
                const jamMulai = el.dataset.jamMulai || '00:00:00';
                const jamSelesai = el.dataset.jamSelesai || '00:00:00';
                const kodePoli = el.dataset.kodePoli || 'B';
                const currentAntrian = parseInt(el.dataset.currentAntrian || '0', 10);

                const now = getJakartaNow();
                const hariSekarang = getHariSekarangJakarta(now);
                const jamSekarang = getTimeString(now);

                if (hari !== hariSekarang) {
                    el.innerText = 'Belum mulai';
                    return;
                }

                if (jamSekarang < jamMulai) {
                    el.innerText = 'Belum mulai';
                    return;
                }

                if (jamSekarang > jamSelesai) {
                    el.innerText = 'Selesai';
                    return;
                }

                el.innerText = `${kodePoli}-${currentAntrian}`;
            }

            function refreshAllAntrianByTime() {
                document.querySelectorAll('.current-antrian-table').forEach(updateElementByTime);

                const bannerEl = document.getElementById('current-antrian-banner');
                if (bannerEl) {
                    updateElementByTime(bannerEl);
                }
            }

            refreshAllAntrianByTime();
            setInterval(refreshAllAntrianByTime, 1000);
            
// FRONT END REALTIME
            if (typeof window.Echo !== 'undefined') {
                window.Echo.channel('antrian-channel')
                    .listen('.AntrianUpdated', (data) => {
                        console.log('Realtime diterima:', data);

                        const tableEl = document.querySelector(
                            `.current-antrian-table[data-jadwal-id="${data.jadwal_id}"]`
                        );

                        if (tableEl) {
                            tableEl.dataset.currentAntrian = data.current_antrian;
                            updateElementByTime(tableEl);
                        }

                        @if($antrianAktif)
                            if (String(data.jadwal_id) === String("{{ $antrianAktif->id_jadwal }}")) {
                                const bannerEl = document.getElementById('current-antrian-banner');

                                if (bannerEl) {
                                    bannerEl.dataset.currentAntrian = data.current_antrian;
                                    updateElementByTime(bannerEl);
                                }
                            }
                        @endif
                    })
                    .listen('.JadwalUpdated', () => {
                        window.location.reload();
                    });
            }
        });
    </script>
    @endpush

</x-layouts.app>