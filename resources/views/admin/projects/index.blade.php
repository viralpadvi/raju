@extends('layouts.admin')

@section('title', 'Projects Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h1 class="h3 mb-0">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-2">
      <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
    </svg>
    Projects Management
  </h1>
  <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-1">
      <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
    </svg>
    Add Project
  </a>
</div>

<!-- Filters -->
<div class="card mb-4 border-0 shadow-sm">
  <div class="card-body">
    <form method="GET" action="{{ route('admin.projects.index') }}">
      <div class="row g-3">
        <div class="col-md-3">
          <label class="form-label">Search</label>
          <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Search projects...">
        </div>
        <div class="col-md-2">
          <label class="form-label">Status</label>
          <select class="form-select" name="status">
            <option value="">All Status</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="on_hold" {{ request('status') === 'on_hold' ? 'selected' : '' }}>On Hold</option>
            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label">Category</label>
          <input type="text" class="form-control" name="category" value="{{ request('category') }}" placeholder="Category...">
        </div>
        <div class="col-md-2">
          <label class="form-label">Active</label>
          <select class="form-select" name="is_active">
            <option value="">All</option>
            <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Active</option>
            <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Inactive</option>
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label">Featured</label>
          <select class="form-select" name="is_featured">
            <option value="">All</option>
            <option value="1" {{ request('is_featured') === '1' ? 'selected' : '' }}>Featured</option>
            <option value="0" {{ request('is_featured') === '0' ? 'selected' : '' }}>Not Featured</option>
          </select>
        </div>
        <div class="col-md-1 d-flex align-items-end">
          <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>
      </div>
      @if(request()->anyFilled(['search', 'status', 'category', 'is_active', 'is_featured']))
      <div class="mt-3">
        <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary btn-sm">Reset Filters</a>
      </div>
      @endif
    </form>
  </div>
</div>

<!-- Projects Grid -->
@if($projects->count() > 0)
<div class="row g-4">
  @foreach($projects as $project)
  <div class="col-md-6 col-lg-4">
    <div class="card h-100 border-0 shadow-sm hover-shadow">
      <div class="position-relative">
        @if($project->images && count($project->images) > 0)
          <img src="{{ asset('storage/' . $project->images[0]) }}" class="card-img-top" alt="{{ $project->name }}" style="height: 200px; object-fit: cover;">
          @if(count($project->images) > 1)
          <span class="badge bg-dark position-absolute top-0 end-0 m-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
              <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
            </svg>
            {{ count($project->images) }} images
          </span>
          @endif
        @else
          <div class="card-img-top bg-gradient-primary d-flex align-items-center justify-content-center" style="height: 200px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white opacity-50">
              <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
            </svg>
          </div>
        @endif
        <div class="position-absolute top-0 start-0 m-2">
          @if($project->is_featured)
          <span class="badge bg-warning text-dark">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="currentColor" class="me-1">
              <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
            </svg>
            Featured
          </span>
          @endif
          <span class="badge bg-{{ $project->is_active ? 'success' : 'secondary' }}">
            {{ $project->is_active ? 'Active' : 'Inactive' }}
          </span>
        </div>
        <div class="position-absolute bottom-0 end-0 m-2">
          @php
            $statusColors = [
              'pending' => 'warning',
              'in_progress' => 'info',
              'completed' => 'success',
              'on_hold' => 'secondary',
              'cancelled' => 'danger'
            ];
            $statusColor = $statusColors[$project->status] ?? 'secondary';
          @endphp
          <span class="badge bg-{{ $statusColor }}">
            {{ ucfirst(str_replace('_', ' ', $project->status)) }}
          </span>
        </div>
      </div>
      <div class="card-body d-flex flex-column">
        <h5 class="card-title mb-2">
          <a href="{{ route('admin.projects.show', $project) }}" class="text-decoration-none text-dark">
            {{ $project->name }}
          </a>
        </h5>
        @if($project->client)
        <p class="text-muted small mb-2">
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
            <circle cx="12" cy="7" r="4"></circle>
          </svg>
          Client: {{ $project->client }}
        </p>
        @endif
        @if($project->description)
        <p class="card-text text-muted small mb-3">{{ Str::limit($project->description, 100) }}</p>
        @endif
        <div class="d-flex flex-wrap gap-2 mb-3">
          @if($project->category)
          <span class="badge bg-primary">{{ $project->category }}</span>
          @endif
          @if($project->tags && count($project->tags) > 0)
            @foreach(array_slice($project->tags, 0, 3) as $tag)
            <span class="badge bg-secondary">{{ $tag }}</span>
            @endforeach
            @if(count($project->tags) > 3)
            <span class="badge bg-light text-dark">+{{ count($project->tags) - 3 }} more</span>
            @endif
          @endif
        </div>
        <div class="mt-auto">
          <div class="d-flex justify-content-between align-items-center">
            <div class="btn-group btn-group-sm">
              <a href="{{ route('admin.projects.show', $project) }}" class="btn btn-outline-primary" title="View">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                </svg>
              </a>
              <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-outline-primary" title="Edit">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                </svg>
              </a>
              <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this project?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger" title="Delete">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                  </svg>
                </button>
              </form>
            </div>
            @if($project->start_date && $project->end_date)
            <small class="text-muted">
              {{ \Carbon\Carbon::parse($project->start_date)->format('M Y') }} - 
              {{ \Carbon\Carbon::parse($project->end_date)->format('M Y') }}
            </small>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
  @endforeach
</div>

<!-- Pagination -->
<div class="mt-4">
  {{ $projects->links() }}
</div>
@else
<div class="card border-0 shadow-sm">
  <div class="card-body text-center py-5">
    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-muted mb-3">
      <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
    </svg>
    <h5 class="text-muted">No projects found</h5>
    <p class="text-muted">Get started by creating your first project.</p>
    <a href="{{ route('admin.projects.create') }}" class="btn btn-primary mt-3">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-1">
        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
      </svg>
      Add Project
    </a>
  </div>
</div>
@endif
@endsection

@push('styles')
<style>
  .hover-shadow {
    transition: all 0.3s ease;
  }
  .hover-shadow:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
  }
  .bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  }
</style>
@endpush

