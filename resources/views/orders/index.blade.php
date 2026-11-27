<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold text-gray-800">Pesanan Saya</h2></x-slot>
    <div class="mx-auto max-w-6xl space-y-4 px-4 py-8 sm:px-6 lg:px-8">
        @forelse ($orders as $order)
            <article class="rounded-lg bg-white p-5 shadow">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <p class="text-xs text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }} · {{ $order->order_number }}</p>
                        <h3 class="mt-1 font-semibold">{{ $order->shop->name }}</h3>
                        <p class="mt-1 text-sm text-gray-600">{{ $order->items->pluck('product_name')->implode(', ') }}</p>
                    </div>
                    <span class="rounded-full bg-indigo-50 px-3 py-1 text-sm font-medium text-indigo-700">{{ ucfirst($order->status) }}</span>
                </div>
                <div class="mt-4 flex items-center justify-between border-t pt-3">
                    <strong>Rp{{ number_format($order->total, 0, ',', '.') }}</strong>
                    <a href="{{ route('orders.show', $order) }}" class="text-sm font-semibold text-indigo-600 hover:underline">Detail pesanan</a>
                </div>
            </article>
        @empty
            <div class="rounded-lg bg-white p-8 text-center text-gray-500 shadow">Anda belum memiliki pesanan.</div>
        @endforelse
        <div>{{ $orders->links() }}</div>
    </div>
</x-app-layout>
