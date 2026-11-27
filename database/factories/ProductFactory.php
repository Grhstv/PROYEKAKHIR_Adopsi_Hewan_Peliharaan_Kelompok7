<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'shop_id' => Shop::factory(),
            'name' => fake()->words(3, true),
            'category' => fake()->randomElement(['Makanan', 'Aksesori', 'Perawatan']),
            'description' => fake()->paragraph(),
            'price' => fake()->numberBetween(10000, 500000),
            'stock' => fake()->numberBetween(1, 50),
            'active' => true,
        ];
    }
}
