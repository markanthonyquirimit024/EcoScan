@extends('layout.shopping-base')

<link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
<title>Edit Product</title>

<style>
    #h2 {
        padding-top: 50px;
    }
</style>

<div class="container py-5">
    <h2 id="h2">Edit Product</h2>

    <!-- Form -->
    <form id="edit-product-form" action="{{ route('product-update', $product->slug) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label fw-bold">Product Name</label>
            <input type="text" name="name" id="name" 
                   class="form-control" 
                   value="{{ old('name', $product->name) }}" required>
        </div>

        <!-- Slug -->
        <div class="mb-3">
            <label for="slug" class="form-label fw-bold">Slug</label>
            <input type="text" name="slug" id="slug" 
                   class="form-control" 
                   value="{{ old('slug', $product->slug) }}" required>
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label for="description" class="form-label fw-bold">Description</label>
            <textarea name="description" id="description" rows="3" 
                      class="form-control" required>{{ old('description', $product->description) }}</textarea>
        </div>

        <!-- Price -->
        <div class="mb-3">
            <label for="price" class="form-label fw-bold">Price ($)</label>
            <input type="number" name="price" id="price" step="0.01" min="0" 
                   class="form-control" 
                   value="{{ old('price', $product->price) }}" required>
        </div>

        <!-- Image -->
        <div class="mb-3">
            <label class="form-label fw-bold">Product Image</label><br>
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" 
                     alt="Product Image" class="img-thumbnail mb-2" width="150">
            @endif
            <input type="file" name="image" class="form-control">
            <small class="text-muted">Leave blank if you don't want to change the image.</small>
        </div>

        <!-- Features -->
        <div class="mb-3">
            <label class="form-label fw-bold">Product Features</label>
            <div id="features-wrapper">
                @foreach($product->features as $feature)
                    <div class="input-group mb-2">
                        <input type="text" name="features[]" class="form-control" 
                               value="{{ old('features.' . $loop->index, $feature->feature) }}" maxlength="255">
                        <button type="button" class="btn btn-danger remove-feature">-</button>
                    </div>
                @endforeach

                <!-- Add at least one empty field if no features exist -->
                @if($product->features->count() == 0)
                    <div class="input-group mb-2">
                        <input type="text" name="features[]" class="form-control" maxlength="255">
                        <button type="button" class="btn btn-danger remove-feature">-</button>
                    </div>
                @endif
            </div>
            <button type="button" class="btn btn-success mt-2" id="add-feature">+ Add Feature</button>
        </div>

        <!-- Submit -->
        <button type="submit" class="btn btn-primary">Update Product</button>
        <a href="{{ route('product-index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- SweetAlert Messages -->
@if (session('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session('success') }}",
                confirmButtonColor: '#3085d6'
            });
        });
    </script>
@endif

@if (session('error'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "{{ session('error') }}",
                confirmButtonColor: '#d33'
            });
        });
    </script>
@endif

@if ($errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonColor: '#d33'
            });
        });
    </script>
@endif

<!-- Feature JS + Confirmation -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const wrapper = document.getElementById('features-wrapper');
        const addBtn = document.getElementById('add-feature');
        const form = document.getElementById('edit-product-form');

        // Add Feature
        addBtn.addEventListener('click', function () {
            const div = document.createElement('div');
            div.classList.add('input-group', 'mb-2');
            div.innerHTML = `
                <input type="text" name="features[]" class="form-control" maxlength="255">
                <button type="button" class="btn btn-danger remove-feature">-</button>
            `;
            wrapper.appendChild(div);
        });

        // Remove Feature
        wrapper.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-feature')) {
                e.target.closest('.input-group').remove();
            }
        });

        // SweetAlert confirmation before submitting
        form.addEventListener("submit", function (e) {
            e.preventDefault(); // stop form
            Swal.fire({
                title: 'Update Product?',
                text: "Are you sure you want to save these changes?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, update it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
