@extends('layouts.storefront')

@section('title', 'Home - Electronics Store')

@section('content')
<!-- Hero Section -->
<section class="hero-section bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Latest Electronics & Gadgets</h1>
                <p class="lead mb-4">Discover the newest smartphones, laptops, audio equipment, and gaming gear at unbeatable prices.</p>
                <div class="d-flex gap-3">
                    <a href="{{ route('category', 'smartphones') }}" class="btn btn-light btn-lg">Shop Smartphones</a>
                    <a href="{{ route('category', 'laptops') }}" class="btn btn-outline-light btn-lg">Shop Laptops</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="text-center">
                    <img src="https://via.placeholder.com/600x400/007bff/ffffff?text=Latest+Electronics" alt="Latest Electronics" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Categories (Dynamic) -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5">Shop by Category</h2>
        <div class="row g-4">
            @forelse($topCategories as $category)
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="bi bi-grid fs-2 text-primary"></i>
                        </div>
                        <h5 class="card-title">{{ $category->name }}</h5>
                        <p class="text-muted">{{ $category->products_count }} products</p>
                        <a href="{{ route('category', $category->slug) }}" class="btn btn-outline-primary">Shop Now</a>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center text-muted">No categories available.</div>
            @endforelse
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h2>Featured Products</h2>
            <a href="{{ route('products') }}" class="btn btn-outline-primary">View All Products</a>
        </div>
        <div class="row g-4">
            @forelse($featuredProducts as $product)
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="position-relative">
                        @php $img = is_array($product->images ?? null) && count($product->images) ? asset('storage/'.($product->images[0])) : 'https://via.placeholder.com/300x200/6c757d/ffffff?text='.urlencode($product->name); @endphp
                        <img src="{{ $img }}" class="card-img-top" alt="{{ $product->name }}">
                        @if($product->compare_price && $product->price < $product->compare_price)
                        <div class="position-absolute top-0 end-0 m-2">
                            <span class="badge bg-danger">Sale</span>
                        </div>
                        @endif
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title">{{ $product->name }}</h6>
                        <p class="text-muted small">{{ $product->brand->name ?? '' }}</p>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <div>
                                <span class="h5 text-primary mb-0">${{ number_format($product->price,2) }}</span>
                                @if($product->compare_price)
                                <small class="text-muted text-decoration-line-through ms-2">${{ number_format($product->compare_price,2) }}</small>
                                @endif
                            </div>
                            <a href="{{ route('product.show', $product->id) }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-cart-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center text-muted">No products to display.</div>
            @endforelse
        </div>
    </div>
</section>

<!-- Brands Section -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5">Shop by Brand</h2>
        <div class="row g-4 align-items-center">
            @forelse($topBrands as $brand)
            <div class="col-lg-2 col-md-4 col-6">
                <div class="text-center">
                    <div class="bg-light rounded p-3 mb-2">
                        @if($brand->logo)
                        <img src="{{ asset('storage/'.$brand->logo) }}" alt="{{ $brand->name }}" class="img-fluid">
                        @else
                        <div class="fw-bold">{{ $brand->name }}</div>
                        @endif
                    </div>
                    <small class="text-muted">{{ $brand->name }}</small>
                </div>
            </div>
            @empty
            <div class="text-center text-muted">No brands available.</div>
            @endforelse
        </div>
    </div>
</section>

<!-- Featured Projects -->
@if(isset($featuredProjects) && $featuredProjects->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h2>Our Projects</h2>
            <a href="{{ route('projects.index') }}" class="btn btn-outline-primary">View All Projects</a>
        </div>
        <div class="row g-4">
            @foreach($featuredProjects as $project)
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-sm hover-shadow">
                    <div class="position-relative">
                        @if($project->images && count($project->images) > 0)
                            <img src="{{ asset('storage/' . $project->images[0]) }}" class="card-img-top" alt="{{ $project->name }}" style="height: 250px; object-fit: cover;">
                        @else
                            <div class="card-img-top bg-gradient-primary d-flex align-items-center justify-content-center" style="height: 250px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="opacity-50">
                                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                                </svg>
                            </div>
                        @endif
                        @if($project->is_featured)
                        <div class="position-absolute top-0 start-0 m-2">
                            <span class="badge bg-warning text-dark">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="currentColor" class="me-1">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                </svg>
                                Featured
                            </span>
                        </div>
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
                            {{ $project->client }}
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
                            @endif
                        </div>
                        <div class="mt-auto">
                            <a href="{{ route('projects.show', $project->slug) }}" class="btn btn-primary btn-sm w-100">
                                View Details
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
    </div>
</section>
@endif

<!-- Newsletter Section -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h3 class="mb-3">Stay Updated with Latest Deals</h3>
                <p class="mb-0">Subscribe to our newsletter and get exclusive offers, new product announcements, and tech tips delivered to your inbox.</p>
            </div>
            <div class="col-lg-6">
                <form class="d-flex gap-2">
                    <input type="email" class="form-control" placeholder="Enter your email address">
                    <button type="submit" class="btn btn-light">Subscribe</button>
                </form>
            </div>
        </div>
    </div>
</section>
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
