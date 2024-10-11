@extends('layouts.adminlte')

@section('title')
Promo
@endsection

@section('contents')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data Promo</h1>
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
                        <h3 class="card-title">List of Promo</h3>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addPromoModal">
                            <i class="fas fa-plus"></i> Tambah Promo
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <table id="promoTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Deskripsi</th>
                            <th>Tanggal Awal</th>
                            <th>Tanggal Akhir</th>
                            <th>Buy X</th>
                            <th>Get Y</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($promos as $promo)
                        <tr>
                            <td>{{ $promo->deskripsi }}</td>
                            <td>{{ \Carbon\Carbon::parse($promo->tanggal_awal)->format('d-m-Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($promo->tanggal_akhir)->format('d-m-Y') }}</td>
                            <td>{{ $promo->buy_x }}</td>
                            <td>{{ $promo->get_y }}</td>
                            <td>
                                <a data-toggle="modal" data-target="#modalEditPromo" onclick="modalEdit({{ $promo->idpromo }})" class="btn btn-info btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('promo.destroy', $promo->idpromo) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?');">
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

<!-- Modal Tambah Promo -->
<div class="modal fade" id="addPromoModal" tabindex="-1" role="dialog" aria-labelledby="addPromoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPromoModalLabel">Tambah Promo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('promo.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <input type="text" class="form-control" id="deskripsi" name="deskripsi" required>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_awal">Tanggal Awal</label>
                        <input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal" required>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_akhir">Tanggal Akhir</label>
                        <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" required>
                    </div>
                    <div class="form-group">
                        <label for="buy_x">Buy X</label>
                        <input type="number" class="form-control" id="buy_x" name="buy_x" placeholder="Masukkan jumlah buy x" required>
                    </div>
                    <div class="form-group">
                        <label for="get_y">Get Y</label>
                        <input type="number" class="form-control" id="get_y" name="get_y" placeholder="Masukkan jumlah get y" required>
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
<div class="modal fade" id="modalEditPromo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" id="modalContent">
        <!-- The content will be filled dynamically -->
    </div>
</div>
@endsection

@section('javascript')
<script>
    $(document).ready(function() {
        $('#promoTable').DataTable();

        // Handle the modal edit for promo
        window.modalEdit = function(promoId) {
            $.ajax({
                type: 'POST',
                url: '{{ route("promo.getEditForm") }}',
                data: {
                    '_token': '<?php echo csrf_token() ?>',
                    'id': promoId,
                },
                success: function(data) {
                    $("#modalContent").html(data.msg);
                    $("#modalEditPromo").modal('show');
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            });
        }
    });
</script>
@endsection
