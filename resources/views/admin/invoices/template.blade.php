@php
    $currency = $settings['currency'] ?? config('app.currency', 'INR');
    $currencySymbol = $settings['currency_symbol'] ?? getCurrencySymbol($currency);
@endphp

<div class="invoice-card">
  <div class="invoice-header">
    <div>
      <h2 class="mb-1">{{ $settings['store_name'] ?? config('app.name') }}</h2>
      <p class="mb-1">{{ $settings['store_address'] ?? 'Address not configured' }}</p>
      <p class="mb-1">Phone: {{ $settings['store_phone'] ?? 'N/A' }}</p>
      <p class="mb-0">Email: {{ $settings['store_email'] ?? 'support@example.com' }}</p>
      @if(!empty($settings['store_gst_number']))
        <p class="mb-0">GSTIN: {{ $settings['store_gst_number'] }}</p>
      @endif
    </div>
    <div class="text-end">
      @if(!empty($settings['logo']))
        <img src="{{ \Illuminate\Support\Str::contains($settings['logo'], 'http') ? $settings['logo'] : (\Illuminate\Support\Facades\Storage::disk('public')->exists($settings['logo']) ? \Illuminate\Support\Facades\Storage::url($settings['logo']) : asset($settings['logo'])) }}"
             alt="Logo" style="max-height:60px;">
      @endif
      <h4 class="text-muted mt-3 mb-1">Invoice</h4>
      <div class="fw-semibold">#{{ $sale->invoice_number ?? $sale->sale_number }}</div>
    </div>
  </div>

  <div class="row invoice-meta">
    <div class="col-md-4 mb-3">
      <h6 class="text-muted text-uppercase">Billed To</h6>
      <p class="mb-1 fw-semibold">{{ $sale->customer->name ?? 'Walk-in Customer' }}</p>
      @if(optional($sale->customer)->email)<p class="mb-1">{{ $sale->customer->email }}</p>@endif
      @if(optional($sale->customer)->phone)<p class="mb-0">{{ $sale->customer->phone }}</p>@endif
    </div>
    <div class="col-md-4 mb-3">
      <h6 class="text-muted text-uppercase">Invoice Details</h6>
      <p class="mb-1">Sale #: {{ $sale->sale_number }}</p>
      <p class="mb-1">Invoice #: {{ $sale->invoice_number ?? 'N/A' }}</p>
      <p class="mb-0">Date: {{ optional($sale->created_at)->format('d M Y, h:i A') }}</p>
    </div>
    <div class="col-md-4 mb-3">
      <h6 class="text-muted text-uppercase">Register</h6>
      <p class="mb-1">{{ $sale->register->name ?? 'Main Register' }}</p>
      <p class="mb-1">Cashier: {{ $sale->user->name ?? 'System' }}</p>
      <p class="mb-0">Payment: {{ ucfirst($sale->payment_method) }}</p>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table table-sm invoice-table">
      <thead>
        <tr>
          <th>Item</th>
          <th>HSN</th>
          <th class="text-end">Qty</th>
          <th class="text-end">Rate</th>
          <th class="text-end">GST</th>
          <th class="text-end">Total</th>
        </tr>
      </thead>
      <tbody>
        @foreach($sale->items as $item)
        <tr>
          <td>
            <div class="fw-semibold">{{ $item->product_name }}</div>
            <div class="text-muted small">SKU: {{ $item->sku ?? 'N/A' }}</div>
          </td>
          <td>{{ $item->hsn_code ?? '-' }}</td>
          <td class="text-end">{{ $item->quantity }}</td>
          <td class="text-end">{{ $currencySymbol }}{{ number_format($item->unit_price, 2) }}</td>
          <td class="text-end">{{ $currencySymbol }}{{ number_format($item->gst_amount, 2) }} ({{ $item->gst_rate }}%)</td>
          <td class="text-end">{{ $currencySymbol }}{{ number_format($item->total_amount, 2) }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="row justify-content-end">
    <div class="col-md-5">
      <table class="table table-borderless">
        <tr>
          <td>Subtotal</td>
          <td class="text-end fw-semibold">{{ $currencySymbol }}{{ number_format($sale->subtotal, 2) }}</td>
        </tr>
        <tr>
          <td>GST ({{ $sale->gst_rate }}%)</td>
          <td class="text-end fw-semibold">{{ $currencySymbol }}{{ number_format($sale->gst_amount, 2) }}</td>
        </tr>
        <tr>
          <td>Discount</td>
          <td class="text-end fw-semibold text-success">- {{ $currencySymbol }}{{ number_format($sale->discount_amount, 2) }}</td>
        </tr>
        <tr class="total-row">
          <td class="fw-bold">Grand Total</td>
          <td class="text-end fw-bold">{{ $currencySymbol }}{{ number_format($sale->total_amount, 2) }}</td>
        </tr>
      </table>
    </div>
  </div>

  <p class="invoice-footer text-muted small mb-0">
    Thank you for shopping with us! This is a computer generated invoice and does not require a signature.
  </p>
</div>

