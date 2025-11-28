<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Register;
use App\Models\Branch;

class RegisterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = Branch::all();

        foreach ($branches as $branch) {
            // Create 2-3 registers per branch
            $registerCount = rand(2, 3);
            
            for ($i = 1; $i <= $registerCount; $i++) {
                Register::firstOrCreate(
                    [
                        'name' => "Register {$i}",
                        'branch_id' => $branch->id,
                    ],
                    [
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
