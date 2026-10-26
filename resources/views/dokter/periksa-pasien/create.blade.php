<x-layouts.app title="Periksa Pasien">

    @php
        $biayaJasa = $daftar->jadwalPeriksa->dokter->poli->tarif ?? 0;
    @endphp

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Periksa Pasien</h1>
    </div>

    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-200 text-red-700 rounded-xl">
            <i class="fas fa-exclamation-triangle mr-2"></i> {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 max-w-4xl">
        <form action="{{ route('dokter.periksa.store') }}" method="POST">
            @csrf

            <input type="hidden" name="id_daftar_poli" value="{{ $daftar->id }}">

            <div class="mb-4">
                <label class="block font-semibold mb-2 text-slate-700">
                    Pilih Obat <span class="text-red-500">*</span>
                </label>

                <select id="obatSelect" class="w-full border border-slate-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <option value="">-- Pilih Obat --</option>
                    @foreach($obats as $obat)
                        <option
                            value="{{ $obat->id }}"
                            data-nama="{{ $obat->nama_obat }}"
                            data-harga="{{ $obat->harga }}"
                            {{ $obat->stok <= 0 ? 'disabled' : '' }}
                        >
                            {{ $obat->nama_obat }}
                            {{ $obat->stok <= 0 ? '(STOK HABIS)' : '(Rp ' . number_format($obat->harga, 0, ',', '.') . ')' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-2 text-slate-700">Obat Terpilih</label>
                <div id="listObat" class="space-y-2 mb-3"></div>
            </div>

            <div class="mb-6 bg-slate-50 p-4 rounded-2xl border border-slate-200">
                <div class="flex justify-between text-sm text-slate-600 mb-1">
                    <span>Biaya Jasa Dokter:</span>
                    <span id="labelBiayaJasa" class="font-bold">
                        Rp {{ number_format($biayaJasa, 0, ',', '.') }}
                    </span>
                </div>

                <div class="flex justify-between text-sm text-slate-600 mb-2">
                    <span>Total Harga Obat:</span>
                    <span id="labelTotalObat" class="font-bold">Rp 0</span>
                </div>

                <div class="border-t border-slate-300 pt-2 flex justify-between items-center">
                    <label class="font-bold text-slate-800">Total Biaya Akhir:</label>
                    <div class="text-xl font-black text-blue-600">
                        Rp <span id="totalHarga">{{ number_format($biayaJasa, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <label class="block font-semibold mb-2 text-slate-700">Catatan Medis</label>
                <textarea
                    name="catatan"
                    class="w-full border border-slate-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    rows="3"
                    placeholder="Masukkan catatan hasil pemeriksaan..."
                ></textarea>
            </div>

            <div class="flex gap-3">
                <button
                    type="submit"
                    class="px-6 py-2 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-sm"
                >
                    Simpan Pemeriksaan
                </button>

                <a
                    href="{{ route('dokter.periksa-pasien.index') }}"
                    class="px-6 py-2 bg-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-300 transition"
                >
                    Batal
                </a>
            </div>
        </form>
    </div>

    <script>
        const BIAYA_JASA = {{ (int) $biayaJasa }};
        let selectedObat = [];
        let totalHargaObat = 0;

        const select = document.getElementById('obatSelect');
        const listObat = document.getElementById('listObat');
        const labelBiayaJasa = document.getElementById('labelBiayaJasa');
        const labelTotalObat = document.getElementById('labelTotalObat');
        const totalHarga = document.getElementById('totalHarga');

        function formatRupiah(angka) {
            return Number(angka).toLocaleString('id-ID');
        }

        function renderHarga() {
            labelBiayaJasa.innerText = 'Rp ' + formatRupiah(BIAYA_JASA);
            labelTotalObat.innerText = 'Rp ' + formatRupiah(totalHargaObat);
            totalHarga.innerText = formatRupiah(BIAYA_JASA + totalHargaObat);
        }

        select.addEventListener('change', function () {
            const selected = select.options[select.selectedIndex];
            if (!selected.value) return;

            const id = selected.value;
            const nama = selected.dataset.nama;
            const harga = parseInt(selected.dataset.harga) || 0;

            if (selectedObat.includes(id)) {
                alert('Obat ini sudah ditambahkan!');
                select.value = '';
                return;
            }

            selectedObat.push(id);
            totalHargaObat += harga;

            const div = document.createElement('div');
            div.className = 'flex justify-between items-center bg-white px-4 py-2 rounded-xl border border-slate-200 shadow-sm';
            div.innerHTML = `
                <span class="text-sm font-medium text-slate-700">${nama}</span>
                <div class="flex items-center gap-3">
                    <span class="text-sm font-bold text-slate-600 text-right">Rp ${formatRupiah(harga)}</span>
                    <button
                        type="button"
                        class="text-red-400 hover:text-red-600 transition"
                        onclick="hapusObat('${id}', ${harga}, this)"
                    >
                        <i class="fas fa-trash-can"></i>
                    </button>
                </div>
                <input type="hidden" name="obat[]" value="${id}">
            `;

            listObat.appendChild(div);
            renderHarga();
            select.value = '';
        });

        function hapusObat(id, harga, btn) {
            selectedObat = selectedObat.filter(item => item != id);
            totalHargaObat -= harga;

            if (totalHargaObat < 0) {
                totalHargaObat = 0;
            }

            btn.closest('.bg-white').remove();
            renderHarga();
        }

        renderHarga();
    </script>

</x-layouts.app>