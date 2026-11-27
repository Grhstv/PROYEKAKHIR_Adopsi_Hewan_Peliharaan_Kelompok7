<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">{{ $shop->name }}</h2>
    </x-slot>
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <section class="mb-6 rounded-lg bg-white p-6 shadow">
            <h3 class="text-lg font-semibold">{{ $shop->name }}</h3>
            <p class="mt-2 whitespace-pre-line text-sm text-gray-700">{{ $shop->description }}</p>
            <p class="mt-3 text-sm text-gray-500">Seller PetHaven · Produk perlengkapan hewan</p>
        </section>
        <h3 class="mb-4 font-semibold text-gray-800">Produk toko</h3>
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @forelse ($products as $product)
                <article class="rounded-lg bg-white p-4 shadow">
                    <p class="text-xs font-semibold uppercase tracking-wide text-emerald-700">{{ $product->category }}</p>
                    <a href="{{ route('marketplace.show', $product) }}" class="mt-1 block font-semibold text-gray-900 hover:underline">{{ $product->name }}</a>
                    <p class="mt-2 font-bold">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                    <p class="mt-1 text-sm text-gray-500">Stok {{ $product->stock }}</p>
                </article>
            @empty
                <p class="rounded-lg bg-white p-6 text-sm text-gray-500 sm:col-span-2 lg:col-span-4">Toko ini belum memiliki produk aktif.</p>
            @endforelse
        </div>
        <div class="mt-6">{{ $products->links() }}</div>
    </div>
</x-app-layout>
