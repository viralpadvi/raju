@extends('layouts.storefront')

@section('title', 'Projects - Portfolio')

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Projects</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold mb-3">Our Projects</h1>
        <p class="lead text-muted">Explore our portfolio of successful projects and innovative solutions</p>
    </div>

    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Filters</h6>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('projects.index') }}">
                        <!-- Search -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Search</label>
                            <input type="text" class="form-control form-control-sm" name="search" value="{{ request('search') }}" placeholder="Search projects...">
                        </div>

                        <!-- Category Filter -->
                        @if($categories->count() > 0)
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Category</label>
                            <select class="form-select form-select-sm" name="category">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>{{ $category }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        <!-- Status Filter -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Status</label>
                            <select class="form-select form-select-sm" name="status">
                                <option value="">All Status</option>
                                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="on_hold" {{ request('status') === 'on_hold' ? 'selected' : '' }}>On Hold</option>
                            </select>
                        </div>

                        <!-- Tags Filter -->
                        @if($allTags && $allTags->count() > 0)
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Tags</label>
                            <select class="form-select form-select-sm" name="tag">
                                <option value="">All Tags</option>
                                @foreach($allTags as $tag)
                                <option value="{{ $tag }}" {{ request('tag') === $tag ? 'selected' : '' }}>{{ $tag }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-sm">Apply Filters</button>
                            @if(request()->anyFilled(['search', 'category', 'status', 'tag']))
                            <a href="{{ route('projects.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Projects Grid -->
        <div class="col-lg-9">
            <!-- Results Count -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <span class="text-muted">Showing {{ $projects->firstItem() ?? 0 }}-{{ $projects->lastItem() ?? 0 }} of {{ $projects->total() }} projects</span>
                </div>
                <div>
                    <select class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                        <option value="featured" {{ request('sort') === 'featured' ? 'selected' : '' }}>Sort by: Featured</option>
                        <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest First</option>
                        <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest First</option>
                    </select>
                </div>
            </div>

            <!-- Projects Grid -->
            @if($projects->count() > 0)
            <div class="row g-4">
                @foreach($projects as $project)
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm hover-shadow">
                        <div class="position-relative">
                            @if($project->images && count($project->images) > 0)
                                <img src="{{ asset('storage/' . $project->images[0]) }}" class="card-img-top" alt="{{ $project->name }}" style="height: 250px; object-fit: cover;">
                                @if(count($project->images) > 1)
                                <span class="badge bg-dark position-absolute top-0 end-0 m-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" class="me-1">
                                        <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                                    </svg>
                                    {{ count($project->images) }} images
                                </span>
                                @endif
                            @else
                                <div class="card-img-top bg-gradient-primary d-flex align-items-center justify-content-center" style="height: 250px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="opacity-50">
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
                            </div>
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
                            <div class="position-absolute bottom-0 end-0 m-2">
                                <span class="badge bg-{{ $statusColor }}">
                                    {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                                </span>
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">
                                <a href="{{ route('projects.show', $project->slug) }}" class="text-decoration-none text-dark">
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
                            <p class="card-text text-muted small mb-3">{{ Str::limit($project->description, 120) }}</p>
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
                            @if($project->start_date && $project->end_date)
                            <p class="text-muted small mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                                {{ \Carbon\Carbon::parse($project->start_date)->format('M Y') }} - {{ \Carbon\Carbon::parse($project->end_date)->format('M Y') }}
                            </p>
                            @endif
                            <div class="mt-auto">
                                <a href="{{ route('projects.show', $project->slug) }}" class="btn btn-primary btn-sm w-100">
                                    View Project Details
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ms-1">
                                        <polyline points="9 18 15 12 9 6"></polyline>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <nav aria-label="Projects pagination" class="mt-5">
                {{ $projects->links() }}
            </nav>
            @else
            <div class="text-center py-5">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-muted mb-3">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                </svg>
                <h5 class="text-muted">No projects found</h5>
                <p class="text-muted">Try adjusting your filters or search terms.</p>
            </div>
            @endif
        </div>
    </div>
</div>
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

