@extends('layouts.pos')

@section('title', 'Kategori')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">Data Kategori</h1>
    <div class="page-breadcrumb">
        <div class="breadcrumb-item">
            <a href="{{ route('dashboard') }}" class="breadcrumb-link">
                <i class="fas fa-home"></i>
                Dashboard
            </a>
        </div>
        <div class="breadcrumb-item">
            <span>Kategori</span>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-th-large" style="margin-right: 0.5rem;"></i>
            Daftar Kategori
        </h3>
        <div>
            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addDataModal">
                <i class="fas fa-plus-circle"></i>
                Tambah Kategori
            </a>
        </div>
    </div>

    <div class="card-body">
        <div style="overflow-x: auto;">
            <table id="kategoriTable" class="datatable" style="width: 100%;">
                <thead>
                    <tr>
                        <th><i class="fas fa-tag" style="margin-right: 0.5rem;"></i>Nama Kategori</th>
                        <th style="text-align: center;"><i class="fas fa-cog" style="margin-right: 0.5rem;"></i>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kategoris as $kategori)
                    <tr>
                        <td style="font-weight: 600; color: #1F2937;">
                            <i class="fas fa-folder" style="margin-right: 0.5rem; color: #4F46E5;"></i>
                            {{ $kategori->nama }}
                        </td>
                        <td style="text-align: center;">
                            <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                <button data-toggle="modal" data-target="#modalEditKategori" onclick="modalEdit({{ $kategori->idkategori }})" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('kategori.destroy', $kategori->idkategori) }}" method="POST" id="delete-form-{{ $kategori->idkategori }}" style="display:inline; margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('delete-form-{{ $kategori->idkategori }}')" title="Hapus">
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

<!-- Modal Tambah Data -->
<div class="modal fade" id="addDataModal" tabindex="-1" role="dialog" aria-labelledby="addDataModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDataModalLabel">Tambah Data Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('kategori.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nama">Nama Kategori</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama kategori">
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
<div class="modal fade" id="modalEditKategori" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" id="modalContent">
    </div>
</div>
@endsection

@section('scripts')
<script>
    function modalEdit(id) {
        load_modal('{{csrf_token()}}', '{{route("kategori.edit")}}', '#modalEditKategori', id);
    }
</script>
@endsection
