<x-layouts.app title="Tambah Obat">

    <div class="mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.obat.index') }}" class="text-slate-500 hover:text-slate-700">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-2xl font-bold text-slate-800">Tambah Obat</h1>
        </div>
    </div>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-200 text-red-700 rounded-lg">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 ">
        <form action="{{ route('admin.obat.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- 2 KOLOM --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- Nama Obat --}}
                <div>
                    <label class="block text-sm font-semibold mb-2">
                        Nama Obat <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_obat"
                        value="{{ old('nama_obat') }}"
                        placeholder="Masukkan nama obat..."
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                {{-- Kemasan --}}
                <div>
                    <label class="block text-sm font-semibold mb-2">
                        Kemasan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="kemasan"
                        value="{{ old('kemasan') }}"
                        placeholder="Contoh: Strip, Botol..."
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

            </div>

            {{-- FULL WIDTH --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- Harga --}}
                <div>
                    <label class="block text-sm font-semibold mb-2">
                        Harga <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="harga"
                        value="{{ old('harga') }}"
                        placeholder="Rp 0"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                {{-- Stok --}}
                <div>
                    <label class="block text-sm font-semibold mb-2">
                        Stok <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="stok"
                        value="{{ old('stok') }}"
                        placeholder="Jumlah stok"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

            </div>

            {{-- BUTTON --}}
            <div class="flex gap-3 pt-3">
                <button type="submit"
                    class="flex items-center gap-2 px-5 py-2 rounded-xl bg-blue-600 text-white hover:bg-blue-700 transition">
                    <i class="fas fa-save"></i> Simpan
                </button>

                <a href="{{ route('admin.obat.index') }}"
                    class="px-5 py-2 rounded-xl bg-slate-200 hover:bg-slate-300 transition">
                    Batal
                </a>
            </div>

        </form>
    </div>

</x-layouts.app>