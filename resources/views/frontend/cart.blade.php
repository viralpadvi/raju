@extends('layouts.storefront')

@section('title', 'Shopping Cart - Electronics Store')

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Shopping Cart</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-8">
            <h2 class="mb-4">Shopping Cart</h2>
            
            <!-- Cart Items -->
            <div class="card">
                <div class="card-body">
                    @for($i = 1; $i <= 3; $i++)
                    <div class="row align-items-center py-3 {{ $i < 3 ? 'border-bottom' : '' }}">
                        <div class="col-md-2">
                            <img src="https://via.placeholder.com/100x100/6c757d/ffffff?text=Product+{{ $i }}" alt="Product {{ $i }}" class="img-fluid rounded">
                        </div>
                        <div class="col-md-4">
                            <h6 class="mb-1">Product Name {{ $i }}</h6>
                            <p class="text-muted small mb-0">{{ ['Apple', 'Samsung', 'Sony'][$i-1] }} • {{ ['Smartphone', 'Laptop', 'Headphones'][$i-1] }}</p>
                            <div class="text-warning small">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star"></i>
                                <span class="text-muted ms-1">({{ rand(10, 999) }})</span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="input-group input-group-sm" style="width: 100px;">
                                <button class="btn btn-outline-secondary" type="button">-</button>
                                <input type="number" class="form-control text-center" value="{{ rand(1, 3) }}" min="1" max="10">
                                <button class="btn btn-outline-secondary" type="button">+</button>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="text-end">
                                <div class="h6 text-primary mb-0">${{ rand(199, 999) }}.99</div>
                                <small class="text-muted text-decoration-line-through">${{ rand(299, 1199) }}.99</small>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="text-end">
                                <button class="btn btn-outline-danger btn-sm mb-2">
                                    <i class="bi bi-trash"></i>
                                </button>
                                <br>
                                <button class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-heart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>

            <!-- Cart Actions -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <a href="{{ route('products') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left me-2"></i>Continue Shopping
                </a>
                <button class="btn btn-outline-danger">
                    <i class="bi bi-trash me-2"></i>Clear Cart
                </button>
            </div>

            <!-- Recently Viewed -->
            <div class="mt-5">
                <h4 class="mb-4">Recently Viewed</h4>
                <div class="row g-3">
                    @for($i = 1; $i <= 4; $i++)
                    <div class="col-lg-3 col-md-6">
                        <div class="card border-0 shadow-sm">
                            <img src="https://via.placeholder.com/200x150/6c757d/ffffff?text=Recent+{{ $i }}" class="card-img-top" alt="Recent Product {{ $i }}">
                            <div class="card-body p-3">
                                <h6 class="card-title small">Recent Product {{ $i }}</h6>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-primary fw-bold">${{ rand(99, 599) }}.99</span>
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
        </div>

        <!-- Order Summary -->
        <div class="col-lg-4">
            <div class="card sticky-top" style="top: 100px;">
                <div class="card-header">
                    <h5 class="mb-0">Order Summary</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal (3 items)</span>
                        <span>$1,299.97</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping</span>
                        <span class="text-success">Free</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tax</span>
                        <span>$104.00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Discount</span>
                        <span class="text-success">-$50.00</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <strong>Total</strong>
                        <strong class="text-primary">$1,353.97</strong>
                    </div>
                    
                    <button class="btn btn-primary w-100 btn-lg mb-3">
                        <i class="bi bi-credit-card me-2"></i>Proceed to Checkout
                    </button>
                    
                    <div class="text-center">
                        <small class="text-muted">or</small>
                    </div>
                    
                    <button class="btn btn-outline-primary w-100 mb-3">
                        <i class="bi bi-paypal me-2"></i>Pay with PayPal
                    </button>
                    
                    <div class="text-center">
                        <small class="text-muted">
                            <i class="bi bi-shield-check me-1"></i>
                            Secure checkout with SSL encryption
                        </small>
                    </div>
                </div>
            </div>

            <!-- Promo Code -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">Promo Code</h6>
                </div>
                <div class="card-body">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Enter promo code">
                        <button class="btn btn-outline-primary" type="button">Apply</button>
                    </div>
                    <small class="text-muted">Have a promo code? Enter it above to get discounts on your order.</small>
                </div>
            </div>

            <!-- Shipping Info -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">Shipping Information</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-truck text-primary me-2"></i>
                        <span>Free shipping on orders over $100</span>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-clock text-primary me-2"></i>
                        <span>Estimated delivery: 2-3 business days</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-arrow-clockwise text-primary me-2"></i>
                        <span>30-day return policy</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
