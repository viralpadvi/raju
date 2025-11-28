@extends('layouts.storefront')

@section('title', 'Smartphones - Electronics Store')

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Smartphones</li>
        </ol>
    </nav>

    <!-- Category Header -->
    <div class="row align-items-center mb-5">
        <div class="col-lg-8">
            <h1 class="display-6 fw-bold mb-3">Smartphones</h1>
            <p class="lead text-muted">Discover the latest smartphones from top brands like Apple, Samsung, Google, and more. Find the perfect device for your needs.</p>
        </div>
        <div class="col-lg-4 text-lg-end">
            <img src="https://via.placeholder.com/300x200/007bff/ffffff?text=Smartphones" alt="Smartphones" class="img-fluid rounded">
        </div>
    </div>

    <!-- Category Stats -->
    <div class="row g-4 mb-5">
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 bg-primary bg-opacity-10">
                <div class="card-body text-center">
                    <i class="bi bi-phone fs-1 text-primary mb-3"></i>
                    <h4 class="text-primary">48</h4>
                    <p class="text-muted mb-0">Products Available</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 bg-success bg-opacity-10">
                <div class="card-body text-center">
                    <i class="bi bi-star fs-1 text-success mb-3"></i>
                    <h4 class="text-success">4.8</h4>
                    <p class="text-muted mb-0">Average Rating</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 bg-warning bg-opacity-10">
                <div class="card-body text-center">
                    <i class="bi bi-tag fs-1 text-warning mb-3"></i>
                    <h4 class="text-warning">$199</h4>
                    <p class="text-muted mb-0">Starting Price</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 bg-info bg-opacity-10">
                <div class="card-body text-center">
                    <i class="bi bi-lightning fs-1 text-info mb-3"></i>
                    <h4 class="text-info">12</h4>
                    <p class="text-muted mb-0">Top Brands</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-lg-3">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Filters</h6>
                </div>
                <div class="card-body">
                    <!-- Price Range -->
                    <div class="mb-4">
                        <h6 class="mb-3">Price Range</h6>
                        <div class="row g-2">
                            <div class="col-6">
                                <input type="number" class="form-control form-control-sm" placeholder="Min" value="199">
                            </div>
                            <div class="col-6">
                                <input type="number" class="form-control form-control-sm" placeholder="Max" value="1299">
                            </div>
                        </div>
                        <div class="mt-2">
                            <input type="range" class="form-range" min="199" max="1299" value="749">
                        </div>
                    </div>

                    <!-- Brands -->
                    <div class="mb-4">
                        <h6 class="mb-3">Brands</h6>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="brandApple" checked>
                            <label class="form-check-label" for="brandApple">Apple (12)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="brandSamsung" checked>
                            <label class="form-check-label" for="brandSamsung">Samsung (15)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="brandGoogle">
                            <label class="form-check-label" for="brandGoogle">Google (8)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="brandOnePlus">
                            <label class="form-check-label" for="brandOnePlus">OnePlus (6)</label>
                        </div>
                    </div>

                    <!-- Features -->
                    <div class="mb-4">
                        <h6 class="mb-3">Features</h6>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="feature5G">
                            <label class="form-check-label" for="feature5G">5G Connectivity</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="featureWireless">
                            <label class="form-check-label" for="featureWireless">Wireless Charging</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="featureWater">
                            <label class="form-check-label" for="featureWater">Water Resistant</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="featureDual">
                            <label class="form-check-label" for="featureDual">Dual SIM</label>
                        </div>
                    </div>

                    <!-- Storage -->
                    <div class="mb-4">
                        <h6 class="mb-3">Storage</h6>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="storage128">
                            <label class="form-check-label" for="storage128">128GB</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="storage256" checked>
                            <label class="form-check-label" for="storage256">256GB</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="storage512">
                            <label class="form-check-label" for="storage512">512GB</label>
                        </div>
                    </div>

                    <button class="btn btn-primary w-100">Apply Filters</button>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="col-lg-9">
            <!-- Sort and View Options -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <span class="text-muted">Showing 1-12 of 48 smartphones</span>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <select class="form-select form-select-sm" style="width: auto;">
                        <option>Sort by: Featured</option>
                        <option>Price: Low to High</option>
                        <option>Price: High to Low</option>
                        <option>Newest First</option>
                        <option>Customer Rating</option>
                    </select>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-secondary btn-sm active">
                            <i class="bi bi-grid-3x3-gap"></i>
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-list"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="row g-4">
                @for($i = 1; $i <= 12; $i++)
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="position-relative">
                            <img src="https://via.placeholder.com/300x200/6c757d/ffffff?text=Smartphone+{{ $i }}" class="card-img-top" alt="Smartphone {{ $i }}">
                            <div class="position-absolute top-0 end-0 m-2">
                                <span class="badge bg-danger">-{{ rand(10, 30) }}%</span>
                            </div>
                            <div class="position-absolute top-0 start-0 m-2">
                                <button class="btn btn-light btn-sm rounded-circle">
                                    <i class="bi bi-heart"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge bg-primary me-2">{{ ['Apple', 'Samsung', 'Google', 'OnePlus'][rand(0, 3)] }}</span>
                                <small class="text-muted">Smartphone</small>
                            </div>
                            <h6 class="card-title">iPhone 15 Pro Max</h6>
                            <p class="text-muted small">Latest flagship smartphone with advanced features</p>
                            <div class="d-flex align-items-center mb-2">
                                <div class="text-warning">
                                    @for($j = 1; $j <= 5; $j++)
                                        <i class="bi bi-star{{ $j <= rand(4, 5) ? '-fill' : '' }}"></i>
                                    @endfor
                                </div>
                                <span class="text-muted small ms-2">({{ rand(50, 999) }})</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <div>
                                    <span class="h5 text-primary mb-0">${{ rand(699, 1299) }}.99</span>
                                    <small class="text-muted text-decoration-line-through ms-2">${{ rand(899, 1499) }}.99</small>
                                </div>
                                <button class="btn btn-primary btn-sm">
                                    <i class="bi bi-cart-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endfor
            </div>

            <!-- Pagination -->
            <nav aria-label="Products pagination" class="mt-5">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">4</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
@endsection
