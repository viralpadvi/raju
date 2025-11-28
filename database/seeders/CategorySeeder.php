<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'description' => 'Electronic devices and gadgets',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Smartphones',
                'slug' => 'smartphones',
                'description' => 'Mobile phones and accessories',
                'parent_id' => 1,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Laptops',
                'slug' => 'laptops',
                'description' => 'Portable computers and accessories',
                'parent_id' => 1,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Tablets',
                'slug' => 'tablets',
                'description' => 'Tablet computers and accessories',
                'parent_id' => 1,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Audio',
                'slug' => 'audio',
                'description' => 'Audio equipment and accessories',
                'parent_id' => 1,
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Gaming',
                'slug' => 'gaming',
                'description' => 'Gaming consoles and accessories',
                'parent_id' => 1,
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}