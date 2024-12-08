<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::insert([
            [
                'status' => 'Hello, this is my first post!',
                'user_id' => 1, // Admin
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status' => 'Welcome to my profile!',
                'user_id' => 2, // User 1
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status' => 'What a great day!',
                'user_id' => 3, // User 2
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
