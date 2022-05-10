<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @extends Factory
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape(['name' => "string", 'description' => "string", 'category_id' => "\Illuminate\Support\HigherOrderCollectionProxy|mixed", 'slug' => "string", 'price' => "float", 'image' => "string", 'created_by' => "\Illuminate\Support\HigherOrderCollectionProxy|mixed"])] public function definition(): array
    {
        return array(
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'category_id' => Category::factory()->create()->id,
            'slug' => $this->faker->unique()->slug,
            'price' => $this->faker->randomFloat(2, 1, 100),
            'image' => $this->faker->imageUrl(),
            'created_by' => User::factory()->create()->id,
        );
    }
}
