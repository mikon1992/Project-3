<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Seminar', 'slug' => 'seminar'],
            ['name' => 'Workshop', 'slug' => 'workshop'],
            ['name' => 'Kompetisi', 'slug' => 'kompetisi'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                ['name' => $category['name']]
            );
        }
    }
}