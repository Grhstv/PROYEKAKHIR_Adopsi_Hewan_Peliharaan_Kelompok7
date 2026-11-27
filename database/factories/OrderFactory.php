<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_number' => Str::upper(Str::random(12)),
            'buyer_id' => User::factory(),
            'shop_id' => Shop::factory(),
            'status' => 'menunggu',
            'shipping_address' => fake()->address(),
            'shipping_phone' => '+6281234567890',
            'payment_method' => 'bayar_ke_seller',
            'total' => fake()->numberBetween(10000, 500000),
        ];
    }
}
