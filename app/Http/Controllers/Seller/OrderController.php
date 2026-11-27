<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $shop = $request->user()->shop()->firstOrFail();
        $orders = $shop->orders()->with(['buyer', 'items'])->latest()->paginate(15);

        return view('seller.orders.index', compact('orders'));
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $shop = $request->user()->shop()->firstOrFail();
        abort_unless($order->shop_id === $shop->id, 404);
        $data = $request->validate([
            'status' => ['required', Rule::in([Order::DIPROSES, Order::DIKIRIM, Order::SELESAI])],
        ]);

        $allowedTransitions = [
            Order::MENUNGGU => Order::DIPROSES,
            Order::DIPROSES => Order::DIKIRIM,
            Order::DIKIRIM => Order::SELESAI,
        ];

        if (($allowedTransitions[$order->status] ?? null) !== $data['status']) {
            return back()->with('error', 'Status pesanan tidak dapat diubah ke tahap tersebut.');
        }

        $order->update(['status' => $data['status']]);

        return back()->with('success', 'Status pesanan diperbarui.');
    }
}
