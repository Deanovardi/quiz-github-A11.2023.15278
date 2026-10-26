<x-layouts.app title="Edit Dokter">

```
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('admin.dokter.index') }}"
        class="flex items-center justify-center w-9 h-9 rounded-lg bg-slate-100 text-slate-500 hover:bg-slate-200 transition">
        <i class="fas fa-arrow-left text-xs"></i>
    </a>
    <h2 class="text-xl font-bold text-slate-800">
        Edit Dokter
    </h2>
</div>

<div class="card bg-base-100 shadow-md rounded-2xl border border-slate-200">
    <div class="card-body p-7">

        <form action="{{ route('admin.dokter.update', $dokter->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div class="form-control">
                    <label class="label pb-1">
                        <span class="text-sm font-semibold text-gray-700">
                            Nama Dokter <span class="text-red-500">*</span>
                        </span>
                    </label>

                    <input type="text" name="nama"
                        value="{{ old('nama', $dokter->nama) }}"
                        placeholder="Masukkan nama dokter..."
                        class="input input-bordered w-full rounded-lg text-sm @error('nama') input-error @enderror"
                        required>

                    @error('nama')
                        <label class="label pt-1">
                            <span class="label-text-alt text-red-500">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <div class="form-control">
                    <label class="label pb-1">
                        <span class="text-sm font-semibold text-gray-700">
                            Email <span class="text-red-500">*</span>
                        </span>
                    </label>

                    <input type="email" name="email"
                        value="{{ old('email', $dokter->email) }}"
                        placeholder="Masukkan email..."
                        class="input input-bordered w-full rounded-lg text-sm @error('email') input-error @enderror"
                        required>

                    @error('email')
                        <label class="label pt-1">
                            <span class="label-text-alt text-red-500">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <div class="form-control">
                    <label class="label pb-1">
                        <span class="text-sm font-semibold text-gray-700">
                            No. KTP <span class="text-red-500">*</span>
                        </span>
                    </label>

                    <input type="text" name="no_ktp"
                        value="{{ old('no_ktp', $dokter->no_ktp) }}"
                        placeholder="Masukkan nomor KTP..."
                        class="input input-bordered w-full rounded-lg text-sm @error('no_ktp') input-error @enderror"
                        required>

                    @error('no_ktp')
                        <label class="label pt-1">
                            <span class="label-text-alt text-red-500">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <div class="form-control">
                    <label class="label pb-1">
                        <span class="text-sm font-semibold text-gray-700">
                            No. HP <span class="text-red-500">*</span>
                        </span>
                    </label>

                    <input type="text" name="no_hp"
                        value="{{ old('no_hp', $dokter->no_hp) }}"
                        placeholder="Masukkan nomor HP..."
                        class="input input-bordered w-full rounded-lg text-sm @error('no_hp') input-error @enderror"
                        required>

                    @error('no_hp')
                        <label class="label pt-1">
                            <span class="label-text-alt text-red-500">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <div class="form-control md:col-span-2">
                    <label class="label pb-1">
                        <span class="text-sm font-semibold text-gray-700">
                            Alamat <span class="text-red-500">*</span>
                        </span>
                    </label>

                    <textarea name="alamat" rows="4" placeholder="Masukkan alamat dokter..."
                        class="textarea textarea-bordered w-full rounded-lg text-sm resize-none @error('alamat') textarea-error @enderror"
                        required>{{ old('alamat', $dokter->alamat) }}</textarea>

                    @error('alamat')
                        <label class="label pt-1">
                            <span class="label-text-alt text-red-500">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <div class="form-control">
                    <label class="label pb-1">
                        <span class="text-sm font-semibold text-gray-700">
                            Poli <span class="text-red-500">*</span>
                        </span>
                    </label>

                    <select name="id_poli"
                        class="select select-bordered w-full rounded-lg text-sm @error('id_poli') select-error @enderror"
                        required>
                        <option value="">Pilih Poli</option>
                        @foreach ($polis as $item)
                            <option value="{{ $item->id }}" {{ old('id_poli', $dokter->id_poli) == $item->id ? 'selected' : '' }}>
                                {{ $item->nama_poli }}
                            </option>
                        @endforeach
                    </select>

                    @error('id_poli')
                        <label class="label pt-1">
                            <span class="label-text-alt text-red-500">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <div class="form-control md:col-span-2">
                    <label class="label pb-1">
                        <span class="text-sm font-semibold text-gray-700">
                            Password Baru
                        </span>
                    </label>

                    <input type="password" name="password"
                        placeholder="Minimal 6 karakter..."
                        class="input input-bordered w-full rounded-lg text-sm @error('password') input-error @enderror">

                    @error('password')
                        <label class="label pt-1">
                            <span class="label-text-alt text-red-500">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

            </div>

            <div class="flex gap-3 mt-6">
                <button type="submit"
                    class="flex items-center gap-2 px-6 py-2.5 bg-[#2d4499] hover:bg-[#1e2d6b] text-white rounded-lg text-sm font-semibold transition">
                    <i class="fas fa-save"></i>
                    Update
                </button>

                <a href="{{ route('admin.dokter.index') }}"
                    class="flex items-center gap-2 px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-500 rounded-lg text-sm font-semibold transition">
                    Batal
                </a>
            </div>

        </form>
    </div>
</div>
```

</x-layouts.app>
