<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\SaleResource;
use App\Models\Product;
use App\Models\Register;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $query = Sale::with(['register', 'user', 'customer']);

        if ($request->filled('register_id')) {
            $query->where('register_id', $request->integer('register_id'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->query('status'));
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->query('payment_method'));
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date('date_to'));
        }

        if ($search = $request->query('search')) {
            $query->where('sale_number', 'like', "%{$search}%");
        }

        $sales = $query->latest()->paginate($request->integer('per_page', 20));

        return SaleResource::collection($sales);
    }

    public function show(Sale $sale): SaleResource
    {
        return new SaleResource($sale->load(['register', 'user', 'customer']));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'register_id' => ['nullable', 'exists:registers,id'],
            'customer_id' => ['nullable', 'exists:users,id'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.price' => ['required', 'numeric', 'min:0'],
            'subtotal' => ['required', 'numeric', 'min:0'],
            'tax_amount' => ['nullable', 'numeric', 'min:0'],
            'discount_amount' => ['nullable', 'numeric', 'min:0'],
            'total_amount' => ['required', 'numeric', 'min:0'],
            'payment_method' => ['required', 'in:cash,card,check,other'],
            'notes' => ['nullable', 'string'],
        ]);

        $userId = Auth::id() ?? $request->user()->id;

        $sale = DB::transaction(function () use ($validated, $userId) {
            $registerId = $validated['register_id'] ?? Register::active()->value('id');

            if (!$registerId) {
                abort(Response::HTTP_UNPROCESSABLE_ENTITY, 'No active register available.');
            }

            $sale = Sale::create([
                'sale_number' => $this->generateSaleNumber(),
                'register_id' => $registerId,
                'user_id' => $userId,
                'customer_id' => $validated['customer_id'] ?? null,
                'subtotal' => $validated['subtotal'],
                'tax_amount' => $validated['tax_amount'] ?? 0,
                'discount_amount' => $validated['discount_amount'] ?? 0,
                'total_amount' => $validated['total_amount'],
                'payment_method' => $validated['payment_method'],
                'status' => 'completed',
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($validated['items'] as $item) {
                $product = Product::lockForUpdate()->find($item['product_id']);

                if (!$product) {
                    abort(Response::HTTP_UNPROCESSABLE_ENTITY, 'Product not found.');
                }

                if ($product->stock_quantity < $item['quantity']) {
                    abort(Response::HTTP_UNPROCESSABLE_ENTITY, "Insufficient stock for {$product->name}.");
                }

                $product->decrement('stock_quantity', $item['quantity']);
            }

            return $sale;
        });

        return new SaleResource($sale->load(['register', 'user', 'customer']));
    }

    private function generateSaleNumber(): string
    {
        $prefix = 'SALE-' . now()->format('Y');
        $count = Sale::where('sale_number', 'like', "{$prefix}-%")->count() + 1;

        return sprintf('%s-%06d', $prefix, $count);
    }
}

