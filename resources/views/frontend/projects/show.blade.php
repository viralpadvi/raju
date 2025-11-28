@extends('layouts.storefront')

@section('title', $project->name . ' - Project Details')

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">Projects</a></li>
            @if($project->category)
            <li class="breadcrumb-item"><a href="{{ route('projects.index', ['category' => $project->category]) }}">{{ $project->category }}</a></li>
            @endif
            <li class="breadcrumb-item active">{{ $project->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Project Images -->
        <div class="col-lg-7 mb-4">
            @if($project->images && count($project->images) > 0)
            <div class="row g-3">
                <div class="col-12">
                    <a href="{{ asset('storage/' . $project->images[0]) }}" data-lightbox="project-images">
                        <img src="{{ asset('storage/' . $project->images[0]) }}" class="img-fluid rounded shadow-sm" alt="{{ $project->name }}" style="cursor: pointer;">
                    </a>
                </div>
                @if(count($project->images) > 1)
                <div class="col-12">
                    <div class="row g-2">
                        @foreach(array_slice($project->images, 1, 4) as $image)
                        <div class="col-3">
                            <a href="{{ asset('storage/' . $image) }}" data-lightbox="project-images">
                                <img src="{{ asset('storage/' . $image) }}" class="img-fluid rounded shadow-sm" alt="Project Image" style="height: 100px; object-fit: cover; width: 100%; cursor: pointer;">
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            @else
            <div class="bg-gradient-primary rounded shadow-sm d-flex align-items-center justify-content-center" style="height: 500px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="128" height="128" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="opacity-50">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                </svg>
            </div>
            @endif
        </div>

        <!-- Project Details -->
        <div class="col-lg-5 mb-4">
            <div class="d-flex align-items-center mb-3">
                @if($project->is_featured)
                <span class="badge bg-warning text-dark me-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="currentColor" class="me-1">
                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                    </svg>
                    Featured
                </span>
                @endif
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
                <span class="badge bg-{{ $statusColor }} me-2">
                    {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                </span>
                @if($project->category)
                <span class="badge bg-primary">{{ $project->category }}</span>
                @endif
            </div>

            <h1 class="h2 mb-3">{{ $project->name }}</h1>

            @if($project->client)
            <div class="mb-3">
                <p class="text-muted mb-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <strong>Client:</strong> {{ $project->client }}
                </p>
                @if($project->client_website)
                <p class="text-muted small mb-0">
                    <a href="{{ $project->client_website }}" target="_blank" class="text-decoration-none">
                        {{ $project->client_website }}
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="currentColor" class="ms-1">
                            <path d="M14,3V5H17.59L7.76,14.83L9.17,16.24L19,6.41V10H21V3M19,19H5V5H12V3H5C3.89,3 3,3.9 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V12H19V19Z"/>
                        </svg>
                    </a>
                </p>
                @endif
            </div>
            @endif

            @if($project->description)
            <div class="mb-4">
                <p class="lead text-muted">{{ $project->description }}</p>
            </div>
            @endif

            @if($project->details)
            <div class="mb-4">
                <h5 class="fw-semibold mb-3">Project Overview</h5>
                <div class="text-muted">{!! nl2br(e($project->details)) !!}</div>
            </div>
            @endif

            <!-- Tags -->
            @if($project->tags && count($project->tags) > 0)
            <div class="mb-4">
                <h6 class="fw-semibold mb-2">Tags</h6>
                <div class="d-flex flex-wrap gap-2">
                    @foreach($project->tags as $tag)
                    <a href="{{ route('projects.index', ['tag' => $tag]) }}" class="badge bg-secondary text-decoration-none">{{ $tag }}</a>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Project Info -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3">Project Information</h6>
                    <div class="row g-3">
                        @if($project->start_date)
                        <div class="col-6">
                            <small class="text-muted d-block">Start Date</small>
                            <strong>{{ \Carbon\Carbon::parse($project->start_date)->format('M d, Y') }}</strong>
                        </div>
                        @endif
                        @if($project->end_date)
                        <div class="col-6">
                            <small class="text-muted d-block">End Date</small>
                            <strong>{{ \Carbon\Carbon::parse($project->end_date)->format('M d, Y') }}</strong>
                        </div>
                        @endif
                        @if($project->budget)
                        <div class="col-6">
                            <small class="text-muted d-block">Budget</small>
                            <strong>₹{{ number_format($project->budget, 2) }}</strong>
                        </div>
                        @endif
                        @php
                            $priorityColors = [
                                'low' => 'secondary',
                                'medium' => 'info',
                                'high' => 'warning',
                                'urgent' => 'danger'
                            ];
                            $priorityColor = $priorityColors[$project->priority] ?? 'secondary';
                        @endphp
                        <div class="col-6">
                            <small class="text-muted d-block">Priority</small>
                            <span class="badge bg-{{ $priorityColor }}">{{ ucfirst($project->priority) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Media & Links -->
            @if($project->website_link || $project->facebook_link || $project->twitter_link || $project->instagram_link || $project->linkedin_link || $project->github_link)
            <div class="mb-4">
                <h6 class="fw-semibold mb-3">Links</h6>
                <div class="d-flex flex-wrap gap-2">
                    @if($project->website_link)
                    <a href="{{ $project->website_link }}" target="_blank" class="btn btn-outline-primary btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                            <path d="M14,3V5H17.59L7.76,14.83L9.17,16.24L19,6.41V10H21V3M19,19H5V5H12V3H5C3.89,3 3,3.9 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V12H19V19Z"/>
                        </svg>
                        Website
                    </a>
                    @endif
                    @if($project->github_link)
                    <a href="{{ $project->github_link }}" target="_blank" class="btn btn-outline-dark btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                            <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"/>
                        </svg>
                        GitHub
                    </a>
                    @endif
                    @if($project->linkedin_link)
                    <a href="{{ $project->linkedin_link }}" target="_blank" class="btn btn-outline-primary btn-sm">
                        LinkedIn
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
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Project Specifications -->
    @if($project->specification && count($project->specification) > 0)
    <div class="row mb-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Project Specifications</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <tbody>
                                @foreach($project->specification as $key => $value)
                                    @if(is_array($value))
                                        @if(isset($value['key']) && isset($value['value']))
                                        <tr>
                                            <td class="fw-semibold" style="width: 30%;">{{ $value['key'] }}</td>
                                            <td>{{ $value['value'] }}</td>
                                        </tr>
                                        @endif
                                    @else
                                        <tr>
                                            <td class="fw-semibold" style="width: 30%;">{{ is_numeric($key) ? '' : $key }}</td>
                                            <td>{{ $value }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Videos Section -->
    @if(($project->videos && count($project->videos) > 0) || $project->youtube_link)
    <div class="row mb-5">
        <div class="col-12">
            <h4 class="mb-4">Project Videos</h4>
            <div class="row g-4">
                @if($project->youtube_link)
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-0">
                            <div class="ratio ratio-16x9">
                                <iframe src="{{ str_replace('watch?v=', 'embed/', str_replace('youtu.be/', 'youtube.com/embed/', $project->youtube_link)) }}" allowfullscreen></iframe>
                            </div>
                        </div>
                        <div class="card-footer bg-white">
                            <a href="{{ $project->youtube_link }}" target="_blank" class="btn btn-sm btn-outline-danger">
                                Watch on YouTube
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                @if($project->videos && count($project->videos) > 0)
                    @foreach($project->videos as $video)
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-0">
                                <video src="{{ asset('storage/' . $video) }}" class="w-100" controls style="border-radius: 0.375rem 0.375rem 0 0;"></video>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    @endif

    <!-- Related Projects -->
    @if($relatedProjects && $relatedProjects->count() > 0)
    <div class="row">
        <div class="col-12">
            <h4 class="mb-4">Related Projects</h4>
            <div class="row g-4">
                @foreach($relatedProjects as $relatedProject)
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 border-0 shadow-sm hover-shadow">
                        <div class="position-relative">
                            @if($relatedProject->images && count($relatedProject->images) > 0)
                                <img src="{{ asset('storage/' . $relatedProject->images[0]) }}" class="card-img-top" alt="{{ $relatedProject->name }}" style="height: 200px; object-fit: cover;">
                            @else
                                <div class="card-img-top bg-gradient-primary d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="opacity-50">
                                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                                    </svg>
                                </div>
                            @endif
                            @if($relatedProject->is_featured)
                            <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-2">Featured</span>
                            @endif
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title">
                                <a href="{{ route('projects.show', $relatedProject->slug) }}" class="text-decoration-none text-dark">
                                    {{ $relatedProject->name }}
                                </a>
                            </h6>
                            @if($relatedProject->description)
                            <p class="text-muted small mb-3">{{ Str::limit($relatedProject->description, 80) }}</p>
                            @endif
                            <div class="mt-auto">
                                <a href="{{ route('projects.show', $relatedProject->slug) }}" class="btn btn-primary btn-sm w-100">
                                    View Project
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
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

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
@endpush

