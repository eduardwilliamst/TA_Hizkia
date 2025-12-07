<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Laba Rugi - {{ $periode }}</title>
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

        .summary-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .summary-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #e0e0e0;
        }

        .summary-total {
            background: #e7f3ff;
            font-weight: bold;
            font-size: 14px;
            padding: 10px !important;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .profit-positive {
            color: #28a745;
            font-weight: bold;
        }

        .profit-negative {
            color: #dc3545;
            font-weight: bold;
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
        <h1>📊 LAPORAN LABA RUGI</h1>
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

    <!-- Income Statement Summary -->
    <div class="section-title">💵 Ringkasan Laba Rugi</div>
    <table class="summary-table">
        <tr>
            <td style="width: 60%;">Total Pendapatan Kotor</td>
            <td class="text-right" style="width: 40%;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Diskon & Potongan</td>
            <td class="text-right">- Rp {{ number_format($totalDiskon, 0, ',', '.') }}</td>
        </tr>
        <tr style="background: #f8f9fa; font-weight: bold;">
            <td>Pendapatan Bersih</td>
            <td class="text-right">Rp {{ number_format($pendapatanBersih, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>HPP (Harga Pokok Penjualan)</td>
            <td class="text-right">- Rp {{ number_format($hpp, 0, ',', '.') }}</td>
        </tr>
        <tr class="summary-total {{ $labaBersih >= 0 ? 'profit-positive' : 'profit-negative' }}">
            <td>LABA BERSIH</td>
            <td class="text-right">Rp {{ number_format($labaBersih, 0, ',', '.') }}</td>
        </tr>
        <tr style="background: #fff3cd;">
            <td>Margin Laba</td>
            <td class="text-right"><strong>{{ number_format($marginLaba, 2) }}%</strong></td>
        </tr>
    </table>

    <!-- Revenue Breakdown by Payment Method -->
    <div class="section-title">💳 Breakdown Pendapatan per Metode Bayar</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Metode Pembayaran</th>
                <th class="text-right">Total Pendapatan</th>
                <th class="text-center">Persentase</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Cash</td>
                <td class="text-right">Rp {{ number_format($cashRevenue, 0, ',', '.') }}</td>
                <td class="text-center">{{ $totalPendapatan > 0 ? number_format(($cashRevenue / $totalPendapatan) * 100, 1) : 0 }}%</td>
            </tr>
            <tr>
                <td>Credit/Debit Card</td>
                <td class="text-right">Rp {{ number_format($creditRevenue, 0, ',', '.') }}</td>
                <td class="text-center">{{ $totalPendapatan > 0 ? number_format(($creditRevenue / $totalPendapatan) * 100, 1) : 0 }}%</td>
            </tr>
        </tbody>
    </table>

    <!-- Top Profitable Products -->
    <div class="section-title">🏆 Top 10 Produk Paling Menguntungkan</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 35%;">Produk</th>
                <th class="text-center" style="width: 10%;">Qty</th>
                <th class="text-right" style="width: 20%;">Revenue</th>
                <th class="text-right" style="width: 15%;">HPP</th>
                <th class="text-right" style="width: 15%;">Profit</th>
            </tr>
        </thead>
        <tbody>
            @forelse($productProfit as $index => $item)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $item['nama'] }}</td>
                <td class="text-center">{{ number_format($item['qty']) }}</td>
                <td class="text-right">Rp {{ number_format($item['revenue'], 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($item['hpp'], 0, ',', '.') }}</td>
                <td class="text-right {{ $item['profit'] >= 0 ? 'profit-positive' : 'profit-negative' }}">
                    Rp {{ number_format($item['profit'], 0, ',', '.') }}
                </td>
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
        <p style="margin-top: 3px;">Dokumen ini bersifat rahasia dan hanya untuk penggunaan internal</p>
    </div>
</body>
</html>
