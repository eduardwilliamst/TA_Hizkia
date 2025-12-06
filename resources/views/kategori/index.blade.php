@extends('layouts.adminlte')

@section('title', 'Kategori')

@section('page-bar')
<h1 class="m-0" style="color: #0d6efd; font-weight: 600;">
    <i class="fas fa-th-large mr-2"></i>
    Kategori Produk
</h1>
@endsection

@section('contents')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card" style="border: 1px solid #e3e6f0; border-radius: 4px; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);">
                <div class="card-header" style="background-color: #fff; border-bottom: 1px solid #e3e6f0; padding: 1rem 1.25rem;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="m-0" style="font-weight: 600; color: #4e73df;">
                            <i class="fas fa-table mr-2"></i>Daftar Kategori Produk
                        </h6>
                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addDataModal" style="padding: 0.4rem 1rem;">
                            <i class="fas fa-plus-circle mr-1"></i>
                            Tambah Kategori
                        </button>
                    </div>
                </div>
                <div class="card-body" style="padding: 1.25rem;">
                    <div class="table-responsive">
                        <table id="kategoriTable" class="table table-bordered" style="width: 100%; border-color: #e3e6f0;">
                            <thead style="background-color: #f8f9fc;">
                                <tr>
                                    <th style="width: 60px; border-color: #e3e6f0; padding: 0.75rem; font-weight: 600; color: #5a5c69; font-size: 0.875rem;">No</th>
                                    <th style="border-color: #e3e6f0; padding: 0.75rem; font-weight: 600; color: #5a5c69; font-size: 0.875rem;">Nama Kategori</th>
                                    <th style="width: 200px; border-color: #e3e6f0; padding: 0.75rem; font-weight: 600; color: #5a5c69; font-size: 0.875rem; text-align: center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kategoris as $index => $kategori)
                                <tr style="background-color: #fff;">
                                    <td style="border-color: #e3e6f0; padding: 0.75rem; color: #5a5c69; font-size: 0.875rem; vertical-align: middle;">{{ $index + 1 }}</td>
                                    <td style="border-color: #e3e6f0; padding: 0.75rem; color: #5a5c69; font-size: 0.875rem; font-weight: 500; vertical-align: middle;">
                                        <i class="fas fa-folder mr-2" style="color: #0d6efd;"></i>{{ $kategori->nama }}
                                    </td>
                                    <td style="border-color: #e3e6f0; padding: 0.75rem; text-align: center; vertical-align: middle;">
                                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalEditKategori" onclick="modalEdit({{ $kategori->idkategori }})" style="padding: 0.4rem 0.9rem; margin-right: 0.25rem;">
                                            <i class="fas fa-edit mr-1"></i>Edit
                                        </button>
                                        <form action="{{ route('kategori.destroy', $kategori->idkategori) }}" method="POST" id="delete-form-{{ $kategori->idkategori }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('delete-form-{{ $kategori->idkategori }}')" style="padding: 0.4rem 0.9rem;">
                                                <i class="fas fa-trash mr-1"></i>Hapus
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
    </div>
</div>

<!-- Modal Tambah Data -->
<div class="modal fade" id="addDataModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border: 1px solid #e3e6f0; border-radius: 4px;">
            <form action="{{ route('kategori.store') }}" method="POST">
                @csrf
                <div class="modal-header" style="background-color: #4e73df; border-bottom: none; padding: 1rem 1.5rem;">
                    <h5 class="modal-title" style="color: white; font-weight: 600; font-size: 1rem;">
                        <i class="fas fa-plus-circle mr-2"></i>
                        Tambah Kategori Baru
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; opacity: 0.9;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding: 1.5rem;">
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #5a5c69; font-size: 0.875rem;">
                            Nama Kategori <span style="color: #e74a3b;">*</span>
                        </label>
                        <input type="text" class="form-control" name="nama" placeholder="Contoh: Elektronik, Makanan, Minuman" required autofocus style="width: 100%; border: 1px solid #d1d3e2; padding: 0.625rem 0.75rem; font-size: 0.875rem; border-radius: 0.25rem;">
                        <div style="font-size: 0.85rem; color: #858796; margin-top: 0.25rem;">
                            <i class="fas fa-info-circle mr-1"></i>Masukkan nama kategori produk
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #e3e6f0; padding: 1rem 1.5rem;">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" style="padding: 0.5rem 1rem;">
                        <i class="fas fa-times mr-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary btn-sm" style="padding: 0.5rem 1rem;">
                        <i class="fas fa-save mr-1"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEditKategori" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" id="modalContent">
        <!-- Content will be loaded via AJAX -->
    </div>
</div>
@endsection

@section('javascript')
<style>
    /* DataTable length menu styling */
    .dataTables_length select {
        padding: 0.375rem 2rem 0.375rem 0.75rem !important;
        font-size: 0.875rem !important;
        border: 1px solid #d1d3e2 !important;
        border-radius: 0.25rem !important;
        background-color: #fff !important;
        color: #5a5c69 !important;
        margin: 0 0.5rem !important;
        min-width: 70px !important;
    }

    .dataTables_length label {
        display: flex !important;
        align-items: center !important;
        font-size: 0.875rem !important;
        color: #5a5c69 !important;
        font-weight: 400 !important;
    }

    /* DataTable search input styling */
    .dataTables_filter {
        text-align: right !important;
    }

    .dataTables_filter input {
        padding: 0.375rem 0.75rem !important;
        font-size: 0.875rem !important;
        border: 1px solid #d1d3e2 !important;
        border-radius: 0.25rem !important;
        margin-left: 0.5rem !important;
        min-width: 200px !important;
    }

    .dataTables_filter label {
        display: inline-flex !important;
        align-items: center !important;
        font-size: 0.875rem !important;
        color: #5a5c69 !important;
        font-weight: 400 !important;
    }
</style>
<script>
    $(document).ready(function() {
        $('#kategoriTable').DataTable({
            responsive: true,
            dom: '<"row mb-3"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                 'rt' +
                 '<"row mt-3"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            pageLength: 25,
            order: [[1, 'asc']],
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ kategori",
                zeroRecords: "Kategori tidak ditemukan",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ kategori",
                infoEmpty: "Tidak ada kategori",
                infoFiltered: "(difilter dari _MAX_ total kategori)",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "›",
                    previous: "‹"
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
                // Auto-focus on edit input after modal loaded
                setTimeout(function() {
                    $('#edit_nama').focus();
                }, 300);
            },
            error: function(xhr) {
                console.log(xhr);
                // Use Swal directly to avoid Toast undefined error
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Memuat Data',
                    text: xhr.responseJSON?.message || 'Terjadi kesalahan saat memuat form edit kategori',
                    timer: 3000,
                    showConfirmButton: false,
                    position: 'top-end',
                    toast: true
                });
            }
        });
    }
</script>
@endsection