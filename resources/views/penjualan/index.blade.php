@extends('layouts.adminlte')

@section('title')
Penjualan
@endsection

@section('page-bar')
<h1 class="m-0">Data Penjualan</h1>
@endsection

@section('contents')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card animate-fade-in-up">
                    <div class="card-header">
                        <h3 class="mb-0">
                            <i class="fas fa-shopping-bag mr-2"></i>
                            Point of Sale
                        </h3>
                    </div>
                    <div class="card-body">
                        <!-- Search Bar -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div style="position: relative;">
                                    <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #999;"></i>
                                    <input type="text" id="search-bar" class="form-control" placeholder="Cari produk berdasarkan nama atau barcode..." style="padding-left: 45px; border-radius: 25px; border: 2px solid #e0e0e0; height: 50px;">
                                </div>
                            </div>
                            <div class="col-md-6 text-right">
                                <button class="btn btn-info" onclick="window.location.reload()" style="border-radius: 25px; padding: 0.7rem 1.5rem;">
                                    <i class="fas fa-sync-alt mr-2"></i>Refresh
                                </button>
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
        <div id="cart" class="my-4 animate-fade-in" style="background: white; border-radius: 15px; padding: 2rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h4 style="margin: 0; color: #333; font-weight: 600;">
                    <i class="fas fa-shopping-cart mr-2" style="color: #667eea;"></i>
                    Keranjang Belanja
                </h4>
                <span class="badge" style="background: #667eea; color: white; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.9rem;">
                    <span id="cart-count">0</span> Item
                </span>
            </div>

            <div style="overflow-x: auto;">
                <table class="table" style="margin-bottom: 1.5rem;">
                    <thead>
                        <tr>
                            <th style="border-top: none;">Nama</th>
                            <th style="border-top: none;">Harga</th>
                            <th style="border-top: none; text-align: center;">Jumlah</th>
                            <th style="border-top: none;">Subtotal</th>
                            <th style="border-top: none; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="cart-body">
                        <!-- Item keranjang akan ditambahkan di sini -->
                        <tr id="empty-cart-message">
                            <td colspan="5" style="text-align: center; padding: 3rem; color: #999;">
                                <i class="fas fa-shopping-cart" style="font-size: 3rem; color: #ddd; margin-bottom: 1rem; display: block;"></i>
                                Keranjang masih kosong
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div style="border-top: 2px solid #f0f0f0; padding-top: 1.5rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <h5 style="margin: 0; color: #666;">Total Pembayaran:</h5>
                    <h3 style="margin: 0; color: #667eea; font-weight: 700;">
                        Rp <span id="cart-total">0</span>
                    </h3>
                </div>

                <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 12px; margin-bottom: 1.5rem;">
                    <label style="font-weight: 600; color: #333; margin-bottom: 1rem; display: block;">
                        <i class="fas fa-credit-card mr-2"></i>Metode Pembayaran
                    </label>
                    <div style="display: flex; gap: 1rem;">
                        <label class="payment-option" style="flex: 1; cursor: pointer;">
                            <input type="radio" name="cara_bayar" value="cash" checked style="display: none;">
                            <div class="payment-card" style="background: white; border: 2px solid #667eea; border-radius: 12px; padding: 1rem; text-align: center; transition: all 0.3s ease;">
                                <i class="fas fa-money-bill-wave" style="font-size: 2rem; color: #667eea; margin-bottom: 0.5rem;"></i>
                                <div style="font-weight: 600; color: #667eea;">Cash</div>
                            </div>
                        </label>
                        <label class="payment-option" style="flex: 1; cursor: pointer;">
                            <input type="radio" name="cara_bayar" value="credit" style="display: none;">
                            <div class="payment-card" style="background: white; border: 2px solid #e0e0e0; border-radius: 12px; padding: 1rem; text-align: center; transition: all 0.3s ease;">
                                <i class="fas fa-credit-card" style="font-size: 2rem; color: #999; margin-bottom: 0.5rem;"></i>
                                <div style="font-weight: 600; color: #999;">Credit</div>
                            </div>
                        </label>
                    </div>
                </div>

                <button type="submit" id="checkout-button" class="btn btn-success btn-lg" style="width: 100%; padding: 1rem; font-weight: 600; border-radius: 12px; font-size: 1.1rem;">
                    <i class="fas fa-check-circle mr-2"></i>Selesaikan Transaksi
                </button>
            </div>
        </div>

        <style>
            .payment-option input[type="radio"]:checked + .payment-card {
                border-color: #667eea !important;
                background: rgba(102, 126, 234, 0.05) !important;
            }

            .payment-option input[type="radio"]:checked + .payment-card i,
            .payment-option input[type="radio"]:checked + .payment-card div {
                color: #667eea !important;
            }

            .payment-card:hover {
                transform: translateY(-3px);
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            }
        </style>
    </div>
</div>
@endsection

@section('javascript')
<script>
    $(document).ready(function() {
        // Initialize tabs
        $('#categoryTabs a:first').tab('show');

        // Load product data for each category
        @foreach($kategoris as $kategori)
        loadProductData('{{ csrf_token() }}', '#div_tabel_{{ $kategori->idkategori }}', '{{ route("penjualan.data") }}', '{{ $kategori->idkategori }}');
        @endforeach
    });

    function loadProductData(token, target, act, kategoriId) {
        $(target).html(`<div class="d-flex justify-content-center align-items-center" style="height: 200px;"><div class="spinner-border text-primary" role="status"></div></div>`);
        $.post(act, {
                _token: token,
                kategori_id: kategoriId
            })
            .done(function(data) {
                $(target).html(data);
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
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
        const cartCount = document.getElementById("cart-count");
        const emptyMessage = document.getElementById("empty-cart-message");

        cartBody.innerHTML = "";
        let total = 0;
        let totalItems = 0;

        if (cart.length === 0) {
            cartBody.innerHTML = `
                <tr id="empty-cart-message">
                    <td colspan="5" style="text-align: center; padding: 3rem; color: #999;">
                        <i class="fas fa-shopping-cart" style="font-size: 3rem; color: #ddd; margin-bottom: 1rem; display: block;"></i>
                        Keranjang masih kosong
                    </td>
                </tr>
            `;
        } else {
            cart.forEach((item, index) => {
                const subtotal = item.price * item.quantity;
                total += subtotal;
                totalItems += item.quantity;

                const row = `
                    <tr class="animate-fade-in">
                        <td style="font-weight: 600; color: #333;">${item.name}</td>
                        <td style="color: #667eea; font-weight: 600;">Rp ${item.price.toLocaleString()}</td>
                        <td style="text-align: center;">
                            <div style="display: flex; justify-content: center; align-items: center; gap: 0.5rem;">
                                <button class="btn btn-sm btn-outline-secondary decrease-qty" data-index="${index}" style="border-radius: 50%; width: 30px; height: 30px; padding: 0;">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" min="1" value="${item.quantity}" data-index="${index}" class="cart-quantity" style="width: 60px; text-align: center; border: 2px solid #e0e0e0; border-radius: 8px; padding: 0.3rem;">
                                <button class="btn btn-sm btn-outline-secondary increase-qty" data-index="${index}" style="border-radius: 50%; width: 30px; height: 30px; padding: 0;">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </td>
                        <td style="font-weight: 600; color: #333;">Rp ${subtotal.toLocaleString()}</td>
                        <td style="text-align: center;">
                            <button class="btn btn-danger btn-sm remove-item" data-index="${index}" style="border-radius: 8px;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                cartBody.innerHTML += row;
            });
        }

        cartTotal.textContent = total.toLocaleString();
        cartCount.textContent = totalItems;
    }

    document.body.addEventListener("click", function(event) {
        if (event.target.closest(".product-card")) {
            const productCard = event.target.closest(".product-card");
            const id = productCard.dataset.id;
            const name = productCard.dataset.name;
            const price = parseInt(productCard.dataset.price);

            // Add animation feedback
            productCard.classList.add('adding-to-cart');
            setTimeout(() => productCard.classList.remove('adding-to-cart'), 500);

            const existingItem = cart.find(item => item.id === id);
            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                cart.push({
                    id,
                    name,
                    price,
                    quantity: 1
                });
            }
            updateCart();

            // Show success notification
            showToast('Produk ditambahkan ke keranjang!', 'success');
        }

        if (event.target.closest(".remove-item")) {
            const button = event.target.closest(".remove-item");
            const index = button.dataset.index;
            cart.splice(index, 1);
            updateCart();
            showToast('Produk dihapus dari keranjang', 'info');
        }

        if (event.target.closest(".increase-qty")) {
            const button = event.target.closest(".increase-qty");
            const index = button.dataset.index;
            cart[index].quantity += 1;
            updateCart();
        }

        if (event.target.closest(".decrease-qty")) {
            const button = event.target.closest(".decrease-qty");
            const index = button.dataset.index;
            if (cart[index].quantity > 1) {
                cart[index].quantity -= 1;
                updateCart();
            }
        }
    });

    // Toast notification function
    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${type === 'success' ? 'linear-gradient(135deg, #11998e 0%, #38ef7d 100%)' : 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)'};
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            z-index: 9999;
            animation: slideInRight 0.3s ease-out;
            font-weight: 500;
        `;
        toast.innerHTML = `<i class="fas fa-check-circle mr-2"></i>${message}`;
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.style.animation = 'fadeOut 0.3s ease-out';
            setTimeout(() => toast.remove(), 300);
        }, 2000);
    }

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

    document.getElementById("checkout-button").addEventListener("click", function() {
    const cartData = cart.map(item => ({
        id: item.id,
        quantity: item.quantity,
        price: item.price,
    }));

    const caraBayar = document.querySelector('input[name="cara_bayar"]:checked').value;

    // fetch("{{ route('penjualan.store') }}", {
    //     method: "POST",
    //     headers: {
    //         "Content-Type": "application/json",
    //         "X-CSRF-TOKEN": "{{ csrf_token() }}",
    //     },
    //     body: JSON.stringify({
    //         cart: cartData,
    //         cara_bayar: caraBayar,
    //     }),
    // })
    // .then(response => response.json())
    // .then(data => {
    //     if (data.message) {
    //         alert(data.message);
    //         cart.length = 0;
    //         updateCart();
    //     }
    // })
    // .catch(error => console.error("Error:", error));

    fetch("{{ route('cart.save') }}", { // Ganti route ke endpoint penyimpanan session
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
        },
        body: JSON.stringify({
            cart: cartData, // Data keranjang dikirim ke session
        }),
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