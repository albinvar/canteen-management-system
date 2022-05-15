<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\DateBasedProduct;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class CartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create()->id,
            'date_based_product_id' => DateBasedProduct::factory()->create()->id,
            'quantity' => $this->faker->numberBetween(1, 10),
        ];
    }
}
