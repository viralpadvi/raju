<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'iPhone 15 Pro',
                'slug' => 'iphone-15-pro',
                'description' => 'Latest iPhone with advanced features',
                'sku' => 'IPH15PRO-256',
                'barcode' => '1234567890123',
                'brand_id' => 1, // Apple
                'category_id' => 2, // Smartphones
                'price' => 999.00,
                'cost_price' => 750.00,
                'stock_quantity' => 15,
                'min_stock_level' => 5,
                'weight' => 0.187,
                'color' => 'Natural Titanium',
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'MacBook Pro M3',
                'slug' => 'macbook-pro-m3',
                'description' => 'Professional laptop with M3 chip',
                'sku' => 'MBP-M3-512',
                'barcode' => '1234567890124',
                'brand_id' => 1, // Apple
                'category_id' => 3, // Laptops
                'price' => 1999.00,
                'cost_price' => 1500.00,
                'stock_quantity' => 8,
                'min_stock_level' => 3,
                'weight' => 1.6,
                'color' => 'Space Gray',
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Samsung Galaxy S24',
                'slug' => 'samsung-galaxy-s24',
                'description' => 'Latest Samsung flagship smartphone',
                'sku' => 'SGS24-256',
                'barcode' => '1234567890125',
                'brand_id' => 2, // Samsung
                'category_id' => 2, // Smartphones
                'price' => 799.00,
                'cost_price' => 600.00,
                'stock_quantity' => 20,
                'min_stock_level' => 5,
                'weight' => 0.168,
                'color' => 'Titanium Gray',
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 3,
            ],
            [
                'name' => 'Dell XPS 13',
                'slug' => 'dell-xps-13',
                'description' => 'Ultrabook with premium design',
                'sku' => 'DXPS13-512',
                'barcode' => '1234567890126',
                'brand_id' => 5, // Dell
                'category_id' => 3, // Laptops
                'price' => 1299.00,
                'cost_price' => 1000.00,
                'stock_quantity' => 12,
                'min_stock_level' => 3,
                'weight' => 1.27,
                'color' => 'Platinum Silver',
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 4,
            ],
            [
                'name' => 'iPad Air',
                'slug' => 'ipad-air',
                'description' => 'Powerful tablet for work and play',
                'sku' => 'IPADAIR-256',
                'barcode' => '1234567890127',
                'brand_id' => 1, // Apple
                'category_id' => 4, // Tablets
                'price' => 599.00,
                'cost_price' => 450.00,
                'stock_quantity' => 18,
                'min_stock_level' => 5,
                'weight' => 0.461,
                'color' => 'Space Gray',
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(
                ['sku' => $product['sku']],
                $product
            );
        }
    }
}