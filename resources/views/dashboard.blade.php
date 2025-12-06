@extends('layouts.adminlte')

@section('title', 'Dashboard')

@section('contents')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    Dashboard
                </h1>
            </div>
            <div class="col-sm-6">
                <div class="float-sm-right text-muted">
                    <i class="far fa-calendar me-2"></i>
                    {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
<!-- Statistics Cards -->
<div class="row row-cards mb-3">
    <div class="col-sm-6 col-lg-3">
        <div class="card card-sm">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="bg-blue text-white avatar">
                            <i class="fas fa-box"></i>
                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">
                            Total Produk
                        </div>
                        <div class="text-muted">
                            {{ number_format($totalProducts) }} items
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card card-sm">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="bg-red text-white avatar">
                            <i class="fas fa-exclamation-triangle"></i>
                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">
                            Stok Rendah
                        </div>
                        <div class="text-muted">
                            {{ number_format($lowStockProducts) }} produk
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card card-sm">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="bg-green text-white avatar">
                            <i class="fas fa-shopping-cart"></i>
                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">
                            Penjualan Hari Ini
                        </div>
                        <div class="text-muted">
                            {{ number_format($todaySales) }} transaksi
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card card-sm">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="bg-purple text-white avatar">
                            <i class="fas fa-money-bill-wave"></i>
                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">
                            Pendapatan Hari Ini
                        </div>
                        <div class="text-muted">
                            Rp {{ number_format($todayRevenue, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Row -->
<div class="row row-cards">
    <!-- Sales Chart -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Grafik Penjualan (7 Hari Terakhir)</h3>
            </div>
            <div class="card-body">
                <canvas id="salesChart" style="height: 300px;"></canvas>
            </div>
        </div>
    </div>

    <!-- Top Products -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Top 5 Produk</h3>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($topProducts as $index => $product)
                    <div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="badge bg-blue badge-pill">{{ $index + 1 }}</span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">{{ $product->nama }}</div>
                                <div class="text-muted small">{{ number_format($product->total_qty) }} terjual</div>
                            </div>
                            <div class="col-auto">
                                <div class="text-green font-weight-medium">
                                    Rp {{ number_format($product->total_revenue, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="list-group-item text-center text-muted">
                        <i class="fas fa-box-open fa-2x mb-2"></i>
                        <div>Belum ada data</div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Low Stock and Recent Sales -->
<div class="row row-cards mt-3">
    <!-- Low Stock Products -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Stok Rendah</h3>
                <div class="card-actions">
                    <a href="{{ route('produk.index') }}" class="btn btn-sm btn-primary">
                        Lihat Semua
                    </a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table card-table table-vcenter">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Kategori</th>
                            <th class="text-center">Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lowStockDetails as $product)
                        <tr>
                            <td>{{ $product->nama }}</td>
                            <td>
                                <span class="badge bg-azure-lt">{{ $product->kategori_nama }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-red-lt">{{ number_format($product->stok) }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">
                                <i class="fas fa-check-circle fa-2x mb-2"></i>
                                <div>Semua stok aman</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Sales -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Transaksi Terbaru</h3>
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
                            <th>Kasir</th>
                            <th>Total</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentSales as $sale)
                        <tr>
                            <td><span class="text-blue">#{{ $sale->idpenjualan }}</span></td>
                            <td>{{ $sale->user_name }}</td>
                            <td class="text-green">Rp {{ number_format($sale->total_harga, 0, ',', '.') }}</td>
                            <td class="text-muted">{{ \Carbon\Carbon::parse($sale->created_at)->format('H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                <i class="fas fa-shopping-cart fa-2x mb-2"></i>
                                <div>Belum ada transaksi</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    // Sales Chart
    const ctx = document.getElementById('salesChart').getContext('2d');
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(13, 110, 253, 0.3)');
    gradient.addColorStop(1, 'rgba(13, 110, 253, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($salesChartLabels),
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: @json($salesChartData),
                backgroundColor: gradient,
                borderColor: '#0d6efd',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#0d6efd',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#0d6efd',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    padding: 12,
                    borderColor: '#0d6efd',
                    borderWidth: 1,
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
</script>
@endsection
