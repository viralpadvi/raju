<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AdCampaign;
use Carbon\Carbon;

class AdCampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $campaigns = [
            [
                'name' => 'Holiday Electronics Sale',
                'description' => 'Major holiday promotion for electronics and gadgets',
                'start_date' => Carbon::now()->subDays(30),
                'end_date' => Carbon::now()->addDays(30),
                'budget' => 50000.00,
                'status' => 'active',
            ],
            [
                'name' => 'Back to School Tech',
                'description' => 'Promotion targeting students and educational technology needs',
                'start_date' => Carbon::now()->subDays(60),
                'end_date' => Carbon::now()->subDays(10),
                'budget' => 25000.00,
                'status' => 'completed',
            ],
            [
                'name' => 'Summer Gaming Festival',
                'description' => 'Gaming consoles and accessories promotion',
                'start_date' => Carbon::now()->subDays(45),
                'end_date' => Carbon::now()->addDays(15),
                'budget' => 35000.00,
                'status' => 'active',
            ],
            [
                'name' => 'Smart Home Solutions',
                'description' => 'Promotion for smart home devices and IoT products',
                'start_date' => Carbon::now()->addDays(7),
                'end_date' => Carbon::now()->addDays(60),
                'budget' => 40000.00,
                'status' => 'paused',
            ],
            [
                'name' => 'Black Friday Mega Sale',
                'description' => 'Annual Black Friday electronics sale campaign',
                'start_date' => Carbon::now()->addDays(30),
                'end_date' => Carbon::now()->addDays(35),
                'budget' => 100000.00,
                'status' => 'active',
            ],
        ];

        foreach ($campaigns as $campaign) {
            AdCampaign::firstOrCreate(
                ['name' => $campaign['name']],
                $campaign
            );
        }
    }
}
