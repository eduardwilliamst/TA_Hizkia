@extends('layouts.adminlte')

@section('title')
Cashflow
@endsection

@section('page-bar')
<h1 class="m-0">Cashflow</h1>
@endsection

@section('contents')
<div class="content">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="card-title">List of Cahshflow</h3>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addCashflowModal">
                            <i class="fas fa-plus"></i> Tambah Cashflow
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <table id="cashflowTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Saldo Awal</th>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cashflows as $cashflow)
                        <tr>
                            <td>{{ $cashflow->saldo_awal }}</td>
                            <td>{{ $cashflow->tanggal }}</td>
                            <td>{{ $cashflow->keterangan }}</td>
                            <td>
                                <a data-toggle="modal" data-target="#editCashflowModal" onclick="modalEdit({{ $cashflow->idsupplier }})" class="btn btn-info btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('cashflow.destroy', $cashflow->idpos_session) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this supplier?');">
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

<!-- Modal Tambah -->
<div class="modal fade" id="addCashflowModal" tabindex="-1" role="dialog" aria-labelledby="addCashflowModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCashflowModalLabel">Tambah Cashflow</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Tabs -->
                <ul class="nav nav-tabs" id="transactionTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="cash-in-tab" data-toggle="tab" href="#cash-in" role="tab" aria-controls="cash-in" aria-selected="true">Cash In</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="cash-out-tab" data-toggle="tab" href="#cash-out" role="tab" aria-controls="cash-out" aria-selected="false">Cash Out</a>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content" id="transactionTabsContent">
                    <!-- Cash In Form -->
                    <div class="tab-pane fade show active" id="cash-in" role="tabpanel" aria-labelledby="cash-in-tab">
                        <form action="{{ route('cashflow.store') }}" method="POST">
                            @csrf
                            <div class="form-group mt-3">
                                <label for="jumlah_cash_in">Jumlah</label>
                                <input type="number" class="form-control" id="jumlah_cash_in" name="jumlah" placeholder="Masukkan jumlah" required>
                            </div>
                            <div class="form-group">
                                <label for="keterangan_cash_in">Keterangan</label>
                                <textarea class="form-control" id="keterangan_cash_in" name="keterangan" rows="3" placeholder="Masukkan keterangan"></textarea>
                            </div>
                            <input type="hidden" name="type" value="cash_in">
                            <button type="submit" class="btn btn-primary">Simpan Cash In</button>
                        </form>
                    </div>

                    <!-- Cash Out Form -->
                    <div class="tab-pane fade" id="cash-out" role="tabpanel" aria-labelledby="cash-out-tab">
                        <form action="{{ route('cashflow.store') }}" method="POST">
                            @csrf
                            <div class="form-group mt-3">
                                <label for="jumlah_cash_out">Jumlah</label>
                                <input type="number" class="form-control" id="jumlah_cash_out" name="jumlah" placeholder="Masukkan jumlah" required>
                            </div>
                            <div class="form-group">
                                <label for="keterangan_cash_out">Keterangan</label>
                                <textarea class="form-control" id="keterangan_cash_out" name="keterangan" rows="3" placeholder="Masukkan keterangan"></textarea>
                            </div>
                            <input type="hidden" name="type" value="cash_out">
                            <button type="submit" class="btn btn-primary">Simpan Cash Out</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editCashflowModal" tabindex="-1" aria-labelledby="editCashflowModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" id="modalContent">

    </div>
</div>
@endsection

@section('javascript')
<script>
    $(document).ready(function() {
        $('#cashflowTable').DataTable({
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

    function modalEdit(supplierId) {
        $.ajax({
            type: 'POST',
            url: '{{ route("cashflow.getEditForm") }}',
            data: {
                '_token': '<?php echo csrf_token() ?>',
                'id': supplierId,
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