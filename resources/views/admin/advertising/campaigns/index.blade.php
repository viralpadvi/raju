@extends('layouts.admin')

@section('title', 'Ad Campaigns')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h1 class="h3 mb-0">Ad Campaigns</h1>
  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCampaignModal">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-1">
      <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
    </svg>
    Create Campaign
  </button>
</div>

<!-- Filters -->
<div class="card mb-4">
  <div class="card-body">
    <div class="row g-3">
      <div class="col-md-3">
        <label class="form-label">Search</label>
        <input type="text" class="form-control" placeholder="Search campaigns...">
      </div>
      <div class="col-md-2">
        <label class="form-label">Status</label>
        <select class="form-select">
          <option value="">All Status</option>
          <option value="active">Active</option>
          <option value="paused">Paused</option>
          <option value="completed">Completed</option>
          <option value="draft">Draft</option>
        </select>
      </div>
      <div class="col-md-2">
        <label class="form-label">Type</label>
        <select class="form-select">
          <option value="">All Types</option>
          <option value="banner">Banner</option>
          <option value="video">Video</option>
          <option value="popup">Popup</option>
        </select>
      </div>
      <div class="col-md-2">
        <label class="form-label">Date From</label>
        <input type="date" class="form-control">
      </div>
      <div class="col-md-2">
        <label class="form-label">Date To</label>
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
                <th>Campaign</th>
                <th>Type</th>
                <th>Duration</th>
                <th>Budget</th>
                <th>Spent</th>
                <th>Impressions</th>
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
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                      </svg>
                    </div>
                    <div>
                      <div class="fw-semibold">Holiday Sale 2024</div>
                      <div class="text-muted small">Christmas promotion campaign</div>
                    </div>
                  </div>
                </td>
                <td>
                  <span class="badge bg-primary">Banner</span>
                </td>
                <td>
                  <div class="fw-semibold">Dec 1 - Dec 31</div>
                  <div class="text-muted small">31 days</div>
                </td>
                <td>
                  <div class="fw-semibold">$5,000</div>
                </td>
                <td>
                  <div class="fw-semibold">$2,450</div>
                  <div class="text-muted small">49% used</div>
                </td>
                <td>
                  <div class="fw-semibold">45,230</div>
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
                    <button class="btn btn-outline-warning" title="Pause">
                      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>
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
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                      </svg>
                    </div>
                    <div>
                      <div class="fw-semibold">New Product Launch</div>
                      <div class="text-muted small">iPhone 15 Pro promotion</div>
                    </div>
                  </div>
                </td>
                <td>
                  <span class="badge bg-info">Video</span>
                </td>
                <td>
                  <div class="fw-semibold">Nov 15 - Dec 15</div>
                  <div class="text-muted small">30 days</div>
                </td>
                <td>
                  <div class="fw-semibold">$3,000</div>
                </td>
                <td>
                  <div class="fw-semibold">$3,000</div>
                  <div class="text-muted small">100% used</div>
                </td>
                <td>
                  <div class="fw-semibold">28,150</div>
                </td>
                <td>
                  <span class="badge bg-secondary">Completed</span>
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
                    <button class="btn btn-outline-info" title="Duplicate">
                      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12V1zm3 4H8c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zm0 16H8V7h11v14z"/>
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
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                      </svg>
                    </div>
                    <div>
                      <div class="fw-semibold">Tech Promotion</div>
                      <div class="text-muted small">Electronics discount campaign</div>
                    </div>
                  </div>
                </td>
                <td>
                  <span class="badge bg-warning">Popup</span>
                </td>
                <td>
                  <div class="fw-semibold">Dec 10 - Jan 10</div>
                  <div class="text-muted small">32 days</div>
                </td>
                <td>
                  <div class="fw-semibold">$2,500</div>
                </td>
                <td>
                  <div class="fw-semibold">$0</div>
                  <div class="text-muted small">0% used</div>
                </td>
                <td>
                  <div class="fw-semibold">0</div>
                </td>
                <td>
                  <span class="badge bg-warning">Draft</span>
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
                    <button class="btn btn-outline-success" title="Activate">
                      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M8 5v14l11-7z"/>
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
        <h6 class="mb-0">Campaign Statistics</h6>
      </div>
      <div class="card-body">
        <div class="row g-3">
          <div class="col-6">
            <div class="text-center">
              <div class="h4 text-primary mb-1">3</div>
              <div class="text-muted small">Total Campaigns</div>
            </div>
          </div>
          <div class="col-6">
            <div class="text-center">
              <div class="h4 text-success mb-1">1</div>
              <div class="text-muted small">Active</div>
            </div>
          </div>
          <div class="col-6">
            <div class="text-center">
              <div class="h4 text-secondary mb-1">1</div>
              <div class="text-muted small">Completed</div>
            </div>
          </div>
          <div class="col-6">
            <div class="text-center">
              <div class="h4 text-warning mb-1">1</div>
              <div class="text-muted small">Draft</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="card mt-3">
      <div class="card-header">
        <h6 class="mb-0">Performance Overview</h6>
      </div>
      <div class="card-body">
        <div class="mb-3">
          <div class="d-flex justify-content-between align-items-center mb-1">
            <span class="small text-muted">Total Budget</span>
            <span class="fw-semibold">$10,500</span>
          </div>
          <div class="d-flex justify-content-between align-items-center mb-1">
            <span class="small text-muted">Total Spent</span>
            <span class="fw-semibold">$5,450</span>
          </div>
          <div class="d-flex justify-content-between align-items-center mb-1">
            <span class="small text-muted">Total Impressions</span>
            <span class="fw-semibold">73,380</span>
          </div>
          <div class="d-flex justify-content-between align-items-center">
            <span class="small text-muted">Total Clicks</span>
            <span class="fw-semibold">1,690</span>
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
            View Placements
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
            Preview Campaign
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Add Campaign Modal -->
<div class="modal fade" id="addCampaignModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Create New Campaign</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Campaign Name</label>
                <input type="text" class="form-control" placeholder="Enter campaign name">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Type</label>
                <select class="form-select">
                  <option value="">Select type</option>
                  <option value="banner">Banner</option>
                  <option value="video">Video</option>
                  <option value="popup">Popup</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Start Date</label>
                <input type="date" class="form-control">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">End Date</label>
                <input type="date" class="form-control">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Budget</label>
                <input type="number" class="form-control" placeholder="0.00" step="0.01">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Daily Budget</label>
                <input type="number" class="form-control" placeholder="0.00" step="0.01">
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" rows="3" placeholder="Enter campaign description"></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Target Audience</label>
            <select class="form-select">
              <option value="">Select audience</option>
              <option value="all">All Users</option>
              <option value="new">New Customers</option>
              <option value="returning">Returning Customers</option>
              <option value="mobile">Mobile Users</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary">Create Campaign</button>
      </div>
    </div>
  </div>
</div>
@endsection
