<x-app-layout>
    <main class="mx-auto max-w-7xl px-5 py-10 sm:px-8 sm:py-14 lg:px-10">
        <div class="max-w-3xl">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-[#718074] transition hover:text-[#365b45]">
                <span aria-hidden="true">←</span> Beranda
            </a>
            <p class="mt-7 text-xs font-bold uppercase tracking-[.18em] text-[#d77d55]">Teman baik menanti</p>
            <div class="mt-2 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h1 class="font-serif text-4xl font-semibold tracking-tight text-[#263a2f] sm:text-5xl">Temukan sahabatmu</h1>
                    <p class="mt-3 text-sm leading-6 text-[#788176] sm:text-base">Kenali cerita mereka dan cari teman yang cocok untuk rumahmu.</p>
                </div>
                <p class="shrink-0 text-sm text-[#788176]"><span class="font-bold text-[#365b45]">{{ $hewans->total() }}</span> profil ditemukan</p>
            </div>
        </div>

        <form method="GET" action="{{ route('hewan.index') }}" class="mt-8 rounded-2xl border border-[#e6e8df] bg-white p-4 shadow-sm sm:p-5">
            <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-[1.5fr_1fr_1fr_1fr_auto]">
                <div class="relative">
                    <label for="filter-cari" class="sr-only">Cari nama atau ras</label>
                    <svg class="pointer-events-none absolute left-3.5 top-1/2 h-5 w-5 -translate-y-1/2 text-[#929c91]" viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="1.8"/><path d="m16 16 4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                    <input id="filter-cari" type="search" name="cari" value="{{ request('cari') }}" placeholder="Cari nama atau ras..." class="h-12 w-full rounded-xl border-[#e3e7df] pl-11 text-sm text-[#33483a] placeholder:text-[#a0a89f] focus:border-[#78977a] focus:ring-[#78977a]">
                </div>
                <div>
                    <label for="filter-kategori" class="sr-only">Pilih kategori</label>
                    <select id="filter-kategori" name="kategori" class="h-12 w-full rounded-xl border-[#e3e7df] text-sm text-[#526055] focus:border-[#78977a] focus:ring-[#78977a]">
                        <option value="">Semua jenis</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" @selected((string) request('kategori') === (string) $kategori->id)>{{ $kategori->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="filter-kelamin" class="sr-only">Pilih jenis kelamin</label>
                    <select id="filter-kelamin" name="jenis_kelamin" class="h-12 w-full rounded-xl border-[#e3e7df] text-sm text-[#526055] focus:border-[#78977a] focus:ring-[#78977a]">
                        <option value="">Semua kelamin</option>
                        <option value="jantan" @selected(request('jenis_kelamin') === 'jantan')>Jantan</option>
                        <option value="betina" @selected(request('jenis_kelamin') === 'betina')>Betina</option>
                    </select>
                </div>
                <div>
                    <label for="filter-status" class="sr-only">Pilih status</label>
                    <select id="filter-status" name="status" class="h-12 w-full rounded-xl border-[#e3e7df] text-sm text-[#526055] focus:border-[#78977a] focus:ring-[#78977a]">
                        <option value="tersedia" @selected($status === 'tersedia')>Siap diadopsi</option>
                        <option value="teradopsi" @selected($status === 'teradopsi')>Sudah diadopsi</option>
                        <option value="semua" @selected($status === 'semua')>Semua status</option>
                    </select>
                </div>
                <button class="inline-flex h-12 items-center justify-center gap-2 rounded-xl bg-[#365b45] px-5 text-sm font-semibold text-white transition hover:bg-[#294936] focus:outline-none focus:ring-2 focus:ring-[#365b45] focus:ring-offset-2">
                    Terapkan <span aria-hidden="true">→</span>
                </button>
            </div>
            @if (request()->hasAny(['cari', 'kategori', 'jenis_kelamin']) || $status !== 'tersedia')
                <a href="{{ route('hewan.index') }}" class="mt-3 inline-flex text-xs font-semibold text-[#7b887c] underline decoration-[#cad3c8] underline-offset-4 hover:text-[#365b45]">Hapus semua filter</a>
            @endif
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
