<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Inter', sans-serif;
      margin: 0;
      color: #fff;
      background: linear-gradient(135deg, #0d0d0d, #1a3d1f);
    }

    /* Navbar base */
    .navbar {
      backdrop-filter: blur(12px);
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      padding: 0.8rem 1rem;
      transition: background 0.3s, color 0.3s;
    }

    /* LIGHT / DARK navbar classes (applied by JS or default) */
    .navbar.dark-mode {
      background: #000 !important;
    }
    .navbar.dark-mode .navbar-brand,
    .navbar.dark-mode .nav-link {
      color: #fff !important;
    }

    .navbar.light-mode {
      background: #fff !important;
    }
    .navbar.light-mode .navbar-brand,
    .navbar.light-mode .nav-link {
      color: #000 !important;
    }

    .navbar-brand {
      font-weight: 700;
      font-size: 1.3rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .navbar-brand img {
      border-radius: 50%;
      object-fit: cover;
      width: 40px;
      height: 40px;
      box-shadow: 0px 0px 10px rgba(255, 255, 255, 0.4);
    }

    /* IMPORTANT: use gap on the flex container instead of margins on links.
       gap keeps spacing between items without affecting the container width. */
    .navbar-nav {
      display: flex;
      align-items: center;
      gap: 0.9rem;            /* <-- change spacing here */
    }

    /* On small screens the nav becomes vertical — reduce gap to look nicer */
    @media (max-width: 991.98px) {
      .navbar-nav {
        flex-direction: column;
        gap: 0.35rem;
      }
      /* tighten up link padding on collapsed mobile menu */
      .navbar-nav .nav-link {
        padding: 0.45rem 0.6rem;
      }
    }

    /* Nav link styling */
    .nav-link {
      font-weight: 500;
      transition: 0.3s;
      border-radius: 6px;
      padding: 0.5rem 0.9rem; /* use internal padding (not margin) */
      color: inherit;
      display: inline-flex;
      align-items: center;
      gap: .4rem;
    }
    .nav-link:hover {
      background: rgba(255, 255, 255, 0.06);
      text-decoration: none;
    }

    /* Logout button (keeps its own box, doesn't affect layout) */
    #logout-btn {
      background-color: red;
      border-radius: 6px;
      padding: 0.4rem 1rem;
      color: #fff;
      border: none;
      transition: 0.3s;
      display: inline-block;
    }
    #logout-btn:hover {
      background-color: black;
    }

    /* If you ever try margin again, use this safe method:
       .navbar-nav .nav-item:not(:last-child) { margin-right: 0.9rem; }
       but gap is preferred. */
  </style>
</head>
<body>

  <nav class="navbar navbar-expand-lg fixed-top dark-mode" id="navbar">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{route('home')}}">
        <img src="{{ asset('images/logo.png') }}" alt="EcoScan">
        EcoScan
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
              aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarContent">
        <!-- Links -->
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
          <li class="nav-item">
            <a class="nav-link" href="{{route('home')}}">Home</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="{{route('orderbtn')}}">Shop</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>

          @guest
            <li class="nav-item">
              <a class="nav-link" href="{{ route('login') }}">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('register') }}">Register</a>
            </li>
          @endguest

          @auth
            <li class="nav-item">
              <a class="nav-link" href="#">
                <i class="bi bi-person-circle"></i> {{ Auth::user()->first_name }}
              </a>
            </li>
            <li class="nav-item">
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" id="logout-btn" onclick="return confirm('Are you sure you want to logout this account?')">
                  Logout
                </button>
              </form>
            </li>
          @endauth
        </ul>
      </div>
    </div>
  </nav>

  

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- THEME HANDLER (runs after DOM ready) -->
  <script>
    (function () {
      function applyTheme(theme) {
        if (theme === 'dark') {
          document.body.classList.add('dark-mode');
        } else {
          document.body.classList.remove('dark-mode');
        }

        const navbar = document.getElementById('navbar');
        if (!navbar) return;
        if (theme === 'dark') {
          navbar.classList.remove('light-mode');
          navbar.classList.add('dark-mode');
        } else {
          navbar.classList.remove('dark-mode');
          navbar.classList.add('light-mode');
        }
      }

      window.setTheme = function (theme) {
        if (theme !== 'dark' && theme !== 'light') return;
        localStorage.setItem('theme', theme);
        applyTheme(theme);
        window.dispatchEvent(new CustomEvent('theme-changed', { detail: theme }));
      };

      document.addEventListener('DOMContentLoaded', function () {
        const saved = localStorage.getItem('theme') || 'light';
        applyTheme(saved);
      });

      window.addEventListener('storage', function (e) {
        if (e.key === 'theme') {
          applyTheme(e.newValue || 'light');
        }
      });

      window.addEventListener('theme-changed', function (e) {
        applyTheme(e.detail);
      });
    })();
  </script>
</body>
</html>
