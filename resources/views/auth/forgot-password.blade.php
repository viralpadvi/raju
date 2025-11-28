@extends('layouts.storefront')

@section('title', 'Forgot Password - Electronics Store')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <!-- Header -->
                    <div class="text-center mb-4">
                        <h2 class="fw-bold text-primary mb-3">
                            <i class="bi bi-key me-2"></i>Forgot Password?
                        </h2>
                        <p class="text-muted">No worries! Enter your email and we'll send you a reset link.</p>
                    </div>

                    <!-- Status Messages -->
                    @if (session('status'))
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle me-2"></i>
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Reset Form -->
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required 
                                       autofocus
                                       placeholder="Enter your email address">
                            </div>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100 btn-lg mb-3">
                            <i class="bi bi-send me-2"></i>Send Reset Link
                        </button>
                    </form>

                    <!-- Help Text -->
                    <div class="text-center">
                        <p class="text-muted small">
                            <i class="bi bi-info-circle me-1"></i>
                            We'll send you a secure link to reset your password. Check your spam folder if you don't see it.
                        </p>
                    </div>

                    <!-- Back to Login -->
                    <div class="text-center mt-4">
                        <a href="{{ route('login') }}" class="text-primary text-decoration-none">
                            <i class="bi bi-arrow-left me-1"></i>Back to Login
                        </a>
                    </div>

                    <!-- Back to Store -->
                    <div class="text-center mt-2">
                        <a href="{{ route('home') }}" class="text-muted text-decoration-none">
                            <i class="bi bi-house me-1"></i>Back to Store
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
