<?php

namespace Database\Factories;

use App\Models\WelfareIndicator;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<WelfareIndicator> */
class WelfareIndicatorFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3),
            'value' => (string) fake()->numberBetween(10, 100),
            'unit' => '%',
            'year' => 2024,
            'notes' => null,
        ];
    }
}
