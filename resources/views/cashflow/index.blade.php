@extends('layouts.adminlte')

@section('title')
Cashflow
@endsection

@section('page-bar')
<h1 class="m-0">Cashflow</h1>
@endsection

@section('contents')
<div class="content">
    <div class="container-fluid">
        <div class="card animate-fade-in-up">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h3 class="mb-0">
                            <i class="fas fa-chart-line mr-2"></i>
                            Manajemen Cashflow
                        </h3>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addCashflowModal" style="padding: 0.7rem 1.5rem; border-radius: 12px;">
                            <i class="fas fa-plus-circle mr-2"></i>Tambah Cashflow
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body" style="padding: 2rem;">
                <div style="overflow-x: auto;">
                    <table id="cashflowTable" class="table table-hover" style="border-radius: 10px; overflow: hidden;">
                        <thead>
                            <tr>
                                <th><i class="fas fa-calendar mr-2"></i>Tanggal</th>
                                <th><i class="fas fa-tag mr-2"></i>Tipe</th>
                                <th><i class="fas fa-dollar-sign mr-2"></i>Jumlah</th>
                                <th><i class="fas fa-wallet mr-2"></i>Balance Awal</th>
                                <th><i class="fas fa-balance-scale mr-2"></i>Balance Akhir</th>
                                <th><i class="fas fa-info-circle mr-2"></i>Keterangan</th>
                                <th style="text-align: center;"><i class="fas fa-cog mr-2"></i>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cashflows as $cashflow)
                            <tr class="animate-fade-in">
                                <td style="font-weight: 500; color: #666;">
                                    <i class="far fa-clock mr-2"></i>
                                    {{ \Carbon\Carbon::parse($cashflow->tanggal)->translatedFormat('d F Y H:i') }}
                                </td>
                                <td>
                                    <span class="badge" style="padding: 0.5rem 1rem; border-radius: 20px; font-weight: 600;
                                        background: {{ $cashflow->tipe == 'cash_in' ? 'linear-gradient(135deg, #11998e 0%, #38ef7d 100%)' : 'linear-gradient(135deg, #eb3349 0%, #f45c43 100%)' }};
                                        color: white;">
                                        <i class="fas fa-{{ $cashflow->tipe == 'cash_in' ? 'arrow-down' : 'arrow-up' }} mr-1"></i>
                                        {{ ucwords(str_replace('_', ' ', $cashflow->tipe)) }}
                                    </span>
                                </td>
                                <td style="color: {{ $cashflow->tipe == 'cash_in' ? '#11998e' : '#eb3349' }}; font-weight: 700; font-size: 1.05rem;">
                                    Rp {{ number_format($cashflow->jumlah, 0, ',', '.') }}
                                </td>
                                <td style="font-weight: 600; color: #666;">
                                    Rp {{ number_format($cashflow->balance_awal, 0, ',', '.') }}
                                </td>
                                <td style="font-weight: 700; color: #333;">
                                    Rp {{ number_format($cashflow->balance_akhir, 0, ',', '.') }}
                                </td>
                                <td style="color: #666;">{{ Str::limit($cashflow->keterangan, 40) }}</td>
                                <td style="text-align: center;">
                                    <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                        <a data-toggle="modal" data-target="#editCashflowModal" onclick="modalEdit({{ $cashflow->idcashflow }})" class="btn btn-info btn-sm" style="border-radius: 8px; padding: 0.5rem 1rem;" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('cashflow.destroy', $cashflow->idcashflow) }}" method="POST" id="delete-form-{{ $cashflow->idcashflow }}" style="display:inline; margin: 0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm" style="border-radius: 8px; padding: 0.5rem 1rem;" onclick="confirmDelete('delete-form-{{ $cashflow->idcashflow }}')" title="Hapus">
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