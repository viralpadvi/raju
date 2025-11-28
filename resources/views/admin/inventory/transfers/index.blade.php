@extends('layouts.admin')

@section('title', 'Stock Transfers')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h1 class="h3 mb-0">Stock Transfers</h1>
  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTransferModal">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-1">
      <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
    </svg>
    New Transfer
  </button>
</div>

<!-- Filters -->
<div class="card mb-4">
  <div class="card-body">
    <div class="row g-3">
      <div class="col-md-3">
        <label class="form-label">Search</label>
        <input type="text" class="form-control" placeholder="Search transfers...">
      </div>
      <div class="col-md-2">
        <label class="form-label">Status</label>
        <select class="form-select">
          <option value="">All Status</option>
          <option value="pending">Pending</option>
          <option value="in_transit">In Transit</option>
          <option value="completed">Completed</option>
          <option value="cancelled">Cancelled</option>
        </select>
      </div>
      <div class="col-md-2">
        <label class="form-label">From Branch</label>
        <select class="form-select">
          <option value="">All Branches</option>
          <option value="1">Main Branch</option>
          <option value="2">Branch 2</option>
        </select>
      </div>
      <div class="col-md-2">
        <label class="form-label">To Branch</label>
        <select class="form-select">
          <option value="">All Branches</option>
          <option value="1">Main Branch</option>
          <option value="2">Branch 2</option>
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

<div class="card">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Transfer #</th>
            <th>From Branch</th>
            <th>To Branch</th>
            <th>Items</th>
            <th>Date</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <div class="fw-semibold">#ST-2024-001</div>
              <div class="text-muted small">Stock Transfer</div>
            </td>
            <td>
              <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="text-primary">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                  </svg>
                </div>
                <div>
                  <div class="fw-semibold">Main Branch</div>
                  <div class="text-muted small">Headquarters</div>
                </div>
              </div>
            </td>
            <td>
              <div class="d-flex align-items-center">
                <div class="bg-info bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="text-info">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                  </svg>
                </div>
                <div>
                  <div class="fw-semibold">Branch 2</div>
                  <div class="text-muted small">Downtown Location</div>
                </div>
              </div>
            </td>
            <td>
              <span class="badge bg-primary">5 items</span>
            </td>
            <td>
              <div class="fw-semibold">Dec 15, 2024</div>
              <div class="text-muted small">2 days ago</div>
            </td>
            <td>
              <span class="badge bg-warning">In Transit</span>
            </td>
            <td>
              <div class="btn-group btn-group-sm">
                <button class="btn btn-outline-primary" title="View">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                  </svg>
                </button>
                <button class="btn btn-outline-success" title="Complete">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                  </svg>
                </button>
                <button class="btn btn-outline-danger" title="Cancel">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                  </svg>
                </button>
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <div class="fw-semibold">#ST-2024-002</div>
              <div class="text-muted small">Stock Transfer</div>
            </td>
            <td>
              <div class="d-flex align-items-center">
                <div class="bg-info bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="text-info">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                  </svg>
                </div>
                <div>
                  <div class="fw-semibold">Branch 2</div>
                  <div class="text-muted small">Downtown Location</div>
                </div>
              </div>
            </td>
            <td>
              <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="text-primary">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                  </svg>
                </div>
                <div>
                  <div class="fw-semibold">Main Branch</div>
                  <div class="text-muted small">Headquarters</div>
                </div>
              </div>
            </td>
            <td>
              <span class="badge bg-primary">3 items</span>
            </td>
            <td>
              <div class="fw-semibold">Dec 10, 2024</div>
              <div class="text-muted small">1 week ago</div>
            </td>
            <td>
              <span class="badge bg-success">Completed</span>
            </td>
            <td>
              <div class="btn-group btn-group-sm">
                <button class="btn btn-outline-primary" title="View">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                  </svg>
                </button>
                <button class="btn btn-outline-info" title="Print" onclick="window.print()">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 6 2 18 2 18 9"></polyline>
                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                    <rect x="6" y="14" width="12" height="8"></rect>
                  </svg>
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    
    <!-- Pagination -->
    <nav aria-label="Transfers pagination" class="mt-4">
      <ul class="pagination justify-content-center">
        <li class="page-item disabled">
          <span class="page-link">Previous</span>
        </li>
        <li class="page-item active">
          <span class="page-link">1</span>
        </li>
        <li class="page-item">
          <a class="page-link" href="#">2</a>
        </li>
        <li class="page-item">
          <a class="page-link" href="#">3</a>
        </li>
        <li class="page-item">
          <a class="page-link" href="#">Next</a>
        </li>
      </ul>
    </nav>
  </div>
</div>

<!-- Add Transfer Modal -->
<div class="modal fade" id="addTransferModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Create New Stock Transfer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">From Branch</label>
                <select class="form-select">
                  <option value="">Select source branch</option>
                  <option value="1">Main Branch</option>
                  <option value="2">Branch 2</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">To Branch</label>
                <select class="form-select">
                  <option value="">Select destination branch</option>
                  <option value="1">Main Branch</option>
                  <option value="2">Branch 2</option>
                </select>
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Notes</label>
            <textarea class="form-control" rows="3" placeholder="Enter transfer notes"></textarea>
          </div>
          
          <!-- Items Section -->
          <div class="mb-3">
            <label class="form-label">Items to Transfer</label>
            <div class="border rounded p-3">
              <div class="row g-3">
                <div class="col-md-5">
                  <label class="form-label">Product</label>
                  <select class="form-select">
                    <option value="">Select product</option>
                    <option value="1">iPhone 15 Pro</option>
                    <option value="2">MacBook Pro M3</option>
                  </select>
                </div>
                <div class="col-md-2">
                  <label class="form-label">Available</label>
                  <input type="number" class="form-control" placeholder="0" readonly>
                </div>
                <div class="col-md-2">
                  <label class="form-label">Transfer Qty</label>
                  <input type="number" class="form-control" placeholder="0">
                </div>
                <div class="col-md-2">
                  <label class="form-label">Reason</label>
                  <select class="form-select">
                    <option value="">Select reason</option>
                    <option value="restock">Restock</option>
                    <option value="sale">Sale</option>
                    <option value="return">Return</option>
                  </select>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                  <button type="button" class="btn btn-outline-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                      <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                    </svg>
                  </button>
                </div>
              </div>
              <div class="mt-3">
                <button type="button" class="btn btn-outline-primary btn-sm">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-1">
                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                  </svg>
                  Add Item
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary">Create Transfer</button>
      </div>
    </div>
  </div>
</div>
@endsection
