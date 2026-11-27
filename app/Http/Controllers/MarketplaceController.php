<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Shop;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{
    public function index(Request $request): View
    {
        $products = Product::query()
            ->with('shop')
            ->where('active', true)
            ->whereHas('shop', fn ($query) => $query->where('active', true))
            ->when($request->filled('q'), fn ($query) => $query->where('name', 'like', '%'.$request->string('q')->toString().'%'))
            ->when($request->filled('category'), fn ($query) => $query->where('category', $request->string('category')->toString()))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('marketplace.index', [
            'products' => $products,
            'categories' => Product::query()->where('active', true)->distinct()->orderBy('category')->pluck('category'),
        ]);
    }

    public function show(Product $product): View
    {
        abort_unless($product->active && $product->shop()->where('active', true)->exists(), 404);

        return view('marketplace.show', compact('product'));
    }

    public function shop(Shop $shop): View
    {
        abort_unless($shop->active, 404);
        $products = $shop->products()
            ->where('active', true)
            ->latest()
            ->paginate(12);

        return view('marketplace.shop', compact('shop', 'products'));
    }
}
