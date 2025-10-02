@include('layout.shopping-base')
<link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
<title>Create Product</title> 

<section class="product-container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card bg-dark text-white shadow-lg" style="width: 600px; margin-top: 80px">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Create Product</h4>
            <a href="{{ route('product-index') }}" class="btn btn-sm btn-secondary">Back</a>
        </div>
        <div class="card-body">
            {{-- Add enctype for file upload --}}
            <form action="{{ route('product-store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Product Name --}}
                <div class="mb-3">
                    <label for="name" class="form-label">Product Name</label>
                    <input type="text"
                           class="form-control @error('name') is-invalid @enderror"
                           id="name"
                           name="name"
                           value="{{ old('name') }}"
                           required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Slug --}}
                <div class="mb-3">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text"
                           class="form-control @error('slug') is-invalid @enderror"
                           id="slug"
                           name="slug"
                           value="{{ old('slug') }}"
                           required
                           readonly>
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror"
                              id="description"
                              name="description"
                              rows="3"
                              maxlength="200"
                              required>{{ old('description') }}</textarea>
                    <small class="text-muted">Max 200 characters</small>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Price --}}
                <div class="form-group mb-3">
                    <label for="price" class="form-label">Price ($)</label>
                    <input type="number"
                           step="0.01"
                           name="price"
                           id="price"
                           class="form-control @error('price') is-invalid @enderror"
                           value="{{ old('price') }}"
                           required>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Image Upload --}}
                <div class="mb-3">
                    <label for="image" class="form-label">Product Image</label>
                    <input type="file"
                           class="form-control @error('image') is-invalid @enderror"
                           id="image"
                           name="image"
                           accept="image/*"
                           required
                           onchange="previewImage(event)">
                    <small class="text-muted">Accepted formats: jpeg, png, jpg, gif | Max: 2MB</small>
                    @error('image')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror

                    {{-- Preview --}}
                    <div class="mt-3 text-center">
                        <img id="imagePreview"
                             src="#"
                             alt="Preview"
                             style="max-width: 200px; max-height: 200px; display: none; border-radius: 8px;">
                    </div>
                </div>

                {{-- Features --}}
                <div class="mb-3">
                    <label class="form-label">Features</label>
                    <div id="features-container">
                        <div class="input-group mb-2">
                            <input type="text"
                                   class="form-control @error('features.0') is-invalid @enderror"
                                   name="features[]"
                                   placeholder="Enter feature"
                                   value="{{ old('features.0') }}"
                                   required>
                        </div>
                    </div>
                    @error('features')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                    @error('features.*')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                    <button type="button" class="btn btn-sm btn-outline-light" onclick="addFeature()">+ Add Feature</button>
                </div>

                {{-- Submit --}}
                <div class="text-end">
                    <button type="submit" class="btn btn-success">Save Product</button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    // Auto-generate slug
    document.getElementById('name').addEventListener('input', function() {
        let name = this.value;
        let slug = name.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');
        document.getElementById('slug').value = slug;
    });

    // Add/remove features
    function addFeature() {
        const container = document.getElementById('features-container');
        const div = document.createElement('div');
        div.className = 'input-group mb-2';
        div.innerHTML = `
            <input type="text" class="form-control" name="features[]" placeholder="Enter feature" required>
            <button type="button" class="btn btn-danger" onclick="removeFeature(this)">❌</button>
        `;
        container.appendChild(div);
    }

    function removeFeature(button) {
        button.parentElement.remove();
    }

    // Image Preview
    function previewImage(event) {
        const preview = document.getElementById('imagePreview');
        preview.src = URL.createObjectURL(event.target.files[0]);
        preview.style.display = 'block';
    }
</script>
