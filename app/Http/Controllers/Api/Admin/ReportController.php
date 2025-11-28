<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ProductResource;
use App\Http\Resources\Admin\SaleResource;
use App\Models\Product;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function summary(Request $request): JsonResponse
    {
        $start = Carbon::parse($request->get('start', now()->subDays(6)->toDateString()));
        $end = Carbon::parse($request->get('end', now()->toDateString()));

        $sales = Sale::whereBetween('created_at', [$start->startOfDay(), $end->endOfDay()])
            ->selectRaw('DATE(created_at) as day, SUM(total_amount) as total, COUNT(*) as orders')
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $topProducts = Product::orderByDesc('stock_quantity')->limit(5)->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'sales' => $sales,
                'top_products' => ProductResource::collection($topProducts),
            ],
        ]);
    }

    public function sales(Request $request)
    {
        $query = Sale::with(['register', 'user', 'customer']);

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date('date_to'));
        }

        $sales = $query->latest()->paginate($request->integer('per_page', 25));

        return SaleResource::collection($sales);
    }

    public function export(Request $request, string $type): JsonResponse
    {
        switch ($type) {
            case 'sales':
                $data = Sale::latest()->limit(100)->get()->map(function ($sale) {
                    return [
                        $sale->sale_number,
                        optional($sale->customer)->name ?? 'Walk-in',
                        $sale->total_amount,
                        $sale->status,
                        optional($sale->created_at)->toDateTimeString(),
                    ];
                })->toArray();
                $headers = ['Sale #', 'Customer', 'Total', 'Status', 'Date'];
                break;
            case 'products':
                $data = Product::orderBy('name')->get()->map(function ($product) {
                    return [
                        $product->name,
                        $product->sku,
                        $product->price,
                        $product->stock_quantity,
                        $product->is_active ? 'Active' : 'Inactive',
                    ];
                })->toArray();
                $headers = ['Product', 'SKU', 'Price', 'Stock', 'Status'];
                break;
            default:
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unsupported export type.',
                ], 422);
        }

        $csv = $this->toCsv($headers, $data);

        return response()->json([
            'status' => 'success',
            'filename' => "{$type}_report_" . now()->format('Ymd_His') . '.csv',
            'content' => base64_encode($csv),
        ]);
    }

    private function toCsv(array $headers, array $rows): string
    {
        $handle = fopen('php://temp', 'r+');
        fputcsv($handle, $headers);
        foreach ($rows as $row) {
            fputcsv($handle, $row);
        }
        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return $csv ?: '';
    }
}

