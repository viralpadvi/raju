@extends('layouts.admin')

@section('title', 'Invoice ' . ($sale->invoice_number ?? $sale->sale_number))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h1 class="h3 mb-0">Invoice</h1>
    <p class="text-muted mb-0">Sale #: {{ $sale->sale_number }}</p>
  </div>
  <div class="d-flex gap-2">
    <a href="{{ route('admin.pos.sales.invoice.download', $sale) }}" class="btn btn-outline-primary">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-2">
        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
        <polyline points="7 10 12 15 17 10"></polyline>
        <line x1="12" y1="15" x2="12" y2="3"></line>
      </svg>
      Download PDF
    </a>
    <button class="btn btn-outline-secondary" onclick="window.print()">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-2">
        <polyline points="6 9 6 2 18 2 18 9"></polyline>
        <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
        <rect x="6" y="14" width="12" height="8"></rect>
      </svg>
      Print
    </button>
  </div>
</div>

<div class="invoice-wrapper bg-white p-4 rounded-4 shadow-sm">
  @include('admin.invoices.template', ['sale' => $sale, 'settings' => $settings])
</div>

@push('styles')
<style>
  .invoice-wrapper { border: 1px solid rgba(15,23,42,.06); }
  .invoice-header { display:flex; justify-content:space-between; gap:2rem; border-bottom:1px solid #e5e7eb; padding-bottom:1.5rem; margin-bottom:1.5rem; }
  .invoice-meta { margin-bottom:1.5rem; }
  .invoice-table thead th { background:#f8fafc; border-bottom:1px solid #e5e7eb; font-size:.75rem; letter-spacing:.8px; text-transform:uppercase; }
  .invoice-table td { vertical-align:middle; }
  .total-row td { border-top:2px solid #e5e7eb; font-size:1.05rem; }
  .invoice-footer { border-top:1px dashed #d4d4d8; padding-top:1rem; }
</style>
@endpush
@endsection


