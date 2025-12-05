@extends('layouts.adminlte')

@section('title', 'Kategori')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">
                    <i class="fas fa-th-large me-2"></i>
                    Kategori Produk
                </h1>
            </div>
            <div class="col-sm-6">
                <div class="float-sm-right">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDataModal">
                        <i class="fas fa-plus me-2"></i>
                        Tambah Kategori
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
<div class="row">
    <div class="col-12">
        <div class="card animate-fade-in-up">
            <div class="card-header">
                <h3 class="card-title">Daftar Kategori</h3>
                <div class="card-actions">
                    <span class="badge bg-azure-lt">{{ $kategoris->count() }} Kategori</span>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="kategoriTable" class="table table-vcenter table-hover">
                        <thead>
                            <tr>
                                <th><i class="fas fa-tag me-2"></i>Nama Kategori</th>
                                <th class="text-center" style="width: 200px;"><i class="fas fa-cog me-2"></i>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kategoris as $kategori)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="avatar avatar-sm me-3" style="background: #0d6efd;">
                                            <i class="fas fa-folder" style="color: white;"></i>
                                        </span>
                                        <div>
                                            <div class="fw-bold">{{ $kategori->nama }}</div>
                                            <div class="text-muted small">ID: {{ $kategori->idkategori }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-cyan" data-bs-toggle="modal" data-bs-target="#modalEditKategori" onclick="modalEdit({{ $kategori->idkategori }})" title="Edit">
                                            <i class="fas fa-edit me-1"></i> Edit
                                        </button>
                                        <form action="{{ route('kategori.destroy', $kategori->idkategori) }}" method="POST" id="delete-form-{{ $kategori->idkategori }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('delete-form-{{ $kategori->idkategori }}')" title="Hapus">
                                                <i class="fas fa-trash me-1"></i> Hapus
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
    </div>
</div>

<!-- Modal Tambah Data -->
<div class="modal modal-blur fade" id="addDataModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('kategori.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-plus-circle me-2 text-primary"></i>
                        Tambah Data Kategori
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label required">Nama Kategori</label>
                        <input type="text" class="form-control" name="nama" placeholder="Masukkan nama kategori" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal modal-blur fade" id="modalEditKategori" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" id="modalContent">
        <!-- Content will be loaded via AJAX -->
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#kategoriTable').DataTable({
            responsive: true,
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>B',
            buttons: [
                {
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel me-1"></i> Excel',
                    className: 'btn btn-success btn-sm',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                },
                {
                    extend: 'pdf',
                    text: '<i class="fas fa-file-pdf me-1"></i> PDF',
                    className: 'btn btn-danger btn-sm',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print me-1"></i> Print',
                    className: 'btn btn-info btn-sm',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                }
            ],
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                zeroRecords: "Data tidak ditemukan",
                info: "Menampilkan halaman _PAGE_ dari _PAGES_",
                infoEmpty: "Tidak ada data yang tersedia",
                infoFiltered: "(difilter dari _MAX_ total data)",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                }
            }
        });
    });

    function modalEdit(kategoriId) {
        $.ajax({
            type: 'POST',
            url: '{{ route("kategori.getEditForm") }}',
            data: {
                '_token': '{{ csrf_token() }}',
                'id': kategoriId,
            },
            success: function(data) {
                $("#modalContent").html(data.msg);
            },
            error: function(xhr) {
                console.log(xhr);
                Toast.fire({
                    icon: 'error',
                    title: 'Gagal memuat data'
                });
            }
        });
    }
</script>
@endsection