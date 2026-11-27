<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">Toko {{ $shop->name }}</h2>
                <p class="text-sm text-gray-500">{{ $shop->address }}</p>
            </div>
            <a href="{{ route('marketplace.index') }}" class="text-sm font-semibold text-indigo-600 hover:underline">Lihat marketplace</a>
        </div>
    </x-slot>
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="grid gap-4 sm:grid-cols-3">
            <div class="rounded-lg bg-white p-5 shadow"><strong class="block text-2xl">{{ $productCount }}</strong><span class="text-sm text-gray-500">Produk toko</span></div>
            <div class="rounded-lg bg-white p-5 shadow"><strong class="block text-2xl">{{ $pendingOrders }}</strong><span class="text-sm text-gray-500">Pesanan menunggu</span></div>
            <a href="{{ route('seller.products.index') }}" class="rounded-lg bg-white p-5 font-semibold text-indigo-600 shadow">Kelola produk →</a>
        </div>
        <div class="mt-7 flex items-center justify-between">
            <h3 class="font-semibold text-gray-800">Pesanan terbaru</h3>
            <a href="{{ route('seller.orders.index') }}" class="text-sm text-indigo-600 hover:underline">Semua pesanan</a>
        </div>
        <div class="mt-3 overflow-x-auto rounded-lg bg-white shadow">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-gray-50 text-gray-600"><tr><th class="px-4 py-3">Nomor</th><th class="px-4 py-3">Pembeli</th><th class="px-4 py-3">Total</th><th class="px-4 py-3">Status</th></tr></thead>
                <tbody class="divide-y">
                    @forelse ($orders as $order)
                        <tr><td class="px-4 py-3">{{ $order->order_number }}</td><td class="px-4 py-3">{{ $order->buyer->name }}</td><td class="px-4 py-3">Rp{{ number_format($order->total, 0, ',', '.') }}</td><td class="px-4 py-3">{{ ucfirst($order->status) }}</td></tr>
                    @empty
                        <tr><td colspan="4" class="px-4 py-6 text-center text-gray-500">Belum ada pesanan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
