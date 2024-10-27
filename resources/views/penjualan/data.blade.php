<div class="row g-4">
    @forelse ($produks as $produk)
        <div class="col-md-3 mb-4"> 
            <div class="card mt-4 border border-black"> <!-- Adjust margin here if needed -->
                <img src="{{ asset('storage/' . $produk->gambar) }}" class="card-img-top mt-2" alt="Gambar {{ $produk->nama }}" onerror="this.onerror=null; this.src='{{ asset('storage/images/default.png') }}';">
                <div class="card-body text-center">
                    <h5 class="card-title">{{ $produk->nama }}</h5>
                    <p class="card-text">Harga: Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                    <p class="card-text">Stok: {{ $produk->stok }}</p>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center">
            <p>Produk tidak tersedia.</p>
        </div>
    @endforelse
</div>
