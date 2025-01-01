@extends('layouts.adminlte')

@section('title')
Keranjang
@endsection

@section('page-bar')
<h1 class="m-0">Keranjang</h1>
@endsection

@section('contents')
<div class="container">
    <h1>Keranjang Belanja</h1>

    @if(empty($cart))
        <p>Keranjang belanja kosong.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart as $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <h3>Total: Rp {{ number_format(collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']), 0, ',', '.') }}</h3>
        <!-- Dropdown Cara Bayar -->
        <div class="form-group">
            <label for="caraBayar">Cara Bayar:</label>
            <select id="caraBayar" class="form-control">
                <option value="cash">Cash</option>
                <option value="credit">Credit</option>
            </select>
        </div>

        <!-- Tombol Simpan -->
        <button id="simpanCart" class="btn btn-primary">Simpan</button>
    @endif
</div>

<script>
    document.getElementById('simpanCart').addEventListener('click', function () {
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
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                alert(data.message);
                // Hapus session cart
                fetch("{{ route('cart.clear') }}", { method: "POST", headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" } })
                .then(() => {
                    window.location.reload(); // Reload halaman
                });
            }
        })
        .catch(error => console.error("Error:", error));
    });
</script>
@endsection
