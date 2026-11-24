@csrf
<div class="grid gap-5 sm:grid-cols-2">
    <div>
        <x-input-label for="nama" value="Nama hewan" />
        <x-text-input id="nama" name="nama" type="text" class="mt-1 block w-full" :value="old('nama', $hewan->nama)" required />
        <x-input-error :messages="$errors->get('nama')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="kategori_id" value="Jenis hewan" />
        <select id="kategori_id" name="kategori_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
            <option value="">-- pilih --</option>
            @foreach ($kategoris as $k)
                <option value="{{ $k->id }}" @selected((string) old('kategori_id', $hewan->kategori_id) === (string) $k->id)>{{ $k->nama }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('kategori_id')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="ras" value="Ras" />
        <x-text-input id="ras" name="ras" type="text" class="mt-1 block w-full" :value="old('ras', $hewan->ras)" />
        <x-input-error :messages="$errors->get('ras')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="warna" value="Warna" />
        <x-text-input id="warna" name="warna" type="text" class="mt-1 block w-full" :value="old('warna', $hewan->warna)" />
        <x-input-error :messages="$errors->get('warna')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="jenis_kelamin" value="Jenis kelamin" />
        <select id="jenis_kelamin" name="jenis_kelamin" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
            <option value="jantan" @selected(old('jenis_kelamin', $hewan->jenis_kelamin) === 'jantan')>Jantan</option>
            <option value="betina" @selected(old('jenis_kelamin', $hewan->jenis_kelamin) === 'betina')>Betina</option>
        </select>
        <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="umur_bulan" value="Umur (bulan)" />
        <x-text-input id="umur_bulan" name="umur_bulan" type="number" min="0" max="360" class="mt-1 block w-full" :value="old('umur_bulan', $hewan->umur_bulan)" required />
        <x-input-error :messages="$errors->get('umur_bulan')" class="mt-2" />
    </div>
    <div class="sm:col-span-2">
        <x-input-label for="kesehatan" value="Kondisi kesehatan" />
        <x-text-input id="kesehatan" name="kesehatan" type="text" class="mt-1 block w-full" :value="old('kesehatan', $hewan->kesehatan)" />
        <x-input-error :messages="$errors->get('kesehatan')" class="mt-2" />
    </div>
    <div class="sm:col-span-2">
        <x-input-label for="deskripsi" value="Deskripsi (minimal 20 karakter)" />
        <textarea id="deskripsi" name="deskripsi" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>{{ old('deskripsi', $hewan->deskripsi) }}</textarea>
        <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
    </div>
    <div class="flex items-center gap-6 sm:col-span-2">
        <label class="flex items-center gap-2 text-sm">
            <input type="hidden" name="sudah_vaksin" value="0">
            <input type="checkbox" name="sudah_vaksin" value="1" class="rounded border-gray-300" @checked(old('sudah_vaksin', $hewan->sudah_vaksin))> Sudah vaksin
        </label>
        <label class="flex items-center gap-2 text-sm">
            <input type="hidden" name="sudah_steril" value="0">
            <input type="checkbox" name="sudah_steril" value="1" class="rounded border-gray-300" @checked(old('sudah_steril', $hewan->sudah_steril))> Sudah steril
        </label>
    </div>
    <div>
        <x-input-label for="status" value="Status" />
        <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            <option value="tersedia" @selected(old('status', $hewan->status) === 'tersedia')>Tersedia</option>
            <option value="teradopsi" @selected(old('status', $hewan->status) === 'teradopsi')>Teradopsi</option>
        </select>
        <x-input-error :messages="$errors->get('status')" class="mt-2" />
    </div>
    <div></div>
    <div>
        <x-input-label for="foto" value="Foto (unggah, maks 2 MB)" />
        <input id="foto" name="foto" type="file" accept="image/jpeg,image/png,image/webp" class="mt-1 block w-full text-sm">
        <x-input-error :messages="$errors->get('foto')" class="mt-2" />
        @if ($hewan->foto)
            <img src="{{ $hewan->foto_src }}" alt="Foto saat ini" class="mt-2 h-24 rounded">
        @endif
    </div>
    <div>
        <x-input-label for="foto_url" value="atau URL foto (disarankan saat deploy ke Vercel)" />
        <x-text-input id="foto_url" name="foto_url" type="url" class="mt-1 block w-full" :value="old('foto_url', $hewan->foto_url)" placeholder="https://..." />
        <x-input-error :messages="$errors->get('foto_url')" class="mt-2" />
    </div>
</div>
