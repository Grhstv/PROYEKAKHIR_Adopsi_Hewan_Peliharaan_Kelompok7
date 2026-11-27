<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $orders = $request->user()->orders()->with(['shop', 'items'])->latest()->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Request $request, Order $order): View
    {
        abort_unless($order->buyer_id === $request->user()->id, 404);
        $order->load(['shop', 'items']);

        return view('orders.show', compact('order'));
    }

    public function cancel(Request $request, Order $order): RedirectResponse
    {
        abort_unless($order->buyer_id === $request->user()->id, 404);

        if ($order->status !== Order::MENUNGGU) {
            return back()->with('error', 'Pesanan hanya dapat dibatalkan sebelum diproses seller.');
        }

        $cancelled = DB::transaction(function () use ($order): bool {
            $lockedOrder = Order::whereKey($order->id)->lockForUpdate()->firstOrFail();

            if ($lockedOrder->status !== Order::MENUNGGU) {
                return false;
            }

            foreach ($lockedOrder->items()->with('product')->get() as $item) {
                $item->product?->increment('stock', $item->quantity);
            }

            $lockedOrder->update(['status' => Order::DIBATALKAN]);

            return true;
        });

        if (! $cancelled) {
            return back()->with('error', 'Pesanan sudah diproses dan tidak dapat dibatalkan.');
        }

        return back()->with('success', 'Pesanan dibatalkan.');
    }
}
