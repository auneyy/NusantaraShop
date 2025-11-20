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
  <link rel="icon" href="{{ asset('storage/product_images/logobos.png') }}">
  @stack('styles')
  
  <style>
    body {
      font-family: 'Manrope', sans-serif;
      background-color: #fff;
      padding-top: 80px; /* Sesuaikan dengan tinggi navbar */
    }

    /* Navbar Base Styles */
    .navbar {
      background-color: #fff !important;
      box-shadow: 0 2px 4px rgba(0,0,0,0.08);
      padding: 1rem 0;
      z-index: 1000;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      backdrop-filter: blur(10px);
    }

    /* Navbar Scrolled State */
    .navbar.scrolled {
      padding: 0.5rem 0;
      background-color: rgba(255, 255, 255, 0.95) !important;
      box-shadow: 0 4px 20px rgba(0,0,0,0.15);
      backdrop-filter: blur(20px);
    }

    /* Navbar Hidden State (saat scroll down) */
    .navbar.navbar-hidden {
      transform: translateY(-100%);
    }

    /* Logo Animation */
    .logonusantara {
      height: 50px;
      width: auto;
      margin-right: 20px;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .navbar.scrolled .logonusantara {
      height: 40px;
    }

    /* Nav Links */
    .navbar-nav .nav-link {
      color: #422D1C !important;
      font-weight: 500;
      margin: 0 10px;
      transition: all 0.3s ease;
      position: relative;
      padding: 0.5rem 0 !important;
    }

    .navbar-nav .nav-link::after {
      content: '';
      position: absolute;
      left: 0;
      bottom: 0;
      width: 0;
      height: 2px;
      background: linear-gradient(90deg, #8B4513, #422D1C);
      transition: width 0.3s ease-in-out;
      border-radius: 2px;
    }

    .navbar-nav .nav-link:hover::after,
    .navbar-nav .nav-link.active::after {
      width: 100%;
    }

    .navbar-nav .nav-link:hover,
    .navbar-nav .nav-link.active {
      color: #8B4513 !important;
      font-weight: 600;
    }

    /* Navbar Icons */
    .navbar-icons {
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .navbar-icons a,
    .navbar-icons .dropdown-toggle {
      color: #422D1C;
      font-size: 1.2rem;
      text-decoration: none;
      transition: all 0.3s ease;
      position: relative;
      display: inline-block;
      cursor: pointer;
    }

    .navbar-icons a::before,
    .navbar-icons .dropdown-toggle::before {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%) scale(0);
      width: 40px;
      height: 40px;
      background-color: rgba(139, 69, 19, 0.1);
      border-radius: 50%;
      transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      z-index: -1;
    }

    .navbar-icons a:hover::before,
    .navbar-icons .dropdown-toggle:hover::before {
      transform: translate(-50%, -50%) scale(1);
    }

    .navbar-icons a:hover,
    .navbar-icons .dropdown-toggle:hover {
      color: #8B4513;
      transform: translateY(-2px);
    }

    /* Mega Menu */
    .mega-menu {
      position: absolute;
      left: 50%;
      transform: translateX(-50%) translateY(10px);
      top: 100%;
      z-index: 1000;
      width: 250px;
      background-color: #ffffff;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
      padding: 1rem 0;
      opacity: 0;
      visibility: hidden;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      border-radius: 12px;
      border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .mega-menu-wrapper:hover .mega-menu {
      opacity: 1;
      visibility: visible;
      transform: translateX(-50%) translateY(0);
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
      transition: all 0.2s ease-in-out;
      position: relative;
      overflow: hidden;
    }

    .category-list-5 .category-item:hover {
      background-color: #f8f9fa;
      padding-left: 2rem;
    }

    .category-list-5 .category-item::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 4px;
      height: 100%;
      background: linear-gradient(180deg, #8B4513, #422D1C);
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
      color: #8B4513;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .view-more-link:hover {
      color: #422D1C;
      transform: translateX(5px);
    }

    /* Scroll to Top Button */
    .scroll-to-top {
      position: fixed;
      bottom: 30px;
      right: 30px;
      width: 50px;
      height: 50px;
      background: linear-gradient(135deg, #8B4513, #422D1C);
      color: white;
      border: none;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
      cursor: pointer;
      opacity: 0;
      visibility: hidden;
      transform: translateY(20px);
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      box-shadow: 0 4px 20px rgba(66, 45, 28, 0.3);
      z-index: 999;
    }

    .scroll-to-top.show {
      opacity: 1;
      visibility: visible;
      transform: translateY(0);
    }

    .scroll-to-top:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 25px rgba(66, 45, 28, 0.4);
    }

    /* Modern Footer Styles */
    .footer {
      background-color: #ffffff;
      color: #422D1C;
      padding: 3rem 0 1.5rem;
      box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.08);
      border-top: 1px solid #f0f0f0;
      margin-top: 4rem;
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
      display: inline-block;
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

    .dropdown-item {
      font-size: 15px;
      transition: all 0.3s ease;
      padding: 0.5rem 1rem;
    }

    .dropdown-item:hover {
      background-color: #f8f9fa;
      padding-left: 1.5rem;
    }

    .dropdown-menu {
      border: none;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
      border-radius: 12px;
      overflow: hidden;
      margin-top: 0.5rem;
    }

    .btn-primary {
      background-color: #422D1C;
      border: none;
      transition: all 0.3s ease;
    }

    .btn-primary:hover {
      background-color: #8B4513;
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(66, 45, 28, 0.3);
    }

    /* Responsive */
    @media (max-width: 991px) {
      body {
        padding-top: 70px;
      }

      .navbar {
        padding: 0.75rem 0;
      }

      .navbar.scrolled {
        padding: 0.5rem 0;
      }

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

      .scroll-to-top {
        bottom: 20px;
        right: 20px;
        width: 45px;
        height: 45px;
        font-size: 1.3rem;
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

    /* Loading Animation */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .fade-in-up {
      animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1);
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
  <!-- Navbar dengan animasi scroll -->
  <nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
      <a href="{{ auth()->check() ? url('/home') : url('/') }}">
        <img src="{{ asset('storage/product_images/logobrand.png') }}" alt="logo" class="logonusantara">
      </a>

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
                                <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
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
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="{{ route('profile.index') }}">{{ Auth::user()->name }}</a></li>
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
          @endauth
        </div>
      </div>
    </div>
  </nav>

  <!-- Scroll to Top Button -->
  <button class="scroll-to-top" id="scrollToTop" aria-label="Scroll to top">
    <i class="bi bi-arrow-up"></i>
  </button>

  <!-- Search Modal -->
  <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="searchModalLabel">Cari Produk</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ url('/products') }}" method="GET">
            <div class="mb-3">
              <input type="text" name="search" class="form-control" placeholder="Cari produk batik..." required>
            </div>
            <button type="submit" class="btn btn-primary">Cari</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <main>
    @yield('content')
    @include('partials.ai-chat')
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
            <p class="contact-text">nusantarashop@gmail.com</p>
          </div>
          <div class="contact-info">
            <i class="bi bi-telephone-fill"></i>
            <p class="contact-text">+62 895 4036 50987</p>
          </div>
          <div class="contact-info">
            <i class="bi bi-geo-alt-fill"></i>
            <p class="contact-text">Jl. Kalimasada Nomor 30, <br>Polehan, Kec. Blimbing, <br>Kota Malang, Jawa Timur 65121</p>
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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Navbar Scroll Animation Script -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const navbar = document.querySelector('.navbar');
      const scrollToTopBtn = document.getElementById('scrollToTop');
      let lastScrollTop = 0;
      let scrollTimeout;

      // Navbar scroll effect
      window.addEventListener('scroll', function() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        // Add/remove scrolled class
        if (scrollTop > 50) {
          navbar.classList.add('scrolled');
        } else {
          navbar.classList.remove('scrolled');
        }

        // Hide navbar on scroll down, show on scroll up (Optional - uncomment jika ingin efek hide)
        // if (scrollTop > lastScrollTop && scrollTop > 100) {
        //   navbar.classList.add('navbar-hidden');
        // } else {
        //   navbar.classList.remove('navbar-hidden');
        // }

        lastScrollTop = scrollTop;

        // Show/hide scroll to top button
        if (scrollTop > 300) {
          scrollToTopBtn.classList.add('show');
        } else {
          scrollToTopBtn.classList.remove('show');
        }
      });

      // Scroll to top functionality
      scrollToTopBtn.addEventListener('click', function() {
        window.scrollTo({
          top: 0,
          behavior: 'smooth'
        });
      });

      // Smooth scroll for anchor links
      document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
          e.preventDefault();
          const target = document.querySelector(this.getAttribute('href'));
          if (target) {
            target.scrollIntoView({
              behavior: 'smooth',
              block: 'start'
            });
          }
        });
      });
    });
  </script>

  @stack('scripts')
</body>

</html>