@extends('layouts.pos')

@section('title', 'Produk')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">Data Produk</h1>
    <div class="page-breadcrumb">
        <div class="breadcrumb-item">
            <a href="{{ route('dashboard') }}" class="breadcrumb-link">
                <i class="fas fa-home"></i>
                Dashboard
            </a>
        </div>
        <div class="breadcrumb-item">
            <span>Produk</span>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-box-open" style="margin-right: 0.5rem;"></i>
            Daftar Produk
        </h3>
        <div>
            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addProdukModal">
                <i class="fas fa-plus-circle"></i>
                Tambah Produk
            </a>
        </div>
    </div>

    <div class="card-body">
        <div style="overflow-x: auto;">
            <table id="produkTable" class="datatable" style="width: 100%;">
                <thead>
                    <tr>
                        <th><i class="fas fa-barcode" style="margin-right: 0.5rem;"></i>Barcode</th>
                        <th><i class="fas fa-tag" style="margin-right: 0.5rem;"></i>Nama Produk</th>
                        <th><i class="fas fa-money-bill-wave" style="margin-right: 0.5rem;"></i>Harga</th>
                        <th><i class="fas fa-box" style="margin-right: 0.5rem;"></i>Stok</th>
                        <th style="text-align: center;"><i class="fas fa-cog" style="margin-right: 0.5rem;"></i>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produks as $produk)
                    <tr>
                        <td style="font-weight: 500; color: #6B7280;">
                            <span style="background: #F9FAFB; padding: 0.375rem 0.75rem; border-radius: 6px; display: inline-block; border: 1px solid #E5E7EB;">
                                {{ $produk->barcode }}
                            </span>
                        </td>
                        <td style="font-weight: 600; color: #1F2937;">{{ $produk->nama }}</td>
                        <td style="color: #10B981; font-weight: 600;">
                            Rp {{ number_format($produk->harga, 0, ',', '.') }}
                        </td>
                        <td>
                            @if($produk->stok > 20)
                                <span class="badge" style="padding: 0.375rem 0.75rem; border-radius: 6px; font-weight: 600; background: #D1FAE5; color: #065F46;">
                                    {{ $produk->stok }} Unit
                                </span>
                            @elseif($produk->stok > 10)
                                <span class="badge" style="padding: 0.375rem 0.75rem; border-radius: 6px; font-weight: 600; background: #FEF3C7; color: #92400E;">
                                    {{ $produk->stok }} Unit
                                </span>
                            @else
                                <span class="badge" style="padding: 0.375rem 0.75rem; border-radius: 6px; font-weight: 600; background: #FEE2E2; color: #991B1B;">
                                    {{ $produk->stok }} Unit
                                </span>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                <button data-toggle="modal" data-target="#modalDetailProduk" onclick="modalDetail({{ $produk->idproduk }})" class="btn btn-sm btn-primary" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button data-toggle="modal" data-target="#modalEditProduk" onclick="modalEdit({{ $produk->idproduk }})" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('produk.destroy', $produk->idproduk) }}" method="POST" id="delete-form-{{ $produk->idproduk }}" style="display:inline; margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('delete-form-{{ $produk->idproduk }}')" title="Hapus">
                                        <i class="fas fa-trash"></i>
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

@section('scripts')
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