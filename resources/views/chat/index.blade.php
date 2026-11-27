<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold text-gray-800">Chat dengan Admin PetHaven</h2></x-slot>
    <div class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="mb-4 rounded-lg bg-blue-50 p-4 text-sm text-blue-800">Pesan dari admin dan balasan Anda tersimpan di percakapan ini. Admin juga dapat mengirim pengumuman ke semua pengguna.</div>
        <section class="space-y-3 rounded-lg bg-white p-5 shadow">
            <div class="max-h-[28rem] space-y-3 overflow-y-auto">
                @forelse ($messages as $message)
                    <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                        <article class="max-w-[85%] rounded-lg px-4 py-3 {{ $message->sender_id === auth()->id() ? 'bg-emerald-100 text-gray-800' : 'bg-gray-100 text-gray-800' }}">
                            <p class="mb-1 text-xs font-semibold">{{ $message->sender_id === auth()->id() ? 'Anda' : $message->sender->name.' · Admin' }}</p>
                            <p class="whitespace-pre-line text-sm">{{ $message->body }}</p>
                            <time class="mt-2 block text-right text-[11px] text-gray-500">{{ $message->created_at->format('d/m/Y H:i') }}</time>
                        </article>
                    </div>
                @empty
                    <p class="py-12 text-center text-sm text-gray-500">Belum ada pesan. Kirim pesan untuk memulai percakapan dengan admin.</p>
                @endforelse
            </div>
            <form method="POST" action="{{ route('chat.store') }}" class="border-t pt-4">
                @csrf
                <label for="body" class="sr-only">Tulis pesan</label>
                <textarea id="body" name="body" rows="3" maxlength="2000" class="block w-full rounded-md border-gray-300" placeholder="Tulis pesan ke admin..." required>{{ old('body') }}</textarea>
                <x-input-error :messages="$errors->get('body')" class="mt-1" />
                <div class="mt-3 text-right"><x-primary-button>Kirim pesan</x-primary-button></div>
            </form>
        </section>
    </div>
</x-app-layout>
