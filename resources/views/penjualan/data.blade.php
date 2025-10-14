<div class="row g-4">
    @forelse ($produks as $produk)
        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-4">
            <div
                class="card product-card animate-fade-in-up"
                data-id="{{ $produk->idproduk }}"
                data-name="{{ $produk->nama }}"
                data-price="{{ $produk->harga }}"
                data-stock="{{ $produk->stok }}"
                data-barcode="{{ $produk->barcode }}"
                style="cursor: pointer;">
                <div style="position: relative; overflow: hidden;">
                    <img src="{{ asset('storage/' . $produk->gambar) }}"
                         class="card-img-top"
                         alt="Gambar {{ $produk->nama }}"
                         onerror="this.onerror=null; this.src='{{ asset('storage/images/default.png') }}';"
                         style="height: 220px; object-fit: cover;">
                    @if($produk->stok < 10)
                        <span class="badge badge-danger" style="position: absolute; top: 10px; right: 10px; font-size: 0.9rem; padding: 0.5rem 0.8rem; border-radius: 20px;">
                            Stok Terbatas
                        </span>
                    @endif
                </div>
                <div class="card-body text-center" style="padding: 1.2rem;">
                    <h5 class="card-title" style="font-weight: 600; color: #333; margin-bottom: 0.8rem; font-size: 1.1rem;">
                        {{ Str::limit($produk->nama, 30) }}
                    </h5>
                    <div style="margin-bottom: 0.8rem;">
                        <span class="price-highlight" style="font-size: 1.4rem; color: #667eea; font-weight: 700;">
                            Rp {{ number_format($produk->harga, 0, ',', '.') }}
                        </span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #f0f0f0;">
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-box" style="color: {{ $produk->stok > 20 ? '#1dd1a1' : ($produk->stok > 10 ? '#feca57' : '#ff6b6b') }};"></i>
                            <span style="font-weight: 600; color: #666; font-size: 0.95rem;">
                                {{ $produk->stok }} Unit
                            </span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-barcode" style="color: #999;"></i>
                            <span style="color: #999; font-size: 0.85rem;">
                                {{ $produk->barcode }}
                            </span>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-sm mt-3" style="width: 100%; padding: 0.7rem; font-weight: 600; border-radius: 10px;">
                        <i class="fas fa-cart-plus mr-2"></i>Tambah ke Keranjang
                    </button>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="empty-state animate-fade-in" style="padding: 4rem 2rem; text-align: center;">
                <i class="fas fa-inbox" style="font-size: 5rem; color: #ddd; margin-bottom: 1.5rem;"></i>
                <h4 style="color: #999; font-weight: 600;">Produk tidak tersedia</h4>
                <p style="color: #bbb;">Tidak ada produk dalam kategori ini.</p>
            </div>
        </div>
    @endforelse
</div>

<style>
    /* Add hover effect to product cards */
    .product-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(102, 126, 234, 0.25) !important;
    }
</style>
