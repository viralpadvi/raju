<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sale;
use App\Models\Branch;
use App\Models\Register;
use App\Models\User;
use Carbon\Carbon;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = Branch::all();
        $registers = Register::all();
        $users = User::all();

        // Create sales for the last 3 months
        for ($i = 0; $i < 200; $i++) {
            $branch = $branches->random();
            $register = $registers->where('branch_id', $branch->id)->random();
            $user = $users->random();
            
            $saleDate = Carbon::now()->subDays(rand(1, 90));
            $totalAmount = rand(50, 2000) + (rand(0, 99) / 100);
            $discountAmount = rand(0, $totalAmount * 0.2);
            $taxAmount = ($totalAmount - $discountAmount) * 0.08;
            $netAmount = $totalAmount - $discountAmount + $taxAmount;
            
            $paymentMethods = ['cash', 'credit_card', 'debit_card', 'mobile_payment'];
            $statuses = ['completed', 'completed', 'completed', 'completed', 'pending', 'refunded'];
            
            Sale::create([
                'invoice_number' => 'SALE-' . str_pad($i + 1, 6, '0', STR_PAD_LEFT),
                'user_id' => $user->id,
                'branch_id' => $branch->id,
                'register_id' => $register->id,
                'total_amount' => $totalAmount,
                'discount_amount' => $discountAmount,
                'tax_amount' => $taxAmount,
                'net_amount' => $netAmount,
                'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                'status' => $statuses[array_rand($statuses)],
                'created_at' => $saleDate,
                'updated_at' => $saleDate,
            ]);
        }
    }
}
