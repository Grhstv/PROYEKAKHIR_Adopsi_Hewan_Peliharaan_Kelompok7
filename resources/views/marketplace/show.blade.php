<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">{{ $product->name }}</h2>
    </x-slot>

    <div class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="grid gap-6 rounded-lg bg-white p-6 shadow md:grid-cols-2">
            <div class="grid min-h-64 place-items-center rounded-lg bg-emerald-50 text-7xl" aria-hidden="true">🐾</div>
            <div>
                <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">{{ $product->category }}</p>
                <h3 class="mt-2 text-2xl font-bold text-gray-900">{{ $product->name }}</h3>
                <p class="mt-3 text-2xl font-bold text-indigo-700">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                <p class="mt-2 text-sm text-gray-500">Toko: <a href="{{ route('shops.show', $product->shop) }}" class="text-indigo-600 hover:underline">{{ $product->shop->name }}</a> · Tersedia {{ $product->stock }} unit</p>
                <p class="mt-5 whitespace-pre-line text-gray-700">{{ $product->description }}</p>

                @auth
                    @can('belanja produk')
                        <form method="POST" action="{{ route('cart.store', $product) }}" class="mt-6 flex items-end gap-3">
                            @csrf
                            <div>
                                <x-input-label for="quantity" value="Jumlah" />
                                <input id="quantity" name="quantity" type="number" min="1" max="{{ min(100, $product->stock) }}" value="1" class="mt-1 w-24 rounded-md border-gray-300" required>
                            </div>
                            <x-primary-button :disabled="$product->stock < 1">Tambah ke keranjang</x-primary-button>
                        </form>
                    @endcan
                @else
                    <a href="{{ route('login') }}" class="mt-6 inline-block rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Masuk untuk membeli</a>
                @endauth
            </div>
        </div>
        <a href="{{ route('marketplace.index') }}" class="mt-5 inline-block text-sm text-indigo-600 hover:underline">← Kembali ke marketplace</a>
    </div>
</x-app-layout>
