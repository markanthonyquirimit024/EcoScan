@include('layout.shopping-base')

<link rel="stylesheet" href="{{ asset('assets/register.css') }}">
<title>Register</title>

<div class="form-container">
  
  <!-- Left side (heading + logo) -->
  <div class="form-left">
    <h2>Register</h2>
    <img src="{{ asset('images/logo.png') }}" alt="EcoScan" class="register-logo" />
  </div>

  <!-- Right side (form) -->
  <div class="form-right">
    <x-success-message />
    <x-validation-errors />

    <form id="register-form" method="POST" action="{{ route('register.post') }}">
      @csrf

      <!-- Name fields -->
      <div class="row">
        <div class="col-md-6 mb-3">
          <input type="text" name="first_name" class="input-field" placeholder="First Name" value="{{ old('first_name') }}" required autofocus>
        </div>
        <div class="col-md-6 mb-3">
          <input type="text" name="last_name" class="input-field" placeholder="Last Name" value="{{ old('last_name') }}" required>
        </div>
      </div>

      <!-- Email -->
      <div class="mb-3">
        <input type="email" name="email" class="input-field" placeholder="Email" value="{{ old('email') }}" required>
      </div>

      <!-- Password -->
      <div class="input-group mb-3">
        <input type="password" id="password" name="password" class="input-field" placeholder="Password" required>
        <button type="button" class="toggle-password" data-target="password">👁️</button>
      </div>

      <!-- Password checklist -->
      <ul id="password-checklist">
        <li id="length">✖ At least 8 characters</li>
        <li id="lowercase">✖ At least one lowercase letter</li>
        <li id="uppercase">✖ At least one uppercase letter</li>
        <li id="number">✖ At least one number</li>
        <li id="special">✖ At least one special character (@$!%*?&)</li>
      </ul>

      <!-- Confirm Password -->
      <div class="input-group mb-3">
        <input type="password" id="password_confirmation" name="password_confirmation" class="input-field" placeholder="Confirm Password" required>
        <button type="button" class="toggle-password" data-target="password_confirmation">👁️</button>
      </div>

      <!-- Submit -->
      <button type="submit" class="register-btn">Register</button>

      <!-- Links -->
      <div class="links">
        <a href="{{ route('login') }}">Already registered? Log in here</a>
      </div>
    </form>
  </div>
</div>

<script>
  // Toggle password visibility
  document.querySelectorAll(".toggle-password").forEach(button => {
    button.addEventListener("click", function () {
      const targetId = this.getAttribute("data-target");
      const field = document.getElementById(targetId);

      if (field.type === "password") {
        field.type = "text";
        this.textContent = "🙈"; // Hide icon
      } else {
        field.type = "password";
        this.textContent = "👁️"; // Show icon
      }
    });
  });

  // Password checklist
  const checklist = {
    length: false,
    lowercase: false,
    uppercase: false,
    number: false,
    special: false
  };

  document.getElementById("password").addEventListener("input", function () {
    const value = this.value;
    checklist.length = value.length >= 8;
    checklist.lowercase = /[a-z]/.test(value);
    checklist.uppercase = /[A-Z]/.test(value);
    checklist.number = /\d/.test(value);
    checklist.special = /[@$!%*?&]/.test(value);

    for (let key in checklist) {
      updateChecklist(key, checklist[key]);
    }
  });

  function updateChecklist(id, isValid) {
    const item = document.getElementById(id);
    item.style.color = isValid ? "lime" : "red";
    item.textContent = `${isValid ? '✔' : '✖'} ${item.textContent.slice(2)}`;
  }

  // Form validation
  document.getElementById("register-form").addEventListener("submit", function (event) {
    const password = document.getElementById("password").value;
    const confirmPassword = document.getElementById("password_confirmation").value;
    const allPassed = Object.values(checklist).every(v => v);

    if (!allPassed) {
      alert("Password does not meet all the requirements.");
      event.preventDefault();
    } else if (password !== confirmPassword) {
      alert("Passwords do not match!");
      event.preventDefault();
    }
  });
</script>
