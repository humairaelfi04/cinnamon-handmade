<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Import model User
use Illuminate\Support\Facades\Hash; // Import Hash

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Owner',
            'email' => 'admin@cinnamon.com',
            'password' => Hash::make('password123'), // Ganti dengan password yang aman
            'role' => 'admin',
        ]);
    }
}
