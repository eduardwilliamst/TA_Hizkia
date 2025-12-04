<div class="modal-content">
    <div class="modal-header" style="background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%); color: white;">
        <h5 class="modal-title">
            <i class="fas fa-edit" style="margin-right: 0.5rem;"></i>Edit Promo
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body" style="padding: 1.5rem;">
        <form action="{{ route('promo.update', $promo->idpromo) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Tipe Promo -->
            <div class="form-group">
                <label style="font-weight: 600; margin-bottom: 0.75rem; display: block;">
                    <i class="fas fa-tag" style="margin-right: 0.5rem; color: #4F46E5;"></i>Tipe Promo
                </label>
                <div style="display: flex; gap: 1rem;">
                    <label class="promo-type-option-edit" style="flex: 1; cursor: pointer;">
                        <input type="radio" name="tipe" value="produk gratis" {{ $promo->tipe === 'produk gratis' ? 'checked' : '' }} style="display: none;">
                        <div class="promo-type-card-edit" style="background: white; border: 2px solid {{ $promo->tipe === 'produk gratis' ? '#10B981' : '#E5E7EB' }}; border-radius: 12px; padding: 1rem; text-align: center; transition: all 0.3s ease;">
                            <i class="fas fa-gift" style="font-size: 2rem; color: #10B981; margin-bottom: 0.5rem; display: block;"></i>
                            <div style="font-weight: 600; color: #10B981;">Beli X Gratis Y</div>
                        </div>
                    </label>
                    <label class="promo-type-option-edit" style="flex: 1; cursor: pointer;">
                        <input type="radio" name="tipe" value="diskon" {{ $promo->tipe === 'diskon' ? 'checked' : '' }} style="display: none;">
                        <div class="promo-type-card-edit" style="background: white; border: 2px solid {{ $promo->tipe === 'diskon' ? '#F59E0B' : '#E5E7EB' }}; border-radius: 12px; padding: 1rem; text-align: center; transition: all 0.3s ease;">
                            <i class="fas fa-percent" style="font-size: 2rem; color: #F59E0B; margin-bottom: 0.5rem; display: block;"></i>
                            <div style="font-weight: 600; color: #F59E0B;">Beli X Dapat Diskon</div>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="form-group">
                <label for="edit_deskripsi" style="font-weight: 600;">
                    <i class="fas fa-info-circle" style="margin-right: 0.5rem; color: #4F46E5;"></i>Deskripsi Promo
                </label>
                <input type="text" class="form-control" id="edit_deskripsi" name="deskripsi" value="{{ $promo->deskripsi }}" required style="border-radius: 8px;">
            </div>

            <!-- Produk Utama -->
            <div class="form-group">
                <label for="edit_produk_idutama" style="font-weight: 600;">
                    <i class="fas fa-box" style="margin-right: 0.5rem; color: #4F46E5;"></i>Produk Utama (Yang Dibeli)
                </label>
                <select class="form-control" id="edit_produk_idutama" name="produk_idutama" required style="border-radius: 8px;">
                    <option value="">-- Pilih Produk --</option>
                    @foreach($produks as $produk)
                        <option value="{{ $produk->idproduk }}" {{ $promo->produk_idutama == $produk->idproduk ? 'selected' : '' }}>
                            {{ $produk->nama }} - Rp {{ number_format($produk->harga, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <!-- Buy X -->
                <div class="form-group">
                    <label for="edit_buy_x" style="font-weight: 600;">
                        <i class="fas fa-shopping-cart" style="margin-right: 0.5rem; color: #4F46E5;"></i>Beli (Qty)
                    </label>
                    <input type="number" class="form-control" id="edit_buy_x" name="buy_x" min="1" value="{{ $promo->buy_x }}" required style="border-radius: 8px;">
                </div>

                <!-- Get Y (untuk produk gratis) -->
                <div class="form-group" id="editGetYGroup" style="{{ $promo->tipe === 'diskon' ? 'display: none;' : '' }}">
                    <label for="edit_get_y" style="font-weight: 600;">
                        <i class="fas fa-gift" style="margin-right: 0.5rem; color: #10B981;"></i>Gratis (Qty)
                    </label>
                    <input type="number" class="form-control" id="edit_get_y" name="get_y" min="1" value="{{ $promo->get_y }}" style="border-radius: 8px;">
                </div>

                <!-- Nilai Diskon (untuk diskon) -->
                <div class="form-group" id="editDiskonGroup" style="{{ $promo->tipe === 'produk gratis' ? 'display: none;' : '' }}">
                    <label for="edit_nilai_diskon" style="font-weight: 600;">
                        <i class="fas fa-percent" style="margin-right: 0.5rem; color: #F59E0B;"></i>Diskon (%)
                    </label>
                    <input type="number" class="form-control" id="edit_nilai_diskon" name="nilai_diskon" min="1" max="100" value="{{ $promo->nilai_diskon }}" style="border-radius: 8px;">
                </div>
            </div>

            <!-- Produk Tambahan (untuk produk gratis) -->
            <div class="form-group" id="editProdukTambahanGroup" style="{{ $promo->tipe === 'diskon' ? 'display: none;' : '' }}">
                <label for="edit_produk_idtambahan" style="font-weight: 600;">
                    <i class="fas fa-gift" style="margin-right: 0.5rem; color: #10B981;"></i>Produk Bonus (Opsional)
                </label>
                <select class="form-control" id="edit_produk_idtambahan" name="produk_idtambahan" style="border-radius: 8px;">
                    <option value="">-- Sama dengan produk utama --</option>
                    @foreach($produks as $produk)
                        <option value="{{ $produk->idproduk }}" {{ $promo->produk_idtambahan == $produk->idproduk ? 'selected' : '' }}>
                            {{ $produk->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <!-- Tanggal Awal -->
                <div class="form-group">
                    <label for="edit_tanggal_awal" style="font-weight: 600;">
                        <i class="fas fa-calendar-alt" style="margin-right: 0.5rem; color: #4F46E5;"></i>Tanggal Mulai
                    </label>
                    <input type="date" class="form-control" id="edit_tanggal_awal" name="tanggal_awal" value="{{ \Carbon\Carbon::parse($promo->tanggal_awal)->format('Y-m-d') }}" required style="border-radius: 8px;">
                </div>

                <!-- Tanggal Akhir -->
                <div class="form-group">
                    <label for="edit_tanggal_akhir" style="font-weight: 600;">
                        <i class="fas fa-calendar-check" style="margin-right: 0.5rem; color: #4F46E5;"></i>Tanggal Selesai
                    </label>
                    <input type="date" class="form-control" id="edit_tanggal_akhir" name="tanggal_akhir" value="{{ \Carbon\Carbon::parse($promo->tanggal_akhir)->format('Y-m-d') }}" required style="border-radius: 8px;">
                </div>
            </div>

            <div class="modal-footer" style="border-top: none; padding: 1.5rem 0 0 0;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Toggle form fields based on promo type (edit modal)
    document.querySelectorAll('#modalEditPromo input[name="tipe"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const tipe = this.value;
            const getYGroup = document.getElementById('editGetYGroup');
            const diskonGroup = document.getElementById('editDiskonGroup');
            const produkTambahanGroup = document.getElementById('editProdukTambahanGroup');

            // Update card styles
            document.querySelectorAll('.promo-type-card-edit').forEach(card => {
                card.style.borderColor = '#E5E7EB';
            });
            this.nextElementSibling.style.borderColor = tipe === 'produk gratis' ? '#10B981' : '#F59E0B';

            if (tipe === 'produk gratis') {
                getYGroup.style.display = 'block';
                produkTambahanGroup.style.display = 'block';
                diskonGroup.style.display = 'none';
            } else {
                getYGroup.style.display = 'none';
                produkTambahanGroup.style.display = 'none';
                diskonGroup.style.display = 'block';
            }
        });
    });
</script>
