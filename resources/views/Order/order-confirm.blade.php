@extends('layout.shopping-base')

<title>Confirm Order</title>
<link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

<style>
    #h2
    {
        margin-top: 50px;
    }
</style>

<main class="container py-5">
    <h2 id="h2">Confirm Your Order</h2>
    <p>Please review your order details and fill in your contact information.</p>

    <div class="card p-4 shadow-sm">
        <h4>{{ $product->name }}</h4>
        <img src="{{ asset('storage/' . $product->image) }}" 
             alt="{{ $product->name }}" width="200" class="mb-3">
        <p>{{ $product->description }}</p>
        <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
        <form action="{{ route('orders.store', $product->slug) }}" method="POST">
            @csrf
            <input type="hidden" name="quantity" value="1">

            <div class="mb-3">
                <label class="form-label fw-bold">Full Name</label>
                <input type="text" name="contact_name" class="form-control" placeholder="ex. John Doe" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Phone Number (e.g 09xx xxx xxxx)</label>
                <input type="text" name="contact_phone" class="form-control" required
                    maxlength="11" pattern="\d{11}" title="Phone number must be 11 digits"
                    oninput="this.value = this.value.replace(/\D/g,'').slice(0,11)" placeholder="09123456789">
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Delivery Address (Full Address)</label>
                <textarea name="address" class="form-control" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <p>Failure to provide real contact information may result in your order being cancelled.</p>
            </div>

            <button type="submit" class="btn btn-success">Confirm Order</button>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</main>
