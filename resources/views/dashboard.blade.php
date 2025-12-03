@extends('layouts.pos')

@section('title', 'Dashboard')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">Dashboard</h1>
    <div class="page-breadcrumb">
        <div class="breadcrumb-item">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </div>
    </div>
</div>

<!-- Welcome Card -->
<div class="card" style="background: linear-gradient(135deg, #4F46E5 0%, #6366F1 100%); color: white; margin-bottom: 2rem; border: none;">
    <div class="card-body" style="padding: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h2 style="color: white; font-size: 1.75rem; font-weight: 700; margin: 0 0 0.5rem 0;">
                    Selamat Datang, {{ Auth::user()->name }}! 👋
                </h2>
                <p style="color: rgba(255,255,255,0.9); margin: 0; font-size: 1rem;">
                    <i class="far fa-calendar-alt" style="margin-right: 0.5rem;"></i>
                    {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                </p>
            </div>
            <div style="text-align: right;">
                <div style="color: white; font-size: 2rem; font-weight: 700;" id="live-clock">
                    <i class="far fa-clock" style="margin-right: 0.5rem;"></i><span id="clock-time"></span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <!-- Total Products -->
    <div class="card" style="border-left: 4px solid #4F46E5;">
        <div class="card-body">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div style="flex: 1;">
                    <p style="color: #6B7280; font-size: 0.875rem; font-weight: 500; margin: 0 0 0.5rem 0; text-transform: uppercase;">Total Produk</p>
                    <h2 style="color: #1F2937; font-size: 2rem; font-weight: 700; margin: 0;">{{ number_format($totalProducts) }}</h2>
                </div>
                <div style="width: 48px; height: 48px; border-radius: 10px; background: rgba(79, 70, 229, 0.1); display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-box" style="font-size: 1.5rem; color: #4F46E5;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Low Stock -->
    <div class="card" style="border-left: 4px solid #EF4444;">
        <div class="card-body">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div style="flex: 1;">
                    <p style="color: #6B7280; font-size: 0.875rem; font-weight: 500; margin: 0 0 0.5rem 0; text-transform: uppercase;">Stok Rendah</p>
                    <h2 style="color: #1F2937; font-size: 2rem; font-weight: 700; margin: 0;">{{ number_format($lowStockProducts) }}</h2>
                </div>
                <div style="width: 48px; height: 48px; border-radius: 10px; background: rgba(239, 68, 68, 0.1); display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-exclamation-triangle" style="font-size: 1.5rem; color: #EF4444;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Sales -->
    <div class="card" style="border-left: 4px solid #3B82F6;">
        <div class="card-body">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div style="flex: 1;">
                    <p style="color: #6B7280; font-size: 0.875rem; font-weight: 500; margin: 0 0 0.5rem 0; text-transform: uppercase;">Penjualan Hari Ini</p>
                    <h2 style="color: #1F2937; font-size: 2rem; font-weight: 700; margin: 0;">{{ number_format($todaySales) }}</h2>
                </div>
                <div style="width: 48px; height: 48px; border-radius: 10px; background: rgba(59, 130, 246, 0.1); display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-shopping-cart" style="font-size: 1.5rem; color: #3B82F6;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Revenue -->
    <div class="card" style="border-left: 4px solid #10B981;">
        <div class="card-body">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div style="flex: 1;">
                    <p style="color: #6B7280; font-size: 0.875rem; font-weight: 500; margin: 0 0 0.5rem 0; text-transform: uppercase;">Pendapatan Hari Ini</p>
                    <h2 style="color: #1F2937; font-size: 2rem; font-weight: 700; margin: 0;">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</h2>
                </div>
                <div style="width: 48px; height: 48px; border-radius: 10px; background: rgba(16, 185, 129, 0.1); display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-money-bill-wave" style="font-size: 1.5rem; color: #10B981;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Month Sales -->
    <div class="card" style="border-left: 4px solid #8B5CF6;">
        <div class="card-body">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div style="flex: 1;">
                    <p style="color: #6B7280; font-size: 0.875rem; font-weight: 500; margin: 0 0 0.5rem 0; text-transform: uppercase;">Penjualan Bulan Ini</p>
                    <h2 style="color: #1F2937; font-size: 2rem; font-weight: 700; margin: 0;">{{ number_format($monthSales) }}</h2>
                </div>
                <div style="width: 48px; height: 48px; border-radius: 10px; background: rgba(139, 92, 246, 0.1); display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-chart-line" style="font-size: 1.5rem; color: #8B5CF6;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Month Revenue -->
    <div class="card" style="border-left: 4px solid #06B6D4;">
        <div class="card-body">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div style="flex: 1;">
                    <p style="color: #6B7280; font-size: 0.875rem; font-weight: 500; margin: 0 0 0.5rem 0; text-transform: uppercase;">Pendapatan Bulan Ini</p>
                    <h2 style="color: #1F2937; font-size: 2rem; font-weight: 700; margin: 0;">Rp {{ number_format($monthRevenue, 0, ',', '.') }}</h2>
                </div>
                <div style="width: 48px; height: 48px; border-radius: 10px; background: rgba(6, 182, 212, 0.1); display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-coins" style="font-size: 1.5rem; color: #06B6D4;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Users -->
    <div class="card" style="border-left: 4px solid #F59E0B;">
        <div class="card-body">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div style="flex: 1;">
                    <p style="color: #6B7280; font-size: 0.875rem; font-weight: 500; margin: 0 0 0.5rem 0; text-transform: uppercase;">Total Pengguna</p>
                    <h2 style="color: #1F2937; font-size: 2rem; font-weight: 700; margin: 0;">{{ number_format($totalUsers) }}</h2>
                </div>
                <div style="width: 48px; height: 48px; border-radius: 10px; background: rgba(245, 158, 11, 0.1); display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-users" style="font-size: 1.5rem; color: #F59E0B;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Sessions -->
    <div class="card" style="border-left: 4px solid #EC4899;">
        <div class="card-body">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div style="flex: 1;">
                    <p style="color: #6B7280; font-size: 0.875rem; font-weight: 500; margin: 0 0 0.5rem 0; text-transform: uppercase;">Total Sesi POS</p>
                    <h2 style="color: #1F2937; font-size: 2rem; font-weight: 700; margin: 0;">{{ number_format($activeSessions) }}</h2>
                </div>
                <div style="width: 48px; height: 48px; border-radius: 10px; background: rgba(236, 72, 153, 0.1); display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-cash-register" style="font-size: 1.5rem; color: #EC4899;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts and Tables -->
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
    <!-- Sales Chart -->
    <div class="card">
        <div class="card-header" style="background: white;">
            <h3 class="card-title">
                <i class="fas fa-chart-area" style="margin-right: 0.5rem;"></i>
                Grafik Penjualan (7 Hari Terakhir)
            </h3>
        </div>
        <div class="card-body">
            <canvas id="salesChart" style="max-height: 300px;"></canvas>
        </div>
    </div>

    <!-- Top Products -->
    <div class="card">
        <div class="card-header" style="background: white;">
            <h3 class="card-title">
                <i class="fas fa-trophy" style="margin-right: 0.5rem;"></i>
                Top 5 Produk
            </h3>
        </div>
        <div class="card-body" style="max-height: 400px; overflow-y: auto;">
            @forelse($topProducts as $index => $product)
                <div style="padding: 1rem; margin-bottom: 0.75rem; background: #F9FAFB; border-radius: 8px; border-left: 3px solid #4F46E5;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.25rem;">
                        <span style="font-weight: 700; color: #4F46E5; font-size: 0.875rem;">#{{ $index + 1 }}</span>
                        <span style="color: #10B981; font-weight: 600; font-size: 0.875rem;">
                            Rp {{ number_format($product->total_revenue, 0, ',', '.') }}
                        </span>
                    </div>
                    <div style="font-weight: 600; color: #1F2937; margin-bottom: 0.25rem;">{{ $product->nama }}</div>
                    <div style="color: #6B7280; font-size: 0.875rem;">
                        Terjual: <strong>{{ number_format($product->total_qty) }}</strong> unit
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 2rem; color: #9CA3AF;">
                    <i class="fas fa-box-open" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                    <p style="margin: 0;">Belum ada data penjualan</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Low Stock & Recent Sales -->
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
    <!-- Low Stock Products -->
    <div class="card">
        <div class="card-header" style="background: white;">
            <h3 class="card-title">
                <i class="fas fa-exclamation-circle" style="margin-right: 0.5rem; color: #EF4444;"></i>
                Produk Stok Rendah
            </h3>
        </div>
        <div class="card-body">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 2px solid #E5E7EB;">
                            <th style="padding: 0.75rem; text-align: left; font-size: 0.875rem; font-weight: 600; color: #6B7280;">Produk</th>
                            <th style="padding: 0.75rem; text-align: left; font-size: 0.875rem; font-weight: 600; color: #6B7280;">Kategori</th>
                            <th style="padding: 0.75rem; text-align: center; font-size: 0.875rem; font-weight: 600; color: #6B7280;">Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lowStockDetails as $product)
                            <tr style="border-bottom: 1px solid #F3F4F6;">
                                <td style="padding: 0.75rem; font-weight: 500; color: #1F2937;">{{ $product->nama }}</td>
                                <td style="padding: 0.75rem;">
                                    <span style="padding: 0.25rem 0.75rem; background: rgba(79, 70, 229, 0.1); color: #4F46E5; border-radius: 6px; font-size: 0.8125rem; font-weight: 500;">
                                        {{ $product->kategori_nama }}
                                    </span>
                                </td>
                                <td style="padding: 0.75rem; text-align: center;">
                                    <span style="padding: 0.375rem 0.75rem; background: #FEE2E2; color: #DC2626; border-radius: 6px; font-weight: 600; font-size: 0.875rem;">
                                        {{ number_format($product->stok) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" style="padding: 2rem; text-align: center; color: #9CA3AF;">
                                    <i class="fas fa-check-circle" style="font-size: 2rem; color: #10B981; margin-bottom: 0.5rem; display: block;"></i>
                                    Semua produk memiliki stok yang cukup
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Sales -->
    <div class="card">
        <div class="card-header" style="background: white;">
            <h3 class="card-title">
                <i class="fas fa-receipt" style="margin-right: 0.5rem; color: #3B82F6;"></i>
                Transaksi Terbaru
            </h3>
        </div>
        <div class="card-body">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 2px solid #E5E7EB;">
                            <th style="padding: 0.75rem; text-align: left; font-size: 0.875rem; font-weight: 600; color: #6B7280;">ID</th>
                            <th style="padding: 0.75rem; text-align: left; font-size: 0.875rem; font-weight: 600; color: #6B7280;">Kasir</th>
                            <th style="padding: 0.75rem; text-align: right; font-size: 0.875rem; font-weight: 600; color: #6B7280;">Total</th>
                            <th style="padding: 0.75rem; text-align: right; font-size: 0.875rem; font-weight: 600; color: #6B7280;">Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentSales as $sale)
                            <tr style="border-bottom: 1px solid #F3F4F6;">
                                <td style="padding: 0.75rem; font-weight: 600; color: #4F46E5;">#{{ $sale->idpenjualan }}</td>
                                <td style="padding: 0.75rem; color: #1F2937;">{{ $sale->user_name }}</td>
                                <td style="padding: 0.75rem; text-align: right; font-weight: 600; color: #10B981;">
                                    Rp {{ number_format($sale->total_harga, 0, ',', '.') }}
                                </td>
                                <td style="padding: 0.75rem; text-align: right; color: #6B7280; font-size: 0.875rem;">
                                    {{ \Carbon\Carbon::parse($sale->created_at)->format('d/m/Y H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="padding: 2rem; text-align: center; color: #9CA3AF;">
                                    <i class="fas fa-shopping-cart" style="font-size: 2rem; opacity: 0.3; margin-bottom: 0.5rem; display: block;"></i>
                                    Belum ada transaksi
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
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
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(79, 70, 229, 0.2)');
    gradient.addColorStop(1, 'rgba(79, 70, 229, 0.01)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($salesChartLabels),
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: @json($salesChartData),
                backgroundColor: gradient,
                borderColor: '#4F46E5',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#4F46E5',
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
                            size: 13,
                            family: 'Inter'
                        },
                        color: '#6B7280',
                        usePointStyle: true,
                        padding: 15
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(31, 41, 55, 0.9)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    padding: 12,
                    borderColor: '#4F46E5',
                    borderWidth: 1,
                    cornerRadius: 8,
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
                        },
                        color: '#9CA3AF',
                        font: {
                            size: 12,
                            family: 'Inter'
                        }
                    },
                    grid: {
                        color: '#F3F4F6',
                        drawBorder: false
                    }
                },
                x: {
                    ticks: {
                        color: '#9CA3AF',
                        font: {
                            size: 12,
                            family: 'Inter'
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
</script>
@endsection
