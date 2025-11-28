@extends('layouts.admin')

@section('title', 'Sales History')

@section('content')
@php
    $query = request()->query();
    $qs = http_build_query($query);
    $exportUrl = fn($format) => route('admin.pos.sales.export', ['format' => $format]) . ($qs ? '?'.$qs : '');
@endphp

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h1 class="h3 mb-1">Sales History</h1>
    <p class="text-muted mb-0">Track every POS transaction and download invoices instantly.</p>
  </div>
  <div class="d-flex gap-2">
    <div class="dropdown">
      <button class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-2">
          <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
          <polyline points="7 10 12 15 17 10"></polyline>
          <line x1="12" y1="15" x2="12" y2="3"></line>
        </svg>
        Export
      </button>
      <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="{{ $exportUrl('csv') }}">Export CSV</a></li>
        <li><a class="dropdown-item" href="{{ $exportUrl('excel') }}">Export Excel</a></li>
        <li><a class="dropdown-item" href="{{ $exportUrl('pdf') }}">Export PDF</a></li>
      </ul>
    </div>
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

<div class="row g-3 mb-4">
  <div class="col-md-4">
    <div class="metric-card">
      <p class="text-muted mb-1 text-uppercase small">Transactions</p>
      <h3 class="mb-0">{{ number_format($summary['count']) }}</h3>
    </div>
  </div>
  <div class="col-md-4">
    <div class="metric-card">
      <p class="text-muted mb-1 text-uppercase small">Total Sales</p>
      <h3 class="mb-0">₹{{ number_format($summary['total'], 2) }}</h3>
    </div>
  </div>
  <div class="col-md-4">
    <div class="metric-card">
      <p class="text-muted mb-1 text-uppercase small">GST Collected</p>
      <h3 class="mb-0">₹{{ number_format($summary['gst'], 2) }}</h3>
    </div>
  </div>
</div>

<div class="card mb-4">
  <div class="card-body">
    <form method="GET" class="row g-3 align-items-end">
      <div class="col-md-3">
        <label class="form-label">Search</label>
        <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Invoice, sale, customer...">
      </div>
      <div class="col-md-2">
        <label class="form-label">Status</label>
        <select class="form-select" name="status">
          <option value="">All</option>
          @foreach(['completed','refunded','cancelled'] as $status)
          <option value="{{ $status }}" {{ request('status')===$status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2">
        <label class="form-label">Payment</label>
        <select class="form-select" name="payment_method">
          <option value="">All</option>
          @foreach(['cash','card','check','other'] as $method)
          <option value="{{ $method }}" {{ request('payment_method')===$method ? 'selected' : '' }}>{{ strtoupper($method) }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2">
        <label class="form-label">Register</label>
        <select class="form-select" name="register_id">
          <option value="">All</option>
          @foreach($registers as $register)
            <option value="{{ $register->id }}" {{ request('register_id')==$register->id ? 'selected' : '' }}>
              {{ $register->name }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2">
        <label class="form-label">From</label>
        <input type="date" class="form-control" name="date_from" value="{{ request('date_from') }}">
      </div>
      <div class="col-md-2">
        <label class="form-label">To</label>
        <input type="date" class="form-control" name="date_to" value="{{ request('date_to') }}">
      </div>
      <div class="col-md-1 d-grid">
        <button class="btn btn-primary">Filter</button>
      </div>
      <div class="col-md-1 d-grid">
        <a href="{{ route('admin.pos.sales.index') }}" class="btn btn-light">Reset</a>
      </div>
    </form>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table align-middle">
        <thead>
          <tr>
            <th>Invoice</th>
            <th>Customer</th>
            <th>Cashier</th>
            <th>Register</th>
            <th>Payment</th>
            <th>Total</th>
            <th>Status</th>
            <th>Date</th>
            <th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($sales as $sale)
          <tr>
            <td>
              <div class="fw-semibold">{{ $sale->invoice_number ?? '—' }}</div>
              <small class="text-muted">{{ $sale->sale_number }}</small>
            </td>
            <td>
              <div class="fw-semibold">{{ $sale->customer->name ?? 'Walk-in Customer' }}</div>
              <small class="text-muted">{{ $sale->customer->email ?? 'No Email' }}</small>
            </td>
            <td>{{ $sale->user->name ?? 'System' }}</td>
            <td>{{ $sale->register->name ?? 'Register' }}</td>
            <td class="text-uppercase">{{ $sale->payment_method }}</td>
            <td class="fw-semibold">₹{{ number_format($sale->total_amount, 2) }}</td>
            <td>
              <span class="badge bg-{{ $sale->status === 'completed' ? 'success' : ($sale->status === 'refunded' ? 'warning' : 'secondary') }}">
                {{ ucfirst($sale->status ?? 'completed') }}
              </span>
            </td>
            <td>
              <div>{{ optional($sale->created_at)->format('d M Y') }}</div>
              <small class="text-muted">{{ optional($sale->created_at)->format('h:i A') }}</small>
            </td>
            <td class="text-end">
              <div class="btn-group btn-group-sm">
                <a href="{{ route('admin.pos.sales.show', $sale) }}" class="btn btn-outline-primary" title="View sale">
                  View
                </a>
                <a href="{{ route('admin.pos.sales.invoice', $sale) }}" class="btn btn-outline-info" title="Invoice">
                  Invoice
                </a>
                <a href="{{ route('admin.pos.sales.invoice.download', $sale) }}" class="btn btn-outline-success" title="Download">
                  PDF
                </a>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="9" class="text-center py-4">
              <p class="mb-0 text-muted">No sales match your filters.</p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="mt-3">
      {{ $sales->links() }}
    </div>
  </div>
</div>

@push('styles')
<style>
  .metric-card {
    background: #fff;
    border-radius: 1rem;
    padding: 1.25rem;
    border: 1px solid rgba(15,23,42,.08);
    box-shadow: 0 10px 30px rgba(15,23,42,.05);
  }
</style>
@endpush
@endsection


