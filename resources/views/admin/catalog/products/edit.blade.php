@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h1 class="h3 mb-0">Edit Product</h1>
  <a href="{{ route('admin.catalog.products.index') }}" class="btn btn-outline-secondary">Back</a>
  </div>

<form method="POST" action="{{ route('admin.catalog.products.update', $product) }}" enctype="multipart/form-data">
  @csrf
  @method('PUT')
  <div class="row">
    <div class="col-lg-8">
      <div class="card mb-3">
        <div class="card-header"><h6 class="mb-0">Basic Information</h6></div>
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label">Product Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" rows="5" class="form-control">{{ old('description', $product->description) }}</textarea>
          </div>
        </div>
      </div>

      <div class="card mb-3">
        <div class="card-header"><h6 class="mb-0">Pricing & Discount</h6></div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label">Price</label>
              <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Compare at Price</label>
              <input type="number" step="0.01" name="compare_price" class="form-control" value="{{ old('compare_price', $product->compare_price) }}">
            </div>
            <div class="col-md-4">
              <label class="form-label">Cost Price</label>
              <input type="number" step="0.01" name="cost_price" class="form-control" value="{{ old('cost_price', $product->cost_price) }}">
            </div>
            <div class="col-md-4">
              <label class="form-label">GST Rate (%)</label>
              <input type="number" step="0.01" name="gst_rate" class="form-control" value="{{ old('gst_rate', $product->gst_rate) }}">
            </div>
            <div class="col-md-4">
              <label class="form-label">HSN Code</label>
              <input type="text" name="hsn_code" class="form-control" value="{{ old('hsn_code', $product->hsn_code) }}">
            </div>
            <div class="col-md-4">
              <label class="form-label">Discount Type</label>
              <select name="discount_type" class="form-select">
                <option value="" {{ old('discount_type', $product->discount_type)===''?'selected':'' }}>None</option>
                <option value="percent" {{ old('discount_type', $product->discount_type)=='percent'?'selected':'' }}>Percent (%)</option>
                <option value="fixed" {{ old('discount_type', $product->discount_type)=='fixed'?'selected':'' }}>Fixed ($)</option>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label">Discount Value</label>
              <input type="number" step="0.01" name="discount_value" class="form-control" value="{{ old('discount_value', $product->discount_value) }}">
            </div>
            <div class="col-md-6">
              <label class="form-label">Discount Start</label>
              <input type="datetime-local" name="discount_start_at" class="form-control" value="{{ old('discount_start_at', optional($product->discount_start_at)->format('Y-m-d\TH:i')) }}">
            </div>
            <div class="col-md-6">
              <label class="form-label">Discount End</label>
              <input type="datetime-local" name="discount_end_at" class="form-control" value="{{ old('discount_end_at', optional($product->discount_end_at)->format('Y-m-d\TH:i')) }}">
            </div>
          </div>
        </div>
      </div>

      <div class="card mb-3">
        <div class="card-header"><h6 class="mb-0">SEO</h6></div>
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label">SEO Title</label>
            <input type="text" name="seo_title" class="form-control" value="{{ old('seo_title', $product->seo_title) }}">
          </div>
          <div class="mb-3">
            <label class="form-label">SEO Description</label>
            <textarea name="seo_description" rows="3" class="form-control">{{ old('seo_description', $product->seo_description) }}</textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">SEO Keywords (comma separated)</label>
            <input type="text" name="seo_keywords" class="form-control" value="{{ old('seo_keywords', $product->seo_keywords) }}">
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="card mb-3">
        <div class="card-header"><h6 class="mb-0">Organization</h6></div>
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label">Brand</label>
            <select name="brand_id" class="form-select">
              <option value="">--</option>
              @foreach($brands as $brand)
              <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id)==$brand->id?'selected':'' }}>{{ $brand->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category_id" class="form-select" required>
              @foreach($categories as $category)
              <option value="{{ $category->id }}" {{ old('category_id', $product->category_id)==$category->id?'selected':'' }}>{{ $category->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">SKU</label>
              <input type="text" name="sku" class="form-control" value="{{ old('sku', $product->sku) }}" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Barcode</label>
              <input type="text" name="barcode" class="form-control" value="{{ old('barcode', $product->barcode) }}">
            </div>
          </div>
          <div class="row g-3 mt-1">
            <div class="col-md-6">
              <label class="form-label">Stock</label>
              <input type="number" name="stock_quantity" class="form-control" min="0" value="{{ old('stock_quantity', $product->stock_quantity) }}" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Min. Stock</label>
              <input type="number" name="min_stock_level" class="form-control" min="0" value="{{ old('min_stock_level', $product->min_stock_level) }}" required>
            </div>
          </div>
          <div class="row g-3 mt-1">
            <div class="col-md-6">
              <label class="form-label">Weight (kg)</label>
              <input type="number" step="0.01" name="weight" class="form-control" value="{{ old('weight', $product->weight) }}">
            </div>
            <div class="col-md-6">
              <label class="form-label">Color</label>
              <input type="text" name="color" class="form-control" value="{{ old('color', $product->color) }}">
            </div>
          </div>
          <div class="form-check form-switch mt-3">
            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Active</label>
          </div>
          <div class="form-check form-switch mt-1">
            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_featured">Featured</label>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-header"><h6 class="mb-0">Product Images</h6></div>
        <div class="card-body">
          <!-- Image Upload Area -->
          <div class="image-upload-area" id="imageUploadArea">
            <input type="file" name="images[]" id="imageInput" multiple accept="image/*" class="d-none">
            <div class="image-upload-dropzone" onclick="document.getElementById('imageInput').click()">
              <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-muted mb-2">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                <polyline points="17 8 12 3 7 8"></polyline>
                <line x1="12" y1="3" x2="12" y2="15"></line>
              </svg>
              <p class="mb-0 fw-semibold">Click to upload or drag and drop</p>
              <p class="text-muted small mb-0">PNG, JPG, GIF up to 2MB each</p>
            </div>
          </div>

          <!-- Existing Images -->
          @if($product->images && count($product->images) > 0)
          <div class="existing-images-container mt-3">
            <label class="form-label small text-muted mb-2">Existing Images</label>
            <div class="image-preview-container" id="existingImagesContainer">
              @foreach($product->images as $index => $img)
                <div class="image-preview-item" data-image-path="{{ $img }}">
                  <div class="image-preview-wrapper">
                    <img src="{{ asset('storage/'.$img) }}" alt="Product Image" class="image-preview-img">
                    <button type="button" class="image-remove-btn" onclick="removeExistingImage(this, '{{ $img }}')" title="Remove image">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                      </svg>
                    </button>
                    <div class="image-preview-label">Image {{ $index + 1 }}</div>
                  </div>
                  <input type="hidden" name="existing_images[]" value="{{ $img }}">
                </div>
              @endforeach
            </div>
          </div>
          @endif

          <!-- New Images Preview Container -->
          <div class="image-preview-container mt-3" id="imagePreviewContainer"></div>

          <!-- Hidden input to store deleted images -->
          <input type="hidden" name="deleted_images" id="deletedImages" value="">
          <input type="hidden" name="image_order" id="imageOrder" value="">
        </div>
      </div>
    </div>
  </div>

  <div class="mt-3">
    <button class="btn btn-primary">Save Changes</button>
  </div>
</form>

@push('styles')
<style>
  .image-upload-area {
    margin-bottom: 1rem;
  }

  .image-upload-dropzone {
    border: 2px dashed #d1d5db;
    border-radius: 0.5rem;
    padding: 2rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s ease;
    background-color: #f9fafb;
  }

  .image-upload-dropzone:hover {
    border-color: #14b8a6;
    background-color: #f0fdfa;
  }

  .image-upload-dropzone.dragover {
    border-color: #14b8a6;
    background-color: #ecfdf5;
  }

  .image-preview-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    gap: 1rem;
  }

  .image-preview-item {
    position: relative;
  }

  .image-preview-wrapper {
    position: relative;
    border-radius: 0.5rem;
    overflow: hidden;
    border: 2px solid #e5e7eb;
    background-color: #ffffff;
    transition: all 0.2s ease;
  }

  .image-preview-wrapper:hover {
    border-color: #14b8a6;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
  }

  .image-preview-img {
    width: 100%;
    height: 120px;
    object-fit: cover;
    display: block;
  }

  .image-remove-btn {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background-color: rgba(220, 38, 38, 0.9);
    color: #ffffff;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    z-index: 10;
  }

  .image-remove-btn:hover {
    background-color: #dc2626;
    transform: scale(1.1);
  }

  .image-preview-label {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
    color: #ffffff;
    padding: 0.5rem;
    font-size: 0.75rem;
    font-weight: 500;
    text-align: center;
  }

  .image-preview-item.removed {
    opacity: 0.5;
    filter: grayscale(100%);
  }
</style>
@endpush

@push('scripts')
<script>
  let uploadedImages = [];
  let deletedImages = [];

  const imageInput = document.getElementById('imageInput');
  const imagePreviewContainer = document.getElementById('imagePreviewContainer');
  const existingImagesContainer = document.getElementById('existingImagesContainer');
  const imageUploadArea = document.getElementById('imageUploadArea');
  const dropzone = imageUploadArea.querySelector('.image-upload-dropzone');

  // File input change
  imageInput.addEventListener('change', function(e) {
    handleFiles(e.target.files);
  });

  // Drag and drop
  dropzone.addEventListener('dragover', function(e) {
    e.preventDefault();
    dropzone.classList.add('dragover');
  });

  dropzone.addEventListener('dragleave', function(e) {
    e.preventDefault();
    dropzone.classList.remove('dragover');
  });

  dropzone.addEventListener('drop', function(e) {
    e.preventDefault();
    dropzone.classList.remove('dragover');
    const files = e.dataTransfer.files;
    handleFiles(files);
    const dt = new DataTransfer();
    Array.from(imageInput.files).forEach(file => dt.items.add(file));
    Array.from(files).forEach(file => dt.items.add(file));
    imageInput.files = dt.files;
  });

  function handleFiles(files) {
    Array.from(files).forEach(file => {
      if (file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function(e) {
          const imageData = {
            file: file,
            preview: e.target.result,
            id: Date.now() + Math.random()
          };
          uploadedImages.push(imageData);
          renderImagePreview(imageData);
        };
        reader.readAsDataURL(file);
      }
    });
  }

  function renderImagePreview(imageData) {
    const item = document.createElement('div');
    item.className = 'image-preview-item';
    item.dataset.imageId = imageData.id;
    
    item.innerHTML = `
      <div class="image-preview-wrapper">
        <img src="${imageData.preview}" alt="Preview" class="image-preview-img">
        <button type="button" class="image-remove-btn" onclick="removeNewImage('${imageData.id}')" title="Remove image">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
          </svg>
        </button>
        <div class="image-preview-label">New Image</div>
      </div>
    `;
    
    imagePreviewContainer.appendChild(item);
  }

  function removeNewImage(imageId) {
    uploadedImages = uploadedImages.filter(img => img.id !== imageId);
    const item = document.querySelector(`[data-image-id="${imageId}"]`);
    if (item) {
      item.remove();
    }
    updateFileInput();
  }

  function removeExistingImage(btn, imagePath) {
    const item = btn.closest('.image-preview-item');
    if (confirm('Are you sure you want to remove this image?')) {
      deletedImages.push(imagePath);
      item.classList.add('removed');
      const hiddenInput = item.querySelector('input[name="existing_images[]"]');
      if (hiddenInput) {
        hiddenInput.remove();
      }
      btn.style.display = 'none';
    }
  }

  function updateFileInput() {
    const dt = new DataTransfer();
    uploadedImages.forEach(img => {
      dt.items.add(img.file);
    });
    imageInput.files = dt.files;
  }

  // Update form data on submit
  document.querySelector('form').addEventListener('submit', function() {
    document.getElementById('deletedImages').value = JSON.stringify(deletedImages);
    
    const order = [];
    if (existingImagesContainer) {
      Array.from(existingImagesContainer.querySelectorAll('.image-preview-item:not(.removed)'))
        .forEach(item => {
          const path = item.dataset.imagePath;
          if (path) order.push(path);
        });
    }
    Array.from(imagePreviewContainer.querySelectorAll('.image-preview-item'))
      .forEach(item => {
        const id = item.dataset.imageId;
        if (id) order.push(id);
      });
    document.getElementById('imageOrder').value = JSON.stringify(order);
  });
</script>
@endpush
@endsection


