@extends('layouts.adminlte')

@section('title', 'List Sesi POS')

@section('page-bar')
<h1 class="m-0">Riwayat Sesi POS</h1>
@endsection

@section('contents')
<div class="content">
    <div class="container-fluid">
        <div class="card animate-fade-in-up">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h3 class="mb-0">
                            <i class="fas fa-cash-register mr-2"></i>
                            Daftar Sesi POS
                        </h3>
                    </div>
                    <div class="col-md-6 text-right">
                        <span class="badge badge-info" style="padding: 0.5rem 1rem; font-size: 0.9rem;">
                            <i class="fas fa-crown mr-1"></i> Admin Only
                        </span>
                    </div>
                </div>
            </div>

            <div class="card-body" style="padding: 2rem;">
                <div style="overflow-x: auto;">
                    <table id="sessionTable" class="table table-hover" style="border-radius: 10px; overflow: hidden;">
                        <thead>
                            <tr>
                                <th><i class="fas fa-hashtag mr-2"></i>ID</th>
                                <th><i class="fas fa-calendar mr-2"></i>Tanggal</th>
                                <th><i class="fas fa-user mr-2"></i>Kasir</th>
                                <th><i class="fas fa-desktop mr-2"></i>POS Mesin</th>
                                <th><i class="fas fa-money-bill-wave mr-2"></i>Saldo Awal</th>
                                <th><i class="fas fa-wallet mr-2"></i>Saldo Akhir</th>
                                <th><i class="fas fa-chart-line mr-2"></i>Selisih</th>
                                <th><i class="fas fa-info-circle mr-2"></i>Status</th>
                                <th style="text-align: center;"><i class="fas fa-cog mr-2"></i>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sessions as $session)
                            <tr class="animate-fade-in">
                                <td style="font-weight: 600; color: #666;">
                                    #{{ $session->idpos_session }}
                                </td>
                                <td style="font-weight: 500; color: #666;">
                                    <i class="far fa-clock mr-2"></i>
                                    {{ \Carbon\Carbon::parse($session->tanggal)->translatedFormat('d M Y, H:i') }}
                                </td>
                                <td style="color: #333;">
                                    <i class="fas fa-user-circle mr-1" style="color: #667eea;"></i>
                                    {{ $session->user->name ?? 'N/A' }}
                                </td>
                                <td style="color: #666;">
                                    <i class="fas fa-desktop mr-1" style="color: #4facfe;"></i>
                                    {{ $session->posMesin->nama ?? 'N/A' }}
                                </td>
                                <td style="font-weight: 600; color: #11998e;">
                                    Rp {{ number_format($session->balance_awal, 0, ',', '.') }}
                                </td>
                                <td style="font-weight: 600; color: {{ $session->balance_akhir ? '#333' : '#999' }};">
                                    @if($session->balance_akhir)
                                        Rp {{ number_format($session->balance_akhir, 0, ',', '.') }}
                                    @else
                                        <span class="badge badge-warning">Belum ditutup</span>
                                    @endif
                                </td>
                                <td>
                                    @if($session->balance_akhir)
                                        @php
                                            $selisih = $session->balance_akhir - $session->balance_awal;
                                        @endphp
                                        <span class="badge" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;
                                            background: {{ $selisih >= 0 ? 'linear-gradient(135deg, #11998e 0%, #38ef7d 100%)' : 'linear-gradient(135deg, #eb3349 0%, #f45c43 100%)' }};
                                            color: white; border-radius: 8px;">
                                            <i class="fas fa-{{ $selisih >= 0 ? 'arrow-up' : 'arrow-down' }} mr-1"></i>
                                            Rp {{ number_format(abs($selisih), 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span style="color: #999;">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($session->balance_akhir)
                                        <span class="badge badge-success" style="padding: 0.4rem 0.8rem; border-radius: 8px;">
                                            <i class="fas fa-check-circle mr-1"></i>Selesai
                                        </span>
                                    @else
                                        <span class="badge badge-warning" style="padding: 0.4rem 0.8rem; border-radius: 8px;">
                                            <i class="fas fa-clock mr-1"></i>Aktif
                                        </span>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    <button class="btn btn-info btn-sm" onclick="viewSessionDetail({{ $session->idpos_session }})"
                                        style="border-radius: 8px; padding: 0.5rem 1rem;" title="Lihat Detail">
                                        <i class="fas fa-eye"></i> Detail
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center" style="padding: 3rem; color: #999;">
                                    <i class="fas fa-inbox" style="font-size: 3rem; color: #ddd; margin-bottom: 1rem; display: block;"></i>
                                    <h5 style="color: #666; font-weight: 600;">Belum Ada Sesi POS</h5>
                                    <p style="color: #999; font-size: 0.9rem;">Sesi akan muncul setelah kasir membuka shift</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($sessions->hasPages())
                <div class="mt-4 d-flex justify-content-center">
                    {{ $sessions->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Session -->
<div class="modal fade" id="sessionDetailModal" tabindex="-1" aria-labelledby="sessionDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" id="sessionDetailContent">
            <!-- Content will be loaded via AJAX -->
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script>
    $(document).ready(function() {
        $('#sessionTable').DataTable({
            order: [[0, 'desc']],
            pageLength: 20,
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ sesi",
                zeroRecords: "Sesi tidak ditemukan",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ sesi",
                infoEmpty: "Tidak ada sesi",
                infoFiltered: "(difilter dari _MAX_ total sesi)",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "›",
                    previous: "‹"
                }
            }
        });
    });

    function viewSessionDetail(sessionId) {
        LoaderUtil.show('Memuat detail sesi...');

        $.ajax({
            type: 'GET',
            url: '/pos-session/' + sessionId + '/detail',
            success: function(data) {
                LoaderUtil.hide();
                $('#sessionDetailContent').html(data);
                $('#sessionDetailModal').modal('show');
            },
            error: function(xhr) {
                LoaderUtil.hide();
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Gagal memuat detail sesi',
                    confirmButtonColor: '#d33'
                });
            }
        });
    }
</script>
@endsection
