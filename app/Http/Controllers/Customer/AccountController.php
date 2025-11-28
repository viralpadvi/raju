<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AccountController extends Controller
{
    /**
     * Build reusable sidebar counters for the authenticated customer.
     */
    protected function buildCounts(): array
    {
        $customer = Auth::guard('customer')->user();
        if (!$customer) {
            return [
                'orders' => 0,
                'wishlist' => 0,
                'addresses' => 0,
                'payments' => 0,
            ];
        }

        $orders = 0;
        if (Schema::hasTable('sales')) {
            // Prefer customer_id if present; otherwise fallback to 0
            $column = Schema::hasColumn('sales', 'customer_id') ? 'customer_id' : (Schema::hasColumn('sales', 'user_id') ? 'user_id' : null);
            if ($column) {
                $orders = DB::table('sales')->where($column, $customer->id)->count();
            }
        }

        $wishlist = Schema::hasTable('wishlists')
            ? DB::table('wishlists')->where('customer_id', $customer->id)->count()
            : 0;

        $addresses = Schema::hasTable('customer_addresses')
            ? DB::table('customer_addresses')->where('customer_id', $customer->id)->count()
            : 0;

        $payments = Schema::hasTable('customer_payment_methods')
            ? DB::table('customer_payment_methods')->where('customer_id', $customer->id)->count()
            : 0;

        return [
            'orders' => $orders,
            'wishlist' => $wishlist,
            'addresses' => $addresses,
            'payments' => $payments,
        ];
    }

    public function dashboard()
    {
        $customer = Auth::guard('customer')->user();
        $counts = $this->buildCounts();

        // Basic demo stats (replace with real aggregates later)
        $stats = [
            'total_orders' => $counts['orders'],
            'wishlist_items' => $counts['wishlist'],
            'average_rating' => 4.8,
            'total_spent' => 2450.00,
        ];

        return view('customer.dashboard', compact('customer', 'counts', 'stats'));
    }

    public function orders()
    {
        $counts = $this->buildCounts();
        return view('customer.orders', compact('counts'));
    }

    public function wishlist()
    {
        $counts = $this->buildCounts();
        return view('customer.wishlist', compact('counts'));
    }

    public function addresses()
    {
        $counts = $this->buildCounts();
        return view('customer.addresses', compact('counts'));
    }

    public function payments()
    {
        $counts = $this->buildCounts();
        return view('customer.payments', compact('counts'));
    }

    public function settings()
    {
        $counts = $this->buildCounts();
        return view('customer.settings', compact('counts'));
    }
}


