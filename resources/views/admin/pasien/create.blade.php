<x-layouts.app title="Tambah Pasien">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Tambah Pasien</h1>
    </div>

    @if ($errors->any())
        <div class="mb-4 rounded-lg border border-red-200 bg-red-100 px-4 py-3 text-red-700">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <form action="{{ route('admin.pasien.store') }}" method="POST" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block mb-2 font-medium">Nama Pasien <span class="text-red-600">*</span></label>
                    <input
                        type="text"
                        name="nama"
                        value="{{ old('nama') }}"
                        class="w-full border rounded-lg px-4 py-2"
                        placeholder="Masukkan nama pasien..."
                        required
                    >
                    @error('nama')
                        <small class="text-red-600">{{ $message }}</small>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2 font-medium">Email <span class="text-red-600">*</span></label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="w-full border rounded-lg px-4 py-2"
                        placeholder="Masukkan email..."
                        required
                    >
                    @error('email')
                        <small class="text-red-600">{{ $message }}</small>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2 font-medium">No. KTP</label>
                    <input
                        type="text"
                        name="no_ktp"
                        value="{{ old('no_ktp') }}"
                        class="w-full border rounded-lg px-4 py-2"
                        placeholder="Masukkan No. KTP..."
                    >
                    @error('no_ktp')
                        <small class="text-red-600">{{ $message }}</small>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2 font-medium">No. HP</label>
                    <input
                        type="text"
                        name="no_hp"
                        value="{{ old('no_hp') }}"
                        class="w-full border rounded-lg px-4 py-2"
                        placeholder="Masukkan No. HP..."
                    >
                    @error('no_hp')
                        <small class="text-red-600">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block mb-2 font-medium">Alamat</label>
                <textarea
                    name="alamat"
                    rows="4"
                    class="w-full border rounded-lg px-4 py-2"
                    placeholder="Masukkan alamat..."
                >{{ old('alamat') }}</textarea>
                @error('alamat')
                    <small class="text-red-600">{{ $message }}</small>
                @enderror
            </div>

            <div>
                <label class="block mb-2 font-medium">Password <span class="text-red-600">*</span></label>
                <input
                    type="password"
                    name="password"
                    class="w-full border rounded-lg px-4 py-2"
                    placeholder="Minimal 6 karakter..."
                    required
                >
                @error('password')
                    <small class="text-red-600">{{ $message }}</small>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                    Simpan
                </button>
                <a href="{{ route('admin.pasien.index') }}" class="px-4 py-2 bg-slate-200 rounded-lg">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-layouts.app>