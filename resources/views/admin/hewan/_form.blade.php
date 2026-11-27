@csrf
<div class="grid gap-5 sm:grid-cols-2">
    <div>
        <x-input-label for="nama" value="Nama hewan" />
        <x-text-input id="nama" name="nama" type="text" class="mt-1 block w-full rounded-xl border-[#e3e7df] focus:border-[#78977a] focus:ring-[#78977a]" :value="old('nama', $hewan->nama)" required />
        <x-input-error :messages="$errors->get('nama')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="kategori_id" value="Jenis hewan" />
        <select id="kategori_id" name="kategori_id" class="mt-1 block w-full rounded-xl border-[#e3e7df] shadow-sm focus:border-[#78977a] focus:ring-[#78977a]" required>
            <option value="">Pilih jenis hewan</option>
            @foreach ($kategoris as $k)
                <option value="{{ $k->id }}" @selected((string) old('kategori_id', $hewan->kategori_id) === (string) $k->id)>{{ $k->nama }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('kategori_id')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="ras" value="Jenis / ras" />
        <x-text-input id="ras" name="ras" type="text" class="mt-1 block w-full rounded-xl border-[#e3e7df] focus:border-[#78977a] focus:ring-[#78977a]" :value="old('ras', $hewan->ras)" placeholder="Contoh: British Shorthair" />
        <x-input-error :messages="$errors->get('ras')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="warna" value="Warna bulu / morfologi" />
        <x-text-input id="warna" name="warna" type="text" class="mt-1 block w-full rounded-xl border-[#e3e7df] focus:border-[#78977a] focus:ring-[#78977a]" :value="old('warna', $hewan->warna)" placeholder="Warna alami asli" />
        <x-input-error :messages="$errors->get('warna')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="jenis_kelamin" value="Jenis kelamin" />
        <select id="jenis_kelamin" name="jenis_kelamin" class="mt-1 block w-full rounded-xl border-[#e3e7df] shadow-sm focus:border-[#78977a] focus:ring-[#78977a]" required>
            <option value="jantan" @selected(old('jenis_kelamin', $hewan->jenis_kelamin) === 'jantan')>Jantan</option>
            <option value="betina" @selected(old('jenis_kelamin', $hewan->jenis_kelamin) === 'betina')>Betina</option>
        </select>
        <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="umur_bulan" value="Umur (bulan)" />
        <x-text-input id="umur_bulan" name="umur_bulan" type="number" min="0" max="360" class="mt-1 block w-full rounded-xl border-[#e3e7df] focus:border-[#78977a] focus:ring-[#78977a]" :value="old('umur_bulan', $hewan->umur_bulan)" required />
        <x-input-error :messages="$errors->get('umur_bulan')" class="mt-2" />
    </div>
    <div class="sm:col-span-2">
        <x-input-label for="kesehatan" value="Kondisi kesehatan" />
        <x-text-input id="kesehatan" name="kesehatan" type="text" class="mt-1 block w-full rounded-xl border-[#e3e7df] focus:border-[#78977a] focus:ring-[#78977a]" :value="old('kesehatan', $hewan->kesehatan)" placeholder="Contoh: Sehat, aktif, bebas kutu dan jamur" />
        <x-input-error :messages="$errors->get('kesehatan')" class="mt-2" />
    </div>
    <div class="sm:col-span-2">
        <x-input-label for="deskripsi" value="Deskripsi iklan (minimal 20 karakter)" />
        <div class="mt-2 rounded-2xl border border-[#e3e9df] bg-[#f7f8f4] p-4 sm:p-5" x-data>
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <p id="deskripsi-help" class="max-w-2xl text-sm leading-6 text-[#68766b]">Gunakan format agar calon adopter mendapat informasi lengkap tentang kesehatan, dokumen, perawatan, lokasi, dan metode serah terima.</p>
                <button type="button"
                        @click="$refs.deskripsi.value = document.getElementById('template-deskripsi-iklan').content.textContent.trim(); $refs.deskripsi.dispatchEvent(new Event('input', { bubbles: true })); $refs.deskripsi.focus()"
                        class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl border border-[#cbd8c8] bg-white px-4 py-2.5 text-sm font-semibold text-[#365b45] transition hover:border-[#93ad91] hover:bg-[#eff4ed] focus:outline-none focus:ring-2 focus:ring-[#78977a]">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M8 4h11a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1Z" stroke="currentColor" stroke-width="1.7"/><path d="M4 8v12a1 1 0 0 0 1 1h11M10 9h7M10 13h7M10 17h4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
                    Gunakan format iklan
                </button>
            </div>
            <template id="template-deskripsi-iklan">
[Judul Iklan]
Contoh: Kucing British Shorthair Jantan - Sehat, Lincah, Siap Adopsi

IDENTITAS HEWAN
Jenis / Ras: [Jenis dan ras. Jika mix breed, tuliskan ras induk jantan dan betina]
Jenis Kelamin: [Jantan / Betina]
Umur / Tanggal Lahir: [Contoh: 4 bulan / 15 Juli 2026]
Warna Bulu / Morfologi: [Warna alami asli, tidak diwarnai]

STATUS DOKUMEN & SERTIFIKASI
Sertifikat / Pedigree: [Ada, sebutkan jenisnya / Tidak ada]
Keterangan jika tanpa sertifikat: [Alasan dan keterangan keaslian indukan]

KESEHATAN & PERAWATAN
Status Kesehatan: [Kondisi terkini, nafsu makan, aktivitas, kutu atau jamur]
Riwayat Vaksin / Obat Cacing: [Sebutkan yang sudah diberikan]
Pakan Harian: [Jenis dan merek pakan]

LOKASI & SERAH TERIMA
Status Kepemilikan: [Pemilik langsung / Keterangan lain]
Lokasi: [Kecamatan, Kota / Kabupaten]
Metode Serah Terima: [COD / Pantau langsung / Antar langsung di area ...]

CATATAN TAMBAHAN
[Sifat hewan dan syarat khusus bagi calon adopter]
Kontak: [Jangan tulis nomor pribadi di deskripsi publik; gunakan jalur kontak resmi PetHaven]
            </template>
            <textarea id="deskripsi" name="deskripsi" rows="12" maxlength="2000" aria-describedby="deskripsi-help" x-ref="deskripsi" class="mt-4 block w-full rounded-xl border-[#e3e7df] bg-white text-sm leading-6 shadow-sm focus:border-[#78977a] focus:ring-[#78977a]" required>{{ old('deskripsi', $hewan->deskripsi) }}</textarea>
        </div>
        <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
        <p class="mt-1 text-xs text-[#879186]">Maksimal 2.000 karakter. Periksa kembali semua informasi sebelum menyimpan.</p>
    </div>
    <div class="flex flex-wrap items-center gap-x-6 gap-y-3 sm:col-span-2">
        <label class="inline-flex items-center gap-2 text-sm text-[#526055]">
            <input type="hidden" name="sudah_vaksin" value="0">
            <input type="checkbox" name="sudah_vaksin" value="1" class="rounded border-[#cbd5c8] text-[#365b45] focus:ring-[#78977a]" @checked(old('sudah_vaksin', $hewan->sudah_vaksin))> Sudah vaksin
        </label>
        <label class="inline-flex items-center gap-2 text-sm text-[#526055]">
            <input type="hidden" name="sudah_steril" value="0">
            <input type="checkbox" name="sudah_steril" value="1" class="rounded border-[#cbd5c8] text-[#365b45] focus:ring-[#78977a]" @checked(old('sudah_steril', $hewan->sudah_steril))> Sudah steril
        </label>
    </div>
    <div>
        <x-input-label for="status" value="Status" />
        <select id="status" name="status" class="mt-1 block w-full rounded-xl border-[#e3e7df] shadow-sm focus:border-[#78977a] focus:ring-[#78977a]">
            <option value="tersedia" @selected(old('status', $hewan->status) === 'tersedia')>Tersedia</option>
            <option value="teradopsi" @selected(old('status', $hewan->status) === 'teradopsi')>Teradopsi</option>
        </select>
        <x-input-error :messages="$errors->get('status')" class="mt-2" />
    </div>
    <div class="hidden sm:block"></div>
    <div>
        <x-input-label for="foto" value="Foto hewan (unggah, maks. 2 MB)" />
        <input id="foto" name="foto" type="file" accept="image/jpeg,image/png,image/webp" class="mt-1 block w-full text-sm text-[#68766b] file:me-3 file:rounded-lg file:border-0 file:bg-[#edf3e9] file:px-3 file:py-2 file:text-sm file:font-semibold file:text-[#365b45] hover:file:bg-[#e1ebdf]">
        <x-input-error :messages="$errors->get('foto')" class="mt-2" />
        @if ($hewan->foto_asli)
            <img src="{{ $hewan->foto_asli }}" alt="Foto {{ $hewan->nama }}" class="mt-3 h-28 w-36 rounded-xl object-cover">
        @endif
    </div>
    <div>
        <x-input-label for="foto_url" value="Atau URL foto (cocok untuk Vercel)" />
        <x-text-input id="foto_url" name="foto_url" type="url" class="mt-1 block w-full rounded-xl border-[#e3e7df] focus:border-[#78977a] focus:ring-[#78977a]" :value="old('foto_url', $hewan->foto_url)" placeholder="https://..." />
        <x-input-error :messages="$errors->get('foto_url')" class="mt-2" />
        <p class="mt-1 text-xs text-[#879186]">Unggah foto disimpan di penyimpanan lokal. Untuk deployment, gunakan URL gambar yang dapat diakses publik.</p>
    </div>
</div>
