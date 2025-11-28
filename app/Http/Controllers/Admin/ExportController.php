<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    /**
     * Export products
     */
    public function exportProducts(Request $request, $format = 'csv')
    {
        $products = Product::with(['brand', 'category'])->get();
        
        $headers = [
            'ID', 'Name', 'SKU', 'Brand', 'Category', 'Price', 'Stock', 'Status'
        ];
        
        $data = [];
        foreach ($products as $product) {
            $data[] = [
                $product->id,
                $product->name,
                $product->sku,
                $product->brand->name ?? '-',
                $product->category->name ?? '-',
                $product->price,
                $product->stock_quantity,
                $product->is_active ? 'Active' : 'Inactive'
            ];
        }
        
        return $this->exportData($data, $headers, 'products', $format);
    }
    
    /**
     * Export reports
     */
    public function exportReports(Request $request, $format = 'csv')
    {
        // Sample data - replace with actual report data
        $headers = ['Date', 'Sales', 'Orders', 'Revenue'];
        $data = [
            ['2024-01-01', '10', '5', '₹5000'],
            ['2024-01-02', '15', '8', '₹7500'],
        ];
        
        return $this->exportData($data, $headers, 'reports', $format);
    }
    
    /**
     * Export sales
     */
    public function exportSales(Request $request, $format = 'csv')
    {
        $salesQuery = Sale::with(['register', 'user', 'customer'])->latest();

        if ($request->filled('status')) {
            $salesQuery->where('status', $request->status);
        }

        if ($request->filled('payment_method')) {
            $salesQuery->where('payment_method', $request->payment_method);
        }

        if ($request->filled('register_id')) {
            $salesQuery->where('register_id', $request->register_id);
        }

        if ($request->filled('date_from')) {
            $salesQuery->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $salesQuery->whereDate('created_at', '<=', $request->date_to);
        }

        if ($search = $request->get('search')) {
            $salesQuery->where(function ($q) use ($search) {
                $q->where('sale_number', 'like', "%{$search}%")
                  ->orWhere('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($cq) use ($search) {
                      $cq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $sales = $salesQuery->get();
        
        $headers = ['Invoice #', 'Sale #', 'Date', 'Register', 'Customer', 'Cashier', 'Payment', 'Subtotal', 'GST', 'Discount', 'Total', 'Status'];
        $data = [];
        
        foreach ($sales as $sale) {
            $data[] = [
                $sale->invoice_number ?? '-',
                $sale->sale_number,
                optional($sale->created_at)->format('Y-m-d H:i'),
                $sale->register->name ?? '-',
                $sale->customer->name ?? 'Walk-in',
                $sale->user->name ?? '-',
                ucfirst($sale->payment_method),
                number_format($sale->subtotal ?? 0, 2),
                number_format($sale->gst_amount ?? 0, 2),
                number_format($sale->discount_amount ?? 0, 2),
                number_format($sale->total_amount ?? 0, 2),
                ucfirst($sale->status ?? 'completed'),
            ];
        }
        
        return $this->exportData($data, $headers, 'sales', $format);
    }
    
    /**
     * Generic export function
     */
    private function exportData($data, $headers, $filename, $format)
    {
        $filename = $filename . '_' . date('Y-m-d') . '.' . $format;
        
        switch ($format) {
            case 'csv':
                return $this->exportCSV($data, $headers, $filename);
            case 'excel':
                return $this->exportExcel($data, $headers, $filename);
            case 'pdf':
                return $this->exportPDF($data, $headers, $filename);
            default:
                return $this->exportCSV($data, $headers, $filename);
        }
    }
    
    /**
     * Export as CSV
     */
    private function exportCSV($data, $headers, $filename)
    {
        return Response::stream(function() use ($data, $headers) {
            $output = fopen('php://output', 'w');
            fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($output, $headers);
            foreach ($data as $row) {
                fputcsv($output, $row);
            }
            fclose($output);
        }, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
    
    /**
     * Export as Excel (CSV format for now - can be enhanced with PhpSpreadsheet)
     */
    private function exportExcel($data, $headers, $filename)
    {
        // For now, export as CSV with .xls extension
        // In production, use PhpSpreadsheet library for proper Excel export
        $filename = str_replace('.xls', '.csv', $filename);
        return $this->exportCSV($data, $headers, $filename);
    }
    
    /**
     * Export as PDF
     */
    private function exportPDF($data, $headers, $filename)
    {
        $html = view('admin.exports.table', compact('data', 'headers'))->render();
        $pdf = Pdf::loadHTML($html)->setPaper('a4', 'landscape');

        return $pdf->download($filename);
    }
}

