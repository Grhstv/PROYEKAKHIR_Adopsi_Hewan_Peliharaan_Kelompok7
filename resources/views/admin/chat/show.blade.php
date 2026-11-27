<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <a href="{{ route('admin.chat.index') }}" class="text-sm font-semibold text-[#718074] transition hover:text-[#365b45]">← Kembali ke pesan</a>
                <h1 class="mt-2 font-serif text-3xl font-semibold tracking-tight text-[#263a2f]">{{ $conversation->user->name }}</h1>
                <p class="mt-1 text-sm text-[#788176]">{{ $conversation->user->email }}</p>
            </div>
            <span class="rounded-full bg-[#edf3e9] px-4 py-2 text-xs font-semibold text-[#52735c]">Percakapan pelanggan</span>
        </div>
    </x-slot>

    <div class="mx-auto max-w-4xl px-5 py-8 sm:px-8 sm:py-10">
        <section class="overflow-hidden rounded-2xl border border-[#e7e9e1] bg-white shadow-sm">
            <div class="max-h-[60vh] min-h-56 space-y-4 overflow-y-auto bg-[#fcfcfa] px-4 py-5 sm:px-6" aria-live="polite">
                @include('chat._messages', ['messages' => $messages, 'otherSenderName' => $conversation->user->name])
            </div>

            @if ($messages->hasPages())
                <div class="border-t border-[#edf0e9] px-5 py-3 sm:px-6">{{ $messages->links() }}</div>
            @endif

            <form method="POST" action="{{ route('admin.chat.store', $conversation) }}" class="border-t border-[#edf0e9] p-4 sm:p-5">
                @csrf
                <label for="message" class="sr-only">Tulis balasan untuk pelanggan</label>
                <textarea id="message" name="message" rows="3" maxlength="2000" required placeholder="Tulis balasan untuk {{ $conversation->user->name }}..." class="w-full resize-y rounded-xl border-[#e3e7df] text-sm text-[#33483a] placeholder:text-[#a0a89f] focus:border-[#78977a] focus:ring-[#78977a]">{{ old('message') }}</textarea>
                @error('message')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <div class="mt-3 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-xs text-[#899389]">Maksimal 2.000 karakter per pesan.</p>
                    <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#365b45] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#294936] focus:outline-none focus:ring-2 focus:ring-[#365b45] focus:ring-offset-2">
                        Kirim balasan <span aria-hidden="true">→</span>
                    </button>
                </div>
            </form>
        </section>
    </div>
</x-app-layout>
