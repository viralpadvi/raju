<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Branch;
use Carbon\Carbon;

class PurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = Supplier::all();
        $branches = Branch::all();

        // Create purchases for the last 6 months
        for ($i = 0; $i < 50; $i++) {
            $supplier = $suppliers->random();
            $branch = $branches->random();
            
            $purchaseDate = Carbon::now()->subDays(rand(1, 180));
            $totalAmount = rand(500, 5000) + (rand(0, 99) / 100);
            
            Purchase::create([
                'supplier_id' => $supplier->id,
                'branch_id' => $branch->id,
                'invoice_number' => 'INV-' . str_pad($i + 1, 6, '0', STR_PAD_LEFT),
                'purchase_date' => $purchaseDate,
                'total_amount' => $totalAmount,
                'notes' => $this->getRandomNotes(),
            ]);
        }
    }

    private function getRandomNotes()
    {
        $notes = [
            'Regular inventory restock',
            'Bulk order for holiday season',
            'Replacement stock for damaged items',
            'New product line introduction',
            'Emergency restock due to high demand',
            'Seasonal inventory preparation',
            'Special promotional items',
            'Quality control replacement',
            'End of month restock',
            'Pre-holiday inventory boost',
        ];

        return $notes[array_rand($notes)];
    }
}
