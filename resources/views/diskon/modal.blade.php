<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Edit Data Diskon</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form action="{{ route('diskon.update', $diskon->iddiskon) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="tanggal_awal">Tanggal Awal</label>
                <input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal" value="{{ $diskon->tanggal_awal }}" required>
            </div>
            <div class="form-group">
                <label for="tanggal_akhir">Tanggal Akhir</label>
                <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" value="{{ $diskon->tanggal_akhir }}" required>
            </div>
            <div class="form-group">
                <label for="presentase">Presentase %</label>
                <input type="number" class="form-control" id="presentase" name="presentase" value="{{ $diskon->presentase }}" required>
            </div>
            <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <input type="text" class="form-control" id="keterangan" name="keterangan" value="{{ $diskon->keterangan }}" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
