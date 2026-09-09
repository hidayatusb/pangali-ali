<?php

namespace Database\Factories;

use App\Models\RegionalPotential;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<RegionalPotential> */
class RegionalPotentialFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'category' => fake()->randomElement(['perikanan', 'lingkungan', 'ekonomi']),
            'description' => fake()->paragraph(),
            'icon' => 'leaf',
        ];
    }
}
