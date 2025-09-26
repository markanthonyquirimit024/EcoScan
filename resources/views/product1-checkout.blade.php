@extends('layout.shopping-base')

<title>Checkout</title>
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">


<div class="container py-5">
    <h2 class="mb-4 mt-4 text-center">Checkout Preview</h2>

    <div class="row">
        <!-- Static Order Summary -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm p-3">
                <h5 class="mb-3">Order Summary</h5>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Plastic Detection Sensor 1
                        <span>$1,500</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Shipping
                        <span>$100</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center fw-bold">
                        Total
                        <span>$1,600</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Static Billing Form -->
        <div class="col-md-6">
            <div class="card shadow-sm p-3">
                <h5 class="mb-3">Billing Information</h5>
                <form onsubmit="showMessage(event)">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" placeholder="Juan Dela Cruz">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" placeholder="example@email.com">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <input type="text" class="form-control" placeholder="123 Street, City">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="phone" class="form-control" placeholder="+639xxxxxxxxx">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Payment Method</label>
                        <select class="form-select">
                            <option selected>Cash on Delivery</option>
                            <option>Credit/Debit Card</option>
                            <option>GCash</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Place Order</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function showMessage(e) {
    e.preventDefault();
    alert("✅ Thank you for your order!");
    window.location.href = "{{ route('orderbtn') }}";
}
</script>

