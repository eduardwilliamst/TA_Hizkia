<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'POS System') - Admin</title>

    <!-- CSS files -->
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler-flags.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler-payments.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler-vendors.min.css" rel="stylesheet"/>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.3/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.bootstrap5.min.css">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css">

    <style>
        @import url('https://rsms.me/inter/inter.css');
        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }
        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }

        /* Custom animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.5s ease-out;
        }

        /* Card hover effect */
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }

        /* Custom color for brand */
        .gradient-brand {
            color: #0d6efd;
        }

        /* DataTables custom styling */
        .dataTables_wrapper .dataTables_length select {
            padding: 0.375rem 2.25rem 0.375rem 0.75rem;
        }

        .page-wrapper {
            background: #f8fafc;
        }
    </style>

    @yield('styles')
</head>
<body>
    <div class="page">
        <!-- Navbar -->
        <header class="navbar navbar-expand-md d-print-none sticky-top" style="background: white; border-bottom: 1px solid #e9ecef;">
            <div class="container-xl">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                    <a href="@if(Auth::user()->hasRole('admin')){{ route('admin.dashboard') }}@else{{ route('user.dashboard') }}@endif">
                        <div class="d-flex align-items-center">
                            <div style="width: 35px; height: 35px; border-radius: 50%; background: #0d6efd; display: inline-flex; align-items: center; justify-content: center; margin-right: 10px;">
                                <i class="fas fa-store" style="color: white; font-size: 1rem;"></i>
                            </div>
                            <span style="font-weight: 700; font-size: 1.2rem; color: #0d6efd;">POS System</span>
                        </div>
                    </a>
                </h1>

                <div class="navbar-nav flex-row order-md-last">
                    <!-- Cart -->
                    <div class="nav-item">
                        <a href="{{ route('penjualan.viewCart') }}" class="nav-link px-3 position-relative">
                            <i class="fas fa-shopping-cart" style="font-size: 1.2rem; color: #0d6efd;"></i>
                            @php
                                $cartItems = session('cart', []);
                                $cartCount = count($cartItems);
                            @endphp
                            @if($cartCount > 0)
                            <span class="badge bg-red badge-pill position-absolute" style="top: 8px; right: 8px;">{{ $cartCount }}</span>
                            @endif
                        </a>
                    </div>

                    <!-- User Menu -->
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex lh-1 text-reset p-2" data-bs-toggle="dropdown" aria-label="Open user menu">
                            <span class="avatar avatar-sm" style="background: #0d6efd;">
                                <i class="fas fa-user" style="color: white;"></i>
                            </span>
                            <div class="d-none d-xl-block ps-2">
                                <div style="font-weight: 600;">{{ Auth::user()->name }}</div>
                                <div class="mt-1 small text-muted">
                                    @if(Auth::user()->hasRole('admin'))
                                        <i class="fas fa-crown"></i> Administrator
                                    @else
                                        <i class="fas fa-cash-register"></i> Kasir
                                    @endif
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <a href="{{ route('profile.index') }}" class="dropdown-item">
                                <i class="fas fa-user-circle me-2 text-primary"></i>Profil Saya
                            </a>
                            <a href="{{ route('cashflow.index') }}" class="dropdown-item">
                                <i class="fas fa-wallet me-2 text-success"></i>Cashflow
                            </a>
                            @if(!Auth::user()->hasRole('admin'))
                            <a href="{{ route('penjualan.listData') }}" class="dropdown-item">
                                <i class="fas fa-history me-2 text-info"></i>Riwayat Transaksi
                            </a>
                            @endif
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('logout') }}" class="dropdown-item text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Sidebar Navigation -->
        <header class="navbar-expand-md">
            <div class="collapse navbar-collapse" id="navbar-menu">
                <div class="navbar" style="background: #0d6efd;">
                    <div class="container-xl">
                        <ul class="navbar-nav">
                            <!-- Dashboard -->
                            <li class="nav-item">
                                @if(Auth::user()->hasRole('admin'))
                                    <a class="nav-link {{ Request::is('admin/dashboard') || Request::is('dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}" style="color: white;">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <i class="fas fa-tachometer-alt"></i>
                                        </span>
                                        <span class="nav-link-title">Dashboard</span>
                                    </a>
                                @else
                                    <a class="nav-link {{ Request::is('cashier/dashboard') || Request::is('dashboard') ? 'active' : '' }}" href="{{ route('user.dashboard') }}" style="color: white;">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <i class="fas fa-tachometer-alt"></i>
                                        </span>
                                        <span class="nav-link-title">Dashboard</span>
                                    </a>
                                @endif
                            </li>

                            <!-- POS -->
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('penjualan*') ? 'active' : '' }}" href="{{ route('penjualan.index') }}" style="color: white;">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <i class="fas fa-cash-register"></i>
                                    </span>
                                    <span class="nav-link-title">POS / Penjualan</span>
                                    <span class="badge badge-sm bg-green ms-2">Hot</span>
                                </a>
                            </li>

                            <!-- Master Data - Admin Only -->
                            @if(Auth::user()->hasRole('admin'))
                            <li class="nav-item dropdown {{ Request::is('kategori*') || Request::is('produk*') || Request::is('promo*') || Request::is('supplier*') || Request::is('tipe*') ? 'active' : '' }}">
                                <a class="nav-link dropdown-toggle" href="#navbar-master" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false" style="color: white;">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <i class="fas fa-database"></i>
                                    </span>
                                    <span class="nav-link-title">Master Data</span>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item {{ Request::is('kategori*') ? 'active' : '' }}" href="{{ route('kategori.index') }}">
                                        <i class="fas fa-th me-2"></i>Kategori
                                    </a>
                                    <a class="dropdown-item {{ Request::is('produk*') ? 'active' : '' }}" href="{{ route('produk.index') }}">
                                        <i class="fas fa-box-open me-2"></i>Produk
                                    </a>
                                    <a class="dropdown-item {{ Request::is('promo*') ? 'active' : '' }}" href="{{ route('promo.index') }}">
                                        <i class="fas fa-star me-2"></i>Promo
                                    </a>
                                    <a class="dropdown-item {{ Request::is('supplier*') ? 'active' : '' }}" href="{{ route('supplier.index') }}">
                                        <i class="fas fa-truck me-2"></i>Supplier
                                    </a>
                                    <a class="dropdown-item {{ Request::is('tipe*') ? 'active' : '' }}" href="{{ route('tipe.index') }}">
                                        <i class="fas fa-list-alt me-2"></i>Tipe Pembelian
                                    </a>
                                </div>
                            </li>

                            <!-- Pembelian - Admin Only -->
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('pembelian/index') || Request::is('pembelian') ? 'active' : '' }}" href="{{ route('pembelian.index') }}" style="color: white;">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <i class="fas fa-shopping-basket"></i>
                                    </span>
                                    <span class="nav-link-title">Pembelian</span>
                                </a>
                            </li>
                            @else
                            <!-- Kasir - Cek Stok -->
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('produk*') ? 'active' : '' }}" href="{{ route('produk.index') }}" style="color: white;">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <i class="fas fa-box-open"></i>
                                    </span>
                                    <span class="nav-link-title">Cek Stok Produk</span>
                                </a>
                            </li>
                            @endif

                            <!-- Riwayat -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle {{ Request::is('pembelian/listData') || Request::is('penjualan/listData') ? 'active' : '' }}" href="#navbar-history" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false" style="color: white;">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <i class="fas fa-history"></i>
                                    </span>
                                    <span class="nav-link-title">Riwayat</span>
                                </a>
                                <div class="dropdown-menu">
                                    @if(Auth::user()->hasRole('admin'))
                                    <a class="dropdown-item {{ Request::is('pembelian/listData') ? 'active' : '' }}" href="{{ route('pembelian.listData') }}">
                                        <i class="fas fa-file-invoice-dollar me-2"></i>Riwayat Pembelian
                                    </a>
                                    @endif
                                    <a class="dropdown-item {{ Request::is('penjualan/listData') ? 'active' : '' }}" href="{{ route('penjualan.listData') }}">
                                        <i class="fas fa-receipt me-2"></i>Riwayat Penjualan
                                    </a>
                                </div>
                            </li>

                            <!-- Cashflow -->
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('cashflow*') ? 'active' : '' }}" href="{{ route('cashflow.index') }}" style="color: white;">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <i class="fas fa-wallet"></i>
                                    </span>
                                    <span class="nav-link-title">Cashflow</span>
                                </a>
                            </li>

                            <!-- Users - Admin Only -->
                            @if(Auth::user()->hasRole('admin'))
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('users*') ? 'active' : '' }}" href="{{ route('users.index') }}" style="color: white;">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <i class="fas fa-users-cog"></i>
                                    </span>
                                    <span class="nav-link-title">Pengguna</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <div class="page-wrapper">
            <!-- Page header -->
            <div class="page-header d-print-none" style="background: white; border-bottom: 1px solid #e9ecef;">
                <div class="container-xl">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            @yield('page-header')
                        </div>
                        <div class="col-auto ms-auto d-print-none">
                            @yield('page-actions')
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page body -->
            <div class="page-body">
                <div class="container-xl">
                    @yield('content')
                </div>
            </div>

            <!-- Footer -->
            <footer class="footer footer-transparent d-print-none">
                <div class="container-xl">
                    <div class="row text-center align-items-center flex-row-reverse">
                        <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                            <ul class="list-inline list-inline-dots mb-0">
                                <li class="list-inline-item">
                                    Copyright &copy; {{ date('Y') }}
                                    <a href="#" class="link-secondary">POS System</a>.
                                    All rights reserved.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Tabler Core -->
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/js/tabler.min.js"></script>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.3/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>

    <!-- Global SweetAlert2 Configuration -->
    <script>
        // Configure SweetAlert2 Toast
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

        // Show success messages from session
        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}'
            });
        @endif

        // Show error messages from session
        @if(session('error'))
            Toast.fire({
                icon: 'error',
                title: '{{ session('error') }}'
            });
        @endif

        // Show warning messages from session
        @if(session('warning'))
            Toast.fire({
                icon: 'warning',
                title: '{{ session('warning') }}'
            });
        @endif

        // Show info messages from session
        @if(session('info'))
            Toast.fire({
                icon: 'info',
                title: '{{ session('info') }}'
            });
        @endif

        // Show validation errors
        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: '<ul style="text-align: left;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
                confirmButtonColor: '#667eea'
            });
        @endif

        // Global delete confirmation function
        function confirmDelete(formId) {
            event.preventDefault();
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
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
