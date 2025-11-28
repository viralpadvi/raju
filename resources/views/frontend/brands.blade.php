@extends('layouts.storefront')

@section('title', 'Brands - Electronics Store')

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Brands</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold mb-3">Shop by Brand</h1>
        <p class="lead text-muted">Discover products from your favorite electronics brands</p>
    </div>

    <!-- Brands Grid -->
    <div class="row g-4">
        @for($i = 1; $i <= 12; $i++)
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card h-100 border-0 shadow-sm brand-card">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <img src="https://via.placeholder.com/120x80/{{ ['000000', '1428A0', 'A50034', '007DB8', '0096D6', 'E2231A', '00BCF2', '4285F4'][rand(0, 7)] }}/ffffff?text=Brand+{{ $i }}" alt="Brand {{ $i }}" class="img-fluid">
                    </div>
                    <h5 class="card-title">{{ ['Apple', 'Samsung', 'Sony', 'LG', 'Dell', 'HP', 'Lenovo', 'Microsoft', 'Google', 'Bose', 'Nintendo', 'Xbox'][$i-1] }}</h5>
                    <p class="text-muted small mb-3">{{ rand(10, 50) }} products available</p>
                    <a href="#" class="btn btn-outline-primary btn-sm">View Products</a>
                </div>
            </div>
        </div>
        @endfor
    </div>

    <!-- Featured Brands Section -->
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="text-center mb-5">Featured Brands</h3>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 bg-primary bg-opacity-10">
                        <div class="card-body text-center p-4">
                            <img src="https://via.placeholder.com/150x100/000000/ffffff?text=Apple" alt="Apple" class="img-fluid mb-3">
                            <h5 class="card-title">Apple</h5>
                            <p class="text-muted">Innovation and design excellence in every product</p>
                            <div class="row g-2 text-center">
                                <div class="col-4">
                                    <div class="h6 text-primary mb-0">24</div>
                                    <small class="text-muted">Products</small>
                                </div>
                                <div class="col-4">
                                    <div class="h6 text-success mb-0">4.9</div>
                                    <small class="text-muted">Rating</small>
                                </div>
                                <div class="col-4">
                                    <div class="h6 text-warning mb-0">$599</div>
                                    <small class="text-muted">Starting</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 bg-success bg-opacity-10">
                        <div class="card-body text-center p-4">
                            <img src="https://via.placeholder.com/150x100/1428A0/ffffff?text=Samsung" alt="Samsung" class="img-fluid mb-3">
                            <h5 class="card-title">Samsung</h5>
                            <p class="text-muted">Leading innovation in mobile and home appliances</p>
                            <div class="row g-2 text-center">
                                <div class="col-4">
                                    <div class="h6 text-primary mb-0">32</div>
                                    <small class="text-muted">Products</small>
                                </div>
                                <div class="col-4">
                                    <div class="h6 text-success mb-0">4.7</div>
                                    <small class="text-muted">Rating</small>
                                </div>
                                <div class="col-4">
                                    <div class="h6 text-warning mb-0">$299</div>
                                    <small class="text-muted">Starting</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 bg-warning bg-opacity-10">
                        <div class="card-body text-center p-4">
                            <img src="https://via.placeholder.com/150x100/000000/ffffff?text=Sony" alt="Sony" class="img-fluid mb-3">
                            <h5 class="card-title">Sony</h5>
                            <p class="text-muted">Premium audio and visual entertainment</p>
                            <div class="row g-2 text-center">
                                <div class="col-4">
                                    <div class="h6 text-primary mb-0">18</div>
                                    <small class="text-muted">Products</small>
                                </div>
                                <div class="col-4">
                                    <div class="h6 text-success mb-0">4.8</div>
                                    <small class="text-muted">Rating</small>
                                </div>
                                <div class="col-4">
                                    <div class="h6 text-warning mb-0">$199</div>
                                    <small class="text-muted">Starting</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Brand Categories -->
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="text-center mb-5">Browse by Category</h3>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                <i class="bi bi-phone fs-2 text-primary"></i>
                            </div>
                            <h5 class="card-title">Smartphones</h5>
                            <p class="text-muted">Mobile phones from top brands</p>
                            <a href="{{ route('category', 'smartphones') }}" class="btn btn-outline-primary btn-sm">Browse</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                <i class="bi bi-laptop fs-2 text-success"></i>
                            </div>
                            <h5 class="card-title">Laptops</h5>
                            <p class="text-muted">Computers for work and play</p>
                            <a href="{{ route('category', 'laptops') }}" class="btn btn-outline-success btn-sm">Browse</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                <i class="bi bi-headphones fs-2 text-warning"></i>
                            </div>
                            <h5 class="card-title">Audio</h5>
                            <p class="text-muted">Headphones and speakers</p>
                            <a href="{{ route('category', 'audio') }}" class="btn btn-outline-warning btn-sm">Browse</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                <i class="bi bi-controller fs-2 text-danger"></i>
                            </div>
                            <h5 class="card-title">Gaming</h5>
                            <p class="text-muted">Gaming consoles and accessories</p>
                            <a href="{{ route('category', 'gaming') }}" class="btn btn-outline-danger btn-sm">Browse</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.brand-card {
    transition: transform 0.3s ease;
}

.brand-card:hover {
    transform: translateY(-5px);
}
</style>
@endsection
