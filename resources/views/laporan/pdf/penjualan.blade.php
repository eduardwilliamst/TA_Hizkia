<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan - {{ $periode }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #0d6efd;
        }

        .header h1 {
            font-size: 18px;
            color: #0d6efd;
            margin-bottom: 5px;
        }

        .header h2 {
            font-size: 14px;
            color: #666;
            font-weight: normal;
        }

        .info-box {
            background: #f8f9fa;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
        }

        .info-box table {
            width: 100%;
        }

        .info-box td {
            padding: 3px 5px;
        }

        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }

        .stat-card {
            display: table-cell;
            width: 25%;
            padding: 10px;
            text-align: center;
            border: 1px solid #e0e0e0;
            background: #f8f9fa;
        }

        .stat-value {
            font-size: 16px;
            font-weight: bold;
            color: #0d6efd;
            margin-bottom: 3px;
        }

        .stat-label {
            font-size: 9px;
            color: #666;
            text-transform: uppercase;
        }

        .section-title {
            font-size: 13px;
            font-weight: bold;
            color: #333;
            margin: 20px 0 10px 0;
            padding-bottom: 5px;
            border-bottom: 1px solid #ddd;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        table.data-table th {
            background: #0d6efd;
            color: white;
            padding: 8px 5px;
            text-align: left;
            font-size: 10px;
            font-weight: bold;
        }

        table.data-table td {
            padding: 6px 5px;
            border-bottom: 1px solid #e0e0e0;
        }

        table.data-table tr:nth-child(even) {
            background: #f8f9fa;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }

        .badge-success {
            background: #1cc88a;
            color: white;
        }

        .badge-info {
            background: #36b9cc;
            color: white;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9px;
            color: #999;
            padding: 10px 0;
            border-top: 1px solid #ddd;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>📊 LAPORAN PENJUALAN</h1>
        <h2>Periode: {{ $periode }}</h2>
    </div>

    <!-- Info Box -->
    <div class="info-box">
        <table>
            <tr>
                <td style="width: 50%;"><strong>Tanggal Generate:</strong> {{ $generatedAt }}</td>
                <td style="width: 50%;"><strong>Dibuat Oleh:</strong> {{ $generatedBy }}</td>
            </tr>
        </table>
    </div>

    <!-- Statistics Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-value">{{ number_format($totalTransaksi) }}</div>
            <div class="stat-label">Total Transaksi</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
            <div class="stat-label">Total Pendapatan</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ number_format($totalItem) }}</div>
            <div class="stat-label">Total Item Terjual</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">Rp {{ number_format($avgPerTransaksi, 0, ',', '.') }}</div>
            <div class="stat-label">Rata-rata/Transaksi</div>
        </div>
    </div>

    <!-- Payment Method Breakdown -->
    <div class="section-title">💳 Metode Pembayaran</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Metode</th>
                <th class="text-center">Jumlah Transaksi</th>
                <th class="text-right">Total Nilai</th>
                <th class="text-center">Persentase</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><span class="badge badge-success">CASH</span></td>
                <td class="text-center">{{ number_format($cashTransaksi) }}</td>
                <td class="text-right">Rp {{ number_format($cashTotal, 0, ',', '.') }}</td>
                <td class="text-center">{{ $totalTransaksi > 0 ? number_format(($cashTransaksi / $totalTransaksi) * 100, 1) : 0 }}%</td>
            </tr>
            <tr>
                <td><span class="badge badge-info">CREDIT</span></td>
                <td class="text-center">{{ number_format($creditTransaksi) }}</td>
                <td class="text-right">Rp {{ number_format($creditTotal, 0, ',', '.') }}</td>
                <td class="text-center">{{ $totalTransaksi > 0 ? number_format(($creditTransaksi / $totalTransaksi) * 100, 1) : 0 }}%</td>
            </tr>
        </tbody>
    </table>

    <!-- Top 10 Products -->
    <div class="section-title">🏆 Top 10 Produk Terlaris</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">Rank</th>
                <th style="width: 45%;">Nama Produk</th>
                <th class="text-center" style="width: 15%;">Qty Terjual</th>
                <th class="text-right" style="width: 20%;">Total Revenue</th>
                <th class="text-center" style="width: 15%;">Kontribusi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($topProducts as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->produk->nama ?? 'Unknown' }}</td>
                <td class="text-center">{{ number_format($item->total_qty) }} unit</td>
                <td class="text-right">Rp {{ number_format($item->total_revenue, 0, ',', '.') }}</td>
                <td class="text-center">{{ $totalPendapatan > 0 ? number_format(($item->total_revenue / $totalPendapatan) * 100, 1) : 0 }}%</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center" style="padding: 20px; color: #999;">Tidak ada data produk</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Kasir Performance (if applicable) -->
    @if(count($kasirPerformance) > 0)
    <div class="section-title">👥 Performa Kasir</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 50%;">Nama Kasir</th>
                <th class="text-center" style="width: 25%;">Jumlah Transaksi</th>
                <th class="text-right" style="width: 25%;">Total Penjualan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kasirPerformance as $kasir)
            <tr>
                <td>{{ $kasir['name'] }}</td>
                <td class="text-center">{{ number_format($kasir['count']) }}</td>
                <td class="text-right">Rp {{ number_format($kasir['total'], 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <!-- Sales by Hour (if applicable) -->
    @if(count($salesByHour) > 0)
    <div class="section-title">⏰ Penjualan Per Jam</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 40%;">Jam</th>
                <th class="text-center" style="width: 30%;">Jumlah Transaksi</th>
                <th class="text-right" style="width: 30%;">Total Penjualan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($salesByHour as $hour => $data)
            <tr>
                <td>{{ $hour }}</td>
                <td class="text-center">{{ number_format($data['count']) }}</td>
                <td class="text-right">Rp {{ number_format($data['total'], 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>Laporan ini dibuat secara otomatis oleh Sistem POS | {{ $generatedAt }}</p>
        <p style="margin-top: 3px;">Dokumen ini bersifat rahasia dan hanya untuk penggunaan internal</p>
    </div>
</body>
</html>
