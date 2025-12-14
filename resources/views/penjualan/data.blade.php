<div class="row g-4">
    @forelse ($produks as $produk)
        @php
            $promo = $activePromos[$produk->idproduk] ?? null;
            $hasPromo = $promo !== null;
        @endphp
        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-4">
            <div
                class="card product-card animate-fade-in-up {{ $hasPromo ? 'has-promo' : '' }}"
                data-id="{{ $produk->idproduk }}"
                data-name="{{ $produk->nama }}"
                data-price="{{ $produk->harga }}"
                data-stock="{{ $produk->stok }}"
                data-barcode="{{ $produk->barcode }}"
                @if($hasPromo)
                data-promo="true"
                data-promo-type="{{ $promo->tipe }}"
                data-promo-buy="{{ $promo->buy_x }}"
                data-promo-get="{{ $promo->get_y }}"
                data-promo-diskon="{{ $promo->nilai_diskon }}"
                data-promo-bonus-id="{{ $promo->produk_idtambahan ?? $produk->idproduk }}"
                data-promo-bonus-name="{{ $promo->produkTambahan ? $promo->produkTambahan->nama : $produk->nama }}"
                data-promo-bonus-price="{{ $promo->produkTambahan ? $promo->produkTambahan->harga : $produk->harga }}"
                data-promo-desc="{{ $promo->deskripsi }}"
                @endif
                style="cursor: pointer; height: 100%; min-height: 480px; display: flex; flex-direction: column; {{ $hasPromo ? 'border: 2px solid ' . ($promo->tipe === 'produk gratis' ? '#10B981' : '#F59E0B') . ';' : '' }}">

                <div style="position: relative; overflow: hidden; height: 220px; flex-shrink: 0;">
                    @if($produk->gambar)
                        <img src="{{ asset('storage/' . $produk->gambar) }}"
                             class="card-img-top"
                             alt="Gambar {{ $produk->nama }}"
                             onerror="this.onerror=null; this.src='{{ asset('storage/images/default.png') }}';"
                             style="height: 100%; width: 100%; object-fit: cover;">
                    @else
                        <div style="height: 100%; width: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-image" style="font-size: 4rem; color: rgba(255,255,255,0.5);"></i>
                        </div>
                    @endif

                    {{-- Stock Badge --}}
                    @if($produk->stok < 10)
                        <span class="badge badge-danger" style="position: absolute; top: 10px; right: 10px; font-size: 0.9rem; padding: 0.5rem 0.8rem; border-radius: 20px;">
                            Stok Terbatas
                        </span>
                    @endif

                    {{-- Promo Badge --}}
                    @if($hasPromo)
                        <div style="position: absolute; top: 10px; left: 10px;">
                            @if($promo->tipe === 'produk gratis')
                                <span class="badge" style="background: linear-gradient(135deg, #10B981 0%, #34D399 100%); color: white; font-size: 0.85rem; padding: 0.5rem 0.8rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(16, 185, 129, 0.4);">
                                    <i class="fas fa-gift"></i> Beli {{ $promo->buy_x }} Gratis {{ $promo->get_y }}
                                </span>
                            @else
                                <span class="badge" style="background: linear-gradient(135deg, #F59E0B 0%, #FBBF24 100%); color: white; font-size: 0.85rem; padding: 0.5rem 0.8rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(245, 158, 11, 0.4);">
                                    <i class="fas fa-percent"></i> Diskon {{ $promo->nilai_diskon }}%
                                </span>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="card-body text-center" style="padding: 1.2rem; display: flex; flex-direction: column; flex-grow: 1;">
                    <h5 class="card-title" style="font-weight: 600; color: #333; margin-bottom: 0.8rem; font-size: 1.1rem;">
                        {{ Str::limit($produk->nama, 30) }}
                    </h5>
                    <div style="margin-bottom: 0.8rem;">
                        <span class="price-highlight" style="font-size: 1.4rem; color: #4F46E5; font-weight: 700;">
                            Rp {{ number_format($produk->harga, 0, ',', '.') }}
                        </span>
                    </div>

                    {{-- Promo Info --}}
                    @if($hasPromo)
                        <div style="background: {{ $promo->tipe === 'produk gratis' ? 'rgba(16, 185, 129, 0.1)' : 'rgba(245, 158, 11, 0.1)' }}; border-radius: 8px; padding: 0.5rem; margin-bottom: 0.8rem;">
                            <small style="color: {{ $promo->tipe === 'produk gratis' ? '#10B981' : '#F59E0B' }}; font-weight: 600;">
                                <i class="fas {{ $promo->tipe === 'produk gratis' ? 'fa-gift' : 'fa-percent' }}"></i>
                                {{ $promo->deskripsi }}
                            </small>
                        </div>
                    @endif

                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: auto; padding-top: 1rem; border-top: 1px solid #f0f0f0;">
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
                    <button class="btn {{ $hasPromo ? ($promo->tipe === 'produk gratis' ? 'btn-success' : 'btn-warning') : 'btn-primary' }} btn-sm mt-3" style="width: 100%; padding: 0.7rem; font-weight: 600; border-radius: 10px;">
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
    /* Make all cards in a row have equal height */
    .row.g-4 {
        display: flex;
        flex-wrap: wrap;
    }

    .row.g-4 > [class*='col-'] {
        display: flex;
        flex-direction: column;
    }

    /* Add hover effect to product cards */
    .product-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(102, 126, 234, 0.25) !important;
    }

    .product-card.has-promo:hover {
        box-shadow: 0 12px 30px rgba(16, 185, 129, 0.3) !important;
    }

    /* Promo badge animation */
    .product-card.has-promo .badge {
        animation: promoPulse 2s infinite;
    }

    @keyframes promoPulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }
</style>
