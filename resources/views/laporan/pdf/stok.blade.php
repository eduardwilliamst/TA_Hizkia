<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Stok Barang</title>
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
            border-bottom: 2px solid #f5576c;
        }

        .header h1 {
            font-size: 18px;
            color: #f5576c;
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
            color: #f5576c;
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
            background: #f5576c;
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

        .badge-danger {
            background: #e74a3b;
            color: white;
        }

        .badge-warning {
            background: #f6c23e;
            color: #333;
        }

        .badge-success {
            background: #1cc88a;
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
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>📦 LAPORAN STOK BARANG</h1>
        <h2>Filter: {{ $filterStok }} | Kategori: {{ $kategori }}</h2>
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
            <div class="stat-value">Rp {{ number_format($totalNilaiInventori, 0, ',', '.') }}</div>
            <div class="stat-label">Nilai Inventori</div>
        </div>
        <div class="stat-card">
            <div class="stat-value" style="color: #f6c23e;">{{ number_format($produkStokRendah) }}</div>
            <div class="stat-label">Stok Rendah</div>
        </div>
        <div class="stat-card">
            <div class="stat-value" style="color: #e74a3b;">{{ number_format($produkStokHabis) }}</div>
            <div class="stat-label">Stok Habis</div>
        </div>
    </div>

    <!-- Category Breakdown -->
    @if(count($categoryBreakdown) > 0)
    <div class="section-title">📊 Breakdown Per Kategori</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 40%;">Kategori</th>
                <th class="text-center" style="width: 20%;">Jumlah Produk</th>
                <th class="text-center" style="width: 20%;">Total Stok</th>
                <th class="text-right" style="width: 20%;">Nilai</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categoryBreakdown as $cat)
            <tr>
                <td>{{ $cat['nama'] }}</td>
                <td class="text-center">{{ number_format($cat['count']) }}</td>
                <td class="text-center">{{ number_format($cat['total_stok']) }} unit</td>
                <td class="text-right">Rp {{ number_format($cat['nilai'], 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <!-- Product List -->
    <div class="section-title">📋 Daftar Produk</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Barcode</th>
                <th style="width: 35%;">Nama Produk</th>
                <th class="text-center" style="width: 15%;">Kategori</th>
                <th class="text-center" style="width: 10%;">Stok</th>
                <th class="text-right" style="width: 10%;">Harga</th>
                <th class="text-right" style="width: 10%;">Nilai</th>
            </tr>
        </thead>
        <tbody>
            @forelse($produks as $index => $produk)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $produk->barcode }}</td>
                <td>{{ $produk->nama }}</td>
                <td class="text-center">{{ $produk->kategori->nama ?? '-' }}</td>
                <td class="text-center">
                    @if($produk->stok == 0)
                        <span class="badge badge-danger">{{ $produk->stok }}</span>
                    @elseif($produk->stok < 10)
                        <span class="badge badge-warning">{{ $produk->stok }}</span>
                    @else
                        <span class="badge badge-success">{{ $produk->stok }}</span>
                    @endif
                </td>
                <td class="text-right">Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($produk->stok * $produk->harga, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center" style="padding: 20px; color: #999;">Tidak ada data produk</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot style="background: #f0f0f0; font-weight: bold;">
            <tr>
                <td colspan="6" class="text-right" style="padding: 8px 5px;">TOTAL NILAI INVENTORI:</td>
                <td class="text-right" style="padding: 8px 5px;">Rp {{ number_format($totalNilaiInventori, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <!-- Alert Section -->
    @if($produkStokRendah > 0 || $produkStokHabis > 0)
    <div style="background: #fff3cd; border: 1px solid #ffc107; padding: 10px; margin-top: 20px; border-radius: 4px;">
        <strong style="color: #856404;">⚠️ PERHATIAN:</strong>
        <ul style="margin: 5px 0 0 20px; color: #856404;">
            @if($produkStokHabis > 0)
            <li>Terdapat {{ $produkStokHabis }} produk dengan stok habis (0 unit)</li>
            @endif
            @if($produkStokRendah > 0)
            <li>Terdapat {{ $produkStokRendah }} produk dengan stok rendah (<10 unit)</li>
            @endif
            <li>Segera lakukan restocking untuk menghindari stockout</li>
        </ul>
    </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>Laporan ini dibuat secara otomatis oleh Sistem POS | {{ $generatedAt }}</p>
        <p style="margin-top: 3px;">Dokumen ini bersifat rahasia dan hanya untuk penggunaan internal</p>
    </div>
</body>
</html>
