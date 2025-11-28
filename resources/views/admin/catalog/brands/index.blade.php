@extends('layouts.admin')

@section('title', 'Brands Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h1 class="h3 mb-0">Brands Management</h1>
  <a href="{{ route('admin.catalog.brands.create') }}" class="btn btn-primary">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-1">
      <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
    </svg>
    Add Brand
  </a>
</div>

<!-- Filters -->
<div class="card mb-4">
  <div class="card-body">
    <form method="GET" action="{{ route('admin.catalog.brands.index') }}">
      <div class="row g-3">
        <div class="col-md-4">
          <label class="form-label">Search</label>
          <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Search brands...">
        </div>
        <div class="col-md-3">
          <label class="form-label">Status</label>
          <select class="form-select" name="status">
            <option value="">All Status</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
          </select>
        </div>
        <div class="col-md-3 d-flex align-items-end">
          <button type="submit" class="btn btn-primary me-2">Filter</button>
              <a href="{{ route('admin.catalog.brands.index') }}" class="btn btn-outline-secondary">Reset</a>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Logo</th>
            <th>Name</th>
            <th>Description</th>
            <th>Products</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($brands as $brand)
          <tr>
            <td>
              <div class="d-flex align-items-center">
                @if($brand->logo)
                  <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}" class="rounded me-2" width="40" height="40">
                @else
                  <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                    <span class="text-primary fw-bold">{{ substr($brand->name, 0, 1) }}</span>
                  </div>
                @endif
              </div>
            </td>
            <td>
              <div class="fw-semibold">{{ $brand->name }}</div>
              @if($brand->website)
                <div class="text-muted small">
                  <a href="{{ $brand->website }}" target="_blank" class="text-decoration-none">{{ $brand->website }}</a>
                </div>
              @endif
            </td>
            <td>
              <div class="text-muted small">{{ $brand->description ?: 'No description' }}</div>
            </td>
            <td>
              <span class="badge bg-primary">{{ $brand->products_count }}</span>
            </td>
            <td>
              <span class="badge bg-{{ $brand->is_active ? 'success' : 'secondary' }}">
                {{ $brand->is_active ? 'Active' : 'Inactive' }}
              </span>
            </td>
            <td>
              <div class="btn-group btn-group-sm">
                <a href="{{ route('admin.catalog.brands.show', $brand) }}" class="btn btn-outline-primary" title="View">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                  </svg>
                </a>
                <a href="{{ route('admin.catalog.brands.edit', $brand) }}" class="btn btn-outline-primary" title="Edit">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                  </svg>
                </a>
                <form method="POST" action="{{ route('admin.catalog.brands.destroy', $brand) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this brand?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-outline-danger" title="Delete">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                      <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                    </svg>
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center py-4">
              <div class="text-muted">No brands found.</div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Add Brand Modal -->
<div class="modal fade" id="addBrandModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New Brand</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label class="form-label">Brand Name</label>
            <input type="text" class="form-control" placeholder="Enter brand name">
          </div>
          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" rows="3" placeholder="Enter brand description"></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Logo</label>
            <input type="file" class="form-control" accept="image/*">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary">Add Brand</button>
      </div>
    </div>
    
    <!-- Pagination -->
    @if($brands->hasPages())
    <div class="d-flex justify-content-between align-items-center mt-4">
      <div class="text-muted small">
        Showing {{ $brands->firstItem() }} to {{ $brands->lastItem() }} of {{ $brands->total() }} results
      </div>
      <div>
        {{ $brands->links() }}
      </div>
    </div>
    @endif
  </div>
</div>
@endsection
