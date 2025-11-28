<div class="card">
    <div class="card-header d-flex align-items-center gap-2">
        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
            <i class="bi bi-person text-primary"></i>
        </div>
        <div class="small">
            <div class="fw-semibold">{{ Auth::guard('customer')->user()->first_name ?? 'My Account' }}</div>
            <div class="text-muted">Customer</div>
        </div>
    </div>
    <div class="list-group list-group-flush">
        @php
            $counts = $counts ?? ['orders' => null, 'wishlist' => null, 'addresses' => null, 'payments' => null];
        @endphp
        <a href="{{ route('customer.dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('customer.dashboard') ? 'active' : '' }} d-flex justify-content-between align-items-center">
            <span><i class="bi bi-person me-2"></i>Profile</span>
        </a>
        <a href="{{ route('customer.orders') }}" class="list-group-item list-group-item-action {{ request()->routeIs('customer.orders') ? 'active' : '' }} d-flex justify-content-between align-items-center">
            <span><i class="bi bi-bag me-2"></i>My Orders</span>
            @if(!is_null($counts['orders']))<span class="badge bg-secondary rounded-pill">{{ $counts['orders'] }}</span>@endif
        </a>
        <a href="{{ route('customer.wishlist') }}" class="list-group-item list-group-item-action {{ request()->routeIs('customer.wishlist') ? 'active' : '' }} d-flex justify-content-between align-items-center">
            <span><i class="bi bi-heart me-2"></i>Wishlist</span>
            @if(!is_null($counts['wishlist']))<span class="badge bg-secondary rounded-pill">{{ $counts['wishlist'] }}</span>@endif
        </a>
        <a href="{{ route('customer.addresses') }}" class="list-group-item list-group-item-action {{ request()->routeIs('customer.addresses') ? 'active' : '' }} d-flex justify-content-between align-items-center">
            <span><i class="bi bi-geo-alt me-2"></i>Addresses</span>
            @if(!is_null($counts['addresses']))<span class="badge bg-secondary rounded-pill">{{ $counts['addresses'] }}</span>@endif
        </a>
        <a href="{{ route('customer.payments') }}" class="list-group-item list-group-item-action {{ request()->routeIs('customer.payments') ? 'active' : '' }} d-flex justify-content-between align-items-center">
            <span><i class="bi bi-credit-card me-2"></i>Payment Methods</span>
            @if(!is_null($counts['payments']))<span class="badge bg-secondary rounded-pill">{{ $counts['payments'] }}</span>@endif
        </a>
        <a href="{{ route('customer.settings') }}" class="list-group-item list-group-item-action {{ request()->routeIs('customer.settings') ? 'active' : '' }} d-flex justify-content-between align-items-center">
            <span><i class="bi bi-gear me-2"></i>Settings</span>
        </a>
        <hr class="my-1">
        <form method="POST" action="{{ route('logout') }}" class="d-inline">
            @csrf
            <button type="submit" class="list-group-item list-group-item-action text-danger text-start">
                <i class="bi bi-box-arrow-right me-2"></i>Logout
            </button>
        </form>
    </div>
</div>


