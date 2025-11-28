@extends('layouts.storefront')

@section('title', 'Account Settings - Electronics Store')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}">My Account</a></li>
            <li class="breadcrumb-item active">Settings</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-3">
            @include('customer.partials.sidebar')
        </div>
        <div class="col-lg-9">
            <h1 class="h4 mb-3">Account Settings</h1>

            <div class="row g-3">
                <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <h6 class="mb-0">Profile</h6>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control" value="{{ Auth::guard('customer')->user()->first_name ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control" value="{{ Auth::guard('customer')->user()->last_name ?? '' }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="{{ Auth::guard('customer')->user()->email ?? '' }}" disabled>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary">Save Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
                </div>

                <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <h6 class="mb-0">Security</h6>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Current Password</label>
                                <input type="password" class="form-control" placeholder="Current password">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">New Password</label>
                                <input type="password" class="form-control" placeholder="New password">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" placeholder="Confirm new password">
                            </div>
                            <div class="col-12">
                                <button class="btn btn-outline-primary">Update Password</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


