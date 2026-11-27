<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[.18em] text-[#d77d55]">Perjalanan adopsi</p>
                <h1 class="mt-1 font-serif text-3xl font-semibold tracking-tight text-[#263a2f] sm:text-4xl">Riwayat Adopsi</h1>
                <p class="mt-2 text-sm text-[#788176]">Lihat perkembangan pengajuan dan kabar dari admin.</p>
            </div>
            <a href="{{ route('hewan.index') }}" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-[#365b45] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#294936] focus:outline-none focus:ring-2 focus:ring-[#365b45] focus:ring-offset-2">
                Cari sahabat <span aria-hidden="true">→</span>
            </a>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl space-y-5 px-5 py-8 sm:px-8 sm:py-10 lg:px-10">
        @forelse ($adopsis as $adopsi)
            <article class="overflow-hidden rounded-2xl border border-[#e7e9e1] bg-white shadow-sm transition hover:shadow-md">
                <div class="grid sm:grid-cols-[12rem_minmax(0,1fr)]">
                    <a href="{{ route('hewan.show', $adopsi->hewan) }}" class="block h-48 overflow-hidden bg-[#edf1e9] sm:h-full sm:min-h-48">
                        <img src="{{ $adopsi->hewan->foto_src }}" alt="Foto {{ $adopsi->hewan->nama }}" class="h-full w-full object-cover transition duration-500 hover:scale-[1.03]" loading="lazy">
                    </a>

                    <div class="flex min-w-0 flex-col p-5 sm:p-6">
                        <div class="flex flex-wrap items-start justify-between gap-3">
                            <div class="min-w-0">
                                <p class="text-xs font-semibold uppercase tracking-[.12em] text-[#899389]">{{ $adopsi->hewan->kategori->nama }}<span class="mx-1.5 text-[#c2c8bd]">·</span>{{ $adopsi->hewan->ras ?? 'Campuran' }}</p>
                                <a href="{{ route('hewan.show', $adopsi->hewan) }}" class="mt-1 inline-block font-serif text-2xl font-semibold text-[#2c4033] transition hover:text-[#52735c]">{{ $adopsi->hewan->nama }}</a>
                                <p class="mt-1 text-sm text-[#788176]">Diajukan {{ $adopsi->created_at->format('d/m/Y, H:i') }}</p>
                            </div>
                            <x-badge :status="$adopsi->status" />
                        </div>

                        <div class="mt-5 border-t border-[#edf0e9] pt-4">
                            <p class="text-xs font-semibold uppercase tracking-wide text-[#899389]">Catatan dari admin</p>
                            <p class="mt-1 text-sm leading-6 text-[#526055]">{{ $adopsi->catatan_admin ?? 'Belum ada catatan dari admin.' }}</p>
                        </div>

                        @can('cancel', $adopsi)
                            <div class="mt-5 border-t border-[#edf0e9] pt-4">
                                <form method="POST" action="{{ route('adopsi.destroy', $adopsi) }}" onsubmit="return confirm('Batalkan pengajuan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center rounded-lg border border-[#efd8d0] px-4 py-2 text-sm font-semibold text-[#a9563b] transition hover:bg-[#fff5f1] focus:outline-none focus:ring-2 focus:ring-[#d77d55] focus:ring-offset-2">
                                        Batalkan pengajuan
                                    </button>
                                </form>
                            </div>
                        @endcan
                    </div>
                </div>
            </article>
        @empty
            <div class="rounded-2xl border border-dashed border-[#d8dfd4] bg-white px-6 py-14 text-center sm:py-16">
                <span class="mx-auto grid h-16 w-16 place-items-center rounded-full bg-[#edf3e9] text-[#52735c]">
                    <x-paw-mark class="h-8 w-8" />
                </span>
                <h2 class="mt-5 font-serif text-2xl font-semibold text-[#314638]">Belum ada riwayat adopsi</h2>
                <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-[#788176]">Pengajuan yang kamu kirim akan muncul di sini. Yuk, kenali hewan-hewan yang sedang mencari rumah.</p>
                <a href="{{ route('hewan.index') }}" class="mt-6 inline-flex rounded-xl bg-[#365b45] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#294936] focus:outline-none focus:ring-2 focus:ring-[#365b45] focus:ring-offset-2">
                    Jelajahi hewan
                </a>
            </div>
        @endforelse

        @if ($adopsis->hasPages())
            <div class="pt-2">{{ $adopsis->links() }}</div>
        @endif
    </div>
</x-app-layout>
