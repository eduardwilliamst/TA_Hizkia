@extends('layouts.adminlte')

@section('title', 'Laporan Penjualan')

@section('contents')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Laporan Penjualan</h1>
            <p class="text-muted mb-0">Periode: {{ $periode }}</p>
        </div>
        <div>
            <a href="{{ route('laporan.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
            <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print mr-2"></i>Cetak Laporan
            </button>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Transaksi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalTransaksi) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-receipt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Pendapatan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Item Terjual</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalItem) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Rata-rata per Transaksi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($avgPerTransaksi, 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calculator fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <!-- Payment Method Chart -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Metode Pembayaran</h6>
                </div>
                <div class="card-body">
                    @if($cashTotal > 0 || $creditTotal > 0)
                    <div class="chart-container" style="position: relative; height:300px;">
                        <canvas id="paymentMethodChart"></canvas>
                    </div>
                    <div class="mt-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span><i class="fas fa-money-bill-wave text-success"></i> Cash</span>
                            <span class="font-weight-bold">Rp {{ number_format($cashTotal, 0, ',', '.') }} ({{ $cashTransaksi }} transaksi)</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span><i class="fas fa-credit-card text-info"></i> Credit</span>
                            <span class="font-weight-bold">Rp {{ number_format($creditTotal, 0, ',', '.') }} ({{ $creditTransaksi }} transaksi)</span>
                        </div>
                    </div>
                    @else
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-chart-pie fa-3x mb-3 opacity-50"></i>
                        <p>Tidak ada data transaksi untuk periode ini</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Top Products Chart -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Top 10 Produk Terlaris</h6>
                </div>
                <div class="card-body">
                    @if(!empty($topProducts) && count($topProducts) > 0)
                    <div class="chart-container" style="position: relative; height:300px;">
                        <canvas id="topProductsChart"></canvas>
                    </div>
                    @else
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-chart-bar fa-3x mb-3 opacity-50"></i>
                        <p>Tidak ada data produk untuk periode ini</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if(!empty($kasirPerformance) && count($kasirPerformance) > 0)
    <!-- Kasir Performance -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Performa Kasir</h6>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height:300px;">
                        <canvas id="kasirPerformanceChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Top Products Table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Detail Top 10 Produk Terlaris</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Produk</th>
                                    <th>Qty Terjual</th>
                                    <th>Total Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topProducts as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->produk->nama ?? 'N/A' }}</td>
                                    <td>{{ number_format($item->total_qty) }}</td>
                                    <td>Rp {{ number_format($item->total_revenue, 0, ',', '.') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada data</td>
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

@section('javascript')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    // Wait for DOM to be fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Chart.js loaded:', typeof Chart !== 'undefined');

        // Payment Method Chart
        const paymentCanvas = document.getElementById('paymentMethodChart');
        if (paymentCanvas) {
            console.log('Payment chart canvas found');
            const paymentCtx = paymentCanvas.getContext('2d');
            new Chart(paymentCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Cash', 'Credit'],
                    datasets: [{
                        data: [{{ $cashTotal }}, {{ $creditTotal }}],
                        backgroundColor: ['#28a745', '#17a2b8'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    label += 'Rp ' + context.parsed.toLocaleString('id-ID');
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        }

        // Top Products Chart
        const topProductsCanvas = document.getElementById('topProductsChart');
        if (topProductsCanvas) {
            const topProductsCtx = topProductsCanvas.getContext('2d');
            new Chart(topProductsCtx, {
                type: 'bar',
                data: {
                    labels: [
                        @foreach($topProducts as $item)
                            '{{ Str::limit($item->produk->nama ?? "N/A", 15) }}',
                        @endforeach
                    ],
                    datasets: [{
                        label: 'Pendapatan (Rp)',
                        data: [
                            @foreach($topProducts as $item)
                                {{ $item->total_revenue }},
                            @endforeach
                        ],
                        backgroundColor: '#4e73df',
                        borderColor: '#4e73df',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });
        }

        @if(!empty($kasirPerformance) && count($kasirPerformance) > 0)
        // Kasir Performance Chart
        const kasirCanvas = document.getElementById('kasirPerformanceChart');
        if (kasirCanvas) {
            const kasirCtx = kasirCanvas.getContext('2d');
            new Chart(kasirCtx, {
                type: 'bar',
                data: {
                    labels: [
                        @foreach($kasirPerformance as $kasir)
                            '{{ $kasir["name"] }}',
                        @endforeach
                    ],
                    datasets: [{
                        label: 'Total Penjualan (Rp)',
                        data: [
                            @foreach($kasirPerformance as $kasir)
                                {{ $kasir["total"] }},
                            @endforeach
                        ],
                        backgroundColor: '#1cc88a',
                        borderColor: '#1cc88a',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });
        }
        @endif
    });
</script>

<style>
    @media print {
        /* Hide navigation elements */
        .btn, .sidebar, .navbar, .card-header .dropdown, .main-sidebar, .main-header {
            display: none !important;
        }

        /* Adjust main content for print */
        .content-wrapper {
            margin-left: 0 !important;
            margin-top: 0 !important;
        }

        /* Prevent page breaks inside cards */
        .card {
            page-break-inside: avoid;
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }

        /* Ensure charts print properly */
        canvas {
            max-height: 300px;
            width: 100% !important;
            height: auto !important;
        }

        .chart-container {
            page-break-inside: avoid;
        }

        /* Optimize text for print */
        body {
            font-size: 12pt;
            color: #000;
        }

        /* Add page breaks between sections */
        .row {
            page-break-inside: avoid;
        }
    }

    /* Loading indicator for charts */
    .chart-loading {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 300px;
        color: #999;
    }
</style>
@endsection
