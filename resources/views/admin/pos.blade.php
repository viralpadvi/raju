@extends('layouts.admin')

@section('title', 'POS Terminal')

@section('content')
<div class="pos-container">
  <div class="row g-4 h-100">
    <!-- Left Section: Scan/Search & Cart -->
    <div class="col-12 col-lg-8">
      <!-- Scan or Search Card -->
      <div class="pos-glass-card mb-4">
        <div class="pos-card-header">
          <h2 class="pos-card-title">Scan or Search</h2>
        </div>
        <div class="pos-card-body">
          <div class="position-relative">
            <div class="pos-search-wrapper">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="pos-search-icon">
              <circle cx="11" cy="11" r="8"></circle>
              <path d="m21 21-4.35-4.35"></path>
            </svg>
            <input 
              type="text" 
              id="productSearch" 
              class="pos-search-input" 
              placeholder="Scan barcode or type to search..." 
              autocomplete="off"
              autofocus
            />
            </div>
            <div id="searchResults" class="pos-search-results"></div>
          </div>
          <div class="pos-shortcuts mt-3">
            <button class="pos-shortcut-btn" title="Add item">
              <kbd>F2</kbd> Add item
            </button>
            <button class="pos-shortcut-btn" title="Remove item">
              <kbd>Del</kbd> Remove
            </button>
            <button class="pos-shortcut-btn" title="Clear search">
              <kbd>Esc</kbd> Clear search
            </button>
          </div>
        </div>
      </div>

      <!-- Cart Card -->
      <div class="pos-glass-card">
        <div class="pos-card-header d-flex align-items-center justify-content-between">
          <h2 class="pos-card-title mb-0">Cart</h2>
          <button type="button" class="pos-clear-btn" id="clearCartBtn" style="display: none;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="3 6 5 6 21 6"></polyline>
              <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
            </svg>
            <span>Clear Cart</span>
          </button>
        </div>
        <div class="pos-card-body">
          <div id="cartItems" class="pos-cart-items">
            <div class="pos-empty-cart">
              <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="9" cy="21" r="1"></circle>
                <circle cx="20" cy="21" r="1"></circle>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
              </svg>
              <p>Cart is empty. Scan or search for products.</p>
            </div>
          </div>
        </div>
        </div>
      </div>

    <!-- Right Section: Summary & Payment -->
    <div class="col-12 col-lg-4">
      <div class="pos-glass-card pos-sticky-card">
        <div class="pos-card-header">
          <h2 class="pos-card-title">Summary</h2>
        </div>
        <div class="pos-card-body">
          <!-- Customer Selection -->
          <div class="pos-form-group">
          <div class="d-flex align-items-center justify-content-between mb-2">
              <label class="pos-form-label mb-0">Customer (Optional)</label>
              <button type="button" class="pos-add-customer-btn" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <line x1="12" y1="5" x2="12" y2="19"></line>
                  <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                <span>Register Customer</span>
              </button>
            </div>
            <div class="position-relative">
              <input type="text" id="customerSearch" class="pos-form-input" placeholder="Search customer..." autocomplete="off">
              <input type="hidden" id="customerId">
              <div id="customerResults" class="pos-customer-results"></div>
            </div>
            <div id="customerInfo" class="pos-customer-info" style="display: none;"></div>
          </div>

          <div class="pos-divider"></div>

          <!-- Summary Details -->
          <div class="pos-summary">
            <div class="pos-summary-row">
              <span class="pos-summary-label">Subtotal</span>
              <span class="pos-summary-value" id="subtotal">{{ $currencySymbol ?? '₹' }}0.00</span>
            </div>
            
            <div class="pos-summary-row">
              <span class="pos-summary-label">GST (%)</span>
              <div class="pos-summary-controls">
                <input type="number" id="taxRate" class="pos-input-small" value="0" min="0" max="100" step="0.1" placeholder="%">
                <span class="pos-summary-value" id="taxAmount">{{ $currencySymbol ?? '₹' }}0.00</span>
              </div>
            </div>
            
            <div class="pos-summary-row">
              <span class="pos-summary-label">Discount</span>
              <div class="pos-summary-controls">
                <select id="discountType" class="pos-select-small">
                  <option value="fixed">{{ $currencySymbol ?? '₹' }}</option>
                  <option value="percentage">%</option>
                </select>
                <input type="number" id="discountValue" class="pos-input-small" value="0" min="0" step="0.01">
                <span class="pos-summary-value" id="discountAmount">{{ $currencySymbol ?? '₹' }}0.00</span>
              </div>
            </div>
            
            <div class="pos-divider"></div>
            
            <div class="pos-summary-row pos-summary-total">
              <span class="pos-summary-label">Total</span>
              <span class="pos-summary-value" id="total">{{ $currencySymbol ?? '₹' }}0.00</span>
            </div>
          </div>

          <div class="pos-form-group">
            <label class="pos-form-label">Customer GST Number</label>
            <input type="text" id="gstNumber" class="pos-form-input" placeholder="GSTIN (optional)">
          </div>

          <!-- Payment Method -->
          <div class="pos-form-group">
            <label class="pos-form-label">Payment Method <span class="text-danger">*</span></label>
            <div class="pos-payment-methods">
              <input type="radio" class="btn-check" name="paymentMethod" id="paymentCash" value="cash" checked>
              <label class="pos-payment-btn pos-payment-btn-active" for="paymentCash">CASH</label>
              
              <input type="radio" class="btn-check" name="paymentMethod" id="paymentCard" value="card">
              <label class="pos-payment-btn" for="paymentCard">CARD</label>
              
              <input type="radio" class="btn-check" name="paymentMethod" id="paymentOther" value="other">
              <label class="pos-payment-btn" for="paymentOther">OTHER</label>
            </div>
          </div>

          <!-- Notes -->
          <div class="pos-form-group">
            <label class="pos-form-label">Notes</label>
            <textarea id="saleNotes" class="pos-form-textarea" rows="2" placeholder="Add notes..."></textarea>
          </div>

          <!-- Pay Button -->
          <button type="button" id="payBtn" class="pos-pay-btn" disabled>
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <line x1="12" y1="19" x2="12" y2="5"></line>
              <path d="M17 8l-5-5-5 5"></path>
            </svg>
            <span>PAY</span>
          </button>
        </div>
        </div>
      </div>
    </div>
  </div>

<!-- Add Customer Modal -->
<div class="modal fade" id="addCustomerModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Register New Customer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="addCustomerForm">
          <div class="mb-3">
            <label class="form-label">Name <span class="text-danger">*</span></label>
            <input type="text" id="newCustomerName" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" id="newCustomerEmail" class="form-control">
          </div>
          <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" id="newCustomerPhone" class="form-control">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="createCustomerBtn">Create Customer</button>
          </div>
        </div>
      </div>
    </div>

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Process Payment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="text-center mb-4">
          <h3 class="mb-0" id="paymentTotal">{{ $currencySymbol ?? '₹' }}0.00</h3>
          <small class="text-muted">Total Amount</small>
        </div>
        <div id="paymentDetails"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="confirmPaymentBtn">Confirm Payment</button>
        </div>
      </div>
    </div>
  </div>

@push('styles')
<style>
  .pos-container {
    background-color: #f5f7fa;
    background-image: 
      repeating-linear-gradient(45deg, transparent, transparent 35px, rgba(20, 184, 166, 0.03) 35px, rgba(20, 184, 166, 0.03) 70px),
      repeating-linear-gradient(-45deg, transparent, transparent 35px, rgba(20, 184, 166, 0.03) 35px, rgba(20, 184, 166, 0.03) 70px);
    min-height: calc(100vh - 200px);
    padding: 2rem;
    margin: -1rem;
    position: relative;
  }

  .pos-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: 
      radial-gradient(circle at 2px 2px, rgba(20, 184, 166, 0.15) 1px, transparent 0);
    background-size: 40px 40px;
    pointer-events: none;
    opacity: 0.4;
  }

  /* Glass Card Styles */
  .pos-glass-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border-radius: 1rem;
    border: 1px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
    overflow: hidden;
    transition: all 0.3s ease;
  }

  .pos-glass-card:hover {
    box-shadow: 0 12px 40px 0 rgba(31, 38, 135, 0.5);
    transform: translateY(-2px);
  }

  .pos-sticky-card {
    position: sticky;
    top: 1rem;
  }

  .pos-card-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    background: rgba(255, 255, 255, 0.5);
  }

  .pos-card-title {
    font-size: 1rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
  }

  .pos-card-body {
    padding: 1.5rem;
  }

  /* Search Styles */
  .pos-search-wrapper {
    position: relative;
    display: flex;
    align-items: center;
  }

  .pos-search-icon {
    position: absolute;
    left: 1rem;
    color: #6b7280;
    pointer-events: none;
    z-index: 1;
  }

  .pos-search-input {
    width: 100%;
    padding: 0.875rem 1rem 0.875rem 3rem;
    font-size: 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 0.75rem;
    background: rgba(255, 255, 255, 0.8);
    transition: all 0.3s ease;
    outline: none;
  }

  .pos-search-input:focus {
    border-color: #14b8a6;
    background: rgba(255, 255, 255, 1);
    box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.1);
  }

  .pos-search-results {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    margin-top: 0.5rem;
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(20px);
    border-radius: 0.75rem;
    border: 1px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
    max-height: 400px;
    overflow-y: auto;
    z-index: 1000;
    display: none;
  }

  .pos-search-result-item {
    padding: 1rem;
    cursor: pointer;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.2s ease;
  }

  .pos-search-result-item:hover {
    background: rgba(20, 184, 166, 0.1);
  }

  .pos-search-result-item:last-child {
    border-bottom: none;
  }

  .pos-search-result-image {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 0.5rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
  }

  /* Shortcuts */
  .pos-shortcuts {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
  }

  .pos-shortcut-btn {
    padding: 0.375rem 0.75rem;
    background: rgba(20, 184, 166, 0.1);
    border: 1px solid rgba(20, 184, 166, 0.2);
    border-radius: 0.5rem;
    font-size: 0.75rem;
    color: #14b8a6;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .pos-shortcut-btn:hover {
    background: rgba(20, 184, 166, 0.2);
    border-color: #14b8a6;
  }

  .pos-shortcut-btn kbd {
    background: rgba(20, 184, 166, 0.2);
    padding: 0.125rem 0.375rem;
    border-radius: 0.25rem;
    font-weight: 600;
    margin-right: 0.25rem;
  }

  /* Cart Styles */
  .pos-cart-items {
    min-height: 200px;
  }

  .pos-empty-cart {
    text-align: center;
    padding: 3rem 1rem;
    color: #9ca3af;
  }

  .pos-empty-cart svg {
    opacity: 0.3;
    margin-bottom: 1rem;
  }

  .pos-cart-item {
    display: flex;
    align-items: center;
    padding: 1rem;
    margin-bottom: 0.75rem;
    background: rgba(255, 255, 255, 0.6);
    border-radius: 0.75rem;
    border: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.2s ease;
  }

  .pos-cart-item:hover {
    background: rgba(255, 255, 255, 0.8);
    transform: translateX(4px);
  }

  .pos-cart-item-image {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 0.5rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .pos-cart-item-details {
    flex: 1;
    margin-left: 1rem;
  }

  .pos-cart-item-name {
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.25rem;
  }

  .pos-cart-item-meta {
    font-size: 0.875rem;
    color: #6b7280;
  }

  .pos-cart-item-price {
    font-weight: 600;
    color: #14b8a6;
    margin: 0 1rem;
    min-width: 80px;
    text-align: right;
    font-size: 1.1rem;
  }

  .pos-quantity-controls {
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .pos-quantity-btn {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #d1d5db;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 0.5rem;
    cursor: pointer;
    transition: all 0.2s ease;
    color: #6b7280;
  }

  .pos-quantity-btn:hover {
    background: #14b8a6;
    border-color: #14b8a6;
    color: white;
  }

  .pos-quantity-input {
    width: 60px;
    text-align: center;
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    padding: 0.375rem;
    background: rgba(255, 255, 255, 0.8);
  }

  .pos-clear-btn {
    padding: 0.5rem 1rem;
    background: rgba(239, 68, 68, 0.1);
    border: 1px solid rgba(239, 68, 68, 0.2);
    border-radius: 0.5rem;
    color: #ef4444;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s ease;
  }

  .pos-clear-btn:hover {
    background: rgba(239, 68, 68, 0.2);
    border-color: #ef4444;
  }

  /* Form Styles */
  .pos-form-group {
    margin-bottom: 1.25rem;
  }

  .pos-form-label {
    display: block;
    font-size: 0.875rem;
    font-weight: 500;
    color: #374151;
    margin-bottom: 0.5rem;
  }

  .pos-form-input,
  .pos-form-select,
  .pos-form-textarea {
    width: 100%;
    padding: 0.625rem 0.875rem;
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    background: rgba(255, 255, 255, 0.8);
    font-size: 0.875rem;
    transition: all 0.2s ease;
    outline: none;
  }

  .pos-form-input:focus,
  .pos-form-select:focus,
  .pos-form-textarea:focus {
    border-color: #14b8a6;
    background: rgba(255, 255, 255, 1);
    box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.1);
  }

  .pos-form-textarea {
    resize: vertical;
  }

  /* Summary Styles */
  .pos-summary {
    margin: 1.5rem 0;
  }

  .pos-summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
  }

  .pos-summary-total {
    border-top: 2px solid rgba(0, 0, 0, 0.1);
    margin-top: 0.5rem;
    padding-top: 1rem;
  }

  .pos-summary-label {
    font-size: 0.875rem;
    color: #6b7280;
    font-weight: 500;
  }

  .pos-summary-total .pos-summary-label {
    font-weight: 700;
    color: #1f2937;
    font-size: 1rem;
  }

  .pos-summary-value {
    font-weight: 600;
    color: #1f2937;
    font-size: 0.875rem;
  }

  .pos-summary-total .pos-summary-value {
    font-size: 1.5rem;
    color: #14b8a6;
    font-weight: 700;
  }

  .pos-summary-controls {
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .pos-input-small,
  .pos-select-small {
    padding: 0.375rem 0.5rem;
    border: 1px solid #d1d5db;
    border-radius: 0.375rem;
    background: rgba(255, 255, 255, 0.8);
    font-size: 0.75rem;
    width: 60px;
  }

  .pos-select-small {
    width: 50px;
  }

  .pos-divider {
    height: 1px;
    background: rgba(0, 0, 0, 0.1);
    margin: 1rem 0;
  }

  /* Payment Methods */
  .pos-payment-methods {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 0.5rem;
  }

  .pos-payment-btn {
    padding: 0.75rem;
    text-align: center;
    border: 2px solid #e5e7eb;
    border-radius: 0.5rem;
    background: rgba(255, 255, 255, 0.8);
    color: #6b7280;
    font-weight: 600;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .btn-check:checked + .pos-payment-btn,
  .pos-payment-btn-active {
    background: #14b8a6;
    border-color: #14b8a6;
    color: white;
  }

  .pos-payment-btn:hover {
    border-color: #14b8a6;
    color: #14b8a6;
  }

  /* Pay Button */
  .pos-pay-btn {
    width: 100%;
    padding: 1rem;
    background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
    border: none;
    border-radius: 0.75rem;
    color: white;
    font-weight: 700;
    font-size: 1.1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(20, 184, 166, 0.4);
    margin-top: 1rem;
  }

  .pos-pay-btn:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(20, 184, 166, 0.6);
  }

  .pos-pay-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    transform: none;
  }

  .pos-customer-info {
    margin-top: 0.5rem;
    padding: 0.5rem;
    background: rgba(20, 184, 166, 0.1);
    border-radius: 0.5rem;
    font-size: 0.875rem;
    color: #14b8a6;
  }

  .pos-add-customer-btn {
    padding: 0.375rem 0.75rem;
    background: rgba(20, 184, 166, 0.1);
    border: 1px solid rgba(20, 184, 166, 0.3);
    border-radius: 0.5rem;
    color: #14b8a6;
    font-size: 0.75rem;
    display: flex;
    align-items: center;
    gap: 0.375rem;
    transition: all 0.2s ease;
    cursor: pointer;
  }

  .pos-add-customer-btn:hover {
    background: rgba(20, 184, 166, 0.2);
    border-color: #14b8a6;
  }

  .pos-customer-results {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    margin-top: 0.25rem;
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(20px);
    border-radius: 0.5rem;
    border: 1px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
    max-height: 200px;
    overflow-y: auto;
    z-index: 1000;
    display: none;
  }

  .pos-customer-result-item {
    padding: 0.75rem 1rem;
    cursor: pointer;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.2s ease;
  }

  .pos-customer-result-item:hover {
    background: rgba(20, 184, 166, 0.1);
  }

  .pos-customer-result-item:last-child {
    border-bottom: none;
  }
</style>
@endpush

@push('scripts')
<script>
const POS = {
  cart: [],
  customerId: null,
  registerId: {{ $defaultRegister->id ?? 'null' }},
  taxRate: 0,
  discountType: 'fixed',
  discountValue: 0,
  currency: '{{ $currency ?? 'INR' }}',
  currencySymbol: '{{ $currencySymbol ?? '₹' }}',
  searchUrl: '{{ url("admin/pos/search") }}',
  barcodeUrl: '{{ url("admin/pos/barcode") }}',
  processUrl: '{{ url("admin/pos/process") }}',
  customerSearchUrl: '{{ url("admin/pos/customers/search") }}',
  customerCreateUrl: '{{ url("admin/pos/customers/create") }}',

  init() {
    this.setupEventListeners();
    this.setupKeyboardShortcuts();
  },

  setupEventListeners() {
    // Product search
    const searchInput = document.getElementById('productSearch');
    let searchTimeout;
    
    searchInput.addEventListener('input', (e) => {
      clearTimeout(searchTimeout);
      const query = e.target.value.trim();
      
      if (query.length < 2) {
        document.getElementById('searchResults').style.display = 'none';
        return;
      }

      searchTimeout = setTimeout(() => {
        this.searchProducts(query);
      }, 300);
    });

    searchInput.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' && e.target.value.trim()) {
        e.preventDefault();
        const query = e.target.value.trim();
        if (query.length > 5 && /^\d+$/.test(query)) {
          // Looks like a barcode
          this.scanBarcode(query);
        } else {
          this.searchProducts(query, true);
        }
      }
      if (e.key === 'Escape') {
        e.target.value = '';
        document.getElementById('searchResults').style.display = 'none';
      }
    });

    // Tax rate
    document.getElementById('taxRate').addEventListener('input', () => this.calculateTotals());
    
    // Discount
    document.getElementById('discountType').addEventListener('change', () => this.calculateTotals());
    document.getElementById('discountValue').addEventListener('input', () => this.calculateTotals());

    // Clear cart
    document.getElementById('clearCartBtn').addEventListener('click', () => this.clearCart());

    // Pay button
    document.getElementById('payBtn').addEventListener('click', () => this.showPaymentModal());

    // Customer search
    const customerSearch = document.getElementById('customerSearch');
    let customerSearchTimeout;
    customerSearch.addEventListener('input', (e) => {
      clearTimeout(customerSearchTimeout);
      const query = e.target.value.trim();
      
      if (query.length < 2) {
        document.getElementById('customerResults').style.display = 'none';
        document.getElementById('customerId').value = '';
        document.getElementById('customerInfo').style.display = 'none';
        return;
      }

      customerSearchTimeout = setTimeout(() => {
        this.searchCustomers(query);
      }, 300);
    });

    // Create customer button
    document.getElementById('createCustomerBtn').addEventListener('click', () => {
      this.createCustomer();
    });

    // Confirm payment
    document.getElementById('confirmPaymentBtn').addEventListener('click', () => this.processPayment());

    // Payment method change
    document.querySelectorAll('input[name="paymentMethod"]').forEach(radio => {
      radio.addEventListener('change', (e) => {
        document.querySelectorAll('.pos-payment-btn').forEach(btn => btn.classList.remove('pos-payment-btn-active'));
        e.target.nextElementSibling.classList.add('pos-payment-btn-active');
      });
    });
  },

  setupKeyboardShortcuts() {
    document.addEventListener('keydown', (e) => {
      // F2: Focus search
      if (e.key === 'F2') {
        e.preventDefault();
        document.getElementById('productSearch').focus();
      }
    });
  },

  async searchProducts(query, addFirst = false) {
    try {
      if (!query || query.trim().length < 2) {
        document.getElementById('searchResults').style.display = 'none';
        return;
      }

      const response = await fetch(`${this.searchUrl}?q=${encodeURIComponent(query.trim())}`, {
        method: 'GET',
        headers: {
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin'
      });
      
      if (!response.ok) {
        const errorData = await response.json().catch(() => ({}));
        throw new Error(errorData.message || `HTTP error! status: ${response.status}`);
      }
      
      const products = await response.json();
      const resultsContainer = document.getElementById('searchResults');
      
      // Check if response has error
      if (products.error) {
        throw new Error(products.message || 'Search failed');
      }
      
      if (!Array.isArray(products) || products.length === 0) {
        resultsContainer.innerHTML = '<div class="pos-search-result-item"><div class="text-center text-muted p-3">No products found</div></div>';
        resultsContainer.style.display = 'block';
        return;
      }

      if (addFirst && products.length > 0) {
        this.addToCart(products[0]);
        document.getElementById('productSearch').value = '';
        resultsContainer.style.display = 'none';
        return;
      }

      resultsContainer.innerHTML = products.map(product => {
        const imageHtml = product.image 
          ? `<img src="${product.image}" class="pos-search-result-image" alt="${product.name}" onerror="this.parentElement.innerHTML='<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'24\' height=\'24\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'white\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'><rect x=\'3\' y=\'3\' width=\'18\' height=\'18\' rx=\'2\' ry=\'2\'></rect><circle cx=\'8.5\' cy=\'8.5\' r=\'1.5\'></circle><polyline points=\'21 15 16 10 5 21\'></polyline></svg>'">`
          : `<div class="pos-search-result-image"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg></div>`;
        
        const productJson = JSON.stringify(product).replace(/"/g, '&quot;');
        return `
          <div class="pos-search-result-item" onclick="POS.addToCart(${productJson})">
            ${imageHtml}
            <div class="flex-grow-1">
              <div class="fw-semibold">${this.escapeHtml(product.name)}</div>
              <div class="small text-muted">${this.escapeHtml(product.sku || 'N/A')} • Stock: ${product.stock || 0} • ${this.currencySymbol}${(product.price || 0).toFixed(2)}</div>
            </div>
          </div>
        `;
      }).join('');
      
      resultsContainer.style.display = 'block';
    } catch (error) {
      console.error('Search error:', error);
      const resultsContainer = document.getElementById('searchResults');
      resultsContainer.innerHTML = `<div class="pos-search-result-item"><div class="text-center text-danger p-3">Error: ${this.escapeHtml(error.message)}</div></div>`;
      resultsContainer.style.display = 'block';
    }
  },

  escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
  },

  async scanBarcode(barcode) {
    try {
      const response = await fetch(`${this.barcodeUrl}?barcode=${encodeURIComponent(barcode)}`);
      const data = await response.json();
      
      if (data.success) {
        this.addToCart(data.product);
        document.getElementById('productSearch').value = '';
        document.getElementById('searchResults').style.display = 'none';
      } else {
        alert('Product not found');
      }
    } catch (error) {
      console.error('Barcode scan error:', error);
      alert('Error scanning barcode');
    }
  },

  addToCart(product) {
    const existingItem = this.cart.find(item => item.id === product.id);
    
    if (existingItem) {
      if (existingItem.quantity >= product.stock) {
        alert('Insufficient stock');
        return;
      }
      existingItem.quantity++;
    } else {
      if (product.stock <= 0) {
        alert('Product out of stock');
        return;
      }
      this.cart.push({
        id: product.id,
        name: product.name,
        sku: product.sku,
        price: product.price,
        stock: product.stock,
        image: product.image,
        quantity: 1
      });
    }
    
    this.renderCart();
    this.calculateTotals();
    document.getElementById('productSearch').value = '';
    document.getElementById('searchResults').style.display = 'none';
    document.getElementById('productSearch').focus();
  },

  removeFromCart(index) {
    this.cart.splice(index, 1);
    this.renderCart();
    this.calculateTotals();
  },

  updateQuantity(index, change) {
    const item = this.cart[index];
    const newQuantity = item.quantity + change;
    
    if (newQuantity < 1) {
      this.removeFromCart(index);
      return;
    }
    
    if (newQuantity > item.stock) {
      alert('Insufficient stock');
      return;
    }
    
    item.quantity = newQuantity;
    this.renderCart();
    this.calculateTotals();
  },

  renderCart() {
    const container = document.getElementById('cartItems');
    const clearBtn = document.getElementById('clearCartBtn');
    
    if (this.cart.length === 0) {
      container.innerHTML = `
        <div class="pos-empty-cart">
          <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="9" cy="21" r="1"></circle>
            <circle cx="20" cy="21" r="1"></circle>
            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
          </svg>
          <p>Cart is empty. Scan or search for products.</p>
        </div>
      `;
      clearBtn.style.display = 'none';
      return;
    }
    
    clearBtn.style.display = 'flex';
    
    container.innerHTML = this.cart.map((item, index) => {
      const imageHtml = item.image 
        ? `<img src="${item.image}" class="pos-cart-item-image" alt="${item.name}">`
        : `<div class="pos-cart-item-image"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg></div>`;
      
      return `
        <div class="pos-cart-item">
          ${imageHtml}
          <div class="pos-cart-item-details">
            <div class="pos-cart-item-name">${item.name}</div>
            <div class="pos-cart-item-meta">${item.sku} • Stock: ${item.stock}</div>
          </div>
          <div class="pos-cart-item-price">${this.currencySymbol}${(item.price * item.quantity).toFixed(2)}</div>
          <div class="pos-quantity-controls">
            <button class="pos-quantity-btn" onclick="POS.updateQuantity(${index}, -1)">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            </button>
            <input type="number" class="pos-quantity-input" value="${item.quantity}" min="1" max="${item.stock}" onchange="POS.setQuantity(${index}, this.value)">
            <button class="pos-quantity-btn" onclick="POS.updateQuantity(${index}, 1)">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            </button>
          </div>
          <button class="btn btn-sm btn-outline-danger ms-2" onclick="POS.removeFromCart(${index})" title="Remove">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
          </button>
        </div>
      `;
    }).join('');
  },

  setQuantity(index, value) {
    const item = this.cart[index];
    const quantity = parseInt(value);
    
    if (quantity < 1) {
      this.removeFromCart(index);
      return;
    }
    
    if (quantity > item.stock) {
      alert('Insufficient stock');
      item.quantity = item.stock;
      this.renderCart();
      return;
    }
    
    item.quantity = quantity;
    this.calculateTotals();
  },

  clearCart() {
    if (confirm('Clear all items from cart?')) {
      this.cart = [];
      this.renderCart();
      this.calculateTotals();
    }
  },

  calculateTotals() {
    const subtotal = this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    
    this.taxRate = parseFloat(document.getElementById('taxRate').value) || 0;
    const taxAmount = subtotal * (this.taxRate / 100);
    
    this.discountType = document.getElementById('discountType').value;
    this.discountValue = parseFloat(document.getElementById('discountValue').value) || 0;
    let discountAmount = 0;
    
    if (this.discountType === 'percentage') {
      discountAmount = subtotal * (this.discountValue / 100);
    } else {
      discountAmount = this.discountValue;
    }
    
    const total = subtotal + taxAmount - discountAmount;
    
    document.getElementById('subtotal').textContent = `${this.currencySymbol}${subtotal.toFixed(2)}`;
    document.getElementById('taxAmount').textContent = `${this.currencySymbol}${taxAmount.toFixed(2)}`;
    document.getElementById('discountAmount').textContent = `${this.currencySymbol}${discountAmount.toFixed(2)}`;
    document.getElementById('total').textContent = `${this.currencySymbol}${total.toFixed(2)}`;
    
    this.updatePayButton();
  },

  async searchCustomers(query) {
    try {
      const response = await fetch(`${this.customerSearchUrl}?q=${encodeURIComponent(query)}`, {
        method: 'GET',
        headers: {
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin'
      });

      if (!response.ok) {
        throw new Error('Customer search failed');
      }

      const customers = await response.json();
      const resultsContainer = document.getElementById('customerResults');

      if (!Array.isArray(customers) || customers.length === 0) {
        resultsContainer.innerHTML = '<div class="pos-customer-result-item"><div class="text-center text-muted p-2">No customers found</div></div>';
        resultsContainer.style.display = 'block';
        return;
      }

      resultsContainer.innerHTML = customers.map(customer => `
        <div class="pos-customer-result-item" onclick="POS.selectCustomer(${customer.id}, '${this.escapeHtml(customer.name)}', '${this.escapeHtml(customer.email || '')}', '${this.escapeHtml(customer.phone || '')}')">
          <div class="fw-semibold">${this.escapeHtml(customer.name)}</div>
          <div class="small text-muted">${this.escapeHtml(customer.email || '')} ${customer.phone ? '• ' + this.escapeHtml(customer.phone) : ''}</div>
        </div>
      `).join('');

      resultsContainer.style.display = 'block';
    } catch (error) {
      console.error('Customer search error:', error);
    }
  },

  selectCustomer(id, name, email, phone) {
    this.customerId = id;
    document.getElementById('customerId').value = id;
    document.getElementById('customerSearch').value = name;
    document.getElementById('customerResults').style.display = 'none';
    
    const infoDiv = document.getElementById('customerInfo');
    infoDiv.innerHTML = `
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <div class="fw-semibold">${this.escapeHtml(name)}</div>
          ${email ? `<div class="small text-muted">${this.escapeHtml(email)}</div>` : ''}
        </div>
        <button type="button" class="btn btn-sm btn-outline-danger" onclick="POS.clearCustomer()">
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
          </svg>
        </button>
  </div>
    `;
    infoDiv.style.display = 'block';
  },

  clearCustomer() {
    this.customerId = null;
    document.getElementById('customerId').value = '';
    document.getElementById('customerSearch').value = '';
    document.getElementById('customerInfo').style.display = 'none';
    document.getElementById('customerResults').style.display = 'none';
  },

  async createCustomer() {
    const name = document.getElementById('newCustomerName').value.trim();
    const email = document.getElementById('newCustomerEmail').value.trim();
    const phone = document.getElementById('newCustomerPhone').value.trim();

    if (!name) {
      alert('Please enter customer name');
      return;
    }

    try {
      const response = await fetch(this.customerCreateUrl, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin',
        body: JSON.stringify({
          name: name,
          email: email || null,
          phone: phone || null
        })
      });

      const data = await response.json();

      if (data.success) {
        // Select the newly created customer
        this.selectCustomer(data.customer.id, data.customer.name, data.customer.email || '', data.customer.phone || '');
        
        // Close modal and reset form
        bootstrap.Modal.getInstance(document.getElementById('addCustomerModal')).hide();
        document.getElementById('addCustomerForm').reset();
        
        alert('Customer created successfully!');
      } else {
        alert('Error: ' + data.message);
      }
    } catch (error) {
      console.error('Create customer error:', error);
      alert('Error creating customer');
    }
  },

  updatePayButton() {
    const payBtn = document.getElementById('payBtn');
    if (this.cart.length > 0 && this.registerId) {
      payBtn.disabled = false;
    } else {
      payBtn.disabled = true;
    }
  },

  showPaymentModal() {
    const total = parseFloat(document.getElementById('total').textContent.replace(this.currencySymbol, '').replace(/,/g, ''));
    const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;
    
    document.getElementById('paymentTotal').textContent = `${this.currencySymbol}${total.toFixed(2)}`;
    
    const modal = new bootstrap.Modal(document.getElementById('paymentModal'));
    modal.show();
  },

  async processPayment() {
    const registerId = this.registerId;
    const customerId = document.getElementById('customerId').value || null;
    const gstNumber = document.getElementById('gstNumber').value.trim() || null;
    const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;
    const notes = document.getElementById('saleNotes').value;
    
    const subtotal = this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    const taxAmount = parseFloat(document.getElementById('taxAmount').textContent.replace(this.currencySymbol, '').replace(/,/g, ''));
    const discountAmount = parseFloat(document.getElementById('discountAmount').textContent.replace(this.currencySymbol, '').replace(/,/g, ''));
    const total = parseFloat(document.getElementById('total').textContent.replace(this.currencySymbol, '').replace(/,/g, ''));
    
    const items = this.cart.map(item => ({
      product_id: item.id,
      quantity: item.quantity,
      price: item.price
    }));
    
    try {
      const response = await fetch(this.processUrl, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
          register_id: registerId,
          customer_id: customerId,
          items: items,
          subtotal: subtotal,
          tax_rate: this.taxRate,
          tax_amount: taxAmount,
          discount_type: this.discountType,
          discount_value: this.discountValue,
          discount_amount: discountAmount,
          total_amount: total,
          payment_method: paymentMethod,
          notes: notes,
          gst_number: gstNumber,
          gst_rate: this.taxRate
        })
      });
      
      const data = await response.json();
      
      if (data.success) {
        alert(`Sale processed successfully!\nSale Number: ${data.sale_number}`);
        this.clearCart();
        document.getElementById('customerId').value = '';
        document.getElementById('customerInfo').style.display = 'none';
        document.getElementById('saleNotes').value = '';
        document.getElementById('taxRate').value = '0';
        document.getElementById('discountValue').value = '0';
        document.getElementById('gstNumber').value = '';
        bootstrap.Modal.getInstance(document.getElementById('paymentModal')).hide();
      } else {
        alert('Error: ' + data.message);
      }
    } catch (error) {
      console.error('Payment error:', error);
      alert('Error processing payment');
    }
  }
};

// Initialize POS when page loads
document.addEventListener('DOMContentLoaded', () => {
  POS.init();
});

// Close search results when clicking outside
document.addEventListener('click', (e) => {
  if (!e.target.closest('#productSearch') && !e.target.closest('#searchResults')) {
    document.getElementById('searchResults').style.display = 'none';
  }
  if (!e.target.closest('#customerSearch') && !e.target.closest('#customerResults') && !e.target.closest('#customerInfo')) {
    document.getElementById('customerResults').style.display = 'none';
  }
    });
  </script>
@endpush
@endsection
