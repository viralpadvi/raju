@extends('layouts.storefront')

@section('title', 'Wishlist - ElectroStore')

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Wishlist</li>
        </ol>
    </nav>

    <h1 class="display-6 fw-bold mb-4">
        <i class="bi bi-heart me-2"></i>My Wishlist
    </h1>

    <!-- Wishlist Items -->
    <div class="row g-4">
        <!-- Sample Wishlist Items -->
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card h-100 shadow-sm">
                <div class="position-relative">
                    <img src="https://via.placeholder.com/300x200/6c757d/ffffff?text=iPhone+15+Pro" alt="iPhone 15 Pro" class="card-img-top" style="height: 200px; object-fit: cover;">
                    <button onclick="removeFromWishlist(1)" class="btn btn-sm btn-light position-absolute top-0 end-0 m-2 rounded-circle">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">iPhone 15 Pro</h5>
                    <p class="card-text text-muted small">128GB, Space Black</p>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="h5 text-primary mb-0">$999.00</span>
                        <div class="d-flex align-items-center">
                            <div class="text-warning me-1">
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <small class="text-muted">4.8</small>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-auto">
                        <button onclick="addToCart(1)" class="btn btn-primary btn-sm flex-fill">Add to Cart</button>
                        <button onclick="viewProduct(1)" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card h-100 shadow-sm">
                <div class="position-relative">
                    <img src="https://via.placeholder.com/300x200/6c757d/ffffff?text=MacBook+Pro" alt="MacBook Pro" class="card-img-top" style="height: 200px; object-fit: cover;">
                    <button onclick="removeFromWishlist(2)" class="btn btn-sm btn-light position-absolute top-0 end-0 m-2 rounded-circle">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">MacBook Pro</h5>
                    <p class="card-text text-muted small">14-inch, M3 Pro, 512GB SSD</p>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="h5 text-primary mb-0">$1,999.00</span>
                        <div class="d-flex align-items-center">
                            <div class="text-warning me-1">
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <small class="text-muted">4.9</small>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-auto">
                        <button onclick="addToCart(2)" class="btn btn-primary btn-sm flex-fill">Add to Cart</button>
                        <button onclick="viewProduct(2)" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Empty State -->
    <div id="emptyWishlist" class="text-center py-5 d-none">
        <i class="bi bi-heart display-1 text-muted"></i>
        <h3 class="mt-3">Your wishlist is empty</h3>
        <p class="text-muted mb-4">Start adding items you love to your wishlist</p>
        <a href="{{ route('products') }}" class="btn btn-primary">Browse Products</a>
    </div>
</div>

<script>
async function removeFromWishlist(productId) {
    const result = await window.utils.showDeleteConfirm('Remove from Wishlist', 'Are you sure you want to remove this item from your wishlist?');
    
    if (result.isConfirmed) {
        // Simulate API call
        await new Promise(resolve => setTimeout(resolve, 1000));
        
        // Remove item from DOM
        const item = document.querySelector(`[data-product-id="${productId}"]`);
        if (item) {
            item.remove();
        }
        
        // Check if wishlist is empty
        const items = document.querySelectorAll('[data-product-id]');
        if (items.length === 0) {
            document.getElementById('emptyWishlist').classList.remove('hidden');
        }
        
        window.utils.showToast('Item removed from wishlist', 'info');
    }
}

function addToCart(productId) {
    window.utils.showToast('Item added to cart!', 'success');
}

function viewProduct(productId) {
    window.location.href = `/products/${productId}`;
}
</script>
@endsection
