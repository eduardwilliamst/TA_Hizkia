@extends('layouts.adminlte')

@section('title', 'Buka Pendaftaran Kas')

@section('contents')
<div class="container-fluid d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="row w-100 justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card" style="border: none; border-radius: 12px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);">
                <div class="card-header text-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px 12px 0 0; padding: 2rem;">
                    <h3 style="color: white; font-weight: 600; margin: 0;">
                        <i class="fas fa-cash-register mr-2"></i>Kontrol Pembukaan
                    </h3>
                    <p style="color: rgba(255,255,255,0.9); margin: 0.5rem 0 0 0; font-size: 0.95rem;">
                        Silakan set saldo awal untuk memulai sesi
                    </p>
                </div>

                <form action="{{ route('possession.open') }}" method="POST" id="openSessionForm">
                    @csrf
                    <div class="card-body" style="padding: 2rem;">
                        <!-- Kas Opening -->
                        <div class="form-group mb-4">
                            <label style="font-weight: 600; color: #5a5c69; margin-bottom: 0.5rem;">
                                <i class="fas fa-money-bill-wave mr-2" style="color: #1cc88a;"></i>Kas Opening
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="background: #f8f9fa; border: 1px solid #d1d3e2;">
                                        <strong>Rp</strong>
                                    </span>
                                </div>
                                <input type="number"
                                       class="form-control form-control-lg"
                                       name="balance_awal"
                                       id="balance_awal"
                                       placeholder="0"
                                       required
                                       min="0"
                                       step="1000"
                                       style="border: 1px solid #d1d3e2; font-size: 1.25rem; font-weight: 600; text-align: right;">
                            </div>
                            <small class="text-muted">
                                <i class="fas fa-info-circle mr-1"></i>Masukkan jumlah uang kas awal dalam kelipatan Rp 1.000
                            </small>
                        </div>

                        <!-- Catatan Opening -->
                        <div class="form-group mb-4">
                            <label style="font-weight: 600; color: #5a5c69; margin-bottom: 0.5rem;">
                                <i class="fas fa-sticky-note mr-2" style="color: #36b9cc;"></i>Catatan Opening
                            </label>
                            <textarea class="form-control"
                                      name="keterangan"
                                      id="keterangan"
                                      rows="3"
                                      placeholder="Tambahkan catatan opening..."
                                      style="border: 1px solid #d1d3e2; resize: none;"></textarea>
                            <small class="text-muted">
                                <i class="fas fa-info-circle mr-1"></i>Opsional - Catatan khusus untuk sesi ini
                            </small>
                        </div>

                        <!-- Session Info -->
                        <div class="alert" style="background: #e7f3ff; border: 1px solid #b8daff; border-radius: 8px; padding: 1rem;">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-info-circle mr-2" style="color: #0d6efd; margin-top: 3px;"></i>
                                <div style="flex: 1;">
                                    <strong style="color: #0d6efd;">Informasi Sesi</strong>
                                    <div style="margin-top: 0.5rem; font-size: 0.9rem; color: #495057;">
                                        <div class="mb-1">
                                            <i class="fas fa-user mr-2"></i>
                                            <strong>Kasir:</strong> {{ auth()->user()->name }}
                                        </div>
                                        <div class="mb-1">
                                            <i class="fas fa-calendar mr-2"></i>
                                            <strong>Tanggal:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y') }}
                                        </div>
                                        <div>
                                            <i class="fas fa-clock mr-2"></i>
                                            <strong>Waktu:</strong> {{ \Carbon\Carbon::now()->format('H:i') }} WIB
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer" style="background: #f8f9fa; border-top: 1px solid #e3e6f0; padding: 1.5rem; border-radius: 0 0 12px 12px;">
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-lg" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 0.75rem 2rem; border: none; border-radius: 8px; font-weight: 600;">
                                <i class="fas fa-check-circle mr-2"></i>Buka Pendaftaran
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Help Text -->
            <div class="text-center mt-4" style="color: #858796;">
                <i class="fas fa-shield-alt mr-2"></i>
                Sesi akan otomatis terbuka setelah Anda mengkonfirmasi kas opening
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script>
$(document).ready(function() {
    // Format number input with thousands separator
    $('#balance_awal').on('input', function() {
        let value = $(this).val().replace(/\D/g, '');
        if (value) {
            $(this).val(parseInt(value));
        }
    });

    // Form validation
    $('#openSessionForm').on('submit', function(e) {
        const balanceAwal = parseInt($('#balance_awal').val());

        if (isNaN(balanceAwal) || balanceAwal < 0) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Kas Opening Tidak Valid',
                text: 'Mohon masukkan jumlah kas opening yang valid',
                confirmButtonColor: '#667eea'
            });
            return false;
        }

        // Show confirmation
        e.preventDefault();

        Swal.fire({
            title: 'Konfirmasi Pembukaan Kas',
            html: `
                <div style="text-align: left; padding: 1rem;">
                    <p style="font-size: 1.1rem; margin-bottom: 1rem;">Apakah Anda yakin ingin membuka sesi dengan:</p>
                    <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px;">
                        <div style="margin-bottom: 0.5rem;">
                            <strong>Kas Opening:</strong>
                            <span style="color: #1cc88a; font-size: 1.2rem; font-weight: bold;">
                                Rp ${balanceAwal.toLocaleString('id-ID')}
                            </span>
                        </div>
                        ${$('#keterangan').val() ? `
                        <div>
                            <strong>Catatan:</strong>
                            <span style="color: #666;">${$('#keterangan').val()}</span>
                        </div>
                        ` : ''}
                    </div>
                    <p style="margin-top: 1rem; color: #858796; font-size: 0.9rem;">
                        <i class="fas fa-info-circle mr-1"></i>
                        Setelah dikonfirmasi, Anda dapat mulai melakukan transaksi
                    </p>
                </div>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: '<i class="fas fa-check mr-2"></i>Ya, Buka Sesi',
            cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
            confirmButtonColor: '#667eea',
            cancelButtonColor: '#858796',
            width: '500px'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading overlay
                LoaderUtil.show('Membuka sesi kasir...');

                // Submit form
                this.submit();
            }
        });
    });

    // Auto-focus on balance input
    $('#balance_awal').focus();
});
</script>

<style>
/* Custom styling for inputs */
#balance_awal:focus,
#keterangan:focus {
    border-color: #667eea !important;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25) !important;
}

/* Remove spinner from number input */
input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
    opacity: 1;
}

/* Animate card on load */
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
</style>
@endsection
