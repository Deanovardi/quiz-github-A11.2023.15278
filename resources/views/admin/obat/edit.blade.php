<x-layouts.app title="Edit Obat">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Edit Obat</h1>
    </div>

    @if ($errors->any())
        <div class="mb-4 rounded-lg border border-red-200 bg-red-100 px-4 py-3 text-red-700">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <form action="{{ route('admin.obat.update', $obat->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block mb-2 font-medium">Nama Obat <span class="text-red-600">*</span></label>
                    <input type="text" name="nama_obat"
                        value="{{ old('nama_obat', $obat->nama_obat) }}"
                        class="w-full border rounded-lg px-4 py-2"
                        placeholder="Masukkan nama obat..." required>
                    @error('nama_obat')
                        <small class="text-red-600">{{ $message }}</small>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2 font-medium">Kemasan <span class="text-red-600">*</span></label>
                    <input type="text" name="kemasan"
                        value="{{ old('kemasan', $obat->kemasan) }}"
                        class="w-full border rounded-lg px-4 py-2"
                        placeholder="Contoh: Strip, Botol..." required>
                    @error('kemasan')
                        <small class="text-red-600">{{ $message }}</small>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2 font-medium">Harga <span class="text-red-600">*</span></label>
                    <input type="number" name="harga"
                        value="{{ old('harga', $obat->harga) }}"
                        class="w-full border rounded-lg px-4 py-2"
                        min="0" required>
                    @error('harga')
                        <small class="text-red-600">{{ $message }}</small>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2 font-medium">Stok <span class="text-red-600">*</span></label>
                    <input type="number" name="stok"
                        value="{{ old('stok', $obat->stok) }}"
                        class="w-full border rounded-lg px-4 py-2"
                        min="0" required>
                    @error('stok')
                        <small class="text-red-600">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                    Update
                </button>
                <a href="{{ route('admin.obat.index') }}" class="px-4 py-2 bg-slate-200 rounded-lg">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-layouts.app>