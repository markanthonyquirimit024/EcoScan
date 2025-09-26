@include('layout.shopping-base')

<link rel="stylesheet" href="{{ asset('assets/login.css') }}">
<link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
<title>Reset Password</title>

<div class="login-container mt-5">
    <!-- Circular Logo -->
    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="login-logo">

    <!-- Success Message -->
    <x-success-message />

    <!-- Error Validation -->
    <x-validation-errors />

    <h3 class="text-light my-3">Reset Password</h3>
    <p class="text-light">Enter your new password below.</p>

    <!-- Reset Password Form -->
    <form id="reset-password-form" method="POST" action="{{ route('password.update') }}">
        @csrf

        <!-- Hidden fields required by Laravel -->
        <input type="hidden" name="token" value="{{ request()->route('token') }}">
        <input type="hidden" name="email" value="{{ request()->email }}">

        <!-- New Password -->
        <label class="form-label text-light" for="password">New Password</label>
        <div class="position-relative mb-3">
            <input type="password" id="password" name="password" class="form-control pe-5" required>
            <span class="toggle-password" data-target="password">👁️</span>
        </div>

        <!-- Password Checklist -->
        <ul id="password-checklist" class="mt-2 small text-muted">
            <li id="length">✖ At least 8 characters</li>
            <li id="lowercase">✖ At least one lowercase letter</li>
            <li id="uppercase">✖ At least one uppercase letter</li>
            <li id="number">✖ At least one number</li>
            <li id="special">✖ At least one special character (@$!%*?&)</li>
        </ul>

        <!-- Confirm Password -->
        <label class="form-label text-light mt-3" for="password_confirmation">Confirm New Password</label>
        <div class="position-relative mb-3">
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control pe-5" required>
            <span class="toggle-password" data-target="password_confirmation">👁️</span>
        </div>

        <button type="submit" class="btn btn-success w-100 mt-3">
            🔑 Reset Password
        </button>
    </form>

    <div class="links mt-3">
        <a href="{{ route('login') }}">← Back to Login</a>
    </div>
</div>

<style>
.toggle-password {
    position: absolute;
    top: 50%;
    right: 12px;
    transform: translateY(-50%);
    cursor: pointer;
    user-select: none;
    font-size: 1.1rem;
}
</style>

<script>
document.querySelectorAll(".toggle-password").forEach(icon => {
    icon.addEventListener("click", function () {
        const field = document.getElementById(this.dataset.target);
        if (field.type === "password") {
            field.type = "text";
            this.textContent = "🙈";
        } else {
            field.type = "password";
            this.textContent = "👁️";
        }
    });
});

const passwordInput = document.getElementById('password');
const requirements = {
    length: false,
    lowercase: false,
    uppercase: false,
    number: false,
    special: false
};

if(passwordInput){
    passwordInput.addEventListener('input', function () {
        const value = passwordInput.value;

        requirements.length = value.length >= 8;
        requirements.lowercase = /[a-z]/.test(value);
        requirements.uppercase = /[A-Z]/.test(value);
        requirements.number = /[0-9]/.test(value);
        requirements.special = /[@$!%*?&]/.test(value);

        for (const [rule, passed] of Object.entries(requirements)) {
            const item = document.getElementById(rule);
            item.style.color = passed ? "green" : "red";
            item.textContent = (passed ? "✔ " : "✖ ") + item.textContent.replace(/✔ |✖ /, "");
        }
    });
}

document.getElementById("reset-password-form").addEventListener("submit", function (event) {
    const password = document.getElementById("password").value;
    const confirmPassword = document.getElementById("password_confirmation").value;

    if (Object.values(requirements).includes(false)) {
        alert("⚠ Password does not meet all the requirements.");
        event.preventDefault();
    } else if (password !== confirmPassword) {
        alert("⚠ Passwords do not match!");
        event.preventDefault();
    }
});
</script>
