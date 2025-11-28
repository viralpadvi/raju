@extends('layouts.admin')

@section('title', 'Reports & Analytics')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h1 class="h3 mb-0">Reports & Analytics</h1>
  <div class="d-flex gap-2">
    <div class="dropdown">
      <button class="btn btn-outline-primary dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
          <polyline points="7 10 12 15 17 10"></polyline>
          <line x1="12" y1="15" x2="12" y2="3"></line>
        </svg>
        <span>Export</span>
      </button>
      <ul class="dropdown-menu" aria-labelledby="exportDropdown">
        <li><a class="dropdown-item" href="{{ route('admin.reports.export', ['format' => 'csv']) }}">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-2">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
            <polyline points="14 2 14 8 20 8"></polyline>
            <line x1="16" y1="13" x2="8" y2="13"></line>
            <line x1="16" y1="17" x2="8" y2="17"></line>
            <polyline points="10 9 9 9 8 9"></polyline>
          </svg>
          Export as CSV
        </a></li>
        <li><a class="dropdown-item" href="{{ route('admin.reports.export', ['format' => 'excel']) }}">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-2">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
            <polyline points="14 2 14 8 20 8"></polyline>
            <line x1="16" y1="13" x2="8" y2="13"></line>
            <line x1="16" y1="17" x2="8" y2="17"></line>
            <polyline points="10 9 9 9 8 9"></polyline>
          </svg>
          Export as Excel
        </a></li>
        <li><a class="dropdown-item" href="{{ route('admin.reports.export', ['format' => 'pdf']) }}">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-2">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
            <polyline points="14 2 14 8 20 8"></polyline>
            <line x1="16" y1="13" x2="8" y2="13"></line>
            <line x1="16" y1="17" x2="8" y2="17"></line>
            <polyline points="10 9 9 9 8 9"></polyline>
          </svg>
          Export as PDF
        </a></li>
      </ul>
    </div>
    <button class="btn btn-outline-info" onclick="window.print()">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="6 9 6 2 18 2 18 9"></polyline>
        <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
        <rect x="6" y="14" width="12" height="8"></rect>
      </svg>
      <span>Print</span>
    </button>
  </div>
</div>

<!-- Date Range Filter -->
<div class="card mb-4">
  <div class="card-body">
    <div class="row g-3">
      <div class="col-md-3">
        <label class="form-label">Date Range</label>
        <select class="form-select">
          <option value="today">Today</option>
          <option value="yesterday">Yesterday</option>
          <option value="last7days">Last 7 Days</option>
          <option value="last30days">Last 30 Days</option>
          <option value="thisMonth">This Month</option>
          <option value="lastMonth">Last Month</option>
          <option value="custom">Custom Range</option>
        </select>
      </div>
      <div class="col-md-2">
        <label class="form-label">From Date</label>
        <input type="date" class="form-control">
      </div>
      <div class="col-md-2">
        <label class="form-label">To Date</label>
        <input type="date" class="form-control">
      </div>
      <div class="col-md-2">
        <label class="form-label">Branch</label>
        <select class="form-select">
          <option value="">All Branches</option>
          <option value="1">Main Branch</option>
          <option value="2">Branch 2</option>
        </select>
      </div>
      <div class="col-md-2">
        <label class="form-label">Register</label>
        <select class="form-select">
          <option value="">All Registers</option>
          <option value="1">Register #1</option>
          <option value="2">Register #2</option>
        </select>
      </div>
      <div class="col-md-1 d-flex align-items-end">
        <button class="btn btn-primary w-100">Generate</button>
      </div>
    </div>
  </div>
</div>

<!-- Key Metrics -->
<div class="row g-4 mb-4">
  <div class="col-lg-3 col-md-6">
    <div class="card bg-primary text-white">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <div class="h4 mb-1">$12,450</div>
            <div class="small">Total Sales</div>
          </div>
          <div class="bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
              <path d="M7 18c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12L8.1 13h7.45c.75 0 1.41-.41 1.75-1.03L21.7 4H5.21l-.94-2H1zm16 16c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/>
            </svg>
          </div>
        </div>
        <div class="mt-2">
          <span class="small">+12.5% from last period</span>
        </div>
      </div>
    </div>
  </div>
  
  <div class="col-lg-3 col-md-6">
    <div class="card bg-success text-white">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <div class="h4 mb-1">156</div>
            <div class="small">Total Orders</div>
          </div>
          <div class="bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
              <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
            </svg>
          </div>
        </div>
        <div class="mt-2">
          <span class="small">+8.3% from last period</span>
        </div>
      </div>
    </div>
  </div>
  
  <div class="col-lg-3 col-md-6">
    <div class="card bg-info text-white">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <div class="h4 mb-1">$79.81</div>
            <div class="small">Average Order</div>
          </div>
          <div class="bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
              <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
            </svg>
          </div>
        </div>
        <div class="mt-2">
          <span class="small">+4.1% from last period</span>
        </div>
      </div>
    </div>
  </div>
  
  <div class="col-lg-3 col-md-6">
    <div class="card bg-warning text-white">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <div class="h4 mb-1">23</div>
            <div class="small">Low Stock Items</div>
          </div>
          <div class="bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
              <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
            </svg>
          </div>
        </div>
        <div class="mt-2">
          <span class="small">Need attention</span>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row g-4">
  <!-- Sales Chart -->
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header">
        <h6 class="mb-0">Sales Trend</h6>
      </div>
      <div class="card-body">
        <div class="text-center py-5">
          <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="currentColor" class="text-muted mb-3">
            <path d="M3 13h2v8H3v-8zm8-6h2v14h-2V7zM19 3h2v18h-2V3z"/>
          </svg>
          <div class="h5 text-muted">Sales Chart</div>
          <div class="text-muted small">Interactive chart will be displayed here</div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Top Products -->
  <div class="col-lg-4">
    <div class="card">
      <div class="card-header">
        <h6 class="mb-0">Top Selling Products</h6>
      </div>
      <div class="card-body">
        <div class="list-group list-group-flush">
          <div class="list-group-item d-flex justify-content-between align-items-center px-0">
            <div class="d-flex align-items-center">
              <img src="https://via.placeholder.com/40x40?text=iPhone" alt="iPhone 15 Pro" class="rounded me-3" width="40" height="40">
              <div>
                <div class="fw-semibold">iPhone 15 Pro</div>
                <div class="text-muted small">15 units sold</div>
              </div>
            </div>
            <span class="badge bg-primary">$14,985</span>
          </div>
          <div class="list-group-item d-flex justify-content-between align-items-center px-0">
            <div class="d-flex align-items-center">
              <img src="https://via.placeholder.com/40x40?text=MacBook" alt="MacBook Pro" class="rounded me-3" width="40" height="40">
              <div>
                <div class="fw-semibold">MacBook Pro M3</div>
                <div class="text-muted small">8 units sold</div>
              </div>
            </div>
            <span class="badge bg-primary">$15,992</span>
          </div>
          <div class="list-group-item d-flex justify-content-between align-items-center px-0">
            <div class="d-flex align-items-center">
              <img src="https://via.placeholder.com/40x40?text=AirPods" alt="AirPods Pro" class="rounded me-3" width="40" height="40">
              <div>
                <div class="fw-semibold">AirPods Pro</div>
                <div class="text-muted small">12 units sold</div>
              </div>
            </div>
            <span class="badge bg-primary">$2,388</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Report Types -->
<div class="row g-4 mt-4">
  <div class="col-lg-6">
    <div class="card">
      <div class="card-header">
        <h6 class="mb-0">Sales Reports</h6>
      </div>
      <div class="card-body">
        <div class="d-grid gap-2">
          <button class="btn btn-outline-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-2">
              <path d="M3 13h2v8H3v-8zm8-6h2v14h-2V7zM19 3h2v18h-2V3z"/>
            </svg>
            Daily Sales Report
          </button>
          <button class="btn btn-outline-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-2">
              <path d="M3 13h2v8H3v-8zm8-6h2v14h-2V7zM19 3h2v18h-2V3z"/>
            </svg>
            Monthly Sales Report
          </button>
          <button class="btn btn-outline-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-2">
              <path d="M3 13h2v8H3v-8zm8-6h2v14h-2V7zM19 3h2v18h-2V3z"/>
            </svg>
            Product Performance Report
          </button>
          <button class="btn btn-outline-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-2">
              <path d="M3 13h2v8H3v-8zm8-6h2v14h-2V7zM19 3h2v18h-2V3z"/>
            </svg>
            Z-Report (End of Day)
          </button>
        </div>
      </div>
    </div>
  </div>
  
  <div class="col-lg-6">
    <div class="card">
      <div class="card-header">
        <h6 class="mb-0">Inventory Reports</h6>
      </div>
      <div class="card-body">
        <div class="d-grid gap-2">
          <button class="btn btn-outline-info">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-2">
              <path d="M4 4h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"/>
            </svg>
            Stock Level Report
          </button>
          <button class="btn btn-outline-info">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-2">
              <path d="M4 4h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"/>
            </svg>
            Low Stock Alert
          </button>
          <button class="btn btn-outline-info">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-2">
              <path d="M4 4h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"/>
            </svg>
            Stock Movement Report
          </button>
          <button class="btn btn-outline-info">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-2">
              <path d="M4 4h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"/>
            </svg>
            Purchase Order Report
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
