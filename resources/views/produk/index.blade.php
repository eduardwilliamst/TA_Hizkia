@extends('layouts.adminlte')

@section('title')
Produk
@endsection

@section('page-bar')
<h1 class="m-0">Data Produk</h1>
@endsection

@section('contents')
<div class="content">
    <div class="container-fluid">
        <div class="card animate-fade-in-up">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h3 class="mb-0">
                            <i class="fas fa-box-open mr-2"></i>
                            Daftar Produk
                        </h3>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addProdukModal" style="padding: 0.7rem 1.5rem; border-radius: 12px;">
                            <i class="fas fa-plus-circle mr-2"></i>Tambah Produk
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body" style="padding: 2rem;">
                <div style="overflow-x: auto;">
                    <table id="produkTable" class="table table-hover" style="border-radius: 10px; overflow: hidden;">
                        <thead>
                            <tr>
                                <th style="width: 15%;"><i class="fas fa-barcode mr-2"></i>Barcode</th>
                                <th style="width: 30%;"><i class="fas fa-tag mr-2"></i>Nama Produk</th>
                                <th style="width: 20%;"><i class="fas fa-money-bill-wave mr-2"></i>Harga</th>
                                <th style="width: 15%;"><i class="fas fa-box mr-2"></i>Stok</th>
                                <th style="width: 20%; text-align: center;"><i class="fas fa-cog mr-2"></i>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($produks as $produk)
                            <tr class="animate-fade-in">
                                <td style="font-weight: 500; color: #666;">
                                    <span style="background: #f8f9fa; padding: 0.4rem 0.8rem; border-radius: 8px; display: inline-block;">
                                        {{ $produk->barcode }}
                                    </span>
                                </td>
                                <td style="font-weight: 600; color: #333;">{{ $produk->nama }}</td>
                                <td style="color: #667eea; font-weight: 700; font-size: 1.05rem;">
                                    Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                </td>
                                <td>
                                    <span class="badge" style="padding: 0.5rem 1rem; border-radius: 20px; font-weight: 600;
                                        background: {{ $produk->stok > 20 ? 'linear-gradient(135deg, #11998e 0%, #38ef7d 100%)' : ($produk->stok > 10 ? 'linear-gradient(135deg, #f39c12 0%, #e67e22 100%)' : 'linear-gradient(135deg, #eb3349 0%, #f45c43 100%)') }};
                                        color: white;">
                                        {{ $produk->stok }} Unit
                                    </span>
                                </td>
                                <td style="text-align: center;">
                                    <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                        <a data-toggle="modal" data-target="#modalDetailProduk" onclick="modalDetail({{ $produk->idproduk }})" class="btn btn-success btn-sm" style="border-radius: 8px; padding: 0.5rem 1rem;" title="Detail">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                        <a data-toggle="modal" data-target="#modalEditProduk" onclick="modalEdit({{ $produk->idproduk }})" class="btn btn-info btn-sm" style="border-radius: 8px; padding: 0.5rem 1rem;" title="Edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('produk.destroy', $produk->idproduk) }}" method="POST" id="delete-form-{{ $produk->idproduk }}" style="display:inline; margin: 0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm" style="border-radius: 8px; padding: 0.5rem 1rem;" onclick="confirmDelete('delete-form-{{ $produk->idproduk }}')" title="Hapus">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Produk -->
<div class="modal fade" id="addProdukModal" tabindex="-1" role="dialog" aria-labelledby="addProdukModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProdukModalLabel">Tambah Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="barcode">Barcode</label>
                        <input type="text" class="form-control" id="barcode" name="barcode" placeholder="Masukkan barcode" required>
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama Produk</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama produk" required>
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <input type="number" class="form-control" id="harga" name="harga" placeholder="Masukkan harga" required>
                    </div>
                    <div class="form-group">
                        <label for="stok">Stok</label>
                        <input type="number" class="form-control" id="stok" name="stok" placeholder="Masukkan jumlah stok" required>
                    </div>
                    <div class="form-group">
                        <label for="gambar">Gambar</label>
                        <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" required>
                    </div>
                    <div class="form-group">
                        <label for="kategori_idkategori">Kategori</label>
                        <select class="form-control" id="kategori_idkategori" name="kategori_idkategori" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->idkategori }}">{{ $kategori->nama }}</option>
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

<!-- Modal Detail -->
<div class="modal fade" id="modalDetailProduk" tabindex="-1" aria-labelledby="modalDetailProdukLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" id="modalDetailContent">

    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEditProduk" tabindex="-1" aria-labelledby="modalEditProdukLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" id="modalContent">

    </div>
</div>
@endsection

@section('javascript')
<script>
    $(document).ready(function() {
        $('#produkTable').DataTable({
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

    function modalDetail(produkId) {
        $.ajax({
            type: 'POST',
            url: '{{ route("produk.getDetailForm") }}',
            data: {
                '_token': '<?php echo csrf_token() ?>',
                'id': produkId,
            },
            success: function(data) {
                $("#modalDetailContent").html(data.msg);
            },
            error: function(xhr) {
                console.log(xhr);
            }
        });
    }

    function modalEdit(produkId) {
        $.ajax({
            type: 'POST',
            url: '{{ route("produk.getEditForm") }}',
            data: {
                '_token': '<?php echo csrf_token() ?>',
                'id': produkId,
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