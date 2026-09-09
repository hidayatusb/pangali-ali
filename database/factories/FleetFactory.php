<?php

namespace Database\Factories;

use App\Models\Fleet;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Fleet> */
class FleetFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true),
            'type' => fake()->word(),
            'count' => fake()->numberBetween(1, 100),
            'description' => fake()->sentence(),
        ];
    }
}
