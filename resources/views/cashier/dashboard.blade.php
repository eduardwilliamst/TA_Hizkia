@extends('layouts.adminlte')

@section('title', 'Cashier Dashboard')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">
                    <i class="fas fa-cash-register me-2"></i>
                    Dashboard Kasir
                </h1>
            </div>
            <div class="col-sm-6">
                <div class="float-sm-right">
                    <a href="{{ route('penjualan.index') }}" class="btn btn-primary">
                        <i class="fas fa-shopping-cart me-2"></i>
                        Transaksi Baru
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
<!-- Statistics Cards -->
<div class="row row-cards mb-3">
    <div class="col-sm-6 col-lg-4">
        <div class="card card-sm">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        @if($posSession)
                        <span class="bg-green text-white avatar">
                            <i class="fas fa-check-circle"></i>
                        </span>
                        @else
                        <span class="bg-red text-white avatar">
                            <i class="fas fa-times-circle"></i>
                        </span>
                        @endif
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">Status Sesi</div>
                        @if($posSession)
                        <div class="text-muted">Aktif sejak {{ \Carbon\Carbon::parse($posSession->tanggal)->format('H:i') }}</div>
                        @else
                        <div class="text-muted">Tidak ada sesi aktif</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-4">
        <div class="card card-sm">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="bg-blue text-white avatar">
                            <i class="fas fa-shopping-cart"></i>
                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">Penjualan Hari Ini</div>
                        <div class="text-muted">{{ number_format($todaySales) }} transaksi</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-4">
        <div class="card card-sm">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="bg-purple text-white avatar">
                            <i class="fas fa-money-bill-wave"></i>
                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">Pendapatan Hari Ini</div>
                        <div class="text-muted">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="row row-cards">
    <!-- Recent Transactions -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Transaksi Terakhir Saya</h3>
                <div class="card-actions">
                    <a href="{{ route('penjualan.listData') }}" class="btn btn-sm btn-primary">
                        Lihat Semua
                    </a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table card-table table-vcenter">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Total</th>
                            <th>Metode</th>
                            <th>Waktu</th>
                            <th class="w-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentSales as $sale)
                        <tr style="cursor: pointer;" onclick="window.location='{{ route('penjualan.show', $sale->idpenjualan) }}'">
                            <td><span class="text-blue">#{{ str_pad($sale->idpenjualan, 5, '0', STR_PAD_LEFT) }}</span></td>
                            <td class="text-green">Rp {{ number_format($sale->total_harga, 0, ',', '.') }}</td>
                            <td>
                                @if($sale->metode_pembayaran == 'cash')
                                <span class="badge bg-green-lt">
                                    <i class="fas fa-money-bill-wave me-1"></i>Cash
                                </span>
                                @else
                                <span class="badge bg-blue-lt">
                                    <i class="fas fa-credit-card me-1"></i>Non-Cash
                                </span>
                                @endif
                            </td>
                            <td class="text-muted">{{ \Carbon\Carbon::parse($sale->created_at)->format('H:i') }}</td>
                            <td>
                                <a href="{{ route('penjualan.show', $sale->idpenjualan) }}" class="btn btn-sm btn-ghost-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="fas fa-shopping-cart fa-2x mb-2"></i>
                                <div>Belum ada transaksi hari ini</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Low Stock -->
    <div class="col-lg-4">
        <!-- Quick Actions -->
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title">Aksi Cepat</h3>
            </div>
            <div class="list-group list-group-flush">
                <a href="{{ route('penjualan.index') }}" class="list-group-item list-group-item-action">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="avatar" style="background-image: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                                <i class="fas fa-shopping-cart text-white"></i>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium">Transaksi Baru</div>
                            <div class="text-muted small">Mulai transaksi penjualan</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chevron-right text-muted"></i>
                        </div>
                    </div>
                </a>

                <a href="{{ route('penjualan.viewCart') }}" class="list-group-item list-group-item-action">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="bg-blue text-white avatar">
                                <i class="fas fa-shopping-basket"></i>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium">Lihat Keranjang</div>
                            <div class="text-muted small">Cek keranjang belanja</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chevron-right text-muted"></i>
                        </div>
                    </div>
                </a>

                <a href="{{ route('produk.index') }}" class="list-group-item list-group-item-action">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="avatar" style="background-image: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                                <i class="fas fa-box text-white"></i>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium">Cek Stok Produk</div>
                            <div class="text-muted small">Lihat ketersediaan produk</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chevron-right text-muted"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Low Stock Alert -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Stok Rendah</h3>
            </div>
            <div class="list-group list-group-flush">
                @forelse($lowStockProducts->take(5) as $product)
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="avatar avatar-sm" style="background-color: rgba(var(--tblr-danger-rgb), 0.1); color: var(--tblr-danger);">
                                <i class="fas fa-exclamation-triangle"></i>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium">{{ $product->nama }}</div>
                            <div class="text-muted small">{{ $product->kategori_nama }}</div>
                        </div>
                        <div class="col-auto">
                            <span class="badge bg-red-lt">{{ number_format($product->stok) }}</span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="list-group-item text-center text-muted">
                    <i class="fas fa-check-circle fa-2x mb-2"></i>
                    <div>Semua stok aman</div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
    </div>
</div>
@endsection
