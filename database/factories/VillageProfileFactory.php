<?php

namespace Database\Factories;

use App\Models\VillageProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<VillageProfile> */
class VillageProfileFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => 'Kelurahan Pangali-Ali',
            'district' => 'Majene',
            'regency' => 'Kabupaten Majene',
            'province' => 'Sulawesi Barat',
            'vision' => fake()->sentence(),
            'mission' => fake()->paragraph(),
            'history' => fake()->paragraph(),
            'description' => fake()->paragraph(),
            'area_km2' => 4.85,
            'lurah_name' => fake()->name(),
        ];
    }
}
