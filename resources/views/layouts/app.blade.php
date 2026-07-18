<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CravePath')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
     <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }

         :root {
            --primary: #e85d04;
            --primary-dark: #c94e03;
            --secondary: #ffd60a;
            --dark: #1a1a2e;
            --light-bg: #fff8f0;
            --card-shadow: 0 4px 20px rgba(232, 93, 4, 0.08);
        }

        body { background-color: var(--light-bg);
            color: #333;
         }
        .navbar-brand {
             font-weight: bold; 
             font-family: 'Playfair Display', serif;
               font-size: 1.6rem;
              color: var(--primary) !important;
              letter-spacing: -0.5px;
            
        }

        .navbar {
            background: white !important;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            padding: 0.8rem 0;
        }

        .nav-link {
            color: #555 !important;
            font-weight: 500;
            font-size: 0.9rem;
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .nav-link:hover {
            color: var(--primary) !important;
            background: rgba(232, 93, 4, 0.06);
        }

        .btn-nav-signup {
            background: var(--primary);
            color: white !important;
            border-radius: 25px;
            padding: 0.4rem 1.2rem !important;
            font-weight: 600;
        }

        .btn-nav-signup:hover {
            background: var(--primary-dark);
            color: white !important;
        }


           /* cards */
         .spot-card {
            border: none;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            transition: all 0.25s ease;
            overflow: hidden;
         }

        .spot-card:hover { transform: 
            translateY(-3px); 
            box-shadow: 0 4px 12px rgba(0,0,0,0.1); 
            transition: 0.2s;
        }

         .spot-card .card-img-top {
            height: 190px;
            object-fit: cover;
        }

        .spot-card .card-body { padding: 1.2rem; }

        .spot-card .card-title {
            font-weight: 600;
            font-size: 1rem;
            color: var(--dark);
        }

        /* buttons */

        .btn-primary-cp {
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 25px;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-primary-cp:hover {
            background: var(--primary-dark);
            color: white;
            transform: translateY(-1px);
        }

         .btn-outline-cp {
            border: 2px solid var(--primary);
            color: var(--primary);
            border-radius: 25px;
            padding: 0.4rem 1.2rem;
            font-weight: 600;
            transition: all 0.2s;
            background: transparent;
        }

        .btn-outline-cp:hover {
            background: var(--primary);
            color: white;
        }


        /* Badges */
        .badge-budget { background: #d4edda; color: #155724; }
        .badge-mid { background: #fff3cd; color: #856404; }
        .badge-premium { background: #f8d7da; color: #721c24; }

          /* Page header */
        .page-header {
            background: linear-gradient(135deg, var(--primary) 0%, #ff8c42 100%);
            color: white;
            padding: 2.5rem 0;
            margin-bottom: 2rem;
            border-radius: 0 0 20px 20px;
        }

        .page-header h2 { font-family: 'Playfair Display', serif; }

         /* Weather card */
        .weather-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 16px;
            padding: 1.5rem;
        }

          /* Search bar */
        .search-bar {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: var(--card-shadow);
            margin-bottom: 2rem;
        }

        .search-bar .form-control,
        .search-bar .form-select {
            border-radius: 10px;
            border: 1.5px solid #eee;
            padding: 0.6rem 1rem;
            font-size: 0.9rem;
        }

        .search-bar .form-control:focus,
        .search-bar .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(232,93,4,0.1);
        }

        /* Alerts */
        .alert { border-radius: 12px; border: none; }
        .alert-success { background: #d4edda; color: #155724; }
        .alert-danger { background: #f8d7da; color: #721c24; }
        .alert-info { background: #d1ecf1; color: #0c5460; }

        /* Footer */
        footer {
            background: white;
            border-top: 1px solid #f0e6dc;
            padding: 2rem 0;
            margin-top: 4rem;
            color: #888;
            font-size: 0.85rem;
        }

        /* AJAX loader */
        #ajax-loading {
            display: none;
            text-align: center;
            padding: 2rem;
            color: var(--primary);
        }

        /* Table */
        .table { border-radius: 12px; overflow: hidden; }
        .table thead th { background: var(--primary); color: white; border: none; font-weight: 600; }
        .table tbody tr:hover { background: rgba(232,93,4,0.03); }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">🍲 CravePath</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                 <li class="nav-item"><a class="nav-link" href="{{ route('home') }}"><i class="bi bi-house"></i> Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('spots.index') }}"><i class="bi bi-compass"></i> Explore</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('feed') }}"><i class="bi bi-newspaper"></i> Feed</a></li>


                @auth
                    @if(auth()->user()->role === 'seller')
                        <li class="nav-item"><a class="nav-link" href="{{ route('seller.dashboard') }}"><i class="bi bi-shop"></i> My Spots</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('seller.reviews.index') }}"><i class="bi bi-chat-dots"></i> Reviews</a></li>
                    @elseif(auth()->user()->role === 'admin')
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="bi bi-gear"></i> Admin</a></li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('saved.index') }}"><i class="bi bi-heart"></i> Saved</a></li>
                    @endif

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-person"></i> {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" style="border-radius: 12px;">
                              <li class="px-3 py-2">
                                <small class="text-muted">{{ auth()->user()->role }}</small>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right"></i> Logout
                                 </button>

                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    <li class="nav-item"><a class="btn btn-warning btn-sm ms-2" href="{{ route('register') }}">Sign Up</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<div class="container mb-5">
    @if(session('success'))
        <div class="alert alert-success"><i class="bi bi-check-circle"></i> {{ session('success') }}
       <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger"><i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
           <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
       </div>
    @endif

    @yield('content')
</div>

<footer class="bg-white border-top py-4 text-center text-muted">
    <div class="container">
        <p class="mb-1">🍲 <strong>CravePath</strong> — Discover great food spots near you.</p>
        <small>&copy; {{ date('Y') }} CravePath — Discover great food spots near you.</small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Global photo modal -->
<div class="modal fade" id="photoModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body p-0 text-center">
                <img src="" alt="photo" id="photoModalImg" class="img-fluid w-100" style="object-fit:contain;">
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('click', function (e) {
        const target = e.target;
        if (target && target.classList && target.classList.contains('spot-photo-thumb')) {
                const src = target.dataset.full || target.src;
                const img = document.getElementById('photoModalImg');
                img.src = src;
                const modalEl = document.getElementById('photoModal');
                const bs = new bootstrap.Modal(modalEl);
                bs.show();
        }
});
// weather refresh handler
document.addEventListener('click', function (e) {
    const target = e.target;
    if (target && target.classList && target.classList.contains('refresh-weather')) {
        const spotId = target.dataset.spotId;
        if (! spotId) return;
        target.disabled = true;
        target.innerText = 'Refreshing...';
        fetch(`/spots/${spotId}/weather`)
            .then(res => {
                if (!res.ok) throw new Error('No weather');
                return res.json();
            })
            .then(data => {
                const block = document.querySelector(`.weather-block[data-spot-id="${spotId}"]`);
                if (!block) return;
                const tempEl = block.querySelector('.weather-temp');
                const descEl = block.querySelector('.weather-desc');
                const iconEl = block.querySelector('.weather-icon');
                const humEl = block.querySelector('.weather-humidity');
                const windEl = block.querySelector('.weather-wind');

                if (tempEl) tempEl.innerText = data.temperature + '°C';
                if (descEl) descEl.innerText = data.description;
                if (iconEl) iconEl.src = `https://openweathermap.org/img/wn/${data.icon}@2x.png`;
                if (humEl) humEl.innerText = data.humidity + '%';
                if (windEl) windEl.innerText = data.wind + ' km/h';
            })
            .catch(() => {
                alert('Unable to fetch weather right now.');
            })
            .finally(() => {
                target.disabled = false;
                target.innerText = 'Refresh';
            });
    }
});
</script>

@yield('scripts')
</body>
</html>