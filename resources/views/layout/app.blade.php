<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>NusantaraShop</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  
  <style>
     body {
      font-family: 'Manrope', sans-serif;
      background-color: #fff;
    }

    .navbar {
      background-color: #fff !important;
      box-shadow: 0 2px 4px rgba(0,0,0,0.2);
      padding: 1rem 0;
      z-index: 1000;
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
      position: relative;
    }

    .navbar-nav .nav-link::after {
      content: '';
      position: absolute;
      left: 0;
      bottom: 0;
      width: 0;
      height: 2px;
      background-color: #8B4513;
      transition: width 0.3s ease-in-out;
    }

    .navbar-nav .nav-link:hover::after {
      width: 100%;
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

    .mega-menu {
      position: absolute;
      left: 50%;
      transform: translateX(-50%);
      top: 100%;
      z-index: 1000;
      width: 250px;
      background-color: #ffffff;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
      padding: 1rem 0;
      opacity: 0;
      visibility: hidden;
      transition: all 0.3s ease-in-out;
    }

    .mega-menu-wrapper:hover .mega-menu {
      opacity: 1;
      visibility: visible;
    }

    .category-list-5 {
      display: flex;
      flex-direction: column;
    }

    .category-list-5 .category-item {
      font-size: 1rem;
      font-weight: 500;
      padding: 0.75rem 1.5rem;
      color: #422D1C;
      text-decoration: none;
      transition: background-color 0.2s ease-in-out;
      position: relative;
      overflow: hidden;
    }

    .category-list-5 .category-item:hover {
      background-color: #f5f5f5;
    }

    .category-list-5 .category-item::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 4px;
      height: 100%;
      background-color: #8c7b6c;
      transform: translateX(-100%);
      transition: transform 0.3s ease-in-out;
    }

    .category-list-5 .category-item:hover::before {
      transform: translateX(0);
    }

    .view-more-container {
      padding: 1rem 1.5rem 0;
      border-top: 1px solid #eeeeee;
      margin-top: 1rem;
    }

    .view-more-link {
      display: flex;
      align-items: center;
      justify-content: space-between;
      text-decoration: none;
      color: #8c7b6c;
      font-weight: 600;
    }

    /* Modern Footer Styles */
    .footer {
      background-color: #ffffff;
      color: #422D1C;
      padding: 3rem 0 1.5rem;
      box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.08);
      border-top: 1px solid #f0f0f0;
    }

    .footer h5 {
      color: #422D1C;
      font-weight: 700;
      font-size: 1.5rem;
      margin-bottom: 1.5rem;
      position: relative;
    }

    .footer h5::after {
      content: '';
      position: absolute;
      left: 0;
      bottom: -8px;
      width: 50px;
      height: 3px;
      background: linear-gradient(90deg, #8B4513, #422D1C);
      border-radius: 2px;
    }

    .footer h6 {
      color: #422D1C;
      font-weight: 600;
      font-size: 1.1rem;
      margin-bottom: 1rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .footer p {
      color: #6b7280;
      line-height: 1.6;
      margin-bottom: 0.5rem;
    }

    .footer .text-muted {
      color: #6b7280 !important;
    }

    .footer .text-muted a {
      color: #6b7280 !important;
      transition: all 0.3s ease;
      text-decoration: none;
      position: relative;
    }

    .footer .text-muted a:hover {
      color: #8B4513 !important;
      transform: translateX(5px);
    }

    .footer .text-muted a::before {
      content: '';
      position: absolute;
      left: -15px;
      top: 50%;
      transform: translateY(-50%);
      width: 8px;
      height: 1px;
      background-color: #8B4513;
      opacity: 0;
      transition: all 0.3s ease;
    }

    .footer .text-muted a:hover::before {
      opacity: 1;
      left: -12px;
    }

    .footer ul {
      list-style: none;
      padding: 0;
    }

    .footer ul li {
      margin-bottom: 0.75rem;
      padding-left: 0;
    }

    .footer-divider {
      border: none;
      height: 1px;
      background: linear-gradient(90deg, transparent, #e5e7eb, transparent);
      margin: 2.5rem 0 1.5rem;
    }

    .footer-bottom {
      text-align: center;
      color: #9ca3af;
      font-size: 0.875rem;
      padding-top: 1rem;
      border-top: 1px solid #f3f4f6;
    }

    .footer-icon {
      display: inline-block;
      width: 20px;
      height: 20px;
      margin-right: 10px;
      opacity: 0.7;
      transition: opacity 0.3s ease;
    }

    .footer .text-muted a:hover .footer-icon {
      opacity: 1;
    }

    /* Contact Info Styling */
    .contact-info {
      display: flex;
      align-items: flex-start;
      margin-bottom: 1rem;
    }

    .contact-info i {
      color: #8B4513;
      margin-right: 10px;
      margin-top: 2px;
      font-size: 1rem;
    }

    .contact-info .contact-text {
      color: #6b7280;
      margin: 0;
      line-height: 1.6;
    }

    /* Responsive */
    @media (max-width: 991px) {
      .navbar-icons {
        margin-top: 1rem;
        justify-content: center;
      }
      
      .footer {
        padding: 2rem 0 1rem;
        margin-top: 2rem;
      }
      
      .footer .col-md-4 {
        margin-bottom: 2rem;
      }
      
      .footer h5::after {
        left: 50%;
        transform: translateX(-50%);
      }
    }

    @media (max-width: 576px) {
      .footer {
        text-align: center;
      }
      
      .contact-info {
        justify-content: center;
      }
    }
</style>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
        if (window.history && window.history.pushState) {
            window.addEventListener('load', function() {
                window.history.pushState({}, '', window.location.href);
            });

            window.addEventListener('popstate', function() {
                window.history.pushState({}, '', window.location.href);
            });
        }

        window.addEventListener('pageshow', function(event) {
            if (event.persisted || 
                (window.performance && window.performance.getEntriesByType("navigation")[0].type === "back_forward")) {
                
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
        
        if (window.location.pathname.includes('/home') || 
            window.location.pathname.includes('/cart') ||
            window.location.pathname.includes('/profile')) {
            
            window.addEventListener('beforeunload', function() {
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
      <a href="{{ auth()->check() ? url('/home') : url('/') }}"><img src="{{ asset('storage/product_images/logobrand.png') }}" alt="logo" class="logonusantara"></a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

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

          <li class="nav-item mega-menu-wrapper">
            <a class="nav-link {{ Request::is('products') ? 'active' : '' }}" href="{{ url('/products') }}">Koleksi</a>
            <div class="mega-menu">
                <div class="category-list-5">
                    @foreach(App\Models\Category::withCount('products')
                        ->orderBy('products_count', 'desc')
                        ->take(5)
                        ->get() as $category)
                    <a href="{{ url('/products?category='.$category->slug) }}" class="category-item">
                        <span class="category-name">{{ $category->name }}</span>
                    </a>
                    @endforeach
                </div>

                @if(App\Models\Category::count() > 5)
                    <div class="view-more-container">
                        <a href="{{ url('/products') }}" class="view-more-link">
                            Lihat Semua Kategori
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 18L15 12L9 6" stroke="#422D1C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </div>
                @endif
            </div>
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
          <div class="dropdown">
            <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-person-circle"></i>
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">{{ Auth::user()->name }}</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="{{ route('orders.index') }}">Pesanan Saya</a></li>
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
          @endauth
        </div>
      </div>
    </div>
  </nav>

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

  <footer class="footer">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <h5 class="mb-4">NusantaraShop</h5>
          <p>Toko batik terpercaya dengan koleksi pilihan terbaik untuk kebutuhan fashion Anda. Menghadirkan keindahan budaya Indonesia dalam setiap produk.</p>
        </div>
        <div class="col-md-4">
          <h6 class="mb-4">Menu Navigasi</h6>
          <ul class="list-unstyled">
            <li>
              <a href="{{ auth()->check() ? url('/home') : url('/') }}" class="text-muted text-decoration-none">
                <i class="bi bi-house footer-icon"></i>Beranda
              </a>
            </li>
            <li>
              <a href="{{ url('/products') }}" class="text-muted text-decoration-none">
                <i class="bi bi-grid footer-icon"></i>Koleksi
              </a>
            </li>
            <li>
              <a href="{{ url('/promo') }}" class="text-muted text-decoration-none">
                <i class="bi bi-percent footer-icon"></i>Promo
              </a>
            </li>
            <li>
              <a href="{{ url('/contact') }}" class="text-muted text-decoration-none">
                <i class="bi bi-envelope footer-icon"></i>Kontak
              </a>
            </li>
            <li>
              <a href="{{ url('/help') }}" class="text-muted text-decoration-none">
                <i class="bi bi-question-circle footer-icon"></i>Bantuan
              </a>
            </li>
          </ul>
        </div>
        <div class="col-md-4">
          <h6 class="mb-4">Hubungi Kami</h6>
          <div class="contact-info">
            <i class="bi bi-envelope-fill"></i>
            <p class="contact-text">info@nusantarashop.com</p>
          </div>
          <div class="contact-info">
            <i class="bi bi-telephone-fill"></i>
            <p class="contact-text">(021) 123-4567</p>
          </div>
          <div class="contact-info">
            <i class="bi bi-geo-alt-fill"></i>
            <p class="contact-text">Jakarta, Indonesia<br>Jl. Batik Nusantara No. 123</p>
          </div>
        </div>
      </div>
      <hr class="footer-divider">
      <div class="footer-bottom">
        <p class="mb-0">© 2025 NusantaraShop. Semua hak cipta dilindungi undang-undang.</p>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>