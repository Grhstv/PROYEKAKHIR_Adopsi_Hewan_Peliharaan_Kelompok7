<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-3">
            <h2 class="text-xl font-semibold text-gray-800">Chat dengan {{ $conversation->user->name }}</h2>
            <a href="{{ route('admin.chat.index') }}" class="text-sm text-indigo-600 hover:underline">Kembali ke inbox</a>
        </div>
    </x-slot>
    <div class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
        <section class="space-y-3 rounded-lg bg-white p-5 shadow">
            <div class="max-h-[28rem] space-y-3 overflow-y-auto">
                @foreach ($messages as $message)
                    <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                        <article class="max-w-[85%] rounded-lg px-4 py-3 {{ $message->sender_id === auth()->id() ? 'bg-indigo-100' : 'bg-gray-100' }}">
                            <p class="mb-1 text-xs font-semibold">{{ $message->sender->name }}</p>
                            <p class="whitespace-pre-line text-sm">{{ $message->body }}</p>
                            <time class="mt-2 block text-right text-[11px] text-gray-500">{{ $message->created_at->format('d/m/Y H:i') }}</time>
                        </article>
                    </div>
                @endforeach
            </div>
            <form method="POST" action="{{ route('admin.chat.store', $conversation) }}" class="border-t pt-4">
                @csrf
                <textarea name="body" rows="3" maxlength="2000" class="block w-full rounded-md border-gray-300" placeholder="Balas pesan..." required>{{ old('body') }}</textarea>
                <x-input-error :messages="$errors->get('body')" class="mt-1" />
                <div class="mt-3 text-right"><x-primary-button>Kirim balasan</x-primary-button></div>
            </form>
        </section>
    </div>
</x-app-layout>
