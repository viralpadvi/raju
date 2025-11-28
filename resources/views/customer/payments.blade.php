@extends('layouts.storefront')

@section('title', 'Payment Methods - Electronics Store')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}">My Account</a></li>
            <li class="breadcrumb-item active">Payment Methods</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-3">
            @include('customer.partials.sidebar')
        </div>
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="h4 mb-0">Payment Methods</h1>
                <a href="#" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Add Card</a>
            </div>
            <div class="row g-3">
                @for($i = 1; $i <= 2; $i++)
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center me-3" style="width: 44px; height: 44px;">
                                    <i class="bi bi-credit-card text-primary"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">Visa •••• {{ $i === 1 ? '4242' : '1111' }}</div>
                                    <div class="text-muted small">Expires {{ $i === 1 ? '04/27' : '08/26' }}</div>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-primary btn-sm">Set Default</button>
                                <button class="btn btn-outline-danger btn-sm">Remove</button>
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


