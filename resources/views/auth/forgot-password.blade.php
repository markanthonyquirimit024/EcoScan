@include('layout.shopping-base')

<link rel="stylesheet" href="{{ asset('assets/login.css') }}">
<link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
<title>Forgot Password</title>

<div class="login-container">
    <!-- Circular Logo -->
    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="login-logo">

    <!-- Success Message -->
    <x-success-message />

    <!-- Error Validation -->
    <x-validation-errors />

    <h3 class="text-light my-3">Forgot Password</h3>
    <p class="text-light">Enter your email to receive a password reset link.</p>

    <!-- Forgot Password Form -->
    <form id="forgot-password-form" method="POST" action="{{ route('password-email') }}">
        @csrf
        <input type="email" id="email" name="email" class="input-field" placeholder="Email" value="{{ old('email') }}" required autofocus>
        <button type="submit" class="login-btn mt-3">Send Password Reset Link</button>
    </form>

    <div class="links mt-3">
        <a href="{{ route('login') }}">← Back to Login</a>
    </div>
</div>
