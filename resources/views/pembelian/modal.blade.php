<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Edit Pembelian #{{ $pembelian->idpembelian }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form action="{{ route('pembelian.update', $pembelian->idpembelian) }}" method="POST" id="formEditPembelian">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="edit_tanggal_pesan">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="edit_tanggal_pesan" name="tanggal_pesan" value="{{ date('Y-m-d', strtotime($pembelian->tanggal_pesan)) }}" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="edit_supplier_idsupplier">Supplier <span class="text-danger">*</span></label>
                        <select class="form-control" id="edit_supplier_idsupplier" name="supplier_idsupplier" required>
                            <option value="">Pilih Supplier</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->idsupplier }}" {{ $pembelian->supplier_idsupplier == $supplier->idsupplier ? 'selected' : '' }}>
                                    {{ $supplier->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="edit_tipe_idtipe">Tipe Pembelian <span class="text-danger">*</span></label>
                        <select class="form-control" id="edit_tipe_idtipe" name="tipe_idtipe" required>
                            <option value="">Pilih Tipe</option>
                            @foreach($tipes as $tipe)
                                <option value="{{ $tipe->idtipe }}" {{ $pembelian->tipe_idtipe == $tipe->idtipe ? 'selected' : '' }}>
                                    {{ $tipe->keterangan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <hr>
            <h6>Detail Produk <span class="text-danger">*</span></h6>
            <div id="editProductList">
                @foreach($pembelian->detils as $index => $detil)
                <div class="row product-row mb-2" id="editProductRow{{ $index }}">
                    <div class="col-md-4">
                        <select class="form-control product-select" name="products[{{ $index }}][produk_id]" required onchange="updateEditProductPrice({{ $index }})">
                            <option value="">Pilih Produk</option>
                            @foreach($produks as $produk)
                                <option value="{{ $produk->idproduk }}" data-harga="{{ $produk->harga_beli ?? $produk->harga }}" {{ $detil->produk_id == $produk->idproduk ? 'selected' : '' }}>
                                    {{ $produk->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="number" class="form-control harga-input" name="products[{{ $index }}][harga]" placeholder="Harga Beli" min="0" value="{{ $detil->harga }}" required onchange="calculateEditTotal()">
                    </div>
                    <div class="col-md-3">
                        <input type="number" class="form-control jumlah-input" name="products[{{ $index }}][jumlah]" placeholder="Jumlah" min="1" value="{{ $detil->jumlah }}" required onchange="calculateEditTotal()">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-sm" onclick="removeEditProductRow({{ $index }})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
            <button type="button" class="btn btn-sm btn-success" onclick="addEditProductRow()">
                <i class="fas fa-plus"></i> Tambah Produk
            </button>

            <hr>
            <div class="text-right">
                <h5>Total: Rp <span id="totalEditPembelian">0</span></h5>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    let editProductRowIndex = {{ $pembelian->detils->count() }};
    const editProduks = @json($produks);

    function addEditProductRow() {
        const row = `
            <div class="row product-row mb-2" id="editProductRow${editProductRowIndex}">
                <div class="col-md-4">
                    <select class="form-control product-select" name="products[${editProductRowIndex}][produk_id]" required onchange="updateEditProductPrice(${editProductRowIndex})">
                        <option value="">Pilih Produk</option>
                        ${editProduks.map(p => `<option value="${p.idproduk}" data-harga="${p.harga_beli || p.harga}">${p.nama}</option>`).join('')}
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" class="form-control harga-input" name="products[${editProductRowIndex}][harga]" placeholder="Harga Beli" min="0" required onchange="calculateEditTotal()">
                </div>
                <div class="col-md-3">
                    <input type="number" class="form-control jumlah-input" name="products[${editProductRowIndex}][jumlah]" placeholder="Jumlah" min="1" required onchange="calculateEditTotal()">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeEditProductRow(${editProductRowIndex})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
        $('#editProductList').append(row);
        editProductRowIndex++;
    }

    function removeEditProductRow(index) {
        $(`#editProductRow${index}`).remove();
        calculateEditTotal();
    }

    function updateEditProductPrice(index) {
        const selectElement = $(`#editProductRow${index} select[name="products[${index}][produk_id]"]`);
        const selectedOption = selectElement.find('option:selected');
        const harga = selectedOption.data('harga') || 0;
        $(`#editProductRow${index} input[name="products[${index}][harga]"]`).val(harga);
        calculateEditTotal();
    }

    function calculateEditTotal() {
        let total = 0;
        $('#editProductList .product-row').each(function() {
            const harga = parseFloat($(this).find('.harga-input').val()) || 0;
            const jumlah = parseInt($(this).find('.jumlah-input').val()) || 0;
            total += harga * jumlah;
        });
        $('#totalEditPembelian').text(total.toLocaleString('id-ID'));
    }

    // Calculate initial total
    $(document).ready(function() {
        calculateEditTotal();
    });
</script>
