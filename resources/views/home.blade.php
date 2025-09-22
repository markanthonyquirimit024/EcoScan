@include('layout.shopping-base')

<title>EcoScan – Smart Plastic Detection</title>
<style>
  body {
    font-family: 'Inter', sans-serif;
    margin: 0;
    color: #222;
    background: #f0fdf4; /* light mode background */
    line-height: 1.6;
    overflow-x: hidden;
    transition: background 0.4s ease, color 0.4s ease;
  }

  /* Smooth fade-in */
  .fade-in {
    opacity: 0;
    transform: translateY(20px);
    animation: fadeInUp 1s ease forwards;
  }
  @keyframes fadeInUp {
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  /* Hero Section */
  .hero {
    margin-top: 120px;
    padding: 100px 20px;
    background: linear-gradient(135deg, #a5d6a7, #ffffff);
    border-radius: 25px;
    box-shadow: 0 12px 30px rgba(0,0,0,0.08);
    transition: background 0.4s ease, color 0.4s ease;
  }
  .hero-text h1 {
    font-size: 3.2rem;
    font-weight: 800;
    margin-bottom: 20px;
    color: #1b5e20;
    transition: color 0.4s ease;
  }
  .hero-text p {
    font-size: 1.2rem;
    color: #444;
    margin-bottom: 30px;
    transition: color 0.4s ease;
  }

  .hero-text .btn-primary {
    padding: 14px 36px;
    font-size: 1.1rem;
    border-radius: 40px;
    background: linear-gradient(90deg, #43a047, #2e7d32);
    border: none;
    font-weight: 600;
    transition: all 0.3s ease;
    color: #fff;
  }
  .hero-text .btn-primary:hover {
    transform: translateY(-3px) scale(1.02);
    box-shadow: 0 10px 25px rgba(67, 160, 71, 0.4);
  }

  .hero-img img {
    max-width: 85%;
    border-radius: 20px;
    box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    transition: transform 0.5s ease;
  }
  .hero-img img:hover {
    transform: scale(1.07);
  }

  /* Features */
  .features {
    padding: 90px 20px;
    transition: background 0.4s ease, color 0.4s ease;
  }
  .features h2 {
    text-align: center;
    margin-bottom: 60px;
    font-weight: 700;
    color: #1b5e20;
    font-size: 2.4rem;
    transition: color 0.4s ease;
  }
  .feature-card {
    background: #ffffff;
    border-radius: 18px;
    padding: 35px 25px;
    text-align: center;
    transition: transform 0.4s ease, box-shadow 0.4s ease, background 0.4s ease, color 0.4s ease;
    border: none;
    box-shadow: 0 8px 20px rgba(0,0,0,0.06);
  }
  .feature-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 14px 30px rgba(0, 0, 0, 0.12);
  }
  .feature-card div {
    font-size: 2.5rem;
  }
  .feature-card h4 {
    margin-top: 18px;
    font-size: 1.4rem;
    font-weight: 600;
    color: #2e7d32;
    transition: color 0.4s ease;
  }
  .feature-card p {
    color: #555;
    font-size: 0.96rem;
    margin-top: 12px;
    transition: color 0.4s ease;
  }

  /* CTA */
  .cta {
    padding: 90px 20px;
    text-align: center;
    background: linear-gradient(135deg, #2e7d32, #1b5e20);
    border-radius: 25px;
    color: #fff;
    margin: 70px auto;
    max-width: 1000px;
    box-shadow: 0 12px 30px rgba(0,0,0,0.15);
    transition: background 0.4s ease, color 0.4s ease;
  }
  .cta h2 {
    font-size: 2.4rem;
    margin-bottom: 20px;
    font-weight: 700;
  }
  .cta p {
    max-width: 650px;
    margin: 0 auto 30px;
    font-size: 1.05rem;
  }
  .cta .btn {
    padding: 14px 32px;
    border-radius: 40px;
    font-weight: bold;
    background: #fff;
    color: #2e7d32;
    transition: all 0.3s ease;
  }
  .cta .btn:hover {
    transform: translateY(-3px) scale(1.03);
    box-shadow: 0 10px 25px rgba(255,255,255,0.3);
  }

  /* Footer */
  footer {
    padding: 35px 20px;
    text-align: center;
    color: #555;
    font-size: 0.95rem;
    background: #e8f5e9;
    border-top: 1px solid #c8e6c9;
    transition: background 0.4s ease, color 0.4s ease;
  }

  /* DARK MODE STYLES */
  body.dark-mode {
    background: #121212;
    color: #e0e0e0;
  }
  body.dark-mode .hero {
    background: linear-gradient(135deg, #1e1e1e, #2d3d2d);
  }
  body.dark-mode .hero-text h1 {
    color: #a5d6a7;
  }
  body.dark-mode .hero-text p {
    color: #cfcfcf;
  }
  body.dark-mode .feature-card {
    background: #1f1f1f;
    color: #ddd;
    box-shadow: 0 8px 20px rgba(255,255,255,0.05);
  }
  body.dark-mode .feature-card h4 {
    color: #81c784;
  }
  body.dark-mode .feature-card p {
    color: #bbb;
  }
  body.dark-mode .cta {
    background: linear-gradient(135deg, #3a3a3a, #222);
    color: #fff;
  }
  body.dark-mode footer {
    background: #1c1c1c;
    color: #aaa;
    border-top: 1px solid #333;
  }

  /* Switch Toggle */
  .switch-container {
    position: fixed;
    bottom: 20px;
    right: 25px;
    z-index: 1000;
  }
  .switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 30px;
  }
  .switch input {
    opacity: 0;
    width: 0;
    height: 0;
  }
  .slider {
    position: absolute;
    cursor: pointer;
    top: 0; left: 0;
    right: 0; bottom: 0;
    background-color: #ccc;
    transition: .4s;
    border-radius: 34px;
  }
  .slider:before {
    position: absolute;
    content: "🌙";
    height: 22px; width: 22px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    border-radius: 50%;
    transition: .4s;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
  }
  input:checked + .slider {
    background-color: #2e7d32;
  }
  input:checked + .slider:before {
    transform: translateX(30px);
    content: "☀️";
  }
</style>

<!-- Theme Switch -->
<div class="switch-container">
  <label class="switch">
    <input type="checkbox" id="theme-toggle">
    <span class="slider"></span>
  </label>
</div>

<!-- Hero Section -->
<section class="hero container fade-in">
  <div class="row g-5 align-items-center">
    <div class="col-md-6 hero-img text-center fade-in" style="animation-delay:0.3s">
      <img src="{{ asset('images/slide5.jpg') }}" alt="EcoScan Sensor">
    </div>
    <div class="col-md-6 hero-text fade-in" style="animation-delay:0.6s">
      <h1>🌍 EcoScan - Smart Plastic Detection</h1>
      <p>Empowering communities and businesses to identify, track, and reduce single-use plastics with AI-powered detection and analytics.</p>
      <a href="#features" class="btn btn-primary">Learn More</a>
    </div>
  </div>
</section>

<!-- Features -->
<section id="features" class="features container">
  <h2 class="fade-in">Key Features</h2>
  <div class="row g-4">
    <div class="col-md-4 fade-in" style="animation-delay:0.3s">
      <div class="feature-card">
        <div>📊</div>
        <h4>Real-time Analytics</h4>
        <p>Track plastic vs non-plastic detections in real time with interactive dashboards.</p>
      </div>
    </div>
    <div class="col-md-4 fade-in" style="animation-delay:0.6s">
      <div class="feature-card">
        <div>🤖</div>
        <h4>AI-Powered Detection</h4>
        <p>Leverage advanced machine learning models for accurate material classification.</p>
      </div>
    </div>
    <div class="col-md-4 fade-in" style="animation-delay:0.9s">
      <div class="feature-card">
        <div>🔒</div>
        <h4>Secure & Scalable</h4>
        <p>Built with modern security and scalability in mind to handle growing data needs.</p>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="cta fade-in">
  <h2>Ready to Take Action?</h2>
  <p>Join the movement towards a plastic-free environment. Discover insights, generate reports, and help reduce single-use plastic waste.</p>
  @guest
    <a href="{{route('register')}}" class="btn">Get Started</a>
  @endguest
  @auth
    <a href="{{route('orderbtn')}}" class="btn">See Product Listing</a>
  @endauth
</section>

<!-- Footer -->
<footer>
  &copy; 2025 EcoScan. All rights reserved.
</footer>

<script>
  // Fade-in on scroll
  const fadeEls = document.querySelectorAll('.fade-in');
  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.style.animationPlayState = 'running';
      }
    });
  }, { threshold: 0.2 });

  fadeEls.forEach(el => {
    el.style.animationPlayState = 'paused';
    observer.observe(el);
  });

  // Theme Switch Script
  const toggleSwitch = document.getElementById('theme-toggle');
  const body = document.body;
  const navbar = document.getElementById("navbar"); // from base.blade.php

  // Load saved preference
  function loadTheme() {
    const theme = localStorage.getItem('theme');
    if (theme === 'dark') {
      body.classList.add('dark-mode');
      toggleSwitch.checked = true;
      if (navbar) {
        navbar.classList.remove("light-mode");
        navbar.classList.add("dark-mode");
      }
    } else {
      body.classList.remove('dark-mode');
      toggleSwitch.checked = false;
      if (navbar) {
        navbar.classList.remove("dark-mode");
        navbar.classList.add("light-mode");
      }
    }
  }

  // Run on page load
  loadTheme();

  // Toggle theme
  toggleSwitch.addEventListener('change', () => {
    if (toggleSwitch.checked) {
      localStorage.setItem('theme', 'dark');
    } else {
      localStorage.setItem('theme', 'light');
    }
    loadTheme();
  });

  // Sync across tabs/pages
  window.addEventListener('storage', (e) => {
    if (e.key === 'theme') {
      loadTheme();
    }
  });
</script>
