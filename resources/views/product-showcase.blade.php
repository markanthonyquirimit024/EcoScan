@extends('layout.shopping-base')

@section('title', 'Product Showcase')

<link rel="stylesheet" href="{{ asset('assets/product-listing.css') }}">

<main>
  <section class="product">
    <h2>Our Eco-Friendly Products</h2>
    <p>Discover the latest smart plastic detection sensors designed to help you reduce waste and track your daily plastic usage effectively.</p>

    <div class="product-container">
      <!-- Product 1 -->
      <div class="product-card">
        <div class="slider-container">
          <div class="slider-images">
            <img src="{{ asset('images/slide5.jpg') }}" alt="Plastic Sensor 1">
            <img src="{{ asset('images/slide6.jpg') }}" alt="Plastic Sensor 1 alt">
          </div>
          <button class="slider-btn prev-btn">&#10094;</button>
          <button class="slider-btn next-btn">&#10095;</button>
        </div>
        <h3>Plastic Detection Sensor 1</h3>
        <ul>
          <li>Smart plastic detection technology</li>
          <li>Enhanced detection accuracy</li>
          <li>Tracks daily plastic usage</li>
        </ul>
        <div class="card-bottom">
          <p>For as low as $500</p>
          @auth
              @if(Auth::user()->utype === 'CUST')
                  <a class="btn-add" href="#">Order Now</a>
              @endif
          @else
              <a class="btn-add" href="{{ route('login') }}">Login to Order</a>
          @endauth
        </div>
      </div>

      <!-- Product 2 -->
      <div class="product-card">
        <div class="slider-container">
          <div class="slider-images">
            <img src="{{ asset('images/slide5.jpg') }}" alt="Plastic Sensor 2">
            <img src="{{ asset('images/slide7.jpg') }}" alt="Plastic Sensor 2 alt">
          </div>
          <button class="slider-btn prev-btn">&#10094;</button>
          <button class="slider-btn next-btn">&#10095;</button>
        </div>
        <h3>Plastic Detection Sensor 2</h3>
        <ul>
          <li>Lightweight and portable</li>
          <li>Smart plastic detection technology</li>
          <li>Enhanced detection accuracy</li>
          <li>Tracks daily plastic usage</li>
          <li>Personalized EcoScan website access</li>
          <li>Includes sustainability web dashboard</li>
        </ul>
        <div class="card-bottom">
          <p>For as low as $1500</p>
          @auth
              @if(Auth::user()->utype === 'CUST')
                  <a class="btn-add" href="#">Order Now</a>
              @endif
          @else
              <a class="btn-add" href="{{ route('login') }}">Login to Order</a>
          @endauth
        </div>
      </div>
    </div>
  </section>
</main>

<!-- Footer -->
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

<script>
    // =====================
    // Theme Toggle
    // =====================
    const toggle = document.getElementById('mode-toggle');
    const body = document.body;

    // Initialize theme from localStorage
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
    // Image Slider
    // =====================
    document.querySelectorAll('.product-card').forEach(card => {
        const images = card.querySelector('.slider-images');
        const imgs = images.querySelectorAll('img');
        const prevBtn = card.querySelector('.prev-btn');
        const nextBtn = card.querySelector('.next-btn');
        let index = 0;

        function showSlide(i) {
            index = (i + imgs.length) % imgs.length;
            images.style.transform = `translateX(-${index * 100}%)`;
        }

        prevBtn.addEventListener('click', () => showSlide(index - 1));
        nextBtn.addEventListener('click', () => showSlide(index + 1));
    });
</script>
