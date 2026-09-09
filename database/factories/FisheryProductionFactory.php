<?php

namespace Database\Factories;

use App\Models\FisheryProduction;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<FisheryProduction> */
class FisheryProductionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'year' => fake()->unique()->numberBetween(2015, 2035),
            'total_ton' => fake()->randomFloat(2, 800, 1500),
            'economic_value' => fake()->randomFloat(2, 10_000_000_000, 20_000_000_000),
        ];
    }
}
