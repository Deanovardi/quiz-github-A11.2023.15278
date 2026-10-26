<x-layouts.app title="Data Obat">
    <div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Data Obat</h1>
    </div>

    <div class="flex items-center gap-2">
        <a href="{{ route('admin.obat.export') }}"
           class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
            Export Excel
        </a>

        <a href="{{ route('admin.obat.create') }}"
           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            + Tambah Obat
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
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">No</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Nama Obat</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Kemasan</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Harga</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Stok</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-slate-700">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($obats as $index => $obat)
                        <tr class="border-t hover:bg-slate-50 transition">
                            <td class="px-6 py-4 text-sm text-slate-700">{{ $index + 1 }}</td>

                            <td class="px-6 py-4 text-sm text-slate-700">
                                {{ $obat->nama_obat ?? '-' }}
                            </td>

                            <!-- 🔥 KEMASAN JADI HIJAU -->
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-flex items-center px-3 py-1 rounded-lg bg-green-100 text-green-700 font-semibold">
                                    {{ $obat->kemasan ?? '-' }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-sm text-slate-700">
                                Rp {{ number_format($obat->harga ?? 0, 0, ',', '.') }}
                            </td>

                            <td class="px-6 py-4 text-sm">
                                @if(($obat->stok ?? 0) <= 0)
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg bg-red-100 text-red-700 font-semibold">
                                        Habis
                                    </span>
                                @elseif(($obat->stok ?? 0) <= 10)
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg bg-yellow-100 text-yellow-700 font-semibold">
                                        {{ $obat->stok }} (Menipis)
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg bg-green-100 text-green-700 font-semibold">
                                        {{ $obat->stok }}
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.obat.edit', $obat->id) }}"
                                       class="px-3 py-1.5 bg-yellow-500 text-white text-sm rounded-lg hover:bg-yellow-600 transition">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.obat.destroy', $obat->id) }}" method="POST"
                                          onsubmit="return confirm('Yakin hapus data obat ini?')">
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
                            <td colspan="6" class="px-6 py-6 text-center text-slate-500">
                                Belum ada data obat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>