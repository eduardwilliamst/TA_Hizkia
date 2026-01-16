<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    @yield('style')
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css') }}">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/summernote/summernote-bs4.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">

    <!-- Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    {{-- Datatables Fix --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.3/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.bootstrap4.min.css">

    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
    {{-- cropperjs --}}
    <link href="{{ asset('js/cropper/cropper.min.css') }}" rel="stylesheet" type="text/css" />

    {{-- Custom Animations & UX Improvements --}}
    <link href="{{ asset('css/custom-animations.css') }}" rel="stylesheet" type="text/css" />

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-50BBRYS4HY"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-50BBRYS4HY');
    </script>

</head>

<body class="hold-transition sidebar-mini {{ Request::is('penjualan/index') || Request::is('penjualan') ? 'sidebar-collapse' : '' }}">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light" style="border-bottom: 3px solid #0d6efd;">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button" style="padding: 0.5rem 1rem;">
                            <i class="fas fa-bars" style="font-size: 1.3rem; color: #0d6efd;"></i>
                        </a>
                    </li>
                </ul>

                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">
                    <!-- Quick POS Button - Kasir Only -->
                    @if(!Auth::user()->hasRole('admin'))
                    <li class="nav-item d-none d-md-block">
                        <a href="{{ route('penjualan.index') }}" class="btn btn-sm" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; border: none; border-radius: 8px; padding: 0.5rem 1.2rem; margin-top: 0.3rem; font-weight: 600;">
                            <i class="fas fa-cash-register mr-1"></i>POS
                        </a>
                    </li>
                    @endif

                    <!-- Shopping Cart -->
                    <li class="nav-item">
                        <a href="{{ route('penjualan.viewCart') }}" class="nav-link position-relative" style="padding: 0.5rem 1rem;">
                            <i class="fas fa-shopping-cart" style="font-size: 1.3rem; color: #0d6efd;"></i>
                            @php
                                $cartItems = session('cart', []);
                                $cartCount = count($cartItems);
                            @endphp
                            @if($cartCount > 0)
                            <span class="badge badge-danger navbar-badge" style="position: absolute; top: 5px; right: 5px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border: 2px solid white; font-size: 0.7rem; padding: 0.2rem 0.4rem; border-radius: 10px;">
                                {{ $cartCount }}
                            </span>
                            @endif
                        </a>
                    </li>

                    <!-- User Menu -->
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" data-toggle="dropdown" style="padding: 0.5rem 1rem;">
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: #0d6efd; display: flex; align-items: center; justify-content: center; margin-right: 8px;">
                                <i class="fas fa-user" style="color: white; font-size: 0.9rem;"></i>
                            </div>
                            <span class="d-none d-md-inline" style="color: #333; font-weight: 600;">{{ Auth::user()->name }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow-sm" style="border-radius: 10px; border: none; min-width: 220px;">
                            <div class="dropdown-header" style="background: #0d6efd; color: white; border-radius: 10px 10px 0 0; padding: 1rem;">
                                <strong>{{ Auth::user()->name }}</strong>
                                <br>
                                <small style="opacity: 0.9;">
                                    @if(Auth::user()->hasRole('admin'))
                                        <i class="fas fa-crown mr-1"></i>Administrator
                                    @else
                                        <i class="fas fa-cash-register mr-1"></i>Kasir
                                    @endif
                                </small>
                            </div>
                            <a href="{{ route('profile.index') }}" class="dropdown-item" style="padding: 0.8rem 1.2rem;">
                                <i class="fas fa-user-circle mr-2" style="color: #0d6efd; width: 20px;"></i>
                                Profil Saya
                            </a>
                            <a href="{{ route('cashflow.index') }}" class="dropdown-item" style="padding: 0.8rem 1.2rem;">
                                <i class="fas fa-wallet mr-2" style="color: #43e97b; width: 20px;"></i>
                                Cashflow
                            </a>
                            @if(!Auth::user()->hasRole('admin'))
                            <a href="{{ route('penjualan.listData') }}" class="dropdown-item" style="padding: 0.8rem 1.2rem;">
                                <i class="fas fa-history mr-2" style="color: #4facfe; width: 20px;"></i>
                                Riwayat Transaksi
                            </a>
                            @endif
                            <div class="dropdown-divider" style="margin: 0.5rem 0;"></div>
                            <a href="{{ route('logout') }}" class="dropdown-item" style="padding: 0.8rem 1.2rem; color: #f5576c;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt mr-2" style="width: 20px;"></i>
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="@if(Auth::user()->hasRole('admin')){{ route('admin.dashboard') }}@else{{ route('user.dashboard') }}@endif" class="brand-link" style="background: #0d6efd; border-bottom: 1px solid rgba(255,255,255,0.1);">
                <div class="d-flex align-items-center justify-content-center">
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: white; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="fas fa-store" style="color: #0d6efd; font-size: 1.2rem;"></i>
                    </div>
                    <span class="brand-text font-weight-bold" style="color: white; font-size: 1.2rem;">POS System</span>
                </div>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex" style="border-bottom: 1px solid rgba(255,255,255,0.1);">
                    <div class="image">
                        <div style="width: 40px; height: 40px; border-radius: 50%; background: #0d6efd; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-user" style="color: white; font-size: 1.2rem;"></i>
                        </div>
                    </div>
                    <div class="info">
                        <a href="{{ route('profile.index') }}" class="d-block" style="color: white;">{{ Auth::user()->name }}</a>
                        <small style="color: rgba(255,255,255,0.6);">
                            @if(Auth::user()->hasRole('admin'))
                                <i class="fas fa-crown mr-1"></i>Administrator
                            @else
                                <i class="fas fa-cash-register mr-1"></i>Kasir
                            @endif
                        </small>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                        <!-- DASHBOARD -->
                        <li class="nav-header" style="color: rgba(255,255,255,0.4); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; padding: 0.5rem 1rem; margin-top: 0.5rem;">
                            <i class="fas fa-grip-horizontal mr-2" style="font-size: 0.7rem;"></i>Overview
                        </li>
                        <li class="nav-item">
                            @if(Auth::user()->hasRole('admin'))
                                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Request::is('admin/dashboard') || Request::is('dashboard') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Dashboard</p>
                                </a>
                            @else
                                <a href="{{ route('user.dashboard') }}" class="nav-link {{ Request::is('cashier/dashboard') || Request::is('dashboard') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Dashboard</p>
                                </a>
                            @endif
                        </li>

                        <!-- POS OPERATIONS -->
                        <li class="nav-header" style="color: rgba(255,255,255,0.4); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; padding: 0.5rem 1rem; margin-top: 1rem;">
                            <i class="fas fa-cash-register mr-2" style="font-size: 0.7rem;"></i>Point of Sale
                        </li>

                        <!-- Penjualan (POS) -->
                        <li class="nav-item">
                            <a href="{{ route('penjualan.index') }}" class="nav-link {{ Request::is('penjualan/index') || Request::is('penjualan') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-shopping-cart"></i>
                                <p>
                                    Penjualan
                                    <span class="badge badge-success right" style="font-size: 0.65rem;">Live</span>
                                </p>
                            </a>
                        </li>

                        <!-- Cart -->
                        <li class="nav-item">
                            <a href="{{ route('penjualan.viewCart') }}" class="nav-link {{ Request::is('cart') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-shopping-basket"></i>
                                <p>
                                    Keranjang
                                    @php
                                        $cartCount = count(session('cart', []));
                                    @endphp
                                    @if($cartCount > 0)
                                        <span class="badge badge-danger right">{{ $cartCount }}</span>
                                    @endif
                                </p>
                            </a>
                        </li>

                        <!-- Cashflow -->
                        <li class="nav-item">
                            <a href="{{ route('cashflow.index') }}" class="nav-link {{ Request::is('cashflow*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-wallet"></i>
                                <p>Cashflow</p>
                            </a>
                        </li>

                        @if(Auth::user()->hasRole('admin'))
                        <!-- List Sesi POS (Admin Only) -->
                        <li class="nav-item">
                            <a href="{{ route('pos-session.index') }}" class="nav-link {{ Request::is('pos-session*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-history"></i>
                                <p>
                                    Riwayat Sesi
                                    <span class="badge badge-primary right" style="font-size: 0.65rem;">Admin</span>
                                </p>
                            </a>
                        </li>

                        <!-- INVENTORY MANAGEMENT -->
                        <li class="nav-header" style="color: rgba(255,255,255,0.4); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; padding: 0.5rem 1rem; margin-top: 1rem;">
                            <i class="fas fa-boxes mr-2" style="font-size: 0.7rem;"></i>Inventory
                        </li>

                        <!-- Produk -->
                        <li class="nav-item has-treeview {{ Request::is('produk*') || Request::is('kategori*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ Request::is('produk*') || Request::is('kategori*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-box-open"></i>
                                <p>
                                    Produk
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('produk.index') }}" class="nav-link {{ Request::is('produk*') ? 'active' : '' }}" style="padding-left: 3rem;">
                                        <i class="far fa-dot-circle nav-icon" style="font-size: 0.5rem;"></i>
                                        <p>Semua Produk</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('kategori.index') }}" class="nav-link {{ Request::is('kategori*') ? 'active' : '' }}" style="padding-left: 3rem;">
                                        <i class="far fa-dot-circle nav-icon" style="font-size: 0.5rem;"></i>
                                        <p>Kategori</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Pembelian (Stock In) -->
                        <li class="nav-item has-treeview {{ Request::is('pembelian*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ Request::is('pembelian*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-dolly"></i>
                                <p>
                                    Pembelian
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('pembelian.index') }}" class="nav-link {{ Request::is('pembelian/index') || Request::is('pembelian') && !Request::is('pembelian/listData') ? 'active' : '' }}" style="padding-left: 3rem;">
                                        <i class="far fa-dot-circle nav-icon" style="font-size: 0.5rem;"></i>
                                        <p>Tambah Pembelian</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('pembelian.listData') }}" class="nav-link {{ Request::is('pembelian/listData') ? 'active' : '' }}" style="padding-left: 3rem;">
                                        <i class="far fa-dot-circle nav-icon" style="font-size: 0.5rem;"></i>
                                        <p>Riwayat Pembelian</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Supplier -->
                        <li class="nav-item">
                            <a href="{{ route('supplier.index') }}" class="nav-link {{ Request::is('supplier*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-truck"></i>
                                <p>Supplier</p>
                            </a>
                        </li>

                        <!-- MARKETING -->
                        <li class="nav-header" style="color: rgba(255,255,255,0.4); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; padding: 0.5rem 1rem; margin-top: 1rem;">
                            <i class="fas fa-bullhorn mr-2" style="font-size: 0.7rem;"></i>Marketing
                        </li>

                        <!-- Promo -->
                        <li class="nav-item">
                            <a href="{{ route('promo.index') }}" class="nav-link {{ Request::is('promo*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tag"></i>
                                <p>Promo</p>
                            </a>
                        </li>

                        <!-- Diskon -->
                        <li class="nav-item">
                            <a href="{{ route('diskon.index') }}" class="nav-link {{ Request::is('diskon*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-percent"></i>
                                <p>Diskon</p>
                            </a>
                        </li>
                        @else
                        <!-- INVENTORY (Kasir - Limited) -->
                        <li class="nav-header" style="color: rgba(255,255,255,0.4); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; padding: 0.5rem 1rem; margin-top: 1rem;">
                            <i class="fas fa-boxes mr-2" style="font-size: 0.7rem;"></i>Inventory
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('produk.index') }}" class="nav-link {{ Request::is('produk*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-box-open"></i>
                                <p>Cek Stok Produk</p>
                            </a>
                        </li>
                        @endif

                        <!-- REPORTS -->
                        <li class="nav-header" style="color: rgba(255,255,255,0.4); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; padding: 0.5rem 1rem; margin-top: 1rem;">
                            <i class="fas fa-chart-bar mr-2" style="font-size: 0.7rem;"></i>Reports
                        </li>

                        <!-- Grafik Penjualan -->
                        <li class="nav-item">
                            <a href="{{ route('grafik.penjualan') }}" class="nav-link {{ Request::is('grafik-penjualan') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-chart-line"></i>
                                <p>
                                    Grafik Penjualan
                                    <span class="badge badge-info right" style="font-size: 0.65rem;">New</span>
                                </p>
                            </a>
                        </li>

                        <!-- Pusat Laporan -->
                        <li class="nav-item">
                            <a href="{{ route('laporan.index') }}" class="nav-link {{ Request::is('laporan') || Request::is('laporan/*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-file-alt"></i>
                                <p>
                                    Pusat Laporan
                                </p>
                            </a>
                        </li>

                        <li class="nav-item has-treeview {{ Request::is('pembelian/listData') || Request::is('penjualan/listData') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ Request::is('pembelian/listData') || Request::is('penjualan/listData') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-file-invoice"></i>
                                <p>
                                    Data Transaksi
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('penjualan.listData') }}" class="nav-link {{ Request::is('penjualan/listData') ? 'active' : '' }}" style="padding-left: 3rem;">
                                        <i class="far fa-dot-circle nav-icon" style="font-size: 0.5rem;"></i>
                                        <p>Data Penjualan</p>
                                    </a>
                                </li>
                                @if(Auth::user()->hasRole('admin'))
                                <li class="nav-item">
                                    <a href="{{ route('pembelian.listData') }}" class="nav-link {{ Request::is('pembelian/listData') ? 'active' : '' }}" style="padding-left: 3rem;">
                                        <i class="far fa-dot-circle nav-icon" style="font-size: 0.5rem;"></i>
                                        <p>Data Pembelian</p>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>

                        @if(Auth::user()->hasRole('admin'))
                        <!-- SYSTEM SETTINGS -->
                        <li class="nav-header" style="color: rgba(255,255,255,0.4); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; padding: 0.5rem 1rem; margin-top: 1rem;">
                            <i class="fas fa-cog mr-2" style="font-size: 0.7rem;"></i>System
                        </li>

                        <!-- Settings -->
                        <li class="nav-item has-treeview {{ Request::is('users*') || Request::is('tipe*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ Request::is('users*') || Request::is('tipe*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-sliders-h"></i>
                                <p>
                                    Pengaturan
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('users.index') }}" class="nav-link {{ Request::is('users*') ? 'active' : '' }}" style="padding-left: 3rem;">
                                        <i class="far fa-dot-circle nav-icon" style="font-size: 0.5rem;"></i>
                                        <p>Pengguna</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('tipe.index') }}" class="nav-link {{ Request::is('tipe*') ? 'active' : '' }}" style="padding-left: 3rem;">
                                        <i class="far fa-dot-circle nav-icon" style="font-size: 0.5rem;"></i>
                                        <p>Tipe Pembelian</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif

                        <!-- ACCOUNT -->
                        <li class="nav-header" style="color: rgba(255,255,255,0.4); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; padding: 0.5rem 1rem; margin-top: 1rem;">
                            <i class="fas fa-user-circle mr-2" style="font-size: 0.7rem;"></i>Account
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('profile.index') }}" class="nav-link {{ Request::is('profile*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-cog"></i>
                                <p>Profil Saya</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: #f5576c;">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>Logout</p>
                            </a>
                        </li>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            @yield('page-bar')
                        </div>
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                @yield('contents')
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
        <footer class="main-footer">
            <strong>Copyright &copy; <a href="#" style="color: #0d6efd;">POS System</a>.</strong>
            All rights reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('adminlte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('adminlte/plugins/chart.js/Chart.min.js')}}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('adminlte/plugins/sparklines/sparkline.js')}}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('adminlte/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
    <script src="{{ asset('adminlte/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('adminlte/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('adminlte/plugins/moment/moment.min.js')}}"></script>
    <script src="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.js')}}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
    <!-- Summernote -->
    <script src="{{ asset('adminlte/plugins/summernote/summernote-bs4.min.js')}}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/dist/js/adminlte.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('adminlte/dist/js/pages/dashboard.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('adminlte/dist/js/demo.js') }}"></script>
    {{-- Cropper JS --}}
    <script src="{{ asset('js/cropper/cropper.min.js') }}"></script>

    {{-- Datatables Fix --}}
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.3/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/responsive.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

    <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        if ($('.datatable-basic').length) {
            $('.datatable-basic').DataTable();
        }
        if ($('.datatable-not-paginate').length) {
            $('.datatable-not-paginate').DataTable({
                paginate: false
            });
        }

        function load_modal(token, url, modal) {
            $(modal).modal('show');
            $(modal + 'Title').html('Edit Permission');
            $(modal + 'Content').html(`<div class="d-flex justify-content-center align-items-center" style="height: 200px;"><div class="spinner-border text-primary" role="status"></div></div>`);
            var act = url;
            console.log(act);
            $.post(act, {
                    _token: token,
                },
                function(data) {
                    $(modal + 'Content').html(data);
                });
        }
    </script>

    <!-- Global App Utilities (Loader & SweetAlert) -->
    <script src="{{ asset('js/app-utilities.js') }}"></script>

    <!-- Global SweetAlert2 Configuration -->
    <script>
        // Configure SweetAlert2 defaults
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
                    // Show loader
                    LoaderUtil.show('Menghapus data...');
                    document.getElementById(formId).submit();
                }
            });
        }
    </script>

    @yield('javascript')
</body>

</html>