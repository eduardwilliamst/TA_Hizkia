<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Omzet Penjualan - {{ $periode }}</title>
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

        .highlight-box {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 10px;
            margin: 10px 0;
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
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>💰 LAPORAN OMZET PENJUALAN</h1>
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
            <div class="stat-value">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</div>
            <div class="stat-label">Total Omzet</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ number_format($totalTransaksi) }}</div>
            <div class="stat-label">Total Transaksi</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">Rp {{ number_format($rataRataPerHari, 0, ',', '.') }}</div>
            <div class="stat-label">Rata-rata/Hari</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ count($omzetByDate) }}</div>
            <div class="stat-label">Hari Operasional</div>
        </div>
    </div>

    <!-- Highlight Boxes -->
    @if($hariTertinggi)
    <div class="highlight-box">
        <strong>🏆 Hari Terbaik:</strong> {{ $hariTertinggi['tanggal'] }} dengan omzet Rp {{ number_format($hariTertinggi['omzet'], 0, ',', '.') }} ({{ $hariTertinggi['transaksi'] }} transaksi)
    </div>
    @endif

    @if($hariTerendah && count($omzetByDate) > 1)
    <div class="highlight-box" style="background: #f8d7da; border-left-color: #dc3545;">
        <strong>📉 Hari Terendah:</strong> {{ $hariTerendah['tanggal'] }} dengan omzet Rp {{ number_format($hariTerendah['omzet'], 0, ',', '.') }} ({{ $hariTerendah['transaksi'] }} transaksi)
    </div>
    @endif

    <!-- Daily Breakdown -->
    <div class="section-title">📅 Breakdown Omzet Harian</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 15%;">Tanggal</th>
                <th class="text-center" style="width: 15%;">Transaksi</th>
                <th class="text-right" style="width: 25%;">Total Omzet</th>
                <th class="text-right" style="width: 20%;">Cash</th>
                <th class="text-right" style="width: 20%;">Credit</th>
            </tr>
        </thead>
        <tbody>
            @forelse($omzetByDate as $data)
            <tr>
                <td>{{ $data['tanggal'] }}</td>
                <td class="text-center">{{ number_format($data['transaksi']) }}</td>
                <td class="text-right"><strong>Rp {{ number_format($data['omzet'], 0, ',', '.') }}</strong></td>
                <td class="text-right">Rp {{ number_format($data['cash'], 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($data['credit'], 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center" style="padding: 20px; color: #999;">Tidak ada data omzet</td>
            </tr>
            @endforelse
            @if(count($omzetByDate) > 0)
            <tr style="background: #e7f3ff; font-weight: bold;">
                <td>TOTAL</td>
                <td class="text-center">{{ number_format($totalTransaksi) }}</td>
                <td class="text-right">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($omzetByDate->sum('cash'), 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($omzetByDate->sum('credit'), 0, ',', '.') }}</td>
            </tr>
            @endif
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        <p>Laporan ini dibuat secara otomatis oleh Sistem POS | {{ $generatedAt }}</p>
        <p style="margin-top: 3px;">Dokumen ini bersifat rahasia dan hanya untuk penggunaan internal</p>
    </div>
</body>
</html>
