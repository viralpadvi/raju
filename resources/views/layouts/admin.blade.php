<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Panel')</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.0/mdb.min.css">
    <link rel="stylesheet" href="/css/custom.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
  </head>
  <body style="font-family: Roboto, system-ui, -apple-system, Segoe UI, Arial, sans-serif; background-color: #f5f7fa;">
    <!-- Header Bar -->
    <header class="hospital-header">
      <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between" style="height: 64px;">
          <!-- Left: Logo and Hamburger -->
          <div class="d-flex align-items-center gap-3">
            <button class="btn btn-link p-0 d-md-none" type="button" data-mdb-toggle="offcanvas" data-mdb-target="#adminSidebar" aria-controls="adminSidebar" aria-label="Open menu">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
              </svg>
            </button>
            <a href="{{ route('admin.dashboard') }}" class="hospital-logo d-flex align-items-center gap-2 text-decoration-none">
              <div class="hospital-logo-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#14b8a6" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                  <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                  <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                  <circle cx="12" cy="12" r="1"></circle>
                </svg>
              </div>
              <span class="hospital-logo-text">A R Electronics</span>
            </a>
          </div>

          <!-- Right: Chat, Notifications, User Profile -->
          <div class="d-flex align-items-center gap-3">
            <!-- Chat Icon -->
            <button class="btn btn-link p-2 text-muted position-relative" title="Chat" aria-label="Chat">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
              </svg>
            </button>

            <!-- Notifications Icon -->
            <button class="btn btn-link p-2 text-muted position-relative" title="Notifications" aria-label="Notifications">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
              </svg>
            </button>

            <!-- User Profile Dropdown -->
            <div class="dropdown">
              <button class="btn btn-link p-0 d-flex align-items-center gap-2 text-decoration-none text-dark" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="hospital-avatar">
                  <span>{{ strtoupper(substr(session('admin_user.name', Auth::user()->name ?? 'Admin'), 0, 1)) }}</span>
                </div>
                <span class="d-none d-md-inline fw-semibold" style="font-size: 0.875rem;">ADMIN USER</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="d-none d-md-inline">
                  <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
              </button>
              <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="userMenu">
                <li><a class="dropdown-item" href="{{ url('/admin/settings') }}">Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                  <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger d-flex align-items-center w-100 border-0 bg-transparent" style="padding: 0.5rem 1rem;">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 0.5rem; flex-shrink: 0;">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                      </svg>
                      <span>Logout</span>
                    </button>
                  </form>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- Mobile offcanvas sidebar -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="adminSidebar" aria-labelledby="adminSidebarLabel" style="background-color: #ffffff;">
      <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title fw-semibold" id="adminSidebarLabel">Menu</h5>
        <button type="button" class="btn-close" data-mdb-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body p-0">
        <div class="hospital-sidebar">
          @include('admin.partials.sidebar', ['prefix' => 'offcanvas-'])
        </div>
      </div>
    </div>

    <!-- Mobile icon rail -->
    <div class="d-md-none mobile-rail">
      <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" title="Dashboard" aria-label="Dashboard">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>
      </a>
      <a href="{{ route('admin.catalog.products.index') }}" class="{{ request()->is('admin/catalog/products*') ? 'active' : '' }}" title="Products" aria-label="Products">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M3 7l9-4 9 4-9 4-9-4zm0 6l9 4 9-4"/><path d="M3 7v10l9 4 9-4V7" fill="none"/></svg>
      </a>
      <a href="{{ url('/admin/branches') }}" class="{{ request()->is('admin/branches*') ? 'active' : '' }}" title="Branches" aria-label="Branches">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M4 4h16v2H4V4zm0 4h16v12H4V8z"/></svg>
      </a>
      <a href="{{ route('admin.pos') }}" class="{{ request()->routeIs('admin.pos') ? 'active' : '' }}" title="POS Terminal" aria-label="POS Terminal">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M3 7h18v2H3zM3 11h18v2H3zM3 15h18v2H3z"/></svg>
      </a>
      <a href="{{ url('/admin/reports') }}" class="{{ request()->is('admin/reports*') ? 'active' : '' }}" title="Reports" aria-label="Reports">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M3 13h2v8H3v-8zm8-6h2v14h-2V7zM19 3h2v18h-2V3z"/></svg>
      </a>
      <a href="{{ url('/admin/settings') }}" class="{{ request()->is('admin/settings*') ? 'active' : '' }}" title="Settings" aria-label="Settings">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M19.14 12.94a7.07 7.07 0 000-1.88l2.03-1.58a.5.5 0 00.12-.64l-1.92-3.32a.5.5 0 00-.6-.22l-2.39.96a7.07 7.07 0 00-1.63-.95l-.36-2.54a.5.5 0 00-.5-.42h-3.84a.5.5 0 00-.5.42l-.36 2.54a7.07 7.07 0 00-1.63.95l-2.39-.96a.5.5 0 00-.6.22L2.71 8.84a.5.5 0 00.12.64l2.03 1.58a7.07 7.07 0 000 1.88l-2.03 1.58a.5.5 0 00-.12.64l1.92 3.32a.5.5 0 00.6.22l2.39-.96c.5.4 1.05.73 1.63.95l.36 2.54a.5.5 0 00.5.42h3.84a.5.5 0 00.5-.42l.36-2.54c.58-.22 1.13-.55 1.63-.95l2.39.96a.5.5 0 00.6-.22l1.92-3.32a.5.5 0 00-.12-.64l-2.03-1.58zM12 15.5a3.5 3.5 0 110-7 3.5 3.5 0 010 7z"/></svg>
      </a>
    </div>

    <div class="container-fluid px-4 py-4 content-with-rail">
      <div class="row g-4">
        <div class="col-md-3 col-lg-2 d-none d-md-block">
          <div class="hospital-sidebar-wrapper sticky-top" style="top: 80px;">
            <div class="hospital-sidebar">
              @include('admin.partials.sidebar')
            </div>
          </div>
        </div>
        <div class="col">
          @yield('content')
        </div>
      </div>
    </div>

    <!-- Bootstrap 5.3.3 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- MDB UI Kit JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.0/mdb.umd.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    
    <!-- Stack for additional styles -->
    @stack('styles')
    
    <!-- Custom JavaScript -->
    <script>
        // Global utilities
        window.utils = {
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
                    confirmButtonColor: '#10b981',
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
                    confirmButtonColor: '#ef4444',
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
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
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
    </script>
    
    @if(session('status') || session('success') || session('error'))
      <script>
        document.addEventListener('DOMContentLoaded', function() {
          const msg = @json(session('status') ?? session('success') ?? session('error'));
          const type = @json(session('error') ? 'error' : 'success');
          
          if (window.utils) {
            window.utils.showToast(msg, type);
          } else {
            // Fallback if utils not loaded yet
            setTimeout(() => {
              if (window.utils) {
                window.utils.showToast(msg, type);
              }
            }, 100);
          }
        });
      </script>
    @endif
    
    <!-- Stack for additional scripts -->
    @stack('scripts')
  </body>
</html>


