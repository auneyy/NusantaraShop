<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NusantaraShop</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f8f9fa;
    }

    .navbar {
      background-color: #fff !important;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      padding: 1rem 0;
    }

    .logonusantara {
      height: 50px;
      width: auto;
      margin-right: 20px;
    }

    .navbar-nav .nav-link {
      color: #422D1C !important;
      font-weight: 500;
      margin: 0 10px;
      transition: all 0.3s ease;
    }

    .navbar-nav .nav-link:hover,
    .navbar-nav .nav-link.active {
      color: #8B4513 !important;
      font-weight: 600;
    }

    .navbar-icons {
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .navbar-icons a {
      color: #422D1C;
      font-size: 1.2rem;
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .navbar-icons a:hover {
      color: #8B4513;
    }

    .btn-auth {
      background-color: #422D1C;
      border-color: #422D1C;
      color: white;
      padding: 0.375rem 1rem;
      border-radius: 5px;
      text-decoration: none;
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .btn-auth:hover {
      background-color: #8B4513;
      border-color: #8B4513;
      color: white;
    }

    .btn-auth-outline {
      background-color: transparent;
      border: 2px solid #422D1C;
      color: #422D1C;
      padding: 0.375rem 1rem;
      border-radius: 5px;
      text-decoration: none;
      font-weight: 500;
      transition: all 0.3s ease;
      margin-left: 10px;
    }

    .btn-auth-outline:hover {
      background-color: #422D1C;
      color: white;
    }

    .product-card img {
      height: 300px;
      object-fit: cover;
    }

    .footer {
      background-color: #422D1C;
      color: white;
      padding: 2rem 0;
    }

    .footer .text-muted {
      color: #cccccc !important;
    }

    .footer .text-muted a {
      color: #dddddd !important;
      transition: color 0.3s ease;
    }

    .footer .text-muted a:hover {
      color: #ffffff !important;
    }

    .footer h5, .footer h6 {
      color: #ffffff;
      font-weight: 600;
    }

    @media (max-width: 991px) {
      .navbar-icons {
        margin-top: 1rem;
        justify-content: center;
      }
    }
  </style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mencegah back button setelah logout
    if (window.history && window.history.pushState) {
        window.addEventListener('load', function() {
            window.history.pushState({}, '', window.location.href);
        });

        window.addEventListener('popstate', function() {
            window.history.pushState({}, '', window.location.href);
        });
    }

    // Deteksi jika user mencoba kembali setelah logout
    window.addEventListener('pageshow', function(event) {
        if (event.persisted || 
            (window.performance && window.performance.getEntriesByType("navigation")[0].type === "back_forward")) {
            
            // Cek apakah masih ada session dengan AJAX call
            fetch('/check-auth', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (!data.authenticated) {
                    window.location.replace('/login');
                }
            })
            .catch(() => {
                window.location.replace('/login');
            });
        }
    });

    // Mencegah cache pada halaman sensitive
    if (window.location.pathname.includes('/home') || 
        window.location.pathname.includes('/cart') ||
        window.location.pathname.includes('/profile')) {
        
        window.addEventListener('beforeunload', function() {
            // Clear any cached data
            if ('caches' in window) {
                caches.keys().then(function(names) {
                    names.forEach(function(name) {
                        caches.delete(name);
                    });
                });
            }
        });
    }
});
</script>

</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
      <a href="{{ auth()->check() ? url('/home') : url('/') }}"><img src="{{ asset('storage/product_images/Nusantara.png') }}" alt="logo" class="logonusantara"></a>

      <!-- Tombol hamburger -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Isi navbar -->
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto">
          @auth
          <li class="nav-item">
            <a class="nav-link {{ Request::is('home') ? 'active' : '' }}" href="{{ url('/home') }}">Beranda</a>
          </li>
          @else
          <li class="nav-item">
            <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{ url('/') }}">Beranda</a>
          </li>
          @endauth
          <li class="nav-item">
            <a class="nav-link {{ Request::is('products') ? 'active' : '' }}" href="{{ url('/products') }}">Koleksi</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('promo') ? 'active' : '' }}" href="{{ url('/promo') }}">Promo</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('contact') ? 'active' : '' }}" href="{{ url('/contact') }}">Kontak</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('help') ? 'active' : '' }}" href="{{ url('/help') }}">Bantuan</a>
          </li>
        </ul>

        <div class="navbar-icons">
          @auth
          <!-- User sudah login - tampilkan dropdown user dan logout -->
          <div class="dropdown">
            <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-person-circle"></i>
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">{{ Auth::user()->name }}</a></li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <form action="{{ route('logout') }}" method="POST">
                  @csrf
                  <button class="dropdown-item" type="submit">Logout</button>
                </form>
              </li>
            </ul>
          </div>
          
          <a href="{{ url('/cart') }}">
            <i class="bi bi-bag"></i>
          </a>
          
          <a href="#" data-bs-toggle="modal" data-bs-target="#searchModal">
            <i class="bi bi-search"></i>
          </a>
          @else
          <!-- User belum login - tampilkan tombol masuk dan daftar -->
          @endauth
        </div>
      </div>
    </div>
  </nav>

  <!-- Search Modal -->
  <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="searchModalLabel">Cari Produk</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="mb-3">
              <input type="text" class="form-control" placeholder="Cari produk batik...">
            </div>
            <button type="submit" class="btn btn-primary">Cari</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <main>
    @yield('content')
  </main>

  <footer class="footer text-center">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <h5 class="mb-3">NusantaraShop</h5>
          <p class="text-muted">Toko batik terpercaya dengan koleksi pilihan terbaik untuk kebutuhan fashion Anda.</p>
        </div>
        <div class="col-md-4">
          <h6 class="mb-3">Menu</h6>
          <ul class="list-unstyled">
            <li><a href="{{ auth()->check() ? url('/home') : url('/') }}" class="text-muted text-decoration-none">Beranda</a></li>
            <li><a href="{{ url('/products') }}" class="text-muted text-decoration-none">Koleksi</a></li>
            <li><a href="{{ url('/contact') }}" class="text-muted text-decoration-none">Kontak</a></li>
          </ul>
        </div>
        <div class="col-md-4">
          <h6 class="mb-3">Kontak</h6>
          <p class="text-muted mb-1">Email: info@nusantarashop.com</p>
          <p class="text-muted mb-1">Telepon: (021) 123-4567</p>
          <p class="text-muted">Alamat: Jakarta, Indonesia</p>
        </div>
      </div>
      <hr class="my-4">
      <p class="mb-0 text-muted">© 2025 NusantaraShop. All rights reserved.</p>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>