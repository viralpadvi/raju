@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
  <div class="mb-4">
    <div class="hospital-dashboard-subtitle">Electronics store overview and key metrics</div>
    <h1 class="hospital-dashboard-title mb-0">Dashboard</h1>
  </div>

  <div class="row g-4 mb-4">
    <div class="col-12 col-md-6 col-lg-3">
      <div class="hospital-metric-card">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <div class="hospital-metric-label">Total Products</div>
            <div class="hospital-metric-value">9</div>
          </div>
          <div class="hospital-metric-icon" style="background-color: rgba(20, 184, 166, 0.1);">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#14b8a6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
              <line x1="3" y1="6" x2="21" y2="6"></line>
              <path d="M16 10a4 4 0 0 1-8 0"></path>
            </svg>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
      <div class="hospital-metric-card">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <div class="hospital-metric-label">Total Orders</div>
            <div class="hospital-metric-value">8</div>
          </div>
          <div class="hospital-metric-icon" style="background-color: rgba(20, 184, 166, 0.1);">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#14b8a6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
              <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
            </svg>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
      <div class="hospital-metric-card">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <div class="hospital-metric-label">Today's Sales</div>
            <div class="hospital-metric-value">0</div>
          </div>
          <div class="hospital-metric-icon" style="background-color: rgba(139, 92, 246, 0.1);">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8b5cf6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
              <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
            </svg>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
      <div class="hospital-metric-card">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <div class="hospital-metric-label">Total Revenue</div>
            <div class="hospital-metric-value">₹1000</div>
          </div>
          <div class="hospital-metric-icon" style="background-color: rgba(34, 197, 94, 0.1);">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <line x1="12" y1="1" x2="12" y2="23"></line>
              <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
            </svg>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-4">
    <div class="col-12 col-md-6 col-lg-4">
      <div class="hospital-metric-card">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <div class="hospital-metric-label">Completed Orders</div>
            <div class="hospital-metric-value">3</div>
          </div>
          <div class="hospital-metric-icon" style="background-color: rgba(34, 197, 94, 0.1);">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
              <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-4">
      <div class="hospital-metric-card">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <div class="hospital-metric-label">Pending Orders</div>
            <div class="hospital-metric-value">7</div>
          </div>
          <div class="hospital-metric-icon" style="background-color: rgba(251, 191, 36, 0.1);">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fbbf24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10"></circle>
              <polyline points="12 6 12 12 16 14"></polyline>
            </svg>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-4">
      <div class="hospital-metric-card">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <div class="hospital-metric-label">Pending Revenue</div>
            <div class="hospital-metric-value">₹1000</div>
          </div>
          <div class="hospital-metric-icon" style="background-color: rgba(251, 191, 36, 0.1);">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fbbf24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <line x1="12" y1="1" x2="12" y2="23"></line>
              <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
            </svg>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-4 mt-1">
    <div class="col-12 col-lg-8">
      <div class="hospital-glass-card">
        <div class="hospital-glass-card-header">
          <h2 class="hospital-glass-card-title">Latest Orders</h2>
          <a href="#" class="hospital-glass-card-link">View all</a>
        </div>
        <div class="hospital-glass-card-body">
          <div class="table-responsive">
            <table class="hospital-table">
              <thead>
                <tr>
                  <th>Order</th>
                  <th>Customer</th>
                  <th>Branch</th>
                  <th>Total</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="fw-semibold">#0001</td>
                  <td class="text-muted">—</td>
                  <td>Main</td>
                  <td class="fw-semibold">₹0.00</td>
                  <td>
                    <span class="hospital-badge hospital-badge-success">Paid</span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-lg-4">
      <div class="hospital-glass-card">
        <div class="hospital-glass-card-header">
          <h2 class="hospital-glass-card-title">Quick Links</h2>
        </div>
        <div class="hospital-glass-card-body">
          <div class="d-grid gap-2">
            <a href="{{ route('admin.catalog.products.create') }}" class="hospital-quick-link-btn">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
              </svg>
              <span>Create New Product</span>
            </a>
            <a href="{{ route('admin.inventory.purchases.index') }}" class="hospital-quick-link-btn">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
              </svg>
              <span>New Purchase</span>
            </a>
            <a href="{{ route('admin.pos') }}" class="hospital-quick-link-btn">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
              </svg>
              <span>Open POS</span>
            </a>
          </div>
          <div class="hospital-low-stock-section">
            <div class="hospital-low-stock-header">
              <h3 class="hospital-low-stock-title">Low Stock</h3>
              <span class="hospital-low-stock-count">0</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection


