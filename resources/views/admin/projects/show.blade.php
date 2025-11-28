@extends('layouts.admin')

@section('title', 'Project Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h1 class="h3 mb-0">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-2">
      <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
    </svg>
    Project Details
  </h1>
  <div class="d-flex gap-2">
    <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-primary">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-1">
        <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
      </svg>
      Edit Project
    </a>
    <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-1">
        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
      </svg>
      Back to Projects
    </a>
  </div>
</div>

<div class="row">
  <div class="col-lg-8">
    <!-- Project Information -->
    <div class="card mb-4 border-0 shadow-sm">
      <div class="card-header bg-white">
        <h5 class="card-title mb-0">Project Information</h5>
      </div>
      <div class="card-body">
        <h2 class="h4 mb-3">{{ $project->name }}</h2>
        
        @if($project->description)
        <div class="mb-4">
          <p class="text-muted">{{ $project->description }}</p>
        </div>
        @endif

        @if($project->details)
        <div class="mb-4">
          <h6 class="fw-semibold mb-2">Project Details</h6>
          <div class="text-muted">{!! nl2br(e($project->details)) !!}</div>
        </div>
        @endif

        @if($project->specification && count($project->specification) > 0)
        <div class="mb-4">
          <h6 class="fw-semibold mb-3">Specifications</h6>
          <div class="table-responsive">
            <table class="table table-bordered table-sm">
              <tbody>
                @foreach($project->specification as $key => $value)
                  @if(is_array($value))
                    <tr>
                      <td class="fw-semibold" style="width: 200px;">{{ $value['key'] ?? $key }}</td>
                      <td>{{ $value['value'] ?? '' }}</td>
                    </tr>
                  @else
                    <tr>
                      <td class="fw-semibold" style="width: 200px;">{{ $key }}</td>
                      <td>{{ $value }}</td>
                    </tr>
                  @endif
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        @endif
      </div>
    </div>

    <!-- Images -->
    @if($project->images && count($project->images) > 0)
    <div class="card mb-4 border-0 shadow-sm">
      <div class="card-header bg-white">
        <h5 class="card-title mb-0">Project Images</h5>
      </div>
      <div class="card-body">
        <div class="row g-3">
          @foreach($project->images as $image)
          <div class="col-md-4 col-sm-6">
            <a href="{{ asset('storage/' . $image) }}" data-lightbox="project-images">
              <img src="{{ asset('storage/' . $image) }}" class="img-fluid rounded shadow-sm" alt="Project Image" style="height: 200px; object-fit: cover; width: 100%; cursor: pointer;">
            </a>
          </div>
          @endforeach
        </div>
      </div>
    </div>
    @endif

    <!-- Videos -->
    @if(($project->videos && count($project->videos) > 0) || $project->youtube_link)
    <div class="card mb-4 border-0 shadow-sm">
      <div class="card-header bg-white">
        <h5 class="card-title mb-0">Project Videos</h5>
      </div>
      <div class="card-body">
        @if($project->youtube_link)
        <div class="mb-3">
          <h6 class="fw-semibold mb-2">YouTube Video</h6>
          <div class="ratio ratio-16x9">
            <iframe src="{{ str_replace('watch?v=', 'embed/', $project->youtube_link) }}" allowfullscreen></iframe>
          </div>
          <div class="mt-2">
            <a href="{{ $project->youtube_link }}" target="_blank" class="btn btn-sm btn-outline-primary">
              Watch on YouTube
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" class="ms-1">
                <path d="M14,3V5H17.59L7.76,14.83L9.17,16.24L19,6.41V10H21V3M19,19H5V5H12V3H5C3.89,3 3,3.9 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V12H19V19Z"/>
              </svg>
            </a>
          </div>
        </div>
        @endif

        @if($project->videos && count($project->videos) > 0)
        <div>
          <h6 class="fw-semibold mb-2">Project Videos</h6>
          <div class="row g-3">
            @foreach($project->videos as $video)
            <div class="col-md-6">
              <video src="{{ asset('storage/' . $video) }}" class="img-fluid rounded shadow-sm" controls style="width: 100%;"></video>
            </div>
            @endforeach
          </div>
        </div>
        @endif
      </div>
    </div>
    @endif

    <!-- Social Media & Links -->
    @if($project->website_link || $project->facebook_link || $project->twitter_link || $project->instagram_link || $project->linkedin_link || $project->github_link)
    <div class="card mb-4 border-0 shadow-sm">
      <div class="card-header bg-white">
        <h5 class="card-title mb-0">Links & Social Media</h5>
      </div>
      <div class="card-body">
        <div class="d-flex flex-wrap gap-2">
          @if($project->website_link)
          <a href="{{ $project->website_link }}" target="_blank" class="btn btn-outline-primary btn-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" class="me-1">
              <path d="M14,3V5H17.59L7.76,14.83L9.17,16.24L19,6.41V10H21V3M19,19H5V5H12V3H5C3.89,3 3,3.9 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V12H19V19Z"/>
            </svg>
            Website
          </a>
          @endif
          @if($project->facebook_link)
          <a href="{{ $project->facebook_link }}" target="_blank" class="btn btn-outline-primary btn-sm">
            Facebook
          </a>
          @endif
          @if($project->twitter_link)
          <a href="{{ $project->twitter_link }}" target="_blank" class="btn btn-outline-info btn-sm">
            Twitter
          </a>
          @endif
          @if($project->instagram_link)
          <a href="{{ $project->instagram_link }}" target="_blank" class="btn btn-outline-danger btn-sm">
            Instagram
          </a>
          @endif
          @if($project->linkedin_link)
          <a href="{{ $project->linkedin_link }}" target="_blank" class="btn btn-outline-primary btn-sm">
            LinkedIn
          </a>
          @endif
          @if($project->github_link)
          <a href="{{ $project->github_link }}" target="_blank" class="btn btn-outline-dark btn-sm">
            GitHub
          </a>
          @endif
        </div>
      </div>
    </div>
    @endif
  </div>

  <div class="col-lg-4">
    <!-- Project Status -->
    <div class="card mb-4 border-0 shadow-sm">
      <div class="card-header bg-white">
        <h5 class="card-title mb-0">Project Status</h5>
      </div>
      <div class="card-body">
        <div class="mb-3">
          <label class="form-label fw-semibold">Status:</label>
          <div>
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
            <span class="badge bg-{{ $statusColor }} fs-6">
              {{ ucfirst(str_replace('_', ' ', $project->status)) }}
            </span>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Priority:</label>
          <div>
            @php
              $priorityColors = [
                'low' => 'secondary',
                'medium' => 'info',
                'high' => 'warning',
                'urgent' => 'danger'
              ];
              $priorityColor = $priorityColors[$project->priority] ?? 'secondary';
            @endphp
            <span class="badge bg-{{ $priorityColor }} fs-6">
              {{ ucfirst($project->priority) }}
            </span>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Active:</label>
          <div>
            <span class="badge bg-{{ $project->is_active ? 'success' : 'secondary' }}">
              {{ $project->is_active ? 'Active' : 'Inactive' }}
            </span>
          </div>
        </div>

        @if($project->is_featured)
        <div class="mb-3">
          <label class="form-label fw-semibold">Featured:</label>
          <div>
            <span class="badge bg-warning text-dark">
              <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="currentColor" class="me-1">
                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
              </svg>
              Featured
            </span>
          </div>
        </div>
        @endif

        @if($project->category)
        <div class="mb-3">
          <label class="form-label fw-semibold">Category:</label>
          <div>
            <span class="badge bg-primary">{{ $project->category }}</span>
          </div>
        </div>
        @endif

        @if($project->tags && count($project->tags) > 0)
        <div class="mb-3">
          <label class="form-label fw-semibold">Tags:</label>
          <div class="d-flex flex-wrap gap-1">
            @foreach($project->tags as $tag)
            <span class="badge bg-secondary">{{ $tag }}</span>
            @endforeach
          </div>
        </div>
        @endif
      </div>
    </div>

    <!-- Client Information -->
    @if($project->client)
    <div class="card mb-4 border-0 shadow-sm">
      <div class="card-header bg-white">
        <h5 class="card-title mb-0">Client Information</h5>
      </div>
      <div class="card-body">
        <div class="text-center mb-3">
          @if($project->client_logo)
            <img src="{{ asset('storage/' . $project->client_logo) }}" alt="{{ $project->client }}" class="img-fluid rounded" style="max-height: 100px;">
          @endif
        </div>
        <h6 class="fw-semibold mb-2">{{ $project->client }}</h6>
        @if($project->client_website)
        <div>
          <a href="{{ $project->client_website }}" target="_blank" class="text-decoration-none small">
            {{ $project->client_website }}
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="currentColor" class="ms-1">
              <path d="M14,3V5H17.59L7.76,14.83L9.17,16.24L19,6.41V10H21V3M19,19H5V5H12V3H5C3.89,3 3,3.9 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V12H19V19Z"/>
            </svg>
          </a>
        </div>
        @endif
      </div>
    </div>
    @endif

    <!-- Project Details -->
    <div class="card mb-4 border-0 shadow-sm">
      <div class="card-header bg-white">
        <h5 class="card-title mb-0">Project Details</h5>
      </div>
      <div class="card-body">
        @if($project->budget)
        <div class="mb-3">
          <label class="form-label fw-semibold">Budget:</label>
          <div class="text-muted">₹{{ number_format($project->budget, 2) }}</div>
        </div>
        @endif

        @if($project->start_date)
        <div class="mb-3">
          <label class="form-label fw-semibold">Start Date:</label>
          <div class="text-muted">{{ \Carbon\Carbon::parse($project->start_date)->format('M d, Y') }}</div>
        </div>
        @endif

        @if($project->end_date)
        <div class="mb-3">
          <label class="form-label fw-semibold">End Date:</label>
          <div class="text-muted">{{ \Carbon\Carbon::parse($project->end_date)->format('M d, Y') }}</div>
        </div>
        @endif

        @if($project->start_date && $project->end_date)
        <div class="mb-3">
          <label class="form-label fw-semibold">Duration:</label>
          <div class="text-muted">
            {{ \Carbon\Carbon::parse($project->start_date)->diffInDays(\Carbon\Carbon::parse($project->end_date)) }} days
          </div>
        </div>
        @endif

        <div class="mb-3">
          <label class="form-label fw-semibold">Created:</label>
          <div class="text-muted">{{ $project->created_at->format('M d, Y \a\t g:i A') }}</div>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Updated:</label>
          <div class="text-muted">{{ $project->updated_at->format('M d, Y \a\t g:i A') }}</div>
        </div>
      </div>
    </div>

    <!-- SEO Information -->
    @if($project->meta_title || $project->meta_description || $project->meta_keywords)
    <div class="card mb-4 border-0 shadow-sm">
      <div class="card-header bg-white">
        <h5 class="card-title mb-0">SEO Information</h5>
      </div>
      <div class="card-body">
        @if($project->meta_title)
        <div class="mb-3">
          <label class="form-label fw-semibold small">Meta Title:</label>
          <div class="text-muted small">{{ $project->meta_title }}</div>
        </div>
        @endif

        @if($project->meta_description)
        <div class="mb-3">
          <label class="form-label fw-semibold small">Meta Description:</label>
          <div class="text-muted small">{{ $project->meta_description }}</div>
        </div>
        @endif

        @if($project->meta_keywords)
        <div class="mb-3">
          <label class="form-label fw-semibold small">Meta Keywords:</label>
          <div class="text-muted small">{{ $project->meta_keywords }}</div>
        </div>
        @endif
      </div>
    </div>
    @endif
  </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
@endpush

