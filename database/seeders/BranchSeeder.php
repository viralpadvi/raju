<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = [
            [
                'name' => 'Downtown Store',
                'address' => '123 Main Street, Downtown, City 12345',
                'phone' => '+1 (555) 123-4567',
                'email' => 'downtown@electronicsstore.com',
                'is_active' => true,
            ],
            [
                'name' => 'Mall Location',
                'address' => '456 Shopping Mall, Westside, City 12345',
                'phone' => '+1 (555) 234-5678',
                'email' => 'mall@electronicsstore.com',
                'is_active' => true,
            ],
            [
                'name' => 'Airport Terminal',
                'address' => '789 Airport Boulevard, Terminal 2, City 12345',
                'phone' => '+1 (555) 345-6789',
                'email' => 'airport@electronicsstore.com',
                'is_active' => true,
            ],
            [
                'name' => 'University Campus',
                'address' => '321 University Avenue, Campus Center, City 12345',
                'phone' => '+1 (555) 456-7890',
                'email' => 'campus@electronicsstore.com',
                'is_active' => true,
            ],
            [
                'name' => 'Outlet Store',
                'address' => '654 Outlet Drive, Factory Outlet, City 12345',
                'phone' => '+1 (555) 567-8901',
                'email' => 'outlet@electronicsstore.com',
                'is_active' => true,
            ],
        ];

        foreach ($branches as $branch) {
            Branch::firstOrCreate(
                ['name' => $branch['name']],
                $branch
            );
        }
    }
}
