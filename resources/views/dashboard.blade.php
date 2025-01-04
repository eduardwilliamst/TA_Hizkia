@extends('layouts.adminlte')

@section('title')
Dashboard
@endsection

@section('page-bar')
Dashboard

<!-- Modal Tambah Data -->
<div class="modal fade" id="addDataModal" tabindex="-1" role="dialog" aria-labelledby="addDataModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDataModalLabel">Tambah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('balance.store') }}" method="POST">
                    @csrf
                    <!-- Input Balance Awal -->
                    <div class="form-group">
                        <label for="balance_awal">Balance Awal</label>
                        <input type="number" class="form-control" id="balance_awal" name="balance_awal" placeholder="Masukkan balance awal" required>
                    </div>

                    <!-- Input Keterangan -->
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" placeholder="Masukkan keterangan" rows="3" required></textarea>
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

@endsection
