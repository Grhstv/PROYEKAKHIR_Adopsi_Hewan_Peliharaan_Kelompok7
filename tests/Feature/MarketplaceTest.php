<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\SellerApplication;
use App\Models\Shop;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MarketplaceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);
    }

    private function user(string $role): User
    {
        $user = User::factory()->create();
        $user->assignRole($role);

        return $user;
    }

    public function test_seller_application_approval_enables_product_sales_and_checkout(): void
    {
        $seller = $this->user('adopter');
        $admin = $this->user('admin');
        $buyer = $this->user('adopter');

        $this->actingAs($seller)->post(route('seller.application.store'), [
            'store_name' => 'Toko Sahabat',
            'store_description' => 'Menyediakan perlengkapan berkualitas untuk hewan kesayangan.',
            'address' => 'Jl. Merdeka No. 8, Jakarta Selatan',
            'phone' => '081234567890',
        ])->assertRedirect(route('seller.application.create'));

        $application = SellerApplication::where('user_id', $seller->id)->firstOrFail();
        $this->actingAs($admin)->post(route('admin.seller-applications.approve', $application))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('shops', ['owner_id' => $seller->id, 'name' => 'Toko Sahabat']);
        $this->assertTrue($seller->fresh()->hasRole('seller'));
        $seller = $seller->fresh();
        $this->actingAs($admin)->get(route('admin.seller-applications.index'))
            ->assertOk()
            ->assertSee('Toko Sahabat');

        $this->actingAs($seller)->post(route('seller.products.store'), [
            'name' => 'Makanan Kucing Sehat',
            'category' => 'Makanan',
            'description' => 'Makanan bernutrisi untuk kucing dewasa.',
            'price' => 75000,
            'stock' => 5,
            'active' => '1',
        ])->assertRedirect(route('seller.products.index'));

        $product = Product::where('name', 'Makanan Kucing Sehat')->firstOrFail();
        $this->get(route('seller.dashboard'))->assertOk()->assertSee('Toko Sahabat');
        $this->get(route('seller.products.index'))->assertOk()->assertSee('Makanan Kucing Sehat');
        $this->get(route('seller.products.create'))->assertOk()->assertSee('Nama produk');
        $this->get(route('shops.show', $product->shop))->assertOk()->assertSee('Toko Sahabat');
        $this->get(route('marketplace.show', $product))->assertOk()->assertSee('Makanan Kucing Sehat');

        $this->actingAs($buyer)->post(route('cart.store', $product), ['quantity' => 2])
            ->assertRedirect(route('cart.index'));
        $this->get(route('cart.index'))->assertOk()->assertSee('Makanan Kucing Sehat');
        $this->post(route('cart.checkout'), [
            'shipping_address' => 'Jl. Melati No. 12, Jakarta Selatan',
            'shipping_phone' => '081234567891',
            'note' => 'Mohon hubungi sebelum dikirim.',
        ])->assertRedirect(route('orders.index'));

        $order = Order::where('buyer_id', $buyer->id)->firstOrFail();
        $this->assertSame('150000.00', $order->total);
        $this->assertSame(3, $product->fresh()->stock);
        $this->get(route('orders.index'))->assertOk()->assertSee($order->order_number);
        $this->get(route('orders.show', $order))->assertOk()->assertSee('Pengiriman dan pembayaran');

        $this->actingAs($seller)->get(route('seller.orders.index'))->assertOk()->assertSee($order->order_number);
        $this->actingAs($seller)->patch(route('seller.orders.update', $order), ['status' => Order::DIPROSES])
            ->assertSessionHasNoErrors();
        $this->assertSame(Order::DIPROSES, $order->fresh()->status);
    }

    public function test_buyer_cannot_read_other_users_order_and_cancellation_restores_stock(): void
    {
        $seller = $this->user('adopter');
        $seller->assignRole('seller');
        $shop = Shop::factory()->create(['owner_id' => $seller->id]);
        $product = Product::factory()->for($shop)->create(['stock' => 2, 'price' => 25000]);
        $buyer = $this->user('adopter');
        $otherBuyer = $this->user('adopter');

        $this->actingAs($buyer)->post(route('cart.store', $product), ['quantity' => 2]);
        $this->post(route('cart.checkout'), [
            'shipping_address' => 'Jl. Melati No. 12, Jakarta Selatan',
            'shipping_phone' => '081234567891',
        ]);
        $order = Order::where('buyer_id', $buyer->id)->firstOrFail();

        $this->actingAs($otherBuyer)->get(route('orders.show', $order))->assertNotFound();
        $this->actingAs($buyer)->patch(route('orders.cancel', $order))->assertSessionHasNoErrors();

        $this->assertSame(2, $product->fresh()->stock);
        $this->assertSame(Order::DIBATALKAN, $order->fresh()->status);
    }
}
