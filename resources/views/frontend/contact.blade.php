@extends('layouts.storefront')

@section('title', 'Contact Us - Electronics Store')

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Contact</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold mb-3">Contact Us</h1>
        <p class="lead text-muted">We're here to help! Get in touch with our team for any questions or support.</p>
    </div>

    <div class="row">
        <!-- Contact Form -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Send us a Message</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="firstName" class="form-label">First Name *</label>
                                <input type="text" class="form-control" id="firstName" required>
                            </div>
                            <div class="col-md-6">
                                <label for="lastName" class="form-label">Last Name *</label>
                                <input type="text" class="form-control" id="lastName" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email Address *</label>
                                <input type="email" class="form-control" id="email" required>
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="phone">
                            </div>
                            <div class="col-12">
                                <label for="subject" class="form-label">Subject *</label>
                                <select class="form-select" id="subject" required>
                                    <option value="">Select a subject</option>
                                    <option value="general">General Inquiry</option>
                                    <option value="support">Technical Support</option>
                                    <option value="order">Order Support</option>
                                    <option value="return">Returns & Exchanges</option>
                                    <option value="warranty">Warranty Claim</option>
                                    <option value="partnership">Business Partnership</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="message" class="form-label">Message *</label>
                                <textarea class="form-control" id="message" rows="5" placeholder="Please describe your inquiry in detail..." required></textarea>
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="newsletter">
                                    <label class="form-check-label" for="newsletter">
                                        Subscribe to our newsletter for updates and special offers
                                    </label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-send me-2"></i>Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="col-lg-4">
            <!-- Contact Details -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Get in Touch</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-start mb-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                            <i class="bi bi-telephone text-primary"></i>
                        </div>
                        <div>
                            <h6 class="mb-1">Phone</h6>
                            <p class="text-muted mb-0">+1 (555) 123-4567</p>
                            <small class="text-muted">Mon-Fri 9AM-6PM EST</small>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-start mb-3">
                        <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                            <i class="bi bi-envelope text-success"></i>
                        </div>
                        <div>
                            <h6 class="mb-1">Email</h6>
                            <p class="text-muted mb-0">support@electrostore.com</p>
                            <small class="text-muted">We'll respond within 24 hours</small>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-start mb-3">
                        <div class="bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                            <i class="bi bi-chat-dots text-warning"></i>
                        </div>
                        <div>
                            <h6 class="mb-1">Live Chat</h6>
                            <p class="text-muted mb-0">Available 24/7</p>
                            <small class="text-muted">Get instant help online</small>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-start">
                        <div class="bg-info bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                            <i class="bi bi-geo-alt text-info"></i>
                        </div>
                        <div>
                            <h6 class="mb-1">Address</h6>
                            <p class="text-muted mb-0">123 Tech Street<br>Electronics City, EC 12345</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Store Hours -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Store Hours</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Monday - Friday</span>
                        <span>9:00 AM - 6:00 PM</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Saturday</span>
                        <span>10:00 AM - 4:00 PM</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Sunday</span>
                        <span>Closed</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span><strong>Online Support</strong></span>
                        <span class="text-success"><strong>24/7</strong></span>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Quick Links</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <a href="#" class="text-decoration-none">
                                <i class="bi bi-question-circle me-2"></i>FAQ
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-decoration-none">
                                <i class="bi bi-truck me-2"></i>Shipping Info
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-decoration-none">
                                <i class="bi bi-arrow-clockwise me-2"></i>Returns & Exchanges
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-decoration-none">
                                <i class="bi bi-shield-check me-2"></i>Warranty
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-decoration-none">
                                <i class="bi bi-headphones me-2"></i>Technical Support
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Store Locations -->
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="text-center mb-5">Visit Our Stores</h3>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="bi bi-shop text-primary fs-4"></i>
                            </div>
                            <h5 class="card-title">Downtown Store</h5>
                            <p class="text-muted">123 Main Street<br>Downtown, City 12345</p>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="tel:+15551234567" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-telephone me-1"></i>Call
                                </a>
                                <a href="#" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-geo-alt me-1"></i>Directions
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="bi bi-shop text-success fs-4"></i>
                            </div>
                            <h5 class="card-title">Mall Location</h5>
                            <p class="text-muted">456 Shopping Mall<br>Westside, City 12345</p>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="tel:+15551234568" class="btn btn-outline-success btn-sm">
                                    <i class="bi bi-telephone me-1"></i>Call
                                </a>
                                <a href="#" class="btn btn-outline-success btn-sm">
                                    <i class="bi bi-geo-alt me-1"></i>Directions
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="bi bi-shop text-warning fs-4"></i>
                            </div>
                            <h5 class="card-title">Airport Terminal</h5>
                            <p class="text-muted">789 Airport Boulevard<br>Terminal 2, City 12345</p>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="tel:+15551234569" class="btn btn-outline-warning btn-sm">
                                    <i class="bi bi-telephone me-1"></i>Call
                                </a>
                                <a href="#" class="btn btn-outline-warning btn-sm">
                                    <i class="bi bi-geo-alt me-1"></i>Directions
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
