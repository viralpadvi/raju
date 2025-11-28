@extends('layouts.admin')

@section('title', 'Purchases Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h1 class="h3 mb-0">Purchases Management</h1>
  <a href="{{ route('admin.inventory.purchases.create') }}" class="btn btn-primary">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <line x1="12" y1="5" x2="12" y2="19"></line>
      <line x1="5" y1="12" x2="19" y2="12"></line>
    </svg>
    <span>New Purchase</span>
  </a>
</div>

<!-- Filters -->
<div class="card mb-4">
  <div class="card-body">
    <form method="GET" action="{{ route('admin.inventory.purchases.index') }}">
      <div class="row g-3">
        <div class="col-md-3">
          <label class="form-label">Search</label>
          <input type="text" name="search" class="form-control" placeholder="Search purchases..." value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
          <label class="form-label">Status</label>
          <select name="status" class="form-select">
            <option value="">All Status</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="received" {{ request('status') === 'received' ? 'selected' : '' }}>Received</option>
            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label">Supplier</label>
          <select name="supplier_id" class="form-select">
            <option value="">All Suppliers</option>
            @foreach($suppliers as $supplier)
              <option value="{{ $supplier->id }}" {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label">Date From</label>
          <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
        </div>
        <div class="col-md-2">
          <label class="form-label">Date To</label>
          <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
        </div>
        <div class="col-md-1 d-flex align-items-end">
          <button type="submit" class="btn btn-primary w-100">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="11" cy="11" r="8"></circle>
              <path d="m21 21-4.35-4.35"></path>
            </svg>
            <span>Filter</span>
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif

@if(session('error'))
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif

<div class="card">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Purchase #</th>
            <th>Supplier</th>
            <th>Date</th>
            <th>Branch</th>
            <th>Total</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($purchases as $purchase)
            <tr>
              <td>
                <div class="fw-semibold">{{ $purchase->purchase_number }}</div>
                <div class="text-muted small">Purchase Order</div>
              </td>
              <td>
                <div class="d-flex align-items-center">
                  <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary">
                      <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                      <circle cx="8.5" cy="7" r="4"></circle>
                      <path d="M20 8v6"></path>
                      <path d="M23 11h-6"></path>
                    </svg>
                  </div>
                  <div>
                    <div class="fw-semibold">{{ $purchase->supplier->name ?? 'N/A' }}</div>
                    <div class="text-muted small">{{ $purchase->supplier->contact_person ?? '' }}</div>
                  </div>
                </div>
              </td>
              <td>
                <div class="fw-semibold">{{ $purchase->purchase_date->format('M d, Y') }}</div>
                <div class="text-muted small">{{ $purchase->purchase_date->diffForHumans() }}</div>
              </td>
              <td>
                <span class="badge bg-info">{{ $purchase->branch->name ?? 'N/A' }}</span>
              </td>
              <td>
                <div class="fw-semibold">₹{{ number_format($purchase->total_amount, 2) }}</div>
              </td>
              <td>
                @if($purchase->status === 'pending')
                  <span class="badge bg-warning">Pending</span>
                @elseif($purchase->status === 'received')
                  <span class="badge bg-success">Received</span>
                @else
                  <span class="badge bg-danger">Cancelled</span>
                @endif
              </td>
              <td>
                <div class="btn-group btn-group-sm">
                  <a href="{{ route('admin.inventory.purchases.show', $purchase->id) }}" class="btn btn-outline-primary" title="View">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                      <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                  </a>
                  @if($purchase->status === 'pending')
                    <form action="{{ route('admin.inventory.purchases.receive', $purchase) }}" method="POST" class="d-inline">
                      @csrf
                      @method('POST')
                      <button type="submit" class="btn btn-outline-success" title="Receive" onclick="return confirm('Mark this purchase as received?')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                          <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                      </button>
                    </form>
                    <form action="{{ route('admin.inventory.purchases.cancel', $purchase) }}" method="POST" class="d-inline">
                      @csrf
                      @method('POST')
                      <button type="submit" class="btn btn-outline-danger" title="Cancel" onclick="return confirm('Cancel this purchase order?')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                          <line x1="18" y1="6" x2="6" y2="18"></line>
                          <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                      </button>
                    </form>
                  @else
                    <button class="btn btn-outline-info" title="Print" onclick="window.print()">
                      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 6 2 18 2 18 9"></polyline>
                        <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                        <rect x="6" y="14" width="12" height="8"></rect>
                      </svg>
                    </button>
                  @endif
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center py-4">
                <div class="text-muted">
                  <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                  </svg>
                  <p>No purchases found. <a href="{{ route('admin.inventory.purchases.create') }}">Create your first purchase order</a></p>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    
    <!-- Pagination -->
    @if($purchases->hasPages())
      <nav aria-label="Purchases pagination" class="mt-4">
        {{ $purchases->links() }}
      </nav>
    @endif
  </div>
</div>
@endsection
