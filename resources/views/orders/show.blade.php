<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold text-gray-800">Pesanan {{ $order->order_number }}</h2></x-slot>
    <div class="mx-auto max-w-4xl space-y-5 px-4 py-8 sm:px-6 lg:px-8">
        <section class="rounded-lg bg-white p-5 shadow">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h3 class="font-semibold">{{ $order->shop->name }}</h3>
                    <p class="mt-1 text-sm text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <span class="rounded-full bg-indigo-50 px-3 py-1 text-sm font-medium text-indigo-700">{{ ucfirst($order->status) }}</span>
            </div>
            <div class="mt-4 divide-y">
                @foreach ($order->items as $item)
                    <div class="flex justify-between gap-4 py-3 text-sm">
                        <span>{{ $item->product_name }} × {{ $item->quantity }}</span>
                        <span>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>
            <p class="mt-3 border-t pt-3 text-right font-bold">Total Rp{{ number_format($order->total, 0, ',', '.') }}</p>
        </section>
        <section class="rounded-lg bg-white p-5 text-sm shadow">
            <h3 class="font-semibold">Pengiriman dan pembayaran</h3>
            <p class="mt-2 text-gray-700">{{ $order->shipping_address }}</p>
            <p class="text-gray-600">{{ $order->shipping_phone }}</p>
            <p class="mt-2 text-gray-600">Bayar langsung kepada seller (COD/manual).</p>
            @if ($order->note)
                <p class="mt-2 text-gray-600">Catatan: {{ $order->note }}</p>
            @endif
        </section>
        @if ($order->status === \App\Models\Order::MENUNGGU)
            <form method="POST" action="{{ route('orders.cancel', $order) }}" onsubmit="return confirm('Batalkan pesanan ini?')">
                @csrf
                @method('PATCH')
                <button class="rounded-md border border-red-300 px-4 py-2 text-sm font-semibold text-red-700">Batalkan pesanan</button>
            </form>
        @endif
        <a href="{{ route('orders.index') }}" class="inline-block text-sm text-indigo-600 hover:underline">← Kembali ke pesanan</a>
    </div>
</x-app-layout>
