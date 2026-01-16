<div class="modal-content">
    <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
        <h5 class="modal-title">
            <i class="fas fa-edit mr-2"></i>Edit Cashflow
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form action="{{ route('cashflow.update', $cashflow->idcashflow) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
            <div class="form-group">
                <label for="type">Tipe Transaksi <span class="text-danger">*</span></label>
                <select class="form-control" id="type" name="type" required>
                    <option value="">Pilih Tipe</option>
                    <option value="cash_in" {{ $cashflow->tipe == 'cash_in' ? 'selected' : '' }}>
                        <i class="fas fa-arrow-down"></i> Cash In (Uang Masuk)
                    </option>
                    <option value="cash_out" {{ $cashflow->tipe == 'cash_out' ? 'selected' : '' }}>
                        <i class="fas fa-arrow-up"></i> Cash Out (Uang Keluar)
                    </option>
                </select>
            </div>

            <div class="form-group">
                <label for="jumlah">Jumlah <span class="text-danger">*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Rp</span>
                    </div>
                    <input type="number"
                           class="form-control"
                           id="jumlah"
                           name="jumlah"
                           value="{{ abs($cashflow->jumlah) }}"
                           min="0"
                           step="0.01"
                           required>
                </div>
                <small class="form-text text-muted">Masukkan angka positif (tanda + atau - ditentukan oleh tipe)</small>
            </div>

            <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <textarea class="form-control"
                          id="keterangan"
                          name="keterangan"
                          rows="3"
                          maxlength="500"
                          placeholder="Opsional: Tambahkan catatan tentang transaksi ini">{{ $cashflow->keterangan }}</textarea>
                <small class="form-text text-muted">Maksimal 500 karakter</small>
            </div>

            <div class="alert alert-info">
                <i class="fas fa-info-circle mr-2"></i>
                <strong>Info:</strong> Balance awal dan akhir akan dihitung ulang secara otomatis setelah update.
            </div>
        </div>
        <div class="modal-footer" style="background: #f8f9fc;">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                <i class="fas fa-times mr-2"></i>Batal
            </button>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save mr-2"></i>Simpan Perubahan
            </button>
        </div>
    </form>
</div>
