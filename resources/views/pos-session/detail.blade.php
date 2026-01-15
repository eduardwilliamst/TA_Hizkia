<div class="modal-content">
    <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
        <h5 class="modal-title">
            <i class="fas fa-cash-register mr-2"></i>Detail Sesi POS #{{ $session->idpos_session }}
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
        <!-- Session Info -->
        <div class="card mb-3" style="border: 1px solid #e3e6f0;">
            <div class="card-header" style="background: #f8f9fc;">
                <h6 class="mb-0"><i class="fas fa-info-circle mr-2" style="color: #667eea;"></i>Informasi Sesi</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-2"><strong>Kasir:</strong> {{ $session->user->name ?? 'N/A' }}</p>
                        <p class="mb-2"><strong>POS Mesin:</strong> {{ $session->posMesin->nama ?? 'N/A' }}</p>
                        <p class="mb-2"><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($session->tanggal)->translatedFormat('d F Y, H:i') }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2"><strong>Saldo Awal:</strong> <span style="color: #11998e; font-weight: 600;">Rp {{ number_format($session->balance_awal, 0, ',', '.') }}</span></p>
                        <p class="mb-2"><strong>Saldo Akhir:</strong>
                            @if($session->balance_akhir)
                                <span style="color: #333; font-weight: 600;">Rp {{ number_format($session->balance_akhir, 0, ',', '.') }}</span>
                            @else
                                <span class="badge badge-warning">Belum ditutup</span>
                            @endif
                        </p>
                        <p class="mb-2"><strong>Status:</strong>
                            @if($session->balance_akhir)
                                <span class="badge badge-success">Selesai</span>
                            @else
                                <span class="badge badge-warning">Aktif</span>
                            @endif
                        </p>
                    </div>
                </div>
                @if($session->keterangan)
                <div class="mt-2">
                    <strong>Keterangan:</strong>
                    <p class="mb-0 text-muted">{{ $session->keterangan }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Sales Summary -->
        <div class="card mb-3" style="border: 1px solid #e3e6f0;">
            <div class="card-header" style="background: #f8f9fc;">
                <h6 class="mb-0"><i class="fas fa-chart-pie mr-2" style="color: #4facfe;"></i>Ringkasan Penjualan</h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-4">
                        <div style="padding: 1rem; border-radius: 8px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <h6 style="color: white; margin-bottom: 0.5rem; font-size: 0.85rem;">Total Transaksi</h6>
                            <h4 style="color: white; font-weight: 700; margin: 0;">{{ $penjualans->count() }}</h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="padding: 1rem; border-radius: 8px; background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                            <h6 style="color: white; margin-bottom: 0.5rem; font-size: 0.85rem;">Cash</h6>
                            <h4 style="color: white; font-weight: 700; margin: 0;">Rp {{ number_format($cashSales, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="padding: 1rem; border-radius: 8px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                            <h6 style="color: white; margin-bottom: 0.5rem; font-size: 0.85rem;">Card</h6>
                            <h4 style="color: white; font-weight: 700; margin: 0;">Rp {{ number_format($cardSales, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
                <div class="mt-3 text-center">
                    <h5 class="mb-0">Total Penjualan: <strong style="color: #667eea;">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</strong></h5>
                </div>
            </div>
        </div>

        <!-- Cashflow Summary -->
        <div class="card mb-3" style="border: 1px solid #e3e6f0;">
            <div class="card-header" style="background: #f8f9fc;">
                <h6 class="mb-0"><i class="fas fa-exchange-alt mr-2" style="color: #43e97b;"></i>Cashflow</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-2"><strong>Total Cash In:</strong> <span style="color: #11998e; font-weight: 600;">Rp {{ number_format($totalCashIn, 0, ',', '.') }}</span></p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2"><strong>Total Cash Out:</strong> <span style="color: #eb3349; font-weight: 600;">Rp {{ number_format($totalCashOut, 0, ',', '.') }}</span></p>
                    </div>
                </div>
                @if($cashFlows->count() > 0)
                <div class="mt-3">
                    <h6 style="font-size: 0.9rem; font-weight: 600; color: #666; margin-bottom: 0.5rem;">Rincian Cashflow:</h6>
                    <div style="max-height: 200px; overflow-y: auto;">
                        <table class="table table-sm table-hover">
                            <thead style="background: #f8f9fc;">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Tipe</th>
                                    <th>Jumlah</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cashFlows as $cf)
                                <tr>
                                    <td style="font-size: 0.85rem;">{{ \Carbon\Carbon::parse($cf->tanggal)->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <span class="badge badge-{{ $cf->tipe == 'cash_in' || $cf->tipe == 'saldo_awal' ? 'success' : 'danger' }}" style="font-size: 0.75rem;">
                                            {{ $cf->tipe }}
                                        </span>
                                    </td>
                                    <td style="font-weight: 600; color: {{ $cf->tipe == 'cash_in' || $cf->tipe == 'saldo_awal' ? '#11998e' : '#eb3349' }}; font-size: 0.85rem;">
                                        Rp {{ number_format($cf->jumlah, 0, ',', '.') }}
                                    </td>
                                    <td style="font-size: 0.85rem;">{{ Str::limit($cf->keterangan, 40) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Sales List -->
        @if($penjualans->count() > 0)
        <div class="card mb-3" style="border: 1px solid #e3e6f0;">
            <div class="card-header" style="background: #f8f9fc;">
                <h6 class="mb-0"><i class="fas fa-receipt mr-2" style="color: #f5576c;"></i>Daftar Transaksi ({{ $penjualans->count() }})</h6>
            </div>
            <div class="card-body">
                <div style="max-height: 300px; overflow-y: auto;">
                    <table class="table table-sm table-hover">
                        <thead style="background: #f8f9fc; position: sticky; top: 0; z-index: 1;">
                            <tr>
                                <th>No Transaksi</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Cara Bayar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($penjualans as $penjualan)
                            <tr>
                                <td style="font-weight: 600; font-size: 0.85rem;">#{{ $penjualan->idpenjualan }}</td>
                                <td style="font-size: 0.85rem;">{{ \Carbon\Carbon::parse($penjualan->tanggal)->format('d/m/Y H:i') }}</td>
                                <td style="font-weight: 600; color: #667eea; font-size: 0.85rem;">Rp {{ number_format($penjualan->total_harga, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge badge-{{ $penjualan->cara_bayar == 'cash' ? 'success' : 'info' }}" style="font-size: 0.75rem;">
                                        {{ $penjualan->cara_bayar == 'cash' ? 'Cash' : 'Card' }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
