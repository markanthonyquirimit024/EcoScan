@extends('layout.shopping-base')

<title>Shop Product</title>
<link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
<link rel="stylesheet" href="{{ asset('assets/product-listing.css') }}">

<main>
  <section class="product">
    <h2>Our Eco-Friendly Products</h2>
    <p>Discover the latest smart plastic detection sensors designed to help you reduce waste and track your daily plastic usage effectively.</p>

    <div class="product-container">
      @foreach($products as $product)
        <div class="product-card">
          <!-- Product Image -->
          <div class="slider-container">
            @if($product->image)
              <div class="slider-images">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
              </div>
            @else
              <div class="slider-images">
                <img src="{{ asset('images/no-image.png') }}" alt="No image">
              </div>
            @endif
          </div>

          <!-- Product Info -->
          <h3 class="text-center">{{ $product->name }}</h3>
          <p>{{ $product->description }}</p>
          <ul>
            @foreach($product->features as $feature)
              <li>{{ $feature->feature }}</li>
            @endforeach
          </ul>

          <!-- Order Form -->
          <div class="card-bottom">
            <p>For as low as ${{ number_format($product->price, 2) }}</p>

            @auth
              @if(Auth::user()->utype === 'CUSTOMER')
                <a href="{{ route('orders.create', $product->slug) }}" class="btn btn-primary">Order Now</a>
              @endif
            @else
              <a class="btn btn-warning text-decoration-none" href="{{ route('login') }}">Login to Order</a>
            @endauth
          </div>
        </div>
      @endforeach
    </div>
  </section>
</main>

<footer>
  &copy; 2025 EcoScan. All rights reserved.
</footer>

<!-- Dark/Light Mode Toggle -->
<div class="theme-toggle">
  <label class="switch">
    <input type="checkbox" id="mode-toggle">
    <span class="slider"></span>
  </label>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  // =====================
  // Theme Toggle
  // =====================
  const toggle = document.getElementById('mode-toggle');
  const body = document.body;

  const savedTheme = localStorage.getItem('theme');
  if (savedTheme === 'dark') {
    body.classList.add('dark-mode');
    toggle.checked = true;
  }

  toggle.addEventListener('change', () => {
    if (toggle.checked) {
      body.classList.add('dark-mode');
      localStorage.setItem('theme', 'dark');
    } else {
      body.classList.remove('dark-mode');
      localStorage.setItem('theme', 'light');
    }
  });

  // =====================
  // SweetAlert2 Toast
  // =====================
  @if(session('success'))
    Swal.fire({
      toast: true,
      position: 'top-end',
      icon: 'success',
      title: "{{ session('success') }}",
      showConfirmButton: false,
      timer: 2000,
      timerProgressBar: true
    });
  @endif


document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".order-btn").forEach(button => {
        button.addEventListener("click", function () {
            let slug = this.dataset.slug;
            let form = document.getElementById("order-form-" + slug);

            Swal.fire({
                title: "Confirm Order",
                text: "Do you want to place this order?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Order Now"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});

</script>
