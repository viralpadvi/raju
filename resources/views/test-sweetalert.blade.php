@extends('layouts.storefront')

@section('title', 'SweetAlert2 Test Page')

@section('content')
<div class="container py-5">
    <h1 class="display-6 fw-bold mb-5">SweetAlert2 Test Page</h1>
    
    <div class="row g-4">
        <!-- Basic Alerts -->
        <div class="col-lg-4 col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-bell me-2"></i>Basic Alerts
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button onclick="window.utils.showSuccess('Success!', 'Operation completed successfully')" 
                                class="btn btn-success">
                            <i class="bi bi-check-circle me-2"></i>Success Alert
                        </button>
                        <button onclick="window.utils.showError('Error!', 'Something went wrong')" 
                                class="btn btn-danger">
                            <i class="bi bi-exclamation-circle me-2"></i>Error Alert
                        </button>
                        <button onclick="window.utils.showWarning('Warning!', 'Please be careful')" 
                                class="btn btn-warning">
                            <i class="bi bi-exclamation-triangle me-2"></i>Warning Alert
                        </button>
                        <button onclick="window.utils.showInfo('Info', 'Here is some information')" 
                                class="btn btn-info">
                            <i class="bi bi-info-circle me-2"></i>Info Alert
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Confirmation Dialogs -->
        <div class="col-lg-4 col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-question-circle me-2"></i>Confirmations
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button onclick="window.utils.showConfirm('Confirm Action', 'Are you sure you want to proceed?')" 
                                class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Basic Confirm
                        </button>
                        <button onclick="window.utils.showDeleteConfirm('Delete Item', 'This action cannot be undone!')" 
                                class="btn btn-danger">
                            <i class="bi bi-trash me-2"></i>Delete Confirm
                        </button>
                        <button onclick="testAsyncConfirm()" 
                                class="btn btn-outline-primary">
                            <i class="bi bi-arrow-clockwise me-2"></i>Async Confirm
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Toast Notifications -->
        <div class="col-lg-4 col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-chat-dots me-2"></i>Toast Notifications
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button onclick="window.utils.showToast('Success message!', 'success')" 
                                class="btn btn-success">
                            <i class="bi bi-check-circle me-2"></i>Success Toast
                        </button>
                        <button onclick="window.utils.showToast('Error message!', 'error')" 
                                class="btn btn-danger">
                            <i class="bi bi-exclamation-circle me-2"></i>Error Toast
                        </button>
                        <button onclick="window.utils.showToast('Warning message!', 'warning')" 
                                class="btn btn-warning">
                            <i class="bi bi-exclamation-triangle me-2"></i>Warning Toast
                        </button>
                        <button onclick="window.utils.showToast('Info message!', 'info')" 
                                class="btn btn-info">
                            <i class="bi bi-info-circle me-2"></i>Info Toast
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loading States -->
        <div class="col-lg-4 col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-hourglass-split me-2"></i>Loading States
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button onclick="window.utils.showLoading('Processing...', 'Please wait')" 
                                class="btn btn-primary">
                            <i class="bi bi-arrow-clockwise me-2"></i>Show Loading
                        </button>
                        <button onclick="testLoadingSequence()" 
                                class="btn btn-secondary">
                            <i class="bi bi-arrow-repeat me-2"></i>Loading Sequence
                        </button>
                        <button onclick="setTimeout(() => window.utils.closeLoading(), 3000)" 
                                class="btn btn-outline-primary">
                            <i class="bi bi-timer me-2"></i>Auto Close (3s)
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dark Mode Toggle -->
        <div class="col-lg-4 col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-moon me-2"></i>Dark Mode
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button onclick="toggleDarkMode()" 
                                class="btn btn-primary">
                            <i class="bi bi-moon-fill me-2"></i>Toggle Dark Mode
                        </button>
                        <button onclick="window.utils.showInfo('Dark Mode', 'This alert will adapt to the current theme')" 
                                class="btn btn-outline-primary">
                            <i class="bi bi-palette me-2"></i>Theme Test
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cart Simulation -->
        <div class="col-lg-4 col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-cart me-2"></i>Cart Simulation
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button onclick="simulateAddToCart()" 
                                class="btn btn-success">
                            <i class="bi bi-cart-plus me-2"></i>Add to Cart
                        </button>
                        <button onclick="simulateRemoveFromCart()" 
                                class="btn btn-warning">
                            <i class="bi bi-cart-dash me-2"></i>Remove from Cart
                        </button>
                        <button onclick="simulateClearCart()" 
                                class="btn btn-danger">
                            <i class="bi bi-cart-x me-2"></i>Clear Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alpine.js Test -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card" x-data="cartTest()">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-gear me-2"></i>Alpine.js Integration Test
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <span class="me-3">Cart Count:</span>
                                <span class="badge bg-primary fs-6" x-text="count"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex gap-2">
                                <button @click="addItem()" class="btn btn-success btn-sm">
                                    <i class="bi bi-plus me-1"></i>Add Item
                                </button>
                                <button @click="removeItem()" class="btn btn-warning btn-sm">
                                    <i class="bi bi-dash me-1"></i>Remove Item
                                </button>
                                <button @click="clearCart()" class="btn btn-danger btn-sm">
                                    <i class="bi bi-x me-1"></i>Clear Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Test functions
async function testAsyncConfirm() {
    const result = await window.utils.showConfirm('Async Confirm', 'This is an async confirmation dialog');
    if (result.isConfirmed) {
        window.utils.showToast('You confirmed!', 'success');
    } else {
        window.utils.showToast('You cancelled!', 'info');
    }
}

function testLoadingSequence() {
    window.utils.showLoading('Step 1', 'Processing data...');
    
    setTimeout(() => {
        window.utils.closeLoading();
        window.utils.showLoading('Step 2', 'Saving changes...');
        
        setTimeout(() => {
            window.utils.closeLoading();
            window.utils.showSuccess('Complete!', 'All operations completed successfully');
        }, 2000);
    }, 2000);
}

function toggleDarkMode() {
    document.documentElement.classList.toggle('dark');
    const isDark = document.documentElement.classList.contains('dark');
    localStorage.setItem('darkMode', isDark);
    window.utils.showToast(`Switched to ${isDark ? 'dark' : 'light'} mode`, 'info');
}

function simulateAddToCart() {
    window.utils.showToast('iPhone 15 Pro added to cart!', 'success');
}

async function simulateRemoveFromCart() {
    const result = await window.utils.showDeleteConfirm('Remove Item', 'Are you sure you want to remove iPhone 15 Pro from your cart?');
    if (result.isConfirmed) {
        window.utils.showToast('Item removed from cart', 'info');
    }
}

async function simulateClearCart() {
    const result = await window.utils.showDeleteConfirm('Clear Cart', 'Are you sure you want to remove all items from your cart?');
    if (result.isConfirmed) {
        window.utils.showToast('Cart cleared', 'info');
    }
}

// Alpine.js component
function cartTest() {
    return {
        count: 0,
        
        addItem() {
            this.count++;
            window.utils.showToast('Item added!', 'success');
        },
        
        async removeItem() {
            if (this.count > 0) {
                const result = await window.utils.showDeleteConfirm('Remove Item', 'Are you sure?');
                if (result.isConfirmed) {
                    this.count--;
                    window.utils.showToast('Item removed!', 'info');
                }
            } else {
                window.utils.showWarning('Empty Cart', 'No items to remove');
            }
        },
        
        async clearCart() {
            if (this.count > 0) {
                const result = await window.utils.showDeleteConfirm('Clear Cart', 'Remove all items?');
                if (result.isConfirmed) {
                    this.count = 0;
                    window.utils.showToast('Cart cleared!', 'info');
                }
            } else {
                window.utils.showInfo('Empty Cart', 'Cart is already empty');
            }
        }
    }
}
</script>
@endsection
