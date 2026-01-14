@extends('layouts.adminlte')

@section('title')
List Pembelian
@endsection

@section('page-bar')
<h1 class="m-0">Data Pembelian</h1>
@endsection


@section('contents')
<div class="content">
    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="card-title"><i class="fas fa-shopping-cart mr-2"></i>Daftar Pembelian</h3>
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
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>Supplier</th>
                            <th>Tipe</th>
                            <th>Produk</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pembelians as $pembelian)
                        <tr>
                            <td>{{ $pembelian->idpembelian }}</td>
                            <td>{{ \Carbon\Carbon::parse($pembelian->tanggal_pesan)->format('d/m/Y') }}</td>
                            <td>{{ $pembelian->supplier->nama ?? '-' }}</td>
                            <td>{{ $pembelian->tipe->keterangan ?? '-' }}</td>
                            <td>
                                @if($pembelian->detils->count() > 0)
                                    <button class="btn btn-sm btn-info" type="button" data-toggle="collapse" data-target="#detil{{ $pembelian->idpembelian }}" aria-expanded="false">
                                        <i class="fas fa-eye"></i> Lihat Detail ({{ $pembelian->detils->count() }} produk)
                                    </button>
                                    <div class="collapse mt-2" id="detil{{ $pembelian->idpembelian }}">
                                        <ul class="list-group">
                                            @foreach($pembelian->detils as $detil)
                                                <li class="list-group-item">
                                                    <strong>{{ $detil->produk->nama ?? 'N/A' }}</strong><br>
                                                    <small>
                                                        Harga: Rp {{ number_format($detil->harga, 0, ',', '.') }} |
                                                        Jumlah: {{ $detil->jumlah }} |
                                                        Subtotal: Rp {{ number_format($detil->harga * $detil->jumlah, 0, ',', '.') }}
                                                    </small>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @else
                                    <span class="badge badge-warning">Tidak ada produk</span>
                                @endif
                            </td>
                            <td><strong>Rp {{ number_format($pembelian->total, 0, ',', '.') }}</strong></td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="modalEdit({{ $pembelian->idpembelian }})" data-toggle="modal" data-target="#modalEditPembelian">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('pembelian.destroy', $pembelian->idpembelian) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pembelian ini? Stok produk akan dikembalikan.');">
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
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPembelianModalLabel">Tambah Pembelian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('pembelian.store') }}" method="POST" id="formAddPembelian">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="tanggal_pesan">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="tanggal_pesan" name="tanggal_pesan" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="supplier_idsupplier">Supplier <span class="text-danger">*</span></label>
                                <select class="form-control" id="supplier_idsupplier" name="supplier_idsupplier" required>
                                    <option value="">Pilih Supplier</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->idsupplier }}">{{ $supplier->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tipe_idtipe">Tipe Pembelian <span class="text-danger">*</span></label>
                                <select class="form-control" id="tipe_idtipe" name="tipe_idtipe" required>
                                    <option value="">Pilih Tipe</option>
                                    @foreach($tipes as $tipe)
                                        <option value="{{ $tipe->idtipe }}">{{ $tipe->keterangan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h6>Detail Produk <span class="text-danger">*</span></h6>
                    <div id="productList">
                        <!-- Product items will be added here -->
                    </div>
                    <button type="button" class="btn btn-sm btn-success" onclick="addProductRow()">
                        <i class="fas fa-plus"></i> Tambah Produk
                    </button>

                    <hr>
                    <div class="text-right">
                        <h5>Total: Rp <span id="totalPembelian">0</span></h5>
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
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" id="modalContent">

    </div>
</div>
@endsection

@section('javascript')
<script>
    let productRowIndex = 0;
    const produks = @json($produks);

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

        // Set default date to today
        const today = new Date().toISOString().split('T')[0];
        $('#tanggal_pesan').val(today);
    });

    function addProductRow() {
        const row = `
            <div class="row product-row mb-2" id="productRow${productRowIndex}">
                <div class="col-md-4">
                    <select class="form-control product-select" name="products[${productRowIndex}][produk_id]" required onchange="updateProductPrice(${productRowIndex})">
                        <option value="">Pilih Produk</option>
                        ${produks.map(p => `<option value="${p.idproduk}" data-harga="${p.harga_beli || p.harga}">${p.nama}</option>`).join('')}
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" class="form-control harga-input" name="products[${productRowIndex}][harga]" placeholder="Harga Beli" min="0" required onchange="calculateTotal()">
                </div>
                <div class="col-md-3">
                    <input type="number" class="form-control jumlah-input" name="products[${productRowIndex}][jumlah]" placeholder="Jumlah" min="1" required onchange="calculateTotal()">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeProductRow(${productRowIndex})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
        $('#productList').append(row);
        productRowIndex++;
    }

    function removeProductRow(index) {
        $(`#productRow${index}`).remove();
        calculateTotal();
    }

    function updateProductPrice(index) {
        const selectElement = $(`select[name="products[${index}][produk_id]"]`);
        const selectedOption = selectElement.find('option:selected');
        const harga = selectedOption.data('harga') || 0;
        $(`input[name="products[${index}][harga]"]`).val(harga);
        calculateTotal();
    }

    function calculateTotal() {
        let total = 0;
        $('.product-row').each(function() {
            const harga = parseFloat($(this).find('.harga-input').val()) || 0;
            const jumlah = parseInt($(this).find('.jumlah-input').val()) || 0;
            total += harga * jumlah;
        });
        $('#totalPembelian').text(total.toLocaleString('id-ID'));
    }

    // Form Submit Pembelian dengan Loader
    $('#formAddPembelian').on('submit', function(e) {
        e.preventDefault();

        const form = $(this);
        const formData = new FormData(this);
        const submitBtn = form.find('button[type="submit"]');

        // Validasi: harus ada minimal 1 produk
        if ($('.product-row').length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian!',
                text: 'Minimal harus ada 1 produk yang dibeli',
                confirmButtonColor: '#f39c12'
            });
            return;
        }

        LoaderUtil.show('Menyimpan pembelian...');
        submitBtn.prop('disabled', true);

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                LoaderUtil.hide();
                $('#addPembelianModal').modal('hide');

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Pembelian berhasil disimpan dan HPP sudah diupdate',
                    timer: 2500,
                    showConfirmButton: false
                }).then(() => {
                    window.location.reload();
                });
            },
            error: function(xhr) {
                LoaderUtil.hide();
                submitBtn.prop('disabled', false);

                let errorMessage = 'Terjadi kesalahan saat menyimpan pembelian';
                if (xhr.responseJSON) {
                    if (xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.responseJSON.errors) {
                        const errors = xhr.responseJSON.errors;
                        errorMessage = '<ul style="text-align: left; margin: 0;">';
                        for (let field in errors) {
                            errors[field].forEach(error => {
                                errorMessage += `<li>${error}</li>`;
                            });
                        }
                        errorMessage += '</ul>';
                    }
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

    // Form Edit Pembelian (delegated event)
    $(document).on('submit', '#modalEditPembelian form', function(e) {
        e.preventDefault();

        const form = $(this);
        const formData = new FormData(this);
        const submitBtn = form.find('button[type="submit"]');

        LoaderUtil.show('Memperbarui pembelian...');
        submitBtn.prop('disabled', true);

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                LoaderUtil.hide();
                $('#modalEditPembelian').modal('hide');

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Pembelian berhasil diperbarui',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.reload();
                });
            },
            error: function(xhr) {
                LoaderUtil.hide();
                submitBtn.prop('disabled', false);

                let errorMessage = 'Terjadi kesalahan saat memperbarui pembelian';
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

    function modalEdit(pembelianId) {
        LoaderUtil.show('Memuat form edit...');

        $.ajax({
            type: 'POST',
            url: '{{ route("pembelian.getEditForm") }}',
            data: {
                '_token': '<?php echo csrf_token() ?>',
                'id': pembelianId,
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
                    text: 'Gagal memuat form edit pembelian',
                    confirmButtonColor: '#d33'
                });
            }
        });
    }

    // Reset form when modal is closed
    $('#addPembelianModal').on('hidden.bs.modal', function() {
        $('#formAddPembelian')[0].reset();
        $('#productList').empty();
        productRowIndex = 0;
        calculateTotal();
    });

    // Add first product row when modal opens
    $('#addPembelianModal').on('shown.bs.modal', function() {
        if ($('#productList').children().length === 0) {
            addProductRow();
        }
    });
</script>
@endsection
