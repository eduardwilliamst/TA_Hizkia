@extends('layouts.adminlte')

@section('title', 'Laporan Laba Rugi')

@section('contents')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Laporan Laba Rugi</h1>
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
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Pendapatan</div>
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
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">HPP</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($hpp, 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-boxes fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Laba Bersih</div>
                            <div class="h5 mb-0 font-weight-bold {{ $labaBersih >= 0 ? 'text-success' : 'text-danger' }}">
                                Rp {{ number_format($labaBersih, 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Margin Laba</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($marginLaba, 2) }}%</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-percentage fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Profit Statement -->
    <div class="row mb-4">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Ringkasan Laba Rugi</h6>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <td>Pendapatan Kotor</td>
                            <td class="text-right">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Total Diskon</td>
                            <td class="text-right text-danger">- Rp {{ number_format($totalDiskon, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="table-secondary">
                            <th>Pendapatan Bersih</th>
                            <th class="text-right">Rp {{ number_format($pendapatanBersih, 0, ',', '.') }}</th>
                        </tr>
                        <tr>
                            <td>Harga Pokok Penjualan (HPP)</td>
                            <td class="text-right text-danger">- Rp {{ number_format($hpp, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="table-{{ $labaBersih >= 0 ? 'success' : 'danger' }}">
                            <th>Laba Bersih</th>
                            <th class="text-right">Rp {{ number_format($labaBersih, 0, ',', '.') }}</th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Pembayaran per Metode</h6>
                </div>
                <div class="card-body">
                    <div style="position: relative; height: 250px; width: 100%;">
                        <canvas id="paymentChart"></canvas>
                    </div>
                    <div class="mt-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span><i class="fas fa-money-bill-wave text-success"></i> Cash</span>
                            <span class="font-weight-bold">Rp {{ number_format($cashRevenue, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span><i class="fas fa-credit-card text-info"></i> Credit</span>
                            <span class="font-weight-bold">Rp {{ number_format($creditRevenue, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Profit Products -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Top 10 Produk Paling Menguntungkan</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Produk</th>
                                    <th>Qty Terjual</th>
                                    <th>Revenue</th>
                                    <th>HPP</th>
                                    <th>Profit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @forelse($productProfit as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item['nama'] }}</td>
                                    <td>{{ number_format($item['qty']) }}</td>
                                    <td>Rp {{ number_format($item['revenue'], 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($item['hpp'], 0, ',', '.') }}</td>
                                    <td class="{{ $item['profit'] >= 0 ? 'text-success' : 'text-danger' }} font-weight-bold">
                                        Rp {{ number_format($item['profit'], 0, ',', '.') }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data</td>
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
    document.addEventListener('DOMContentLoaded', function() {
        const canvas = document.getElementById('paymentChart');
        if (canvas) {
            const ctx = canvas.getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Cash', 'Credit'],
                    datasets: [{
                        data: [{{ $cashRevenue }}, {{ $creditRevenue }}],
                        backgroundColor: ['#28a745', '#17a2b8'],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    aspectRatio: 1.5,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 15,
                                font: {
                                    size: 12
                                }
                            }
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
    });
</script>
@endsection
