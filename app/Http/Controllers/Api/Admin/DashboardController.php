<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ProductResource;
use App\Http\Resources\Admin\SaleResource;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function summary(): JsonResponse
    {
        $today = Carbon::today();

        $metrics = [
            'total_products' => Product::count(),
            'total_orders' => Sale::count(),
            'today_sales_count' => Sale::whereDate('created_at', $today)->count(),
            'today_sales_amount' => (float) Sale::whereDate('created_at', $today)->sum('total_amount'),
            'total_revenue' => (float) Sale::sum('total_amount'),
            'pending_purchases' => Purchase::pending()->count(),
        ];

        return response()->json([
            'status' => 'success',
            'data' => $metrics,
        ]);
    }

    public function recentSales(): JsonResponse
    {
        $sales = Sale::with(['register', 'customer', 'user'])
            ->latest()
            ->limit(request('limit', 10))
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => SaleResource::collection($sales),
        ]);
    }

    public function lowStock(): JsonResponse
    {
        $products = Product::lowStock()
            ->with(['brand', 'category'])
            ->orderBy('stock_quantity')
            ->limit(request('limit', 10))
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => ProductResource::collection($products),
        ]);
    }
}

