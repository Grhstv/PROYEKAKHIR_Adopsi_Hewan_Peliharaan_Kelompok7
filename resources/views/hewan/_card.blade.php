<a href="{{ route('hewan.show', $hewan) }}" class="group block overflow-hidden rounded-2xl border border-[#e7e9e1] bg-white transition duration-300 hover:-translate-y-1 hover:border-[#c7d4c3] hover:shadow-[0_20px_45px_-28px_rgba(35,55,45,.38)]">
    <div class="relative overflow-hidden bg-[#edf1e9]">
        @if ($hewan->foto_asli)
            <img src="{{ $hewan->foto_asli }}" alt="Foto {{ $hewan->nama }}" class="h-56 w-full object-cover transition duration-500 group-hover:scale-[1.03]" loading="lazy">
        @else
            @php
                $ikonHewan = ['kucing' => '🐈', 'anjing' => '🐕', 'kelinci' => '🐇', 'burung' => '🦜', 'hamster' => '🐹'];
            @endphp
            <div class="grid h-56 w-full place-items-center bg-gradient-to-br from-[#eef2e9] via-[#f5f2e7] to-[#f6e8dd]" aria-label="Foto {{ $hewan->nama }} belum tersedia">
                <span class="grid h-28 w-28 place-items-center rounded-full bg-white/70 text-6xl shadow-sm" aria-hidden="true">{{ $ikonHewan[$hewan->kategori->slug] ?? '🐾' }}</span>
            </div>
        @endif
        <span class="absolute left-4 top-4 inline-flex items-center gap-1.5 rounded-full border border-white/80 bg-white/95 px-3 py-1.5 text-xs font-semibold {{ $hewan->status === \App\Models\Hewan::TERSEDIA ? 'text-[#42654a]' : 'text-[#777f77]' }}">
            <span class="h-1.5 w-1.5 rounded-full {{ $hewan->status === \App\Models\Hewan::TERSEDIA ? 'bg-[#6d9a70]' : 'bg-[#a0a69e]' }}"></span>
            {{ $hewan->status === \App\Models\Hewan::TERSEDIA ? 'Siap diadopsi' : 'Sudah diadopsi' }}
        </span>
    </div>
    <div class="p-5">
        <div class="flex items-start justify-between gap-3">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[.12em] text-[#899389]">{{ $hewan->kategori->nama }}<span class="mx-1.5 text-[#c2c8bd]">·</span>{{ $hewan->ras ?? 'Campuran' }}</p>
                <h3 class="mt-1.5 font-serif text-2xl font-semibold text-[#2c4033] group-hover:text-[#52735c]">{{ $hewan->nama }}</h3>
            </div>
            <span class="rounded-lg bg-[#f3f5ef] px-2.5 py-1.5 text-xs font-medium text-[#6e7c70]">{{ $hewan->umur_label }}</span>
        </div>
        <div class="mt-4 flex flex-wrap items-center gap-x-4 gap-y-2 border-t border-[#edf0e9] pt-4 text-sm text-[#738075]">
            <span class="inline-flex items-center gap-1.5"><span aria-hidden="true">◉</span>{{ ucfirst($hewan->jenis_kelamin) }}</span>
            <span class="inline-flex items-center gap-1.5"><span aria-hidden="true">✚</span>{{ $hewan->sudah_vaksin ? 'Sudah vaksin' : 'Belum vaksin' }}</span>
        </div>
    </div>
</a>
