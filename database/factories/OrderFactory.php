<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 10),
            'date_based_product_id' => $this->faker->numberBetween(1, 10),
            'quantity' => $this->faker->numberBetween(1, 10),
            'price' => $this->faker->numberBetween(1, 10),
            'order_group_id' => OrderGroup::factory()->create()->id,
            'payment_method' => $this->faker->randomElement(['cash', 'credit_card']),
            'payment_status' => $this->faker->randomElement(['pending', 'paid', 'cancelled']),
            'uuid' => $this->faker->uuid,
        ];
    }
}
