@extends('layouts.storefront')

@section('title', 'Products - Electronics Store')

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Products</li>
        </ol>
    </nav>

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
                                <input type="number" class="form-control form-control-sm" placeholder="Min" id="minPrice">
                            </div>
                            <div class="col-6">
                                <input type="number" class="form-control form-control-sm" placeholder="Max" id="maxPrice">
                            </div>
                        </div>
                        <div class="mt-2">
                            <input type="range" class="form-range" min="0" max="2000" value="1000" id="priceRange">
                        </div>
                    </div>

                    <!-- Brands -->
                    <div class="mb-4">
                        <h6 class="mb-3">Brands</h6>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="brandApple">
                            <label class="form-check-label" for="brandApple">Apple</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="brandSamsung">
                            <label class="form-check-label" for="brandSamsung">Samsung</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="brandSony">
                            <label class="form-check-label" for="brandSony">Sony</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="brandLG">
                            <label class="form-check-label" for="brandLG">LG</label>
                        </div>
                    </div>

                    <!-- Categories -->
                    <div class="mb-4">
                        <h6 class="mb-3">Categories</h6>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="catSmartphones">
                            <label class="form-check-label" for="catSmartphones">Smartphones</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="catLaptops">
                            <label class="form-check-label" for="catLaptops">Laptops</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="catTablets">
                            <label class="form-check-label" for="catTablets">Tablets</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="catAudio">
                            <label class="form-check-label" for="catAudio">Audio</label>
                        </div>
                    </div>

                    <!-- Rating -->
                    <div class="mb-4">
                        <h6 class="mb-3">Customer Rating</h6>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="rating5">
                            <label class="form-check-label" for="rating5">
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                & Up
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="rating4">
                            <label class="form-check-label" for="rating4">
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star text-warning"></i>
                                & Up
                            </label>
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
                    <span class="text-muted">Showing 1-12 of 48 products</span>
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
                            <img src="https://via.placeholder.com/300x200/6c757d/ffffff?text=Product+{{ $i }}" class="card-img-top" alt="Product {{ $i }}">
                            <div class="position-absolute top-0 end-0 m-2">
                                <span class="badge bg-danger">-{{ rand(10, 50) }}%</span>
                            </div>
                            <div class="position-absolute top-0 start-0 m-2">
                                <button class="btn btn-light btn-sm rounded-circle">
                                    <i class="bi bi-heart"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge bg-primary me-2">Brand</span>
                                <small class="text-muted">Category</small>
                            </div>
                            <h6 class="card-title">Product Name {{ $i }}</h6>
                            <p class="text-muted small">Product description goes here...</p>
                            <div class="d-flex align-items-center mb-2">
                                <div class="text-warning">
                                    @for($j = 1; $j <= 5; $j++)
                                        <i class="bi bi-star{{ $j <= rand(3, 5) ? '-fill' : '' }}"></i>
                                    @endfor
                                </div>
                                <span class="text-muted small ms-2">({{ rand(10, 999) }})</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <div>
                                    <span class="h5 text-primary mb-0">${{ rand(99, 999) }}.99</span>
                                    <small class="text-muted text-decoration-line-through ms-2">${{ rand(199, 1199) }}.99</small>
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
                    <li class="page-item"><a class="page-link" href="#">5</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
@endsection
