@extends('layouts.admin')

@section('title', 'Add New Project')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h1 class="h3 mb-0">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-2">
      <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
    </svg>
    Add New Project
  </h1>
  <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-1">
      <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
    </svg>
    Back to Projects
  </a>
</div>

<form method="POST" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data">
  @csrf
  
  <div class="row">
    <div class="col-lg-8">
      <!-- Basic Information -->
      <div class="card mb-4 border-0 shadow-sm">
        <div class="card-header bg-white">
          <h5 class="card-title mb-0">Basic Information</h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="name" class="form-label">Project Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="client" class="form-label">Client Name</label>
                <input type="text" class="form-control @error('client') is-invalid @enderror" id="client" name="client" value="{{ old('client') }}">
                @error('client')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label for="description" class="form-label">Short Description</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Brief description of the project...">{{ old('description') }}</textarea>
            @error('description')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="details" class="form-label">Project Details</label>
            <textarea class="form-control @error('details') is-invalid @enderror" id="details" name="details" rows="6" placeholder="Detailed information about the project...">{{ old('details') }}</textarea>
            @error('details')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">Provide comprehensive details about the project scope, objectives, and deliverables.</div>
          </div>

          <div class="mb-3">
            <label for="specification" class="form-label">Specification</label>
            <div id="specification-container">
              <div class="specification-item mb-2 d-flex gap-2">
                <input type="text" class="form-control form-control-sm" name="specification[0][key]" placeholder="Key" value="{{ old('specification.0.key') }}">
                <input type="text" class="form-control form-control-sm" name="specification[0][value]" placeholder="Value" value="{{ old('specification.0.value') }}">
                <button type="button" class="btn btn-sm btn-outline-danger remove-specification" style="display:none;">×</button>
              </div>
            </div>
            <button type="button" class="btn btn-sm btn-outline-primary" id="add-specification">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" class="me-1">
                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
              </svg>
              Add Specification
            </button>
          </div>
        </div>
      </div>

      <!-- Media Files -->
      <div class="card mb-4 border-0 shadow-sm">
        <div class="card-header bg-white">
          <h5 class="card-title mb-0">Media Files</h5>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <label for="images" class="form-label">Project Images</label>
            <input type="file" class="form-control @error('images.*') is-invalid @enderror" id="images" name="images[]" accept="image/*" multiple>
            <div class="form-text">Upload multiple images (JPG, PNG, GIF, WebP). Max size: 5MB per image.</div>
            @error('images.*')
              <div class="text-danger small">{{ $message }}</div>
            @enderror
            <div id="image-preview" class="mt-3 d-flex flex-wrap gap-2"></div>
          </div>

          <div class="mb-3">
            <label for="videos" class="form-label">Project Videos</label>
            <input type="file" class="form-control @error('videos.*') is-invalid @enderror" id="videos" name="videos[]" accept="video/*" multiple>
            <div class="form-text">Upload multiple videos (MP4, AVI, MOV, WMV, FLV). Max size: 50MB per video.</div>
            @error('videos.*')
              <div class="text-danger small">{{ $message }}</div>
            @enderror
            <div id="video-preview" class="mt-3"></div>
          </div>

          <div class="mb-3">
            <label for="youtube_link" class="form-label">YouTube Link</label>
            <input type="url" class="form-control @error('youtube_link') is-invalid @enderror" id="youtube_link" name="youtube_link" value="{{ old('youtube_link') }}" placeholder="https://www.youtube.com/watch?v=...">
            @error('youtube_link')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>

      <!-- Client Information -->
      <div class="card mb-4 border-0 shadow-sm">
        <div class="card-header bg-white">
          <h5 class="card-title mb-0">Client Information</h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="client_logo" class="form-label">Client Logo</label>
                <input type="file" class="form-control @error('client_logo') is-invalid @enderror" id="client_logo" name="client_logo" accept="image/*">
                @error('client_logo')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div id="client-logo-preview" class="mt-2"></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="client_website" class="form-label">Client Website</label>
                <input type="url" class="form-control @error('client_website') is-invalid @enderror" id="client_website" name="client_website" value="{{ old('client_website') }}" placeholder="https://clientwebsite.com">
                @error('client_website')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Social Media Links -->
      <div class="card mb-4 border-0 shadow-sm">
        <div class="card-header bg-white">
          <h5 class="card-title mb-0">Social Media & Links</h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="facebook_link" class="form-label">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-1">
                    <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
                  </svg>
                  Facebook
                </label>
                <input type="url" class="form-control" id="facebook_link" name="facebook_link" value="{{ old('facebook_link') }}" placeholder="https://facebook.com/...">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="twitter_link" class="form-label">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-1">
                    <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/>
                  </svg>
                  Twitter
                </label>
                <input type="url" class="form-control" id="twitter_link" name="twitter_link" value="{{ old('twitter_link') }}" placeholder="https://twitter.com/...">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="instagram_link" class="form-label">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-1">
                    <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                    <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                    <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                  </svg>
                  Instagram
                </label>
                <input type="url" class="form-control" id="instagram_link" name="instagram_link" value="{{ old('instagram_link') }}" placeholder="https://instagram.com/...">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="linkedin_link" class="form-label">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-1">
                    <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path>
                    <rect x="2" y="9" width="4" height="12"></rect>
                    <circle cx="4" cy="4" r="2"></circle>
                  </svg>
                  LinkedIn
                </label>
                <input type="url" class="form-control" id="linkedin_link" name="linkedin_link" value="{{ old('linkedin_link') }}" placeholder="https://linkedin.com/...">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="github_link" class="form-label">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-1">
                    <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"/>
                  </svg>
                  GitHub
                </label>
                <input type="url" class="form-control" id="github_link" name="github_link" value="{{ old('github_link') }}" placeholder="https://github.com/...">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="website_link" class="form-label">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="2" y1="12" x2="22" y2="12"></line>
                    <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                  </svg>
                  Website
                </label>
                <input type="url" class="form-control" id="website_link" name="website_link" value="{{ old('website_link') }}" placeholder="https://projectwebsite.com">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <!-- Project Settings -->
      <div class="card mb-4 border-0 shadow-sm">
        <div class="card-header bg-white">
          <h5 class="card-title mb-0">Project Settings</h5>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
              <option value="pending" {{ old('status', 'pending') === 'pending' ? 'selected' : '' }}>Pending</option>
              <option value="in_progress" {{ old('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
              <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>Completed</option>
              <option value="on_hold" {{ old('status') === 'on_hold' ? 'selected' : '' }}>On Hold</option>
              <option value="cancelled" {{ old('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            @error('status')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="priority" class="form-label">Priority <span class="text-danger">*</span></label>
            <select class="form-select @error('priority') is-invalid @enderror" id="priority" name="priority" required>
              <option value="low" {{ old('priority', 'medium') === 'low' ? 'selected' : '' }}>Low</option>
              <option value="medium" {{ old('priority', 'medium') === 'medium' ? 'selected' : '' }}>Medium</option>
              <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>High</option>
              <option value="urgent" {{ old('priority') === 'urgent' ? 'selected' : '' }}>Urgent</option>
            </select>
            @error('priority')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <input type="text" class="form-control @error('category') is-invalid @enderror" id="category" name="category" value="{{ old('category') }}" placeholder="e.g., Web Development, Mobile App">
            @error('category')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="tags" class="form-label">Tags</label>
            <input type="text" class="form-control @error('tags') is-invalid @enderror" id="tags" name="tags" value="{{ old('tags') }}" placeholder="tag1, tag2, tag3">
            @error('tags')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">Separate tags with commas</div>
          </div>

          <div class="mb-3">
            <label for="budget" class="form-label">Budget</label>
            <div class="input-group">
              <span class="input-group-text">₹</span>
              <input type="number" class="form-control @error('budget') is-invalid @enderror" id="budget" name="budget" value="{{ old('budget') }}" step="0.01" min="0" placeholder="0.00">
            </div>
            @error('budget')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date') }}">
                @error('start_date')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date') }}">
                @error('end_date')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label for="sort_order" class="form-label">Sort Order</label>
            <input type="number" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
            @error('sort_order')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">Lower numbers appear first</div>
          </div>

          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Active</label>
          </div>

          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
            <label class="form-check-label" for="is_featured">Featured</label>
          </div>
        </div>
      </div>

      <!-- SEO Settings -->
      <div class="card mb-4 border-0 shadow-sm">
        <div class="card-header bg-white">
          <h5 class="card-title mb-0">SEO Settings</h5>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <label for="meta_title" class="form-label">Meta Title</label>
            <input type="text" class="form-control" id="meta_title" name="meta_title" value="{{ old('meta_title') }}" maxlength="255">
          </div>
          <div class="mb-3">
            <label for="meta_description" class="form-label">Meta Description</label>
            <textarea class="form-control" id="meta_description" name="meta_description" rows="3">{{ old('meta_description') }}</textarea>
          </div>
          <div class="mb-3">
            <label for="meta_keywords" class="form-label">Meta Keywords</label>
            <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords') }}" placeholder="keyword1, keyword2, keyword3">
            <div class="form-text">Separate keywords with commas</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="d-flex gap-2 mb-4">
    <button type="submit" class="btn btn-primary">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-1">
        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
      </svg>
      Create Project
    </button>
    <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary">Cancel</a>
  </div>
</form>
@endsection

@push('scripts')
<script>
  // Handle specification fields
  let specCount = 1;
  document.getElementById('add-specification').addEventListener('click', function() {
    const container = document.getElementById('specification-container');
    const newItem = document.createElement('div');
    newItem.className = 'specification-item mb-2 d-flex gap-2';
    newItem.innerHTML = `
      <input type="text" class="form-control form-control-sm" name="specification[${specCount}][key]" placeholder="Key">
      <input type="text" class="form-control form-control-sm" name="specification[${specCount}][value]" placeholder="Value">
      <button type="button" class="btn btn-sm btn-outline-danger remove-specification">×</button>
    `;
    container.appendChild(newItem);
    specCount++;
    updateRemoveButtons();
  });

  document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-specification')) {
      e.target.closest('.specification-item').remove();
      updateRemoveButtons();
    }
  });

  function updateRemoveButtons() {
    const items = document.querySelectorAll('.specification-item');
    items.forEach((item, index) => {
      const removeBtn = item.querySelector('.remove-specification');
      if (removeBtn) {
        removeBtn.style.display = items.length > 1 ? 'block' : 'none';
      }
    });
  }

  // Image preview
  document.getElementById('images').addEventListener('change', function(e) {
    const preview = document.getElementById('image-preview');
    preview.innerHTML = '';
    Array.from(e.target.files).forEach((file, index) => {
      const reader = new FileReader();
      reader.onload = function(e) {
        const img = document.createElement('img');
        img.src = e.target.result;
        img.className = 'img-thumbnail';
        img.style.width = '150px';
        img.style.height = '150px';
        img.style.objectFit = 'cover';
        preview.appendChild(img);
      };
      reader.readAsDataURL(file);
    });
  });

  // Client logo preview
  document.getElementById('client_logo').addEventListener('change', function(e) {
    const preview = document.getElementById('client-logo-preview');
    preview.innerHTML = '';
    if (e.target.files[0]) {
      const reader = new FileReader();
      reader.onload = function(e) {
        const img = document.createElement('img');
        img.src = e.target.result;
        img.className = 'img-thumbnail';
        img.style.width = '100px';
        img.style.height = '100px';
        img.style.objectFit = 'contain';
        preview.appendChild(img);
      };
      reader.readAsDataURL(e.target.files[0]);
    }
  });

  // Parse tags from comma-separated string
  document.getElementById('tags').addEventListener('blur', function() {
    const value = this.value;
    if (value) {
      const tags = value.split(',').map(tag => tag.trim()).filter(tag => tag);
      // Could save as JSON array, but keeping as comma-separated for now
    }
  });
</script>
@endpush

