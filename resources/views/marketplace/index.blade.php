<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">Marketplace Perlengkapan Hewan</h2>
                <p class="mt-1 text-sm text-gray-500">Produk dari toko seller PetHaven.</p>
            </div>
            @auth
                @can('belanja produk')
                    <a href="{{ route('cart.index') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Lihat keranjang</a>
                @endcan
            @endauth
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <form method="GET" action="{{ route('marketplace.index') }}" class="mb-6 grid gap-3 rounded-lg bg-white p-4 shadow sm:grid-cols-[1fr_220px_auto]">
            <input name="q" value="{{ request('q') }}" placeholder="Cari produk..." class="rounded-md border-gray-300">
            <select name="category" class="rounded-md border-gray-300">
                <option value="">Semua kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category }}" @selected(request('category') === $category)>{{ $category }}</option>
                @endforeach
            </select>
            <button class="rounded-md bg-gray-800 px-5 py-2 text-sm font-semibold text-white">Cari</button>
        </form>

        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @forelse ($products as $product)
                <article class="overflow-hidden rounded-lg bg-white shadow">
                    <div class="grid h-36 place-items-center bg-emerald-50 text-4xl" aria-hidden="true">🐾</div>
                    <div class="p-4">
                        <p class="text-xs font-semibold uppercase tracking-wide text-emerald-700">{{ $product->category }}</p>
                        <a href="{{ route('marketplace.show', $product) }}" class="mt-1 block font-semibold text-gray-900 hover:underline">{{ $product->name }}</a>
                        <p class="mt-2 text-lg font-bold text-gray-900">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                        <p class="mt-1 text-sm text-gray-500"><a href="{{ route('shops.show', $product->shop) }}" class="hover:underline">{{ $product->shop->name }}</a> · Stok {{ $product->stock }}</p>
                        <a href="{{ route('marketplace.show', $product) }}" class="mt-4 inline-block text-sm font-semibold text-indigo-600 hover:underline">Detail produk</a>
                    </div>
                </article>
            @empty
                <p class="rounded-lg bg-white p-6 text-sm text-gray-500 sm:col-span-2 lg:col-span-4">Belum ada produk yang cocok dengan pencarian Anda.</p>
            @endforelse
        </div>
        <div class="mt-6">{{ $products->links() }}</div>
    </div>
</x-app-layout>
