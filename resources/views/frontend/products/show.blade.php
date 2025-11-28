@extends('layouts.storefront')

@section('title', 'Product Details - Electronics Store')

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products') }}">Products</a></li>
            <li class="breadcrumb-item"><a href="{{ route('category', 'smartphones') }}">Smartphones</a></li>
            <li class="breadcrumb-item active">iPhone 15 Pro</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Images -->
        <div class="col-lg-6">
            <div class="row g-2">
                <div class="col-12">
                    <img src="https://via.placeholder.com/600x400/6c757d/ffffff?text=iPhone+15+Pro+Main" class="img-fluid rounded" alt="iPhone 15 Pro">
                </div>
                <div class="col-3">
                    <img src="https://via.placeholder.com/150x100/6c757d/ffffff?text=Image+1" class="img-fluid rounded" alt="Image 1">
                </div>
                <div class="col-3">
                    <img src="https://via.placeholder.com/150x100/6c757d/ffffff?text=Image+2" class="img-fluid rounded" alt="Image 2">
                </div>
                <div class="col-3">
                    <img src="https://via.placeholder.com/150x100/6c757d/ffffff?text=Image+3" class="img-fluid rounded" alt="Image 3">
                </div>
                <div class="col-3">
                    <img src="https://via.placeholder.com/150x100/6c757d/ffffff?text=Image+4" class="img-fluid rounded" alt="Image 4">
                </div>
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-lg-6">
            <div class="d-flex align-items-center mb-3">
                <span class="badge bg-primary me-2">Apple</span>
                <span class="badge bg-success">In Stock</span>
            </div>
            
            <h1 class="h3 mb-3">iPhone 15 Pro</h1>
            
            <div class="d-flex align-items-center mb-3">
                <div class="text-warning me-2">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                </div>
                <span class="text-muted">(4.8) 1,234 reviews</span>
            </div>

            <div class="mb-4">
                <span class="h3 text-primary">$999.00</span>
                <span class="text-muted text-decoration-line-through ms-2">$1,199.00</span>
                <span class="badge bg-danger ms-2">Save $200</span>
            </div>

            <p class="text-muted mb-4">The iPhone 15 Pro features a titanium design, A17 Pro chip, and Pro camera system. Experience the power of the most advanced iPhone ever created.</p>

            <!-- Product Options -->
            <div class="mb-4">
                <h6 class="mb-3">Storage</h6>
                <div class="btn-group" role="group">
                    <input type="radio" class="btn-check" name="storage" id="storage128" value="128">
                    <label class="btn btn-outline-primary" for="storage128">128GB</label>
                    
                    <input type="radio" class="btn-check" name="storage" id="storage256" value="256" checked>
                    <label class="btn btn-outline-primary" for="storage256">256GB</label>
                    
                    <input type="radio" class="btn-check" name="storage" id="storage512" value="512">
                    <label class="btn btn-outline-primary" for="storage512">512GB</label>
                </div>
            </div>

            <div class="mb-4">
                <h6 class="mb-3">Color</h6>
                <div class="btn-group" role="group">
                    <input type="radio" class="btn-check" name="color" id="colorNatural" value="natural">
                    <label class="btn btn-outline-secondary" for="colorNatural">Natural Titanium</label>
                    
                    <input type="radio" class="btn-check" name="color" id="colorBlue" value="blue" checked>
                    <label class="btn btn-outline-primary" for="colorBlue">Blue Titanium</label>
                    
                    <input type="radio" class="btn-check" name="color" id="colorWhite" value="white">
                    <label class="btn btn-outline-light" for="colorWhite">White Titanium</label>
                </div>
            </div>

            <!-- Quantity -->
            <div class="mb-4">
                <h6 class="mb-3">Quantity</h6>
                <div class="input-group" style="width: 120px;">
                    <button class="btn btn-outline-secondary" type="button">-</button>
                    <input type="number" class="form-control text-center" value="1" min="1" max="10">
                    <button class="btn btn-outline-secondary" type="button">+</button>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-grid gap-2 d-md-flex mb-4">
                <button class="btn btn-primary btn-lg flex-fill">
                    <i class="bi bi-cart-plus me-2"></i>Add to Cart
                </button>
                <button class="btn btn-outline-primary btn-lg">
                    <i class="bi bi-heart me-2"></i>Wishlist
                </button>
            </div>

            <!-- Product Features -->
            <div class="row g-3">
                <div class="col-6">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-truck text-primary me-2"></i>
                        <small>Free Shipping</small>
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-arrow-clockwise text-primary me-2"></i>
                        <small>30-Day Returns</small>
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-shield-check text-primary me-2"></i>
                        <small>1-Year Warranty</small>
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-headphones text-primary me-2"></i>
                        <small>24/7 Support</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Tabs -->
    <div class="row mt-5">
        <div class="col-12">
            <ul class="nav nav-tabs" id="productTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button">
                        Description
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="specifications-tab" data-bs-toggle="tab" data-bs-target="#specifications" type="button">
                        Specifications
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button">
                        Reviews (1,234)
                    </button>
                </li>
            </ul>
            <div class="tab-content" id="productTabsContent">
                <div class="tab-pane fade show active" id="description">
                    <div class="p-4">
                        <h5>Product Description</h5>
                        <p>The iPhone 15 Pro represents the pinnacle of smartphone technology. Built with aerospace-grade titanium, it's both incredibly strong and remarkably light. The A17 Pro chip delivers unprecedented performance, while the Pro camera system captures stunning photos and videos in any lighting condition.</p>
                        <ul>
                            <li>A17 Pro chip with 6-core CPU and 6-core GPU</li>
                            <li>Pro camera system with 48MP main camera</li>
                            <li>Titanium design for durability and lightness</li>
                            <li>Action Button for quick access to features</li>
                            <li>USB-C connector for universal compatibility</li>
                        </ul>
                    </div>
                </div>
                <div class="tab-pane fade" id="specifications">
                    <div class="p-4">
                        <h5>Technical Specifications</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-sm">
                                    <tr><td><strong>Display</strong></td><td>6.1-inch Super Retina XDR</td></tr>
                                    <tr><td><strong>Chip</strong></td><td>A17 Pro</td></tr>
                                    <tr><td><strong>Storage</strong></td><td>128GB, 256GB, 512GB, 1TB</td></tr>
                                    <tr><td><strong>Camera</strong></td><td>48MP Main, 12MP Ultra Wide</td></tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-sm">
                                    <tr><td><strong>Battery</strong></td><td>Up to 23 hours video playback</td></tr>
                                    <tr><td><strong>Connectivity</strong></td><td>5G, Wi-Fi 6E, Bluetooth 5.3</td></tr>
                                    <tr><td><strong>Materials</strong></td><td>Titanium, Ceramic Shield</td></tr>
                                    <tr><td><strong>Weight</strong></td><td>187 grams</td></tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="reviews">
                    <div class="p-4">
                        <h5>Customer Reviews</h5>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <span class="h4 me-3">4.8</span>
                                    <div>
                                        <div class="text-warning">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                        </div>
                                        <small class="text-muted">Based on 1,234 reviews</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="progress mb-1" style="height: 8px;">
                                    <div class="progress-bar" style="width: 85%"></div>
                                </div>
                                <div class="progress mb-1" style="height: 8px;">
                                    <div class="progress-bar" style="width: 10%"></div>
                                </div>
                                <div class="progress mb-1" style="height: 8px;">
                                    <div class="progress-bar" style="width: 3%"></div>
                                </div>
                                <div class="progress mb-1" style="height: 8px;">
                                    <div class="progress-bar" style="width: 1%"></div>
                                </div>
                                <div class="progress mb-1" style="height: 8px;">
                                    <div class="progress-bar" style="width: 1%"></div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Sample Reviews -->
                        <div class="border-top pt-4">
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0">
                                    <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <span class="text-primary fw-bold">JD</span>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-1">John Doe</h6>
                                        <small class="text-muted">2 days ago</small>
                                    </div>
                                    <div class="text-warning mb-2">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                    </div>
                                    <p class="mb-0">Amazing phone! The camera quality is outstanding and the titanium build feels premium. Highly recommended!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    <div class="row mt-5">
        <div class="col-12">
            <h4 class="mb-4">Related Products</h4>
            <div class="row g-4">
                @for($i = 1; $i <= 4; $i++)
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <img src="https://via.placeholder.com/300x200/6c757d/ffffff?text=Related+{{ $i }}" class="card-img-top" alt="Related Product {{ $i }}">
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title">Related Product {{ $i }}</h6>
                            <div class="d-flex align-items-center mb-2">
                                <div class="text-warning">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star"></i>
                                </div>
                                <span class="text-muted small ms-2">(4.0)</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <span class="h6 text-primary mb-0">${{ rand(199, 899) }}.99</span>
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
</div>
@endsection
