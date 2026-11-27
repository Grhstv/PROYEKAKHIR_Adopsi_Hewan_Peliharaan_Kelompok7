<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-3">
            <h2 class="text-xl font-semibold text-gray-800">Produk Toko</h2>
            <a href="{{ route('seller.products.create') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Tambah produk</a>
        </div>
    </x-slot>
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="overflow-x-auto rounded-lg bg-white shadow">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-gray-50 text-gray-600"><tr><th class="px-4 py-3">Produk</th><th class="px-4 py-3">Kategori</th><th class="px-4 py-3">Harga</th><th class="px-4 py-3">Stok</th><th class="px-4 py-3">Status</th><th class="px-4 py-3"></th></tr></thead>
                <tbody class="divide-y">
                    @forelse ($products as $product)
                        <tr>
                            <td class="px-4 py-3 font-medium">{{ $product->name }}</td><td class="px-4 py-3">{{ $product->category }}</td><td class="px-4 py-3">Rp{{ number_format($product->price, 0, ',', '.') }}</td><td class="px-4 py-3">{{ $product->stock }}</td><td class="px-4 py-3">{{ $product->active ? 'Aktif' : 'Nonaktif' }}</td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('seller.products.edit', $product) }}" class="text-indigo-600">Ubah</a>
                                <form method="POST" action="{{ route('seller.products.destroy', $product) }}" class="inline" onsubmit="return confirm('Hapus produk ini?')">@csrf @method('DELETE')<button class="ms-2 text-red-600">Hapus</button></form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-8 text-center text-gray-500">Belum ada produk. Tambahkan produk pertama Anda.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $products->links() }}</div>
    </div>
</x-app-layout>
