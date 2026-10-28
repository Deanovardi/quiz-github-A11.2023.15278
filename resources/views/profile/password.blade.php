<x-layouts.app title="Ganti Password">
    @php
        $dashboardRoute = match (auth()->user()->role) {
            'admin' => 'admin.dashboard',
            'dokter' => 'dokter.dashboard',
            default => 'pasien.dashboard',
        };
    @endphp

    <div class="max-w-2xl">
        <div class="mb-6">
            <a href="{{ route($dashboardRoute) }}" class="inline-flex items-center gap-2 mb-4 text-sm font-medium text-slate-600 hover:text-primary">
                <i class="fas fa-arrow-left" aria-hidden="true"></i>
                Kembali
            </a>
            <h1 class="text-2xl font-bold text-slate-800">Ganti Password</h1>
            <p class="mt-1 text-sm text-slate-500">Perbarui password akun yang sedang digunakan.</p>
        </div>

        <div class="bg-base-100 border border-base-300 rounded-xl shadow-sm">
            <form action="{{ route('profile.password.update') }}" method="POST" class="space-y-5 p-6">
                @csrf
                @method('PUT')

                <div class="form-control">
                    <label for="current_password" class="label">
                        <span class="label-text font-semibold">Password Lama</span>
                    </label>
                    <input
                        id="current_password"
                        type="password"
                        name="current_password"
                        autocomplete="current-password"
                        required
                        class="input input-bordered w-full @error('current_password') input-error @enderror"
                    >
                    @error('current_password')
                        <p class="mt-1 text-sm text-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-control">
                    <label for="password" class="label">
                        <span class="label-text font-semibold">Password Baru</span>
                    </label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        autocomplete="new-password"
                        minlength="8"
                        required
                        class="input input-bordered w-full @error('password') input-error @enderror"
                    >
                    @error('password')
                        <p class="mt-1 text-sm text-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-control">
                    <label for="password_confirmation" class="label">
                        <span class="label-text font-semibold">Konfirmasi Password Baru</span>
                    </label>
                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        autocomplete="new-password"
                        minlength="8"
                        required
                        class="input input-bordered w-full"
                    >
                </div>

                <div class="flex flex-wrap gap-3 pt-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-key" aria-hidden="true"></i>
                        Simpan Password
                    </button>
                    <a href="{{ route($dashboardRoute) }}" class="btn btn-ghost">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>