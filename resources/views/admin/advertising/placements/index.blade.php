@extends('layouts.admin')

@section('title', 'Ad Placements')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h1 class="h3 mb-0">Ad Placements</h1>
  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPlacementModal">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-1">
      <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
    </svg>
    Add Placement
  </button>
</div>

<!-- Filters -->
<div class="card mb-4">
  <div class="card-body">
    <div class="row g-3">
      <div class="col-md-3">
        <label class="form-label">Search</label>
        <input type="text" class="form-control" placeholder="Search placements...">
      </div>
      <div class="col-md-2">
        <label class="form-label">Status</label>
        <select class="form-select">
          <option value="">All Status</option>
          <option value="active">Active</option>
          <option value="inactive">Inactive</option>
          <option value="scheduled">Scheduled</option>
        </select>
      </div>
      <div class="col-md-2">
        <label class="form-label">Location</label>
        <select class="form-select">
          <option value="">All Locations</option>
          <option value="home">Home Page</option>
          <option value="category">Category Page</option>
          <option value="product">Product Page</option>
        </select>
      </div>
      <div class="col-md-2">
        <label class="form-label">Campaign</label>
        <select class="form-select">
          <option value="">All Campaigns</option>
          <option value="1">Holiday Sale</option>
          <option value="2">New Products</option>
        </select>
      </div>
      <div class="col-md-2">
        <label class="form-label">Date</label>
        <input type="date" class="form-control">
      </div>
      <div class="col-md-1 d-flex align-items-end">
        <button class="btn btn-primary w-100">Filter</button>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Placement</th>
                <th>Location</th>
                <th>Campaign</th>
                <th>Impressions</th>
                <th>Clicks</th>
                <th>CTR</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" class="text-primary">
                        <path d="M4 4h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"/>
                      </svg>
                    </div>
                    <div>
                      <div class="fw-semibold">Hero Banner</div>
                      <div class="text-muted small">Main banner placement</div>
                    </div>
                  </div>
                </td>
                <td>
                  <span class="badge bg-primary">Home Page</span>
                </td>
                <td>
                  <div class="fw-semibold">Holiday Sale</div>
                  <div class="text-muted small">Dec 1 - Dec 31</div>
                </td>
                <td>
                  <div class="fw-semibold">12,450</div>
                </td>
                <td>
                  <div class="fw-semibold">1,234</div>
                </td>
                <td>
                  <div class="fw-semibold text-success">9.9%</div>
                </td>
                <td>
                  <span class="badge bg-success">Active</span>
                </td>
                <td>
                  <div class="btn-group btn-group-sm">
                    <button class="btn btn-outline-primary" title="View">
                      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                      </svg>
                    </button>
                    <button class="btn btn-outline-primary" title="Edit">
                      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                      </svg>
                    </button>
                    <button class="btn btn-outline-danger" title="Delete">
                      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                      </svg>
                    </button>
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="bg-info bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" class="text-info">
                        <path d="M4 4h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"/>
                      </svg>
                    </div>
                    <div>
                      <div class="fw-semibold">Sidebar Ad</div>
                      <div class="text-muted small">Right sidebar placement</div>
                    </div>
                  </div>
                </td>
                <td>
                  <span class="badge bg-info">Category Page</span>
                </td>
                <td>
                  <div class="fw-semibold">New Products</div>
                  <div class="text-muted small">Nov 15 - Dec 15</div>
                </td>
                <td>
                  <div class="fw-semibold">8,920</div>
                </td>
                <td>
                  <div class="fw-semibold">456</div>
                </td>
                <td>
                  <div class="fw-semibold text-warning">5.1%</div>
                </td>
                <td>
                  <span class="badge bg-success">Active</span>
                </td>
                <td>
                  <div class="btn-group btn-group-sm">
                    <button class="btn btn-outline-primary" title="View">
                      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                      </svg>
                    </button>
                    <button class="btn btn-outline-primary" title="Edit">
                      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                      </svg>
                    </button>
                    <button class="btn btn-outline-danger" title="Delete">
                      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                      </svg>
                    </button>
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" class="text-warning">
                        <path d="M4 4h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"/>
                      </svg>
                    </div>
                    <div>
                      <div class="fw-semibold">Product Banner</div>
                      <div class="text-muted small">Product page placement</div>
                    </div>
                  </div>
                </td>
                <td>
                  <span class="badge bg-warning">Product Page</span>
                </td>
                <td>
                  <div class="fw-semibold">Tech Promotion</div>
                  <div class="text-muted small">Dec 10 - Jan 10</div>
                </td>
                <td>
                  <div class="fw-semibold">0</div>
                </td>
                <td>
                  <div class="fw-semibold">0</div>
                </td>
                <td>
                  <div class="fw-semibold text-muted">-</div>
                </td>
                <td>
                  <span class="badge bg-warning">Scheduled</span>
                </td>
                <td>
                  <div class="btn-group btn-group-sm">
                    <button class="btn btn-outline-primary" title="View">
                      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                      </svg>
                    </button>
                    <button class="btn btn-outline-primary" title="Edit">
                      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                      </svg>
                    </button>
                    <button class="btn btn-outline-danger" title="Delete">
                      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                      </svg>
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  
  <div class="col-lg-4">
    <div class="card">
      <div class="card-header">
        <h6 class="mb-0">Placement Statistics</h6>
      </div>
      <div class="card-body">
        <div class="row g-3">
          <div class="col-6">
            <div class="text-center">
              <div class="h4 text-primary mb-1">3</div>
              <div class="text-muted small">Total Placements</div>
            </div>
          </div>
          <div class="col-6">
            <div class="text-center">
              <div class="h4 text-success mb-1">2</div>
              <div class="text-muted small">Active</div>
            </div>
          </div>
          <div class="col-6">
            <div class="text-center">
              <div class="h4 text-warning mb-1">1</div>
              <div class="text-muted small">Scheduled</div>
            </div>
          </div>
          <div class="col-6">
            <div class="text-center">
              <div class="h4 text-info mb-1">21,370</div>
              <div class="text-muted small">Total Impressions</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="card mt-3">
      <div class="card-header">
        <h6 class="mb-0">Quick Actions</h6>
      </div>
      <div class="card-body">
        <div class="d-grid gap-2">
          <button class="btn btn-outline-primary btn-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-1">
              <path d="M3 13h2v8H3v-8zm8-6h2v14h-2V7zM19 3h2v18h-2V3z"/>
            </svg>
            View Campaigns
          </button>
          <button class="btn btn-outline-info btn-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-1">
              <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
            </svg>
            Performance Report
          </button>
          <button class="btn btn-outline-success btn-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-1">
              <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
            </svg>
            Preview Ads
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Add Placement Modal -->
<div class="modal fade" id="addPlacementModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New Placement</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label class="form-label">Placement Name</label>
            <input type="text" class="form-control" placeholder="Enter placement name">
          </div>
          <div class="mb-3">
            <label class="form-label">Location</label>
            <select class="form-select">
              <option value="">Select location</option>
              <option value="home">Home Page</option>
              <option value="category">Category Page</option>
              <option value="product">Product Page</option>
              <option value="checkout">Checkout Page</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Campaign</label>
            <select class="form-select">
              <option value="">Select campaign</option>
              <option value="1">Holiday Sale</option>
              <option value="2">New Products</option>
              <option value="3">Tech Promotion</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Position</label>
            <select class="form-select">
              <option value="">Select position</option>
              <option value="top">Top</option>
              <option value="middle">Middle</option>
              <option value="bottom">Bottom</option>
              <option value="sidebar">Sidebar</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Size</label>
            <select class="form-select">
              <option value="">Select size</option>
              <option value="728x90">728x90 (Leaderboard)</option>
              <option value="300x250">300x250 (Medium Rectangle)</option>
              <option value="160x600">160x600 (Wide Skyscraper)</option>
              <option value="320x50">320x50 (Mobile Banner)</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary">Add Placement</button>
      </div>
    </div>
  </div>
</div>
@endsection
