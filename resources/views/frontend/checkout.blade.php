@extends('layouts.storefront')

@section('title', 'Checkout - ElectroStore')

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cart') }}" class="text-decoration-none">Cart</a></li>
            <li class="breadcrumb-item active" aria-current="page">Checkout</li>
        </ol>
    </nav>

    <h1 class="display-6 fw-bold mb-4">Checkout</h1>

    <div class="row">
        <!-- Checkout Form -->
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-truck me-2"></i>Shipping Information
                    </h5>
                </div>
                <div class="card-body">
                    <form id="checkoutForm">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="firstName" class="form-label">First Name *</label>
                                <input type="text" class="form-control" id="firstName" required>
                            </div>
                            <div class="col-md-6">
                                <label for="lastName" class="form-label">Last Name *</label>
                                <input type="text" class="form-control" id="lastName" required>
                            </div>
                            <div class="col-12">
                                <label for="email" class="form-label">Email Address *</label>
                                <input type="email" class="form-control" id="email" required>
                            </div>
                            <div class="col-12">
                                <label for="phone" class="form-label">Phone Number *</label>
                                <input type="tel" class="form-control" id="phone" required>
                            </div>
                            <div class="col-12">
                                <label for="address" class="form-label">Address *</label>
                                <input type="text" class="form-control" id="address" placeholder="Street address" required>
                            </div>
                            <div class="col-md-4">
                                <label for="city" class="form-label">City *</label>
                                <input type="text" class="form-control" id="city" required>
                            </div>
                            <div class="col-md-4">
                                <label for="state" class="form-label">State *</label>
                                <select class="form-select" id="state" required>
                                    <option value="">Select State</option>
                                    <option value="CA">California</option>
                                    <option value="NY">New York</option>
                                    <option value="TX">Texas</option>
                                    <option value="FL">Florida</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="zipCode" class="form-label">ZIP Code *</label>
                                <input type="text" class="form-control" id="zipCode" required>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Payment Information -->
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-credit-card me-2"></i>Payment Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="cardNumber" class="form-label">Card Number *</label>
                            <input type="text" class="form-control" id="cardNumber" placeholder="1234 5678 9012 3456" required>
                        </div>
                        <div class="col-md-6">
                            <label for="expiryDate" class="form-label">Expiry Date *</label>
                            <input type="text" class="form-control" id="expiryDate" placeholder="MM/YY" required>
                        </div>
                        <div class="col-md-6">
                            <label for="cvv" class="form-label">CVV *</label>
                            <input type="text" class="form-control" id="cvv" placeholder="123" required>
                        </div>
                        <div class="col-12">
                            <label for="cardholderName" class="form-label">Cardholder Name *</label>
                            <input type="text" class="form-control" id="cardholderName" required>
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="saveCard">
                                <label class="form-check-label" for="saveCard">
                                    Save card for future purchases
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-4">
            <div class="card shadow-sm sticky-top" style="top: 2rem;">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-cart-check me-2"></i>Order Summary
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Cart Items -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <img src="https://via.placeholder.com/60x60/6c757d/ffffff?text=Product" alt="Product" class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">iPhone 15 Pro</h6>
                                <small class="text-muted">Qty: 1</small>
                            </div>
                            <span class="fw-semibold">$999.00</span>
                        </div>

                        <div class="d-flex align-items-center">
                            <img src="https://via.placeholder.com/60x60/6c757d/ffffff?text=Product" alt="Product" class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">MacBook Pro</h6>
                                <small class="text-muted">Qty: 1</small>
                            </div>
                            <span class="fw-semibold">$1,999.00</span>
                        </div>
                    </div>

                    <!-- Order Totals -->
                    <div class="border-top pt-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <span>$2,998.00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Shipping</span>
                            <span class="text-success">Free</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Tax</span>
                            <span>$239.84</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold fs-5">
                            <span>Total</span>
                            <span>$3,237.84</span>
                        </div>
                    </div>

                    <!-- Checkout Button -->
                    <button onclick="processCheckout()" class="btn btn-primary btn-lg w-100 mt-4">
                        <i class="bi bi-lock me-2"></i>Complete Order
                    </button>

                    <!-- Security Notice -->
                    <div class="text-center mt-3">
                        <small class="text-muted">
                            <i class="bi bi-shield-check me-1"></i>
                            Secure checkout with SSL encryption
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
async function processCheckout() {
    // Show loading
    window.utils.showLoading('Processing Order', 'Please wait while we process your order...');
    
    try {
        // Simulate API call
        await new Promise(resolve => setTimeout(resolve, 3000));
        
        // Close loading
        window.utils.closeLoading();
        
        // Show success and redirect
        await window.utils.showSuccess('Order Placed!', 'Your order has been successfully placed. You will receive a confirmation email shortly.');
        
        // Redirect to success page
        window.location.href = '{{ route("checkout.success") }}';
        
    } catch (error) {
        window.utils.closeLoading();
        await window.utils.showError('Checkout Failed', 'There was an error processing your order. Please try again.');
    }
}

// Form validation
document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    e.preventDefault();
    processCheckout();
});
</script>
@endsection
