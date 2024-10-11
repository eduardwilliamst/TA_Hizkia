<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Set Up No. Perkiraan Ledger</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form action="{{ route('perkiraan.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="no_perkiraan">No</label>
                <input type="text" class="form-control" id="no_perkiraan" name="no_perkiraan" required>
            </div>
            <div class="form-group">
                <label for="no_pusat">No. Pusat</label>
                <input type="text" class="form-control" id="no_pusat" name="no_pusat" required>
            </div>
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="perkiraan_tidak_aktif" name="perkiraan_tidak_aktif">
                    <label class="form-check-label" for="perkiraan_tidak_aktif">Perkiraan Tidak Aktif</label>
                </div>
            </div>
            <div class="form-group">
                <label for="group_perkiraan">Group Perkiraan</label>
                <select class="form-control" id="group_perkiraan" name="group_perkiraan">
                    <option value="asset">Asset</option>
                    <option value="hutang">Hutang</option>
                    <option value="modal">Modal</option>
                    <option value="pendapatan">Pendapatan</option>
                    <option value="biaya_langsung">Biaya Langsung</option>
                    <option value="biaya_tak_langsung">Biaya Tak Langsung</option>
                    <option value="lain-lain">Lain-lain</option>
                </select>
            </div>
            <div class="form-group">
                <label for="tingkat_perkiraan">Tingkat Perkiraan</label>
                <select class="form-control" id="tingkat_perkiraan" name="tingkat_perkiraan">
                    <option value="group">Group (Tidak untuk Posting)</option>
                    <option value="sub_group">Sub Group (Tidak untuk Posting)</option>
                    <option value="detail">Detail Perkiraan (Posting)</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
