<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
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
            'sku' => $this->faker->numberBetween(100000, 900000),
            'img' => $this->faker->imageUrl(),
            'name' => $this->faker->creditCardNumber(),
            'price' => $this->faker->numberBetween(100, 900),
            'description' => $this->faker->text(),
        ];
    }
}
