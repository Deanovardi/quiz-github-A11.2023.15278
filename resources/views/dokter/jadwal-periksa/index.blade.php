<x-layouts.app title="Jadwal Periksa">

    <div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Jadwal Periksa</h1>
    </div>

    <div class="flex items-center gap-2">
        <a href="{{ route('dokter.jadwal-periksa.export') }}"
           class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
            Export Excel
        </a>

        <a href="{{ route('dokter.jadwal-periksa.create') }}"
           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            + Tambah Jadwal
        </a>
    </div>
</div>

    @if(session('success'))
        <div class="mb-5 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Hari</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Jam Mulai</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Jam Selesai</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwals as $jadwal)
                        <tr class="border-t border-slate-100 hover:bg-slate-50 transition">
                            <td class="px-6 py-4 text-slate-600">{{ $jadwal->id }}</td>
                            <td class="px-6 py-4 font-medium text-slate-800">{{ $jadwal->hari }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('dokter.jadwal-periksa.edit', $jadwal->id) }}"
                                       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-amber-400 text-white text-sm font-semibold hover:bg-amber-500 transition">
                                        <i class="fas fa-pen"></i>
                                        Edit
                                    </a>

                                    <form action="{{ route('dokter.jadwal-periksa.destroy', $jadwal->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-red-500 text-white text-sm font-semibold hover:bg-red-600 transition">
                                            <i class="fas fa-trash"></i>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-400">
                                    <i class="fas fa-calendar-xmark text-4xl mb-4"></i>
                                    <p class="text-base">Belum ada jadwal periksa</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-layouts.app>