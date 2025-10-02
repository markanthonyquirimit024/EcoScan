@extends('layout.shopping-base')

<title>My Profile</title>
<link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

<div class="container py-5">
    <h2 class="mb-4 my-5 text-center">⚙️ My Profile</h2>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm p-4 bg-dark text-light">
                <!-- Profile Overview -->
                <div class="d-flex align-items-center mb-4">
                    <img src="{{ asset('images/person.png') }}" alt="Profile Picture" 
                        class="rounded-circle me-3" width="120" height="120">
                    <div>
                        <h4 class="mb-1">{{ Auth::user()->first_name }}</h4>
                        <p class="mb-0 text-light">Role: {{ Auth::user()->utype }}</p>
                        <p class="small text-light">Member since: {{ Auth::user()->created_at->format('m-d-Y') }}</p>
                    </div>
                </div>

                <!-- Tabs -->
                <ul class="nav nav-tabs mb-4" id="profileTabs" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button">👤 Profile Info</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#security" type="button">🔒 Security</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link text-danger" id="danger-tab" data-bs-toggle="tab" data-bs-target="#danger" type="button">⚠️ Danger Zone</button>
                    </li>
                </ul>

                <div class="tab-content">
                    <!-- Profile Info -->
                    <div class="tab-pane fade show active" id="profile">
                        <form id="edit-profile-form" action="{{ route('profile.edit') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">First Name</label>
                                    <input type="text" name="first_name" class="form-control" value="{{ Auth::user()->first_name }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" name="last_name" class="form-control" value="{{ Auth::user()->last_name }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}">
                            </div>
                            <button type="submit" class="btn btn-success">💾 Save Changes</button>
                        </form>
                    </div>

                    <!-- Security -->
                    <div class="tab-pane fade" id="security">
                        <form id="change-password-form" action="{{ route('profile.change_password') }}" method="POST">
                            @csrf

                            <!-- Current Password -->
                            <label class="form-label" for="current_password">Current Password</label>
                            <div class="position-relative mb-3">
                                <input type="password" id="current_password" name="current_password" class="form-control pe-5" required>
                                <span class="toggle-password" data-target="current_password">👁️</span>
                            </div>

                            <!-- New Password -->
                            <label class="form-label" for="password">New Password</label>
                            <div class="position-relative mb-3">
                                <input type="password" id="password" name="password" class="form-control pe-5" required>
                                <span class="toggle-password" data-target="password">👁️</span>
                            </div>

                            <!-- Password Checklist -->
                            <ul id="password-checklist" class="mt-2 small text-light">
                                <li id="length">✖ At least 8 characters</li>
                                <li id="lowercase">✖ At least one lowercase letter</li>
                                <li id="uppercase">✖ At least one uppercase letter</li>
                                <li id="number">✖ At least one number</li>
                                <li id="special">✖ At least one special character (@$!%*?&)</li>
                            </ul>

                            <!-- Confirm Password -->
                            <label class="form-label mt-3" for="password_confirmation">Confirm New Password</label>
                            <div class="position-relative mb-3">
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control pe-5" required>
                                <span class="toggle-password" data-target="password_confirmation">👁️</span>
                            </div>

                            <button type="submit" class="btn btn-success w-100 mt-3">
                                🔑 Update Password
                            </button>
                        </form>
                    </div>

                    <!-- Danger Zone -->
                    <div class="tab-pane fade" id="danger">
                        <form id="delete-account-form" action="{{ route('profile.destroy') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Enter Password" required>
                            </div>
                            <button type="submit" class="btn btn-danger">🗑️ Delete Account</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Toggle password visibility
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

// Password validation
const passwordInput = document.getElementById('password');
const requirements = { length: false, lowercase: false, uppercase: false, number: false, special: false };

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
            item.style.color = passed ? "lightgreen" : "red";
            item.textContent = (passed ? "✔ " : "✖ ") + item.textContent.replace(/✔ |✖ /, "");
        }
    });
}

// Profile Edit Confirmation
document.getElementById("edit-profile-form").addEventListener("submit", function(e){
    e.preventDefault();
    Swal.fire({
        title: 'Save Profile Changes?',
        text: "Do you want to update your profile info?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, save it!',
        cancelButtonText: 'Cancel'
    }).then(result => {
        if(result.isConfirmed) this.submit();
    });
});

// Change Password Validation + SweetAlert
document.getElementById("change-password-form").addEventListener("submit", function (event) {
    event.preventDefault();
    const password = document.getElementById("password").value;
    const confirmPassword = document.getElementById("password_confirmation").value;

    if (Object.values(requirements).includes(false)) {
        Swal.fire("⚠ Invalid Password", "Password does not meet all the requirements.", "error");
    } else if (password !== confirmPassword) {
        Swal.fire("⚠ Password Mismatch", "Passwords do not match!", "error");
    } else {
        Swal.fire({
            title: 'Change Password?',
            text: "Are you sure you want to update your password?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, update it!'
        }).then(result => {
            if(result.isConfirmed) this.submit();
        });
    }
});

// Delete Account Confirmation
document.getElementById("delete-account-form").addEventListener("submit", function(e){
    e.preventDefault();
    Swal.fire({
        title: 'Delete Account?',
        text: "This action cannot be undone. Are you sure?",
        icon: 'error',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonText: 'Cancel',
        confirmButtonText: 'Yes, delete it!'
    }).then(result => {
        if(result.isConfirmed) this.submit();
    });
});

    setTimeout(() => {
        let alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            let bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 3000);
</script>
