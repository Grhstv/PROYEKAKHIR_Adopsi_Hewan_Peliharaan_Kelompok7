<x-app-layout>
    <main class="mx-auto max-w-7xl px-5 py-8 sm:px-8 sm:py-12 lg:px-10">
        <a href="{{ route('hewan.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-[#718074] transition hover:text-[#365b45]">
            <span aria-hidden="true">←</span> Kembali ke katalog
        </a>

        <div class="mt-6 overflow-hidden rounded-[1.75rem] border border-[#e6e8df] bg-white shadow-sm lg:grid lg:grid-cols-[1.05fr_.95fr]">
            <div class="relative min-h-[300px] overflow-hidden bg-gradient-to-br from-[#eef2e9] via-[#f5f2e7] to-[#f6e8dd] sm:min-h-[420px]">
                @if ($hewan->foto_asli)
                    <img src="{{ $hewan->foto_asli }}" alt="Foto {{ $hewan->nama }}" class="absolute inset-0 h-full w-full object-cover">
                @else
                    @php
                        $ikonHewan = ['kucing' => '🐈', 'anjing' => '🐕', 'kelinci' => '🐇', 'burung' => '🦜', 'hamster' => '🐹'];
                    @endphp
                    <div class="absolute inset-0 grid place-items-center">
                        <span class="grid h-36 w-36 place-items-center rounded-full bg-white/70 text-7xl shadow-sm" aria-hidden="true">{{ $ikonHewan[$hewan->kategori->slug] ?? '🐾' }}</span>
                    </div>
                @endif
                <span class="absolute left-5 top-5 inline-flex items-center gap-2 rounded-full bg-white/95 px-4 py-2 text-sm font-semibold {{ $hewan->status === \App\Models\Hewan::TERSEDIA ? 'text-[#42654a]' : 'text-[#777f77]' }}">
                    <span class="h-2 w-2 rounded-full {{ $hewan->status === \App\Models\Hewan::TERSEDIA ? 'bg-[#6d9a70]' : 'bg-[#a0a69e]' }}"></span>
                    {{ $hewan->status === \App\Models\Hewan::TERSEDIA ? 'Siap diadopsi' : 'Sudah diadopsi' }}
                </span>
            </div>

            <div class="p-6 sm:p-9 lg:p-10">
                <p class="text-xs font-bold uppercase tracking-[.16em] text-[#d77d55]">{{ $hewan->kategori->nama }}<span class="mx-1.5 text-[#c2c8bd]">·</span>{{ $hewan->ras ?? 'Campuran' }}</p>
                <h1 class="mt-2 font-serif text-4xl font-semibold tracking-tight text-[#263a2f] sm:text-5xl">{{ $hewan->nama }}</h1>
                <p class="mt-3 text-sm leading-6 text-[#788176]">Kenali kepribadian dan kebutuhannya, lalu cari tahu apakah kalian cocok satu sama lain.</p>

                <dl class="mt-7 grid grid-cols-2 gap-3">
                    <div class="rounded-xl bg-[#f7f8f4] p-4"><dt class="text-xs font-medium text-[#899389]">Umur</dt><dd class="mt-1 text-sm font-semibold text-[#3d5143]">{{ $hewan->umur_label }}</dd></div>
                    <div class="rounded-xl bg-[#f7f8f4] p-4"><dt class="text-xs font-medium text-[#899389]">Jenis kelamin</dt><dd class="mt-1 text-sm font-semibold text-[#3d5143]">{{ ucfirst($hewan->jenis_kelamin) }}</dd></div>
                    <div class="rounded-xl bg-[#f7f8f4] p-4"><dt class="text-xs font-medium text-[#899389]">Warna</dt><dd class="mt-1 text-sm font-semibold text-[#3d5143]">{{ $hewan->warna ?? 'Belum diketahui' }}</dd></div>
                    <div class="rounded-xl bg-[#f7f8f4] p-4"><dt class="text-xs font-medium text-[#899389]">Vaksinasi</dt><dd class="mt-1 text-sm font-semibold text-[#3d5143]">{{ $hewan->sudah_vaksin ? 'Sudah vaksin' : 'Belum vaksin' }}</dd></div>
                    <div class="col-span-2 rounded-xl bg-[#f7f8f4] p-4"><dt class="text-xs font-medium text-[#899389]">Kesehatan</dt><dd class="mt-1 text-sm font-semibold text-[#3d5143]">{{ $hewan->kesehatan ?? 'Informasi belum tersedia' }}</dd></div>
                    <div class="col-span-2 flex items-center justify-between rounded-xl border border-[#e9ede5] px-4 py-3">
                        <span class="text-sm text-[#68766b]">Sterilisasi</span>
                        <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $hewan->sudah_steril ? 'bg-[#edf4eb] text-[#4c7552]' : 'bg-[#f5f1e7] text-[#8b7854]' }}">{{ $hewan->sudah_steril ? 'Sudah steril' : 'Belum steril' }}</span>
                    </div>
                </dl>

                <div class="mt-6 border-t border-[#edf0e9] pt-6">
                    <h2 class="text-sm font-bold text-[#3a4d3e]">Tentang {{ $hewan->nama }}</h2>
                    <p class="mt-2 whitespace-pre-line text-sm leading-7 text-[#68766b]">{{ $hewan->deskripsi }}</p>
                </div>

                <div class="mt-6">
                    @if ($hewan->status !== \App\Models\Hewan::TERSEDIA)
                        <p class="rounded-xl bg-[#f3f5ef] p-4 text-sm leading-6 text-[#68766b]">Kabar baik, {{ $hewan->nama }} sudah menemukan rumah baru. Terima kasih sudah ikut peduli! 💛</p>
                    @elseif (! auth()->check())
                        <a href="{{ route('login') }}" class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#365b45] px-5 py-3.5 text-sm font-semibold text-white transition hover:bg-[#294936] focus:outline-none focus:ring-2 focus:ring-[#365b45] focus:ring-offset-2 sm:w-auto">
                            Masuk untuk mengajukan adopsi <span aria-hidden="true">→</span>
                        </a>
                    @else
                        @can('mengajukan adopsi')
                            @if ($sudahMengajukan)
                                <p class="rounded-xl border border-[#f1dfb6] bg-[#fcf8ed] p-4 text-sm leading-6 text-[#806b3e]">Pengajuanmu untuk {{ $hewan->nama }} sedang menunggu keputusan.</p>
                            @else
                                <a href="{{ route('adopsi.create', $hewan) }}" class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#365b45] px-5 py-3.5 text-sm font-semibold text-white transition hover:bg-[#294936] focus:outline-none focus:ring-2 focus:ring-[#365b45] focus:ring-offset-2 sm:w-auto">
                                    Ajukan adopsi <span aria-hidden="true">→</span>
                                </a>
                            @endif
                        @endcan
                    @endif
                    <p class="mt-3 text-xs leading-5 text-[#8b9388]">Pastikan kamu siap memenuhi kebutuhan perawatan dan komitmen jangka panjangnya.</p>
                </div>
            </div>
        </div>

        @if ($serupa->isNotEmpty())
            <section class="mt-16">
                <div class="flex items-end justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[.16em] text-[#d77d55]">Mungkin cocok juga</p>
                        <h2 class="mt-2 font-serif text-3xl font-semibold text-[#263a2f]">Teman lain untuk dikenali</h2>
                    </div>
                    <a href="{{ route('hewan.index', ['kategori' => $hewan->kategori_id]) }}" class="hidden text-sm font-semibold text-[#52735c] hover:text-[#d77d55] sm:inline">Lihat kategori →</a>
                </div>
                <div class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($serupa as $hewanSerupa)
                        @include('hewan._card', ['hewan' => $hewanSerupa])
                    @endforeach
                </div>
            </section>
        @endif
    </main>
</x-app-layout>
