@extends('layout.shopping-base')

<link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
<title>My Orders</title>

<div class="d-flex justify-content-center align-items-start" style="min-height: 100vh; padding-top: 80px;">
    <div class="w-100" style="max-width: 1200px;">

        <!-- Sticky Header with Search -->
        <div class="row mb-4 sticky-top bg-dark py-3 px-3 shadow-sm rounded" style="z-index: 100;">
            <div class="d-flex justify-content-between align-items-center w-100 flex-wrap gap-2">
                <h2 class="text-white mb-0">📦 My Orders</h2>
                <form action="{{ route('orders.index') }}" method="GET" class="d-flex gap-2 flex-grow-1 flex-md-grow-0">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Search by Product or Status">
                    <button type="submit" class="btn btn-outline-light btn-sm">Search</button>
                </form>
            </div>
        </div>

        <x-success-message/>
        <x-validation-errors/>

        @if($orders->isEmpty())
            <p class="text-center mt-4">You haven't placed any orders yet.</p>
        @else
            <div class="table-responsive" style="max-height: 70vh; overflow-y: auto;">
                <table class="table table-dark table-striped table-hover align-middle text-center mb-0 shadow-sm rounded" style="table-layout: fixed; width: 100%;">
                    <thead class="sticky-top bg-dark" style="z-index: 99;">
                        <tr>
                            <th style="width: 60px;">Image</th>
                            <th style="width: 180px;">Product Name</th>
                            <th style="width: 80px;">Quantity</th>
                            <th style="width: 120px;">Total Price</th>
                            <th style="width: 120px;">Status</th>
                            <th style="width: 150px;">Placed On</th>
                            <th style="width: 200px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr style="height: 60px;">
                                <td>@if($order->product?->image)
                                        <img src="{{ asset('storage/' . $order->product->image) }}" alt="{{ $order->product->name }}"" class="me-2 rounded" style="width: 60px;height:60px">
                                    @endif</td>  
                                <td>
                                    <span>{{ $order->product?->name ?? 'N/A' }}</span>
                                </td>   

                                <td>{{ $order->quantity }}</td>
                                <td>${{ number_format($order->total_price, 2) }}</td>
                                <td>
                                    <span class="badge 
                                        @if($order->status == 'pending') bg-warning
                                        @elseif($order->status == 'approved') bg-info
                                        @elseif($order->status == 'shipped') bg-primary
                                        @elseif($order->status == 'completed') bg-success
                                        @elseif($order->status == 'cancelled') bg-danger
                                        @endif">
                                        {{ ucfirst($order->status ?? 'pending') }}
                                    </span>
                                </td>
                                <td>{{ $order->created_at->format('M d, Y h:i A') }}</td>
                                <td>
                                    <!-- View Contact -->
                                    @if($order->status === 'pending')
                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#contactModal{{ $order->id }}">
                                            Edit Contact
                                        </button>
                                    @elseif($order->status === 'cancelled')
                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewcontactModal{{ $order->id }}">
                                            Show Contact
                                        </button>
                                    @endif


                                    @if($order->status === 'pending')
                                        <form id="cancel-order-{{ $order->id }}" action="{{ route('orders.cancel', $order->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="button" class="btn btn-warning btn-sm cancel-btn" data-id="{{ $order->id }}">Cancel</button>
                                        </form>
                                    @elseif($order->status === 'cancelled')
                                        <form id="delete-order-{{ $order->id }}" action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="{{ $order->id }}">Delete</button>
                                        </form>
                                    @else
                                        <span class="text-muted mt-1">No Action</span>
                                    @endif
                                </td>
                            </tr>

                        <div class="modal fade" id="contactModal{{ $order->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content bg-dark text-white">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Contact Information</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <form action="{{ route('orders.updateAddress', $order->id) }}" method="POST" class="update-contact-form" id="update-contact-{{ $order->id }}">
                                    @csrf
                                    <div class="modal-body text-start">
                                        <div class="mb-3">
                                            <label for="contact_name_{{ $order->id }}" class="form-label">Contact Name</label>
                                            <input type="text" name="contact_name" id="contact_name_{{ $order->id }}" 
                                                class="form-control form-control-sm bg-dark text-white border-secondary"
                                                value="{{ $order->contact_name }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="contact_phone_{{ $order->id }}" class="form-label">Contact Phone</label>
                                            <input type="text" name="contact_phone" id="contact_phone_{{ $order->id }}" 
                                                class="form-control form-control-sm bg-dark text-white border-secondary"
                                                value="{{ $order->contact_phone }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="address_{{ $order->id }}" class="form-label">Address</label>
                                            <textarea name="address" id="address_{{ $order->id }}" rows="3" 
                                                    class="form-control form-control-sm bg-dark text-white border-secondary"
                                                    required>{{ $order->address }}</textarea>
                                        </div>

                                        <p class="small text-warning mb-0">
                                            ⚠ Please provide accurate contact information. Orders with false details may be cancelled.
                                        </p>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-success btn-sm save-contact-btn" data-id="{{ $order->id }}">Save Changes</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="viewcontactModal{{ $order->id }}" tabindex="-1" aria-hidden="true">
                             <div class="modal-dialog modal-dialog-centered">
                             <div class="modal-content bg-dark text-white">
                                 <div class="modal-header">
                                    <h5 class="modal-title">Order Contact Information</h5>
                                      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-start">
                                        <p><strong>Contact Name:</strong> {{ $order->contact_name }}</p>
                                        <p><strong>Contact Phone:</strong> {{ $order->contact_phone }}</p>
                                        <p><strong>Address:</strong> {{ $order->address }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3 d-flex justify-content-center">
                {{ $orders->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.save-contact-btn').forEach(button => {
    button.addEventListener('click', function () {
        let orderId = this.dataset.id;
        Swal.fire({
            title: 'Save Contact Information?',
            text: "This will update the contact details for your order.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, save it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('update-contact-' + orderId).submit();
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    // Cancel Confirmation
    document.querySelectorAll('.cancel-btn').forEach(button => {
        button.addEventListener('click', function () {
            let orderId = this.dataset.id;
            Swal.fire({
                title: 'Cancel Order?',
                text: "You can’t undo this action.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f0ad4e',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, cancel it!'
            }).then((result) => {
                if (result.isConfirmed) document.getElementById('cancel-order-' + orderId).submit();
            });
        });
    });

    // Delete Confirmation
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function () {
            let orderId = this.dataset.id;
            Swal.fire({
                title: 'Delete Order?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) document.getElementById('delete-order-' + orderId).submit();
            });
        });
    });
});
</script>


<style>
.table-dark.table-striped tbody tr:hover,
.table-hover tbody tr:hover {
    background-color: #1f1f1f;
}
.badge {
    font-size: 0.85rem;
    padding: 0.4em 0.7em;
}
</style>
