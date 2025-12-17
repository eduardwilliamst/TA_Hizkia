@extends('layouts.adminlte')

@section('title', 'Grafik Penjualan')

@section('style')
<style>
    .chart-container {
        position: relative;
        height: 350px;
    }
    .stat-card {
        border-radius: 10px;
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        transition: transform 0.2s ease;
    }
    .stat-card:hover {
        transform: translateY(-3px);
    }
    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    .filter-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
        color: white;
    }
    .filter-card .form-control, .filter-card .form-select {
        background: rgba(255,255,255,0.95);
        border: none;
        border-radius: 8px;
    }
    .chart-card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }
    .chart-card .card-header {
        background: transparent;
        border-bottom: 1px solid #eee;
        padding: 1rem 1.5rem;
    }
    .chart-card .card-title {
        font-weight: 600;
        color: #333;
        margin: 0;
    }
    .legend-item {
        display: inline-flex;
        align-items: center;
        margin-right: 15px;
        font-size: 0.85rem;
    }
    .legend-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin-right: 6px;
    }
</style>
@endsection

@section('contents')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">
                    <i class="fas fa-chart-line me-2" style="color: #667eea;"></i>
                    Grafik Penjualan
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Grafik Penjualan</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <!-- Filter Card -->
        <div class="card filter-card mb-4">
            <div class="card-body">
                <form action="{{ route('grafik.penjualan') }}" method="GET" class="row align-items-end">
                    <div class="col-md-3 mb-2 mb-md-0">
                        <label class="text-white mb-2"><i class="fas fa-calendar-alt mr-2"></i>Tahun</label>
                        <select name="year" class="form-control">
                            @foreach($availableYears as $year)
                                <option value="{{ $year }}" {{ $thisYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-2 mb-md-0">
                        <label class="text-white mb-2"><i class="fas fa-calendar-day mr-2"></i>Bulan (Perbandingan)</label>
                        <select name="month" class="form-control">
                            @foreach($monthNames as $index => $name)
                                <option value="{{ $index + 1 }}" {{ $selectedMonth == ($index + 1) ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-2 mb-md-0">
                        <label class="text-white mb-2"><i class="fas fa-box mr-2"></i>Produk</label>
                        <select name="product_id" class="form-control">
                            <option value="">Top 5 Produk</option>
                            @foreach($products as $product)
                                <option value="{{ $product->idproduk }}" {{ $selectedProductId == $product->idproduk ? 'selected' : '' }}>{{ $product->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-light btn-block" style="border-radius: 8px; font-weight: 600;">
                            <i class="fas fa-filter mr-2"></i>Terapkan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Summary Stats -->
        <div class="row mb-4">
            <div class="col-sm-6 col-lg-3 mb-3">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon mr-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <div>
                                <div class="text-muted small">Total Pendapatan {{ $thisYear }}</div>
                                <div class="h5 mb-0 font-weight-bold">Rp {{ number_format($totalYearRevenue, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-3">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon mr-3" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                                <i class="fas fa-coins"></i>
                            </div>
                            <div>
                                <div class="text-muted small">Total HPP {{ $thisYear }}</div>
                                <div class="h5 mb-0 font-weight-bold">Rp {{ number_format($totalYearHpp, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-3">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon mr-3" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white;">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div>
                                <div class="text-muted small">Total Laba {{ $thisYear }}</div>
                                <div class="h5 mb-0 font-weight-bold text-success">Rp {{ number_format($totalYearProfit, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-3">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon mr-3" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
                                <i class="fas fa-percentage"></i>
                            </div>
                            <div>
                                <div class="text-muted small">Margin Laba</div>
                                <div class="h5 mb-0 font-weight-bold" style="color: #4facfe;">{{ $profitMargin }}%</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row 1 -->
        <div class="row">
            <!-- Monthly Sales Chart -->
            <div class="col-lg-8 mb-4">
                <div class="card chart-card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">
                            <i class="fas fa-chart-area mr-2" style="color: #667eea;"></i>
                            Grafik Penjualan Bulanan Tahun {{ $thisYear }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="monthlyChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Year Comparison Chart -->
            <div class="col-lg-4 mb-4">
                <div class="card chart-card h-100">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-bar mr-2" style="color: #f5576c;"></i>
                            Perbandingan Bulan {{ $monthNames[$selectedMonth - 1] }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="comparisonChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row 2 -->
        <div class="row">
            <!-- Product Sales Chart -->
            <div class="col-lg-6 mb-4">
                <div class="card chart-card h-100">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-box mr-2" style="color: #43e97b;"></i>
                            Penjualan Produk: {{ $selectedProductName }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="productChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- HPP vs Revenue Chart -->
            <div class="col-lg-6 mb-4">
                <div class="card chart-card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">
                            <i class="fas fa-balance-scale mr-2" style="color: #4facfe;"></i>
                            Penjualan vs HPP vs Laba
                        </h3>
                        <div>
                            <span class="legend-item"><span class="legend-dot" style="background: #667eea;"></span>Pendapatan</span>
                            <span class="legend-item"><span class="legend-dot" style="background: #f5576c;"></span>HPP</span>
                            <span class="legend-item"><span class="legend-dot" style="background: #43e97b;"></span>Laba</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="hppChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Format currency helper
    function formatRupiah(value) {
        return 'Rp ' + value.toLocaleString('id-ID');
    }

    // 1. Monthly Sales Chart
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    const monthlyGradient = monthlyCtx.createLinearGradient(0, 0, 0, 350);
    monthlyGradient.addColorStop(0, 'rgba(102, 126, 234, 0.4)');
    monthlyGradient.addColorStop(1, 'rgba(102, 126, 234, 0)');

    new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: @json($monthlyLabels),
            datasets: [{
                label: 'Pendapatan',
                data: @json($monthlyRevenue),
                backgroundColor: monthlyGradient,
                borderColor: '#667eea',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#667eea',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#667eea',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    padding: 12,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            return formatRupiah(context.parsed.y);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return formatRupiah(value);
                        }
                    },
                    grid: { color: 'rgba(0, 0, 0, 0.05)' }
                },
                x: { grid: { display: false } }
            }
        }
    });

    // 2. Year Comparison Chart
    const comparisonCtx = document.getElementById('comparisonChart').getContext('2d');
    new Chart(comparisonCtx, {
        type: 'bar',
        data: {
            labels: @json($comparisonYears),
            datasets: [{
                label: 'Pendapatan',
                data: @json($comparisonData),
                backgroundColor: [
                    'rgba(245, 87, 108, 0.8)',
                    'rgba(102, 126, 234, 0.8)',
                    'rgba(67, 233, 123, 0.8)',
                    'rgba(79, 172, 254, 0.8)',
                    'rgba(240, 147, 251, 0.8)'
                ],
                borderColor: [
                    '#f5576c',
                    '#667eea',
                    '#43e97b',
                    '#4facfe',
                    '#f093fb'
                ],
                borderWidth: 2,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#f5576c',
                    callbacks: {
                        label: function(context) {
                            return formatRupiah(context.parsed.y);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            if (value >= 1000000) {
                                return 'Rp ' + (value / 1000000).toFixed(1) + 'jt';
                            }
                            return formatRupiah(value);
                        }
                    },
                    grid: { color: 'rgba(0, 0, 0, 0.05)' }
                },
                x: { grid: { display: false } }
            }
        }
    });

    // 3. Product Sales Chart
    const productCtx = document.getElementById('productChart').getContext('2d');
    @if($selectedProductId)
    // Single product line chart
    const productGradient = productCtx.createLinearGradient(0, 0, 0, 350);
    productGradient.addColorStop(0, 'rgba(67, 233, 123, 0.4)');
    productGradient.addColorStop(1, 'rgba(67, 233, 123, 0)');

    new Chart(productCtx, {
        type: 'line',
        data: {
            labels: @json($productMonthlyLabels),
            datasets: [{
                label: '{{ $selectedProductName }}',
                data: @json($productMonthlyData),
                backgroundColor: productGradient,
                borderColor: '#43e97b',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#43e97b',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#43e97b',
                    callbacks: {
                        label: function(context) {
                            return formatRupiah(context.parsed.y);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return formatRupiah(value);
                        }
                    },
                    grid: { color: 'rgba(0, 0, 0, 0.05)' }
                },
                x: { grid: { display: false } }
            }
        }
    });
    @else
    // Multiple products bar chart
    const productColors = [
        { bg: 'rgba(102, 126, 234, 0.8)', border: '#667eea' },
        { bg: 'rgba(245, 87, 108, 0.8)', border: '#f5576c' },
        { bg: 'rgba(67, 233, 123, 0.8)', border: '#43e97b' },
        { bg: 'rgba(79, 172, 254, 0.8)', border: '#4facfe' },
        { bg: 'rgba(240, 147, 251, 0.8)', border: '#f093fb' }
    ];

    const productDatasets = @json($productMonthlyData).map((product, index) => ({
        label: product.name,
        data: product.data,
        backgroundColor: productColors[index % productColors.length].bg,
        borderColor: productColors[index % productColors.length].border,
        borderWidth: 2,
        borderRadius: 4
    }));

    new Chart(productCtx, {
        type: 'bar',
        data: {
            labels: @json($productMonthlyLabels),
            datasets: productDatasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 15
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + formatRupiah(context.parsed.y);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    stacked: false,
                    ticks: {
                        callback: function(value) {
                            if (value >= 1000000) {
                                return 'Rp ' + (value / 1000000).toFixed(1) + 'jt';
                            }
                            return formatRupiah(value);
                        }
                    },
                    grid: { color: 'rgba(0, 0, 0, 0.05)' }
                },
                x: {
                    stacked: false,
                    grid: { display: false }
                }
            }
        }
    });
    @endif

    // 4. HPP vs Revenue vs Profit Chart
    const hppCtx = document.getElementById('hppChart').getContext('2d');
    new Chart(hppCtx, {
        type: 'bar',
        data: {
            labels: @json($hppLabels),
            datasets: [
                {
                    label: 'Pendapatan',
                    data: @json($revenueData),
                    backgroundColor: 'rgba(102, 126, 234, 0.8)',
                    borderColor: '#667eea',
                    borderWidth: 2,
                    borderRadius: 4,
                    order: 2
                },
                {
                    label: 'HPP',
                    data: @json($hppData),
                    backgroundColor: 'rgba(245, 87, 108, 0.8)',
                    borderColor: '#f5576c',
                    borderWidth: 2,
                    borderRadius: 4,
                    order: 3
                },
                {
                    label: 'Laba',
                    data: @json($profitData),
                    type: 'line',
                    backgroundColor: 'rgba(67, 233, 123, 0.2)',
                    borderColor: '#43e97b',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#43e97b',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 8,
                    order: 1
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index'
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    padding: 12,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + formatRupiah(context.parsed.y);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            if (value >= 1000000) {
                                return 'Rp ' + (value / 1000000).toFixed(1) + 'jt';
                            }
                            return formatRupiah(value);
                        }
                    },
                    grid: { color: 'rgba(0, 0, 0, 0.05)' }
                },
                x: { grid: { display: false } }
            }
        }
    });
});
</script>
@endsection
