<?php

namespace Database\Factories;

use App\Models\Commodity;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Commodity> */
class CommodityFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'percentage' => fake()->randomFloat(2, 5, 50),
            'tonnage' => fake()->randomFloat(2, 50, 600),
            'color' => '#3b82f6',
            'year' => 2024,
        ];
    }
}
