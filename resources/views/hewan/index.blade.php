<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Daftar Hewan</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <form method="GET" action="{{ route('hewan.index') }}" class="mb-6 grid gap-3 rounded-lg bg-white p-4 shadow sm:grid-cols-5">
            <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari nama / ras"
                   class="rounded-md border-gray-300 text-sm sm:col-span-2">
            <select name="kategori" class="rounded-md border-gray-300 text-sm">
                <option value="">Semua jenis</option>
                @foreach ($kategoris as $k)
                    <option value="{{ $k->id }}" @selected((string) request('kategori') === (string) $k->id)>{{ $k->nama }}</option>
                @endforeach
            </select>
            <select name="jenis_kelamin" class="rounded-md border-gray-300 text-sm">
                <option value="">Semua kelamin</option>
                <option value="jantan" @selected(request('jenis_kelamin') === 'jantan')>Jantan</option>
                <option value="betina" @selected(request('jenis_kelamin') === 'betina')>Betina</option>
            </select>
            <div class="flex gap-2">
                <select name="status" class="w-full rounded-md border-gray-300 text-sm">
                    <option value="tersedia" @selected($status === 'tersedia')>Tersedia</option>
                    <option value="teradopsi" @selected($status === 'teradopsi')>Teradopsi</option>
                    <option value="semua" @selected($status === 'semua')>Semua</option>
                </select>
                <button class="rounded-md bg-indigo-600 px-4 text-sm font-semibold text-white hover:bg-indigo-500">Cari</button>
            </div>
        </form>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($hewans as $hewan)
                @include('hewan._card', ['hewan' => $hewan])
            @empty
                <p class="col-span-full rounded-lg bg-white p-8 text-center text-gray-500 shadow">Tidak ada hewan yang cocok dengan pencarian.</p>
            @endforelse
        </div>

        <div class="mt-6">{{ $hewans->links() }}</div>
    </div>
</x-app-layout>
