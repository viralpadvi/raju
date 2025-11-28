<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'manager@electro.com'],
            [
                'name' => 'Store Manager',
                'role' => 'manager',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );
    }
}


