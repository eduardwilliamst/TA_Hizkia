@extends('layouts.adminlte')

@section('title')
Perkiraan
@endsection

@section('page-bar')
<h1 class="m-0">Daftar No. Perkiraan</h1>
@endsection

@section('contents')
<div class="content">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <!-- Button Group -->
                <div class="btn-group mb-2" role="group" aria-label="Button group">
                    <a type="button" class="btn btn-danger" data-toggle="modal" data-target="#addDataModal" onclick="modalAdd()">
                        Baru
                    </a>
                    <a type="button" class="btn btn-danger">Hapus</a>
                    <a type="button" class="btn btn-danger">Koreksi</a>
                    <a type="button" class="btn btn-danger" data-toggle="modal" data-target="#anggaranModal">
                        Anggaran
                    </a>
                    <a type="button" class="btn btn-danger" data-toggle="modal" data-target="#bukuBesarModal">
                        Buku Besar
                    </a>
                    <a type="button" class="btn btn-danger">Saldo</a>
                    <a type="button" class="btn btn-danger">Keluar</a>
                </div>

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="asset-tab" data-toggle="tab" href="#asset" role="tab" aria-controls="asset" aria-selected="true">Asset</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="hutang-tab" data-toggle="tab" href="#hutang" role="tab" aria-controls="hutang" aria-selected="false">Hutang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="modal-tab" data-toggle="tab" href="#modal" role="tab" aria-controls="modal" aria-selected="false">Modal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pendapatan-tab" data-toggle="tab" href="#pendapatan" role="tab" aria-controls="pendapatan" aria-selected="false">Pendapatan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="biaya-langsung-tab" data-toggle="tab" href="#biaya-langsung" role="tab" aria-controls="biaya-langsung" aria-selected="false">Biaya Langsung</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="biaya-tak-langsung-tab" data-toggle="tab" href="#biaya-tak-langsung" role="tab" aria-controls="biaya-tak-langsung" aria-selected="false">Biaya Tak Langsung</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="lain-lain-tab" data-toggle="tab" href="#lain-lain" role="tab" aria-controls="lain-lain" aria-selected="false">Lain-lain</a>
                    </li>
                </ul>
            </div>

            <div class="card-body">
                <div class="tab-content" id="myTabContent">
                    <!-- Asset tab content -->
                    <div class="tab-pane fade show active" id="asset" role="tabpanel" aria-labelledby="asset-tab">
                        <table id="perkiraanTable1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 10%;">No. Perkiraan</th>
                                    <th>Nama Perkiraan</th>
                                    <th>Tingkat</th>
                                    <th>Tipe</th>
                                    <th style="width: 5%;">S</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1-1020</td>
                                    <td>Kas Kecil</td>
                                    <td>D</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Hutang tab content -->
                    <div class="tab-pane fade" id="hutang" role="tabpanel" aria-labelledby="hutang-tab">
                        <table id="perkiraanTable2" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 10%;">No. Perkiraan</th>
                                    <th>Nama Perkiraan</th>
                                    <th>Tingkat</th>
                                    <th>Tipe</th>
                                    <th style="width: 5%;">S</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1-1020</td>
                                    <td>Kas Kecil</td>
                                    <td>D</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Modal tab content -->
                    <div class="tab-pane fade" id="modal" role="tabpanel" aria-labelledby="modal-tab">
                        <table id="perkiraanTable3" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 10%;">No. Perkiraan</th>
                                    <th>Nama Perkiraan</th>
                                    <th>Tingkat</th>
                                    <th>Tipe</th>
                                    <th style="width: 5%;">S</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1-1020</td>
                                    <td>Kas Kecil</td>
                                    <td>D</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pendapatan tab content -->
                    <div class="tab-pane fade" id="pendapatan" role="tabpanel" aria-labelledby="pendapatan-tab">
                        <table id="perkiraanTable4" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 10%;">No. Perkiraan</th>
                                    <th>Nama Perkiraan</th>
                                    <th>Tingkat</th>
                                    <th>Tipe</th>
                                    <th style="width: 5%;">S</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1-1020</td>
                                    <td>Kas Kecil</td>
                                    <td>D</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Biaya Langsung tab content -->
                    <div class="tab-pane fade" id="biaya-langsung" role="tabpanel" aria-labelledby="biaya-langsung-tab">
                        <table id="perkiraanTable5" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 10%;">No. Perkiraan</th>
                                    <th>Nama Perkiraan</th>
                                    <th>Tingkat</th>
                                    <th>Tipe</th>
                                    <th style="width: 5%;">S</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1-1020</td>
                                    <td>Kas Kecil</td>
                                    <td>D</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Biaya Tak Langsung tab content -->
                    <div class="tab-pane fade" id="biaya-tak-langsung" role="tabpanel" aria-labelledby="biaya-tak-langsung-tab">
                        <table id="perkiraanTable6" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 10%;">No. Perkiraan</th>
                                    <th>Nama Perkiraan</th>
                                    <th>Tingkat</th>
                                    <th>Tipe</th>
                                    <th style="width: 5%;">S</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1-1020</td>
                                    <td>Kas Kecil</td>
                                    <td>D</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Lain-lain tab content -->
                    <div class="tab-pane fade" id="lain-lain" role="tabpanel" aria-labelledby="lain-lain-tab">
                        <table id="perkiraanTable7" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 10%;">No. Perkiraan</th>
                                    <th>Nama Perkiraan</th>
                                    <th>Tingkat</th>
                                    <th>Tipe</th>
                                    <th style="width: 5%;">S</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1-1020</td>
                                    <td>Kas Kecil</td>
                                    <td>D</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk menambahkan data baru -->
<div class="modal fade" id="addDataModal" tabindex="-1" role="dialog" aria-labelledby="addDataModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDataModalLabel">Tambah Data Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form untuk menambahkan data baru -->
                <form action="{{ route('perkiraan.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="no_perkiraan">No</label>
                        <input type="text" class="form-control" id="no_perkiraan" name="no_perkiraan" required>
                    </div>
                    <div class="form-group">
                        <label for="no_pusat">No. Pusat</label>
                        <input type="text" class="form-control" id="no_pusat" name="no_pusat" required>
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="perkiraan_tidak_aktif" name="perkiraan_tidak_aktif">
                            <label class="form-check-label" for="perkiraan_tidak_aktif">Perkiraan Tidak Aktif</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="group_perkiraan">Group Perkiraan</label>
                        <select class="form-control" id="group_perkiraan" name="group_perkiraan">
                            <option value="asset">Asset</option>
                            <option value="hutang">Hutang</option>
                            <option value="modal">Modal</option>
                            <option value="pendapatan">Pendapatan</option>
                            <option value="biaya_langsung">Biaya Langsung</option>
                            <option value="biaya_tak_langsung">Biaya Tak Langsung</option>
                            <option value="lain-lain">Lain-lain</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tingkat_perkiraan">Tingkat Perkiraan</label>
                        <select class="form-control" id="tingkat_perkiraan" name="tingkat_perkiraan">
                            <option value="group">Group (Tidak untuk Posting)</option>
                            <option value="sub_group">Sub Group (Tidak untuk Posting)</option>
                            <option value="detail">Detail Perkiraan (Posting)</option>
                        </select>
                    </div>
                    <!-- Tambahkan field lain sesuai kebutuhan -->
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Buku Besar -->
<div class="modal fade" id="bukuBesarModal" tabindex="-1" role="dialog" aria-labelledby="bukuBesarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bukuBesarModalLabel">Buku Besar Perkiraan/Buku Pembantu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>GL.No#</th>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Debet</th>
                                <th>Kredit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data Buku Besar -->
                            <tr>
                                <td>1-1020</td>
                                <td>08/12/2024</td>
                                <td>Transaksi 1</td>
                                <td>1,000,000</td>
                                <td>500,000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Saldo Awal Per Tanggal</label>
                        <input type="text" class="form-control" value="0.00" readonly>
                    </div>
                    <div class="col-md-6 text-right">
                        <label>Total</label>
                        <div>
                            <span>Debet: 1,000,000</span> |
                            <span>Kredit: 500,000</span> |
                            <span>Saldo: 500,000</span>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <label>Transaksi Jurnals</label>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <!-- Data Transaksi Jurnals -->
                            <tbody>
                                <tr>
                                    <td>08/12/2024</td>
                                    <td>Transaksi 2</td>
                                    <td>1,000,000</td>
                                    <td>500,000</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="tanggal">Dari Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal">
                    </div>
                    <div class="col-md-6 text-right">
                        <button type="button" class="btn btn-primary mt-4">Store</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Keluar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Anggaran -->
<div class="modal fade" id="anggaranModal" tabindex="-1" role="dialog" aria-labelledby="anggaranModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="anggaranModalLabel">Isi Anggaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="noPerkiraan">No.Perkiraan</label>
                        <input type="text" class="form-control" id="noPerkiraan" placeholder="1-1121" readonly>
                    </div>
                    <div class="form-group">
                        <label for="namaPerkiraan">Nama</label>
                        <input type="text" class="form-control" id="namaPerkiraan" placeholder="Piutang Pihak Ke 3" readonly>
                    </div>
                    <div class="form-group">
                        <label for="tahun">Tahun</label>
                        <input type="text" class="form-control" id="tahun" placeholder="2024" readonly>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Periode</th>
                                    <th>Fiskal Lalu</th>
                                    <th>Fiskal Aktif</th>
                                    <th>Fiskal Berikut</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data Anggaran -->
                                <tr>
                                    <td>01-Jan</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                </tr>
                                <!-- Tambahkan lebih banyak baris sesuai kebutuhan -->
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group">
                        <label for="copyAnggaran">Copy Anggaran</label>
                        <div class="input-group">
                            <select class="form-control">
                                <option value="Lalu">Lalu</option>
                                <option value="Aktif">Aktif</option>
                                <option value="Berikut">Berikut</option>
                            </select>
                            <span class="input-group-text">Ke</span>
                            <select class="form-control">
                                <option value="Lalu">Lalu</option>
                                <option value="Aktif">Aktif</option>
                                <option value="Berikut">Berikut</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success">Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script>
    $(document).ready(function() {
        $('#perkiraanTable1').DataTable();
        $('#perkiraanTable2').DataTable();
        $('#perkiraanTable3').DataTable();
        $('#perkiraanTable4').DataTable();
        $('#perkiraanTable5').DataTable();
        $('#perkiraanTable6').DataTable();
        $('#perkiraanTable7').DataTable();
    });

    function printPage() {
        window.print();
    }

    function simpan() {
        alert('Simpan button clicked');
    }

    function modalAdd() {
        $('#addDataModal').modal('show');
    }
</script>
@endsection