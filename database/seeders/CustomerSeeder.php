<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john.doe@example.com',
                'phone' => '+1 (555) 123-4567',
                'date_of_birth' => '1990-05-15',
                'gender' => 'male',
                'address' => '123 Main Street, New York, NY 10001',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'newsletter_subscribed' => true,
                'email_verified_at' => now(),
            ],
            [
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'email' => 'jane.smith@example.com',
                'phone' => '+1 (555) 987-6543',
                'date_of_birth' => '1985-08-22',
                'gender' => 'female',
                'address' => '456 Oak Avenue, Los Angeles, CA 90210',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'newsletter_subscribed' => false,
                'email_verified_at' => now(),
            ],
            [
                'first_name' => 'Mike',
                'last_name' => 'Johnson',
                'email' => 'mike.johnson@example.com',
                'phone' => '+1 (555) 456-7890',
                'date_of_birth' => '1992-12-03',
                'gender' => 'male',
                'address' => '789 Pine Street, Chicago, IL 60601',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'newsletter_subscribed' => true,
                'email_verified_at' => now(),
            ],
            [
                'first_name' => 'Sarah',
                'last_name' => 'Wilson',
                'email' => 'sarah.wilson@example.com',
                'phone' => '+1 (555) 321-0987',
                'date_of_birth' => '1988-03-18',
                'gender' => 'female',
                'address' => '321 Elm Drive, Miami, FL 33101',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'newsletter_subscribed' => true,
                'email_verified_at' => now(),
            ],
            [
                'first_name' => 'David',
                'last_name' => 'Brown',
                'email' => 'david.brown@example.com',
                'phone' => '+1 (555) 654-3210',
                'date_of_birth' => '1995-07-25',
                'gender' => 'male',
                'address' => '654 Maple Lane, Seattle, WA 98101',
                'password' => Hash::make('password123'),
                'is_active' => false,
                'newsletter_subscribed' => false,
                'email_verified_at' => now(),
            ],
        ];

        foreach ($customers as $customer) {
            Customer::firstOrCreate(
                ['email' => $customer['email']],
                $customer
            );
        }
    }
}
