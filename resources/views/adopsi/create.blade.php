<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Ajukan Adopsi: {{ $hewan->nama }}</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6 flex items-center gap-4 rounded-lg bg-white p-4 shadow">
            <img src="{{ $hewan->foto_src }}" alt="Foto {{ $hewan->nama }}" class="h-20 w-20 rounded-md object-cover">
            <div>
                <div class="font-semibold text-gray-800">{{ $hewan->nama }}</div>
                <div class="text-sm text-gray-500">{{ $hewan->kategori->nama }} &middot; {{ $hewan->ras ?? 'Campuran' }} &middot; {{ $hewan->umur_label }}</div>
            </div>
        </div>

        <form method="POST" action="{{ route('adopsi.store', $hewan) }}" class="space-y-5 rounded-lg bg-white p-6 shadow">
            @csrf

            <div>
                <x-input-label for="no_telepon" value="Nomor telepon / WhatsApp" />
                <x-text-input id="no_telepon" name="no_telepon" type="text" class="mt-1 block w-full" :value="old('no_telepon', auth()->user()->phone)" required />
                <x-input-error :messages="$errors->get('no_telepon')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="alamat_lengkap" value="Alamat lengkap tempat hewan akan tinggal" />
                <textarea id="alamat_lengkap" name="alamat_lengkap" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>{{ old('alamat_lengkap') }}</textarea>
                <x-input-error :messages="$errors->get('alamat_lengkap')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="tempat_tinggal" value="Tempat tinggal" />
                <select id="tempat_tinggal" name="tempat_tinggal" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    @foreach (['rumah_sendiri' => 'Rumah sendiri', 'kontrakan' => 'Kontrakan', 'kos' => 'Kos', 'apartemen' => 'Apartemen'] as $v => $l)
                        <option value="{{ $v }}" @selected(old('tempat_tinggal') === $v)>{{ $l }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('tempat_tinggal')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="pengalaman" value="Pengalaman memelihara hewan" />
                <select id="pengalaman" name="pengalaman" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    @foreach (['belum_pernah' => 'Belum pernah', 'pernah' => 'Pernah', 'berpengalaman' => 'Berpengalaman'] as $v => $l)
                        <option value="{{ $v }}" @selected(old('pengalaman') === $v)>{{ $l }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('pengalaman')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="jadwal_perawatan" value="Jadwal dan waktu yang tersedia untuk merawat" />
                <x-text-input id="jadwal_perawatan" name="jadwal_perawatan" type="text" class="mt-1 block w-full" :value="old('jadwal_perawatan')" required placeholder="Contoh: pagi dan sore, setiap hari" />
                <x-input-error :messages="$errors->get('jadwal_perawatan')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="anggaran_bulanan" value="Perkiraan anggaran perawatan per bulan (Rp)" />
                <x-text-input id="anggaran_bulanan" name="anggaran_bulanan" type="number" min="0" max="100000000" class="mt-1 block w-full" :value="old('anggaran_bulanan')" required />
                <x-input-error :messages="$errors->get('anggaran_bulanan')" class="mt-2" />
            </div>

            <div>
                <label class="flex items-start gap-2 text-sm text-gray-700">
                    <input type="checkbox" name="persetujuan_keluarga" value="1" class="mt-1 rounded border-gray-300" @checked(old('persetujuan_keluarga'))>
                    Semua anggota keluarga atau penghuni rumah menyetujui rencana adopsi ini.
                </label>
                <x-input-error :messages="$errors->get('persetujuan_keluarga')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="alasan" value="Alasan ingin mengadopsi (minimal 20 karakter)" />
                <textarea id="alasan" name="alasan" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>{{ old('alasan') }}</textarea>
                <x-input-error :messages="$errors->get('alasan')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="rencana_perawatan" value="Rencana perawatan dan penanganan kesehatan" />
                <textarea id="rencana_perawatan" name="rencana_perawatan" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>{{ old('rencana_perawatan') }}</textarea>
                <x-input-error :messages="$errors->get('rencana_perawatan')" class="mt-2" />
            </div>

            <div>
                <label class="flex items-start gap-2 text-sm text-gray-700">
                    <input type="checkbox" name="setuju" value="1" class="mt-1 rounded border-gray-300" @checked(old('setuju'))>
                    Saya sanggup merawat hewan ini dengan baik seumur hidupnya dan bersedia dihubungi pihak shelter.
                </label>
                <x-input-error :messages="$errors->get('setuju')" class="mt-2" />
            </div>

            <div class="space-y-3 rounded-lg border border-gray-200 p-4">
                <h3 class="font-semibold text-gray-800">Syarat dan Ketentuan Adopsi</h3>
                <div class="max-h-48 overflow-y-auto whitespace-pre-line text-sm text-gray-600">{{ $terms }}</div>
                <label class="flex items-start gap-2 text-sm text-gray-700">
                    <input type="checkbox" name="setuju_terms" value="1" class="mt-1 rounded border-gray-300" @checked(old('setuju_terms'))>
                    Saya telah membaca dan menyetujui Syarat dan Ketentuan yang berlaku untuk pengajuan adopsi ini.
                </label>
                <x-input-error :messages="$errors->get('setuju_terms')" class="mt-2" />
            </div>

            <div class="flex items-center gap-3">
                <x-primary-button>Kirim Pengajuan</x-primary-button>
                <a href="{{ route('hewan.show', $hewan) }}" class="text-sm text-gray-600 hover:underline">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>
