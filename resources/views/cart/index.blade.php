@extends('layouts.adminlte')

@section('title')
Keranjang
@endsection

@section('page-bar')
<h1 class="m-0">Keranjang</h1>
@endsection

@section('contents')
<div class="container">
    <div class="card animate-fade-in-up" style="max-width: 1000px; margin: 0 auto;">
        <div class="card-header">
            <h3 class="mb-0">
                <i class="fas fa-shopping-cart mr-2"></i>
                Keranjang Belanja
            </h3>
        </div>
        <div class="card-body" style="padding: 2rem;">
            @if(empty($cart))
                <div class="empty-state" style="padding: 4rem 2rem; text-align: center;">
                    <i class="fas fa-shopping-cart" style="font-size: 6rem; color: #ddd; margin-bottom: 1.5rem;"></i>
                    <h4 style="color: #999; font-weight: 600; margin-bottom: 1rem;">Keranjang Belanja Kosong</h4>
                    <p style="color: #bbb; margin-bottom: 2rem;">Tambahkan produk untuk melanjutkan transaksi</p>
                    <a href="{{ route('penjualan.index') }}" class="btn btn-primary" style="padding: 0.8rem 2rem; border-radius: 12px;">
                        <i class="fas fa-shopping-bag mr-2"></i>Mulai Belanja
                    </a>
                </div>
            @else
                <div style="overflow-x: auto;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th><i class="fas fa-box mr-2"></i>Nama Produk</th>
                                <th><i class="fas fa-money-bill-wave mr-2"></i>Harga</th>
                                <th style="text-align: center;"><i class="fas fa-hashtag mr-2"></i>Jumlah</th>
                                <th><i class="fas fa-calculator mr-2"></i>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart as $item)
                                <tr class="animate-fade-in">
                                    <td style="font-weight: 600; color: #333;">{{ $item['name'] }}</td>
                                    <td style="color: #667eea; font-weight: 600;">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                                    <td style="text-align: center;">
                                        <span class="badge" style="background: #667eea; color: white; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.95rem;">
                                            {{ $item['quantity'] }} x
                                        </span>
                                    </td>
                                    <td style="font-weight: 700; color: #333; font-size: 1.1rem;">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div style="border-top: 2px solid #f0f0f0; margin-top: 1.5rem; padding-top: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; padding: 1.5rem; background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%); border-radius: 12px;">
                        <h4 style="margin: 0; color: #333; font-weight: 600;">Total Pembayaran:</h4>
                        <h2 style="margin: 0; color: #667eea; font-weight: 700;" id="totalPembayaran">
                            Rp {{ number_format(collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']), 0, ',', '.') }}
                        </h2>
                    </div>

                    <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 12px; margin-bottom: 1.5rem;">
                        <label style="font-weight: 600; color: #333; margin-bottom: 1rem; display: block;">
                            <i class="fas fa-credit-card mr-2"></i>Metode Pembayaran
                        </label>
                        <div style="padding: 0.8rem; background: white; border-radius: 10px; border: 2px solid #667eea;">
                            <strong style="color: #667eea; font-size: 1.1rem;">
                                @if(session('cara_bayar') === 'cash')
                                    💵 Cash
                                @else
                                    💳 Credit Card
                                @endif
                            </strong>
                        </div>
                    </div>

                    @if(session('cara_bayar') === 'cash')
                    <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 12px; margin-bottom: 1.5rem;">
                        <label style="font-weight: 600; color: #333; margin-bottom: 1rem; display: block;">
                            <i class="fas fa-money-bill-wave mr-2"></i>Uang yang Dibayar
                        </label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="background: #667eea; color: white; border: none;">Rp</span>
                            </div>
                            <input type="number"
                                   id="uangDibayar"
                                   class="form-control"
                                   placeholder="Masukkan jumlah uang"
                                   min="0"
                                   step="1000"
                                   style="font-size: 1.1rem; padding: 0.8rem; border: 2px solid #667eea;">
                        </div>

                        <div id="kembalianSection" style="display: none; padding: 1rem; background: white; border-radius: 10px; border: 2px solid #28a745; margin-top: 1rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span style="font-weight: 600; color: #333;">
                                    <i class="fas fa-hand-holding-usd mr-2"></i>Uang Kembalian:
                                </span>
                                <span id="uangKembalian" style="font-weight: 700; color: #28a745; font-size: 1.2rem;">
                                    Rp 0
                                </span>
                            </div>
                        </div>

                        <div id="warningInsufficientCash" style="display: none; padding: 1rem; background: #fff3cd; border-radius: 10px; border: 2px solid #ffc107; margin-top: 1rem;">
                            <i class="fas fa-exclamation-triangle mr-2" style="color: #856404;"></i>
                            <span style="color: #856404; font-weight: 600;">Uang yang dibayar kurang dari total pembayaran!</span>
                        </div>
                    </div>
                    @endif

                    <button id="simpanCart" class="btn btn-success btn-lg" style="width: 100%; padding: 1rem; font-weight: 600; border-radius: 12px; font-size: 1.1rem;" @if(session('cara_bayar') === 'cash') disabled @endif>
                        <i class="fas fa-check-circle mr-2"></i>Selesaikan Transaksi
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    const cart = @json($cart);
    const caraBayar = @json(session('cara_bayar', 'cash'));

    // Calculate total payment
    let totalPembayaran = 0;
    cart.forEach(item => {
        totalPembayaran += item.price * item.quantity;
    });

    // Add change calculation logic for cash payments
    if (caraBayar === 'cash') {
        const uangDibayarInput = document.getElementById('uangDibayar');
        const kembalianSection = document.getElementById('kembalianSection');
        const uangKembalianDisplay = document.getElementById('uangKembalian');
        const warningSection = document.getElementById('warningInsufficientCash');
        const simpanBtn = document.getElementById('simpanCart');

        uangDibayarInput.addEventListener('input', function() {
            const uangDibayar = parseFloat(this.value) || 0;

            if (uangDibayar > 0) {
                const kembalian = uangDibayar - totalPembayaran;

                if (kembalian >= 0) {
                    // Sufficient cash - show change, hide warning, enable button
                    kembalianSection.style.display = 'block';
                    warningSection.style.display = 'none';
                    uangKembalianDisplay.textContent = 'Rp ' + kembalian.toLocaleString('id-ID');
                    simpanBtn.disabled = false;
                } else {
                    // Insufficient cash - hide change, show warning, disable button
                    kembalianSection.style.display = 'none';
                    warningSection.style.display = 'block';
                    simpanBtn.disabled = true;
                }
            } else {
                // No input - hide everything, disable button
                kembalianSection.style.display = 'none';
                warningSection.style.display = 'none';
                simpanBtn.disabled = true;
            }
        });
    }

    document.getElementById('simpanCart').addEventListener('click', function () {
        // Disable button to prevent double submission
        const btn = this;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';

        fetch("{{ route('penjualan.store') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
            },
            body: JSON.stringify({
                cart: cart,
                cara_bayar: caraBayar,
                total_diskon: @json(session('total_diskon', 0)),
            }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                alert(data.message);
                // Hapus session cart
                fetch("{{ route('cart.clear') }}", { method: "POST", headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" } })
                .then(() => {
                    window.location.href = "{{ route('penjualan.index') }}"; // Kembali ke POS
                });
            } else if (data.error) {
                alert('Error: ' + data.error);
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-check-circle mr-2"></i>Selesaikan Transaksi';
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert('Terjadi kesalahan saat menyimpan transaksi!');
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-check-circle mr-2"></i>Selesaikan Transaksi';
        });
    });
</script>
@endsection
