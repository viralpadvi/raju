@extends('layouts.pos')

@section('title', 'POS')

@section('content')
  <div class="row g-4">
    <div class="col-12 col-lg-8">
      <div class="card card-quiet mb-3">
        <div class="card-body">
          <h2 class="h6 mb-3">Scan or Search</h2>
          <input type="text" class="form-control form-control" placeholder="Scan barcode or type to search..." />
        </div>
      </div>
      <div class="card card-quiet">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <h2 class="h6 m-0">Cart</h2>
            <span class="small text-muted">F2: add item • Del: remove</span>
          </div>
          <div id="pos-cart" data-props='{}'></div>
        </div>
      </div>
    </div>
    <div class="col-12 col-lg-4">
      <div class="card card-quiet position-sticky" style="top: 5rem;">
        <div class="card-body">
          <h2 class="h6 mb-3">Summary</h2>
          <dl class="row small mb-3">
            <dt class="col">Subtotal</dt><dd class="col text-end">$0.00</dd>
            <dt class="col">Tax</dt><dd class="col text-end">$0.00</dd>
            <dt class="col fw-semibold">Total</dt><dd class="col text-end fw-semibold">$0.00</dd>
          </dl>
          <button class="btn btn-primary w-100">Pay</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Mobile checkout bar -->
  <div class="d-md-none fixed-bottom bg-white border-top py-2 px-3 d-flex align-items-center justify-content-between">
    <div class="small"><span class="text-muted">Total:</span> <span id="mobile-total" class="fw-semibold">$0.00</span></div>
    <button class="btn btn-primary btn-sm">Pay</button>
  </div>
@endsection

@section('scripts')
  <script type="module">
    import PosCart from '/js/pos-cart.js';
    const { createApp } = window.Vue;
    const mount = document.getElementById('pos-cart');
    if (mount && createApp) {
      createApp(PosCart, JSON.parse(mount.dataset.props || '{}')).mount(mount);
    }
    window.addEventListener('pos-total-changed', (e) => {
      const el = document.getElementById('mobile-total');
      if (el) el.textContent = `$${Number(e.detail.total || 0).toFixed(2)}`;
    });
  </script>
@endsection


