@extends('layouts.adminlte')

@section('title', 'Laporan Detail Transaksi')

@section('contents')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Laporan Detail Transaksi</h1>
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

    <!-- Filter Info -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-info">
                <i class="fas fa-filter mr-2"></i>
                <strong>Filter:</strong> Kasir: {{ $filter_kasir }} | Metode Bayar: {{ $filter_bayar }}
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Transaksi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalTransaksi) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-receipt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Nilai</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($totalNilai, 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Rata-rata per Transaksi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($totalTransaksi > 0 ? $totalNilai / $totalTransaksi : 0, 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calculator fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction List -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Transaksi</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="transactionTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>Kasir</th>
                            <th>Items</th>
                            <th>Metode Bayar</th>
                            <th>Diskon</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @forelse($penjualans as $penjualan)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>#{{ $penjualan->idpenjualan }}</td>
                            <td>{{ \Carbon\Carbon::parse($penjualan->created_at)->format('d/m/Y H:i') }}</td>
                            <td>{{ $penjualan->user->name ?? '-' }}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-info" type="button" data-toggle="collapse" data-target="#items-{{ $penjualan->idpenjualan }}">
                                    <i class="fas fa-eye mr-1"></i>{{ $penjualan->penjualanDetils->sum('jumlah') }} item
                                </button>
                            </td>
                            <td>
                                @if($penjualan->cara_bayar == 'cash')
                                    <span class="badge badge-success"><i class="fas fa-money-bill-wave mr-1"></i>Cash</span>
                                @else
                                    <span class="badge badge-info"><i class="fas fa-credit-card mr-1"></i>Credit</span>
                                @endif
                            </td>
                            <td>Rp {{ number_format($penjualan->total_diskon, 0, ',', '.') }}</td>
                            <td class="font-weight-bold">Rp {{ number_format($penjualan->total_harga, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="collapse" id="items-{{ $penjualan->idpenjualan }}">
                            <td colspan="8" class="bg-light">
                                <table class="table table-sm mb-0">
                                    <thead>
                                        <tr>
                                            <th>Produk</th>
                                            <th>Harga</th>
                                            <th>Qty</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($penjualan->penjualanDetils as $detil)
                                        <tr>
                                            <td>{{ $detil->produk->nama ?? 'Unknown' }}</td>
                                            <td>Rp {{ number_format($detil->harga, 0, ',', '.') }}</td>
                                            <td>{{ $detil->jumlah }}</td>
                                            <td>Rp {{ number_format($detil->sub_total, 0, ',', '.') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data transaksi</td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="bg-light">
                        <tr>
                            <th colspan="7" class="text-right">Grand Total:</th>
                            <th>Rp {{ number_format($totalNilai, 0, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Footer Info -->
    <div class="row">
        <div class="col-12">
            <p class="text-muted small">
                <i class="fas fa-info-circle mr-1"></i>
                Digenerate pada: {{ $generatedAt }} oleh {{ $generatedBy }}
            </p>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script>
    $(document).ready(function() {
        $('#transactionTable').DataTable({
            "pageLength": 25,
            "ordering": true,
            "order": [[2, 'desc']],
            "language": {
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Data tidak ditemukan",
                "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                "infoEmpty": "Tidak ada data",
                "infoFiltered": "(difilter dari _MAX_ total data)",
                "search": "Cari:",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                }
            }
        });
    });
</script>
@endsection
