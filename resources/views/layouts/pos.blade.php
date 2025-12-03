<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ config('app.name', 'POS System') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.bootstrap5.min.css">
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-color: #4F46E5;
            --primary-dark: #4338CA;
            --primary-light: #6366F1;
            --secondary-color: #10B981;
            --danger-color: #EF4444;
            --warning-color: #F59E0B;
            --info-color: #3B82F6;
            --dark-color: #1F2937;
            --light-color: #F9FAFB;
            --sidebar-width: 260px;
            --topbar-height: 64px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #F3F4F6;
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, #1F2937 0%, #111827 100%);
            color: white;
            z-index: 1000;
            transition: transform 0.3s ease;
            overflow-y: auto;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            color: white;
        }

        .sidebar-brand-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .sidebar-brand-text {
            font-size: 1.25rem;
            font-weight: 700;
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .menu-section {
            margin-bottom: 1.5rem;
        }

        .menu-section-title {
            padding: 0 1.5rem;
            margin-bottom: 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: rgba(255, 255, 255, 0.5);
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.2s ease;
            position: relative;
        }

        .menu-item:hover {
            background: rgba(255, 255, 255, 0.05);
            color: white;
        }

        .menu-item.active {
            background: rgba(79, 70, 229, 0.2);
            color: white;
        }

        .menu-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: var(--primary-light);
        }

        .menu-item i {
            width: 20px;
            margin-right: 0.75rem;
            font-size: 1.125rem;
        }

        .menu-item-text {
            flex: 1;
            font-size: 0.9375rem;
            font-weight: 500;
        }

        .menu-item-badge {
            padding: 0.25rem 0.5rem;
            background: var(--danger-color);
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .menu-submenu {
            display: none;
            background: rgba(0, 0, 0, 0.2);
            padding: 0.5rem 0;
        }

        .menu-item.has-submenu.open .menu-submenu {
            display: block;
        }

        .menu-item.has-submenu .menu-arrow {
            margin-left: auto;
            transition: transform 0.2s ease;
        }

        .menu-item.has-submenu.open .menu-arrow {
            transform: rotate(90deg);
        }

        .submenu-item {
            display: flex;
            align-items: center;
            padding: 0.625rem 1.5rem 0.625rem 3.25rem;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .submenu-item:hover {
            color: white;
            background: rgba(255, 255, 255, 0.05);
        }

        .submenu-item.active {
            color: var(--primary-light);
            font-weight: 500;
        }

        /* Main Content */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        .topbar {
            background: white;
            height: var(--topbar-height);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            padding: 0 2rem;
            gap: 1rem;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topbar-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--dark-color);
            cursor: pointer;
            padding: 0.5rem;
        }

        .topbar-search {
            flex: 1;
            max-width: 500px;
        }

        .search-input {
            width: 100%;
            padding: 0.625rem 1rem 0.625rem 2.5rem;
            border: 1px solid #E5E7EB;
            border-radius: 8px;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236B7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'/%3E%3C/svg%3E") no-repeat 0.75rem center;
            background-size: 1rem;
            background-color: #F9FAFB;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            background-color: white;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-left: auto;
        }

        .topbar-icon {
            position: relative;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #F9FAFB;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            color: var(--dark-color);
            text-decoration: none;
        }

        .topbar-icon:hover {
            background: #E5E7EB;
        }

        .topbar-icon .badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background: var(--danger-color);
            color: white;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            font-size: 0.625rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .user-menu {
            position: relative;
        }

        .user-btn {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 0.75rem;
            background: #F9FAFB;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .user-btn:hover {
            background: #E5E7EB;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .user-info {
            text-align: left;
        }

        .user-name {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--dark-color);
        }

        .user-role {
            font-size: 0.75rem;
            color: #6B7280;
        }

        .dropdown-menu {
            position: absolute;
            top: calc(100% + 0.5rem);
            right: 0;
            background: white;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            min-width: 200px;
            padding: 0.5rem;
            display: none;
            z-index: 1000;
        }

        .dropdown-menu.show {
            display: block;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.625rem 0.75rem;
            color: var(--dark-color);
            text-decoration: none;
            border-radius: 6px;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background: #F3F4F6;
        }

        .dropdown-divider {
            height: 1px;
            background: #E5E7EB;
            margin: 0.5rem 0;
        }

        /* Content Area */
        .content-wrapper {
            padding: 2rem;
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        .page-breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: #6B7280;
        }

        .breadcrumb-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .breadcrumb-item:not(:last-child)::after {
            content: '/';
            margin-left: 0.5rem;
            color: #D1D5DB;
        }

        .breadcrumb-link {
            color: #6B7280;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .breadcrumb-link:hover {
            color: var(--primary-color);
        }

        /* Cards */
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .card-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #E5E7EB;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--dark-color);
            margin: 0;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            border: none;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        .btn-secondary {
            background: #6B7280;
            color: white;
        }

        .btn-secondary:hover {
            background: #4B5563;
        }

        .btn-success {
            background: var(--secondary-color);
            color: white;
        }

        .btn-success:hover {
            background: #059669;
        }

        .btn-danger {
            background: var(--danger-color);
            color: white;
        }

        .btn-danger:hover {
            background: #DC2626;
        }

        .btn-warning {
            background: var(--warning-color);
            color: white;
        }

        .btn-warning:hover {
            background: #D97706;
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.8125rem;
        }

        .btn-lg {
            padding: 0.875rem 1.5rem;
            font-size: 1rem;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-wrapper {
                margin-left: 0;
            }

            .topbar-toggle {
                display: block;
            }

            .topbar {
                padding: 0 1rem;
            }

            .topbar-search {
                display: none;
            }

            .content-wrapper {
                padding: 1rem;
            }

            .user-info {
                display: none;
            }
        }

        /* Overlay for mobile */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            display: none;
        }

        .sidebar-overlay.active {
            display: block;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #F3F4F6;
        }

        ::-webkit-scrollbar-thumb {
            background: #D1D5DB;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #9CA3AF;
        }
    </style>

    @yield('styles')
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('dashboard') }}" class="sidebar-brand">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-cash-register"></i>
                </div>
                <span class="sidebar-brand-text">POS System</span>
            </a>
        </div>

        <nav class="sidebar-menu">
            <!-- Main Menu -->
            <div class="menu-section">
                <div class="menu-section-title">Main Menu</div>
                <a href="{{ route('dashboard') }}" class="menu-item {{ Request::is('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span class="menu-item-text">Dashboard</span>
                </a>
            </div>

            <!-- Transaksi -->
            <div class="menu-section">
                <div class="menu-section-title">Transaksi</div>
                <a href="{{ route('penjualan.index') }}" class="menu-item {{ Request::is('penjualan/index') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="menu-item-text">Penjualan</span>
                </a>
                <a href="{{ route('pembelian.index') }}" class="menu-item {{ Request::is('pembelian/index') ? 'active' : '' }}">
                    <i class="fas fa-shopping-bag"></i>
                    <span class="menu-item-text">Pembelian</span>
                </a>
                <a href="{{ route('penjualan.viewCart') }}" class="menu-item {{ Request::is('cart') ? 'active' : '' }}">
                    <i class="fas fa-cart-plus"></i>
                    <span class="menu-item-text">Keranjang</span>
                </a>
            </div>

            <!-- Master Data -->
            <div class="menu-section">
                <div class="menu-section-title">Master Data</div>
                <a href="{{ route('produk.index') }}" class="menu-item {{ Request::is('produk*') ? 'active' : '' }}">
                    <i class="fas fa-box"></i>
                    <span class="menu-item-text">Produk</span>
                </a>
                <a href="{{ route('kategori.index') }}" class="menu-item {{ Request::is('kategori*') ? 'active' : '' }}">
                    <i class="fas fa-tags"></i>
                    <span class="menu-item-text">Kategori</span>
                </a>
                <a href="{{ route('supplier.index') }}" class="menu-item {{ Request::is('supplier*') ? 'active' : '' }}">
                    <i class="fas fa-truck"></i>
                    <span class="menu-item-text">Supplier</span>
                </a>
                <a href="{{ route('tipe.index') }}" class="menu-item {{ Request::is('tipe*') ? 'active' : '' }}">
                    <i class="fas fa-list-alt"></i>
                    <span class="menu-item-text">Tipe Pembelian</span>
                </a>
            </div>

            <!-- Laporan -->
            <div class="menu-section">
                <div class="menu-section-title">Laporan</div>
                <a href="{{ route('penjualan.listData') }}" class="menu-item {{ Request::is('penjualan/listData') ? 'active' : '' }}">
                    <i class="fas fa-receipt"></i>
                    <span class="menu-item-text">Histori Penjualan</span>
                </a>
                <a href="{{ route('pembelian.listData') }}" class="menu-item {{ Request::is('pembelian/listData') ? 'active' : '' }}">
                    <i class="fas fa-file-invoice-dollar"></i>
                    <span class="menu-item-text">Histori Pembelian</span>
                </a>
                <a href="{{ route('cashflow.index') }}" class="menu-item {{ Request::is('cashflow*') ? 'active' : '' }}">
                    <i class="fas fa-money-bill-wave"></i>
                    <span class="menu-item-text">Cashflow</span>
                </a>
            </div>

            <!-- Promo & Diskon -->
            <div class="menu-section">
                <div class="menu-section-title">Marketing</div>
                <a href="{{ route('promo.index') }}" class="menu-item {{ Request::is('promo*') ? 'active' : '' }}">
                    <i class="fas fa-star"></i>
                    <span class="menu-item-text">Promo</span>
                </a>
                @if(Route::has('diskon.index'))
                <a href="{{ route('diskon.index') }}" class="menu-item {{ Request::is('diskon*') ? 'active' : '' }}">
                    <i class="fas fa-percentage"></i>
                    <span class="menu-item-text">Diskon</span>
                </a>
                @endif
            </div>

            <!-- Pengaturan -->
            <div class="menu-section">
                <div class="menu-section-title">Pengaturan</div>
                <a href="{{ route('users.index') }}" class="menu-item {{ Request::is('users*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span class="menu-item-text">Pengguna</span>
                </a>
                @if(Route::has('roles.index'))
                <a href="{{ route('roles.index') }}" class="menu-item {{ Request::is('roles*') ? 'active' : '' }}">
                    <i class="fas fa-user-shield"></i>
                    <span class="menu-item-text">Role & Permissions</span>
                </a>
                @endif
                <a href="{{ route('profile.index') }}" class="menu-item {{ Request::is('profile*') ? 'active' : '' }}">
                    <i class="fas fa-user-circle"></i>
                    <span class="menu-item-text">Profil Saya</span>
                </a>
            </div>
        </nav>
    </aside>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Main Content -->
    <div class="main-wrapper">
        <!-- Topbar -->
        <header class="topbar">
            <button class="topbar-toggle" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>

            <div class="topbar-search">
                <input type="text" class="search-input" placeholder="Cari produk, transaksi, atau pelanggan...">
            </div>

            <div class="topbar-actions">
                <a href="{{ route('penjualan.viewCart') }}" class="topbar-icon" title="Keranjang">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="badge" id="cartCount" style="display: none;">0</span>
                </a>

                <button class="topbar-icon" title="Notifikasi">
                    <i class="fas fa-bell"></i>
                    <!-- <span class="badge">3</span> -->
                </button>

                <div class="user-menu">
                    <button class="user-btn" id="userMenuBtn">
                        <div class="user-avatar">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="user-info">
                            <div class="user-name">{{ Auth::user()->name }}</div>
                            <div class="user-role">{{ Auth::user()->email }}</div>
                        </div>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu" id="userDropdown">
                        <a href="{{ route('profile.index') }}" class="dropdown-item">
                            <i class="fas fa-user"></i>
                            <span>Profil Saya</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('logout') }}" class="dropdown-item"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="content-wrapper">
            @yield('content')
        </main>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/responsive.bootstrap5.min.js"></script>
    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        // Sidebar Toggle
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        sidebarToggle?.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            sidebarOverlay.classList.toggle('active');
        });

        sidebarOverlay?.addEventListener('click', () => {
            sidebar.classList.remove('active');
            sidebarOverlay.classList.remove('active');
        });

        // User Menu Dropdown
        const userMenuBtn = document.getElementById('userMenuBtn');
        const userDropdown = document.getElementById('userDropdown');

        userMenuBtn?.addEventListener('click', (e) => {
            e.stopPropagation();
            userDropdown.classList.toggle('show');
        });

        document.addEventListener('click', (e) => {
            if (!userMenuBtn?.contains(e.target)) {
                userDropdown?.classList.remove('show');
            }
        });

        // Initialize DataTables
        $(document).ready(function() {
            if ($('.datatable').length) {
                $('.datatable').DataTable({
                    responsive: true,
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.1/i18n/id.json'
                    }
                });
            }

            // Initialize Select2
            if ($('.select2').length) {
                $('.select2').select2({
                    theme: 'bootstrap-5'
                });
            }
        });

        // SweetAlert2 Toast
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        // Show session messages
        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}'
            });
        @endif

        @if(session('error'))
            Toast.fire({
                icon: 'error',
                title: '{{ session('error') }}'
            });
        @endif

        @if(session('warning'))
            Toast.fire({
                icon: 'warning',
                title: '{{ session('warning') }}'
            });
        @endif

        @if(session('info'))
            Toast.fire({
                icon: 'info',
                title: '{{ session('info') }}'
            });
        @endif

        // Validation errors
        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Validasi Error',
                html: '<ul style="text-align: left;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
                confirmButtonColor: '#4F46E5'
            });
        @endif

        // Global delete confirmation
        function confirmDelete(formId) {
            event.preventDefault();
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }
    </script>

    @yield('scripts')
</body>
</html>
