<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'POS')</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.0/mdb.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/css/custom.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  </head>
  <body style="font-family: Roboto, system-ui, -apple-system, Segoe UI, Arial, sans-serif;">
    <nav class="navbar navbar-light bg-white border-bottom sticky-top">
      <div class="container-xxl d-flex align-items-center justify-content-between">
        <a class="navbar-brand fw-semibold" href="{{ route('pos.index') }}">POS</a>
        <div class="d-flex align-items-center gap-2">
          <select class="form-select form-select-sm" style="width:auto">
            <option>Main Branch</option>
            <option>Branch 2</option>
          </select>
          <a class="small text-secondary" href="{{ url('/admin') }}">Admin</a>
        </div>
      </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
      @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.0/mdb.umd.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script type="module">
      import { createApp } from 'https://cdn.jsdelivr.net/npm/vue@3/dist/vue.esm-browser.js';
      window.Vue = { createApp };
    </script>
    @if(session('status') || session('success') || session('error'))
      <script>
        const msg = @json(session('status') ?? session('success') ?? session('error'));
        const type = @json(session('error') ? 'error' : 'success');
        Swal.fire({ icon: type, text: msg, timer: 2000, showConfirmButton: false });
      </script>
    @endif
    @yield('scripts')
  </body>
</html>


