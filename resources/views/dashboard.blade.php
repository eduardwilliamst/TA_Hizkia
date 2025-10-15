@extends('layouts.adminlte')

@section('title')
Dashboard
@endsection

@section('page-bar')
<h1 class="m-0">Dashboard</h1>
@endsection

@section('contents')
<div class="content">
    <div class="container-fluid">
        <!-- Welcome Banner -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card animate-fade-in-up" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px; border: none; box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3);">
                    <div class="card-body" style="padding: 2rem;">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h2 style="color: white; font-weight: 700; margin-bottom: 0.5rem;">
                                    Selamat Datang, {{ Auth::user()->name }}!
                                </h2>
                                <p style="color: rgba(255,255,255,0.9); margin-bottom: 0; font-size: 1.1rem;">
                                    <i class="far fa-calendar-alt mr-2"></i>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                                </p>
                            </div>
                            <div class="col-md-4 text-right">
                                <div style="color: white; font-size: 2.5rem; font-weight: 700;" id="live-clock">
                                    <i class="far fa-clock mr-2"></i><span id="clock-time"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row">
            <!-- Total Products -->
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="card animate-fade-in-up" style="border-radius: 15px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: transform 0.3s ease;">
                    <div class="card-body" style="padding: 1.5rem;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 style="color: #666; font-weight: 600; margin-bottom: 0.5rem; text-transform: uppercase; font-size: 0.85rem;">Total Produk</h6>
                                <h2 style="color: #667eea; font-weight: 700; margin-bottom: 0;">{{ number_format($totalProducts) }}</h2>
                            </div>
                            <div style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-box" style="font-size: 1.8rem; color: white;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Low Stock Products -->
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="card animate-fade-in-up" style="border-radius: 15px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: transform 0.3s ease;">
                    <div class="card-body" style="padding: 1.5rem;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 style="color: #666; font-weight: 600; margin-bottom: 0.5rem; text-transform: uppercase; font-size: 0.85rem;">Stok Rendah</h6>
                                <h2 style="color: #f093fb; font-weight: 700; margin-bottom: 0;">{{ number_format($lowStockProducts) }}</h2>
                            </div>
                            <div style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-exclamation-triangle" style="font-size: 1.8rem; color: white;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Today's Sales -->
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="card animate-fade-in-up" style="border-radius: 15px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: transform 0.3s ease;">
                    <div class="card-body" style="padding: 1.5rem;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 style="color: #666; font-weight: 600; margin-bottom: 0.5rem; text-transform: uppercase; font-size: 0.85rem;">Penjualan Hari Ini</h6>
                                <h2 style="color: #4facfe; font-weight: 700; margin-bottom: 0;">{{ number_format($todaySales) }}</h2>
                            </div>
                            <div style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-shopping-cart" style="font-size: 1.8rem; color: white;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Today's Revenue -->
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="card animate-fade-in-up" style="border-radius: 15px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: transform 0.3s ease;">
                    <div class="card-body" style="padding: 1.5rem;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 style="color: #666; font-weight: 600; margin-bottom: 0.5rem; text-transform: uppercase; font-size: 0.85rem;">Pendapatan Hari Ini</h6>
                                <h2 style="color: #43e97b; font-weight: 700; margin-bottom: 0;">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</h2>
                            </div>
                            <div style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-money-bill-wave" style="font-size: 1.8rem; color: white;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Month Sales -->
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="card animate-fade-in-up" style="border-radius: 15px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: transform 0.3s ease;">
                    <div class="card-body" style="padding: 1.5rem;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 style="color: #666; font-weight: 600; margin-bottom: 0.5rem; text-transform: uppercase; font-size: 0.85rem;">Penjualan Bulan Ini</h6>
                                <h2 style="color: #fa709a; font-weight: 700; margin-bottom: 0;">{{ number_format($monthSales) }}</h2>
                            </div>
                            <div style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-chart-line" style="font-size: 1.8rem; color: white;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Month Revenue -->
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="card animate-fade-in-up" style="border-radius: 15px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: transform 0.3s ease;">
                    <div class="card-body" style="padding: 1.5rem;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 style="color: #666; font-weight: 600; margin-bottom: 0.5rem; text-transform: uppercase; font-size: 0.85rem;">Pendapatan Bulan Ini</h6>
                                <h2 style="color: #30cfd0; font-weight: 700; margin-bottom: 0;">Rp {{ number_format($monthRevenue, 0, ',', '.') }}</h2>
                            </div>
                            <div style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #30cfd0 0%, #330867 100%); display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-coins" style="font-size: 1.8rem; color: white;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Users -->
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="card animate-fade-in-up" style="border-radius: 15px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: transform 0.3s ease;">
                    <div class="card-body" style="padding: 1.5rem;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 style="color: #666; font-weight: 600; margin-bottom: 0.5rem; text-transform: uppercase; font-size: 0.85rem;">Total Pengguna</h6>
                                <h2 style="color: #a8edea; font-weight: 700; margin-bottom: 0;">{{ number_format($totalUsers) }}</h2>
                            </div>
                            <div style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-users" style="font-size: 1.8rem; color: white;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Sessions -->
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="card animate-fade-in-up" style="border-radius: 15px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: transform 0.3s ease;">
                    <div class="card-body" style="padding: 1.5rem;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 style="color: #666; font-weight: 600; margin-bottom: 0.5rem; text-transform: uppercase; font-size: 0.85rem;">Total Sesi POS</h6>
                                <h2 style="color: #ff9a56; font-weight: 700; margin-bottom: 0;">{{ number_format($activeSessions) }}</h2>
                            </div>
                            <div style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #ff9a56 0%, #ff6a88 100%); display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-cash-register" style="font-size: 1.8rem; color: white;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts and Tables Row -->
        <div class="row">
            <!-- Sales Chart -->
            <div class="col-lg-8 mb-4">
                <div class="card animate-fade-in-up" style="border-radius: 15px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                    <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px 15px 0 0; padding: 1.5rem;">
                        <h3 class="mb-0">
                            <i class="fas fa-chart-area mr-2"></i>
                            Grafik Penjualan (7 Hari Terakhir)
                        </h3>
                    </div>
                    <div class="card-body" style="padding: 2rem;">
                        <canvas id="salesChart" style="max-height: 300px;"></canvas>
                    </div>
                </div>
            </div>

            <!-- Top Products -->
            <div class="col-lg-4 mb-4">
                <div class="card animate-fade-in-up" style="border-radius: 15px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                    <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px 15px 0 0; padding: 1.5rem;">
                        <h3 class="mb-0">
                            <i class="fas fa-trophy mr-2"></i>
                            Top 5 Produk
                        </h3>
                    </div>
                    <div class="card-body" style="padding: 1.5rem;">
                        @forelse($topProducts as $index => $product)
                            <div style="padding: 1rem; margin-bottom: 1rem; background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%); border-radius: 10px; border-left: 4px solid #667eea;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div style="flex: 1;">
                                        <div style="font-weight: 700; color: #667eea; font-size: 1.2rem; margin-bottom: 0.25rem;">
                                            #{{ $index + 1 }} {{ $product->nama }}
                                        </div>
                                        <div style="color: #666; font-size: 0.9rem;">
                                            Terjual: <strong>{{ number_format($product->total_qty) }}</strong> unit
                                        </div>
                                    </div>
                                    <div style="text-align: right;">
                                        <div style="color: #43e97b; font-weight: 700; font-size: 1rem;">
                                            Rp {{ number_format($product->total_revenue, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center" style="padding: 2rem; color: #999;">
                                <i class="fas fa-box-open" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                                <p>Belum ada data penjualan bulan ini</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Low Stock Products -->
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card animate-fade-in-up" style="border-radius: 15px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                    <div class="card-header" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; border-radius: 15px 15px 0 0; padding: 1.5rem;">
                        <h3 class="mb-0">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            Produk Stok Rendah
                        </h3>
                    </div>
                    <div class="card-body" style="padding: 1.5rem;">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th style="border: none; color: #666; font-weight: 600;">Produk</th>
                                        <th style="border: none; color: #666; font-weight: 600;">Kategori</th>
                                        <th style="border: none; color: #666; font-weight: 600; text-align: center;">Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($lowStockDetails as $product)
                                        <tr>
                                            <td style="font-weight: 600; color: #333;">{{ $product->nama }}</td>
                                            <td>
                                                <span class="badge" style="padding: 0.4rem 0.8rem; border-radius: 10px; background: linear-gradient(135deg, rgba(102, 126, 234, 0.2) 0%, rgba(118, 75, 162, 0.2) 100%); color: #667eea; font-weight: 600;">
                                                    {{ $product->kategori_nama }}
                                                </span>
                                            </td>
                                            <td style="text-align: center;">
                                                <span class="badge badge-danger" style="padding: 0.4rem 0.8rem; border-radius: 10px; font-weight: 600; font-size: 0.9rem;">
                                                    {{ number_format($product->stok) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center" style="padding: 2rem; color: #999;">
                                                <i class="fas fa-check-circle" style="font-size: 2rem; color: #43e97b; margin-bottom: 0.5rem;"></i>
                                                <p class="mb-0">Semua produk memiliki stok yang cukup</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Sales -->
            <div class="col-lg-6 mb-4">
                <div class="card animate-fade-in-up" style="border-radius: 15px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                    <div class="card-header" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; border-radius: 15px 15px 0 0; padding: 1.5rem;">
                        <h3 class="mb-0">
                            <i class="fas fa-receipt mr-2"></i>
                            Transaksi Terbaru
                        </h3>
                    </div>
                    <div class="card-body" style="padding: 1.5rem;">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th style="border: none; color: #666; font-weight: 600;">ID</th>
                                        <th style="border: none; color: #666; font-weight: 600;">Kasir</th>
                                        <th style="border: none; color: #666; font-weight: 600;">Total</th>
                                        <th style="border: none; color: #666; font-weight: 600;">Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentSales as $sale)
                                        <tr>
                                            <td style="font-weight: 700; color: #667eea;">#{{ $sale->idpenjualan }}</td>
                                            <td style="color: #333;">{{ $sale->user_name }}</td>
                                            <td style="font-weight: 600; color: #43e97b;">Rp {{ number_format($sale->total_harga, 0, ',', '.') }}</td>
                                            <td style="color: #666; font-size: 0.9rem;">{{ \Carbon\Carbon::parse($sale->created_at)->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center" style="padding: 2rem; color: #999;">
                                                <i class="fas fa-shopping-cart" style="font-size: 2rem; opacity: 0.3; margin-bottom: 0.5rem;"></i>
                                                <p class="mb-0">Belum ada transaksi</p>
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
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    // Live Clock
    function updateClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        document.getElementById('clock-time').textContent = `${hours}:${minutes}:${seconds}`;
    }
    updateClock();
    setInterval(updateClock, 1000);

    // Sales Chart
    const ctx = document.getElementById('salesChart').getContext('2d');
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(102, 126, 234, 0.4)');
    gradient.addColorStop(1, 'rgba(118, 75, 162, 0.1)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($salesChartLabels),
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: @json($salesChartData),
                backgroundColor: gradient,
                borderColor: '#667eea',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#667eea',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: true,
                    labels: {
                        font: {
                            size: 14,
                            weight: 'bold'
                        },
                        color: '#333'
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(102, 126, 234, 0.9)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    padding: 12,
                    borderColor: '#667eea',
                    borderWidth: 1,
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                            return label;
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
                        },
                        color: '#666',
                        font: {
                            size: 12
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                        drawBorder: false
                    }
                },
                x: {
                    ticks: {
                        color: '#666',
                        font: {
                            size: 12
                        }
                    },
                    grid: {
                        display: false,
                        drawBorder: false
                    }
                }
            }
        }
    });

    // Card Hover Effects
    document.querySelectorAll('.card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
</script>
@endpush
@endsection
