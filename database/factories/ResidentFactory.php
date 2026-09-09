<?php

namespace Database\Factories;

use App\Models\Resident;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Resident>
 */
class ResidentFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'address' => 'Lingkungan '.fake()->numberBetween(1, 5).', Pangali-Ali',
            'occupation' => fake()->randomElement([
                'Nelayan',
                'Ibu Rumah Tangga',
                'Pedagang',
                'Petani',
                'PNS',
                'Wirausaha',
                'Buruh',
                'Mahasiswa',
            ]),
            'gender' => fake()->randomElement(['laki-laki', 'perempuan']),
            'phone' => fake()->optional(0.7)->numerify('08##########'),
            'marital_status' => fake()->randomElement([
                'belum-kawin',
                'kawin',
                'cerai-hidup',
                'cerai-mati',
            ]),
            'religion' => fake()->randomElement([
                'Islam',
                'Kristen',
                'Katolik',
                'Hindu',
                'Buddha',
                'Konghucu',
            ]),
        ];
    }
}
