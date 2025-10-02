@extends('layout.shopping-base')

<link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
<title>Manage Products</title>

<div class="d-flex justify-content-center align-items-start" style="min-height: 100vh; padding-top: 80px;">
    <div style="width: 90%;">
        <!-- Sticky Header -->
        <div class="row mb-4 sticky-top bg-dark py-3" style="z-index: 100;">
            <div class="col text-start">
                <h2 class="text-white mb-0">Manage Products</h2>
            </div>
            <div class="col text-center">
                <form action="{{ route('product-index') }}" method="GET" class="d-flex">
                    <input type="text"
                           name="search"
                           class="form-control me-2"
                           placeholder="Search products..."
                           value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-light">Search</button>
                </form>
            </div>
            <div class="col text-end">
                <a class="btn btn-success" href="{{ route('product-create') }}">+ Add Product</a>
            </div>
        </div>

        <x-success-message/>
        <x-validation-errors/>

        <!-- Table -->
        <div style="max-height: 65vh; overflow-y: auto;">
            <table class="table table-dark table-bordered text-center mb-0" style="table-layout: fixed; width: 100%;">
                <thead class="sticky-top bg-dark" style="z-index: 99;">
                    <tr>
                        <th style="width: 60px;">Id</th>
                        <th style="width: 150px;">Image</th>
                        <th style="width: 180px;">Name</th>
                        <th style="width: 180px;">Slug</th>
                        <th style="width: 120px;">Price</th>
                        <th style="width: 200px;">Description</th>
                        <th style="width: 320px;">Features</th>
                        <th style="width: 150px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         alt="{{ $product->name }}" 
                                         class="img-thumbnail" 
                                         style="max-width: 100px; max-height: 100px;">
                                @else
                                    <span class="text-muted">No image</span>
                                @endif
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->slug }}</td>
                            <td>${{ number_format($product->price, 2) }}</td>
                            <td class="text-start" style="white-space: normal; word-wrap: break-word;">
                                {{ Str::limit($product->description, 50) }}
                            </td>
                            <td class="text-start" style="white-space: normal; word-wrap: break-word;">
                                <ul class="list-disc pl-4 mb-0">
                                    @foreach ($product->features as $feature)
                                        <li>{{ $feature->feature }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                <a class="btn btn-warning my-2" href="{{route('product-edit', $product->slug)}}">
                                    ✏️ Edit
                                </a>
                                <form id="delete-product-form-{{ $product->id }}" action="{{ route('product-destroy', $product->slug) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger delete-btn">🗑️ Delete</button>
                                </form>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <strong>No results found.</strong>
                                @if(request('search'))
                                    <div class="small">Try adjusting your search (e.g. "<em>{{ request('search') }}</em>").</div>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3 d-flex justify-content-center">
            {{ $products->appends(request()->query())->links() }}
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('form');
            Swal.fire({
                title: 'Delete Product?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>