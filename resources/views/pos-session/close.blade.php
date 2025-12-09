@extends('layouts.adminlte')

@section('title', 'Menutup Kasir')

@section('contents')
<div class="container-fluid d-flex align-items-center justify-content-center" style="min-height: 85vh;">
    <div class="row w-100 justify-content-center">
        <div class="col-md-8 col-lg-7">
            <div class="card" style="border: none; border-radius: 12px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);">
                <div class="card-header text-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px 12px 0 0; padding: 1.5rem;">
                    <h3 style="color: white; font-weight: 600; margin: 0;">
                        <i class="fas fa-cash-register mr-2"></i>Menutup Kasir
                    </h3>
                    <p style="color: rgba(255,255,255,0.9); margin: 0.5rem 0 0 0; font-size: 0.95rem;">
                        {{ $summary['jumlahTransaksi'] }} pesanan: Rp {{ number_format($summary['totalPenjualan'], 2, ',', '.') }}
                    </p>
                </div>

                <form action="{{ route('possession.process-close') }}" method="POST" id="closeSessionForm">
                    @csrf
                    <div class="card-body" style="padding: 1.5rem;">
                        <!-- Kas Section -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 style="margin: 0; font-weight: 600; color: #333;">
                                    <i class="fas fa-money-bill-wave mr-2" style="color: #1cc88a;"></i>Kas
                                </h5>
                                <h5 style="margin: 0; font-weight: 700; color: #1cc88a;">
                                    Rp {{ number_format($summary['kasTotal'], 2, ',', '.') }}
                                </h5>
                            </div>
                            <div class="pl-4">
                                <div class="d-flex justify-content-between py-1">
                                    <span style="color: #666;">Opening</span>
                                    <span style="color: #333;">Rp {{ number_format($summary['balanceAwal'], 2, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between py-1">
                                    <span style="color: #666;">▸ Tunai Masuk / Keluar</span>
                                    <span style="color: #333;">+ Rp {{ number_format($summary['cashInOut'], 2, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between py-1">
                                    <span style="color: #666;">Dihitung</span>
                                    <span style="color: #333;">Rp {{ number_format($summary['kasTotal'], 2, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between py-1">
                                    <span style="color: #dc3545; font-weight: 600;">Selisih</span>
                                    <span style="color: #dc3545; font-weight: 600;" id="selisihKas">Rp -{{ number_format($summary['kasTotal'], 2, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        <hr style="border-color: #e3e6f0;">

                        <!-- Kartu Section -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 style="margin: 0; font-weight: 600; color: #333;">
                                    <i class="fas fa-credit-card mr-2" style="color: #36b9cc;"></i>Kartu
                                </h5>
                                <h5 style="margin: 0; font-weight: 700; color: #36b9cc;">
                                    Rp {{ number_format($summary['kartuTotal'], 2, ',', '.') }}
                                </h5>
                            </div>
                            <div class="pl-4">
                                <div class="d-flex justify-content-between py-1">
                                    <span style="color: #666;">Dihitung</span>
                                    <span style="color: #333;">Rp {{ number_format($summary['kartuTotal'], 2, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between py-1">
                                    <span style="color: #666;">Selisih</span>
                                    <span style="color: #666;">Rp 0,00</span>
                                </div>
                            </div>
                        </div>

                        <hr style="border-color: #e3e6f0;">

                        <!-- Akun Pelanggan Section -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 style="margin: 0; font-weight: 600; color: #333;">
                                    <i class="fas fa-user-circle mr-2" style="color: #f6c23e;"></i>Akun Pelanggan
                                </h5>
                                <h5 style="margin: 0; font-weight: 700; color: #666;">
                                    Rp 0,00
                                </h5>
                            </div>
                            <div class="pl-4">
                                <div class="d-flex justify-content-between py-1">
                                    <span style="color: #666;">Dihitung</span>
                                    <span style="color: #333;">Rp 0,00</span>
                                </div>
                                <div class="d-flex justify-content-between py-1">
                                    <span style="color: #666;">Selisih</span>
                                    <span style="color: #666;">Rp 0,00</span>
                                </div>
                            </div>
                        </div>

                        <hr style="border-color: #e3e6f0;">

                        <!-- Jumlah Tunai Input -->
                        <div class="form-group mb-4">
                            <label style="font-weight: 600; color: #5a5c69; margin-bottom: 0.5rem;">
                                <i class="fas fa-coins mr-2" style="color: #e74a3b;"></i>Jumlah Tunai
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="background: #f8f9fa; border: 1px solid #d1d3e2;">
                                        <i class="fas fa-times mr-2" style="color: #858796; cursor: pointer;" onclick="$('#jumlah_tunai').val(0).trigger('input')"></i>
                                        <i class="fas fa-calculator mr-2" style="color: #858796;"></i>
                                    </span>
                                </div>
                                <input type="number"
                                       class="form-control form-control-lg"
                                       name="jumlah_tunai"
                                       id="jumlah_tunai"
                                       placeholder="0"
                                       value="0"
                                       min="0"
                                       step="1000"
                                       style="border: 1px solid #d1d3e2; font-size: 1.25rem; font-weight: 600; text-align: right;">
                                <div class="input-group-append">
                                    <span class="input-group-text" style="background: #f8f9fa; border: 1px solid #d1d3e2;">
                                        <i class="fas fa-copy" style="color: #858796; cursor: pointer;" onclick="copyExpectedCash()"></i>
                                    </span>
                                </div>
                            </div>
                            <small class="text-muted">
                                <i class="fas fa-info-circle mr-1"></i>Masukkan jumlah uang kas fisik yang ada
                            </small>
                        </div>

                        <!-- Catatan Closing -->
                        <div class="form-group mb-4">
                            <label style="font-weight: 600; color: #5a5c69; margin-bottom: 0.5rem;">
                                <i class="fas fa-sticky-note mr-2" style="color: #4e73df;"></i>Catatan closing
                            </label>
                            <textarea class="form-control"
                                      name="catatan_closing"
                                      id="catatan_closing"
                                      rows="3"
                                      placeholder="Tambahkan catatan closing..."
                                      style="border: 1px solid #d1d3e2; resize: none;"></textarea>
                        </div>

                        <!-- Hidden fields for summary data -->
                        <input type="hidden" name="balance_akhir" value="{{ $summary['kasTotal'] }}">
                        <input type="hidden" name="total_cash" value="{{ $summary['kasTotal'] }}">
                        <input type="hidden" name="total_card" value="{{ $summary['kartuTotal'] }}">
                    </div>

                    <div class="card-footer d-flex justify-content-between" style="background: #f8f9fa; border-top: 1px solid #e3e6f0; padding: 1.5rem; border-radius: 0 0 12px 12px;">
                        <button type="button" class="btn btn-secondary btn-lg" onclick="window.history.back()">
                            <i class="fas fa-arrow-left mr-2"></i>Buang
                        </button>
                        <div>
                            <button type="button" class="btn btn-outline-primary btn-lg mr-2" onclick="downloadSaleReport()">
                                <i class="fas fa-download mr-2"></i>Sale Hari ⬇
                            </button>
                            <button type="submit" class="btn btn-lg" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 0.75rem 2rem; border: none; font-weight: 600;">
                                <i class="fas fa-check-circle mr-2"></i>Tutup Kasir
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script>
$(document).ready(function() {
    const expectedCash = {{ $summary['kasTotal'] }};

    // Update selisih when jumlah tunai changes
    $('#jumlah_tunai').on('input', function() {
        let jumlahTunai = parseFloat($(this).val()) || 0;
        let selisih = jumlahTunai - expectedCash;

        let color = selisih === 0 ? '#666' : (selisih < 0 ? '#dc3545' : '#1cc88a');
        let sign = selisih >= 0 ? '' : '-';
        let absSelisih = Math.abs(selisih);

        $('#selisihKas').text('Rp ' + sign + absSelisih.toLocaleString('id-ID', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        })).css('color', color);
    });

    // Form submission
    $('#closeSessionForm').on('submit', function(e) {
        e.preventDefault();

        let jumlahTunai = parseFloat($('#jumlah_tunai').val()) || 0;
        let selisih = jumlahTunai - expectedCash;

        Swal.fire({
            title: 'Konfirmasi Tutup Kasir',
            html: `
                <div style="text-align: left; padding: 1rem;">
                    <p style="font-size: 1.1rem; margin-bottom: 1rem;">Apakah Anda yakin ingin menutup kasir?</p>
                    <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px;">
                        <div style="margin-bottom: 0.5rem;">
                            <strong>Kas Expected:</strong>
                            <span style="color: #1cc88a; font-size: 1.1rem; font-weight: bold;">
                                Rp ${expectedCash.toLocaleString('id-ID', {minimumFractionDigits: 2})}
                            </span>
                        </div>
                        <div style="margin-bottom: 0.5rem;">
                            <strong>Kas Actual:</strong>
                            <span style="font-size: 1.1rem; font-weight: bold;">
                                Rp ${jumlahTunai.toLocaleString('id-ID', {minimumFractionDigits: 2})}
                            </span>
                        </div>
                        <div>
                            <strong>Selisih:</strong>
                            <span style="color: ${selisih === 0 ? '#666' : (selisih < 0 ? '#dc3545' : '#1cc88a')}; font-size: 1.2rem; font-weight: bold;">
                                Rp ${Math.abs(selisih).toLocaleString('id-ID', {minimumFractionDigits: 2})}
                            </span>
                            ${selisih !== 0 ? `<span style="color: #858796;">(${selisih > 0 ? 'Lebih' : 'Kurang'})</span>` : ''}
                        </div>
                    </div>
                    ${selisih !== 0 ? `
                    <div style="margin-top: 1rem; padding: 0.75rem; background: #fff3cd; border-left: 4px solid #ffc107; border-radius: 4px;">
                        <i class="fas fa-exclamation-triangle" style="color: #ffc107;"></i>
                        <strong>Perhatian:</strong> Ada selisih kas sebesar Rp ${Math.abs(selisih).toLocaleString('id-ID', {minimumFractionDigits: 2})}
                    </div>
                    ` : ''}
                    <p style="margin-top: 1rem; color: #858796; font-size: 0.9rem;">
                        <i class="fas fa-info-circle mr-1"></i>
                        Sesi akan ditutup dan Anda akan logout dari sistem
                    </p>
                </div>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: '<i class="fas fa-check mr-2"></i>Ya, Tutup Kasir',
            cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
            confirmButtonColor: '#667eea',
            cancelButtonColor: '#858796',
            width: '600px'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Menutup Kasir...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                this.submit();
            }
        });
    });
});

function copyExpectedCash() {
    const expectedCash = {{ $summary['kasTotal'] }};
    $('#jumlah_tunai').val(expectedCash).trigger('input');

    Swal.fire({
        icon: 'success',
        title: 'Copied!',
        text: 'Jumlah kas expected telah disalin',
        timer: 1500,
        showConfirmButton: false,
        position: 'top-end',
        toast: true
    });
}

function downloadSaleReport() {
    window.open('{{ route("laporan.penjualan") }}?periode=today', '_blank');
}
</script>

<style>
#jumlah_tunai:focus,
#catatan_closing:focus {
    border-color: #667eea !important;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25) !important;
}

input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
    opacity: 1;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.card {
    animation: fadeInUp 0.5s ease;
}

.input-group-text i {
    transition: color 0.2s;
}

.input-group-text i:hover {
    color: #4e73df !important;
}
</style>
@endsection
