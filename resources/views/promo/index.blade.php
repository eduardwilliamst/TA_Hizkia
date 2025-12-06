@extends('layouts.adminlte')

@section('title', 'Promo')

@section('page-bar')
<h1 class="m-0" style="color: #0d6efd; font-weight: 600;">
    <i class="fas fa-tags mr-2"></i>
    Data Promo
</h1>
@endsection

@section('content-header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                @yield('page-bar')
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" style="color: #0d6efd;"><i class="fas fa-home mr-1"></i>Dashboard</a></li>
                    <li class="breadcrumb-item active">Promo</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

@section('contents')
<div class="container-fluid">
<div class="card">
    <div class="card-header" style="background: #0d6efd; color: white;">
        <h3 class="card-title">
            <i class="fas fa-tags mr-2"></i>
            Daftar Promo
        </h3>
        <div class="card-tools">
            <button class="btn btn-light btn-sm" data-toggle="modal" data-target="#addPromoModal">
                <i class="fas fa-plus-circle mr-1"></i>
                Tambah Promo
            </button>
        </div>
    </div>

    <div class="card-body">
        <!-- Promo Type Filter -->
        <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem;">
            <button class="btn btn-outline-primary active" onclick="filterPromo('all', this)">
                <i class="fas fa-list"></i> Semua
            </button>
            <button class="btn btn-outline-success" onclick="filterPromo('produk gratis', this)">
                <i class="fas fa-gift"></i> Produk Gratis
            </button>
            <button class="btn btn-outline-warning" onclick="filterPromo('diskon', this)">
                <i class="fas fa-percent"></i> Diskon
            </button>
        </div>

        <div style="overflow-x: auto;">
            <table id="promoTable" class="datatable" style="width: 100%;">
                <thead>
                    <tr>
                        <th><i class="fas fa-info-circle" style="margin-right: 0.5rem;"></i>Deskripsi</th>
                        <th><i class="fas fa-tag" style="margin-right: 0.5rem;"></i>Tipe</th>
                        <th><i class="fas fa-box" style="margin-right: 0.5rem;"></i>Produk Utama</th>
                        <th><i class="fas fa-shopping-cart" style="margin-right: 0.5rem;"></i>Syarat</th>
                        <th><i class="fas fa-gift" style="margin-right: 0.5rem;"></i>Benefit</th>
                        <th><i class="fas fa-calendar" style="margin-right: 0.5rem;"></i>Periode</th>
                        <th><i class="fas fa-check-circle" style="margin-right: 0.5rem;"></i>Status</th>
                        <th style="text-align: center;"><i class="fas fa-cog" style="margin-right: 0.5rem;"></i>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($promos as $promo)
                    @php
                        $now = \Carbon\Carbon::now();
                        $isActive = $now->between($promo->tanggal_awal, $promo->tanggal_akhir);
                    @endphp
                    <tr data-tipe="{{ $promo->tipe }}">
                        <td style="font-weight: 600; color: #1F2937;">{{ $promo->deskripsi }}</td>
                        <td>
                            @if($promo->tipe == 'produk gratis')
                                <span class="badge" style="background: #10B981; color: white; padding: 0.375rem 0.75rem; border-radius: 6px;">
                                    <i class="fas fa-gift"></i> Produk Gratis
                                </span>
                            @else
                                <span class="badge" style="background: #F59E0B; color: white; padding: 0.375rem 0.75rem; border-radius: 6px;">
                                    <i class="fas fa-percent"></i> Diskon
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($promo->produkUtama)
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <img src="{{ asset('storage/' . $promo->produkUtama->gambar) }}"
                                         style="width: 40px; height: 40px; object-fit: cover; border-radius: 8px;"
                                         onerror="this.src='{{ asset('storage/images/default.png') }}'">
                                    <span>{{ $promo->produkUtama->nama }}</span>
                                </div>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge" style="background: #4F46E5; color: white; padding: 0.375rem 0.75rem; border-radius: 6px;">
                                Beli {{ $promo->buy_x }}
                            </span>
                        </td>
                        <td>
                            @if($promo->tipe == 'produk gratis')
                                <span class="badge" style="background: #10B981; color: white; padding: 0.375rem 0.75rem; border-radius: 6px;">
                                    Gratis {{ $promo->get_y }}
                                    @if($promo->produkTambahan)
                                        {{ $promo->produkTambahan->nama }}
                                    @else
                                        (Produk sama)
                                    @endif
                                </span>
                            @else
                                <span class="badge" style="background: #F59E0B; color: white; padding: 0.375rem 0.75rem; border-radius: 6px;">
                                    Diskon {{ $promo->nilai_diskon }}%
                                </span>
                            @endif
                        </td>
                        <td style="font-size: 0.875rem;">
                            <div>{{ \Carbon\Carbon::parse($promo->tanggal_awal)->format('d M Y') }}</div>
                            <div class="text-muted">s/d {{ \Carbon\Carbon::parse($promo->tanggal_akhir)->format('d M Y') }}</div>
                        </td>
                        <td>
                            @if($isActive)
                                <span class="badge" style="background: #10B981; color: white; padding: 0.375rem 0.75rem; border-radius: 6px;">
                                    <i class="fas fa-check"></i> Aktif
                                </span>
                            @else
                                <span class="badge" style="background: #6B7280; color: white; padding: 0.375rem 0.75rem; border-radius: 6px;">
                                    <i class="fas fa-clock"></i> Tidak Aktif
                                </span>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                <button data-toggle="modal" data-target="#modalEditPromo" onclick="modalEdit({{ $promo->idpromo }})" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('promo.destroy', $promo->idpromo) }}" method="POST" id="delete-form-{{ $promo->idpromo }}" style="display:inline; margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('delete-form-{{ $promo->idpromo }}')" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Promo -->
<div class="modal fade" id="addPromoModal" tabindex="-1" role="dialog" aria-labelledby="addPromoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%); color: white;">
                <h5 class="modal-title" id="addPromoModalLabel">
                    <i class="fas fa-plus-circle" style="margin-right: 0.5rem;"></i>Tambah Promo Baru
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 1.5rem;">
                <form action="{{ route('promo.store') }}" method="POST">
                    @csrf

                    <!-- Tipe Promo -->
                    <div class="form-group">
                        <label style="font-weight: 600; margin-bottom: 0.75rem; display: block;">
                            <i class="fas fa-tag" style="margin-right: 0.5rem; color: #4F46E5;"></i>Tipe Promo
                        </label>
                        <div style="display: flex; gap: 1rem;">
                            <label class="promo-type-option" style="flex: 1; cursor: pointer;">
                                <input type="radio" name="tipe" value="produk gratis" checked style="display: none;">
                                <div class="promo-type-card" style="background: white; border: 2px solid #10B981; border-radius: 12px; padding: 1rem; text-align: center; transition: all 0.3s ease;">
                                    <i class="fas fa-gift" style="font-size: 2rem; color: #10B981; margin-bottom: 0.5rem; display: block;"></i>
                                    <div style="font-weight: 600; color: #10B981;">Beli X Gratis Y</div>
                                    <small style="color: #6B7280;">Beli produk dapat bonus</small>
                                </div>
                            </label>
                            <label class="promo-type-option" style="flex: 1; cursor: pointer;">
                                <input type="radio" name="tipe" value="diskon" style="display: none;">
                                <div class="promo-type-card" style="background: white; border: 2px solid #E5E7EB; border-radius: 12px; padding: 1rem; text-align: center; transition: all 0.3s ease;">
                                    <i class="fas fa-percent" style="font-size: 2rem; color: #F59E0B; margin-bottom: 0.5rem; display: block;"></i>
                                    <div style="font-weight: 600; color: #F59E0B;">Beli X Dapat Diskon</div>
                                    <small style="color: #6B7280;">Beli produk dapat potongan %</small>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="form-group">
                        <label for="deskripsi" style="font-weight: 600;">
                            <i class="fas fa-info-circle" style="margin-right: 0.5rem; color: #4F46E5;"></i>Deskripsi Promo
                        </label>
                        <input type="text" class="form-control" id="deskripsi" name="deskripsi" placeholder="Contoh: Beli 3 Gratis 1" required style="border-radius: 8px;">
                    </div>

                    <!-- Produk Utama -->
                    <div class="form-group">
                        <label for="produk_idutama" style="font-weight: 600;">
                            <i class="fas fa-box" style="margin-right: 0.5rem; color: #4F46E5;"></i>Produk Utama (Yang Dibeli)
                        </label>
                        <select class="form-control" id="produk_idutama" name="produk_idutama" required style="border-radius: 8px;">
                            <option value="">-- Pilih Produk --</option>
                            @foreach($produks as $produk)
                                <option value="{{ $produk->idproduk }}">{{ $produk->nama }} - Rp {{ number_format($produk->harga, 0, ',', '.') }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <!-- Buy X -->
                        <div class="form-group">
                            <label for="buy_x" style="font-weight: 600;">
                                <i class="fas fa-shopping-cart" style="margin-right: 0.5rem; color: #4F46E5;"></i>Beli (Qty)
                            </label>
                            <input type="number" class="form-control" id="buy_x" name="buy_x" min="1" value="3" required style="border-radius: 8px;">
                        </div>

                        <!-- Get Y (untuk produk gratis) -->
                        <div class="form-group" id="getYGroup">
                            <label for="get_y" style="font-weight: 600;">
                                <i class="fas fa-gift" style="margin-right: 0.5rem; color: #10B981;"></i>Gratis (Qty)
                            </label>
                            <input type="number" class="form-control" id="get_y" name="get_y" min="1" value="1" style="border-radius: 8px;">
                        </div>

                        <!-- Nilai Diskon (untuk diskon) -->
                        <div class="form-group" id="diskonGroup" style="display: none;">
                            <label for="nilai_diskon" style="font-weight: 600;">
                                <i class="fas fa-percent" style="margin-right: 0.5rem; color: #F59E0B;"></i>Diskon (%)
                            </label>
                            <input type="number" class="form-control" id="nilai_diskon" name="nilai_diskon" min="1" max="100" value="10" style="border-radius: 8px;">
                        </div>
                    </div>

                    <!-- Produk Tambahan (untuk produk gratis) -->
                    <div class="form-group" id="produkTambahanGroup">
                        <label for="produk_idtambahan" style="font-weight: 600;">
                            <i class="fas fa-gift" style="margin-right: 0.5rem; color: #10B981;"></i>Produk Bonus (Opsional)
                        </label>
                        <select class="form-control" id="produk_idtambahan" name="produk_idtambahan" style="border-radius: 8px;">
                            <option value="">-- Sama dengan produk utama --</option>
                            @foreach($produks as $produk)
                                <option value="{{ $produk->idproduk }}">{{ $produk->nama }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Kosongkan jika produk bonus sama dengan produk utama</small>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <!-- Tanggal Awal -->
                        <div class="form-group">
                            <label for="tanggal_awal" style="font-weight: 600;">
                                <i class="fas fa-calendar-alt" style="margin-right: 0.5rem; color: #4F46E5;"></i>Tanggal Mulai
                            </label>
                            <input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal" required style="border-radius: 8px;">
                        </div>

                        <!-- Tanggal Akhir -->
                        <div class="form-group">
                            <label for="tanggal_akhir" style="font-weight: 600;">
                                <i class="fas fa-calendar-check" style="margin-right: 0.5rem; color: #4F46E5;"></i>Tanggal Selesai
                            </label>
                            <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" required style="border-radius: 8px;">
                        </div>
                    </div>

                    <!-- Preview Promo -->
                    <div id="promoPreview" style="background: #F3F4F6; border-radius: 12px; padding: 1rem; margin-top: 1rem;">
                        <div style="font-weight: 600; color: #1F2937; margin-bottom: 0.5rem;">
                            <i class="fas fa-eye" style="margin-right: 0.5rem;"></i>Preview Promo:
                        </div>
                        <div id="previewText" style="font-size: 1.1rem; color: #4F46E5; font-weight: 600;">
                            Beli 3 Gratis 1
                        </div>
                    </div>

                    <div class="modal-footer" style="border-top: none; padding: 1.5rem 0 0 0;">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Promo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEditPromo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" id="modalContent">
    </div>
</div>

</div>
@endsection

@section('style')
<style>
    .promo-type-option input[type="radio"]:checked + .promo-type-card {
        border-color: currentColor !important;
        background: rgba(79, 70, 229, 0.05) !important;
        transform: scale(1.02);
    }

    .promo-type-card:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .btn-outline-primary.active,
    .btn-outline-success.active,
    .btn-outline-warning.active {
        color: white !important;
    }

    .btn-outline-primary.active {
        background: #4F46E5 !important;
        border-color: #4F46E5 !important;
    }

    .btn-outline-success.active {
        background: #10B981 !important;
        border-color: #10B981 !important;
    }

    .btn-outline-warning.active {
        background: #F59E0B !important;
        border-color: #F59E0B !important;
    }
</style>
@endsection

@section('scripts')
<script>
    // Toggle form fields based on promo type
    document.querySelectorAll('input[name="tipe"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const tipe = this.value;
            const getYGroup = document.getElementById('getYGroup');
            const diskonGroup = document.getElementById('diskonGroup');
            const produkTambahanGroup = document.getElementById('produkTambahanGroup');

            // Update card styles
            document.querySelectorAll('.promo-type-card').forEach(card => {
                card.style.borderColor = '#E5E7EB';
            });
            this.nextElementSibling.style.borderColor = tipe === 'produk gratis' ? '#10B981' : '#F59E0B';

            if (tipe === 'produk gratis') {
                getYGroup.style.display = 'block';
                produkTambahanGroup.style.display = 'block';
                diskonGroup.style.display = 'none';
                document.getElementById('get_y').required = true;
                document.getElementById('nilai_diskon').required = false;
            } else {
                getYGroup.style.display = 'none';
                produkTambahanGroup.style.display = 'none';
                diskonGroup.style.display = 'block';
                document.getElementById('get_y').required = false;
                document.getElementById('nilai_diskon').required = true;
            }
            updatePreview();
        });
    });

    // Update preview
    function updatePreview() {
        const tipe = document.querySelector('input[name="tipe"]:checked').value;
        const buyX = document.getElementById('buy_x').value || 0;
        const getY = document.getElementById('get_y').value || 0;
        const diskon = document.getElementById('nilai_diskon').value || 0;
        const previewText = document.getElementById('previewText');

        if (tipe === 'produk gratis') {
            previewText.innerHTML = `<i class="fas fa-gift" style="margin-right: 0.5rem;"></i>Beli ${buyX} Gratis ${getY}`;
            previewText.style.color = '#10B981';
        } else {
            previewText.innerHTML = `<i class="fas fa-percent" style="margin-right: 0.5rem;"></i>Beli ${buyX} Dapat Diskon ${diskon}%`;
            previewText.style.color = '#F59E0B';
        }
    }

    document.getElementById('buy_x').addEventListener('input', updatePreview);
    document.getElementById('get_y').addEventListener('input', updatePreview);
    document.getElementById('nilai_diskon').addEventListener('input', updatePreview);

    // Filter promo by type
    function filterPromo(tipe, btn) {
        // Update button styles
        document.querySelectorAll('[onclick^="filterPromo"]').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        // Filter table rows
        const rows = document.querySelectorAll('#promoTable tbody tr');
        rows.forEach(row => {
            if (tipe === 'all' || row.dataset.tipe === tipe) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Modal edit
    function modalEdit(id) {
        $.ajax({
            type: 'POST',
            url: '{{ route("promo.getEditForm") }}',
            data: {
                '_token': '{{ csrf_token() }}',
                'id': id,
            },
            success: function(data) {
                $("#modalContent").html(data.msg);
                $("#modalEditPromo").modal('show');
            },
            error: function(xhr) {
                console.log(xhr);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Gagal memuat data promo'
                });
            }
        });
    }

    // Set default dates
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0];
        const nextMonth = new Date();
        nextMonth.setMonth(nextMonth.getMonth() + 1);

        document.getElementById('tanggal_awal').value = today;
        document.getElementById('tanggal_akhir').value = nextMonth.toISOString().split('T')[0];
    });
</script>
@endsection
