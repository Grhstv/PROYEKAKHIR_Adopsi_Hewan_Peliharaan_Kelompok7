<x-app-layout>
    <main class="mx-auto max-w-7xl px-5 py-8 sm:px-8 sm:py-10 lg:px-10">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-[#718074] transition hover:text-[#365b45]">
            <span aria-hidden="true">←</span> Beranda
        </a>

        <section aria-labelledby="catalog-title" class="relative mt-6 overflow-hidden rounded-[2rem] bg-[#2f4d3a] px-6 py-8 text-white shadow-[0_24px_60px_-32px_rgba(35,55,45,.55)] sm:px-9 sm:py-10">
            <div class="pointer-events-none absolute -right-16 -top-24 h-64 w-64 rounded-full bg-[#8eaa8b]/20 blur-3xl"></div>
            <div class="pointer-events-none absolute -bottom-28 left-1/3 h-56 w-56 rounded-full bg-[#e59870]/15 blur-3xl"></div>
            <div class="relative flex flex-col gap-7 sm:flex-row sm:items-end sm:justify-between">
                <div class="max-w-2xl">
                    <p class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-3.5 py-1.5 text-xs font-bold uppercase tracking-[.16em] text-[#e2eadf]">
                        <span class="h-1.5 w-1.5 rounded-full bg-[#f1c39f]"></span>
                        Teman baik menanti
                    </p>
                    <h1 id="catalog-title" class="mt-4 font-serif text-4xl font-semibold leading-tight tracking-tight sm:text-5xl">Temukan sahabatmu</h1>
                    <p class="mt-3 max-w-xl text-sm leading-6 text-white/75 sm:text-base">Kenali cerita mereka dan temukan teman yang cocok untuk rumahmu.</p>
                </div>
                <div class="flex w-fit items-center gap-3 rounded-2xl border border-white/15 bg-white/10 px-5 py-4 backdrop-blur-sm">
                    <span class="grid h-11 w-11 place-items-center rounded-xl bg-white/10 text-[#f1c39f]"><x-paw-mark class="h-6 w-6" /></span>
                    <div>
                        <p class="font-serif text-3xl font-semibold leading-none">{{ number_format($hewans->total()) }}</p>
                        <p class="mt-1.5 text-xs text-white/75">profil ditemukan</p>
                    </div>
                </div>
            </div>
        </section>

        <form method="GET" action="{{ route('hewan.index') }}" class="mt-6 rounded-3xl border border-[#e6e8df] bg-white p-5 shadow-sm sm:p-6">
            <div class="mb-5 flex flex-wrap items-end justify-between gap-3">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[.15em] text-[#d77d55]">Pencarian</p>
                    <h2 class="mt-1 font-serif text-2xl font-semibold text-[#314638]">Cari yang paling cocok</h2>
                </div>
                @if (request()->hasAny(['cari', 'kategori', 'jenis_kelamin']) || $status !== 'tersedia')
                    <a href="{{ route('hewan.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-[#718074] underline decoration-[#cad3c8] underline-offset-4 transition hover:text-[#365b45]">
                        Hapus filter <span aria-hidden="true">×</span>
                    </a>
                @endif
            </div>

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-[minmax(0,1.7fr)_minmax(0,1fr)_minmax(0,1fr)_minmax(0,1fr)_auto]">
                <div class="sm:col-span-2 lg:col-span-1">
                    <label for="filter-cari" class="mb-2 block text-xs font-semibold text-[#667468]">Nama atau ras</label>
                    <div class="relative">
                        <svg class="pointer-events-none absolute left-3.5 top-1/2 h-5 w-5 -translate-y-1/2 text-[#929c91]" viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="1.8"/><path d="m16 16 4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                        <input id="filter-cari" type="search" name="cari" value="{{ request('cari') }}" placeholder="Contoh: kucing oren" class="h-12 w-full rounded-xl border-[#e3e7df] pl-11 text-sm text-[#33483a] placeholder:text-[#a0a89f] focus:border-[#78977a] focus:ring-[#78977a]">
                    </div>
                </div>
                <div>
                    <label for="filter-kategori" class="mb-2 block text-xs font-semibold text-[#667468]">Jenis hewan</label>
                    <select id="filter-kategori" name="kategori" class="h-12 w-full rounded-xl border-[#e3e7df] text-sm text-[#526055] focus:border-[#78977a] focus:ring-[#78977a]">
                        <option value="">Semua jenis</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" @selected((string) request('kategori') === (string) $kategori->id)>{{ $kategori->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="filter-kelamin" class="mb-2 block text-xs font-semibold text-[#667468]">Jenis kelamin</label>
                    <select id="filter-kelamin" name="jenis_kelamin" class="h-12 w-full rounded-xl border-[#e3e7df] text-sm text-[#526055] focus:border-[#78977a] focus:ring-[#78977a]">
                        <option value="">Semua kelamin</option>
                        <option value="jantan" @selected(request('jenis_kelamin') === 'jantan')>Jantan</option>
                        <option value="betina" @selected(request('jenis_kelamin') === 'betina')>Betina</option>
                    </select>
                </div>
                <div>
                    <label for="filter-status" class="mb-2 block text-xs font-semibold text-[#667468]">Status adopsi</label>
                    <select id="filter-status" name="status" class="h-12 w-full rounded-xl border-[#e3e7df] text-sm text-[#526055] focus:border-[#78977a] focus:ring-[#78977a]">
                        <option value="tersedia" @selected($status === 'tersedia')>Siap diadopsi</option>
                        <option value="teradopsi" @selected($status === 'teradopsi')>Sudah diadopsi</option>
                        <option value="semua" @selected($status === 'semua')>Semua status</option>
                    </select>
                </div>
                <div class="flex items-end sm:col-span-2 lg:col-span-1">
                    <button class="inline-flex h-12 w-full items-center justify-center gap-2 rounded-xl bg-[#365b45] px-5 text-sm font-semibold text-white transition hover:bg-[#294936] focus:outline-none focus:ring-2 focus:ring-[#365b45] focus:ring-offset-2">
                        Terapkan <span aria-hidden="true">→</span>
                    </button>
                </div>
            </div>
        </form>

        <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($hewans as $hewan)
                @include('hewan._card', ['hewan' => $hewan])
            @empty
                <div class="col-span-full rounded-2xl border border-dashed border-[#d8dfd4] bg-white px-6 py-16 text-center">
                    <svg class="mx-auto h-10 w-10 text-[#8ba18a]" viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.8" stroke="currentColor" stroke-width="1.7"/><path d="m16 16 4.2 4.2" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
                    <h2 class="mt-4 font-serif text-2xl font-semibold text-[#314638]">Belum ada yang cocok</h2>
                    <p class="mt-2 text-sm text-[#788176]">Coba ubah kata pencarian atau pilih filter yang lain.</p>
                    <a href="{{ route('hewan.index') }}" class="mt-5 inline-flex rounded-xl bg-[#365b45] px-5 py-3 text-sm font-semibold text-white hover:bg-[#294936]">Tampilkan semua hewan</a>
                </div>
            @endforelse
        </div>

        @if ($hewans->hasPages())
            <div class="mt-8">{{ $hewans->links() }}</div>
        @endif
    </main>
</x-app-layout>
