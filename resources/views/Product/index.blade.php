@extends('layout.shopping-base')

@section('title', 'Products Table')

<div class="container py-5 text-center">
    <h2 class="mb-4">Product List</h2>

    <!-- Add Product Button -->
     <p>Product</p>
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addProductModal">
        Create Product
    </button>

    <!-- Products Table -->
    <table class="table table-dark table-bordered mx-auto" style="width: 80%;">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <tr class="table-active">
                <th scope="row">1</th>
                <td>Sample Product</td>
                <td>sample-product</td>
                <td>Sample description</td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark text-light">
            <form action="" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <!-- Product Name -->
                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <!-- Slug -->
                    <div class="mb-3">
                        <label class="form-label">Slug</label>
                        <input type="text" name="slug" class="form-control" required>
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3" required></textarea>
                    </div>

                    <!-- Features -->
                    <div class="mb-3">
                        <label class="form-label">Features (Max 200 chars each)</label>
                        <div id="features-wrapper">
                            <div class="input-group mb-2 feature-item">
                                <input type="text" name="features[]" class="form-control" maxlength="200" placeholder="Enter feature" required>
                                <button type="button" class="btn btn-success add-feature">+</button>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Product</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- jQuery (needed for add/remove feature logic) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        // Add new feature field
        $(document).on('click', '.add-feature', function () {
            let newField = `
                <div class="input-group mb-2 feature-item">
                    <input type="text" name="features[]" class="form-control" maxlength="200" placeholder="Enter feature" required>
                    <button type="button" class="btn btn-danger remove-feature">-</button>
                </div>
            `;
            $("#features-wrapper").append(newField);
        });

        // Remove feature field
        $(document).on('click', '.remove-feature', function () {
            $(this).closest('.feature-item').remove();
        });
    });
</script>
