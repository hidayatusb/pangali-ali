<?php

namespace Database\Factories;

use App\Models\Infrastructure;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Infrastructure> */
class InfrastructureFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true),
            'count' => fake()->numberBetween(1, 5),
            'unit' => 'unit',
            'icon' => 'anchor',
            'category' => 'perikanan',
            'description' => fake()->sentence(),
            'sort_order' => fake()->numberBetween(0, 20),
        ];
    }
}
