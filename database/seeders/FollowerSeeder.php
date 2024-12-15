<?php

namespace Database\Seeders;

use App\Models\Follower;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FollowerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Follower::insert([
            [
                'follower_id' => 2, // User 1 follows User 3
                'following_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'follower_id' => 2, // User 1 follows User 2
                'following_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'follower_id' => 3, // User 2 follows User 1
                'following_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'follower_id' => 3, // User 2 follows User 1
                'following_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'follower_id' => 2, // User 1 follows Admin
                'following_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'follower_id' => 3, // User 2 follows Admin
                'following_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'follower_id' => 1,
                'following_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'follower_id' => 5,
                'following_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'follower_id' => 6,
                'following_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
