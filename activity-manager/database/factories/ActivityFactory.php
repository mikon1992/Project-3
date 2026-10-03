<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityFactory extends Factory
{
    protected $model = \App\Models\Activity::class;

    public function definition(): array
    {
        $start = now()->addDays(fake()->numberBetween(1, 30))->setTime(fake()->numberBetween(8, 18), 0);

        return [
            'category_id' => Category::factory(),
            'code' => 'ACT-' . fake()->unique()->numerify('####'),
            'title' => fake()->sentence(5),
            'description' => fake()->paragraph(),
            'start_at' => $start,
            'end_at' => (clone $start)->addHours(2),
            'location' => fake()->city(),
            'capacity' => fake()->numberBetween(20, 200),
            'status' => 'draft',
            'poster_path' => null,
            'registered_count' => 0,
        ];
    }
}