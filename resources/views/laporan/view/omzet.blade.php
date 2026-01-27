@extends('layouts.adminlte')

@section('title', 'Laporan Omzet')

@section('contents')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Laporan Omzet</h1>
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
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Omzet</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Transaksi</div>
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
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Rata-rata/Hari</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($rataRataPerHari, 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Hari Terbaik</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @if($hariTertinggi)
                                    {{ $hariTertinggi['tanggal'] }}
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-trophy fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Omzet Harian</h6>
                </div>
                <div class="card-body">
                    @if($omzetByDate->count() > 0)
                    <div class="chart-container" style="position: relative; height:350px;">
                        <canvas id="omzetChart"></canvas>
                    </div>
                    @else
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-chart-bar fa-3x mb-3 opacity-50"></i>
                        <p>Tidak ada data untuk periode ini</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Omzet Table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Detail Omzet per Hari</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jumlah Transaksi</th>
                                    <th>Cash</th>
                                    <th>Credit</th>
                                    <th>Total Omzet</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($omzetByDate as $data)
                                <tr>
                                    <td>{{ $data['tanggal'] }}</td>
                                    <td>{{ number_format($data['transaksi']) }}</td>
                                    <td>Rp {{ number_format($data['cash'], 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($data['credit'], 0, ',', '.') }}</td>
                                    <td><strong>Rp {{ number_format($data['omzet'], 0, ',', '.') }}</strong></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data</td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="table-secondary">
                                <tr>
                                    <th>Total</th>
                                    <th>{{ number_format($totalTransaksi) }}</th>
                                    <th>-</th>
                                    <th>-</th>
                                    <th>Rp {{ number_format($totalOmzet, 0, ',', '.') }}</th>
                                </tr>
                            </tfoot>
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
        const canvas = document.getElementById('omzetChart');
        if (canvas) {
            const ctx = canvas.getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [
                        @foreach($omzetByDate as $data)
                            '{{ $data["tanggal"] }}',
                        @endforeach
                    ],
                    datasets: [{
                        label: 'Omzet (Rp)',
                        data: [
                            @foreach($omzetByDate as $data)
                                {{ $data["omzet"] }},
                            @endforeach
                        ],
                        backgroundColor: 'rgba(78, 115, 223, 0.2)',
                        borderColor: '#4e73df',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.3
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
    });
</script>
@endsection
