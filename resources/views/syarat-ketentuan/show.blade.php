<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.16em] text-[#7b8b7b]">Informasi PetHaven</p>
            <h1 class="mt-1 font-serif text-3xl font-semibold text-[#2d4937]">Syarat &amp; Ketentuan</h1>
        </div>
    </x-slot>

    <section class="mx-auto max-w-4xl px-5 py-10 sm:px-8 lg:px-10">
        <div class="rounded-[1.75rem] border border-[#e5e8df] bg-white p-6 shadow-sm sm:p-10">
            <div class="mb-7 flex flex-col gap-3 border-b border-[#edf0e9] pb-6 sm:flex-row sm:items-end sm:justify-between">
                <p class="max-w-2xl text-sm leading-6 text-[#68766b]">
                    Ketentuan ini menjelaskan penggunaan PetHaven dan panduan berinteraksi saat mencari atau menawarkan hewan.
                </p>
                @if ($updatedAt)
                    <p class="shrink-0 text-xs text-[#8a958b]">Diperbarui {{ $updatedAt->format('d-m-Y') }}</p>
                @endif
            </div>

            <article class="whitespace-pre-line text-sm leading-7 text-[#46564a]">{{ $content }}</article>
        </div>
    </section>
</x-app-layout>
