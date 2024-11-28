@extends('layouts.adminlte')

@section('contents')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <!-- Search Bar -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <input type="text" id="search-bar" class="form-control" placeholder="Cari Barang di sini">
                    </div>
                </div>

                <!-- Category Tabs -->
                <div id="product-container">
                    <ul class="nav nav-tabs" id="categoryTabs" role="tablist">
                        @foreach($kategoris as $kategori)
                        <li class="nav-item" role="presentation">
                            <a class="nav-link @if($loop->first) active @endif" id="tab-{{ $kategori->idkategori }}" data-toggle="tab" href="#category-{{ $kategori->idkategori }}" role="tab" aria-controls="category-{{ $kategori->idkategori }}" aria-selected="@if($loop->first) true @else false @endif">
                                {{ $kategori->nama }}
                            </a>
                        </li>
                        @endforeach
                    </ul>

                    <!-- Tab Content -->
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
        </div>
    </div>
</div>

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
    <div class="text-right">
        <label>
            <input type="radio" name="cara_bayar" value="cash" checked> Cash
        </label>
        <label>
            <input type="radio" name="cara_bayar" value="credit"> Credit
        </label>
        <button id="checkout-button" class="btn btn-success">Selesai</button>
    </div>
</div>
@endsection

@section('javascript')
<script>
    $(document).ready(function () {
        // Initialize tabs
        $('#categoryTabs a:first').tab('show');

        // Load product data for each category
        @foreach($kategoris as $kategori)
        loadProductData('{{ csrf_token() }}', '#div_tabel_{{ $kategori->idkategori }}', '{{ route('penjualan.data') }}', '{{ $kategori->idkategori }}');
        @endforeach
    });

    function loadProductData(token, target, act, kategoriId) {
        $(target).html(`<div class="d-flex justify-content-center align-items-center" style="height: 200px;"><div class="spinner-border text-primary" role="status"></div></div>`);
        $.post(act, {
                _token: token,
                kategori_id: kategoriId
            })
            .done(function (data) {
                $(target).html(data);
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                let errormess = "";
                try {
                    errormess = jqXHR['responseJSON']['message'];
                } catch (error) {}
                $(target).html("Error loading data: " + textStatus + " - " + errorThrown + " " + errormess);
            });
    }

    const cart = [];
    function updateCart() {
        const cartBody = document.getElementById("cart-body");
        const cartTotal = document.getElementById("cart-total");
        cartBody.innerHTML = ""; 
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

        cartTotal.textContent = total.toLocaleString();
    }

    document.body.addEventListener("click", function (event) {
        if (event.target.closest(".product-card")) {
            const productCard = event.target.closest(".product-card");
            const id = productCard.dataset.id;
            const name = productCard.dataset.name;
            const price = parseInt(productCard.dataset.price);

            const existingItem = cart.find(item => item.id === id);
            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                cart.push({ id, name, price, quantity: 1 });
            }
            updateCart();
        }

        if (event.target.classList.contains("remove-item")) {
            const index = event.target.dataset.index;
            cart.splice(index, 1);
            updateCart();
        }
    });

    document.body.addEventListener("input", function (event) {
        if (event.target.classList.contains("cart-quantity")) {
            const index = event.target.dataset.index;
            const quantity = parseInt(event.target.value);
            if (quantity > 0) {
                cart[index].quantity = quantity;
                updateCart();
            }
        }
    });

    document.getElementById("checkout-button").addEventListener("click", function () {
        const cartData = cart.map(item => ({
            id: item.id,
            quantity: item.quantity,
            price: item.price
        }));

        const caraBayar = document.querySelector('input[name="cara_bayar"]:checked').value;

        fetch("/penjualan/store", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
            },
            body: JSON.stringify({ cart: cartData, cara_bayar: caraBayar }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                alert(data.message);
                cart.length = 0;
                updateCart();
            }
        })
        .catch(error => console.error("Error:", error));
    });
</script>
@endsection
