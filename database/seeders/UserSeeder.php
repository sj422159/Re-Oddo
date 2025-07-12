<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@rewear.com',
            'password' => Hash::make('password'),
            'points' => 0,
            'is_admin' => true,
        ]);

        User::create([
            'name' => 'Alice Johnson',
            'email' => 'alice@example.com',
            'password' => Hash::make('password'),
            'points' => 150,
            'bio' => 'Fashion enthusiast and sustainability advocate',
            'location' => 'San Francisco, CA',
        ]);

        User::create([
            'name' => 'Bob Smith',
            'email' => 'bob@example.com',
            'password' => Hash::make('password'),
            'points' => 200,
            'bio' => 'Love trading unique vintage pieces',
            'location' => 'New York, NY',
        ]);

        User::factory(10)->create();
    }
}
