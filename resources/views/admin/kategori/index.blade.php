<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold text-gray-800">Kelola Kategori</h2></x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <form method="POST" action="{{ route('admin.kategori.store') }}" class="mb-6 flex items-start gap-2 rounded-lg bg-white p-4 shadow">
            @csrf
            <div class="flex-1">
                <x-text-input name="nama" type="text" class="block w-full" placeholder="Nama kategori baru, mis. Reptil" :value="old('nama')" required />
                <x-input-error :messages="$errors->get('nama')" class="mt-2" />
            </div>
            <x-primary-button>Tambah</x-primary-button>
        </form>

        <div class="overflow-x-auto rounded-lg bg-white shadow">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50 text-left text-gray-600">
                    <tr><th class="px-4 py-3">Nama</th><th class="px-4 py-3">Slug</th><th class="px-4 py-3">Jumlah hewan</th><th class="px-4 py-3"></th></tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($kategoris as $k)
                        <tr>
                            <td class="px-4 py-3 font-medium">{{ $k->nama }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $k->slug }}</td>
                            <td class="px-4 py-3">{{ $k->hewans_count }}</td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                <a href="{{ route('admin.kategori.edit', $k) }}" class="text-indigo-600 hover:underline">Ubah</a>
                                <form method="POST" action="{{ route('admin.kategori.destroy', $k) }}" class="inline" onsubmit="return confirm('Hapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="ms-3 text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
