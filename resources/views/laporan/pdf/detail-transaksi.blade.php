<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Detail Transaksi - {{ $periode }}</title>
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

        .summary-box {
            background: #e7f3ff;
            padding: 10px;
            margin-bottom: 15px;
            border-left: 4px solid #0d6efd;
        }

        .summary-box strong {
            font-size: 12px;
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
            font-size: 8px;
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

        .transaksi-block {
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            padding: 8px;
            margin-bottom: 10px;
            page-break-inside: avoid;
        }

        .transaksi-header {
            background: #f8f9fa;
            padding: 6px;
            margin: -8px -8px 8px -8px;
            border-bottom: 1px solid #e0e0e0;
            font-weight: bold;
            font-size: 10px;
        }

        .item-table {
            width: 100%;
            margin-top: 5px;
        }

        .item-table td {
            padding: 3px 0;
            font-size: 9px;
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
        <h1>🧾 LAPORAN DETAIL TRANSAKSI</h1>
        <h2>Periode: {{ $periode }}</h2>
    </div>

    <!-- Info Box -->
    <div class="info-box">
        <table>
            <tr>
                <td style="width: 33%;"><strong>Generate:</strong> {{ $generatedAt }}</td>
                <td style="width: 33%;"><strong>Oleh:</strong> {{ $generatedBy }}</td>
                <td style="width: 34%;"><strong>Kasir:</strong> {{ $filter_kasir }}</td>
            </tr>
            <tr>
                <td colspan="3"><strong>Metode Bayar:</strong> {{ $filter_bayar }}</td>
            </tr>
        </table>
    </div>

    <!-- Summary -->
    <div class="summary-box">
        <strong>Total: {{ number_format($totalTransaksi) }} Transaksi</strong> |
        <strong>Nilai: Rp {{ number_format($totalNilai, 0, ',', '.') }}</strong>
    </div>

    <!-- Transaction Details -->
    <div class="section-title">📋 Daftar Transaksi</div>

    @forelse($penjualans as $penjualan)
    <div class="transaksi-block">
        <div class="transaksi-header">
            #{{ $penjualan->idpenjualan }} |
            {{ \Carbon\Carbon::parse($penjualan->created_at)->format('d/m/Y H:i') }} |
            Kasir: {{ $penjualan->user->name ?? 'Unknown' }} |
            <span class="badge {{ $penjualan->cara_bayar == 'cash' ? 'badge-success' : 'badge-info' }}">
                {{ strtoupper($penjualan->cara_bayar) }}
            </span>
        </div>

        <table class="item-table">
            <thead style="border-bottom: 1px solid #ddd;">
                <tr>
                    <th style="width: 50%; padding-bottom: 3px; text-align: left; font-size: 8px;">Produk</th>
                    <th style="width: 15%; padding-bottom: 3px; text-align: center; font-size: 8px;">Qty</th>
                    <th style="width: 17%; padding-bottom: 3px; text-align: right; font-size: 8px;">Harga</th>
                    <th style="width: 18%; padding-bottom: 3px; text-align: right; font-size: 8px;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penjualan->penjualanDetils as $detil)
                <tr>
                    <td>{{ $detil->produk->nama ?? 'Unknown' }}</td>
                    <td class="text-center">{{ $detil->jumlah }}</td>
                    <td class="text-right">Rp {{ number_format($detil->harga, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($detil->sub_total, 0, ',', '.') }}</td>
                </tr>
                @endforeach
                <tr style="border-top: 1px solid #ddd; font-weight: bold;">
                    <td colspan="3" class="text-right" style="padding-top: 5px;">TOTAL:</td>
                    <td class="text-right" style="padding-top: 5px;">Rp {{ number_format($penjualan->total_harga, 0, ',', '.') }}</td>
                </tr>
                @if($penjualan->total_diskon > 0)
                <tr>
                    <td colspan="3" class="text-right">Diskon:</td>
                    <td class="text-right" style="color: #dc3545;">- Rp {{ number_format($penjualan->total_diskon, 0, ',', '.') }}</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
    @empty
    <div style="text-align: center; padding: 40px; color: #999;">
        Tidak ada transaksi untuk periode ini
    </div>
    @endforelse

    <!-- Footer -->
    <div class="footer">
        <p>Laporan ini dibuat secara otomatis oleh Sistem POS | {{ $generatedAt }}</p>
        <p style="margin-top: 2px;">Dokumen ini bersifat rahasia dan hanya untuk penggunaan internal</p>
    </div>
</body>
</html>
