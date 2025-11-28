<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Login')</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.0/mdb.min.css" integrity="sha512-K4o8k7cQm7m8z5c7yKf0CjLwZ0gqJY9m3rQYV1fVwQy0vE0kz3n6G+K2Qv5xg7j2YQk2xwX1v4Qf7v5m4vQYQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/css/custom.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
      body {
        font-family: 'Roboto', system-ui, -apple-system, Segoe UI, Arial, sans-serif;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
      }
      
      .login-container {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        padding: 0;
        overflow: hidden;
        max-width: 400px;
        width: 100%;
        margin: 20px;
      }
      
      .login-header {
        background: linear-gradient(135deg, #3f51b5 0%, #5c6bc0 100%);
        color: white;
        padding: 2rem;
        text-align: center;
      }
      
      .login-body {
        padding: 2rem;
      }
      
      .form-control {
        border-radius: 10px;
        border: 2px solid #e0e0e0;
        padding: 12px 16px;
        transition: all 0.3s ease;
      }
      
      .form-control:focus {
        border-color: #3f51b5;
        box-shadow: 0 0 0 0.2rem rgba(63, 81, 181, 0.25);
      }
      
      .form-control{
        background: #f7f9ff;
      }

      .btn-login {
        background: linear-gradient(135deg, #3f51b5 0%, #5c6bc0 100%);
        border: none;
        border-radius: 10px;
        padding: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
      }
      
      .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(63, 81, 181, 0.3);
      }
      
      .back-link {
        color: #666;
        text-decoration: none;
        transition: color 0.3s ease;
      }
      
      .back-link:hover {
        color: #3f51b5;
      }
      
      .alert {
        border-radius: 10px;
        border: none;
      }
      
      .form-check-input:checked {
        background-color: #3f51b5;
        border-color: #3f51b5;
      }
    </style>
  </head>
  <body>
    <div class="login-container">
      <div class="login-header">
          <div class="mb-3">
            <div class="bg-white bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center" style="width:64px;height:64px;">
              <i class="bi bi-check2-circle fs-2"></i>
            </div>
          </div>
          <h2 class="fw-bold mb-2">Admin Portal</h2>
          <p class="mb-0 opacity-75">Sign in to your admin account</p>
      </div>
      
      <div class="login-body">
        @if ($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        @if (session('success'))
          <div class="alert alert-success">
            {{ session('success') }}
          </div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}">
          @csrf
          
          <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Email Address</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                   id="email" name="email" value="{{ old('email') }}" required autofocus
                   placeholder="name@domain.com">
            @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="password" class="form-label fw-semibold">Password</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                   id="password" name="password" required
                   placeholder="••••••••">
            @error('password')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-4 form-check">
            <input type="checkbox" class="form-check-input" id="remember" name="remember">
            <label class="form-check-label" for="remember">
              Remember me
            </label>
          </div>

          <button type="submit" class="btn btn-primary btn-login w-100 mb-3">
            <i class="bi bi-person-fill me-2"></i>Sign In
          </button>

          <div class="text-center">
            <a href="{{ route('home') }}" class="back-link">
              <i class="bi bi-house me-1"></i>Back to Store
            </a>
          </div>
        </form>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.0/mdb.umd.min.js" integrity="sha512-2x2ZcN1A4sY0a7C8B0+6kZ1k7k5Zt0y2C2lJj3rNnQmYUs3xX0F4G2gT3x2v2YJcV4zS3dYQ4r1c8z4g8u8o9w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    
    @if(session('status') || session('success') || session('error'))
      <script>
        const msg = @json(session('status') ?? session('success') ?? session('error'));
        const type = @json(session('error') ? 'error' : 'success');
        Swal.fire({ 
          icon: type, 
          text: msg, 
          timer: 3000, 
          showConfirmButton: false,
          toast: true,
          position: 'top-end'
        });
      </script>
    @endif
  </body>
</html>
