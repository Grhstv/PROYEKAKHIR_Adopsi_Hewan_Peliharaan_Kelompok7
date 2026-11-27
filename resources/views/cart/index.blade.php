<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold text-gray-800">Keranjang Belanja</h2></x-slot>

    <div class="mx-auto grid max-w-7xl gap-6 px-4 py-8 sm:px-6 lg:px-8 lg:grid-cols-[1fr_360px]">
        <section class="space-y-4">
            @forelse ($items as $item)
                <article class="flex flex-wrap items-center justify-between gap-4 rounded-lg bg-white p-4 shadow">
                    <div>
                        <a href="{{ route('marketplace.show', $item->product) }}" class="font-semibold text-gray-900 hover:underline">{{ $item->product->name }}</a>
                        <p class="text-sm text-gray-500">{{ $item->product->shop->name }} · Rp{{ number_format($item->product->price, 0, ',', '.') }} · stok {{ $item->product->stock }}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <form method="POST" action="{{ route('cart.update', $item) }}" class="flex items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <input name="quantity" type="number" min="1" max="{{ max(1, $item->product->stock) }}" value="{{ $item->quantity }}" class="w-20 rounded-md border-gray-300" aria-label="Jumlah {{ $item->product->name }}">
                            <button class="text-sm font-medium text-indigo-600">Perbarui</button>
                        </form>
                        <form method="POST" action="{{ route('cart.destroy', $item) }}">
                            @csrf
                            @method('DELETE')
                            <button class="text-sm text-red-600">Hapus</button>
                        </form>
                    </div>
                </article>
            @empty
                <div class="rounded-lg bg-white p-8 text-center text-gray-500 shadow">
                    Keranjang masih kosong. <a href="{{ route('marketplace.index') }}" class="text-indigo-600 underline">Cari produk</a>.
                </div>
            @endforelse
        </section>

        <aside class="h-fit rounded-lg bg-white p-5 shadow">
            <h3 class="font-semibold text-gray-900">Ringkasan checkout</h3>
            <p class="mt-3 flex justify-between border-b pb-3 text-sm text-gray-600"><span>Total produk</span><strong>Rp{{ number_format($total, 0, ',', '.') }}</strong></p>
            <p class="mt-3 text-xs leading-5 text-gray-500">Pesanan dipisahkan per toko. Pembayaran dilakukan langsung kepada seller (COD/manual); PetHaven belum memproses pembayaran online.</p>
            @if ($items->isNotEmpty())
                <form method="POST" action="{{ route('cart.checkout') }}" class="mt-5 space-y-3">
                    @csrf
                    <div>
                        <x-input-label for="shipping_address" value="Alamat pengiriman" />
                        <textarea id="shipping_address" name="shipping_address" rows="3" class="mt-1 block w-full rounded-md border-gray-300" required>{{ old('shipping_address') }}</textarea>
                        <x-input-error :messages="$errors->get('shipping_address')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="shipping_phone" value="Nomor WhatsApp penerima" />
                        <x-text-input id="shipping_phone" name="shipping_phone" type="tel" class="mt-1 block w-full" :value="old('shipping_phone', auth()->user()->phone)" required />
                        <x-input-error :messages="$errors->get('shipping_phone')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="note" value="Catatan untuk seller (opsional)" />
                        <textarea id="note" name="note" rows="2" class="mt-1 block w-full rounded-md border-gray-300">{{ old('note') }}</textarea>
                    </div>
                    <x-input-error :messages="$errors->get('cart')" />
                    <x-primary-button class="w-full justify-center">Buat pesanan</x-primary-button>
                </form>
            @endif
        </aside>
    </div>
</x-app-layout>
