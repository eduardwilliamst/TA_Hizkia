@extends('layouts.adminlte')

@section('title')
Tipe Pembelian
@endsection

@section('page-bar')
<h1 class="m-0">Data Tipe Pembelian</h1>
@endsection

@section('contents')
<div class="content">
    <div class="container-fluid">
        <div class="card animate-fade-in-up">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h3 class="mb-0">
                            <i class="fas fa-list-alt mr-2"></i>
                            Daftar Tipe Pembelian
                        </h3>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addDataModal" style="padding: 0.7rem 1.5rem; border-radius: 12px;">
                            <i class="fas fa-plus-circle mr-2"></i>Tambah Tipe
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body" style="padding: 2rem;">
                <div style="overflow-x: auto;">
                    <table id="tipeTable" class="table table-hover" style="border-radius: 10px; overflow: hidden;">
                        <thead>
                            <tr>
                                <th style="width: 70%;"><i class="fas fa-tag mr-2"></i>Keterangan</th>
                                <th style="width: 30%; text-align: center;"><i class="fas fa-cog mr-2"></i>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tipes as $tipe)
                            <tr class="animate-fade-in">
                                <td style="font-weight: 600; color: #333; font-size: 1.05rem;">
                                    <i class="fas fa-file-invoice mr-2" style="color: #667eea;"></i>
                                    {{ $tipe->keterangan }}
                                </td>
                                <td style="text-align: center;">
                                    <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                        <a data-toggle="modal" data-target="#modalEditTipe" onclick="modalEdit({{ $tipe->idtipe }})" class="btn btn-info btn-sm" style="border-radius: 8px; padding: 0.5rem 1rem;" title="Edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('tipe.destroy', $tipe->idtipe) }}" method="POST" id="delete-form-{{ $tipe->idtipe }}" style="display:inline; margin: 0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm" style="border-radius: 8px; padding: 0.5rem 1rem;" onclick="confirmDelete('delete-form-{{ $tipe->idtipe }}')" title="Hapus">
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

<!-- Modal Tambah Data -->
<div class="modal fade" id="addDataModal" tabindex="-1" role="dialog" aria-labelledby="addDataModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDataModalLabel">Tambah Data Tipe Pembelian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('tipe.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Masukkan keterangan tipe pembelian" required>
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
<div class="modal fade" id="modalEditTipe" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" id="modalContent">

    </div>
</div>
@endsection

@section('javascript')
<script>
    $(document).ready(function() {
        $('#tipeTable').DataTable({
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

        // Form Tambah Tipe
        $('#addDataModal form').on('submit', function(e) {
            e.preventDefault();

            const form = $(this);
            const formData = new FormData(this);
            const submitBtn = form.find('button[type="submit"]');

            LoaderUtil.show('Menyimpan tipe pembelian...');
            submitBtn.prop('disabled', true);

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    LoaderUtil.hide();
                    $('#addDataModal').modal('hide');

                    Toast.fire({
                        icon: 'success',
                        title: 'Tipe pembelian berhasil ditambahkan!'
                    });

                    setTimeout(() => window.location.reload(), 1500);
                },
                error: function(xhr) {
                    LoaderUtil.hide();
                    submitBtn.prop('disabled', false);

                    let errorMessage = 'Terjadi kesalahan saat menyimpan tipe pembelian';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        const errors = xhr.responseJSON.errors;
                        errorMessage = '<ul style="text-align: left; margin: 0;">';
                        for (let field in errors) {
                            errors[field].forEach(error => {
                                errorMessage += `<li>${error}</li>`;
                            });
                        }
                        errorMessage += '</ul>';
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        html: errorMessage,
                        confirmButtonColor: '#d33'
                    });
                }
            });
        });

        // Form Edit Tipe (delegated event)
        $(document).on('submit', '#modalEditTipe form', function(e) {
            e.preventDefault();

            const form = $(this);
            const formData = new FormData(this);
            const submitBtn = form.find('button[type="submit"]');

            LoaderUtil.show('Memperbarui tipe pembelian...');
            submitBtn.prop('disabled', true);

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    LoaderUtil.hide();
                    $('#modalEditTipe').modal('hide');

                    Toast.fire({
                        icon: 'success',
                        title: 'Tipe pembelian berhasil diperbarui!'
                    });

                    setTimeout(() => window.location.reload(), 1500);
                },
                error: function(xhr) {
                    LoaderUtil.hide();
                    submitBtn.prop('disabled', false);

                    let errorMessage = 'Terjadi kesalahan saat memperbarui tipe pembelian';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        const errors = xhr.responseJSON.errors;
                        errorMessage = '<ul style="text-align: left; margin: 0;">';
                        for (let field in errors) {
                            errors[field].forEach(error => {
                                errorMessage += `<li>${error}</li>`;
                            });
                        }
                        errorMessage += '</ul>';
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        html: errorMessage,
                        confirmButtonColor: '#d33'
                    });
                }
            });
        });
    });

    function modalEdit(tipeId) {
        LoaderUtil.show('Memuat form edit...');

        $.ajax({
            type: 'POST',
            url: '{{ route("tipe.getEditForm") }}',
            data: {
                '_token': '<?php echo csrf_token() ?>',
                'id': tipeId,
            },
            success: function(data) {
                LoaderUtil.hide();
                $("#modalContent").html(data.msg);
            },
            error: function(xhr) {
                LoaderUtil.hide();
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Gagal memuat form edit tipe pembelian',
                    confirmButtonColor: '#d33'
                });
            }
        });
    }
</script>
@endsection
