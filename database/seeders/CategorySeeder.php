<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Tops', 'slug' => 'tops', 'icon' => '👕'],
            ['name' => 'Bottoms', 'slug' => 'bottoms', 'icon' => '👖'],
            ['name' => 'Dresses', 'slug' => 'dresses', 'icon' => '👗'],
            ['name' => 'Outerwear', 'slug' => 'outerwear', 'icon' => '🧥'],
            ['name' => 'Shoes', 'slug' => 'shoes', 'icon' => '👠'],
            ['name' => 'Accessories', 'slug' => 'accessories', 'icon' => '👜'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
