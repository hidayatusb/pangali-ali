<?php

namespace Database\Factories;

use App\Models\DevelopmentPlan;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<DevelopmentPlan> */
class DevelopmentPlanFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'year' => 2025,
            'status' => fake()->randomElement(['draft', 'rencana', 'berjalan', 'selesai']),
            'description' => fake()->paragraph(),
            'budget' => fake()->randomFloat(2, 50_000_000, 1_000_000_000),
        ];
    }
}
