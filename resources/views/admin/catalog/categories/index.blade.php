@extends('layouts.admin')

@section('title', 'Categories Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h1 class="h3 mb-0">Categories Management</h1>
  <a href="{{ route('admin.catalog.categories.create') }}" class="btn btn-primary">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-1">
      <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
    </svg>
    Add Category
  </a>
</div>

<!-- Filters -->
<div class="card mb-4">
  <div class="card-body">
    <form method="GET" action="{{ route('admin.catalog.categories.index') }}">
      <div class="row g-3">
        <div class="col-md-4">
          <label class="form-label">Search</label>
          <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Search categories...">
        </div>
        <div class="col-md-3">
          <label class="form-label">Parent Category</label>
          <select class="form-select" name="parent_id">
            <option value="">All Categories</option>
            @foreach($parentCategories as $parent)
              <option value="{{ $parent->id }}" {{ request('parent_id') == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label">Status</label>
          <select class="form-select" name="status">
            <option value="">All Status</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
          </select>
        </div>
        <div class="col-md-2 d-flex align-items-end">
          <button type="submit" class="btn btn-primary me-2">Filter</button>
          <a href="{{ route('admin.catalog.categories.index') }}" class="btn btn-outline-secondary">Reset</a>
        </div>
      </div>
    </form>
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
                <th>Name</th>
                <th>Parent</th>
                <th>Products</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($categories as $category)
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    @if($category->image)
                      <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="rounded me-2" width="40" height="40">
                    @else
                      <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                        <span class="text-primary fw-bold">{{ substr($category->name, 0, 1) }}</span>
                      </div>
                    @endif
                    <div>
                      <div class="fw-semibold">{{ $category->name }}</div>
                      <div class="text-muted small">{{ $category->description ?: 'No description' }}</div>
                    </div>
                  </div>
                </td>
                <td>
                  @if($category->parent)
                    <span class="text-muted">{{ $category->parent->name }}</span>
                  @else
                    <span class="text-muted">-</span>
                  @endif
                </td>
                <td>
                  <span class="badge bg-primary">{{ $category->products_count }}</span>
                </td>
                <td>
                  <span class="badge bg-{{ $category->is_active ? 'success' : 'secondary' }}">
                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                  </span>
                </td>
                <td>
                  <div class="btn-group btn-group-sm">
                    <a href="{{ route('admin.catalog.categories.show', $category) }}" class="btn btn-outline-primary" title="View">
                      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                      </svg>
                    </a>
                    <a href="{{ route('admin.catalog.categories.edit', $category) }}" class="btn btn-outline-primary" title="Edit">
                      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                      </svg>
                    </a>
                    <form method="POST" action="{{ route('admin.catalog.categories.destroy', $category) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this category?')">
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
                <td colspan="5" class="text-center py-4">
                  <div class="text-muted">No categories found.</div>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        
        <!-- Pagination -->
        @if($categories->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-4">
          <div class="text-muted small">
            Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }} of {{ $categories->total() }} results
          </div>
          <div>
            {{ $categories->links() }}
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>
  
  <div class="col-lg-4">
    <div class="card">
      <div class="card-header">
        <h6 class="mb-0">Category Hierarchy</h6>
      </div>
      <div class="card-body">
        <div class="category-tree">
          @foreach($parentCategories as $parent)
          <div class="category-item">
            <div class="d-flex align-items-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-2">
                <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/>
              </svg>
              <span class="fw-semibold">{{ $parent->name }}</span>
              <span class="badge bg-primary ms-2">{{ $parent->products_count }}</span>
            </div>
            @if($parent->children->count() > 0)
            <div class="ms-4 mt-2">
              @foreach($parent->children as $child)
              <div class="category-item">
                <div class="d-flex align-items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-2">
                    <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/>
                  </svg>
                  <span>{{ $child->name }}</span>
                  <span class="badge bg-secondary ms-2">{{ $child->products_count }}</span>
                </div>
              </div>
              @endforeach
            </div>
            @endif
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
