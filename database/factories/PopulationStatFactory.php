<?php

namespace Database\Factories;

use App\Models\PopulationStat;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<PopulationStat> */
class PopulationStatFactory extends Factory
{
    public function definition(): array
    {
        return [
            'year' => fake()->unique()->numberBetween(2018, 2030),
            'total' => fake()->numberBetween(3000, 4000),
            'male' => fake()->numberBetween(1400, 2000),
            'female' => fake()->numberBetween(1400, 2000),
            'growth_percent' => fake()->randomFloat(2, 0.5, 3.5),
        ];
    }
}
