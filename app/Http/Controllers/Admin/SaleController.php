<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Register;
use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view-sales');
    }

    public function index(Request $request)
    {
        $query = $this->filteredSalesQuery($request);

        $sales = (clone $query)->paginate(15)->withQueryString();
        $registers = Register::active()->orderBy('name')->get();

        $summary = [
            'count' => (clone $query)->count(),
            'total' => (clone $query)->sum('total_amount'),
            'gst' => (clone $query)->sum('gst_amount'),
        ];

        return view('admin.pos.sales.index', compact('sales', 'registers', 'summary'));
    }

    public function show(Sale $sale)
    {
        $sale->load(['items', 'user', 'customer', 'register']);
        return view('admin.pos.sales.show', compact('sale'));
    }

    protected function filteredSalesQuery(Request $request)
    {
        $query = Sale::with(['user', 'customer', 'register'])->latest();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('sale_number', 'like', "%{$search}%")
                  ->orWhere('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($customerQuery) use ($search) {
                      $customerQuery->where('name', 'like', "%{$search}%")
                                    ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->filled('register_id')) {
            $query->where('register_id', $request->register_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        return $query;
    }
}
