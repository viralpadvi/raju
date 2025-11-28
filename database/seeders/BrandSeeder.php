<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            [
                'name' => 'Apple',
                'slug' => 'apple',
                'description' => 'Premium technology and consumer electronics',
                'website' => 'https://apple.com',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Samsung',
                'slug' => 'samsung',
                'description' => 'Global leader in smartphones and electronics',
                'website' => 'https://samsung.com',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'LG',
                'slug' => 'lg',
                'description' => 'Home appliances and electronics',
                'website' => 'https://lg.com',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Sony',
                'slug' => 'sony',
                'description' => 'Entertainment and electronics',
                'website' => 'https://sony.com',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Dell',
                'slug' => 'dell',
                'description' => 'Computer technology and services',
                'website' => 'https://dell.com',
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($brands as $brand) {
            Brand::firstOrCreate(
                ['slug' => $brand['slug']],
                $brand
            );
        }
    }
}