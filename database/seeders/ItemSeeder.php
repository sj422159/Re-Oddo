<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('is_admin', false)->get();
        $categories = Category::all();

        $items = [
            [
                'title' => 'Vintage Denim Jacket',
                'description' => 'Classic blue denim jacket in excellent condition. Perfect for layering.',
                'size' => 'm',
                'condition' => 'excellent',
                'type' => 'outerwear',
                'tags' => ['vintage', 'denim', 'classic'],
                'status' => 'approved',
            ],
            [
                'title' => 'Floral Summer Dress',
                'description' => 'Beautiful floral print dress perfect for summer occasions.',
                'size' => 's',
                'condition' => 'good',
                'type' => 'dresses',
                'tags' => ['floral', 'summer', 'casual'],
                'status' => 'approved',
            ],
            [
                'title' => 'Designer Sneakers',
                'description' => 'Barely worn designer sneakers in great condition.',
                'size' => 'l',
                'condition' => 'excellent',
                'type' => 'shoes',
                'tags' => ['designer', 'sneakers', 'comfortable'],
                'status' => 'approved',
            ],
            [
                'title' => 'Wool Winter Coat',
                'description' => 'Warm wool coat perfect for winter weather.',
                'size' => 'l',
                'condition' => 'good',
                'type' => 'outerwear',
                'tags' => ['wool', 'winter', 'warm'],
                'status' => 'pending',
            ],
        ];

        foreach ($items as $itemData) {
            Item::create([
                'user_id' => $users->random()->id,
                'category_id' => $categories->random()->id,
                'title' => $itemData['title'],
                'description' => $itemData['description'],
                'size' => $itemData['size'],
                'condition' => $itemData['condition'],
                'type' => $itemData['type'],
                'tags' => $itemData['tags'],
                'status' => $itemData['status'],
                'point_value' => rand(30, 80),
            ]);
        }

        Item::factory(20)->create();
    }
}
