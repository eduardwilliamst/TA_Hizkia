<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Inventory - {{ $kategori }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            line-height: 1.3;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #0d6efd;
        }

        .header h1 {
            font-size: 16px;
            color: #0d6efd;
            margin-bottom: 5px;
        }

        .header h2 {
            font-size: 12px;
            color: #666;
            font-weight: normal;
        }

        .info-box {
            background: #f8f9fa;
            padding: 8px;
            margin-bottom: 12px;
            border-radius: 4px;
            font-size: 9px;
        }

        .info-box table {
            width: 100%;
        }

        .info-box td {
            padding: 2px 5px;
        }

        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }

        .stat-card {
            display: table-cell;
            width: 25%;
            padding: 8px;
            text-align: center;
            border: 1px solid #e0e0e0;
            background: #f8f9fa;
        }

        .stat-value {
            font-size: 13px;
            font-weight: bold;
            color: #0d6efd;
            margin-bottom: 3px;
        }

        .stat-label {
            font-size: 8px;
            color: #666;
            text-transform: uppercase;
        }

        .section-title {
            font-size: 11px;
            font-weight: bold;
            color: #333;
            margin: 15px 0 8px 0;
            padding-bottom: 3px;
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
            padding: 6px 4px;
            text-align: left;
            font-size: 9px;
            font-weight: bold;
        }

        table.data-table td {
            padding: 5px 4px;
            border-bottom: 1px solid #e0e0e0;
            font-size: 9px;
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
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 7px;
            font-weight: bold;
        }

        .badge-danger {
            background: #dc3545;
            color: white;
        }

        .badge-warning {
            background: #ffc107;
            color: #333;
        }

        .badge-success {
            background: #28a745;
            color: white;
        }

        .summary-table {
            width: 100%;
            margin-bottom: 15px;
        }

        .summary-table td {
            padding: 6px 8px;
            border-bottom: 1px solid #e0e0e0;
        }

        .highlight-row {
            background: #e7f3ff;
            font-weight: bold;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8px;
            color: #999;
            padding: 8px 0;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>📦 LAPORAN INVENTORY</h1>
        <h2>Kategori: {{ $kategori }}</h2>
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
            <div class="stat-value">{{ number_format($totalProduk) }}</div>
            <div class="stat-label">Total Produk</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">Rp {{ number_format($totalNilaiModal / 1000000, 1) }}M</div>
            <div class="stat-label">Nilai Modal</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">Rp {{ number_format($totalNilaiJual / 1000000, 1) }}M</div>
            <div class="stat-label">Nilai Jual</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">Rp {{ number_format($potensiLaba / 1000000, 1) }}M</div>
            <div class="stat-label">Potensi Laba</div>
        </div>
    </div>

    <!-- Stock Alerts Summary -->
    <div class="section-title">⚠️ Status Stok</div>
    <table class="summary-table">
        <tr>
            <td style="width: 60%;">Stok Aman (≥10 unit)</td>
            <td class="text-right" style="width: 40%;"><span class="badge badge-success">{{ number_format($stokAman) }} produk</span></td>
        </tr>
        <tr style="background: #fff3cd;">
            <td>Stok Rendah (1-9 unit)</td>
            <td class="text-right"><span class="badge badge-warning">{{ number_format($stokRendah) }} produk</span></td>
        </tr>
        <tr style="background: #f8d7da;">
            <td>Stok Habis (0 unit)</td>
            <td class="text-right"><span class="badge badge-danger">{{ number_format($stokHabis) }} produk</span></td>
        </tr>
    </table>

    <!-- Category Breakdown -->
    @if(count($categoryInventory) > 0)
    <div class="section-title">📊 Breakdown per Kategori</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 30%;">Kategori</th>
                <th class="text-center" style="width: 15%;">Produk</th>
                <th class="text-center" style="width: 15%;">Total Stok</th>
                <th class="text-right" style="width: 20%;">Nilai Modal</th>
                <th class="text-right" style="width: 20%;">Nilai Jual</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categoryInventory as $cat)
            <tr>
                <td>{{ $cat['nama'] }}</td>
                <td class="text-center">{{ number_format($cat['jumlah_produk']) }}</td>
                <td class="text-center">{{ number_format($cat['total_stok']) }}</td>
                <td class="text-right">Rp {{ number_format($cat['nilai_modal'], 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($cat['nilai_jual'], 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <!-- Top Value Products -->
    <div class="section-title">💎 Top 10 Produk Bernilai Tertinggi</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 35%;">Produk</th>
                <th class="text-center" style="width: 12%;">Stok</th>
                <th class="text-right" style="width: 16%;">Harga Beli</th>
                <th class="text-right" style="width: 16%;">Harga Jual</th>
                <th class="text-right" style="width: 16%;">Nilai Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($topValueProducts as $index => $item)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $item['nama'] }}</td>
                <td class="text-center">{{ number_format($item['stok']) }}</td>
                <td class="text-right">Rp {{ number_format($item['harga_beli'], 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($item['harga_jual'], 0, ',', '.') }}</td>
                <td class="text-right"><strong>Rp {{ number_format($item['nilai_jual'], 0, ',', '.') }}</strong></td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center" style="padding: 20px; color: #999;">Tidak ada data produk</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- All Products Listing -->
    <div class="section-title">📋 Daftar Lengkap Inventory</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 30%;">Produk</th>
                <th style="width: 18%;">Kategori</th>
                <th class="text-center" style="width: 12%;">Stok</th>
                <th class="text-right" style="width: 17%;">Harga Beli</th>
                <th class="text-right" style="width: 18%;">Harga Jual</th>
            </tr>
        </thead>
        <tbody>
            @forelse($produks as $index => $produk)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $produk->nama }}</td>
                <td>{{ $produk->kategori->nama ?? '-' }}</td>
                <td class="text-center">
                    @if($produk->stok == 0)
                        <span class="badge badge-danger">{{ $produk->stok }}</span>
                    @elseif($produk->stok < 10)
                        <span class="badge badge-warning">{{ $produk->stok }}</span>
                    @else
                        <span class="badge badge-success">{{ $produk->stok }}</span>
                    @endif
                </td>
                <td class="text-right">Rp {{ number_format($produk->harga_beli ?? 0, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center" style="padding: 20px; color: #999;">Tidak ada data produk</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        <p>Laporan ini dibuat secara otomatis oleh Sistem POS | {{ $generatedAt }}</p>
        <p style="margin-top: 2px;">Dokumen ini bersifat rahasia dan hanya untuk penggunaan internal</p>
    </div>
</body>
</html>
