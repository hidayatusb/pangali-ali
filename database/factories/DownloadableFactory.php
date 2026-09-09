<?php

namespace Database\Factories;

use App\Models\Downloadable;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Downloadable> */
class DownloadableFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'category' => 'laporan',
            'file_path' => null,
            'file_name' => 'dokumen.pdf',
            'file_size' => null,
            'description' => fake()->sentence(),
            'published_at' => now(),
        ];
    }
}
