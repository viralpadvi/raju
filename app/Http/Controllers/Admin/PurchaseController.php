<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Branch;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Purchase::with(['supplier', 'branch', 'user']);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where('purchase_number', 'like', '%' . $request->search . '%')
                  ->orWhereHas('supplier', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by supplier
        if ($request->has('supplier_id') && $request->supplier_id) {
            $query->where('supplier_id', $request->supplier_id);
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('purchase_date', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('purchase_date', '<=', $request->date_to);
        }

        $purchases = $query->latest()->paginate(15);
        $suppliers = Supplier::active()->get();
        $branches = Branch::active()->get();

        return view('admin.inventory.purchases.index', compact('purchases', 'suppliers', 'branches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::active()->get();
        $branches = Branch::active()->get();
        $products = Product::where('is_active', true)->get();

        return view('admin.inventory.purchases.create', compact('suppliers', 'branches', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'branch_id' => 'required|exists:branches,id',
            'purchase_date' => 'required|date',
            'expected_date' => 'nullable|date|after_or_equal:purchase_date',
            'subtotal' => 'required|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,received,cancelled',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.total' => 'required|numeric|min:0',
        ]);

        // Generate purchase number
        $purchaseNumber = 'PO-' . date('Y') . '-' . str_pad(Purchase::count() + 1, 4, '0', STR_PAD_LEFT);

        $purchase = Purchase::create([
            'purchase_number' => $purchaseNumber,
            'supplier_id' => $validated['supplier_id'],
            'branch_id' => $validated['branch_id'],
            'user_id' => Auth::id(),
            'purchase_date' => $validated['purchase_date'],
            'expected_date' => $validated['expected_date'] ?? null,
            'subtotal' => $validated['subtotal'],
            'tax_amount' => $validated['tax_amount'] ?? 0,
            'discount_amount' => $validated['discount_amount'] ?? 0,
            'total_amount' => $validated['total_amount'],
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? null,
        ]);

        // Update product stock if status is received
        if ($purchase->status === 'received') {
            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                if ($product) {
                    $product->increment('stock_quantity', $item['quantity']);
                }
            }
        }

        return redirect()->route('admin.inventory.purchases.index')
            ->with('success', 'Purchase order created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $purchase = Purchase::with(['supplier', 'branch', 'user'])->findOrFail($id);

        return view('admin.inventory.purchases.show', compact('purchase'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $purchase = Purchase::findOrFail($id);
        $suppliers = Supplier::active()->get();
        $branches = Branch::active()->get();
        $products = Product::where('is_active', true)->get();

        return view('admin.inventory.purchases.edit', compact('purchase', 'suppliers', 'branches', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $purchase = Purchase::findOrFail($id);

        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'branch_id' => 'required|exists:branches,id',
            'purchase_date' => 'required|date',
            'expected_date' => 'nullable|date|after_or_equal:purchase_date',
            'subtotal' => 'required|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,received,cancelled',
            'notes' => 'nullable|string',
        ]);

        $oldStatus = $purchase->status;
        $purchase->update($validated);

        // Handle stock updates if status changed to received
        if ($oldStatus !== 'received' && $purchase->status === 'received') {
            // Add stock logic here when purchase items are implemented
        }

        return redirect()->route('admin.inventory.purchases.index')
            ->with('success', 'Purchase order updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $purchase = Purchase::findOrFail($id);

        if ($purchase->status === 'received') {
            return redirect()->route('admin.inventory.purchases.index')
                ->with('error', 'Cannot delete a received purchase order.');
        }

        $purchase->delete();

        return redirect()->route('admin.inventory.purchases.index')
            ->with('success', 'Purchase order deleted successfully.');
    }

    /**
     * Mark purchase as received
     */
    public function receive(Request $request, Purchase $purchase)
    {

        if ($purchase->status === 'received') {
            return redirect()->route('admin.inventory.purchases.index')
                ->with('error', 'Purchase order is already received.');
        }

        $purchase->update(['status' => 'received']);

        // Update product stock
        // This will be implemented when purchase items are added

        return redirect()->route('admin.inventory.purchases.index')
            ->with('success', 'Purchase order marked as received.');
    }

    /**
     * Cancel purchase order
     */
    public function cancel(Purchase $purchase)
    {

        if ($purchase->status === 'received') {
            return redirect()->route('admin.inventory.purchases.index')
                ->with('error', 'Cannot cancel a received purchase order.');
        }

        $purchase->update(['status' => 'cancelled']);

        return redirect()->route('admin.inventory.purchases.index')
            ->with('success', 'Purchase order cancelled successfully.');
    }
}
