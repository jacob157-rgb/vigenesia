<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'username' => 'admin',
                'role' => 'admin',
                'password' => Hash::make('admin'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'username' => 'rifqi',
                'role' => 'user',
                'password' => Hash::make('rifqi'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'username' => 'rizki',
                'role' => 'user',
                'password' => Hash::make('rizki'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'username' => 'jacob',
                'role' => 'admin',
                'password' => Hash::make('jacob'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'username' => 'testadmin',
                'role' => 'admin',
                'password' => Hash::make('testadmin'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'username' => 'testuser',
                'role' => 'user',
                'password' => Hash::make('testuser'),
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
