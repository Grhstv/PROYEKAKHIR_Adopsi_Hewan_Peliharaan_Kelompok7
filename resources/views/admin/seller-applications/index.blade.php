<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold text-gray-800">Pengajuan Seller</h2></x-slot>
    <div class="mx-auto max-w-7xl space-y-4 px-4 py-8 sm:px-6 lg:px-8">
        @forelse ($applications as $application)
            <article class="rounded-lg bg-white p-5 shadow">
                <div class="flex flex-wrap justify-between gap-3">
                    <div>
                        <h3 class="text-lg font-semibold">{{ $application->store_name }} <span class="text-sm font-normal text-gray-500">· {{ ucfirst($application->status) }}</span></h3>
                        <p class="mt-1 text-sm text-gray-600">{{ $application->user->name }} · {{ $application->user->email }} · {{ $application->phone }}</p>
                        <p class="mt-3 whitespace-pre-line text-sm text-gray-700">{{ $application->store_description }}</p>
                        <p class="mt-2 text-sm text-gray-600">Alamat: {{ $application->address }}</p>
                        @if ($application->admin_note)<p class="mt-2 text-sm text-gray-500">Catatan: {{ $application->admin_note }}</p>@endif
                    </div>
                    <time class="text-xs text-gray-400">{{ $application->created_at->format('d/m/Y H:i') }}</time>
                </div>
                @if ($application->status === \App\Models\SellerApplication::MENUNGGU)
                    <div class="mt-4 grid gap-3 border-t pt-4 md:grid-cols-2">
                        <form method="POST" action="{{ route('admin.seller-applications.approve', $application) }}" class="flex flex-wrap items-end gap-2">
                            @csrf
                            <div class="min-w-52 flex-1">
                                <label for="approve-note-{{ $application->id }}" class="text-xs text-gray-500">Catatan (opsional)</label>
                                <input id="approve-note-{{ $application->id }}" name="admin_note" maxlength="500" class="mt-1 w-full rounded-md border-gray-300 text-sm">
                            </div>
                            <button class="rounded-md bg-emerald-600 px-4 py-2 text-sm font-semibold text-white">Setujui dan aktifkan toko</button>
                        </form>
                        <form method="POST" action="{{ route('admin.seller-applications.reject', $application) }}" class="flex flex-wrap items-end gap-2">
                            @csrf
                            <div class="min-w-52 flex-1">
                                <label for="reject-note-{{ $application->id }}" class="text-xs text-gray-500">Alasan penolakan</label>
                                <input id="reject-note-{{ $application->id }}" name="admin_note" minlength="5" maxlength="500" required class="mt-1 w-full rounded-md border-gray-300 text-sm">
                            </div>
                            <button class="rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white">Tolak</button>
                        </form>
                    </div>
                @endif
            </article>
        @empty
            <div class="rounded-lg bg-white p-8 text-center text-gray-500 shadow">Belum ada pengajuan seller.</div>
        @endforelse
        <div>{{ $applications->links() }}</div>
    </div>
</x-app-layout>
