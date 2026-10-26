<x-layouts.app title="Tambah Poli">

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.polis.index') }}"
            class="flex items-center justify-center w-9 h-9 rounded-lg bg-slate-100 text-slate-500 hover:bg-slate-200 transition">
            <i class="fas fa-arrow-left text-xs"></i>
        </a>

        <h2 class="text-xl font-bold text-slate-800">
            Tambah Poli
        </h2>
    </div>

    <div class="card bg-base-100 shadow-md rounded-2xl border border-slate-200">
        <div class="card-body p-7">

            <form action="{{ route('admin.polis.store') }}" method="POST">
                @csrf

                {{-- NAMA POLI --}}
                <div class="form-control mb-5">
                    <label class="label pb-1">
                        <span class="text-sm font-semibold text-gray-700">
                            Nama Poli <span class="text-red-500">*</span>
                        </span>
                    </label>

                    <input type="text"
                        name="nama_poli"
                        value="{{ old('nama_poli') }}"
                        class="input input-bordered w-full rounded-lg text-sm"
                        placeholder="Masukkan nama poli..."
                        required>
                </div>

                {{-- KETERANGAN --}}
                <div class="form-control mb-5">
                    <label class="label pb-1">
                        <span class="text-sm font-semibold text-gray-700">
                            Keterangan
                        </span>
                    </label>

                    <textarea name="keterangan"
                        class="textarea textarea-bordered w-full rounded-lg text-sm"
                        rows="4"
                        placeholder="Masukkan keterangan...">{{ old('keterangan') }}</textarea>
                </div>

                {{-- TARIF POLI (INI YANG KURANG) --}}
                <div class="form-control mb-6">
                    <label class="label pb-1">
                        <span class="text-sm font-semibold text-gray-700">
                            Tarif Poli <span class="text-red-500">*</span>
                        </span>
                    </label>

                    <input type="number"
                        name="tarif"
                        value="{{ old('tarif') }}"
                        class="input input-bordered w-full rounded-lg text-sm"
                        placeholder="Masukkan tarif poli..."
                        required>
                </div>

                <div class="flex gap-3">

                    <button type="submit"
                        class="px-6 py-2.5 bg-[#2d4499] text-white rounded-lg">
                        Simpan
                    </button>

                    <a href="{{ route('admin.polis.index') }}"
                        class="px-6 py-2.5 bg-slate-100 text-slate-500 rounded-lg">
                        Batal
                    </a>

                </div>

            </form>

        </div>
    </div>

</x-layouts.app>