<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @extends Factory
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape(['name' => "string", 'description' => "string", 'slug' => "string"])] public function definition(): array
    {
        $title = $this->faker->unique()->word;
        return [
            'name' => $title,
            'description' => $this->faker->sentence,
            'slug' => Str::slug($title),
        ];
    }
}
