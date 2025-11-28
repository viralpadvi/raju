@extends('layouts.admin')

@section('title', 'Category Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h1 class="h3 mb-0">Category Details</h1>
  <div class="d-flex gap-2">
    <a href="{{ route('admin.catalog.categories.edit', $category) }}" class="btn btn-primary">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-1">
        <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
      </svg>
      Edit Category
    </a>
    <a href="{{ route('admin.catalog.categories.index') }}" class="btn btn-outline-secondary">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-1">
        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
      </svg>
      Back to Categories
    </a>
  </div>
</div>

<div class="row">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">Category Information</h5>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-4">
            <div class="text-center">
              @if($category->image)
                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="img-fluid rounded" style="max-width: 200px; max-height: 200px;">
              @else
                <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 200px; height: 200px;">
                  <span class="text-primary fw-bold display-4">{{ substr($category->name, 0, 1) }}</span>
                </div>
              @endif
            </div>
          </div>
          <div class="col-md-8">
            <h2 class="h4 mb-3">{{ $category->name }}</h2>
            
            @if($category->parent)
              <div class="mb-3">
                <label class="form-label fw-semibold">Parent Category:</label>
                <div>
                  <a href="{{ route('admin.catalog.categories.show', $category->parent) }}" class="text-decoration-none">
                    {{ $category->parent->name }}
                  </a>
                </div>
              </div>
            @endif
            
            <div class="mb-3">
              <label class="form-label fw-semibold">Status:</label>
              <div>
                <span class="badge bg-{{ $category->is_active ? 'success' : 'secondary' }} fs-6">
                  {{ $category->is_active ? 'Active' : 'Inactive' }}
                </span>
              </div>
            </div>
            
            @if($category->description)
              <div class="mb-3">
                <label class="form-label fw-semibold">Description:</label>
                <div class="text-muted">{{ $category->description }}</div>
              </div>
            @endif
            
            <div class="row">
              <div class="col-sm-6">
                <div class="mb-3">
                  <label class="form-label fw-semibold">Sort Order:</label>
                  <div class="text-muted">{{ $category->sort_order }}</div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="mb-3">
                  <label class="form-label fw-semibold">Slug:</label>
                  <div class="text-muted"><code>{{ $category->slug }}</code></div>
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-sm-6">
                <div class="mb-3">
                  <label class="form-label fw-semibold">Created:</label>
                  <div class="text-muted">{{ $category->created_at->format('M d, Y \a\t g:i A') }}</div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="mb-3">
                  <label class="form-label fw-semibold">Last Updated:</label>
                  <div class="text-muted">{{ $category->updated_at->format('M d, Y \a\t g:i A') }}</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Subcategories Section -->
    @if($category->children->count() > 0)
    <div class="card mt-4">
      <div class="card-header">
        <h5 class="card-title mb-0">Subcategories ({{ $category->children->count() }})</h5>
      </div>
      <div class="card-body">
        <div class="row">
          @foreach($category->children as $child)
          <div class="col-md-6 col-lg-4 mb-3">
            <div class="card border">
              <div class="card-body">
                <div class="d-flex align-items-center">
                  @if($child->image)
                    <img src="{{ asset('storage/' . $child->image) }}" alt="{{ $child->name }}" class="rounded me-2" width="40" height="40">
                  @else
                    <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                      <span class="text-primary fw-bold">{{ substr($child->name, 0, 1) }}</span>
                    </div>
                  @endif
                  <div class="flex-grow-1">
                    <div class="fw-semibold">{{ $child->name }}</div>
                    <div class="text-muted small">{{ $child->products_count }} products</div>
                  </div>
                  <a href="{{ route('admin.catalog.categories.show', $child) }}" class="btn btn-sm btn-outline-primary">View</a>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
    @endif
    
    <!-- Products Section -->
    <div class="card mt-4">
      <div class="card-header">
        <h5 class="card-title mb-0">Products ({{ $category->products_count }})</h5>
      </div>
      <div class="card-body">
        @if($category->products_count > 0)
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Product</th>
                  <th>SKU</th>
                  <th>Price</th>
                  <th>Stock</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($category->products as $product)
                <tr>
                  <td>
                    <div class="d-flex align-items-center">
                      <div class="bg-light rounded me-2" style="width: 40px; height: 40px;"></div>
                      <div>
                        <div class="fw-semibold">{{ $product->name }}</div>
                        <div class="text-muted small">{{ $product->brand->name ?? 'No Brand' }}</div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <code>{{ $product->sku ?: 'N/A' }}</code>
                  </td>
                  <td>
                    <span class="fw-semibold">${{ number_format($product->price, 2) }}</span>
                  </td>
                  <td>
                    <span class="badge bg-{{ $product->stock_quantity > 10 ? 'success' : ($product->stock_quantity > 0 ? 'warning' : 'danger') }}">
                      {{ $product->stock_quantity }}
                    </span>
                  </td>
                  <td>
                    <span class="badge bg-{{ $product->is_active ? 'success' : 'secondary' }}">
                      {{ $product->is_active ? 'Active' : 'Inactive' }}
                    </span>
                  </td>
                  <td>
                    <a href="{{ route('admin.catalog.products.show', $product) }}" class="btn btn-sm btn-outline-primary">View</a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @else
          <div class="text-center py-4">
            <div class="text-muted">No products found in this category.</div>
            <a href="{{ route('admin.catalog.products.create', ['category_id' => $category->id]) }}" class="btn btn-primary mt-2">Add Product</a>
          </div>
        @endif
      </div>
    </div>
  </div>
  
  <div class="col-lg-4">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">Quick Stats</h5>
      </div>
      <div class="card-body">
        <div class="row text-center">
          <div class="col-6">
            <div class="border-end">
              <div class="h4 text-primary mb-1">{{ $category->products_count }}</div>
              <div class="text-muted small">Total Products</div>
            </div>
          </div>
          <div class="col-6">
            <div class="h4 text-success mb-1">{{ $category->children->count() }}</div>
            <div class="text-muted small">Subcategories</div>
          </div>
        </div>
        
        <hr>
        
        <div class="row text-center">
          <div class="col-6">
            <div class="border-end">
              <div class="h4 text-warning mb-1">{{ $category->products->where('stock_quantity', '<=', 10)->count() }}</div>
              <div class="text-muted small">Low Stock</div>
            </div>
          </div>
          <div class="col-6">
            <div class="h4 text-danger mb-1">{{ $category->products->where('stock_quantity', 0)->count() }}</div>
            <div class="text-muted small">Out of Stock</div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="card mt-3">
      <div class="card-header">
        <h5 class="card-title mb-0">Quick Actions</h5>
      </div>
      <div class="card-body">
        <div class="d-grid gap-2">
          <a href="{{ route('admin.catalog.products.create', ['category_id' => $category->id]) }}" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-1">
              <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
            </svg>
            Add Product
          </a>
          <a href="{{ route('admin.catalog.categories.create', ['parent_id' => $category->id]) }}" class="btn btn-outline-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-1">
              <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
            </svg>
            Add Subcategory
          </a>
          <a href="{{ route('admin.catalog.categories.edit', $category) }}" class="btn btn-outline-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-1">
              <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
            </svg>
            Edit Category
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
