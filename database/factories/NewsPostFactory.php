<?php

namespace Database\Factories;

use App\Models\NewsPost;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<NewsPost>
 */
class NewsPostFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(6);

        return [
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numerify('###'),
            'excerpt' => fake()->paragraph(),
            'body' => fake()->paragraphs(3, true),
            'image_path' => null,
            'published_at' => fake()->dateTimeBetween('-6 months', 'now'),
            'is_published' => true,
        ];
    }
}
