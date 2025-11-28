@extends('layouts.storefront')

@section('title', 'My Wishlist - Electronics Store')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}">My Account</a></li>
            <li class="breadcrumb-item active">Wishlist</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-3">
            @include('customer.partials.sidebar')
        </div>
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="h4 mb-0">My Wishlist</h1>
            </div>
            <div class="row g-3">
                @for($i = 1; $i <= 8; $i++)
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <img src="https://via.placeholder.com/300x200/6c757d/ffffff?text=Wishlist+{{ $i }}" class="card-img-top" alt="Wishlist {{ $i }}">
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title">Product {{ $i }}</h6>
                            <p class="text-muted small mb-2">${{ rand(49, 499) }}.99</p>
                            <div class="mt-auto d-flex gap-2">
                                <button class="btn btn-primary btn-sm flex-fill">Add to Cart</button>
                                <button class="btn btn-outline-danger btn-sm" title="Remove"><i class="bi bi-trash"></i></button>
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


