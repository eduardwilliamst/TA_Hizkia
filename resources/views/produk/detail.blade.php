<div class="modal-content">
    <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 0;">
        <h5 class="modal-title" style="font-weight: 700;">
            <i class="fas fa-info-circle mr-2"></i>Detail Produk
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body" style="padding: 2rem;">
        <div class="row">
            <!-- Product Image -->
            <div class="col-md-5">
                <div style="background: #f8f9fa; border-radius: 15px; padding: 1rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);">
                    @if($produk->gambar)
                        <img src="{{ asset('storage/' . $produk->gambar) }}"
                             alt="{{ $produk->nama }}"
                             class="img-fluid"
                             style="border-radius: 12px; width: 100%; height: auto; object-fit: cover; max-height: 350px;"
                             onerror="this.onerror=null; this.src='{{ asset('storage/images/default.png') }}';">
                    @else
                        <div style="background: linear-gradient(135deg, #e0e0e0 0%, #f0f0f0 100%); border-radius: 12px; height: 300px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-image" style="font-size: 4rem; color: #999;"></i>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Product Details -->
            <div class="col-md-7">
                <div style="padding-left: 1rem;">
                    <h3 style="font-weight: 700; color: #333; margin-bottom: 1.5rem;">
                        {{ $produk->nama }}
                    </h3>

                    <div class="detail-item" style="margin-bottom: 1.5rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; color: white; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);">
                            <div>
                                <small style="opacity: 0.9; display: block; margin-bottom: 0.3rem;">Harga Produk</small>
                                <h2 style="margin: 0; font-weight: 700;">Rp {{ number_format($produk->harga, 0, ',', '.') }}</h2>
                            </div>
                            <div>
                                <i class="fas fa-tag" style="font-size: 2.5rem; opacity: 0.3;"></i>
                            </div>
                        </div>
                    </div>

                    <div class="detail-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                        <!-- Barcode -->
                        <div class="detail-card" style="background: #f8f9fa; padding: 1rem; border-radius: 12px; border-left: 4px solid #667eea;">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div style="width: 45px; height: 45px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-barcode" style="color: white; font-size: 1.2rem;"></i>
                                </div>
                                <div>
                                    <small style="color: #666; font-size: 0.85rem; display: block;">Barcode</small>
                                    <strong style="color: #333; font-size: 1rem;">{{ $produk->barcode }}</strong>
                                </div>
                            </div>
                        </div>

                        <!-- Stok -->
                        <div class="detail-card" style="background: #f8f9fa; padding: 1rem; border-radius: 12px; border-left: 4px solid {{ $produk->stok > 20 ? '#1dd1a1' : ($produk->stok > 10 ? '#feca57' : '#ff6b6b') }};">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div style="width: 45px; height: 45px; background: {{ $produk->stok > 20 ? 'linear-gradient(135deg, #11998e 0%, #38ef7d 100%)' : ($produk->stok > 10 ? 'linear-gradient(135deg, #f39c12 0%, #e67e22 100%)' : 'linear-gradient(135deg, #eb3349 0%, #f45c43 100%)') }}; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-box" style="color: white; font-size: 1.2rem;"></i>
                                </div>
                                <div>
                                    <small style="color: #666; font-size: 0.85rem; display: block;">Stok Tersedia</small>
                                    <strong style="color: #333; font-size: 1rem;">{{ $produk->stok }} Unit</strong>
                                </div>
                            </div>
                        </div>

                        <!-- Kategori -->
                        <div class="detail-card" style="background: #f8f9fa; padding: 1rem; border-radius: 12px; border-left: 4px solid #17a2b8;">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div style="width: 45px; height: 45px; background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-list" style="color: white; font-size: 1.2rem;"></i>
                                </div>
                                <div>
                                    <small style="color: #666; font-size: 0.85rem; display: block;">Kategori</small>
                                    <strong style="color: #333; font-size: 1rem;">{{ $produk->kategori->nama ?? '-' }}</strong>
                                </div>
                            </div>
                        </div>

                        <!-- Usia -->
                        <div class="detail-card" style="background: #f8f9fa; padding: 1rem; border-radius: 12px; border-left: 4px solid #28a745;">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div style="width: 45px; height: 45px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-calendar-alt" style="color: white; font-size: 1.2rem;"></i>
                                </div>
                                <div>
                                    <small style="color: #666; font-size: 0.85rem; display: block;">Rentang Usia</small>
                                    <strong style="color: #333; font-size: 1rem;">{{ $produk->usia_awal ?? 0 }} - {{ $produk->usia_akhir ?? 0 }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status Stock Alert -->
                    @if($produk->stok < 10)
                        <div class="alert alert-warning" style="border-radius: 12px; border-left: 4px solid #feca57; background: #fff3cd;">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <i class="fas fa-exclamation-triangle" style="font-size: 1.5rem; color: #f39c12;"></i>
                                <div>
                                    <strong>Stok Menipis!</strong><br>
                                    <small>Segera lakukan restok untuk produk ini.</small>
                                </div>
                            </div>
                        </div>
                    @elseif($produk->stok > 20)
                        <div class="alert alert-success" style="border-radius: 12px; border-left: 4px solid #1dd1a1; background: #d4edda;">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <i class="fas fa-check-circle" style="font-size: 1.5rem; color: #28a745;"></i>
                                <div>
                                    <strong>Stok Aman</strong><br>
                                    <small>Persediaan produk mencukupi.</small>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer" style="border-top: 2px solid #f0f0f0; padding: 1.5rem;">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="padding: 0.7rem 1.5rem; border-radius: 10px; font-weight: 600;">
            <i class="fas fa-times mr-2"></i>Tutup
        </button>
        <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#modalEditProduk" onclick="modalEdit({{ $produk->idproduk }})" class="btn btn-primary" style="padding: 0.7rem 1.5rem; border-radius: 10px; font-weight: 600; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
            <i class="fas fa-edit mr-2"></i>Edit Produk
        </a>
    </div>
</div>
