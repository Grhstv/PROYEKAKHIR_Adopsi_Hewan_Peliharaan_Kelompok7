<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">Kelola Hewan</h2>
            <a href="{{ route($routePrefix.'.hewan.create') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">+ Tambah Hewan</a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <form method="GET" class="mb-4 flex flex-wrap gap-2">
            <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari nama / ras" class="rounded-md border-gray-300 text-sm">
            <select name="kategori" class="rounded-md border-gray-300 text-sm">
                <option value="">Semua jenis</option>
                @foreach ($kategoris as $k)
                    <option value="{{ $k->id }}" @selected((string) request('kategori') === (string) $k->id)>{{ $k->nama }}</option>
                @endforeach
            </select>
            <button class="rounded-md bg-gray-800 px-4 text-sm font-semibold text-white">Filter</button>
        </form>

        <div class="overflow-x-auto rounded-lg bg-white shadow">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50 text-left text-gray-600">
                    <tr><th class="px-4 py-3">Foto</th><th class="px-4 py-3">Nama</th><th class="px-4 py-3">Jenis</th><th class="px-4 py-3">Kelamin</th><th class="px-4 py-3">Umur</th><th class="px-4 py-3">Status</th><th class="px-4 py-3"></th></tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($hewans as $h)
                        <tr>
                            <td class="px-4 py-3"><img src="{{ $h->foto_src }}" alt="" class="h-12 w-12 rounded object-cover"></td>
                            <td class="px-4 py-3 font-medium">{{ $h->nama }}<div class="text-xs text-gray-500">{{ $h->ras ?? '-' }}</div></td>
                            <td class="px-4 py-3">{{ $h->kategori->nama }}</td>
                            <td class="px-4 py-3">{{ ucfirst($h->jenis_kelamin) }}</td>
                            <td class="px-4 py-3">{{ $h->umur_label }}</td>
                            <td class="px-4 py-3"><x-badge :status="$h->status" /></td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                <a href="{{ route($routePrefix.'.hewan.edit', $h) }}" class="text-indigo-600 hover:underline">Ubah</a>
                                <form method="POST" action="{{ route($routePrefix.'.hewan.destroy', $h) }}" class="inline" onsubmit="return confirm('Hapus {{ e($h->nama) }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="ms-3 text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-4 py-8 text-center text-gray-500">Belum ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $hewans->links() }}</div>
    </div>
</x-app-layout>
