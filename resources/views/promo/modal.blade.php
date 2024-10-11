<!-- Modal Edit -->
<div class="modal fade" id="modalEditHistory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data Diskon</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('diskon.update', 'diskon_id_placeholder') }}" method="POST" id="editDiskonForm">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="diskon_value">Diskon Value</label>
                        <input type="text" class="form-control" id="diskon_value" name="diskon_value" required>
                    </div>
                    <div class="form-group">
                        <label for="diskon_description">Diskon Description</label>
                        <input type="text" class="form-control" id="diskon_description" name="diskon_description" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">BATAL</button>
                        <button type="submit" class="btn btn-primary">SIMPAN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
