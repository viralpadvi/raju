<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            BrandSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            BranchSeeder::class,
            RegisterSeeder::class,
            SupplierSeeder::class,
            PurchaseSeeder::class,
            SaleSeeder::class,
            AdCampaignSeeder::class,
            AdPlacementSeeder::class,
            CustomerSeeder::class,
            ManagerSeeder::class,
            RolePermissionSeeder::class,
            AdminUserSeeder::class,
        ]);
    }
}
