<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Edit Produk</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form action="{{ route('produk.update', $produk->idproduk) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="barcode">Barcode</label>
                <input type="text" class="form-control" id="barcode" name="barcode" value="{{ $produk->barcode }}" required>
            </div>
            <div class="form-group">
                <label for="nama">Nama Produk</label>
                <input type="text" class="form-control" id="nama" name="nama" value="{{ $produk->nama }}" required>
            </div>
            <div class="form-group">
                <label for="harga">Harga</label>
                <input type="number" class="form-control" id="harga" name="harga" value="{{ $produk->harga }}" required>
            </div>
            <div class="form-group">
                <label for="stok">Stok</label>
                <input type="number" class="form-control" id="stok" name="stok" value="{{ $produk->stok }}" required>
            </div>
            <div class="form-group">
                <label for="gambar">Gambar Produk</label>
                @if($produk->gambar)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $produk->gambar) }}"
                             alt="{{ $produk->nama }}"
                             class="img-thumbnail"
                             style="max-height: 150px; object-fit: cover;">
                        <p class="text-muted small mt-1">Gambar saat ini</p>
                    </div>
                @endif
                <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah gambar.</small>
            </div>
            <div class="form-group">
                <label for="kategori_idkategori">Kategori</label>
                <select class="form-control" id="kategori_idkategori" name="kategori_idkategori" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->idkategori }}" {{ $produk->kategori_idkategori == $kategori->idkategori ? 'selected' : '' }}>
                        {{ $kategori->nama }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
