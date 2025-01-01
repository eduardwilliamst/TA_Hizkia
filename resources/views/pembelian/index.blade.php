@extends('layouts.adminlte')

@section('title')
List Pembelian
@endsection

@section('contents')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data Pembelian</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="card-title">List of Pembelians</h3>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addPembelianModal">
                            <i class="fas fa-plus"></i> Tambah Pembelian
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <table id="pembelianTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Tanggal Pesan</th>
                            <th>Tanggal Datang</th>
                            <th>Pembelian</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pembelians as $pembelian)
                        <tr>
                            <td>{{ $pembelian->tanggal_pesan }}</td>
                            <td>{{ $pembelian->tanggal_datang }}</td>
                            <td>{{ $pembelian->pembelian->nama_pembelian }}</td>  <!-- Menampilkan nama pembelian -->
                            <td>
                                <form action="{{ route('pembelian.destroy', $pembelian->idpembelian) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this pembelian?');">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Pembelian -->
<div class="modal fade" id="addPembelianModal" tabindex="-1" role="dialog" aria-labelledby="addPembelianModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPembelianModalLabel">Tambah Pembelian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('pembelian.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="tanggal_pesan">Tanggal Pesan</label>
                        <input type="date" class="form-control" id="tanggal_pesan" name="tanggal_pesan" required>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_datang">Tanggal Datang</label>
                        <input type="date" class="form-control" id="tanggal_datang" name="tanggal_datang" required>
                    </div>
                    <div class="form-group">
                        <label for="idproduks">Produks</label>
                        <select class="form-control" id="idproduks" name="idproduks" required>
                            @foreach($produks as $produk)
                                <option value="{{ $produk->idproduk }}">{{ $produk->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="supplier_idsupplier">Supplier</label>
                        <select class="form-control" id="supplier_idsupplier" name="supplier_idsupplier" required>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->idsupplier }}">{{ $supplier->nama_supplier }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEditPembelian" tabindex="-1" aria-labelledby="modalEditPembelianLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" id="modalContent">

    </div>
</div>
@endsection

@section('javascript')
<script>
    $(document).ready(function() {
        $('#pembelianTable').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'excel',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                },
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                },
            ]
        });
    });

    function modalEdit(pembelianId) {
        $.ajax({
            type: 'POST',
            url: '{{ route("pembelian.getEditForm") }}',
            data: {
                '_token': '<?php echo csrf_token() ?>',
                'id': pembelianId,
            },
            success: function(data) {
                $("#modalContent").html(data.msg);
            },
            error: function(xhr) {
                console.log(xhr);
            }
        });
    }
</script>
@endsection
