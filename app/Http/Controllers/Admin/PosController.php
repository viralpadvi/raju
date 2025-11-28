<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Register;
use App\Models\Sale;
use App\Models\Branch;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    /**
     * Display POS terminal
     */
    public function index()
    {
        // Auto-select first active register
        $defaultRegister = Register::active()->with('branch')->first();
        $registers = Register::active()->with('branch')->get();
        $branches = Branch::active()->get();
        
        // Currency settings
        $currency = config('app.currency', 'INR');
        $currencySymbol = getCurrencySymbol($currency);
        
        return view('admin.pos', compact('registers', 'branches', 'defaultRegister', 'currency', 'currencySymbol'));
    }

    /**
     * Search customers
     */
    public function searchCustomers(Request $request)
    {
        try {
            $query = $request->get('q', '');

            if (empty($query) || strlen($query) < 2) {
                return response()->json([]);
            }

            $customers = \App\Models\User::where('role', '!=', 'admin')
                ->where(function($q) use ($query) {
                    $q->where('name', 'like', '%' . $query . '%')
                      ->orWhere('email', 'like', '%' . $query . '%')
                      ->orWhere('phone', 'like', '%' . $query . '%');
                })
                ->limit(10)
                ->get()
                ->map(function($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'phone' => $user->phone ?? '',
                    ];
                });

            return response()->json($customers->values());
        } catch (\Exception $e) {
            \Log::error('Customer Search Error: ' . $e->getMessage());
            return response()->json([
                'error' => true,
                'message' => 'Error searching customers: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create new customer
     */
    public function createCustomer(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'nullable|email|unique:users,email',
                'phone' => 'nullable|string|max:20',
            ]);

            $customer = \App\Models\User::create([
                'name' => $validated['name'],
                'email' => $validated['email'] ?? null,
                'phone' => $validated['phone'] ?? null,
                'role' => 'customer',
                'password' => \Hash::make('password'), // Default password, should be changed
            ]);

            return response()->json([
                'success' => true,
                'customer' => [
                    'id' => $customer->id,
                    'name' => $customer->name,
                    'email' => $customer->email,
                    'phone' => $customer->phone ?? '',
                ],
                'message' => 'Customer created successfully'
            ]);
        } catch (\Exception $e) {
            \Log::error('Create Customer Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error creating customer: ' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * Search products for POS
     */
    public function searchProducts(Request $request)
    {
        try {
            $query = $request->get('q', '');
            $barcode = $request->get('barcode', '');

            if (empty($query) && empty($barcode)) {
                return response()->json([]);
            }

            $products = Product::where('is_active', true)
                ->with(['brand', 'category']);

            if ($barcode) {
                $products->where('barcode', $barcode);
            } else {
                $products->where(function($q) use ($query) {
                    $q->where('name', 'like', '%' . $query . '%')
                      ->orWhere('sku', 'like', '%' . $query . '%')
                      ->orWhere('barcode', 'like', '%' . $query . '%');
                });
            }

            $results = $products->limit(20)->get()->map(function($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'sku' => $product->sku ?? '',
                    'barcode' => $product->barcode ?? '',
                    'price' => (float) ($product->sale_price ?: $product->price),
                    'stock' => (int) $product->stock_quantity,
                    'image' => $product->image_url ?? null,
                    'brand' => $product->brand->name ?? null,
                    'category' => $product->category->name ?? null,
                ];
            });

            return response()->json($results->values());
        } catch (\Exception $e) {
            \Log::error('POS Search Error: ' . $e->getMessage());
            return response()->json([
                'error' => true,
                'message' => 'Error searching products: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Process sale
     */
    public function processSale(Request $request)
    {
        $validated = $request->validate([
            'register_id' => 'nullable|exists:registers,id',
            'customer_id' => 'nullable|exists:users,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0',
            'subtotal' => 'required|numeric|min:0',
            'gst_rate' => 'nullable|numeric|min:0|max:100',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'gst_number' => 'nullable|string|max:30',
            'tax_amount' => 'nullable|numeric|min:0',
            'discount_type' => 'nullable|in:fixed,percentage',
            'discount_value' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,card,check,other',
            'notes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Auto-select register if not provided
            $registerId = $validated['register_id'] ?? Register::active()->first()?->id;
            
            if (!$registerId) {
                throw new \Exception('No active register found. Please create a register first.');
            }

            // Generate sale & invoice numbers
            $sequence = Sale::max('id') + 1;
            $saleNumber = 'SALE-' . date('Y') . '-' . str_pad($sequence, 6, '0', STR_PAD_LEFT);
            $invoiceNumber = 'INV-' . date('Y') . '-' . str_pad($sequence, 6, '0', STR_PAD_LEFT);

            $gstRate = $validated['gst_rate'] ?? $validated['tax_rate'] ?? 0;
            $gstAmount = $validated['tax_amount'] ?? round(($validated['subtotal'] ?? 0) * ($gstRate / 100), 2);

            // Create sale
            $sale = Sale::create([
                'sale_number' => $saleNumber,
                'invoice_number' => $invoiceNumber,
                'register_id' => $registerId,
                'user_id' => Auth::id(),
                'customer_id' => $validated['customer_id'] ?? null,
                'subtotal' => $validated['subtotal'],
                'tax_amount' => $gstAmount,
                'gst_rate' => $gstRate,
                'gst_amount' => $gstAmount,
                'gst_number' => $validated['gst_number'] ?? null,
                'discount_amount' => $validated['discount_amount'] ?? 0,
                'total_amount' => $validated['total_amount'],
                'payment_method' => $validated['payment_method'],
                'status' => 'completed',
                'notes' => $validated['notes'] ?? null,
            ]);

            // Update product stock
            foreach ($validated['items'] as $item) {
                $product = Product::find($item['product_id']);
                if (!$product) {
                    continue;
                }

                if ($product->stock_quantity < $item['quantity']) {
                    throw new \Exception("Insufficient stock for {$product->name}");
                }

                $product->decrement('stock_quantity', $item['quantity']);

                $itemSubtotal = $item['quantity'] * $item['price'];
                $itemDiscount = $item['discount'] ?? 0;
                $lineTotalBeforeTax = $itemSubtotal - $itemDiscount;
                $itemGstRate = $product->gst_rate ?? $gstRate;
                $itemGstAmount = round($lineTotalBeforeTax * ($itemGstRate / 100), 2);

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'sku' => $product->sku,
                    'hsn_code' => $product->hsn_code,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'discount_amount' => $itemDiscount,
                    'gst_rate' => $itemGstRate,
                    'gst_amount' => $itemGstAmount,
                    'total_amount' => $lineTotalBeforeTax + $itemGstAmount,
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'sale_id' => $sale->id,
                'sale_number' => $sale->sale_number,
                'message' => 'Sale processed successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Get product by barcode
     */
    public function getProductByBarcode(Request $request)
    {
        $barcode = $request->get('barcode');
        
        $product = Product::where('is_active', true)
            ->where('barcode', $barcode)
            ->where('stock_quantity', '>', 0)
            ->with(['brand', 'category'])
            ->first();

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'barcode' => $product->barcode,
                'price' => (float) $product->sale_price ?: $product->price,
                'stock' => $product->stock_quantity,
                'image' => $product->image_url ?? null,
                'brand' => $product->brand->name ?? null,
                'category' => $product->category->name ?? null,
            ]
        ]);
    }
}

