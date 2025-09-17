<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>

<style>
  #orderbtn:hover
  {
  background: #1c2414;
  border-radius: 5px;
  }
  .logo{
      border-radius: 50%;
      object-fit: cover;
      box-shadow: 0px 0px 10px rgba(255, 255, 255, 0.5);
  }
  body {
        font-family: 'Inter', sans-serif;
        margin: 0;
        color: #fff;
        background: linear-gradient(135deg, #0d0d0d, #1a3d1f);
    }
    .nav-item:hover{
        background: rgba(255, 255, 255, 0.28);
        border-radius: 5px;
      
    }
    #logout-btn{
        background-color: red;
    }
    #logout-btn:hover
    {
        background-color: black;
    }

</style>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top" style="background: radial-gradient(circle, rgba(114, 114, 114, 1) 0%, rgba(9, 121, 54, 1) 92%);" data-bs-theme="dark">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="{{route('home')}}">
    <img src="{{ asset('images/logo.png') }}" alt="EcoScan" width="40" height="36" class="logo">
    EcoScan</a>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 text-center justify-content-center">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="{{route('home')}}">Home</a>
        </li>
        <li class="nav-item" id="orderbtn">
          <a class="nav-link active btn btn-success text-light" style="background: rgba(255,255,255,0.08);" href="{{route('orderbtn')}}">Order Now</a>
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
                <a class="nav-link active mx-3" href="#">
                    {{ Auth::user()->first_name }}
                </a>
            </li>
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link btn btn-link text-white" id="logout-btn" onclick="return confirm('Are you sure you want to logout this account?')" style="text-decoration: none;">
                        Logout
                    </button>
                </form>
            </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>
</body>
</html>