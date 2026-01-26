@extends('layouts.adminlte')

@section('title', 'Riwayat Pembelian')

@section('page-bar')
<h1 class="m-0">Riwayat Pembelian</h1>
@endsection

@section('contents')
<div class="content">
    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card animate-fade-in-up">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h3 class="mb-0">
                            <i class="fas fa-dolly mr-2"></i>
                            Daftar Riwayat Pembelian
                        </h3>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="{{ route('pembelian.index') }}" class="btn btn-primary" style="padding: 0.7rem 1.5rem; border-radius: 12px;">
                            <i class="fas fa-plus-circle mr-2"></i>Tambah Pembelian Baru
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body" style="padding: 2rem;">
                <div style="overflow-x: auto;">
                    <table id="pembelianTable" class="table table-hover" style="border-radius: 10px; overflow: hidden;">
                        <thead>
                            <tr>
                                <th><i class="fas fa-hashtag mr-2"></i>ID</th>
                                <th><i class="fas fa-calendar mr-2"></i>Tanggal</th>
                                <th><i class="fas fa-truck mr-2"></i>Supplier</th>
                                <th><i class="fas fa-box mr-2"></i>Produk</th>
                                <th><i class="fas fa-money-bill-wave mr-2"></i>Total</th>
                                <th style="text-align: center;"><i class="fas fa-cog mr-2"></i>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pembelians as $pembelian)
                            @php
                                $total = $pembelian->detils->sum(function($detil) {
                                    return $detil->harga * $detil->jumlah;
                                });
                            @endphp
                            <tr class="animate-fade-in">
                                <td style="font-weight: 600; color: #666;">
                                    #{{ $pembelian->idpembelian }}
                                </td>
                                <td style="font-weight: 500; color: #666;">
                                    <i class="far fa-clock mr-2"></i>
                                    {{ \Carbon\Carbon::parse($pembelian->tanggal_pesan)->translatedFormat('d M Y') }}
                                </td>
                                <td style="color: #333;">
                                    <i class="fas fa-building mr-1" style="color: #667eea;"></i>
                                    {{ $pembelian->supplier->nama ?? 'N/A' }}
                                </td>
                                <td>
                                    @if($pembelian->detils->count() > 0)
                                        <button class="btn btn-sm btn-info" type="button" data-toggle="collapse"
                                            data-target="#detil{{ $pembelian->idpembelian }}" aria-expanded="false"
                                            style="border-radius: 8px; padding: 0.4rem 0.8rem;">
                                            <i class="fas fa-eye mr-1"></i> Lihat Detail ({{ $pembelian->detils->count() }} item)
                                        </button>
                                        <div class="collapse mt-2" id="detil{{ $pembelian->idpembelian }}">
                                            <div class="card card-body" style="background: #f8f9fc; border: 1px solid #e3e6f0;">
                                                <table class="table table-sm mb-0">
                                                    <thead style="background: #e7e9fd;">
                                                        <tr>
                                                            <th>Produk</th>
                                                            <th>Harga Beli</th>
                                                            <th>Jumlah</th>
                                                            <th>Subtotal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($pembelian->detils as $detil)
                                                        <tr>
                                                            <td style="font-weight: 600;">{{ $detil->produk->nama ?? 'N/A' }}</td>
                                                            <td>Rp {{ number_format($detil->harga, 0, ',', '.') }}</td>
                                                            <td>
                                                                <span class="badge badge-primary">{{ $detil->jumlah }} pcs</span>
                                                            </td>
                                                            <td style="font-weight: 600; color: #667eea;">
                                                                Rp {{ number_format($detil->harga * $detil->jumlah, 0, ',', '.') }}
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @else
                                        <span class="badge badge-warning">Tidak ada produk</span>
                                    @endif
                                </td>
                                <td>
                                    <span style="font-weight: 700; color: #11998e; font-size: 1.05rem;">
                                        Rp {{ number_format($total, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td style="text-align: center;">
                                    <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                        <button class="btn btn-warning btn-sm" onclick="viewDetail({{ $pembelian->idpembelian }})"
                                            style="border-radius: 8px; padding: 0.5rem 1rem;" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <form action="{{ route('pembelian.destroy', $pembelian->idpembelian) }}"
                                            method="POST" id="delete-form-{{ $pembelian->idpembelian }}" style="display:inline; margin: 0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm"
                                                style="border-radius: 8px; padding: 0.5rem 1rem;"
                                                onclick="confirmDelete('delete-form-{{ $pembelian->idpembelian }}')"
                                                title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center" style="padding: 3rem; color: #999;">
                                    <i class="fas fa-inbox" style="font-size: 3rem; color: #ddd; margin-bottom: 1rem; display: block;"></i>
                                    <h5 style="color: #666; font-weight: 600;">Belum Ada Riwayat Pembelian</h5>
                                    <p style="color: #999; font-size: 0.9rem;">Mulai tambahkan pembelian produk dari supplier</p>
                                    <a href="{{ route('pembelian.index') }}" class="btn btn-primary mt-2">
                                        <i class="fas fa-plus mr-2"></i>Tambah Pembelian
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($pembelians->hasPages())
                <div class="mt-4 d-flex justify-content-center">
                    {{ $pembelians->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Pembelian -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" id="detailContent">
            <!-- Content will be loaded via AJAX -->
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script>
    $(document).ready(function() {
        $('#pembelianTable').DataTable({
            order: [[0, 'desc']],
            pageLength: 20,
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ pembelian",
                zeroRecords: "Pembelian tidak ditemukan",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ pembelian",
                infoEmpty: "Tidak ada pembelian",
                infoFiltered: "(difilter dari _MAX_ total pembelian)",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "›",
                    previous: "‹"
                }
            }
        });
    });

    function viewDetail(pembelianId) {
        LoaderUtil.show('Memuat detail pembelian...');

        $.ajax({
            type: 'GET',
            url: '/pembelian/' + pembelianId,
            success: function(data) {
                LoaderUtil.hide();
                $('#detailContent').html(data);
                $('#detailModal').modal('show');
            },
            error: function(xhr) {
                LoaderUtil.hide();
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Gagal memuat detail pembelian',
                    confirmButtonColor: '#d33'
                });
            }
        });
    }

    function confirmDelete(formId) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Pembelian akan dihapus dan stok produk akan dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                LoaderUtil.show('Menghapus pembelian...');
                document.getElementById(formId).submit();
            }
        });
    }
</script>
@endsection
