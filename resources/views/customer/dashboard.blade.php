@extends('layouts.storefront')

@section('title', 'My Account - Electronics Store')

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">My Account</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3">
            @include('customer.partials.sidebar')
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">
            <!-- Welcome Section -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="mb-2">Welcome back, {{ $customer->first_name ?: $customer->email }}!</h4>
                            <p class="text-muted mb-0">Manage your account settings and view your order history</p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                <span class="text-primary fw-bold fs-1">{{ substr($customer->first_name ?: $customer->email, 0, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="card border-0 bg-primary bg-opacity-10">
                        <div class="card-body text-center">
                            <i class="bi bi-bag fs-1 text-primary mb-2"></i>
                            <h5 class="text-primary">12</h5>
                            <p class="text-muted mb-0">Total Orders</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 bg-success bg-opacity-10">
                        <div class="card-body text-center">
                            <i class="bi bi-heart fs-1 text-success mb-2"></i>
                            <h5 class="text-success">8</h5>
                            <p class="text-muted mb-0">Wishlist Items</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 bg-warning bg-opacity-10">
                        <div class="card-body text-center">
                            <i class="bi bi-star fs-1 text-warning mb-2"></i>
                            <h5 class="text-warning">4.8</h5>
                            <p class="text-muted mb-0">Average Rating</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 bg-info bg-opacity-10">
                        <div class="card-body text-center">
                            <i class="bi bi-currency-dollar fs-1 text-info mb-2"></i>
                            <h5 class="text-info">$2,450</h5>
                            <p class="text-muted mb-0">Total Spent</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Recent Orders</h6>
                    <a href="{{ route('customer.orders') }}" class="btn btn-outline-primary btn-sm">View All</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for($i = 1; $i <= 3; $i++)
                                <tr>
                                    <td>#{{ rand(1000, 9999) }}</td>
                                    <td>{{ now()->subDays(rand(1, 30))->format('M d, Y') }}</td>
                                    <td>
                                        <span class="badge bg-{{ ['success', 'warning', 'primary'][rand(0, 2)] }}">
                                            {{ ['Delivered', 'Processing', 'Shipped'][rand(0, 2)] }}
                                        </span>
                                    </td>
                                    <td>${{ rand(99, 999) }}.99</td>
                                    <td>
                                        <a href="#" class="btn btn-outline-primary btn-sm">View</a>
                                    </td>
                                </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Wishlist -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Wishlist</h6>
                    <a href="{{ route('customer.wishlist') }}" class="btn btn-outline-primary btn-sm">View All</a>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @for($i = 1; $i <= 3; $i++)
                        <div class="col-md-4">
                            <div class="d-flex align-items-center">
                                <img src="https://via.placeholder.com/60x60/6c757d/ffffff?text=W{{ $i }}" alt="Product" class="rounded me-3">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Wishlist Product {{ $i }}</h6>
                                    <p class="text-muted small mb-1">${{ rand(99, 599) }}.99</p>
                                    <button class="btn btn-primary btn-sm">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>

            <!-- Account Information -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Account Information</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Full Name</label>
                            <p class="text-muted">{{ $customer->first_name }} {{ $customer->last_name }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email</label>
                            <p class="text-muted">{{ $customer->email }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Phone</label>
                            <p class="text-muted">{{ $customer->phone ?: 'Not provided' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Member Since</label>
                            <p class="text-muted">{{ $customer->created_at->format('F Y') }}</p>
                        </div>
                        <div class="col-12">
                            <a href="{{ route('customer.settings') }}" class="btn btn-outline-primary">Edit Profile</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
