@extends('layouts.storefront')

@section('title', 'My Addresses - Electronics Store')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}">My Account</a></li>
            <li class="breadcrumb-item active">Addresses</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-3">
            @include('customer.partials.sidebar')
        </div>
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="h4 mb-0">My Addresses</h1>
                <a href="#" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Add Address</a>
            </div>
            <div class="row g-3">
                @for($i = 1; $i <= 2; $i++)
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <h6 class="mb-0">{{ $i === 1 ? 'Default Shipping' : 'Billing Address' }}</h6>
                                <span class="badge bg-{{ $i === 1 ? 'primary' : 'secondary' }}">{{ $i === 1 ? 'Default' : 'Optional' }}</span>
                            </div>
                            <p class="mb-1">John Doe</p>
                            <p class="mb-1">123 Main Street</p>
                            <p class="mb-1">New York, NY 10001</p>
                            <p class="text-muted">United States</p>
                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-primary btn-sm">Edit</button>
                                <button class="btn btn-outline-danger btn-sm">Delete</button>
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


