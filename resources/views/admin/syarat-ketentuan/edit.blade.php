<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.16em] text-[#7b8b7b]">Pengaturan konten</p>
                <h1 class="mt-1 font-serif text-3xl font-semibold text-[#2d4937]">Edit Syarat &amp; Ketentuan</h1>
            </div>
            <a href="{{ route('syarat-ketentuan.show') }}" class="inline-flex items-center justify-center rounded-xl border border-[#dfe5dc] bg-white px-4 py-2.5 text-sm font-semibold text-[#365b45] transition hover:border-[#b8c9b6]">
                Lihat halaman pelanggan
            </a>
        </div>
    </x-slot>

    <section class="mx-auto max-w-4xl px-5 py-10 sm:px-8 lg:px-10">
        <div class="rounded-[1.75rem] border border-[#e5e8df] bg-white p-6 shadow-sm sm:p-9">
            <p class="mb-6 text-sm leading-6 text-[#68766b]">
                Perubahan yang disimpan akan langsung tampil pada halaman Syarat &amp; Ketentuan pelanggan. Teks ditampilkan sebagai teks biasa, bukan HTML.
            </p>

            <form method="POST" action="{{ route('admin.syarat-ketentuan.update') }}" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="content" class="mb-2 block text-sm font-semibold text-[#405447]">Isi syarat dan ketentuan</label>
                    <textarea id="content" name="content" rows="20" maxlength="20000" required class="block w-full rounded-2xl border-[#dfe5dc] bg-[#fcfcfa] text-sm leading-7 text-[#34483a] shadow-sm focus:border-[#52735c] focus:ring-[#52735c]">{{ old('content', $terms->content) }}</textarea>
                    <p class="mt-2 text-xs text-[#849084]">Maksimal 20.000 karakter.</p>
                    <x-input-error :messages="$errors->get('content')" class="mt-2" />
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="rounded-xl bg-[#365b45] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#294936] focus:outline-none focus:ring-2 focus:ring-[#365b45] focus:ring-offset-2">
                        Simpan perubahan
                    </button>
                </div>
            </form>
        </div>
    </section>
</x-app-layout>
