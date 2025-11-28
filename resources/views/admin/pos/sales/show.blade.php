@extends('layouts.admin')

@section('title', 'Sale ' . $sale->sale_number)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h1 class="h3 mb-0">Sale Details</h1>
    <p class="text-muted mb-0">Invoice #{{ $sale->invoice_number ?? 'N/A' }}</p>
  </div>
  <div class="d-flex gap-2">
    <a href="{{ route('admin.pos.sales.invoice', $sale) }}" class="btn btn-outline-primary">View Invoice</a>
    <a href="{{ route('admin.pos.sales.invoice.download', $sale) }}" class="btn btn-outline-success">Download PDF</a>
  </div>
</div>

<div class="row g-4 mb-4">
  <div class="col-md-4">
    <div class="mini-card">
      <p class="text-muted mb-1 text-uppercase small">Customer</p>
      <h5 class="mb-1">{{ $sale->customer->name ?? 'Walk-in Customer' }}</h5>
      <p class="mb-0 text-muted small">{{ $sale->customer->email ?? 'No email' }}</p>
    </div>
  </div>
  <div class="col-md-4">
    <div class="mini-card">
      <p class="text-muted mb-1 text-uppercase small">Total Amount</p>
      <h5 class="mb-1">₹{{ number_format($sale->total_amount, 2) }}</h5>
      <p class="mb-0 text-muted small">Payment: {{ strtoupper($sale->payment_method) }}</p>
    </div>
  </div>
  <div class="col-md-4">
    <div class="mini-card">
      <p class="text-muted mb-1 text-uppercase small">Date</p>
      <h5 class="mb-1">{{ optional($sale->created_at)->format('d M Y, h:i A') }}</h5>
      <p class="mb-0 text-muted small">Cashier: {{ $sale->user->name ?? 'System' }}</p>
    </div>
  </div>
</div>

<div class="card mb-4">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h6 class="mb-0">Line Items</h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>Product</th>
            <th>HSN</th>
            <th>Qty</th>
            <th>Rate</th>
            <th>GST</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          @foreach($sale->items as $item)
          <tr>
            <td>
              <div class="fw-semibold">{{ $item->product_name }}</div>
              <small class="text-muted">SKU: {{ $item->sku ?? 'N/A' }}</small>
            </td>
            <td>{{ $item->hsn_code ?? '—' }}</td>
            <td>{{ $item->quantity }}</td>
            <td>₹{{ number_format($item->unit_price, 2) }}</td>
            <td>₹{{ number_format($item->gst_amount, 2) }} ({{ $item->gst_rate }}%)</td>
            <td class="fw-semibold">₹{{ number_format($item->total_amount, 2) }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="row justify-content-end">
  <div class="col-md-4">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between mb-2">
          <span>Subtotal</span>
          <span>₹{{ number_format($sale->subtotal, 2) }}</span>
        </div>
        <div class="d-flex justify-content-between mb-2">
          <span>GST ({{ $sale->gst_rate }}%)</span>
          <span>₹{{ number_format($sale->gst_amount, 2) }}</span>
        </div>
        <div class="d-flex justify-content-between mb-2">
          <span>Discount</span>
          <span>- ₹{{ number_format($sale->discount_amount, 2) }}</span>
        </div>
        <hr>
        <div class="d-flex justify-content-between fw-bold">
          <span>Grand Total</span>
          <span>₹{{ number_format($sale->total_amount, 2) }}</span>
        </div>
      </div>
    </div>
  </div>
</div>

@push('styles')
<style>
  .mini-card {
    border-radius: 1rem;
    border: 1px solid rgba(15,23,42,.08);
    background: #fff;
    padding: 1.25rem;
    box-shadow: 0 10px 30px rgba(15,23,42,.05);
  }
</style>
@endpush
@endsection


