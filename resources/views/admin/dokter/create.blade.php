<x-layouts.app title="Tambah Dokter">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Tambah Dokter</h1>
    </div>

    @if ($errors->any())
        <div class="mb-4 rounded-lg border border-red-200 bg-red-100 px-4 py-3 text-red-700 shadow-sm">
            <div class="font-bold mb-1 italic text-sm underline">Terjadi kesalahan:</div>
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <form action="{{ route('admin.dokter.store') }}" method="POST" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block mb-2 font-medium">Nama Dokter <span class="text-red-600">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama') }}"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Masukkan nama dokter..." required>
                    @error('nama')
                        <small class="text-red-600 font-bold italic">{{ $message }}</small>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2 font-medium">Email <span class="text-red-600">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Masukkan email..." required>
                    @error('email')
                        <small class="text-red-600 font-bold italic">{{ $message }}</small>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2 font-medium">No. KTP <span class="text-red-600">*</span></label>
                    <input type="text" name="no_ktp" value="{{ old('no_ktp') }}"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Masukkan No. KTP..." required>
                    @error('no_ktp')
                        <small class="text-red-600 font-bold italic">{{ $message }}</small>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2 font-medium">No. HP</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp') }}"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Masukkan No. HP...">
                    @error('no_hp')
                        <small class="text-red-600 font-bold italic">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block mb-2 font-medium">Alamat</label>
                <textarea name="alamat" rows="4" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="Masukkan alamat...">{{ old('alamat') }}</textarea>
                @error('alamat')
                    <small class="text-red-600 font-bold italic">{{ $message }}</small>
                @enderror
            </div>

            <div>
                <label class="block mb-2 font-medium">Poli <span class="text-red-600">*</span></label>
                <select name="id_poli" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                    <option value="">-- Pilih Poli --</option>
                    @foreach($polis as $item)
                        <option value="{{ $item->id }}" {{ old('id_poli') == $item->id ? 'selected' : '' }}>
                            {{ $item->nama_poli }}
                        </option>
                    @endforeach
                </select>
                @error('id_poli')
                    <small class="text-red-600 font-bold italic">{{ $message }}</small>
                @enderror
            </div>

            <div>
                <label class="block mb-2 font-medium">Password <span class="text-red-600">*</span></label>
                <input type="password" name="password"
                    class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Minimal 6 karakter..." required>
                @error('password')
                    <small class="text-red-600 font-bold italic">{{ $message }}</small>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-bold shadow-sm">
                    Simpan
                </button>
                <a href="{{ route('admin.dokter.index') }}" class="px-4 py-2 bg-slate-200 rounded-lg hover:bg-slate-300 transition text-slate-700 font-bold">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-layouts.app>