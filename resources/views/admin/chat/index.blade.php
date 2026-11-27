<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold text-gray-800">Chat & Pengumuman Pengguna</h2></x-slot>
    <div class="mx-auto grid max-w-7xl gap-6 px-4 py-8 sm:px-6 lg:px-8 lg:grid-cols-[1fr_360px]">
        <section>
            <h3 class="mb-3 font-semibold">Percakapan pengguna</h3>
            <div class="space-y-3">
                @forelse ($conversations as $conversation)
                    <a href="{{ route('admin.chat.show', $conversation) }}" class="block rounded-lg bg-white p-4 shadow hover:bg-gray-50">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="font-semibold">{{ $conversation->user->name }} <span class="font-normal text-gray-500">({{ $conversation->user->email }})</span></p>
                                <p class="mt-1 truncate text-sm text-gray-600">{{ $conversation->latestMessage?->body ?? 'Belum ada pesan' }}</p>
                                <p class="mt-1 text-xs text-gray-400">{{ $conversation->last_message_at?->format('d/m/Y H:i') }}</p>
                            </div>
                            @if ($conversation->unread_count)
                                <span class="rounded-full bg-red-100 px-2 py-1 text-xs font-bold text-red-700">{{ $conversation->unread_count }} baru</span>
                            @endif
                        </div>
                    </a>
                @empty
                    <div class="rounded-lg bg-white p-6 text-sm text-gray-500 shadow">Belum ada percakapan. Gunakan pengumuman untuk menghubungi semua pengguna.</div>
                @endforelse
            </div>
            <div class="mt-4">{{ $conversations->links() }}</div>
        </section>
        <aside class="h-fit rounded-lg bg-white p-5 shadow">
            <h3 class="font-semibold">Kirim ke semua pengguna</h3>
            <p class="mt-2 text-sm text-gray-500">Pesan akan masuk ke kotak chat semua adopter dan seller; admin/petugas tidak disertakan.</p>
            <form method="POST" action="{{ route('admin.chat.broadcast') }}" class="mt-4 space-y-3">
                @csrf
                <textarea name="body" rows="6" maxlength="2000" class="block w-full rounded-md border-gray-300" placeholder="Tulis pengumuman..." required>{{ old('body') }}</textarea>
                <x-input-error :messages="$errors->get('body')" />
                <x-primary-button>Kirim pengumuman</x-primary-button>
            </form>
        </aside>
    </div>
</x-app-layout>
