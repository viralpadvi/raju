@extends('layouts.admin')

@section('title', 'Create Purchase Order')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h1 class="h3 mb-0">Create Purchase Order</h1>
  <a href="{{ route('admin.inventory.purchases.index') }}" class="btn btn-outline-secondary">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <line x1="19" y1="12" x2="5" y2="12"></line>
      <polyline points="12 19 5 12 12 5"></polyline>
    </svg>
    <span>Back</span>
  </a>
</div>

<form method="POST" action="{{ route('admin.inventory.purchases.store') }}" id="purchaseForm">
  @csrf
  
  <div class="row">
    <div class="col-lg-8">
      <!-- Purchase Details -->
      <div class="card mb-4">
        <div class="card-header">
          <h6 class="mb-0">Purchase Details</h6>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Supplier <span class="text-danger">*</span></label>
                <select name="supplier_id" class="form-select @error('supplier_id') is-invalid @enderror" required>
                  <option value="">Select supplier</option>
                  @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                  @endforeach
                </select>
                @error('supplier_id')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Branch <span class="text-danger">*</span></label>
                <select name="branch_id" class="form-select @error('branch_id') is-invalid @enderror" required>
                  <option value="">Select branch</option>
                  @foreach($branches as $branch)
                    <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                  @endforeach
                </select>
                @error('branch_id')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Purchase Date <span class="text-danger">*</span></label>
                <input type="date" name="purchase_date" class="form-control @error('purchase_date') is-invalid @enderror" value="{{ old('purchase_date', date('Y-m-d')) }}" required>
                @error('purchase_date')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Expected Date</label>
                <input type="date" name="expected_date" class="form-control @error('expected_date') is-invalid @enderror" value="{{ old('expected_date') }}">
                @error('expected_date')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Notes</label>
            <textarea name="notes" class="form-control" rows="3" placeholder="Enter purchase notes">{{ old('notes') }}</textarea>
          </div>
        </div>
      </div>

      <!-- Items Section -->
      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h6 class="mb-0">Items</h6>
          <button type="button" class="btn btn-sm btn-outline-primary" id="addItemBtn">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <line x1="12" y1="5" x2="12" y2="19"></line>
              <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            <span>Add Item</span>
          </button>
        </div>
        <div class="card-body">
          <div id="itemsContainer">
            <!-- Items will be added here dynamically -->
          </div>
          <div class="text-center text-muted py-3" id="noItemsMessage">
            No items added. Click "Add Item" to start.
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <!-- Summary -->
      <div class="card mb-4">
        <div class="card-header">
          <h6 class="mb-0">Summary</h6>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label">Status <span class="text-danger">*</span></label>
            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
              <option value="pending" {{ old('status', 'pending') === 'pending' ? 'selected' : '' }}>Pending</option>
              <option value="received" {{ old('status') === 'received' ? 'selected' : '' }}>Received</option>
              <option value="cancelled" {{ old('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            @error('status')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label">Subtotal</label>
            <input type="number" name="subtotal" id="subtotal" class="form-control" value="0.00" step="0.01" readonly>
          </div>
          <div class="mb-3">
            <label class="form-label">Tax Amount</label>
            <input type="number" name="tax_amount" id="taxAmount" class="form-control" value="0.00" step="0.01" min="0">
          </div>
          <div class="mb-3">
            <label class="form-label">Discount Amount</label>
            <input type="number" name="discount_amount" id="discountAmount" class="form-control" value="0.00" step="0.01" min="0">
          </div>
          <div class="mb-3">
            <label class="form-label">Total Amount</label>
            <input type="number" name="total_amount" id="totalAmount" class="form-control fw-bold" value="0.00" step="0.01" readonly>
          </div>
        </div>
      </div>

      <!-- Actions -->
      <div class="card">
        <div class="card-body">
          <button type="submit" class="btn btn-primary w-100 mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
              <polyline points="17 21 17 13 7 13 7 21"></polyline>
              <polyline points="7 3 7 8 15 8"></polyline>
            </svg>
            <span>Create Purchase Order</span>
          </button>
          <a href="{{ route('admin.inventory.purchases.index') }}" class="btn btn-outline-secondary w-100">
            <span>Cancel</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</form>

@push('scripts')
<script>
let itemCount = 0;
const products = @json($products);

document.getElementById('addItemBtn').addEventListener('click', function() {
  addItemRow();
});

function addItemRow() {
  itemCount++;
  const container = document.getElementById('itemsContainer');
  const noItemsMessage = document.getElementById('noItemsMessage');
  
  if (noItemsMessage) {
    noItemsMessage.style.display = 'none';
  }

  const itemRow = document.createElement('div');
  itemRow.className = 'row g-3 mb-3 item-row';
  itemRow.dataset.itemIndex = itemCount;
  
  itemRow.innerHTML = `
    <div class="col-md-5">
      <select name="items[${itemCount}][product_id]" class="form-select product-select" required>
        <option value="">Select product</option>
        ${products.map(p => `<option value="${p.id}" data-price="${p.cost_price || p.price}">${p.name} (₹${p.cost_price || p.price})</option>`).join('')}
      </select>
    </div>
    <div class="col-md-2">
      <input type="number" name="items[${itemCount}][quantity]" class="form-control item-quantity" placeholder="Qty" min="1" required>
    </div>
    <div class="col-md-2">
      <input type="number" name="items[${itemCount}][unit_price]" class="form-control item-unit-price" placeholder="Price" step="0.01" min="0" required>
    </div>
    <div class="col-md-2">
      <input type="number" name="items[${itemCount}][total]" class="form-control item-total" placeholder="Total" step="0.01" readonly>
    </div>
    <div class="col-md-1">
      <button type="button" class="btn btn-outline-danger w-100 remove-item">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="3 6 5 6 21 6"></polyline>
          <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
        </svg>
      </button>
    </div>
  `;

  container.appendChild(itemRow);

  // Add event listeners
  const productSelect = itemRow.querySelector('.product-select');
  const quantityInput = itemRow.querySelector('.item-quantity');
  const unitPriceInput = itemRow.querySelector('.item-unit-price');
  const totalInput = itemRow.querySelector('.item-total');
  const removeBtn = itemRow.querySelector('.remove-item');

  productSelect.addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    if (selectedOption.value) {
      unitPriceInput.value = selectedOption.dataset.price;
      calculateItemTotal(itemRow);
    }
  });

  quantityInput.addEventListener('input', () => calculateItemTotal(itemRow));
  unitPriceInput.addEventListener('input', () => calculateItemTotal(itemRow));

  removeBtn.addEventListener('click', function() {
    itemRow.remove();
    updateTotals();
    if (container.children.length === 0 && noItemsMessage) {
      noItemsMessage.style.display = 'block';
    }
  });
}

function calculateItemTotal(row) {
  const quantity = parseFloat(row.querySelector('.item-quantity').value) || 0;
  const unitPrice = parseFloat(row.querySelector('.item-unit-price').value) || 0;
  const total = quantity * unitPrice;
  row.querySelector('.item-total').value = total.toFixed(2);
  updateTotals();
}

function updateTotals() {
  let subtotal = 0;
  document.querySelectorAll('.item-total').forEach(input => {
    subtotal += parseFloat(input.value) || 0;
  });

  const taxAmount = parseFloat(document.getElementById('taxAmount').value) || 0;
  const discountAmount = parseFloat(document.getElementById('discountAmount').value) || 0;
  const total = subtotal + taxAmount - discountAmount;

  document.getElementById('subtotal').value = subtotal.toFixed(2);
  document.getElementById('totalAmount').value = total.toFixed(2);
}

document.getElementById('taxAmount').addEventListener('input', updateTotals);
document.getElementById('discountAmount').addEventListener('input', updateTotals);

// Add initial item row
if (itemCount === 0) {
  addItemRow();
}
</script>
@endpush
@endsection

