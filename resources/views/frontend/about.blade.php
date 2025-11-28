@extends('layouts.storefront')

@section('title', 'About Us - Electronics Store')

@section('content')
<!-- Hero Section -->
<section class="bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-5 fw-bold mb-4">About ElectroStore</h1>
                <p class="lead">Your trusted partner for the latest electronics and gadgets. We've been serving customers with quality products and exceptional service since 2020.</p>
            </div>
            <div class="col-lg-6">
                <img src="https://via.placeholder.com/600x400/ffffff/007bff?text=About+Us" alt="About Us" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</section>

<!-- Our Story -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="mb-4">Our Story</h2>
                <p class="lead text-muted mb-4">
                    Founded in 2020, ElectroStore began as a small electronics retailer with a big vision: to make cutting-edge technology accessible to everyone. What started as a single store has grown into a trusted online destination for electronics enthusiasts worldwide.
                </p>
                <p class="text-muted">
                    We believe that technology should enhance your life, not complicate it. That's why we carefully curate our product selection, ensuring every item meets our high standards for quality, innovation, and value. Our team of tech experts is always on hand to help you find the perfect solution for your needs.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Our Values -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5">Our Values</h2>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="text-center">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-award fs-2 text-primary"></i>
                    </div>
                    <h5 class="mb-3">Quality First</h5>
                    <p class="text-muted">We only stock products from trusted brands that meet our rigorous quality standards.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="text-center">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-people fs-2 text-success"></i>
                    </div>
                    <h5 class="mb-3">Customer Focus</h5>
                    <p class="text-muted">Your satisfaction is our priority. We're here to help you find the perfect tech solution.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="text-center">
                    <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-lightning fs-2 text-warning"></i>
                    </div>
                    <h5 class="mb-3">Innovation</h5>
                    <p class="text-muted">We stay ahead of the curve, bringing you the latest and greatest in technology.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="text-center">
                    <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-shield-check fs-2 text-info"></i>
                    </div>
                    <h5 class="mb-3">Trust & Security</h5>
                    <p class="text-muted">Your data and transactions are protected with industry-leading security measures.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Team -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5">Meet Our Team</h2>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                            <span class="text-primary fw-bold fs-1">JD</span>
                        </div>
                        <h5 class="card-title">John Doe</h5>
                        <p class="text-muted">CEO & Founder</p>
                        <p class="small">Visionary leader with 15+ years in electronics retail. Passionate about bringing the latest technology to customers.</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="#" class="text-primary"><i class="bi bi-linkedin"></i></a>
                            <a href="#" class="text-primary"><i class="bi bi-twitter"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                            <span class="text-success fw-bold fs-1">SJ</span>
                        </div>
                        <h5 class="card-title">Sarah Johnson</h5>
                        <p class="text-muted">Head of Technology</p>
                        <p class="small">Tech expert who ensures we stay ahead of the latest trends and innovations in the electronics industry.</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="#" class="text-primary"><i class="bi bi-linkedin"></i></a>
                            <a href="#" class="text-primary"><i class="bi bi-github"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                            <span class="text-warning fw-bold fs-1">MC</span>
                        </div>
                        <h5 class="card-title">Mike Chen</h5>
                        <p class="text-muted">Customer Experience</p>
                        <p class="small">Dedicated to ensuring every customer has an exceptional shopping experience with us.</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="#" class="text-primary"><i class="bi bi-linkedin"></i></a>
                            <a href="#" class="text-primary"><i class="bi bi-envelope"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                            <span class="text-info fw-bold fs-1">ED</span>
                        </div>
                        <h5 class="card-title">Emily Davis</h5>
                        <p class="text-muted">Operations Manager</p>
                        <p class="small">Keeps everything running smoothly behind the scenes to ensure fast and reliable service.</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="#" class="text-primary"><i class="bi bi-linkedin"></i></a>
                            <a href="#" class="text-primary"><i class="bi bi-twitter"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <h2 class="text-center mb-5">By the Numbers</h2>
        <div class="row g-4 text-center">
            <div class="col-lg-3 col-md-6">
                <div class="h2 fw-bold mb-2">50K+</div>
                <p class="mb-0">Happy Customers</p>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="h2 fw-bold mb-2">10K+</div>
                <p class="mb-0">Products Sold</p>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="h2 fw-bold mb-2">4.9</div>
                <p class="mb-0">Average Rating</p>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="h2 fw-bold mb-2">24/7</div>
                <p class="mb-0">Customer Support</p>
            </div>
        </div>
    </div>
</section>

<!-- Our Mission -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <img src="https://via.placeholder.com/600x400/6c757d/ffffff?text=Our+Mission" alt="Our Mission" class="img-fluid rounded shadow">
            </div>
            <div class="col-lg-6">
                <h2 class="mb-4">Our Mission</h2>
                <p class="lead text-muted mb-4">
                    To democratize access to cutting-edge technology by providing high-quality electronics at competitive prices, backed by exceptional customer service.
                </p>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Curated selection of premium electronics</li>
                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Expert advice and technical support</li>
                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Fast and reliable shipping</li>
                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Comprehensive warranty coverage</li>
                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>30-day return policy</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Contact CTA -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="mb-4">Get in Touch</h2>
                <p class="lead text-muted mb-4">
                    Have questions about our products or need technical support? Our team is here to help!
                </p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('contact') }}" class="btn btn-primary btn-lg">
                        <i class="bi bi-envelope me-2"></i>Contact Us
                    </a>
                    <a href="tel:+15551234567" class="btn btn-outline-primary btn-lg">
                        <i class="bi bi-telephone me-2"></i>Call Us
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
