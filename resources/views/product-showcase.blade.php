@extends('layout.shopping-base')

@section('title', 'Product Showcase')

<style>
    .product {
        padding: 60px 20px;
        background: radial-gradient(circle, rgba(25,121,54,0.9) 0%, rgba(0,0,0,0.9) 100%);
    }
    .product-container {
        display: flex;
        justify-content: center;
        gap: 30px;
        flex-wrap: wrap;
    }
    .product-card {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        padding: 20px;
        width: 500px;
        text-align: center;
        box-shadow: 0 6px 15px rgba(0,0,0,0.4);
        transition: transform 0.3s;
        display: flex;
        flex-direction: column;
        display: flex;
        justify-content: space-between;
    }

    .product-card:hover {
        transform: translateY(-5px);
    }
    .product-card img {
        width: 400px;
        height: 250px;
        object-fit: cover;
        border-radius: 10px;
        margin-bottom: 15px;
    }
    .product-card h3 {
        color: #fff;
        margin-bottom: 10px;
    }
    .product-card ul {
        text-align: left;
        margin: 0 auto 15px;
        padding: 0;
        list-style: disc inside;
        color: #ddd;
    }
    .product-card ul li {
        margin-bottom: 8px;
    }
    .btn-add {
        background: #22c55e;
        color: #fff;
        border: none;
        padding: 10px 15px;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.3s;
        margin-top: auto;
        text-decoration: none;
    }
    .btn-add:hover {
        background: #16a34a;
    }

    .card-bottom {
    margin-top: auto;
    }
    
    footer {
      padding: 30px 20px;
      text-align: center;
      color: #aaa;
      font-size: 0.9rem;
      background: #0d0d0d;
    }
</style>

<section class="product container">
  <div class="product-container">
    <!-- Product 1 -->
    <div class="product-card">
      <img src="{{ asset('images/slide5.jpg') }}" alt="Plastic Detection Sensor">
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
      <img src="{{ asset('images/slide5.jpg') }}" alt="Plastic Detection Sensor">
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

  <!-- Footer -->
  <footer>
    &copy; 2025 EcoScan. All rights reserved.
  </footer>