@extends('layouts.admin')

@section('title', 'Purchase Order Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h1 class="h3 mb-0">Purchase Order: {{ $purchase->purchase_number }}</h1>
  <div class="d-flex gap-2">
    <button class="btn btn-outline-info" onclick="window.print()">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="6 9 6 2 18 2 18 9"></polyline>
        <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
        <rect x="6" y="14" width="12" height="8"></rect>
      </svg>
      <span>Print</span>
    </button>
    <a href="{{ route('admin.inventory.purchases.index') }}" class="btn btn-outline-secondary">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <line x1="19" y1="12" x2="5" y2="12"></line>
        <polyline points="12 19 5 12 12 5"></polyline>
      </svg>
      <span>Back</span>
    </a>
  </div>
</div>

<div class="row">
  <div class="col-lg-8">
    <div class="card mb-4">
      <div class="card-header">
        <h6 class="mb-0">Purchase Details</h6>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label text-muted">Purchase Number</label>
              <div class="fw-semibold">{{ $purchase->purchase_number }}</div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label text-muted">Status</label>
              <div>
                @if($purchase->status === 'pending')
                  <span class="badge bg-warning">Pending</span>
                @elseif($purchase->status === 'received')
                  <span class="badge bg-success">Received</span>
                @else
                  <span class="badge bg-danger">Cancelled</span>
                @endif
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label text-muted">Purchase Date</label>
              <div class="fw-semibold">{{ $purchase->purchase_date->format('M d, Y') }}</div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label text-muted">Expected Date</label>
              <div class="fw-semibold">{{ $purchase->expected_date ? $purchase->expected_date->format('M d, Y') : 'N/A' }}</div>
            </div>
          </div>
        </div>
        @if($purchase->notes)
          <div class="mb-3">
            <label class="form-label text-muted">Notes</label>
            <div>{{ $purchase->notes }}</div>
          </div>
        @endif
      </div>
    </div>

    <div class="card mb-4">
      <div class="card-header">
        <h6 class="mb-0">Supplier Information</h6>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label text-muted">Supplier Name</label>
              <div class="fw-semibold">{{ $purchase->supplier->name ?? 'N/A' }}</div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label text-muted">Contact Person</label>
              <div class="fw-semibold">{{ $purchase->supplier->contact_person ?? 'N/A' }}</div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label text-muted">Email</label>
              <div>{{ $purchase->supplier->email ?? 'N/A' }}</div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label text-muted">Phone</label>
              <div>{{ $purchase->supplier->phone ?? 'N/A' }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card mb-4">
      <div class="card-header">
        <h6 class="mb-0">Summary</h6>
      </div>
      <div class="card-body">
        <div class="mb-3">
          <div class="d-flex justify-content-between mb-2">
            <span class="text-muted">Subtotal</span>
            <span class="fw-semibold">₹{{ number_format($purchase->subtotal, 2) }}</span>
          </div>
          <div class="d-flex justify-content-between mb-2">
            <span class="text-muted">Tax Amount</span>
            <span class="fw-semibold">₹{{ number_format($purchase->tax_amount, 2) }}</span>
          </div>
          <div class="d-flex justify-content-between mb-2">
            <span class="text-muted">Discount</span>
            <span class="fw-semibold">₹{{ number_format($purchase->discount_amount, 2) }}</span>
          </div>
          <hr>
          <div class="d-flex justify-content-between">
            <span class="fw-bold">Total Amount</span>
            <span class="fw-bold fs-5">₹{{ number_format($purchase->total_amount, 2) }}</span>
          </div>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-header">
        <h6 class="mb-0">Actions</h6>
      </div>
      <div class="card-body">
        @if($purchase->status === 'pending')
          <form action="{{ route('admin.inventory.purchases.receive', $purchase) }}" method="POST" class="mb-2">
            @csrf
            <button type="submit" class="btn btn-success w-100" onclick="return confirm('Mark this purchase as received?')">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"></polyline>
              </svg>
              <span>Mark as Received</span>
            </button>
          </form>
          <form action="{{ route('admin.inventory.purchases.cancel', $purchase) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Cancel this purchase order?')">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
              </svg>
              <span>Cancel Order</span>
            </button>
          </form>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection

