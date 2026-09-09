<?php

namespace Database\Factories;

use App\Models\Fisherman;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Fisherman>
 */
class FishermanFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'nik' => fake()->unique()->numerify('################'),
            'age' => fake()->numberBetween(18, 70),
            'gender' => fake()->randomElement(['laki-laki', 'perempuan']),
            'address' => 'Lingkungan '.fake()->numberBetween(1, 5).', Pangali-Ali',
            'boat_type' => fake()->randomElement(['Perahu Motor', 'Kapal Purse Seine', 'Bagan', 'Jukung']),
            'phone' => fake()->phoneNumber(),
            'is_active' => true,
        ];
    }
}
