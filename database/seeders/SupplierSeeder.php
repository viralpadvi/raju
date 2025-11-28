<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'TechDistributors Inc.',
                'contact_person' => 'John Smith',
                'email' => 'john@techdistributors.com',
                'phone' => '+1 (555) 100-2000',
                'address' => '1000 Distribution Center Blvd, Industrial Park, City 12345',
            ],
            [
                'name' => 'Global Electronics Supply',
                'contact_person' => 'Sarah Johnson',
                'email' => 'sarah@globalelectronics.com',
                'phone' => '+1 (555) 200-3000',
                'address' => '2000 Supply Chain Ave, Commerce District, City 12345',
            ],
            [
                'name' => 'Premium Gadgets Co.',
                'contact_person' => 'Mike Chen',
                'email' => 'mike@premiumgadgets.com',
                'phone' => '+1 (555) 300-4000',
                'address' => '3000 Innovation Drive, Tech Hub, City 12345',
            ],
            [
                'name' => 'Wholesale Electronics Ltd.',
                'contact_person' => 'Emily Davis',
                'email' => 'emily@wholesaleelectronics.com',
                'phone' => '+1 (555) 400-5000',
                'address' => '4000 Wholesale Plaza, Business Center, City 12345',
            ],
            [
                'name' => 'Direct Import Solutions',
                'contact_person' => 'David Wilson',
                'email' => 'david@directimport.com',
                'phone' => '+1 (555) 500-6000',
                'address' => '5000 Import Terminal, Port District, City 12345',
            ],
            [
                'name' => 'Electronics Warehouse',
                'contact_person' => 'Lisa Brown',
                'email' => 'lisa@electronicswarehouse.com',
                'phone' => '+1 (555) 600-7000',
                'address' => '6000 Warehouse Row, Storage Complex, City 12345',
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::firstOrCreate(
                ['name' => $supplier['name']],
                $supplier
            );
        }
    }
}
