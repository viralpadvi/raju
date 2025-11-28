<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\PurchaseResource;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        $query = Purchase::with(['supplier', 'branch', 'user']);

        if ($search = $request->query('search')) {
            $query->where('purchase_number', 'like', "%{$search}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->query('status'));
        }

        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->integer('supplier_id'));
        }

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->integer('branch_id'));
        }

        if ($request->filled('date_from')) {
            $query->whereDate('purchase_date', '>=', $request->date('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('purchase_date', '<=', $request->date('date_to'));
        }

        $purchases = $query->latest()->paginate($request->integer('per_page', 15));

        return PurchaseResource::collection($purchases);
    }

    public function store(Request $request): PurchaseResource
    {
        $validated = $this->validatedData($request);
        $purchase = Purchase::create(array_merge($validated, [
            'purchase_number' => $this->generatePurchaseNumber(),
            'user_id' => $request->user()->id,
        ]));

        return new PurchaseResource($purchase->load(['supplier', 'branch', 'user']));
    }

    public function show(Purchase $purchase): PurchaseResource
    {
        return new PurchaseResource($purchase->load(['supplier', 'branch', 'user']));
    }

    public function update(Request $request, Purchase $purchase): PurchaseResource
    {
        $validated = $this->validatedData($request);

        if ($purchase->status === 'received') {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY, 'Cannot update a received purchase order.');
        }

        $purchase->update($validated);

        return new PurchaseResource($purchase->load(['supplier', 'branch', 'user']));
    }

    public function destroy(Purchase $purchase)
    {
        if ($purchase->status === 'received') {
            return response()->json([
                'status' => 'error',
                'message' => 'Cannot delete a received purchase order.',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $purchase->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Purchase order deleted successfully.',
        ]);
    }

    public function receive(Purchase $purchase)
    {
        if ($purchase->status === 'received') {
            return response()->json([
                'status' => 'error',
                'message' => 'Purchase order already received.',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $purchase->update(['status' => 'received']);

        return new PurchaseResource($purchase->fresh()->load(['supplier', 'branch', 'user']));
    }

    public function cancel(Purchase $purchase)
    {
        if ($purchase->status === 'received') {
            return response()->json([
                'status' => 'error',
                'message' => 'Cannot cancel a received purchase order.',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $purchase->update(['status' => 'cancelled']);

        return new PurchaseResource($purchase->fresh()->load(['supplier', 'branch', 'user']));
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'supplier_id' => ['required', 'exists:suppliers,id'],
            'branch_id' => ['required', 'exists:branches,id'],
            'purchase_date' => ['required', 'date'],
            'expected_date' => ['nullable', 'date', 'after_or_equal:purchase_date'],
            'subtotal' => ['required', 'numeric', 'min:0'],
            'tax_amount' => ['nullable', 'numeric', 'min:0'],
            'discount_amount' => ['nullable', 'numeric', 'min:0'],
            'total_amount' => ['required', 'numeric', 'min:0'],
            'status' => ['nullable', 'in:pending,received,cancelled'],
            'notes' => ['nullable', 'string'],
        ]);
    }

    private function generatePurchaseNumber(): string
    {
        $prefix = 'PO-' . now()->format('Y');
        $latest = Purchase::where('purchase_number', 'like', "{$prefix}-%")->count() + 1;

        return sprintf('%s-%04d', $prefix, $latest);
    }
}

