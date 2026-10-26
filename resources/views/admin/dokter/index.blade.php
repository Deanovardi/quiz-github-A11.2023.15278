<x-layouts.app title="Data Dokter">
    <div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Data Dokter</h1>
    </div>

    <div class="flex items-center gap-2">
        <a href="{{ route('admin.dokter.export') }}"
           class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
            Export Excel
        </a>

        <a href="{{ route('admin.dokter.create') }}"
           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            + Tambah Dokter
        </a>
    </div>
</div>

    @if(session('success'))
        <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-700 border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Nama Dokter</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Email</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">No. KTP</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">No. HP</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Alamat</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Poli</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-slate-700">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($dokters as $dokter)
                        <tr class="border-t hover:bg-slate-50 transition">
                            <td class="px-6 py-4 text-sm text-slate-700">{{ $dokter->nama ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-slate-700">{{ $dokter->email ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-slate-700">{{ $dokter->no_ktp ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-slate-700">{{ $dokter->no_hp ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-slate-700">{{ $dokter->alamat ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-flex items-center px-3 py-1 rounded-lg bg-blue-100 text-blue-700 font-semibold">
                                    {{ $dokter->poli->nama_poli ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.dokter.edit', $dokter->id) }}"
                                       class="px-3 py-1.5 bg-yellow-500 text-white text-sm rounded-lg hover:bg-yellow-600 transition">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.dokter.destroy', $dokter->id) }}" method="POST"
                                          onsubmit="return confirm('Yakin hapus data dokter ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-3 py-1.5 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-6 text-center text-slate-500">
                                Belum ada data dokter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>