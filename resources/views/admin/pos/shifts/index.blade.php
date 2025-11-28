@extends('layouts.admin')

@section('title', 'Shifts Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h1 class="h3 mb-0">Shifts Management</h1>
  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#openShiftModal">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-1">
      <path d="M8 5v14l11-7z"/>
    </svg>
    Open Shift
  </button>
</div>

<!-- Filters -->
<div class="card mb-4">
  <div class="card-body">
    <div class="row g-3">
      <div class="col-md-3">
        <label class="form-label">Search</label>
        <input type="text" class="form-control" placeholder="Search shifts...">
      </div>
      <div class="col-md-2">
        <label class="form-label">Status</label>
        <select class="form-select">
          <option value="">All Status</option>
          <option value="open">Open</option>
          <option value="closed">Closed</option>
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
      <div class="col-md-2">
        <label class="form-label">User</label>
        <select class="form-select">
          <option value="">All Users</option>
          <option value="1">John Smith</option>
          <option value="2">Sarah Johnson</option>
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
            <th>Shift</th>
            <th>Register</th>
            <th>User</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <div class="fw-semibold">#SH-2024-001</div>
              <div class="text-muted small">Morning Shift</div>
            </td>
            <td>
              <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="text-primary">
                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                  </svg>
                </div>
                <div>
                  <div class="fw-semibold">Register #1</div>
                  <div class="text-muted small">Main Counter</div>
                </div>
              </div>
            </td>
            <td>
              <div class="d-flex align-items-center">
                <div class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                  </svg>
                </div>
                <div>
                  <div class="fw-semibold">John Smith</div>
                  <div class="text-muted small">Cashier</div>
                </div>
              </div>
            </td>
            <td>
              <div class="fw-semibold">9:00 AM</div>
              <div class="text-muted small">Dec 15, 2024</div>
            </td>
            <td>
              <div class="fw-semibold">-</div>
              <div class="text-muted small">Still open</div>
            </td>
            <td>
              <span class="badge bg-success">Open</span>
            </td>
            <td>
              <div class="btn-group btn-group-sm">
                <button class="btn btn-outline-primary" title="View">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                  </svg>
                </button>
                <button class="btn btn-outline-warning" title="Close Shift">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                  </svg>
                </button>
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <div class="fw-semibold">#SH-2024-002</div>
              <div class="text-muted small">Afternoon Shift</div>
            </td>
            <td>
              <div class="d-flex align-items-center">
                <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="text-success">
                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                  </svg>
                </div>
                <div>
                  <div class="fw-semibold">Register #2</div>
                  <div class="text-muted small">Express Counter</div>
                </div>
              </div>
            </td>
            <td>
              <div class="d-flex align-items-center">
                <div class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                  </svg>
                </div>
                <div>
                  <div class="fw-semibold">Sarah Johnson</div>
                  <div class="text-muted small">Cashier</div>
                </div>
              </div>
            </td>
            <td>
              <div class="fw-semibold">1:00 PM</div>
              <div class="text-muted small">Dec 15, 2024</div>
            </td>
            <td>
              <div class="fw-semibold">-</div>
              <div class="text-muted small">Still open</div>
            </td>
            <td>
              <span class="badge bg-success">Open</span>
            </td>
            <td>
              <div class="btn-group btn-group-sm">
                <button class="btn btn-outline-primary" title="View">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                  </svg>
                </button>
                <button class="btn btn-outline-warning" title="Close Shift">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                  </svg>
                </button>
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <div class="fw-semibold">#SH-2024-003</div>
              <div class="text-muted small">Evening Shift</div>
            </td>
            <td>
              <div class="d-flex align-items-center">
                <div class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="text-secondary">
                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                  </svg>
                </div>
                <div>
                  <div class="fw-semibold">Register #3</div>
                  <div class="text-muted small">Service Counter</div>
                </div>
              </div>
            </td>
            <td>
              <div class="d-flex align-items-center">
                <div class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                  </svg>
                </div>
                <div>
                  <div class="fw-semibold">Mike Wilson</div>
                  <div class="text-muted small">Cashier</div>
                </div>
              </div>
            </td>
            <td>
              <div class="fw-semibold">5:00 PM</div>
              <div class="text-muted small">Dec 14, 2024</div>
            </td>
            <td>
              <div class="fw-semibold">9:00 PM</div>
              <div class="text-muted small">Dec 14, 2024</div>
            </td>
            <td>
              <span class="badge bg-secondary">Closed</span>
            </td>
            <td>
              <div class="btn-group btn-group-sm">
                <button class="btn btn-outline-primary" title="View">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                  </svg>
                </button>
                <button class="btn btn-outline-info" title="Print Report" onclick="window.print()">
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
    <nav aria-label="Shifts pagination" class="mt-4">
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

<!-- Open Shift Modal -->
<div class="modal fade" id="openShiftModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Open New Shift</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label class="form-label">Register</label>
            <select class="form-select">
              <option value="">Select register</option>
              <option value="1">Register #1 - Main Counter</option>
              <option value="2">Register #2 - Express Counter</option>
              <option value="3">Register #3 - Service Counter</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">User</label>
            <select class="form-select">
              <option value="">Select user</option>
              <option value="1">John Smith</option>
              <option value="2">Sarah Johnson</option>
              <option value="3">Mike Wilson</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Initial Cash</label>
            <input type="number" class="form-control" placeholder="0.00" step="0.01">
          </div>
          <div class="mb-3">
            <label class="form-label">Notes</label>
            <textarea class="form-control" rows="3" placeholder="Enter shift notes"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary">Open Shift</button>
      </div>
    </div>
  </div>
</div>
@endsection
