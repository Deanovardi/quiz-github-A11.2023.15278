<x-layouts.app title="Tambah Jadwal Periksa">

    <div class="mb-6">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('dokter.jadwal-periksa.index') }}"
               class="text-slate-500 hover:text-slate-700 transition">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl font-bold text-slate-800">Tambah Jadwal Periksa</h1>
        </div>
    </div>

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

    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6 max-w-6xl">
        <form action="{{ route('dokter.jadwal-periksa.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="hari" class="block text-sm font-semibold text-slate-700 mb-2">
                    Hari <span class="text-red-500">*</span>
                </label>
                <select
                    id="hari"
                    name="hari"
                    required
                    class="w-full rounded-xl border border-slate-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    <option value="">Pilih Hari</option>
                    <option value="Senin" {{ old('hari') == 'Senin' ? 'selected' : '' }}>Senin</option>
                    <option value="Selasa" {{ old('hari') == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                    <option value="Rabu" {{ old('hari') == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                    <option value="Kamis" {{ old('hari') == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                    <option value="Jumat" {{ old('hari') == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                    <option value="Sabtu" {{ old('hari') == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                    <option value="Minggu" {{ old('hari') == 'Minggu' ? 'selected' : '' }}>Minggu</option>
                </select>
                @error('hari')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="jam_mulai" class="block text-sm font-semibold text-slate-700 mb-2">
                    Jam Mulai <span class="text-red-500">*</span>
                </label>
                <input
                    type="time"
                    id="jam_mulai"
                    name="jam_mulai"
                    value="{{ old('jam_mulai') }}"
                    step="60"
                    required
                    class="w-full rounded-xl border border-slate-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                @error('jam_mulai')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="jam_selesai" class="block text-sm font-semibold text-slate-700 mb-2">
                    Jam Selesai <span class="text-red-500">*</span>
                </label>
                <input
                    type="time"
                    id="jam_selesai"
                    name="jam_selesai"
                    value="{{ old('jam_selesai') }}"
                    step="60"
                    required
                    class="w-full rounded-xl border border-slate-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                @error('jam_selesai')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-blue-700 text-white font-semibold hover:bg-blue-800 transition">
                    <i class="fas fa-save"></i>
                    Simpan
                </button>

                <a href="{{ route('dokter.jadwal-periksa.index') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-slate-100 text-slate-700 font-semibold hover:bg-slate-200 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>

</x-layouts.app>