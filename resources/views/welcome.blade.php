<x-app-layout>
    <main class="pb-20">
        <section class="overflow-hidden bg-[#f7f6f1]">
            <div class="mx-auto grid max-w-7xl items-center gap-12 px-5 py-14 sm:px-8 sm:py-20 lg:grid-cols-[1.05fr_.95fr] lg:gap-16 lg:px-10 lg:py-24">
                <div class="relative z-10">
                    <p class="inline-flex items-center gap-2 rounded-full border border-[#dce5d8] bg-white/80 px-4 py-2 text-xs font-bold uppercase tracking-[.18em] text-[#52735c]">
                        <span class="h-2 w-2 rounded-full bg-[#82a889]"></span>
                        Teman baik, rumah baru
                    </p>
                    <h1 class="mt-7 max-w-2xl font-serif text-5xl font-semibold leading-[1.08] tracking-tight text-[#23372d] sm:text-6xl lg:text-7xl">
                        Ada hati kecil yang
                        <span class="italic text-[#d77d55]">menunggu</span>
                        untuk pulang.
                    </h1>
                    <p class="mt-6 max-w-xl text-base leading-7 text-[#68746a] sm:text-lg">
                        Temukan teman baru, kenali ceritanya, lalu beri mereka rumah yang penuh kasih. Semua dimulai dari satu pertemuan.
                    </p>

                    <form action="{{ route('hewan.index') }}" method="GET" class="mt-8 flex max-w-xl flex-col gap-3 rounded-2xl border border-[#e7e8df] bg-white p-2.5 shadow-[0_16px_50px_-28px_rgba(35,55,45,.28)] sm:flex-row">
                        <label for="cari-hewan" class="sr-only">Cari nama atau ras hewan</label>
                        <div class="flex min-w-0 flex-1 items-center gap-3 px-3">
                            <svg class="h-5 w-5 shrink-0 text-[#829083]" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="1.8"/>
                                <path d="m16 16 4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                            </svg>
                            <input id="cari-hewan" name="cari" type="search" placeholder="Cari teman baru..." class="h-12 w-full border-0 bg-transparent p-0 text-sm text-[#27382f] placeholder:text-[#a0a89f] focus:ring-0">
                        </div>
                        <button class="inline-flex h-12 items-center justify-center gap-2 rounded-xl bg-[#365b45] px-6 text-sm font-semibold text-white transition hover:bg-[#294936] focus:outline-none focus:ring-2 focus:ring-[#365b45] focus:ring-offset-2">
                            Jelajahi
                            <span aria-hidden="true">→</span>
                        </button>
                    </form>

                    <a href="{{ route('hewan.index') }}" class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-[#52735c] transition hover:text-[#d77d55]">
                        Lihat semua hewan <span aria-hidden="true">↗</span>
                    </a>
                </div>

                <div class="relative mx-auto w-full max-w-xl lg:max-w-none">
                    <div class="absolute -right-10 -top-8 h-40 w-40 rounded-full bg-[#e8d8ae]/60 blur-2xl"></div>
                    <div class="absolute -bottom-8 -left-8 h-48 w-48 rounded-full bg-[#b7cbb4]/60 blur-2xl"></div>
                    <div class="relative rotate-1 overflow-hidden rounded-[2rem] bg-[#dfe8dc] p-3 shadow-[0_28px_70px_-35px_rgba(35,55,45,.48)]">
                        <img src="https://images.unsplash.com/photo-1552053831-71594a27632d?auto=format&fit=crop&w=1200&q=85"
                             alt="Anjing golden retriever yang ramah"
                             class="h-[360px] w-full rounded-[1.5rem] object-cover sm:h-[460px]"
                             fetchpriority="high">
                        <div class="absolute bottom-7 left-7 right-7 rounded-2xl border border-white/60 bg-white/90 p-4 shadow-lg backdrop-blur sm:bottom-9 sm:left-9 sm:right-auto sm:min-w-64">
                            <p class="text-xs font-semibold uppercase tracking-[.14em] text-[#819080]">Teman seumur hidup</p>
                            <p class="mt-1 font-serif text-2xl font-semibold text-[#283c30]">Dimulai dari sini.</p>
                        </div>
                    </div>
                    <div class="absolute -right-3 top-8 grid h-16 w-16 place-items-center rounded-2xl bg-[#e59870] text-3xl shadow-lg sm:-right-5 sm:top-12" aria-hidden="true">🐾</div>
                </div>
            </div>
        </section>

        <section class="mx-auto -mt-2 max-w-7xl px-5 sm:px-8 lg:px-10" aria-label="Ringkasan adopsi">
            <div class="grid overflow-hidden rounded-2xl border border-[#e6e8df] bg-white shadow-sm sm:grid-cols-3">
                <div class="flex items-center gap-4 border-b border-[#eceee7] px-6 py-5 sm:border-b-0 sm:border-r sm:px-8">
                    <span class="grid h-12 w-12 place-items-center rounded-xl bg-[#edf3e9] text-xl" aria-hidden="true">🐕</span>
                    <div><p class="text-2xl font-bold text-[#2d4d39]">{{ number_format($totalTersedia) }}</p><p class="text-sm text-[#788176]">teman menanti</p></div>
                </div>
                <div class="flex items-center gap-4 border-b border-[#eceee7] px-6 py-5 sm:border-b-0 sm:border-r sm:px-8">
                    <span class="grid h-12 w-12 place-items-center rounded-xl bg-[#fbf0e9] text-xl" aria-hidden="true">🏡</span>
                    <div><p class="text-2xl font-bold text-[#2d4d39]">{{ number_format($totalTeradopsi) }}</p><p class="text-sm text-[#788176]">sudah punya rumah</p></div>
                </div>
                <div class="flex items-center gap-4 px-6 py-5 sm:px-8">
                    <span class="grid h-12 w-12 place-items-center rounded-xl bg-[#f7f1df] text-xl" aria-hidden="true">💛</span>
                    <div><p class="text-2xl font-bold text-[#2d4d39]">{{ $kategoris->count() }}</p><p class="text-sm text-[#788176]">kategori sahabat</p></div>
                </div>
            </div>
        </section>

        <section class="mx-auto max-w-7xl px-5 pt-20 sm:px-8 lg:px-10">
            <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[.18em] text-[#d77d55]">Pilih temanmu</p>
                    <h2 class="mt-2 font-serif text-3xl font-semibold text-[#263a2f] sm:text-4xl">Cari berdasarkan kategori</h2>
                </div>
                <a href="{{ route('hewan.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-[#52735c] hover:text-[#d77d55]">
                    Jelajahi semua <span aria-hidden="true">→</span>
                </a>
            </div>
            <div class="mt-7 flex gap-3 overflow-x-auto pb-2">
                @php
                    $ikonKategori = ['kucing' => '🐈', 'anjing' => '🐕', 'kelinci' => '🐇', 'burung' => '🦜', 'hamster' => '🐹'];
                @endphp
                @forelse ($kategoris as $kategori)
                    <a href="{{ route('hewan.index', ['kategori' => $kategori->id]) }}" class="group flex min-w-max items-center gap-3 rounded-2xl border border-[#e6e8df] bg-white px-5 py-4 transition hover:-translate-y-0.5 hover:border-[#b6c9b5] hover:shadow-md">
                        <span class="grid h-11 w-11 place-items-center rounded-xl bg-[#f1f4ec] text-2xl transition group-hover:bg-[#e7efe4]" aria-hidden="true">{{ $ikonKategori[$kategori->slug] ?? '🐾' }}</span>
                        <span><span class="block font-semibold text-[#314638]">{{ $kategori->nama }}</span><span class="mt-0.5 block text-xs text-[#8b9388]">{{ $kategori->hewans_count }} tersedia</span></span>
                        <span class="ml-1 text-[#a2aa9f] transition group-hover:translate-x-1 group-hover:text-[#52735c]" aria-hidden="true">→</span>
                    </a>
                @empty
                    <p class="rounded-xl bg-white px-5 py-4 text-sm text-[#788176]">Kategori hewan akan segera hadir.</p>
                @endforelse
            </div>
        </section>

        <section class="mx-auto max-w-7xl px-5 pt-20 sm:px-8 lg:px-10">
            <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[.18em] text-[#d77d55]">Kenalan lebih dekat</p>
                    <h2 class="mt-2 font-serif text-3xl font-semibold text-[#263a2f] sm:text-4xl">Mereka sedang menunggu</h2>
                    <p class="mt-2 text-sm text-[#788176]">Setiap profil punya cerita dan informasi perawatan yang bisa kamu kenali.</p>
                </div>
                <a href="{{ route('hewan.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-[#52735c] hover:text-[#d77d55]">
                    Lihat semua hewan <span aria-hidden="true">→</span>
                </a>
            </div>
            <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($terbaru as $hewan)
                    @include('hewan._card', ['hewan' => $hewan])
                @empty
                    <div class="col-span-full rounded-2xl border border-dashed border-[#d8dfd4] bg-white px-6 py-14 text-center">
                        <span class="text-4xl" aria-hidden="true">🐾</span>
                        <h3 class="mt-3 font-serif text-2xl font-semibold text-[#314638]">Belum ada teman yang terdaftar</h3>
                        <p class="mt-2 text-sm text-[#788176]">Coba kunjungi lagi nanti, mungkin ada cerita baru yang menunggu.</p>
                    </div>
                @endforelse
            </div>
        </section>

        <section class="mx-auto mt-20 max-w-7xl px-5 sm:px-8 lg:px-10">
            <div class="overflow-hidden rounded-[2rem] bg-[#2f4d3a] px-6 py-10 text-white sm:px-10 sm:py-12 lg:px-14">
                <div class="grid gap-10 lg:grid-cols-[.8fr_1.2fr] lg:items-center">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[.18em] text-[#c8d8bd]">Langkah kecil, arti besar</p>
                        <h2 class="mt-3 max-w-md font-serif text-3xl font-semibold leading-tight sm:text-4xl">Membuka rumah, mengubah hidup.</h2>
                        <p class="mt-4 max-w-md text-sm leading-6 text-[#d8e1d5]">Luangkan waktu untuk mengenal kebutuhan dan kepribadian mereka sebelum mengajukan adopsi.</p>
                        <a href="{{ route('hewan.index') }}" class="mt-6 inline-flex items-center gap-2 rounded-xl bg-[#f1c39f] px-5 py-3 text-sm font-bold text-[#334739] transition hover:bg-[#f7d3b6]">
                            Temukan sahabatmu <span aria-hidden="true">→</span>
                        </a>
                    </div>
                    <div class="grid gap-3 sm:grid-cols-3">
                        <div class="rounded-2xl border border-white/10 bg-white/[.07] p-5">
                            <span class="grid h-10 w-10 place-items-center rounded-xl bg-white/10 text-xl" aria-hidden="true">🔎</span>
                            <h3 class="mt-4 font-semibold">Kenali ceritanya</h3>
                            <p class="mt-2 text-sm leading-5 text-[#d1ddd0]">Baca profil, kesehatan, dan kebiasaan setiap hewan.</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/[.07] p-5">
                            <span class="grid h-10 w-10 place-items-center rounded-xl bg-white/10 text-xl" aria-hidden="true">📝</span>
                            <h3 class="mt-4 font-semibold">Ajukan adopsi</h3>
                            <p class="mt-2 text-sm leading-5 text-[#d1ddd0]">Ceritakan rumah dan kesiapanmu merawat mereka.</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/[.07] p-5">
                            <span class="grid h-10 w-10 place-items-center rounded-xl bg-white/10 text-xl" aria-hidden="true">🏠</span>
                            <h3 class="mt-4 font-semibold">Mulai perjalanan</h3>
                            <p class="mt-2 text-sm leading-5 text-[#d1ddd0]">Pantau status pengajuanmu dari akun PetHaven.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</x-app-layout>
