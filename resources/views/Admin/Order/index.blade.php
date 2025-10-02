@extends('layout.shopping-base')
<link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
<title>Order Management</title>

<div class="d-flex justify-content-center align-items-start" style="min-height: 100vh; padding-top: 80px;">
    <div style="width: 90%;">

        <!-- Sticky Header with Search -->
        <div class="row mb-4 sticky-top bg-dark py-3 px-3" style="z-index: 100;">
            <div class="d-flex justify-content-between align-items-center w-100">
                <h2 class="text-white mb-0">All Orders</h2>
                <form action="{{ route('admin.orders.index') }}" method="GET" class="d-flex" style="gap: 5px;">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Search by Order ID, User or Product">
                    <button type="submit" class="btn btn-outline-light">Search</button>
                </form>
            </div>
        </div>
        <x-success-message/>
        <x-validation-errors/>

        @if($orders->isEmpty())
            <p class="text-center mt-4">No orders placed yet.</p>
        @else
            <div style="max-height: 65vh; overflow-y: auto;">
                <table class="table table-dark table-striped table-hover align-middle text-center mb-0" style="table-layout: fixed; width: 100%;">
                    <thead class="sticky-top bg-dark" style="z-index: 99;">
                        <tr>
                            <th style="width: 60px;">Order #</th>
                            <th style="width: 200px;">User Contact Info</th>
                            <th style="width: 200px;">Product</th>
                            <th style="width: 80px;">Quantity</th>
                            <th style="width: 120px;">Total</th>
                            <th style="width: 120px;">Status</th>
                            <th style="width: 150px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#contactModal{{ $order->id }}">
                                        View Contact
                                    </button>
                                </td>
                                <td class="text-start">{{ $order->product->name }}</td>
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
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td>
                                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                        @csrf
                                        <select name="status" onchange="this.form.submit()" class="form-select form-select-sm">
                                            <option value="pending"   {{ $order->status=='pending'?'selected':'' }}>Pending</option>
                                            <option value="approved"  {{ $order->status=='approved'?'selected':'' }}>Approved</option>
                                            <option value="shipped"   {{ $order->status=='shipped'?'selected':'' }}>Shipped</option>
                                            <option value="completed" {{ $order->status=='completed'?'selected':'' }}>Completed</option>
                                            <option value="cancelled" {{ $order->status=='cancelled'?'selected':'' }}>Cancelled</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>

                            <!-- Contact Info Modal -->
                            <div class="modal fade" id="contactModal{{ $order->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content bg-dark text-white">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Contact Information</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-start">
                                            <p><strong>User Id:</strong> #{{ $order->user->id }}</p>
                                            <p><strong>Name:</strong> {{ $order->user->first_name }} {{ $order->user->last_name }}</p>
                                            <p><strong>Phone:</strong> {{ $order->contact_phone }}</p>
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
