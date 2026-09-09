<?php

namespace Database\Factories;

use App\Models\MapZone;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<MapZone> */
class MapZoneFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true),
            'type' => fake()->randomElement(['fishing', 'residential', 'port', 'mangrove']),
            'color' => '#3b82f6',
            'latitude' => -3.54,
            'longitude' => 118.97,
            'geojson' => null,
            'description' => fake()->sentence(),
        ];
    }
}
