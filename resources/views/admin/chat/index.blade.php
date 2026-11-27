<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs font-bold uppercase tracking-[.18em] text-[#d77d55]">Layanan pelanggan</p>
            <h1 class="mt-1 font-serif text-3xl font-semibold tracking-tight text-[#263a2f] sm:text-4xl">Pesan Pelanggan</h1>
            <p class="mt-2 text-sm text-[#788176]">Buka percakapan untuk membaca dan membalas pesan pelanggan.</p>
        </div>
    </x-slot>

    <div class="mx-auto max-w-5xl space-y-3 px-5 py-8 sm:px-8 sm:py-10">
        @forelse ($conversations as $conversation)
            <a href="{{ route('admin.chat.show', $conversation) }}" class="group flex flex-col gap-4 rounded-2xl border border-[#e7e9e1] bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-[#c7d4c3] hover:shadow-md sm:flex-row sm:items-center sm:justify-between sm:p-6">
                <div class="flex min-w-0 items-center gap-4">
                    <span class="grid h-12 w-12 shrink-0 place-items-center rounded-full bg-[#edf3e9] font-semibold text-[#365b45]">{{ mb_strtoupper(mb_substr($conversation->user->name, 0, 1)) }}</span>
                    <div class="min-w-0">
                        <h2 class="truncate font-semibold text-[#2c4033] group-hover:text-[#52735c]">{{ $conversation->user->name }}</h2>
                        <p class="truncate text-sm text-[#788176]">{{ $conversation->user->email }}</p>
                        <p class="mt-1 text-xs text-[#899389]">{{ $conversation->messages_count }} pesan · diperbarui {{ $conversation->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
                <span class="inline-flex shrink-0 items-center gap-2 text-sm font-semibold text-[#52735c]">Buka chat <span aria-hidden="true">→</span></span>
            </a>
        @empty
            <div class="rounded-2xl border border-dashed border-[#d8dfd4] bg-white px-6 py-14 text-center">
                <span class="mx-auto grid h-14 w-14 place-items-center rounded-full bg-[#edf3e9] text-[#52735c]"><x-paw-mark class="h-7 w-7" /></span>
                <h2 class="mt-4 font-serif text-2xl font-semibold text-[#314638]">Belum ada pesan pelanggan</h2>
                <p class="mt-2 text-sm text-[#788176]">Percakapan baru akan muncul di halaman ini.</p>
            </div>
        @endforelse

        @if ($conversations->hasPages())
            <div class="pt-3">{{ $conversations->links() }}</div>
        @endif
    </div>
</x-app-layout>
