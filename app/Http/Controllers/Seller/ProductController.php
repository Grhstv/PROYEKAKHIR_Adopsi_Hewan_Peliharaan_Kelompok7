<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductController extends Controller
{
    private const CATEGORIES = ['Makanan', 'Aksesori', 'Perawatan', 'Kesehatan', 'Lainnya'];

    public function index(Request $request): View
    {
        $shop = $request->user()->shop()->firstOrFail();
        $products = $shop->products()->latest()->paginate(12);

        return view('seller.products.index', compact('products'));
    }

    public function create(Request $request): View
    {
        $request->user()->shop()->firstOrFail();

        return view('seller.products.create', ['categories' => self::CATEGORIES]);
    }

    public function store(Request $request): RedirectResponse
    {
        $shop = $request->user()->shop()->firstOrFail();
        $data = $this->validatedProduct($request);
        $shop->products()->create($data + ['active' => $request->boolean('active')]);

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Request $request, Product $product): View
    {
        $shop = $request->user()->shop()->firstOrFail();
        abort_unless($product->shop_id === $shop->id, 404);

        return view('seller.products.edit', [
            'product' => $product,
            'categories' => self::CATEGORIES,
        ]);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $shop = $request->user()->shop()->firstOrFail();
        abort_unless($product->shop_id === $shop->id, 404);
        $product->update($this->validatedProduct($request) + ['active' => $request->boolean('active')]);

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Request $request, Product $product): RedirectResponse
    {
        $shop = $request->user()->shop()->firstOrFail();
        abort_unless($product->shop_id === $shop->id, 404);
        $product->delete();

        return back()->with('success', 'Produk berhasil dihapus dari katalog.');
    }

    private function validatedProduct(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:160'],
            'category' => ['required', Rule::in(self::CATEGORIES)],
            'description' => ['required', 'string', 'min:10', 'max:3000'],
            'price' => ['required', 'integer', 'min:1000', 'max:100000000'],
            'stock' => ['required', 'integer', 'min:0', 'max:100000'],
        ]);
    }
}
