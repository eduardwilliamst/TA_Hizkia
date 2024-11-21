@extends('layouts.adminlte')

@section('contents')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <!-- Nav tabs for categories -->
                <ul class="nav nav-tabs" id="categoryTabs" role="tablist">
                    @foreach($kategoris as $kategori)
                    <li class="nav-item" role="presentation">
                        <a class="nav-link @if($loop->first) active @endif" id="tab-{{ $kategori->idkategori }}" data-toggle="tab" href="#category-{{ $kategori->idkategori }}" role="tab" aria-controls="category-{{ $kategori->idkategori }}" aria-selected="@if($loop->first) true @else false @endif">
                            {{ $kategori->nama }}
                        </a>
                    </li>
                    @endforeach
                </ul>

                <!-- Tab content -->
                <div class="tab-content" id="categoryTabContent">
                    @foreach($kategoris as $kategori)
                    <div class="tab-pane fade @if($loop->first) show active @endif" id="category-{{ $kategori->idkategori }}" role="tabpanel" aria-labelledby="tab-{{ $kategori->idkategori }}">
                        <div class="table-responsive" id="div_tabel_{{ $kategori->idkategori }}">
                            <!-- Product data will be loaded here -->
                            <div class="d-flex justify-content-center align-items-center" style="height: 200px;">
                                <div class="spinner-border text-primary" role="status"></div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->

<!-- Keranjang Belanja -->
<div id="cart" class="my-4">
    <h4>Keranjang Belanja</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="cart-body">
            <!-- Item keranjang akan ditambahkan di sini -->
        </tbody>
    </table>
    <div class="text-right">
        <h5>Total: Rp <span id="cart-total">0</span></h5>
    </div>
</div>

@endsection

@section('javascript')
<script>
    $(document).ready(function() {
        // Initialize tabs if necessary
        $('#categoryTabs a:first').tab('show'); // Activate the first tab

        // Load product data for each category
        @foreach($kategoris as $kategori)
        loadProductData('{{ csrf_token() }}', '#div_tabel_{{ $kategori->idkategori }}', '{{ route('penjualan.data') }}', '{{ $kategori->idkategori }}');
        @endforeach
    });

    function loadProductData(token, target, act, kategoriId) {
        $(target).html(`<div class="d-flex justify-content-center align-items-center" style="height: 200px;"><div class="spinner-border text-primary" role="status"></div></div>`);
        $.post(act, {
                _token: token,
                kategori_id: kategoriId // Send category ID to filter products
            })
            .done(function(data) {
                $(target).html(data);
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                var errormess = "";
                try {
                    errormess = jqXHR['responseJSON']['message'];
                } catch (error) {}
                $(target).html("Error loading data: " + textStatus + " - " + errorThrown + " " + errormess);
            });
    }

    document.addEventListener("DOMContentLoaded", function() {
        const cart = []; // Array untuk menyimpan data keranjang

        function updateCart() {
            const cartBody = document.getElementById("cart-body");
            const cartTotal = document.getElementById("cart-total");
            cartBody.innerHTML = ""; // Kosongkan isi keranjang
            let total = 0;

            cart.forEach((item, index) => {
                const subtotal = item.price * item.quantity;
                total += subtotal;

                const row = `
                <tr>
                    <td>${item.name}</td>
                    <td>Rp ${item.price.toLocaleString()}</td>
                    <td>
                        <input type="number" min="1" value="${item.quantity}" data-index="${index}" class="cart-quantity">
                    </td>
                    <td>Rp ${subtotal.toLocaleString()}</td>
                    <td>
                        <button class="btn btn-danger btn-sm remove-item" data-index="${index}">Hapus</button>
                    </td>
                </tr>
            `;
                cartBody.innerHTML += row;
            });

            cartTotal.textContent = total.toLocaleString(); // Update total harga
        }

        // Event delegation untuk menangani klik produk
        document.body.addEventListener("click", function(event) {
            if (event.target.closest(".product-card")) {
                const productCard = event.target.closest(".product-card"); // Ambil card yang diklik
                const id = productCard.dataset.id;
                const name = productCard.dataset.name;
                const price = parseInt(productCard.dataset.price);
                const stock = parseInt(productCard.dataset.stock);

                // Log data produk yang diklik
                console.log("Produk yang diklik:", { id, name, price, stock });

                // Cek apakah item sudah ada di keranjang
                const existingItem = cart.find(item => item.id === id);
                if (existingItem) {
                    existingItem.quantity += 1; // Tambah jumlah jika sudah ada
                } else {
                    cart.push({
                        id,
                        name,
                        price,
                        quantity: 1
                    }); // Tambahkan item baru
                }

                updateCart(); // Perbarui tampilan keranjang
            }
        });

        // Event delegation untuk menghapus item
        document.body.addEventListener("click", function(event) {
            if (event.target.classList.contains("remove-item")) {
                const index = event.target.dataset.index;
                cart.splice(index, 1); // Hapus item dari array
                updateCart();
            }
        });

        // Event delegation untuk mengubah jumlah item
        document.body.addEventListener("input", function(event) {
            if (event.target.classList.contains("cart-quantity")) {
                const index = event.target.dataset.index;
                const quantity = parseInt(event.target.value);
                if (quantity > 0) {
                    cart[index].quantity = quantity;
                    updateCart();
                }
            }
        });
    });
</script>
@endsection
