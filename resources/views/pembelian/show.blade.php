<div class="modal-content">
    <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
        <h5 class="modal-title">
            <i class="fas fa-dolly mr-2"></i>Detail Pembelian #{{ $pembelian->idpembelian }}
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
        <!-- Purchase Info -->
        <div class="card mb-3" style="border: 1px solid #e3e6f0;">
            <div class="card-header" style="background: #f8f9fc;">
                <h6 class="mb-0"><i class="fas fa-info-circle mr-2" style="color: #667eea;"></i>Informasi Pembelian</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-2"><strong>Tanggal Pesan:</strong> {{ \Carbon\Carbon::parse($pembelian->tanggal_pesan)->translatedFormat('d F Y') }}</p>
                        <p class="mb-2"><strong>Supplier:</strong> {{ $pembelian->supplier->nama ?? 'N/A' }}</p>
                        <p class="mb-2"><strong>Tipe Pembelian:</strong>
                            <span class="badge" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
                                {{ $pembelian->tipe->keterangan ?? 'N/A' }}
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2"><strong>Jumlah Item:</strong>
                            <span class="badge badge-primary">{{ $pembelian->detils->count() }} item</span>
                        </p>
                        <p class="mb-2"><strong>Total Pembelian:</strong>
                            <span style="color: #11998e; font-weight: 700; font-size: 1.2rem;">
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </span>
                        </p>
                        <p class="mb-2"><strong>Dibuat:</strong> {{ \Carbon\Carbon::parse($pembelian->created_at)->translatedFormat('d F Y, H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Details -->
        <div class="card mb-3" style="border: 1px solid #e3e6f0;">
            <div class="card-header" style="background: #f8f9fc;">
                <h6 class="mb-0"><i class="fas fa-box-open mr-2" style="color: #4facfe;"></i>Detail Produk</h6>
            </div>
            <div class="card-body" style="padding: 0;">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background: #e7e9fd;">
                            <tr>
                                <th style="width: 5%; padding: 1rem;">#</th>
                                <th style="padding: 1rem;">Nama Produk</th>
                                <th style="padding: 1rem; text-align: right;">Harga Beli</th>
                                <th style="padding: 1rem; text-align: center;">Jumlah</th>
                                <th style="padding: 1rem; text-align: right;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pembelian->detils as $index => $detil)
                            <tr>
                                <td style="padding: 1rem; font-weight: 600; color: #666;">{{ $index + 1 }}</td>
                                <td style="padding: 1rem;">
                                    <div style="font-weight: 600; color: #333;">{{ $detil->produk->nama ?? 'N/A' }}</div>
                                    <small style="color: #999;">{{ $detil->produk->barcode ?? '-' }}</small>
                                </td>
                                <td style="padding: 1rem; text-align: right; color: #666;">
                                    Rp {{ number_format($detil->harga, 0, ',', '.') }}
                                </td>
                                <td style="padding: 1rem; text-align: center;">
                                    <span class="badge badge-primary" style="font-size: 0.9rem; padding: 0.4rem 0.8rem;">
                                        {{ $detil->jumlah }} pcs
                                    </span>
                                </td>
                                <td style="padding: 1rem; text-align: right; font-weight: 700; color: #667eea; font-size: 1.05rem;">
                                    Rp {{ number_format($detil->harga * $detil->jumlah, 0, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot style="background: #f8f9fc; border-top: 2px solid #667eea;">
                            <tr>
                                <td colspan="4" style="padding: 1rem; text-align: right; font-weight: 700; font-size: 1.1rem;">
                                    TOTAL PEMBELIAN:
                                </td>
                                <td style="padding: 1rem; text-align: right; font-weight: 700; font-size: 1.2rem; color: #11998e;">
                                    Rp {{ number_format($total, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- Supplier Contact Info (Optional) -->
        @if($pembelian->supplier)
        <div class="card mb-3" style="border: 1px solid #e3e6f0;">
            <div class="card-header" style="background: #f8f9fc;">
                <h6 class="mb-0"><i class="fas fa-address-card mr-2" style="color: #43e97b;"></i>Informasi Supplier</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-2"><strong>Nama Supplier:</strong> {{ $pembelian->supplier->nama }}</p>
                        @if($pembelian->supplier->telp)
                        <p class="mb-2"><strong>Telepon:</strong> {{ $pembelian->supplier->telp }}</p>
                        @endif
                    </div>
                    <div class="col-md-6">
                        @if($pembelian->supplier->alamat)
                        <p class="mb-2"><strong>Alamat:</strong> {{ $pembelian->supplier->alamat }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    <div class="modal-footer" style="background: #f8f9fc;">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
            <i class="fas fa-times mr-2"></i>Tutup
        </button>
    </div>
</div>
