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
            font-family: 'Times New Roman', Times, serif;
            font-size: 10pt;
            line-height: 1.5;
            color: #000;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px double #000;
        }

        .header h1 {
            font-size: 16pt;
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .header h2 {
            font-size: 12pt;
            font-weight: normal;
            margin-bottom: 3px;
        }

        .header .company-info {
            font-size: 9pt;
            margin-top: 5px;
        }

        .report-info {
            margin-bottom: 20px;
            border: 1px solid #000;
            padding: 10px;
        }

        .report-info table {
            width: 100%;
        }

        .report-info td {
            padding: 3px 5px;
            font-size: 9pt;
        }

        .report-info td:first-child {
            width: 120px;
            font-weight: bold;
        }

        .section-title {
            font-size: 11pt;
            font-weight: bold;
            margin: 15px 0 10px 0;
            padding-bottom: 5px;
            border-bottom: 2px solid #000;
            text-transform: uppercase;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 9pt;
        }

        table.data-table th {
            background-color: #f0f0f0;
            border: 1px solid #000;
            padding: 6px 4px;
            text-align: left;
            font-weight: bold;
            font-size: 9pt;
        }

        table.data-table td {
            border: 1px solid #000;
            padding: 5px 4px;
        }

        table.data-table tr:nth-child(even) {
            background-color: #fafafa;
        }

        table.summary-table {
            width: 100%;
            margin-bottom: 15px;
            font-size: 9pt;
        }

        table.summary-table td {
            padding: 4px 8px;
            border-bottom: 1px solid #ddd;
        }

        table.summary-table td:first-child {
            width: 60%;
            font-weight: bold;
        }

        table.summary-table td:last-child {
            text-align: right;
        }

        table.summary-table tr.total-row td {
            border-top: 2px solid #000;
            border-bottom: 3px double #000;
            padding-top: 6px;
            padding-bottom: 6px;
            font-size: 10pt;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #000;
            font-size: 8pt;
        }

        .signature-box {
            margin-top: 40px;
        }

        .signature-box table {
            width: 100%;
        }

        .signature-box td {
            width: 33%;
            text-align: center;
            vertical-align: bottom;
            padding-top: 60px;
        }

        .signature-line {
            border-top: 1px solid #000;
            display: inline-block;
            width: 150px;
            margin-top: 50px;
        }

        @page {
            margin: 2cm 1.5cm;
        }

        .no-print {
            display: none;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>Laporan Penjualan</h1>
        <h2>Periode: {{ $periode }}</h2>
        <div class="company-info">
            PT. NAMA PERUSAHAAN | Alamat Perusahaan | Telepon: (021) 12345678
        </div>
    </div>

    <!-- Report Info -->
    <div class="report-info">
        <table>
            <tr>
                <td>Tanggal Cetak</td>
                <td>: {{ $generatedAt }}</td>
            </tr>
            <tr>
                <td>Dicetak Oleh</td>
                <td>: {{ $generatedBy }}</td>
            </tr>
            <tr>
                <td>Rentang Tanggal</td>
                <td>: {{ $dateRange['start']->format('d/m/Y') }} s/d {{ $dateRange['end']->format('d/m/Y') }}</td>
            </tr>
        </table>
    </div>

    <!-- Ringkasan -->
    <div class="section-title">I. Ringkasan Penjualan</div>
    <table class="summary-table">
        <tr>
            <td>Total Transaksi</td>
            <td>{{ number_format($totalTransaksi) }} transaksi</td>
        </tr>
        <tr>
            <td>Total Item Terjual</td>
            <td>{{ number_format($totalItem) }} item</td>
        </tr>
        <tr>
            <td>Rata-rata per Transaksi</td>
            <td>Rp {{ number_format($avgPerTransaksi, 0, ',', '.') }}</td>
        </tr>
        <tr class="total-row">
            <td>TOTAL PENDAPATAN</td>
            <td>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
        </tr>
    </table>

    <!-- Breakdown Metode Pembayaran -->
    <div class="section-title">II. Rincian Metode Pembayaran</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 45%">Metode Pembayaran</th>
                <th style="width: 25%">Jumlah Transaksi</th>
                <th style="width: 25%">Total Nilai</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">1</td>
                <td>Tunai (Cash)</td>
                <td class="text-right">{{ number_format($cashTransaksi) }}</td>
                <td class="text-right">Rp {{ number_format($cashTotal, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="text-center">2</td>
                <td>Kredit (Credit Card)</td>
                <td class="text-right">{{ number_format($creditTransaksi) }}</td>
                <td class="text-right">Rp {{ number_format($creditTotal, 0, ',', '.') }}</td>
            </tr>
            <tr style="font-weight: bold; background-color: #e0e0e0;">
                <td colspan="2" class="text-right">TOTAL</td>
                <td class="text-right">{{ number_format($totalTransaksi) }}</td>
                <td class="text-right">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Top 10 Produk -->
    <div class="section-title">III. Daftar 10 Produk Terlaris</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 50%">Nama Produk</th>
                <th style="width: 20%">Qty Terjual</th>
                <th style="width: 25%">Total Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($topProducts as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->produk->nama ?? 'N/A' }}</td>
                <td class="text-right">{{ number_format($item->total_qty) }}</td>
                <td class="text-right">Rp {{ number_format($item->total_revenue, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if(!empty($kasirPerformance) && count($kasirPerformance) > 0)
    <!-- Performa Kasir -->
    <div class="section-title">IV. Performa Per Kasir</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 50%">Nama Kasir</th>
                <th style="width: 20%">Jumlah Transaksi</th>
                <th style="width: 25%">Total Penjualan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kasirPerformance as $index => $kasir)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $kasir['name'] }}</td>
                <td class="text-right">{{ number_format($kasir['count']) }}</td>
                <td class="text-right">Rp {{ number_format($kasir['total'], 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p><strong>Catatan:</strong></p>
        <ul style="margin-left: 20px; font-size: 9pt;">
            <li>Laporan ini dibuat secara otomatis oleh sistem.</li>
            <li>Data yang ditampilkan merupakan data real-time dari database.</li>
            <li>Untuk informasi lebih lanjut, hubungi bagian keuangan.</li>
        </ul>
    </div>

    <!-- Signature Box -->
    <div class="signature-box">
        <table>
            <tr>
                <td>
                    <div>Dibuat Oleh,</div>
                    <div class="signature-line"></div>
                    <div>({{ $generatedBy }})</div>
                </td>
                <td>
                    <div>Diperiksa Oleh,</div>
                    <div class="signature-line"></div>
                    <div>(Manager)</div>
                </td>
                <td>
                    <div>Disetujui Oleh,</div>
                    <div class="signature-line"></div>
                    <div>(Direktur)</div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
