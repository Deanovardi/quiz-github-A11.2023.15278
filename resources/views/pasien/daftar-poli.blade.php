<x-layouts.app title="Daftar Poli">

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

    <div class="max-w-4xl mx-auto space-y-8">
        {{-- Form Pendaftaran --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-slate-800">🧾 Pendaftaran Poli</h1>
                <p class="text-slate-500 mt-2">Silakan pilih poli dan jadwal yang tersedia</p>
            </div>

            @if(session('success'))
                <div class="mb-5 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-green-700 flex items-center gap-3">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-red-700">
                    <div class="font-semibold mb-1">Terdapat kesalahan:</div>
                    <ul class="list-disc pl-5 text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('pasien.daftar-poli.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nomor Rekam Medis</label>
                    <input type="text"
                        value="{{ $pasien->no_rm ?? '-' }}"
                        readonly
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-700 font-mono">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Pilih Poli
                        </label>

                        <select id="id_poli"
                            name="id_poli"
                            required
                            class="w-full rounded-xl border border-slate-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">

                            <option value="">-- Pilih Poli --</option>

                            @foreach($poli as $p)
                                <option value="{{ $p->id }}" {{ old('id_poli') == $p->id ? 'selected' : '' }}>
                                    {{ $p->nama_poli }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Pilih Jadwal
                        </label>

                        <select id="id_jadwal"
                            name="id_jadwal"
                            required
                            class="w-full rounded-xl border border-slate-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">

                            <option value="">-- Pilih Jadwal --</option>

                            @foreach($jadwals as $jadwal)
                                @php
                                    $kodePoliOption = $jadwal->kode_poli ?? 'B';
                                @endphp

                                <option value="{{ $jadwal->id }}"
                                        data-poli="{{ $jadwal->id_poli }}"
                                        {{ old('id_jadwal') == $jadwal->id ? 'selected' : '' }}>

                                    {{ $kodePoliOption }} |
                                    {{ $jadwal->hari }}
                                    |
                                    {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}
                                    -
                                    {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                    |
                                    Dr. {{ $jadwal->nama_dokter }}

                                </option>
                            @endforeach

                        </select>
                    </div>

                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Keluhan
                    </label>

                    <textarea
                        name="keluhan"
                        rows="4"
                        required
                        class="w-full rounded-xl border border-slate-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('keluhan') }}</textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-8 py-3 font-semibold text-white hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                        Daftar Poli
                    </button>
                </div>

            </form>
        </div>

        {{-- STATUS ANTRIAN --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">

            <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                <h2 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                    <span class="flex h-3 w-3 rounded-full bg-green-500 animate-pulse"></span>
                    Status Antrian Sekarang
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50">
                        <tr>
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
                                Sedang Dilayani
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @forelse($jadwals as $j)
                            @php
                                $kodePoli = $j->kode_poli ?? 'B';
                                $hariJadwal = strtolower(trim($j->hari ?? ''));

                                $jamMulai = \Carbon\Carbon::today('Asia/Jakarta')
                                    ->setTimeFromTimeString($j->jam_mulai);

                                $jamSelesai = \Carbon\Carbon::today('Asia/Jakarta')
                                    ->setTimeFromTimeString($j->jam_selesai);

                                if ($hariJadwal !== $hariSekarang) {
                                    $labelAntrian = 'Belum mulai';
                                } elseif ($now->lt($jamMulai)) {
                                    $labelAntrian = 'Belum mulai';
                                } elseif ($now->between($jamMulai, $jamSelesai)) {
                                    $labelAntrian = $kodePoli . '-' . ($j->current_antrian ?? 0);
                                } else {
                                    $labelAntrian = 'Selesai';
                                }
                            @endphp

                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 font-medium text-slate-800">
                                    {{ $j->nama_poli }}
                                </td>

                                <td class="px-6 py-4 text-slate-600">
                                    Dr. {{ $j->nama_dokter }}
                                </td>

                                <td class="px-6 py-4 text-slate-600">
                                    {{ $j->hari }}
                                    ({{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }})
                                </td>

                                <td class="px-6 py-4">
                                    <span class="current-antrian-table px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-sm font-bold border border-blue-100"
                                          data-jadwal-id="{{ $j->id }}"
                                          data-kode-poli="{{ $kodePoli }}">
                                        {{ $labelAntrian }}
                                    </span>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-slate-500">
                                    Belum ada jadwal poli yang tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>

    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const poliSelect = document.getElementById('id_poli');
            const jadwalSelect = document.getElementById('id_jadwal');
            const allOptions = Array.from(jadwalSelect.querySelectorAll('option'));

            function filterJadwal() {
                const selectedPoli = poliSelect.value;
                const oldSelected = "{{ old('id_jadwal') }}";
                const matched = allOptions.filter(option => option.value && option.dataset.poli === selectedPoli);

                jadwalSelect.innerHTML = '';
                jadwalSelect.disabled = false;

                const placeholder = document.createElement('option');
                placeholder.value = '';
                placeholder.textContent = selectedPoli && matched.length === 0
                    ? 'Belum ada jadwal untuk poli ini'
                    : '-- Pilih Jadwal --';
                placeholder.disabled = selectedPoli && matched.length === 0;
                placeholder.selected = true;
                jadwalSelect.appendChild(placeholder);

                if (selectedPoli && matched.length === 0) {
                    const submitBtn = document.querySelector('button[type="submit"]');
                    if (submitBtn) submitBtn.disabled = true;
                    return;
                }

                matched.forEach(option => {
                    const cloned = option.cloneNode(true);
                    if (oldSelected && cloned.value === oldSelected) cloned.selected = true;
                    jadwalSelect.appendChild(cloned);
                });

                const submitBtn = document.querySelector('button[type="submit"]');
                if (submitBtn) submitBtn.disabled = false;
            }

            filterJadwal();
            poliSelect.addEventListener('change', filterJadwal);

            if (typeof window.Echo !== 'undefined') {
                window.Echo.channel('antrian-channel')
                    .listen('.AntrianUpdated', (data) => {
                        console.log('Realtime diterima:', data);

                        const tableEl = document.querySelector(
                            `.current-antrian-table[data-jadwal-id="${data.jadwal_id}"]`
                        );

                        if (tableEl) {
                            const kodePoli = tableEl.dataset.kodePoli || 'B';
                            tableEl.innerText = `${kodePoli}-${data.current_antrian}`;
                        }
                    })
                    .listen('.JadwalUpdated', () => {
                        window.location.reload();
                    });
            }
        });
    </script>
    @endpush

</x-layouts.app>