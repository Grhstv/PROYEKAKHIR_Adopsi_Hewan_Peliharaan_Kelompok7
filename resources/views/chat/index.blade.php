<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs font-bold uppercase tracking-[.18em] text-[#d77d55]">Bantuan PetHaven</p>
            <h1 class="mt-1 font-serif text-3xl font-semibold tracking-tight text-[#263a2f] sm:text-4xl">Chat Admin</h1>
            <p class="mt-2 text-sm text-[#788176]">Kirim pertanyaan dan admin akan membalas melalui percakapan ini.</p>
        </div>
    </x-slot>

    <div class="mx-auto max-w-4xl px-5 py-8 sm:px-8 sm:py-10">
        <section class="overflow-hidden rounded-2xl border border-[#e7e9e1] bg-white shadow-sm">
            <div class="flex items-center gap-4 border-b border-[#edf0e9] bg-[#fbfaf7] px-5 py-4 sm:px-6">
                <span class="grid h-11 w-11 place-items-center rounded-full bg-[#365b45] text-white"><x-paw-mark class="h-6 w-6" /></span>
                <div>
                    <h2 class="font-semibold text-[#2c4033]">Admin PetHaven</h2>
                    <p class="text-xs text-[#788176]">Pesan tersimpan di akun Anda</p>
                </div>
            </div>

            <div class="max-h-[55vh] min-h-56 space-y-4 overflow-y-auto bg-[#fcfcfa] px-4 py-5 sm:px-6" aria-live="polite">
                @if ($messages?->isNotEmpty())
                    @include('chat._messages', ['messages' => $messages, 'otherSenderName' => 'Admin'])
                @else
                    <div class="grid min-h-48 place-items-center text-center">
                        <div>
                            <span class="mx-auto grid h-14 w-14 place-items-center rounded-full bg-[#edf3e9] text-[#52735c]">
                                <x-paw-mark class="h-7 w-7" />
                            </span>
                            <p class="mt-4 font-semibold text-[#314638]">Mulai percakapan</p>
                            <p class="mt-1 text-sm text-[#788176]">Tulis pertanyaan Anda di bawah. Admin akan membalas di sini.</p>
                        </div>
                    </div>
                @endif
            </div>

            @if ($messages?->hasPages())
                <div class="border-t border-[#edf0e9] px-5 py-3 sm:px-6">{{ $messages->links() }}</div>
            @endif

            <form method="POST" action="{{ route('chat.store') }}" class="border-t border-[#edf0e9] p-4 sm:p-5">
                @csrf
                <label for="message" class="sr-only">Tulis pesan untuk admin</label>
                <textarea id="message" name="message" rows="3" maxlength="2000" required placeholder="Tulis pesan untuk admin..." class="w-full resize-y rounded-xl border-[#e3e7df] text-sm text-[#33483a] placeholder:text-[#a0a89f] focus:border-[#78977a] focus:ring-[#78977a]">{{ old('message') }}</textarea>
                @error('message')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <div class="mt-3 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-xs text-[#899389]">Maksimal 2.000 karakter per pesan.</p>
                    <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#365b45] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#294936] focus:outline-none focus:ring-2 focus:ring-[#365b45] focus:ring-offset-2">
                        Kirim pesan <span aria-hidden="true">→</span>
                    </button>
                </div>
            </form>
        </section>

        <p class="mt-5 text-center text-sm text-[#788176]">
            Perlu bantuan lebih cepat?
            <a href="https://wa.me/{{ config('contact.admin_whatsapp') }}" target="_blank" rel="noopener noreferrer" class="font-semibold text-[#365b45] underline decoration-[#b8c9b6] underline-offset-4 hover:text-[#294936]">Hubungi WhatsApp Admin</a>
        </p>
    </div>
</x-app-layout>
