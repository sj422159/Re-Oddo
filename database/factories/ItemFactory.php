<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    public function definition(): array
    {
        $types = ['tops', 'bottoms', 'dresses', 'outerwear', 'shoes', 'accessories'];
        $sizes = ['xs', 's', 'm', 'l', 'xl', 'xxl'];
        $conditions = ['new', 'excellent', 'good', 'fair'];
        $statuses = ['approved', 'pending'];

        return [
            'user_id' => User::where('is_admin', false)->inRandomOrder()->first()?->id,
            'category_id' => Category::inRandomOrder()->first()?->id,
            'title' => fake()->words(3, true),
            'description' => fake()->paragraph(),
            'size' => fake()->randomElement($sizes),
            'condition' => fake()->randomElement($conditions),
            'type' => fake()->randomElement($types),
            'tags' => fake()->words(3),
            'status' => fake()->randomElement($statuses),
            'point_value' => fake()->numberBetween(30, 80),
        ];
    }
}
