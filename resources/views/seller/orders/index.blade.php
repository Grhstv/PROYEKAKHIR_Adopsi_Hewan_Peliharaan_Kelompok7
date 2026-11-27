<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold text-gray-800">Pesanan Toko</h2></x-slot>
    <div class="mx-auto max-w-7xl space-y-4 px-4 py-8 sm:px-6 lg:px-8">
        @forelse ($orders as $order)
            <article class="rounded-lg bg-white p-5 shadow">
                <div class="flex flex-wrap justify-between gap-3">
                    <div>
                        <p class="text-xs text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }} · {{ $order->order_number }}</p>
                        <h3 class="mt-1 font-semibold">{{ $order->buyer->name }}</h3>
                        <p class="mt-1 text-sm text-gray-600">{{ $order->items->pluck('product_name')->implode(', ') }}</p>
                        <p class="mt-2 text-sm text-gray-600">{{ $order->shipping_address }} · {{ $order->shipping_phone }}</p>
                    </div>
                    <div class="text-right"><span class="text-sm font-medium">{{ ucfirst($order->status) }}</span><p class="mt-1 font-bold">Rp{{ number_format($order->total, 0, ',', '.') }}</p></div>
                </div>
                @if (in_array($order->status, [\App\Models\Order::MENUNGGU, \App\Models\Order::DIPROSES, \App\Models\Order::DIKIRIM], true))
                    <form method="POST" action="{{ route('seller.orders.update', $order) }}" class="mt-4 flex flex-wrap items-center gap-2 border-t pt-4">
                        @csrf
                        @method('PATCH')
                        <label for="status-{{ $order->id }}" class="text-sm text-gray-600">Perbarui status</label>
                        <select id="status-{{ $order->id }}" name="status" class="rounded-md border-gray-300 text-sm" required>
                            @if ($order->status === \App\Models\Order::MENUNGGU)
                                <option value="diproses">Diproses</option>
                            @elseif ($order->status === \App\Models\Order::DIPROSES)
                                <option value="dikirim">Dikirim</option>
                            @else
                                <option value="selesai">Selesai</option>
                            @endif
                        </select>
                        <button class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white">Simpan</button>
                    </form>
                @endif
            </article>
        @empty
            <div class="rounded-lg bg-white p-8 text-center text-gray-500 shadow">Belum ada pesanan masuk.</div>
        @endforelse
        <div>{{ $orders->links() }}</div>
    </div>
</x-app-layout>
