@extends('layouts.storefront')

@section('title', 'My Orders - Electronics Store')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}">My Account</a></li>
            <li class="breadcrumb-item active">Orders</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-3">
            @include('customer.partials.sidebar')
        </div>
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="h4 mb-0">My Orders</h1>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @for($i = 1; $i <= 10; $i++)
                                <tr>
                                    <td>#{{ 1000 + $i }}</td>
                                    <td>{{ now()->subDays($i)->format('M d, Y') }}</td>
                                    <td>
                                        <span class="badge bg-{{ ['secondary','primary','warning','success'][($i % 4)] }}">
                                            {{ ['Pending','Processing','Shipped','Delivered'][($i % 4)] }}
                                        </span>
                                    </td>
                                    <td>${{ rand(49, 799) }}.99</td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-outline-primary btn-sm">View</a>
                                    </td>
                                </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


