<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AdPlacement;
use App\Models\AdCampaign;

class AdPlacementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $campaigns = AdCampaign::all();

        $placements = [
            [
                'name' => 'Homepage Hero Banner',
                'location' => 'homepage_hero',
                'content' => '<div class="hero-banner"><h2>Holiday Electronics Sale</h2><p>Up to 50% off on selected items</p><button class="btn btn-primary">Shop Now</button></div>',
                'ad_campaign_id' => $campaigns->where('name', 'Holiday Electronics Sale')->first()?->id,
                'is_active' => true,
            ],
            [
                'name' => 'Category Sidebar Ad',
                'location' => 'category_sidebar',
                'content' => '<div class="sidebar-ad"><img src="/images/gaming-promo.jpg" alt="Gaming Promotion"><h4>Gaming Festival</h4><p>Special deals on gaming gear</p></div>',
                'ad_campaign_id' => $campaigns->where('name', 'Summer Gaming Festival')->first()?->id,
                'is_active' => true,
            ],
            [
                'name' => 'Product Page Banner',
                'location' => 'product_page',
                'content' => '<div class="product-banner"><h3>Back to School</h3><p>Get 20% off on laptops and tablets</p></div>',
                'ad_campaign_id' => $campaigns->where('name', 'Back to School Tech')->first()?->id,
                'is_active' => false,
            ],
            [
                'name' => 'Footer Newsletter Signup',
                'location' => 'footer_newsletter',
                'content' => '<div class="newsletter-ad"><h4>Stay Updated</h4><p>Get the latest deals and tech news</p><form><input type="email" placeholder="Your email"><button>Subscribe</button></form></div>',
                'ad_campaign_id' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Mobile App Banner',
                'location' => 'mobile_app',
                'content' => '<div class="mobile-banner"><h3>Download Our App</h3><p>Get exclusive mobile-only deals</p><button>Download Now</button></div>',
                'ad_campaign_id' => null,
                'is_active' => true,
            ],
        ];

        foreach ($placements as $placement) {
            AdPlacement::firstOrCreate(
                ['name' => $placement['name']],
                $placement
            );
        }
    }
}
