@extends('layouts.adminlte')

@section('title')
List Penjualan
@endsection

@section('contents')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data Penjualan</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="card-title">List of Penjualans</h3>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <table id="penjualanTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Cara Bayar</th>
                            <th>Total Diskon</th>
                            <th>Total Bayar</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penjualans as $penjualan)
                        <tr>
                            <td>{{ $penjualan->tanggal }}</td>
                            <td>{{ $penjualan->cara_bayar }}</td>
                            <td>{{ number_format($penjualan->total_diskon, 0, ',', '.') }}</td>
                            <td>{{ number_format($penjualan->total_bayar, 0, ',', '.') }}</td>
                            <td>
                                <form action="{{ route('penjualan.destroy', $penjualan->idpenjualan) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this penjualan?');">
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
@endsection

@section('javascript')
<script>
    $(document).ready(function() {
        $('#penjualanTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
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
</script>
@endsection
