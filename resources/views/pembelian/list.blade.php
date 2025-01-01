@extends('layouts.adminlte')

@section('title')
List Pembelian
@endsection

@section('contents')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data Pembelian</h1>
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
                        <h3 class="card-title">List of Pembelians</h3>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <table id="pembelianTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Tanggal Pesan</th>
                            <th>Tanggal Datang</th>
                            <th>Supplier</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pembelians as $pembelian)
                        <tr>
                            <td>{{ $pembelian->tanggal_pesan }}</td>
                            <td>{{ $pembelian->tanggal_datang }}</td>
                            <td>{{ $pembelian->supplier->nama_supplier }}</td>  <!-- Menampilkan nama supplier -->
                            <td>
                                <form action="{{ route('pembelian.destroy', $pembelian->idpembelian) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this pembelian?');">
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
        $('#pembelianTable').DataTable({
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
