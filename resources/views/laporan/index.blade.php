@extends('layouts.adminlte')

@section('title', 'Laporan')

@section('page-bar')
<h1 class="m-0" style="color: #0d6efd; font-weight: 600;">
    <i class="fas fa-file-alt mr-2"></i>
    Pusat Laporan
</h1>
@endsection

@section('contents')
<div class="container-fluid">
    <!-- Info Banner -->
    <div class="alert alert-info" style="border-left: 4px solid #0d6efd; background: rgba(13, 110, 253, 0.1); border-radius: 4px;">
        <i class="fas fa-info-circle mr-2"></i>
        <strong>Pilih laporan yang ingin Anda lihat.</strong> Klik pada card untuk membuka modal filter, kemudian generate PDF.
    </div>

    <!-- Laporan Wajib Section -->
    <div class="row mb-4">
        <div class="col-12">
            <h4 style="color: #5a5c69; font-weight: 600; margin-bottom: 1rem;">
                <i class="fas fa-star mr-2" style="color: #f6c23e;"></i>Laporan Utama
            </h4>
        </div>
    </div>

    <div class="row">
        <!-- Laporan Penjualan Harian -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card report-card" data-toggle="modal" data-target="#modalLaporanPenjualan" style="cursor: pointer; border: 1px solid #e3e6f0; border-radius: 8px; transition: all 0.2s ease; height: 100%;">
                <div class="card-body" style="padding: 1.5rem;">
                    <div class="d-flex align-items-center mb-3">
                        <div style="width: 60px; height: 60px; border-radius: 12px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-chart-line" style="font-size: 1.8rem; color: white;"></i>
                        </div>
                        <div style="flex: 1; margin-left: 1rem;">
                            <h5 style="margin: 0; font-weight: 600; color: #333;">Laporan Penjualan</h5>
                            <p style="margin: 0; color: #858796; font-size: 0.85rem;">Harian, Mingguan, Bulanan</p>
                        </div>
                    </div>
                    <p style="color: #666; font-size: 0.9rem; margin-bottom: 1rem;">
                        Lihat detail penjualan, transaksi per jam, top produk, dan performa kasir.
                    </p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge" style="background: rgba(102, 126, 234, 0.1); color: #667eea; padding: 0.4rem 0.8rem; border-radius: 6px; font-size: 0.8rem;">
                            <i class="fas fa-file-pdf mr-1"></i>PDF
                        </span>
                        <span style="color: #667eea; font-weight: 600; font-size: 0.9rem;">
                            Klik untuk generate <i class="fas fa-arrow-right ml-1"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Laporan Stok Barang -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card report-card" data-toggle="modal" data-target="#modalLaporanStok" style="cursor: pointer; border: 1px solid #e3e6f0; border-radius: 8px; transition: all 0.2s ease; height: 100%;">
                <div class="card-body" style="padding: 1.5rem;">
                    <div class="d-flex align-items-center mb-3">
                        <div style="width: 60px; height: 60px; border-radius: 12px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-boxes" style="font-size: 1.8rem; color: white;"></i>
                        </div>
                        <div style="flex: 1; margin-left: 1rem;">
                            <h5 style="margin: 0; font-weight: 600; color: #333;">Laporan Stok</h5>
                            <p style="margin: 0; color: #858796; font-size: 0.85rem;">Inventori & Ketersediaan</p>
                        </div>
                    </div>
                    <p style="color: #666; font-size: 0.9rem; margin-bottom: 1rem;">
                        Stok rendah, stok habis, produk slow-moving, dan nilai total inventori.
                    </p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge" style="background: rgba(245, 87, 108, 0.1); color: #f5576c; padding: 0.4rem 0.8rem; border-radius: 6px; font-size: 0.8rem;">
                            <i class="fas fa-file-pdf mr-1"></i>PDF
                        </span>
                        <span style="color: #f5576c; font-weight: 600; font-size: 0.9rem;">
                            Klik untuk generate <i class="fas fa-arrow-right ml-1"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Laporan Omzet -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card report-card" data-toggle="modal" data-target="#modalLaporanOmzet" style="cursor: pointer; border: 1px solid #e3e6f0; border-radius: 8px; transition: all 0.2s ease; height: 100%;">
                <div class="card-body" style="padding: 1.5rem;">
                    <div class="d-flex align-items-center mb-3">
                        <div style="width: 60px; height: 60px; border-radius: 12px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-money-bill-wave" style="font-size: 1.8rem; color: white;"></i>
                        </div>
                        <div style="flex: 1; margin-left: 1rem;">
                            <h5 style="margin: 0; font-weight: 600; color: #333;">Laporan Omzet</h5>
                            <p style="margin: 0; color: #858796; font-size: 0.85rem;">Breakdown Harian</p>
                        </div>
                    </div>
                    <p style="color: #666; font-size: 0.9rem; margin-bottom: 1rem;">
                        Omzet per hari, total transaksi, cash vs credit, dan hari terbaik/terburuk.
                    </p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge" style="background: rgba(0, 242, 254, 0.1); color: #00f2fe; padding: 0.4rem 0.8rem; border-radius: 6px; font-size: 0.8rem;">
                            <i class="fas fa-file-pdf mr-1"></i>PDF
                        </span>
                        <span style="color: #00f2fe; font-weight: 600; font-size: 0.9rem;">
                            Klik untuk generate <i class="fas fa-arrow-right ml-1"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Laporan Tambahan Section -->
    <div class="row mb-4 mt-5">
        <div class="col-12">
            <h4 style="color: #5a5c69; font-weight: 600; margin-bottom: 1rem;">
                <i class="fas fa-chart-bar mr-2" style="color: #1cc88a;"></i>Laporan Tambahan
            </h4>
        </div>
    </div>

    <div class="row">
        <!-- Laporan Laba Rugi -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card report-card" data-toggle="modal" data-target="#modalLaporanLabaRugi" style="cursor: pointer; border: 1px solid #e3e6f0; border-radius: 8px; transition: all 0.2s ease; height: 100%;">
                <div class="card-body" style="padding: 1.5rem;">
                    <div class="d-flex align-items-center mb-3">
                        <div style="width: 60px; height: 60px; border-radius: 12px; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-calculator" style="font-size: 1.8rem; color: white;"></i>
                        </div>
                        <div style="flex: 1; margin-left: 1rem;">
                            <h5 style="margin: 0; font-weight: 600; color: #333;">Laporan Laba Rugi</h5>
                            <p style="margin: 0; color: #858796; font-size: 0.85rem;">Profit & Loss Statement</p>
                        </div>
                    </div>
                    <p style="color: #666; font-size: 0.9rem; margin-bottom: 1rem;">
                        Revenue, HPP, laba bersih, margin laba, dan top produk menguntungkan.
                    </p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge" style="background: rgba(67, 233, 123, 0.1); color: #43e97b; padding: 0.4rem 0.8rem; border-radius: 6px; font-size: 0.8rem;">
                            <i class="fas fa-file-pdf mr-1"></i>PDF
                        </span>
                        <span style="color: #43e97b; font-weight: 600; font-size: 0.9rem;">
                            Klik untuk generate <i class="fas fa-arrow-right ml-1"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Laporan Detail Transaksi -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card report-card" data-toggle="modal" data-target="#modalLaporanDetailTransaksi" style="cursor: pointer; border: 1px solid #e3e6f0; border-radius: 8px; transition: all 0.2s ease; height: 100%;">
                <div class="card-body" style="padding: 1.5rem;">
                    <div class="d-flex align-items-center mb-3">
                        <div style="width: 60px; height: 60px; border-radius: 12px; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-receipt" style="font-size: 1.8rem; color: white;"></i>
                        </div>
                        <div style="flex: 1; margin-left: 1rem;">
                            <h5 style="margin: 0; font-weight: 600; color: #333;">Detail Transaksi</h5>
                            <p style="margin: 0; color: #858796; font-size: 0.85rem;">Transaction Listing</p>
                        </div>
                    </div>
                    <p style="color: #666; font-size: 0.9rem; margin-bottom: 1rem;">
                        Daftar lengkap transaksi dengan detail produk, kasir, dan metode bayar.
                    </p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge" style="background: rgba(250, 112, 154, 0.1); color: #fa709a; padding: 0.4rem 0.8rem; border-radius: 6px; font-size: 0.8rem;">
                            <i class="fas fa-file-pdf mr-1"></i>PDF
                        </span>
                        <span style="color: #fa709a; font-weight: 600; font-size: 0.9rem;">
                            Klik untuk generate <i class="fas fa-arrow-right ml-1"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Laporan Inventory -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card report-card" data-toggle="modal" data-target="#modalLaporanInventory" style="cursor: pointer; border: 1px solid #e3e6f0; border-radius: 8px; transition: all 0.2s ease; height: 100%;">
                <div class="card-body" style="padding: 1.5rem;">
                    <div class="d-flex align-items-center mb-3">
                        <div style="width: 60px; height: 60px; border-radius: 12px; background: linear-gradient(135deg, #fbc2eb 0%, #a6c1ee 100%); display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-warehouse" style="font-size: 1.8rem; color: white;"></i>
                        </div>
                        <div style="flex: 1; margin-left: 1rem;">
                            <h5 style="margin: 0; font-weight: 600; color: #333;">Laporan Inventory</h5>
                            <p style="margin: 0; color: #858796; font-size: 0.85rem;">Stock Value & Analysis</p>
                        </div>
                    </div>
                    <p style="color: #666; font-size: 0.9rem; margin-bottom: 1rem;">
                        Nilai inventori, potensi laba, breakdown kategori, dan produk bernilai tinggi.
                    </p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge" style="background: rgba(166, 193, 238, 0.2); color: #a6c1ee; padding: 0.4rem 0.8rem; border-radius: 6px; font-size: 0.8rem;">
                            <i class="fas fa-file-pdf mr-1"></i>PDF
                        </span>
                        <span style="color: #a6c1ee; font-weight: 600; font-size: 0.9rem;">
                            Klik untuk generate <i class="fas fa-arrow-right ml-1"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Laporan Penjualan -->
<div class="modal fade" id="modalLaporanPenjualan" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 12px; border: none;">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px 12px 0 0;">
                <h5 class="modal-title" style="color: white; font-weight: 600;">
                    <i class="fas fa-chart-line mr-2"></i>Laporan Penjualan
                </h5>
                <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 0.9;">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('laporan.penjualan') }}" method="POST" target="_blank">
                @csrf
                <div class="modal-body" style="padding: 2rem;">
                    <div class="form-group">
                        <label style="font-weight: 600; color: #5a5c69;">Periode Laporan</label>
                        <select name="periode" class="form-control" required>
                            <option value="today">Hari Ini</option>
                            <option value="yesterday">Kemarin</option>
                            <option value="this_week">Minggu Ini</option>
                            <option value="last_week">Minggu Lalu</option>
                            <option value="this_month" selected>Bulan Ini</option>
                            <option value="last_month">Bulan Lalu</option>
                            <option value="custom">Custom Range</option>
                        </select>
                    </div>
                    <div id="custom-date-range" style="display: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label style="font-weight: 600; color: #5a5c69;">Tanggal Mulai</label>
                                    <input type="date" name="tanggal_mulai" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label style="font-weight: 600; color: #5a5c69;">Tanggal Akhir</label>
                                    <input type="date" name="tanggal_akhir" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(Auth::user()->hasRole('admin'))
                    <div class="form-group">
                        <label style="font-weight: 600; color: #5a5c69;">Kasir (Opsional)</label>
                        <select name="user_id" class="form-control">
                            <option value="">Semua Kasir</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                </div>
                <div class="modal-footer" style="border-top: 1px solid #e3e6f0;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-info" onclick="viewLaporanPenjualan(this.form)">
                        <i class="fas fa-chart-bar mr-2"></i>Lihat Laporan
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-file-pdf mr-2"></i>Download PDF
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Laporan Stok -->
<div class="modal fade" id="modalLaporanStok" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 12px; border: none;">
            <div class="modal-header" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 12px 12px 0 0;">
                <h5 class="modal-title" style="color: white; font-weight: 600;">
                    <i class="fas fa-boxes mr-2"></i>Laporan Stok
                </h5>
                <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 0.9;">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('laporan.stok') }}" method="POST" target="_blank">
                @csrf
                <div class="modal-body" style="padding: 2rem;">
                    <div class="form-group">
                        <label style="font-weight: 600; color: #5a5c69;">Filter Stok</label>
                        <select name="filter_stok" class="form-control">
                            <option value="semua">Semua Produk</option>
                            <option value="rendah">Stok Rendah (&lt;10 unit)</option>
                            <option value="habis">Stok Habis (0 unit)</option>
                            <option value="tinggi">Stok Berlebih (&gt;100 unit)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label style="font-weight: 600; color: #5a5c69;">Kategori (Opsional)</label>
                        <select name="kategori_id" class="form-control">
                            <option value="">Semua Kategori</option>
                            @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->idkategori }}">{{ $kategori->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #e3e6f0;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn" style="background: #f5576c; color: white;">
                        <i class="fas fa-file-pdf mr-2"></i>Generate PDF
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Laporan Omzet -->
<div class="modal fade" id="modalLaporanOmzet" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 12px; border: none;">
            <div class="modal-header" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 12px 12px 0 0;">
                <h5 class="modal-title" style="color: white; font-weight: 600;">
                    <i class="fas fa-money-bill-wave mr-2"></i>Laporan Omzet Penjualan
                </h5>
                <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 0.9;">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('laporan.omzet') }}" method="POST" target="_blank">
                @csrf
                <div class="modal-body" style="padding: 2rem;">
                    <div class="form-group">
                        <label style="font-weight: 600; color: #5a5c69;">Periode Laporan</label>
                        <select name="periode" class="form-control" required>
                            <option value="today">Hari Ini</option>
                            <option value="yesterday">Kemarin</option>
                            <option value="this_week">Minggu Ini</option>
                            <option value="last_week">Minggu Lalu</option>
                            <option value="this_month" selected>Bulan Ini</option>
                            <option value="last_month">Bulan Lalu</option>
                            <option value="custom">Custom Range</option>
                        </select>
                    </div>
                    <div id="custom-date-range-omzet" style="display: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label style="font-weight: 600; color: #5a5c69;">Tanggal Mulai</label>
                                    <input type="date" name="tanggal_mulai" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label style="font-weight: 600; color: #5a5c69;">Tanggal Akhir</label>
                                    <input type="date" name="tanggal_akhir" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #e3e6f0;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn" style="background: #00f2fe; color: white;">
                        <i class="fas fa-file-pdf mr-2"></i>Generate PDF
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Laporan Laba Rugi -->
<div class="modal fade" id="modalLaporanLabaRugi" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 12px; border: none;">
            <div class="modal-header" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); border-radius: 12px 12px 0 0;">
                <h5 class="modal-title" style="color: white; font-weight: 600;">
                    <i class="fas fa-calculator mr-2"></i>Laporan Laba Rugi
                </h5>
                <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 0.9;">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('laporan.laba-rugi') }}" method="POST" target="_blank">
                @csrf
                <div class="modal-body" style="padding: 2rem;">
                    <div class="form-group">
                        <label style="font-weight: 600; color: #5a5c69;">Periode Laporan</label>
                        <select name="periode" class="form-control" required>
                            <option value="today">Hari Ini</option>
                            <option value="yesterday">Kemarin</option>
                            <option value="this_week">Minggu Ini</option>
                            <option value="last_week">Minggu Lalu</option>
                            <option value="this_month" selected>Bulan Ini</option>
                            <option value="last_month">Bulan Lalu</option>
                            <option value="custom">Custom Range</option>
                        </select>
                    </div>
                    <div id="custom-date-range-laba" style="display: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label style="font-weight: 600; color: #5a5c69;">Tanggal Mulai</label>
                                    <input type="date" name="tanggal_mulai" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label style="font-weight: 600; color: #5a5c69;">Tanggal Akhir</label>
                                    <input type="date" name="tanggal_akhir" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #e3e6f0;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn" style="background: #43e97b; color: white;">
                        <i class="fas fa-file-pdf mr-2"></i>Generate PDF
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Laporan Detail Transaksi -->
<div class="modal fade" id="modalLaporanDetailTransaksi" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 12px; border: none;">
            <div class="modal-header" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); border-radius: 12px 12px 0 0;">
                <h5 class="modal-title" style="color: white; font-weight: 600;">
                    <i class="fas fa-receipt mr-2"></i>Laporan Detail Transaksi
                </h5>
                <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 0.9;">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('laporan.detail-transaksi') }}" method="POST" target="_blank">
                @csrf
                <div class="modal-body" style="padding: 2rem;">
                    <div class="form-group">
                        <label style="font-weight: 600; color: #5a5c69;">Periode Laporan</label>
                        <select name="periode" class="form-control" required>
                            <option value="today">Hari Ini</option>
                            <option value="yesterday">Kemarin</option>
                            <option value="this_week">Minggu Ini</option>
                            <option value="last_week">Minggu Lalu</option>
                            <option value="this_month" selected>Bulan Ini</option>
                            <option value="last_month">Bulan Lalu</option>
                            <option value="custom">Custom Range</option>
                        </select>
                    </div>
                    <div id="custom-date-range-transaksi" style="display: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label style="font-weight: 600; color: #5a5c69;">Tanggal Mulai</label>
                                    <input type="date" name="tanggal_mulai" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label style="font-weight: 600; color: #5a5c69;">Tanggal Akhir</label>
                                    <input type="date" name="tanggal_akhir" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(Auth::user()->hasRole('admin'))
                    <div class="form-group">
                        <label style="font-weight: 600; color: #5a5c69;">Kasir (Opsional)</label>
                        <select name="user_id" class="form-control">
                            <option value="">Semua Kasir</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    <div class="form-group">
                        <label style="font-weight: 600; color: #5a5c69;">Metode Bayar (Opsional)</label>
                        <select name="cara_bayar" class="form-control">
                            <option value="">Semua Metode</option>
                            <option value="cash">Cash</option>
                            <option value="card">Credit/Debit Card</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #e3e6f0;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn" style="background: #fa709a; color: white;">
                        <i class="fas fa-file-pdf mr-2"></i>Generate PDF
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Laporan Inventory -->
<div class="modal fade" id="modalLaporanInventory" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 12px; border: none;">
            <div class="modal-header" style="background: linear-gradient(135deg, #fbc2eb 0%, #a6c1ee 100%); border-radius: 12px 12px 0 0;">
                <h5 class="modal-title" style="color: white; font-weight: 600;">
                    <i class="fas fa-warehouse mr-2"></i>Laporan Inventory
                </h5>
                <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 0.9;">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('laporan.inventory') }}" method="POST" target="_blank">
                @csrf
                <div class="modal-body" style="padding: 2rem;">
                    <div class="form-group">
                        <label style="font-weight: 600; color: #5a5c69;">Kategori (Opsional)</label>
                        <select name="kategori_id" class="form-control">
                            <option value="">Semua Kategori</option>
                            @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->idkategori }}">{{ $kategori->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #e3e6f0;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn" style="background: #a6c1ee; color: white;">
                        <i class="fas fa-file-pdf mr-2"></i>Generate PDF
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.report-card {
    overflow: hidden;
}

.report-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1) !important;
    border-color: var(--primary-color) !important;
}

select[name="periode"] {
    transition: border-color 0.15s ease;
}

select[name="periode"]:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem var(--primary-light);
}
</style>

<script>
$(document).ready(function() {
    // Show/hide custom date range for all periode selects
    $('#modalLaporanPenjualan select[name="periode"]').on('change', function() {
        if ($(this).val() === 'custom') {
            $('#custom-date-range').slideDown();
            $('#modalLaporanPenjualan input[name="tanggal_mulai"]').attr('required', true);
            $('#modalLaporanPenjualan input[name="tanggal_akhir"]').attr('required', true);
        } else {
            $('#custom-date-range').slideUp();
            $('#modalLaporanPenjualan input[name="tanggal_mulai"]').removeAttr('required');
            $('#modalLaporanPenjualan input[name="tanggal_akhir"]').removeAttr('required');
        }
    });

    $('#modalLaporanOmzet select[name="periode"]').on('change', function() {
        if ($(this).val() === 'custom') {
            $('#custom-date-range-omzet').slideDown();
            $('#modalLaporanOmzet input[name="tanggal_mulai"]').attr('required', true);
            $('#modalLaporanOmzet input[name="tanggal_akhir"]').attr('required', true);
        } else {
            $('#custom-date-range-omzet').slideUp();
            $('#modalLaporanOmzet input[name="tanggal_mulai"]').removeAttr('required');
            $('#modalLaporanOmzet input[name="tanggal_akhir"]').removeAttr('required');
        }
    });

    $('#modalLaporanLabaRugi select[name="periode"]').on('change', function() {
        if ($(this).val() === 'custom') {
            $('#custom-date-range-laba').slideDown();
            $('#modalLaporanLabaRugi input[name="tanggal_mulai"]').attr('required', true);
            $('#modalLaporanLabaRugi input[name="tanggal_akhir"]').attr('required', true);
        } else {
            $('#custom-date-range-laba').slideUp();
            $('#modalLaporanLabaRugi input[name="tanggal_mulai"]').removeAttr('required');
            $('#modalLaporanLabaRugi input[name="tanggal_akhir"]').removeAttr('required');
        }
    });

    $('#modalLaporanDetailTransaksi select[name="periode"]').on('change', function() {
        if ($(this).val() === 'custom') {
            $('#custom-date-range-transaksi').slideDown();
            $('#modalLaporanDetailTransaksi input[name="tanggal_mulai"]').attr('required', true);
            $('#modalLaporanDetailTransaksi input[name="tanggal_akhir"]').attr('required', true);
        } else {
            $('#custom-date-range-transaksi').slideUp();
            $('#modalLaporanDetailTransaksi input[name="tanggal_mulai"]').removeAttr('required');
            $('#modalLaporanDetailTransaksi input[name="tanggal_akhir"]').removeAttr('required');
        }
    });

    // Function to view Laporan Penjualan with charts
    window.viewLaporanPenjualan = function(form) {
        const formData = new FormData(form);
        const params = new URLSearchParams();

        for (let [key, value] of formData.entries()) {
            if (value) {
                params.append(key, value);
            }
        }

        const url = '{{ route("laporan.view.penjualan") }}?' + params.toString();
        window.open(url, '_blank');

        // Close modal
        $('#modalLaporanPenjualan').modal('hide');
    };
});
</script>
@endsection
