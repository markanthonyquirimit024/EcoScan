@include('layout.shopping-base')  
  
  <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">
  <link rel="stylesheet" href="{{ asset('assets/login.css') }}">
  <title>Login</title>

  <div class="login-container">
    <!-- Circular Logo -->
    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="login-logo">
    <!--Success Message-->
    <x-success-message/>

    <!-- Error Validation -->
    <x-validation-errors/>
    <h3 class="text-light">Login</h3>
     <p class="text-light ">Enter your credentials</p>
    <form id="login-form" method="POST" action="{{ route('login') }}">
      @csrf
      <input type="email" id="email" name="email" class="input-field" placeholder="Email" value="{{ old('email') }}" required autofocus>
      <div style="position: relative; width: 100%;">
    <input type="password" id="password" name="password" class="input-field" placeholder="Password" required>
    <button type="button" id="toggle-password">👁️</button>
  </div>

      <button type="submit" class="login-btn">LOGIN</button>
    </form>

    <div class="links">
      <a href="{{ route('password.request') }}">Forgot Password?</a><br>
    </div>
  </div>

  <script>
    let failedAttempts = 0;

    document.getElementById("login-form").addEventListener("submit", function(event) {
      const password = document.getElementById("password").value;
      const passwordError = document.getElementById("password-error");

      // Password validation regex
      const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

      if (!passwordPattern.test(password)) {
        passwordError.style.display = "block";
        failedAttempts++;

        if (failedAttempts >= 3) {
          // Redirect to captcha page after 3 failed attempts
          alert("Too many failed attempts! Redirecting to captcha verification.");
          window.location.href = "{{ route('captcha.page') }}";
        }

        event.preventDefault(); // Stop form submission
      } else {
        passwordError.style.display = "none";
        failedAttempts = 0; // Reset counter on success
      }
    });

  document.getElementById("toggle-password").addEventListener("click", function() {
    let passwordField = document.getElementById("password");
    if (passwordField.type === "password") {
      passwordField.type = "text";
      this.textContent = "🙈"; // Change to hide icon
    } else {
      passwordField.type = "password";
      this.textContent = "👁️"; // Change back to show icon
    }
  });
</script>

