@extends('layouts.admin')

@section('title', 'Products Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h1 class="h3 mb-0">Products</h1>
  <a href="{{ route('admin.catalog.products.create') }}" class="btn btn-primary">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <line x1="12" y1="5" x2="12" y2="19"></line>
      <line x1="5" y1="12" x2="19" y2="12"></line>
    </svg>
    <span>Add Product</span>
  </a>
  </div>

<!-- Filters -->
<div class="card mb-4">
  <div class="card-body">
    <form method="GET" action="{{ route('admin.catalog.products.index') }}">
      <div class="row g-3">
        <div class="col-md-4">
          <label class="form-label">Search</label>
          <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Search by name or SKU">
        </div>
        <div class="col-md-3">
          <label class="form-label">Brand</label>
          <select name="brand" class="form-select">
            <option value="">All</option>
            @foreach($brands as $brand)
              <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label">Category</label>
          <select name="category" class="form-select">
            <option value="">All</option>
            @foreach($categories as $category)
              <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label">Status</label>
          <select name="status" class="form-select">
            <option value="">All</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
          </select>
        </div>
      </div>
      <div class="mt-3">
        <button class="btn btn-primary">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
          </svg>
          <span>Filter</span>
        </button>
        <a href="{{ route('admin.catalog.products.index') }}" class="btn btn-outline-secondary">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="1 4 1 10 7 10"></polyline>
            <path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path>
          </svg>
          <span>Reset</span>
        </a>
      </div>
    </form>
  </div>
  </div>

<div class="card">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover align-middle">
        <thead>
          <tr>
            <th>Product</th>
            <th>SKU</th>
            <th>Brand / Category</th>
            <th>Price</th>
            <th>Compare</th>
            <th>Discount</th>
            <th>Status</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @forelse($products as $product)
          <tr>
            <td>
              <div class="fw-semibold">{{ $product->name }}</div>
              <div class="text-muted small">#{{ $product->id }}</div>
            </td>
            <td class="text-muted">{{ $product->sku }}</td>
            <td>
              <div class="small">{{ $product->brand->name ?? '-' }}</div>
              <div class="text-muted small">{{ $product->category->name ?? '-' }}</div>
            </td>
            <td><span class="fw-semibold text-primary">${{ number_format($product->price, 2) }}</span></td>
            <td class="text-muted">{{ $product->compare_price ? '$'.number_format($product->compare_price,2) : '-' }}</td>
            <td class="text-muted">
              @if($product->discount_type)
                {{ strtoupper($product->discount_type) }} {{ $product->discount_type === 'percent' ? $product->discount_value.'%' : '$'.number_format($product->discount_value,2) }}
              @else
                -
              @endif
            </td>
            <td>
              <span class="badge bg-{{ $product->is_active ? 'success' : 'secondary' }}">{{ $product->is_active ? 'Active' : 'Inactive' }}</span>
            </td>
            <td class="text-end">
              <div class="btn-group btn-group-sm">
                <a href="{{ route('admin.catalog.products.edit', $product) }}" class="btn btn-outline-primary">Edit</a>
                <form method="POST" action="{{ route('admin.catalog.products.destroy', $product) }}" onsubmit="return confirm('Delete this product?')">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-outline-danger">Delete</button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="8" class="text-center text-muted py-4">No products found.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @if($products->hasPages())
    <div class="d-flex justify-content-between align-items-center mt-3">
      <div class="text-muted small">Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }}</div>
      {{ $products->links() }}
    </div>
    @endif
  </div>
</div>
@endsection

@extends('layouts.admin')

@section('title', 'Products Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h1 class="h3 mb-0">Products Management</h1>
  <div class="d-flex gap-2">
    <div class="dropdown">
      <button class="btn btn-outline-primary dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
          <polyline points="7 10 12 15 17 10"></polyline>
          <line x1="12" y1="15" x2="12" y2="3"></line>
        </svg>
        <span>Export</span>
      </button>
      <ul class="dropdown-menu" aria-labelledby="exportDropdown">
        <li><a class="dropdown-item" href="{{ route('admin.catalog.products.export', ['format' => 'csv']) }}">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-2">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
            <polyline points="14 2 14 8 20 8"></polyline>
            <line x1="16" y1="13" x2="8" y2="13"></line>
            <line x1="16" y1="17" x2="8" y2="17"></line>
            <polyline points="10 9 9 9 8 9"></polyline>
          </svg>
          Export as CSV
        </a></li>
        <li><a class="dropdown-item" href="{{ route('admin.catalog.products.export', ['format' => 'excel']) }}">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-2">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
            <polyline points="14 2 14 8 20 8"></polyline>
            <line x1="16" y1="13" x2="8" y2="13"></line>
            <line x1="16" y1="17" x2="8" y2="17"></line>
            <polyline points="10 9 9 9 8 9"></polyline>
          </svg>
          Export as Excel
        </a></li>
        <li><a class="dropdown-item" href="{{ route('admin.catalog.products.export', ['format' => 'pdf']) }}">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-2">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
            <polyline points="14 2 14 8 20 8"></polyline>
            <line x1="16" y1="13" x2="8" y2="13"></line>
            <line x1="16" y1="17" x2="8" y2="17"></line>
            <polyline points="10 9 9 9 8 9"></polyline>
          </svg>
          Export as PDF
        </a></li>
      </ul>
    </div>
    <a href="{{ route('admin.catalog.products.create') }}" class="btn btn-primary">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <line x1="12" y1="5" x2="12" y2="19"></line>
        <line x1="5" y1="12" x2="19" y2="12"></line>
      </svg>
      <span>Add Product</span>
    </a>
  </div>
</div>

<!-- Filters -->
<div class="card mb-4">
  <div class="card-body">
    <div class="row g-3">
      <div class="col-md-3">
        <label class="form-label">Search</label>
        <input type="text" class="form-control" placeholder="Search products...">
      </div>
      <div class="col-md-2">
        <label class="form-label">Category</label>
        <select class="form-select">
          <option value="">All Categories</option>
          <option value="1">Smartphones</option>
          <option value="2">Laptops</option>
        </select>
      </div>
      <div class="col-md-2">
        <label class="form-label">Brand</label>
        <select class="form-select">
          <option value="">All Brands</option>
          <option value="1">Samsung</option>
          <option value="2">Apple</option>
        </select>
      </div>
      <div class="col-md-2">
        <label class="form-label">Status</label>
        <select class="form-select">
          <option value="">All Status</option>
          <option value="1">Active</option>
          <option value="0">Inactive</option>
        </select>
      </div>
      <div class="col-md-3 d-flex align-items-end">
        <button class="btn btn-primary me-2">Filter</button>
        <button class="btn btn-outline-secondary">Reset</button>
      </div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>
              <input type="checkbox" class="form-check-input">
            </th>
            <th>Product</th>
            <th>SKU</th>
            <th>Category</th>
            <th>Brand</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <input type="checkbox" class="form-check-input">
            </td>
            <td>
              <div class="d-flex align-items-center">
                <img src="https://via.placeholder.com/50x50?text=iPhone" alt="iPhone 15" class="rounded me-3" width="50" height="50">
                <div>
                  <div class="fw-semibold">iPhone 15 Pro</div>
                  <div class="text-muted small">Latest Apple smartphone</div>
                </div>
              </div>
            </td>
            <td>
              <code>IPH15PRO-256</code>
            </td>
            <td>
              <span class="badge bg-primary">Smartphones</span>
            </td>
            <td>
              <span class="badge bg-secondary">Apple</span>
            </td>
            <td>
              <div class="fw-semibold">$999.00</div>
            </td>
            <td>
              <span class="badge bg-success">In Stock</span>
              <div class="text-muted small">15 units</div>
            </td>
            <td>
              <span class="badge bg-success">Active</span>
            </td>
            <td>
              <div class="btn-group btn-group-sm">
                <button class="btn btn-outline-primary" title="View">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                  </svg>
                </button>
                <button class="btn btn-outline-primary" title="Edit">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                  </svg>
                </button>
                <button class="btn btn-outline-danger" title="Delete">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                  </svg>
                </button>
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <input type="checkbox" class="form-check-input">
            </td>
            <td>
              <div class="d-flex align-items-center">
                <img src="https://via.placeholder.com/50x50?text=MacBook" alt="MacBook Pro" class="rounded me-3" width="50" height="50">
                <div>
                  <div class="fw-semibold">MacBook Pro M3</div>
                  <div class="text-muted small">Professional laptop</div>
                </div>
              </div>
            </td>
            <td>
              <code>MBP-M3-512</code>
            </td>
            <td>
              <span class="badge bg-primary">Laptops</span>
            </td>
            <td>
              <span class="badge bg-secondary">Apple</span>
            </td>
            <td>
              <div class="fw-semibold">$1,999.00</div>
            </td>
            <td>
              <span class="badge bg-warning">Low Stock</span>
              <div class="text-muted small">3 units</div>
            </td>
            <td>
              <span class="badge bg-success">Active</span>
            </td>
            <td>
              <div class="btn-group btn-group-sm">
                <button class="btn btn-outline-primary" title="View">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                  </svg>
                </button>
                <button class="btn btn-outline-primary" title="Edit">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                  </svg>
                </button>
                <button class="btn btn-outline-danger" title="Delete">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                  </svg>
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    
    <!-- Pagination -->
    <nav aria-label="Products pagination" class="mt-4">
      <ul class="pagination justify-content-center">
        <li class="page-item disabled">
          <span class="page-link">Previous</span>
        </li>
        <li class="page-item active">
          <span class="page-link">1</span>
        </li>
        <li class="page-item">
          <a class="page-link" href="#">2</a>
        </li>
        <li class="page-item">
          <a class="page-link" href="#">3</a>
        </li>
        <li class="page-item">
          <a class="page-link" href="#">Next</a>
        </li>
      </ul>
    </nav>
  </div>
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Product Name</label>
                <input type="text" class="form-control" placeholder="Enter product name">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">SKU</label>
                <input type="text" class="form-control" placeholder="Enter SKU">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Category</label>
                <select class="form-select">
                  <option value="">Select category</option>
                  <option value="1">Smartphones</option>
                  <option value="2">Laptops</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Brand</label>
                <select class="form-select">
                  <option value="">Select brand</option>
                  <option value="1">Apple</option>
                  <option value="2">Samsung</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Price</label>
                <input type="number" class="form-control" placeholder="0.00" step="0.01">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Stock Quantity</label>
                <input type="number" class="form-control" placeholder="0">
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" rows="3" placeholder="Enter product description"></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Product Images</label>
            <input type="file" class="form-control" accept="image/*" multiple>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary">Add Product</button>
      </div>
    </div>
  </div>
</div>
@endsection
