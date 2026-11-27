<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold text-gray-800">Ubah Produk</h2></x-slot>
    <div class="mx-auto max-w-3xl px-4 py-8 sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('seller.products.update', $product) }}" class="space-y-5 rounded-lg bg-white p-6 shadow">
            @method('PUT')
            @include('seller.products._form')
            <div class="flex gap-3"><x-primary-button>Simpan perubahan</x-primary-button><a href="{{ route('seller.products.index') }}" class="py-2 text-sm text-gray-600">Batal</a></div>
        </form>
    </div>
</x-app-layout>
