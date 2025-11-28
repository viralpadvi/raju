<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('description', 'Your trusted partner for the latest electronics and gadgets. Quality products at competitive prices.')">
    <meta name="keywords" content="@yield('keywords', 'electronics, gadgets, smartphones, laptops, tablets, audio, gaming')">
    <meta name="author" content="ElectroStore">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Electronics Store')">
    <meta property="og:description" content="@yield('description', 'Your trusted partner for the latest electronics and gadgets.')">
    <meta property="og:image" content="@yield('og:image', asset('images/og-image.jpg'))">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', 'Electronics Store')">
    <meta property="twitter:description" content="@yield('description', 'Your trusted partner for the latest electronics and gadgets.')">
    <meta property="twitter:image" content="@yield('og:image', asset('images/og-image.jpg'))">
    
    <title>@yield('title', 'ElectroStore - Premium Electronics & Gadgets')</title>
    
    <!-- Preconnect to external domains -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png') }}">
    
    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    @stack('styles')
</head>
<body class="bg-light" x-data="{ 
    mobileMenuOpen: false, 
    searchOpen: false,
    cartOpen: false,
    darkMode: localStorage.getItem('darkMode') === 'true' || false
}" :class="{ 'dark': darkMode }" x-init="
    $watch('darkMode', value => localStorage.setItem('darkMode', value))
">
    <!-- Header -->
    <header class="bg-white shadow-sm sticky-top">
        <!-- Top Bar -->
        <div class="bg-primary text-white py-2">
        <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-3">
                            <span><i class="bi bi-phone me-1"></i> +1 (555) 123-4567</span>
                            <span><i class="bi bi-envelope me-1"></i> support@electrostore.com</span>
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="d-flex align-items-center justify-content-end gap-3">
                            <span class="d-none d-md-inline">Free shipping on orders over $99</span>
                            <button id="dark-mode-toggle" class="btn btn-link text-white p-1">
                                <i class="bi bi-moon-fill"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Header -->
        <div class="container py-3">
            <div class="row align-items-center">
                <!-- Logo -->
                <div class="col-lg-2 col-md-3 col-6">
                    <a href="{{ route('home') }}" class="text-decoration-none">
                        <h2 class="h4 mb-0 text-primary">
                            <i class="bi bi-lightning-charge-fill me-2"></i>ElectroStore
                        </h2>
                    </a>
                </div>
                
                <!-- Search Bar -->
                <div class="col-lg-6 col-md-5 d-none d-md-block" x-data="{ searchOpen: false }">
                    <div class="position-relative">
                        <input type="text" 
                               class="form-control form-control-lg ps-5" 
                               placeholder="Search for products, brands, and more..."
                               x-model="searchQuery"
                               @focus="searchOpen = true"
                               @blur="setTimeout(() => searchOpen = false, 200)">
                        <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        
                        <!-- Search Results Dropdown -->
                        <div x-show="searchOpen" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="position-absolute top-100 start-0 end-0 mt-2 bg-white rounded-3 shadow-lg border z-50"
                             style="display: none;">
                            <div class="p-3">
                                <p class="text-muted small mb-0">Search results will appear here...</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Header Actions -->
                <div class="col-lg-4 col-md-4 col-6">
                    <div class="d-flex align-items-center justify-content-end gap-3">
                        <!-- Branch Selector -->
                        <div class="dropdown" x-data="{ branchOpen: false }">
                            <button class="btn btn-link text-decoration-none dropdown-toggle" 
                                    type="button" 
                                    @click="branchOpen = !branchOpen">
                                <i class="bi bi-geo-alt me-1"></i>
                                <span class="d-none d-sm-inline">Branch</span>
                            </button>
                            <ul class="dropdown-menu" x-show="branchOpen" style="display: none;">
                                <li><h6 class="dropdown-header">Select Branch</h6></li>
                                <li><label class="dropdown-item"><input type="radio" name="branch" value="main" class="me-2" checked> Main Store</label></li>
                                <li><label class="dropdown-item"><input type="radio" name="branch" value="mall" class="me-2"> Mall Branch</label></li>
                                <li><label class="dropdown-item"><input type="radio" name="branch" value="online" class="me-2"> Online Only</label></li>
                            </ul>
                        </div>
                        
                        <!-- Wishlist -->
                        <a href="{{ route('wishlist') }}" class="btn btn-link text-decoration-none position-relative">
                            <i class="bi bi-heart fs-5"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">3</span>
                        </a>

                        <!-- Cart -->
                        <button class="btn btn-link text-decoration-none position-relative" @click="cartOpen = true">
                            <i class="bi bi-cart3 fs-5"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">5</span>
                        </button>
                        
                        <!-- User Account -->
                        <div class="dropdown" x-data="{ userMenuOpen: false }">
                            <button class="btn btn-link text-decoration-none dropdown-toggle" 
                                    type="button" 
                                    @click="userMenuOpen = !userMenuOpen">
                                <i class="bi bi-person-circle fs-5"></i>
                                <span class="d-none d-sm-inline ms-1">Account</span>
                                </button>
                            <ul class="dropdown-menu dropdown-menu-end" x-show="userMenuOpen" style="display: none;">
                                <li><a class="dropdown-item" href="{{ route('login') }}">Sign In</a></li>
                                <li><a class="dropdown-item" href="{{ route('register') }}">Sign Up</a></li>
                                <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('customer.dashboard') }}">My Account</a></li>
                                    <li><a class="dropdown-item" href="{{ route('customer.orders') }}">My Orders</a></li>
                                <li><a class="dropdown-item" href="{{ route('wishlist') }}">Wishlist</a></li>
                                </ul>
                        </div>

                        <!-- Mobile Menu Toggle -->
                        <button class="btn btn-link d-lg-none" @click="mobileMenuOpen = true">
                            <i class="bi bi-list fs-5"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-top">
            <div class="container">
                <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                Categories
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('category', 'smartphones') }}">Smartphones</a></li>
                                <li><a class="dropdown-item" href="{{ route('category', 'laptops') }}">Laptops</a></li>
                                <li><a class="dropdown-item" href="{{ route('category', 'tablets') }}">Tablets</a></li>
                                <li><a class="dropdown-item" href="{{ route('category', 'audio') }}">Audio</a></li>
                                <li><a class="dropdown-item" href="{{ route('category', 'gaming') }}">Gaming</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('products') }}">All Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('deals') }}">Deals</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('brands') }}">Brands</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('projects.index') }}">Projects</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('about') }}">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="text-white mb-3 fw-bold">
                        <i class="bi bi-lightning-charge-fill me-2 text-primary"></i>ElectroStore
                    </h5>
                    <p class="text-light mb-3">Your trusted partner for the latest electronics and gadgets. Quality products at competitive prices.</p>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-white text-decoration-none fs-5"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-white text-decoration-none fs-5"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="text-white text-decoration-none fs-5"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-white text-decoration-none fs-5"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h6 class="text-white mb-3 fw-bold">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('home') }}" class="text-light text-decoration-none">Home</a></li>
                        <li class="mb-2"><a href="{{ route('products') }}" class="text-light text-decoration-none">Products</a></li>
                        <li class="mb-2"><a href="{{ route('projects.index') }}" class="text-light text-decoration-none">Projects</a></li>
                        <li class="mb-2"><a href="{{ route('deals') }}" class="text-light text-decoration-none">Deals</a></li>
                        <li class="mb-2"><a href="{{ route('about') }}" class="text-light text-decoration-none">About Us</a></li>
                        <li class="mb-2"><a href="{{ route('contact') }}" class="text-light text-decoration-none">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h6 class="text-white mb-3 fw-bold">Customer Service</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none">Help Center</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none">Shipping Info</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none">Returns</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none">Warranty</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none">Track Order</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h6 class="text-white mb-3 fw-bold">Newsletter</h6>
                    <p class="text-light mb-3">Subscribe to get updates on new products and exclusive deals.</p>
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="Enter your email">
                        <button class="btn btn-primary" type="button">Subscribe</button>
                    </div>
                </div>
            </div>
            <hr class="my-4 border-secondary">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="text-light mb-0">&copy; 2024 ElectroStore. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-end">
                    <div class="d-flex justify-content-end gap-3">
                        <a href="#" class="text-light text-decoration-none">Privacy Policy</a>
                        <a href="#" class="text-light text-decoration-none">Terms of Service</a>
                        <a href="#" class="text-light text-decoration-none">Cookie Policy</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Mobile Menu Offcanvas -->
    <div class="offcanvas offcanvas-start" tabindex="-1" x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Menu</h5>
            <button type="button" class="btn-close" @click="mobileMenuOpen = false"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="list-unstyled">
                <li class="mb-2"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
                <li class="mb-2"><a href="{{ route('products') }}" class="text-decoration-none">Products</a></li>
                <li class="mb-2"><a href="{{ route('deals') }}" class="text-decoration-none">Deals</a></li>
                <li class="mb-2"><a href="{{ route('brands') }}" class="text-decoration-none">Brands</a></li>
                <li class="mb-2"><a href="{{ route('about') }}" class="text-decoration-none">About</a></li>
                <li class="mb-2"><a href="{{ route('contact') }}" class="text-decoration-none">Contact</a></li>
            </ul>
        </div>
    </div>

    <!-- Cart Sidebar Offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" x-show="cartOpen" @click.away="cartOpen = false">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Shopping Cart</h5>
            <button type="button" class="btn-close" @click="cartOpen = false"></button>
        </div>
        <div class="offcanvas-body">
            <div class="text-center py-5">
                <i class="bi bi-cart3 fs-1 text-muted"></i>
                <p class="text-muted mt-3">Your cart is empty</p>
                <a href="{{ route('products') }}" class="btn btn-primary">Start Shopping</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5.3.3 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        // Global utilities
        window.utils = {
            // Format currency
            formatCurrency: (amount, currency = 'USD') => {
                return new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: currency
                }).format(amount);
            },
            
            // Format date
            formatDate: (date, options = {}) => {
                const defaultOptions = {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };
                return new Intl.DateTimeFormat('en-US', { ...defaultOptions, ...options }).format(new Date(date));
            },
            
            // Debounce function
            debounce: (func, wait) => {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            },
            
            // Show toast notification
            showToast: (message, type = 'info', duration = 3000) => {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: duration,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });

                Toast.fire({
                    icon: type,
                    title: message
                });
            },

            // SweetAlert2 Success Alert
            showSuccess: (title, text = '', options = {}) => {
                return Swal.fire({
                    icon: 'success',
                    title: title,
                    text: text,
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#0d6efd',
                    ...options
                });
            },

            // SweetAlert2 Error Alert
            showError: (title, text = '', options = {}) => {
                return Swal.fire({
                    icon: 'error',
                    title: title,
                    text: text,
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#dc3545',
                    ...options
                });
            },

            // SweetAlert2 Warning Alert
            showWarning: (title, text = '', options = {}) => {
                return Swal.fire({
                    icon: 'warning',
                    title: title,
                    text: text,
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#ffc107',
                    ...options
                });
            },

            // SweetAlert2 Info Alert
            showInfo: (title, text = '', options = {}) => {
                return Swal.fire({
                    icon: 'info',
                    title: title,
                    text: text,
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#0dcaf0',
                    ...options
                });
            },

            // SweetAlert2 Confirmation Dialog
            showConfirm: (title, text = '', options = {}) => {
                return Swal.fire({
                    title: title,
                    text: text,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                    confirmButtonColor: '#198754',
                    cancelButtonColor: '#6c757d',
                    ...options
                });
            },

            // SweetAlert2 Delete Confirmation
            showDeleteConfirm: (title = 'Are you sure?', text = "You won't be able to revert this!", options = {}) => {
                return Swal.fire({
                    title: title,
                    text: text,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    ...options
                });
            },

            // SweetAlert2 Loading Alert
            showLoading: (title = 'Loading...', text = 'Please wait') => {
                Swal.fire({
                    title: title,
                    text: text,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },

            // Close Loading Alert
            closeLoading: () => {
                Swal.close();
            }
        };

        // Initialize common functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize dark mode toggle
            const darkModeToggle = document.getElementById('dark-mode-toggle');
            if (darkModeToggle) {
                darkModeToggle.addEventListener('click', function() {
                    document.documentElement.classList.toggle('dark');
                    const isDark = document.documentElement.classList.contains('dark');
                    localStorage.setItem('darkMode', isDark);
                });
                
                // Load saved dark mode preference
                const savedDarkMode = localStorage.getItem('darkMode');
                if (savedDarkMode === 'true') {
                    document.documentElement.classList.add('dark');
                }
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>