<div class="modal-content" style="border: 1px solid #e3e6f0; border-radius: 4px;">
    <form action="{{ route('kategori.update', $kategori->idkategori) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-header" style="background-color: #4e73df; border-bottom: none; padding: 1rem 1.5rem;">
            <h5 class="modal-title" style="color: white; font-weight: 600; font-size: 1rem;">
                <i class="fas fa-edit mr-2"></i>
                Edit Kategori
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; opacity: 0.9;">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" style="padding: 1.5rem;">
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="edit_nama" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #5a5c69; font-size: 0.875rem;">
                    Nama Kategori <span style="color: #e74a3b;">*</span>
                </label>
                <input type="text" class="form-control" id="edit_nama" value="{{ $kategori->nama }}" name="nama" required style="width: 100%; border: 1px solid #d1d3e2; padding: 0.625rem 0.75rem; font-size: 0.875rem; border-radius: 0.25rem;">
                <div style="font-size: 0.85rem; color: #858796; margin-top: 0.25rem;">
                    Contoh: Elektronik, Makanan, Minuman
                </div>
            </div>
        </div>
        <div class="modal-footer" style="border-top: 1px solid #e3e6f0; padding: 1rem 1.5rem;">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" style="padding: 0.5rem 1rem;">
                <i class="fas fa-times mr-1"></i>Batal
            </button>
            <button type="submit" class="btn btn-primary btn-sm" style="padding: 0.5rem 1rem;">
                <i class="fas fa-save mr-1"></i>Simpan Perubahan
            </button>
        </div>
    </form>
</div>