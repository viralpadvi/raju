@extends('layouts.admin')

@section('title', 'Edit Brand')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h1 class="h3 mb-0">Edit Brand</h1>
  <a href="{{ route('admin.catalog.brands.index') }}" class="btn btn-outline-secondary">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-1">
      <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
    </svg>
    Back to Brands
  </a>
</div>

<div class="row">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">Brand Information</h5>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin.catalog.brands.update', $brand) }}" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="name" class="form-label">Brand Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $brand->name) }}" required>
                @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="website" class="form-label">Website</label>
                <input type="url" class="form-control @error('website') is-invalid @enderror" id="website" name="website" value="{{ old('website', $brand->website) }}" placeholder="https://example.com">
                @error('website')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Enter brand description...">{{ old('description', $brand->description) }}</textarea>
            @error('description')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="logo" class="form-label">Brand Logo</label>
                @if($brand->logo)
                  <div class="mb-2">
                    <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}" class="img-thumbnail" style="max-width: 100px; max-height: 100px;">
                    <div class="form-text">Current logo</div>
                  </div>
                @endif
                <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo" accept="image/*">
                <div class="form-text">Upload a new logo to replace the current one (JPG, PNG, GIF, SVG). Max size: 2MB.</div>
                @error('logo')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="is_active" class="form-label">Status</label>
                <select class="form-select @error('is_active') is-invalid @enderror" id="is_active" name="is_active">
                  <option value="1" {{ old('is_active', $brand->is_active) == '1' ? 'selected' : '' }}>Active</option>
                  <option value="0" {{ old('is_active', $brand->is_active) == '0' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('is_active')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-1">
                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
              </svg>
              Update Brand
            </button>
            <a href="{{ route('admin.catalog.brands.index') }}" class="btn btn-outline-secondary">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>
  
  <div class="col-lg-4">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">Brand Statistics</h5>
      </div>
      <div class="card-body">
        <div class="row text-center">
          <div class="col-6">
            <div class="border-end">
              <div class="h4 text-primary mb-1">{{ $brand->products_count }}</div>
              <div class="text-muted small">Products</div>
            </div>
          </div>
          <div class="col-6">
            <div class="h4 text-success mb-1">{{ $brand->is_active ? 'Active' : 'Inactive' }}</div>
            <div class="text-muted small">Status</div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="card mt-3">
      <div class="card-header">
        <h5 class="card-title mb-0">Tips</h5>
      </div>
      <div class="card-body">
        <div class="alert alert-info">
          <h6 class="alert-heading">Brand Guidelines</h6>
          <ul class="mb-0 small">
            <li>Use clear, descriptive brand names</li>
            <li>Upload high-quality logos (PNG with transparent background recommended)</li>
            <li>Include website URL for brand verification</li>
            <li>Write detailed descriptions for better SEO</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
