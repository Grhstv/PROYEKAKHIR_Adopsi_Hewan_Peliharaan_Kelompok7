<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use App\Support\PhoneNumber;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{
    public function index(Request $request): View
    {
        $items = $request->user()->cartItems()->with('product.shop')->get();

        return view('cart.index', [
            'items' => $items,
            'total' => $items->sum(fn (CartItem $item): float => (float) $item->product->price * $item->quantity),
        ]);
    }

    public function store(Request $request, Product $product): RedirectResponse
    {
        abort_unless($product->active && $product->shop->active, 404);

        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:100'],
        ]);

        if ($product->shop->owner_id === $request->user()->id) {
            return back()->with('error', 'Anda tidak dapat membeli produk dari toko sendiri.');
        }

        $item = $request->user()->cartItems()->firstOrNew(['product_id' => $product->id]);
        $quantity = (int) $item->quantity + (int) $data['quantity'];

        if ($quantity > $product->stock) {
            return back()->with('error', 'Jumlah melebihi stok yang tersedia.');
        }

        $item->quantity = $quantity;
        $item->save();

        return redirect()->route('cart.index')->with('success', 'Produk ditambahkan ke keranjang.');
    }

    public function update(Request $request, CartItem $cartItem): RedirectResponse
    {
        abort_unless($cartItem->user_id === $request->user()->id, 404);

        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:100'],
        ]);

        if ($data['quantity'] > $cartItem->product->stock || ! $cartItem->product->active) {
            return back()->with('error', 'Jumlah melebihi stok yang tersedia atau produk sudah tidak aktif.');
        }

        $cartItem->update(['quantity' => $data['quantity']]);

        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function destroy(Request $request, CartItem $cartItem): RedirectResponse
    {
        abort_unless($cartItem->user_id === $request->user()->id, 404);
        $cartItem->delete();

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }

    public function checkout(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'shipping_address' => ['required', 'string', 'min:10', 'max:1000'],
            'shipping_phone' => ['required', 'string', 'regex:/^[0-9+\s().-]{8,24}$/'],
            'note' => ['nullable', 'string', 'max:500'],
        ]);
        $user = $request->user();
        $phone = PhoneNumber::normalize($data['shipping_phone']);

        $orders = DB::transaction(function () use ($user, $data, $phone): array {
            $cartItems = CartItem::where('user_id', $user->id)->lockForUpdate()->get();

            if ($cartItems->isEmpty()) {
                throw ValidationException::withMessages(['cart' => 'Keranjang Anda masih kosong.']);
            }

            $groups = [];

            foreach ($cartItems as $cartItem) {
                $product = Product::with('shop')->whereKey($cartItem->product_id)->lockForUpdate()->firstOrFail();

                if (! $product->active || ! $product->shop->active || $product->stock < $cartItem->quantity) {
                    throw ValidationException::withMessages(['cart' => "Stok produk {$product->name} tidak mencukupi."]);
                }

                if ($product->shop->owner_id === $user->id) {
                    throw ValidationException::withMessages(['cart' => 'Keranjang tidak boleh berisi produk dari toko Anda sendiri.']);
                }

                $groups[$product->shop_id][] = [$cartItem, $product];
            }

            $createdOrders = [];

            foreach ($groups as $shopId => $entries) {
                $total = array_sum(array_map(
                    fn (array $entry): float => (float) $entry[1]->price * $entry[0]->quantity,
                    $entries,
                ));
                $order = Order::create([
                    'order_number' => Str::upper(Str::random(16)),
                    'buyer_id' => $user->id,
                    'shop_id' => $shopId,
                    'status' => Order::MENUNGGU,
                    'shipping_address' => $data['shipping_address'],
                    'shipping_phone' => $phone,
                    'payment_method' => 'bayar_ke_seller',
                    'note' => $data['note'] ?? null,
                    'total' => $total,
                ]);

                foreach ($entries as [$cartItem, $product]) {
                    $unitPrice = (float) $product->price;
                    $order->items()->create([
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'quantity' => $cartItem->quantity,
                        'unit_price' => $unitPrice,
                        'subtotal' => $unitPrice * $cartItem->quantity,
                    ]);
                    $product->decrement('stock', $cartItem->quantity);
                    $cartItem->delete();
                }

                $createdOrders[] = $order;
            }

            return $createdOrders;
        });

        return redirect()->route('orders.index')
            ->with('success', count($orders).' pesanan berhasil dibuat. Pembayaran dilakukan langsung kepada seller.');
    }
}
