<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function show(Sale $sale)
    {
        $sale->load(['items', 'user', 'customer', 'register']);
        $settings = $this->invoiceSettings();

        return view('admin.invoices.show', compact('sale', 'settings'));
    }

    public function download(Sale $sale)
    {
        $sale->load(['items', 'user', 'customer', 'register']);
        $settings = $this->invoiceSettings();

        $pdf = Pdf::loadView('admin.invoices.pdf', compact('sale', 'settings'))->setPaper('a4');
        $filename = ($sale->invoice_number ?? $sale->sale_number) . '.pdf';

        return $pdf->download($filename);
    }

    protected function invoiceSettings(): array
    {
        return [
            'store_name' => Setting::get('store_name', config('app.name')),
            'store_email' => Setting::get('store_email', 'info@example.com'),
            'store_phone' => Setting::get('store_phone', '+91 90000 00000'),
            'store_address' => Setting::get('store_address', 'Sample Address, City, State, ZIP'),
            'gst_number' => Setting::get('store_gst_number', 'GSTIN1234567'),
            'logo' => Setting::get('logo'),
            'currency' => config('app.currency', 'INR'),
            'currency_symbol' => getCurrencySymbol(config('app.currency', 'INR')),
        ];
    }
}
