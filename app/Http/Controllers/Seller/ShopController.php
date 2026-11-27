<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShopController extends Controller
{
    public function index(Request $request): View
    {
        $shop = $request->user()->shop()->firstOrFail();

        return view('seller.dashboard', [
            'shop' => $shop,
            'productCount' => $shop->products()->count(),
            'pendingOrders' => $shop->orders()->where('status', Order::MENUNGGU)->count(),
            'orders' => $shop->orders()->with(['buyer', 'items'])->latest()->take(8)->get(),
        ]);
    }
}
