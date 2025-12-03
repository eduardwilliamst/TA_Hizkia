@extends('layouts.pos')

@section('title', 'Keranjang')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">Keranjang Belanja</h1>
    <div class="page-breadcrumb">
        <div class="breadcrumb-item">
            <a href="{{ route('dashboard') }}" class="breadcrumb-link">
                <i class="fas fa-home"></i>
                Dashboard
            </a>
        </div>
        <div class="breadcrumb-item">
            <span>Keranjang</span>
        </div>
    </div>
</div>

<div class="card" style="max-width: 1000px; margin: 0 auto;">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-shopping-cart" style="margin-right: 0.5rem;"></i>
            Daftar Belanja
        </h3>
        <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i>
            Kembali Belanja
        </a>
    </div>
    <div class="card-body">
        @if(empty($cart))
            <div style="padding: 4rem 2rem; text-align: center;">
                <i class="fas fa-shopping-cart" style="font-size: 6rem; color: #E5E7EB; margin-bottom: 1.5rem; display: block;"></i>
                <h4 style="color: #6B7280; font-weight: 600; margin-bottom: 1rem;">Keranjang Belanja Kosong</h4>
                <p style="color: #9CA3AF; margin-bottom: 2rem;">Tambahkan produk untuk melanjutkan transaksi</p>
                <a href="{{ route('penjualan.index') }}" class="btn btn-primary">
                    <i class="fas fa-shopping-bag" style="margin-right: 0.5rem;"></i>Mulai Belanja
                </a>
            </div>
        @else
            <div style="overflow-x: auto;">
                <table class="table" style="width: 100%;">
                    <thead>
                        <tr>
                            <th><i class="fas fa-box" style="margin-right: 0.5rem;"></i>Nama Produk</th>
                            <th><i class="fas fa-money-bill-wave" style="margin-right: 0.5rem;"></i>Harga</th>
                            <th style="text-align: center;"><i class="fas fa-hashtag" style="margin-right: 0.5rem;"></i>Jumlah</th>
                            <th><i class="fas fa-calculator" style="margin-right: 0.5rem;"></i>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cart as $item)
                            <tr>
                                <td style="font-weight: 600; color: #1F2937;">{{ $item['name'] }}</td>
                                <td style="color: #10B981; font-weight: 600;">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                                <td style="text-align: center;">
                                    <span class="badge" style="background: #4F46E5; color: white; padding: 0.375rem 0.75rem; border-radius: 6px;">
                                        {{ $item['quantity'] }} x
                                    </span>
                                </td>
                                <td style="font-weight: 700; color: #1F2937; font-size: 1.05rem;">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="border-top: 2px solid #E5E7EB; margin-top: 1.5rem; padding-top: 1.5rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; padding: 1.5rem; background: rgba(79, 70, 229, 0.05); border-radius: 8px; border-left: 4px solid #4F46E5;">
                    <h4 style="margin: 0; color: #1F2937; font-weight: 600;">Total Pembayaran:</h4>
                    <h2 style="margin: 0; color: #4F46E5; font-weight: 700;">
                        Rp {{ number_format(collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']), 0, ',', '.') }}
                    </h2>
                </div>

                <div style="background: #F9FAFB; padding: 1.5rem; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #E5E7EB;">
                    <label style="font-weight: 600; color: #1F2937; margin-bottom: 1rem; display: block;">
                        <i class="fas fa-credit-card" style="margin-right: 0.5rem;"></i>Pilih Metode Pembayaran
                    </label>
                    <select id="caraBayar" class="form-control" style="border-radius: 8px; border: 1px solid #E5E7EB; padding: 0.75rem; font-weight: 500;">
                        <option value="cash">💵 Cash</option>
                        <option value="credit">💳 Credit Card</option>
                    </select>
                </div>

                <button id="simpanCart" class="btn btn-success" style="width: 100%; padding: 1rem; font-weight: 600; border-radius: 8px; font-size: 1rem;">
                    <i class="fas fa-check-circle" style="margin-right: 0.5rem;"></i>Selesaikan Transaksi
                </button>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('simpanCart')?.addEventListener('click', function () {
        const cart = @json($cart);
        const caraBayar = document.getElementById('caraBayar').value;

        fetch("{{ route('penjualan.store') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
            },
            body: JSON.stringify({
                cart: cart,
                cara_bayar: caraBayar,
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.message) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Transaksi berhasil disimpan',
                        confirmButtonColor: '#4F46E5'
                    }).then(() => {
                        window.location.href = "{{ route('penjualan.index') }}";
                    });
                }
            })
            .catch((error) => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat menyimpan transaksi',
                    confirmButtonColor: '#EF4444'
                });
                console.error("Error:", error);
            });
    });
</script>
@endsection
