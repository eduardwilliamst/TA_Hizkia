<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="modalEditTipeLabel">Edit Tipe Pembelian</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form action="{{ route('tipe.update', $tipe->idtipe) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <input type="text" class="form-control" id="keterangan" name="keterangan" value="{{ $tipe->keterangan }}" placeholder="Masukkan keterangan tipe pembelian" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
