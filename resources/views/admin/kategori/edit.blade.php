<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold text-gray-800">Ubah Kategori</h2></x-slot>

    <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <form method="POST" action="{{ route('admin.kategori.update', $kategori) }}" class="space-y-4 rounded-lg bg-white p-6 shadow">
            @csrf
            @method('PUT')
            <div>
                <x-input-label for="nama" value="Nama kategori" />
                <x-text-input id="nama" name="nama" type="text" class="mt-1 block w-full" :value="old('nama', $kategori->nama)" required />
                <x-input-error :messages="$errors->get('nama')" class="mt-2" />
            </div>
            <div class="flex items-center gap-3">
                <x-primary-button>Perbarui</x-primary-button>
                <a href="{{ route('admin.kategori.index') }}" class="text-sm text-gray-600 hover:underline">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>
