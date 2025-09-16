<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin - NusantaraShop')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        :root {
            --primary-color: #422D1C;
            --sidebar-width: 260px;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f8f9fb;
            color: #334155;
            line-height: 1.6;
            overflow-x: hidden;
        }

        .sidebar {
            width: var(--sidebar-width);
            background: #fff;
            border-right: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            transition: all 0.3s ease;
            z-index: 1040;
            left: 0;
            top: 0;
        }

        .sidebar.collapsed {
            transform: translateX(-100%);
        }

        .sidebar-header {
            padding: 24px 20px;
            border-bottom: 1px solid #e2e8f0;
            text-align: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .logo i {
            font-size: 1.8rem;
        }

        .logo-subtitle {
            font-size: 0.8rem;
            color: #64748b;
            font-weight: 500;
        }

        .nav-menu {
            padding: 16px 0;
        }

        .nav-menu .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #64748b;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
            border-radius: 0;
        }

        .nav-menu .nav-link:hover,
        .nav-menu .nav-link:focus {
            background: #f8fafc;
            color: var(--primary-color);
            border-left-color: var(--primary-color);
        }

        .nav-menu .nav-link.active {
            background: #f8fafc;
            color: var(--primary-color);
            border-left-color: var(--primary-color);
        }

        .nav-icon {
            width: 20px;
            height: 20px;
            margin-right: 12px;
            font-size: 1.1rem;
            text-align: center;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            transition: all 0.3s ease;
        }

        .main-content.full-width {
            margin-left: 0;
        }

        .custom-header {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            position: sticky;
            top: 0;
            z-index: 100;
            padding: 15px 0;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1e293b;
            margin: 0;
        }

        .search-container {
            position: relative;
        }

        .search-input {
            padding: 8px 16px 8px 40px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: #f8fafc;
            font-size: 0.9rem;
            width: 280px;
            transition: all 0.2s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(66, 45, 28, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            font-size: 1rem;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            padding: 8px 12px;
            border-radius: 8px;
            transition: all 0.2s ease;
            position: relative;
        }

        .user-profile:hover {
            background: #f8fafc;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            background: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .user-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            min-width: 200px;
            z-index: 1041;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.2s ease;
        }

        .user-dropdown.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .user-dropdown-header {
            padding: 16px;
            border-bottom: 1px solid #e2e8f0;
            background: #f8fafc;
        }

        .user-name {
            font-weight: 600;
            color: #1e293b;
            font-size: 0.9rem;
        }

        .user-email {
            font-size: 0.8rem;
            color: #64748b;
            margin-top: 2px;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            color: #64748b;
            text-decoration: none;
            transition: all 0.2s ease;
            font-size: 0.9rem;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }

        .dropdown-item:hover {
            background: #f8fafc;
            color: var(--primary-color);
        }

        .dropdown-item.logout {
            border-top: 1px solid #e2e8f0;
            color: #dc2626;
        }

        .dropdown-item.logout:hover {
            background: #fef2f2;
        }

        .sidebar-toggle {
            background: none;
            border: none;
            padding: 8px;
            cursor: pointer;
            color: #64748b;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            transition: all 0.2s ease;
            margin-right: 10px;
        }

        .sidebar-toggle:hover {
            background: #f1f5f9;
            color: var(--primary-color);
        }

        .toggle-state {
            display: flex;
            align-items: center;
            margin-left: 10px;
            color: #64748b;
            font-size: 0.8rem;
        }

        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .search-input {
                width: 200px;
            }
        }

        @media (max-width: 768px) {
            .search-input {
                width: 150px;
            }

            .user-profile span:not(.user-avatar) {
                display: none;
            }
            
            .toggle-state {
                display: none;
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1039;
            display: none;
        }

        .sidebar-overlay.show {
            display: block;
        }
        
        .content-area {
            padding: 24px;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="admin-layout">
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                   <img src="{{ asset('storage/product_images/logobrand.png') }}" 
     alt="NusantaraShop" 
     class="logonusantara"
     style="width:200px; height:auto;">
                </div>
            </div>
            
            <nav class="nav-menu">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-home"></i>
                            Beranda
                        </a>
                    </li>

                    <li class="nav-item">
                          <a href="{{ route('admin.pesanan') }}" class="nav-link {{ request()->routeIs('admin.pesanan') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            Pesanan
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-box"></i>
                            Produk
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-layer-group"></i>
                            Kategori
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.discounts.index') }}" class="nav-link {{ request()->routeIs('admin.discounts.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tags"></i>
                            Diskon
                        </a>
                    </li>

                    <li class="nav-item">
                         <a href="{{ route('admin.messages.index') }}" class="nav-link {{ request()->routeIs('admin.messages.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-inbox"></i>
                            Pesan Masuk
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.artikel.index') }}" class="nav-link {{ request()->routeIs('admin.artikel.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-newspaper"></i>
                            Artikel
                        </a>
                    </li>

                    <li class="nav-item">
                       <a href="{{ route('admin.pendapatan') }}" class="nav-link {{ request()->routeIs('admin.pendapatan') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chart-line"></i>
                            Laporan Pendapatan
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <main class="main-content" id="mainContent">
            <header class="custom-header">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <button class="sidebar-toggle" id="sidebarToggle">
                                    <i class="fas fa-bars"></i>
                                </button>
                                <h1 class="page-title">@yield('page-title', 'Dashboard Admin')</h1>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="d-flex align-items-center justify-content-end gap-3">
                                <div class="search-container">
                                    <i class="search-icon fas fa-search"></i>
                                    <input type="text" class="search-input form-control" placeholder="Cari produk, pesanan, atau pengguna...">
                                </div>
                                
                                <div class="user-profile" id="userProfile">
                                    <div class="user-avatar">
                                        <i class="fas fa-user"></i>
                                    </div>
                                   <span>{{ Auth::user()->name }}</span>
                                    <i class="fas fa-chevron-down" style="font-size: 0.8rem; color: #64748b;"></i>
                                    
                                    <!-- Dropdown Menu -->
                                    <div class="user-dropdown" id="userDropdown">
                                        <div class="user-dropdown-header">
                                           <div class="user-name">{{ Auth::user()->name }}</div>
                                            <div class="user-email">{{ Auth::user()->email }}</div>
                                        </div>
                                        <div class="dropdown-menu-custom">
                                            <a href="#profile" class="dropdown-item">
                                                <i class="fas fa-user"></i>
                                                Profil Saya
                                            </a>
                                            <a href="#settings" class="dropdown-item">
                                                <i class="fas fa-cog"></i>
                                                Pengaturan
                                            </a>
<a href="#" class="dropdown-item"
   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
   <i class="fas fa-sign-out-alt"></i> Keluar
</a>

<form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display:none;">
    @csrf
</form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <div class="container-fluid content-area">
                @yield('content')
            </div>
        </main>
    </div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        let sidebarVisible = true;
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const toggleState = document.getElementById('toggleState');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        function toggleSidebar() {
            sidebarVisible = !sidebarVisible;
            
            if (sidebarVisible) {
                sidebar.classList.remove('collapsed');
                mainContent.classList.remove('full-width');
                sidebarOverlay.classList.remove('show');
            } else {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('full-width');
            }
            
            localStorage.setItem('sidebarVisible', sidebarVisible);
        }

        sidebarToggle.addEventListener('click', toggleSidebar);

        sidebarOverlay.addEventListener('click', function() {
            if (window.innerWidth <= 1024) {
                toggleSidebar();
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const savedState = localStorage.getItem('sidebarVisible');
            
            if (savedState !== null) {
                sidebarVisible = savedState === 'true';
                
                if (!sidebarVisible) {
                    sidebar.classList.add('collapsed');
                    mainContent.classList.add('full-width');
                    toggleState.textContent = 'Sidebar Tersembunyi';
                }
            }
            
            if (window.innerWidth <= 1024) {
                sidebarVisible = false;
                sidebar.classList.add('collapsed');
                mainContent.classList.add('full-width');
                toggleState.textContent = 'Sidebar Tersembunyi';
            }
        });

        const userProfile = document.getElementById('userProfile');
        const userDropdown = document.getElementById('userDropdown');

        userProfile.addEventListener('click', function(e) {
            e.stopPropagation();
            userDropdown.classList.toggle('show');
        });

        document.addEventListener('click', function(e) {
            if (!userProfile.contains(e.target)) {
                userDropdown.classList.remove('show');
            }
        });

        document.querySelectorAll('.dropdown-item').forEach(item => {
            item.addEventListener('click', function() {
                userDropdown.classList.remove('show');
            });
        });

        window.addEventListener('resize', function() {
            if (window.innerWidth <= 1024) {
                if (sidebarVisible) {
                    toggleSidebar();
                }
            } else {
                if (!sidebarVisible) {
                    toggleSidebar();
                }
            }
        });
    </script>
    @stack('scripts')
</body>
</html>