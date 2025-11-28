@extends('layouts.storefront')

@section('title', 'Deals & Offers - Electronics Store')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-5 fw-bold mb-4">Amazing Deals & Offers</h1>
                <p class="lead">Save big on the latest electronics! Limited time offers on smartphones, laptops, audio gear, and more.</p>
                <div class="d-flex gap-3">
                    <a href="#featured-deals" class="btn btn-light btn-lg">Shop Deals</a>
                    <a href="#flash-sales" class="btn btn-outline-light btn-lg">Flash Sales</a>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="https://via.placeholder.com/600x400/ffffff/007bff?text=Special+Deals" alt="Special Deals" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</section>

<!-- Flash Sales -->
<section id="flash-sales" class="py-5 bg-danger text-white">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="display-6 fw-bold mb-3">⚡ Flash Sales</h2>
            <p class="lead">Limited time offers - Don't miss out!</p>
        </div>
        <div class="row g-4">
            @for($i = 1; $i <= 4; $i++)
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 bg-white text-dark h-100">
                    <div class="position-relative">
                        <img src="https://via.placeholder.com/300x200/6c757d/ffffff?text=Flash+Sale+{{ $i }}" class="card-img-top" alt="Flash Sale {{ $i }}">
                        <div class="position-absolute top-0 end-0 m-2">
                            <span class="badge bg-danger">-{{ rand(30, 70) }}%</span>
                        </div>
                        <div class="position-absolute bottom-0 start-0 end-0 m-2">
                            <div class="bg-danger text-white p-2 rounded text-center">
                                <small class="fw-bold">Ends in: {{ rand(1, 23) }}h {{ rand(1, 59) }}m</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title">Flash Sale Product {{ $i }}</h6>
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
                                <span class="h5 text-danger mb-0">${{ rand(99, 399) }}.99</span>
                                <small class="text-muted text-decoration-line-through ms-2">${{ rand(299, 799) }}.99</small>
                            </div>
                            <button class="btn btn-danger btn-sm">
                                <i class="bi bi-cart-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </div>
</section>

<!-- Featured Deals -->
<section id="featured-deals" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-6 fw-bold mb-3">Featured Deals</h2>
            <p class="lead text-muted">Handpicked deals on our most popular products</p>
        </div>
        
        <div class="row g-4">
            @for($i = 1; $i <= 8; $i++)
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="position-relative">
                        <img src="https://via.placeholder.com/300x200/6c757d/ffffff?text=Deal+{{ $i }}" class="card-img-top" alt="Deal {{ $i }}">
                        <div class="position-absolute top-0 end-0 m-2">
                            <span class="badge bg-success">-{{ rand(15, 40) }}%</span>
                        </div>
                        <div class="position-absolute top-0 start-0 m-2">
                            <button class="btn btn-light btn-sm rounded-circle">
                                <i class="bi bi-heart"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex align-items-center mb-2">
                            <span class="badge bg-primary me-2">{{ ['Apple', 'Samsung', 'Sony', 'LG', 'Dell', 'HP', 'Lenovo', 'Microsoft'][$i-1] }}</span>
                            <small class="text-muted">{{ ['Smartphone', 'Laptop', 'Tablet', 'Audio', 'Gaming', 'Accessories', 'Wearables', 'Home'][$i-1] }}</small>
                        </div>
                        <h6 class="card-title">Deal Product {{ $i }}</h6>
                        <p class="text-muted small">Special offer on this amazing product</p>
                        <div class="d-flex align-items-center mb-2">
                            <div class="text-warning">
                                @for($j = 1; $j <= 5; $j++)
                                    <i class="bi bi-star{{ $j <= rand(3, 5) ? '-fill' : '' }}"></i>
                                @endfor
                            </div>
                            <span class="text-muted small ms-2">({{ rand(20, 500) }})</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <div>
                                <span class="h5 text-primary mb-0">${{ rand(199, 899) }}.99</span>
                                <small class="text-muted text-decoration-line-through ms-2">${{ rand(399, 1299) }}.99</small>
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
    </div>
</section>

<!-- Category Deals -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5">Deals by Category</h2>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="bi bi-phone fs-2 text-primary"></i>
                        </div>
                        <h5 class="card-title">Smartphone Deals</h5>
                        <p class="text-muted">Up to 50% off on latest smartphones</p>
                        <div class="mb-3">
                            <span class="h4 text-danger">Save up to $500</span>
                        </div>
                        <a href="{{ route('category', 'smartphones') }}" class="btn btn-primary">Shop Now</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="bi bi-laptop fs-2 text-success"></i>
                        </div>
                        <h5 class="card-title">Laptop Deals</h5>
                        <p class="text-muted">Powerful laptops at unbeatable prices</p>
                        <div class="mb-3">
                            <span class="h4 text-danger">Save up to $800</span>
                        </div>
                        <a href="{{ route('category', 'laptops') }}" class="btn btn-success">Shop Now</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="bi bi-headphones fs-2 text-warning"></i>
                        </div>
                        <h5 class="card-title">Audio Deals</h5>
                        <p class="text-muted">Premium audio equipment on sale</p>
                        <div class="mb-3">
                            <span class="h4 text-danger">Save up to $300</span>
                        </div>
                        <a href="{{ route('category', 'audio') }}" class="btn btn-warning">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter Signup -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h3 class="mb-3">Never Miss a Deal!</h3>
                <p class="mb-0">Subscribe to our newsletter and be the first to know about exclusive offers, flash sales, and new product launches.</p>
            </div>
            <div class="col-lg-6">
                <form class="d-flex gap-2">
                    <input type="email" class="form-control" placeholder="Enter your email address">
                    <button type="submit" class="btn btn-light">Subscribe</button>
                </form>
                <small class="text-light mt-2 d-block">Join 50,000+ subscribers for exclusive deals</small>
            </div>
        </div>
    </div>
</section>

<!-- Deal Terms -->
<section class="py-4 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="text-center">
                    <h6 class="mb-3">Deal Terms & Conditions</h6>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="bi bi-clock text-primary me-2"></i>
                                <small>Limited time offers</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="bi bi-arrow-clockwise text-success me-2"></i>
                                <small>30-day return policy</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="bi bi-truck text-info me-2"></i>
                                <small>Free shipping on orders $100+</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="bi bi-shield-check text-warning me-2"></i>
                                <small>Full warranty included</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
