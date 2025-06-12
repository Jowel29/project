<?php

namespace Database\Factories\Product;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'image' => fake()->optional()->imageUrl(640, 480, 'apple', true),
            'description' => fake()->realText,
            'price' => $this->faker->randomFloat(2, 1, 1000),
        ];
    }
}
