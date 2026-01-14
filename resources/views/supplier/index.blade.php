@extends('layouts.adminlte')

@section('title')
Supplier
@endsection

@section('page-bar')
<h1 class="m-0">Data Supplier</h1>
@endsection

@section('contents')
<div class="content">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="card-title">List of Suppliers</h3>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addSupplierModal">
                            <i class="fas fa-plus"></i> Tambah Supplier
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <table id="supplierTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($suppliers as $supplier)
                        <tr>
                            <td>{{ $supplier->nama }}</td>
                            <td>{{ $supplier->alamat }}</td>
                            <td>{{ $supplier->telp }}</td>
                            <td>
                                <a data-toggle="modal" data-target="#modalEditSupplier" onclick="modalEdit({{ $supplier->idsupplier }})" class="btn btn-info btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('supplier.destroy', $supplier->idsupplier) }}" method="POST" id="delete-form-{{ $supplier->idsupplier }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('delete-form-{{ $supplier->idsupplier }}')">
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

<!-- Modal Tambah Supplier -->
<div class="modal fade" id="addSupplierModal" tabindex="-1" role="dialog" aria-labelledby="addSupplierModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSupplierModalLabel">Tambah Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('supplier.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama supplier" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukkan alamat supplier" required>
                    </div>
                    <div class="form-group">
                        <label for="telp">Telepon</label>
                        <input type="text" class="form-control" id="telp" name="telp" placeholder="Masukkan telepon supplier" required>
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
<div class="modal fade" id="modalEditSupplier" tabindex="-1" aria-labelledby="modalEditSupplierLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" id="modalContent">

    </div>
</div>
@endsection

@section('javascript')
<script>
    $(document).ready(function() {
        $('#supplierTable').DataTable({
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

        // Form Tambah Supplier
        $('#addSupplierModal form').on('submit', function(e) {
            e.preventDefault();

            const form = $(this);
            const formData = new FormData(this);
            const submitBtn = form.find('button[type="submit"]');

            LoaderUtil.show('Menyimpan supplier...');
            submitBtn.prop('disabled', true);

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    LoaderUtil.hide();
                    $('#addSupplierModal').modal('hide');

                    Toast.fire({
                        icon: 'success',
                        title: 'Supplier berhasil ditambahkan!'
                    });

                    setTimeout(() => window.location.reload(), 1500);
                },
                error: function(xhr) {
                    LoaderUtil.hide();
                    submitBtn.prop('disabled', false);

                    let errorMessage = 'Terjadi kesalahan saat menyimpan supplier';
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

        // Form Edit Supplier (delegated event)
        $(document).on('submit', '#modalEditSupplier form', function(e) {
            e.preventDefault();

            const form = $(this);
            const formData = new FormData(this);
            const submitBtn = form.find('button[type="submit"]');

            LoaderUtil.show('Memperbarui supplier...');
            submitBtn.prop('disabled', true);

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    LoaderUtil.hide();
                    $('#modalEditSupplier').modal('hide');

                    Toast.fire({
                        icon: 'success',
                        title: 'Supplier berhasil diperbarui!'
                    });

                    setTimeout(() => window.location.reload(), 1500);
                },
                error: function(xhr) {
                    LoaderUtil.hide();
                    submitBtn.prop('disabled', false);

                    let errorMessage = 'Terjadi kesalahan saat memperbarui supplier';
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

    function modalEdit(supplierId) {
        LoaderUtil.show('Memuat form edit...');

        $.ajax({
            type: 'POST',
            url: '{{ route("supplier.getEditForm") }}',
            data: {
                '_token': '<?php echo csrf_token() ?>',
                'id': supplierId,
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
                    text: 'Gagal memuat form edit supplier',
                    confirmButtonColor: '#d33'
                });
            }
        });
    }
</script>
@endsection