<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold text-gray-800">Tambah Hewan</h2></x-slot>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <form method="POST" action="{{ route('admin.hewan.store') }}" enctype="multipart/form-data" class="rounded-lg bg-white p-6 shadow">
            @include('admin.hewan._form')
            <div class="mt-6 flex items-center gap-3">
                <x-primary-button>Simpan</x-primary-button>
                <a href="{{ route('admin.hewan.index') }}" class="text-sm text-gray-600 hover:underline">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>
