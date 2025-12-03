@extends('layouts.pos')

@section('title', 'Penjualan')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">Point of Sale</h1>
    <div class="page-breadcrumb">
        <div class="breadcrumb-item">
            <a href="{{ route('dashboard') }}" class="breadcrumb-link">
                <i class="fas fa-home"></i>
                Dashboard
            </a>
        </div>
        <div class="breadcrumb-item">
            <span>Penjualan</span>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 400px; gap: 1.5rem;">
    <!-- Products Section (Left Side) -->
    <div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-shopping-bag" style="margin-right: 0.5rem;"></i>
                    Produk
                </h3>
            </div>
            <div class="card-body">
                <!-- Search Bar -->
                <div style="display: grid; grid-template-columns: 1fr auto; gap: 1rem; margin-bottom: 1.5rem;">
                    <div style="position: relative;">
                        <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
                        <input type="text" id="search-bar" class="form-control" placeholder="Cari produk berdasarkan nama atau barcode..." style="padding-left: 45px; border-radius: 8px; border: 1px solid #E5E7EB; height: 45px;">
                    </div>
                    <button class="btn btn-secondary" onclick="window.location.reload()">
                        <i class="fas fa-sync-alt"></i>
                    </button>
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
    </div>

    <!-- Keranjang Belanja (Right Side - Sticky) -->
    <div>
        <div id="cart" class="card sticky-cart" style="position: sticky; top: 80px;">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-shopping-cart" style="margin-right: 0.5rem;"></i>
                    Keranjang Belanja
                </h3>
                <span class="badge" style="background: #4F46E5; color: white; padding: 0.375rem 0.75rem; border-radius: 12px; font-size: 0.875rem;">
                    <span id="cart-count">0</span> Item
                </span>
            </div>
            <div class="card-body">

            <!-- Cart Items List -->
            <div style="max-height: 400px; overflow-y: auto; margin-bottom: 1.5rem;" id="cart-items-container">
                <div id="cart-body">
                    <!-- Item keranjang akan ditambahkan di sini -->
                    <div id="empty-cart-message" style="text-align: center; padding: 3rem; color: #999;">
                        <i class="fas fa-shopping-cart" style="font-size: 3rem; color: #ddd; margin-bottom: 1rem; display: block;"></i>
                        Keranjang masih kosong
                    </div>
                </div>
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

                <button type="submit" id="checkout-button" class="btn btn-success" style="width: 100%; padding: 1rem; font-weight: 600; border-radius: 8px; font-size: 1rem;">
                    <i class="fas fa-check-circle" style="margin-right: 0.5rem;"></i>Selesaikan Transaksi
                </button>
            </div>
            </div>
        </div>
    </div>
</div>

<!-- Responsive -->
<style>
    @media (max-width: 991px) {
        .page-header + div {
            grid-template-columns: 1fr !important;
        }
        .sticky-cart {
            position: relative !important;
            top: 0 !important;
        }
    }
</style>
@endsection

@section('styles')
<style>
    .payment-option input[type="radio"]:checked + .payment-card {
        border-color: #4F46E5 !important;
        background: rgba(79, 70, 229, 0.05) !important;
    }

    .payment-option input[type="radio"]:checked + .payment-card i,
    .payment-option input[type="radio"]:checked + .payment-card div {
        color: #4F46E5 !important;
    }

            .payment-card:hover {
                transform: translateY(-3px);
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            }

            /* Checkout Modal Animations */
            @keyframes slideInRight {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }

            @keyframes fadeOut {
                from {
                    opacity: 1;
                }
                to {
                    opacity: 0;
                }
            }

            @keyframes slideUp {
                from {
                    transform: translateY(20px);
                    opacity: 0;
                }
                to {
                    transform: translateY(0);
                    opacity: 1;
                }
            }

            @keyframes pulse {
                0%, 100% {
                    transform: scale(1);
                }
                50% {
                    transform: scale(1.05);
                }
            }

            @keyframes shake {
                0%, 100% { transform: translateX(0); }
                10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
                20%, 40%, 60%, 80% { transform: translateX(5px); }
            }

            /* Modal Content Animation */
            .modal.fade .modal-dialog {
                transition: transform 0.3s ease-out;
            }

            .modal.show .modal-dialog {
                transform: scale(1);
            }

            /* Cart Item Slide In */
            .cart-item-animate {
                animation: slideUp 0.3s ease-out;
            }

            /* Change Display Pulse */
            .change-pulse {
                animation: pulse 0.5s ease-in-out;
            }

            /* Warning Shake */
            .warning-shake {
                animation: shake 0.5s ease-in-out;
            }

            /* Input Focus Effect */
            #cash-tendered-input:focus {
                border-color: #667eea !important;
                box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25) !important;
                transform: scale(1.02);
                transition: all 0.3s ease;
            }

            /* Button Hover Effects */
            #confirm-checkout-btn:not(:disabled):hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(40, 167, 69, 0.4);
                transition: all 0.3s ease;
            }

            #confirm-checkout-btn:disabled {
                opacity: 0.6;
                cursor: not-allowed;
            }

            /* Scrollbar Styling for Cart Items */
            #modal-cart-items::-webkit-scrollbar {
                width: 8px;
            }

            #modal-cart-items::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 10px;
            }

            #modal-cart-items::-webkit-scrollbar-thumb {
                background: #667eea;
                border-radius: 10px;
            }

            #modal-cart-items::-webkit-scrollbar-thumb:hover {
                background: #5568d3;
            }

            /* Loading Spinner Animation */
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }

            /* Quick Cash Button Styles */
            .quick-cash-btn {
                background: white;
                border: 2px solid #e0e0e0;
                border-radius: 10px;
                padding: 0.6rem;
                font-weight: 600;
                font-size: 0.9rem;
                color: #667eea;
                cursor: pointer;
                transition: all 0.2s ease;
                text-align: center;
            }

            .quick-cash-btn:hover {
                background: #667eea;
                color: white;
                border-color: #667eea;
                transform: translateY(-2px);
                box-shadow: 0 4px 10px rgba(102, 126, 234, 0.3);
            }

            .quick-cash-btn:active {
                transform: translateY(0);
            }

            /* Cart Items Scrollbar */
            #cart-items-container::-webkit-scrollbar {
                width: 6px;
            }

            #cart-items-container::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 10px;
            }

            #cart-items-container::-webkit-scrollbar-thumb {
                background: #667eea;
                border-radius: 10px;
            }

            #cart-items-container::-webkit-scrollbar-thumb:hover {
                background: #5568d3;
            }

            /* Cart Item Card Styles */
            .cart-item-card {
                background: #f8f9fa;
                border-radius: 12px;
                padding: 1rem;
                margin-bottom: 0.8rem;
                transition: all 0.2s ease;
                border: 2px solid transparent;
            }

    .cart-item-card {
        background: #F9FAFB;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 0.8rem;
        transition: all 0.2s ease;
        border: 1px solid #E5E7EB;
    }

    .cart-item-card:hover {
        border-color: #4F46E5;
        box-shadow: 0 2px 8px rgba(79, 70, 229, 0.15);
    }
</style>
@endsection

<!-- Checkout Confirmation Modal -->
<div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 20px; border: none; overflow: hidden;">
            <!-- Modal Header -->
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 1.5rem;">
                <h5 class="modal-title" id="checkoutModalLabel" style="font-weight: 600; font-size: 1.3rem;">
                    <i class="fas fa-check-circle mr-2"></i>Konfirmasi Pembayaran
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; opacity: 0.9;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body" style="padding: 2rem;">
                <!-- Cart Summary Section -->
                <div style="background: #f8f9fa; border-radius: 12px; padding: 1.5rem; margin-bottom: 1.5rem;">
                    <h6 style="font-weight: 600; color: #333; margin-bottom: 1rem;">
                        <i class="fas fa-shopping-cart mr-2"></i>Ringkasan Belanja
                    </h6>
                    <div id="modal-cart-items" style="max-height: 250px; overflow-y: auto;">
                        <!-- Cart items will be populated here -->
                    </div>
                </div>

                <!-- Total Amount Display -->
                <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px; padding: 1.5rem; margin-bottom: 1.5rem; text-align: center; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);">
                    <div style="color: rgba(255, 255, 255, 0.9); font-size: 0.9rem; margin-bottom: 0.5rem; font-weight: 500;">Total Pembayaran</div>
                    <div style="color: white; font-size: 2.5rem; font-weight: 700;">
                        Rp <span id="modal-total-amount">0</span>
                    </div>
                    <div style="color: rgba(255, 255, 255, 0.8); font-size: 0.9rem; margin-top: 0.5rem;">
                        <span id="modal-total-items">0</span> Item
                    </div>
                </div>

                <!-- Payment Method Display -->
                <div style="background: #f8f9fa; border-radius: 12px; padding: 1rem; margin-bottom: 1.5rem; display: flex; align-items: center;">
                    <i class="fas fa-credit-card" style="font-size: 1.5rem; color: #667eea; margin-right: 1rem;"></i>
                    <div>
                        <div style="font-size: 0.85rem; color: #666;">Metode Pembayaran</div>
                        <div id="modal-payment-method" style="font-weight: 600; color: #333; font-size: 1.1rem;">Cash</div>
                    </div>
                </div>

                <!-- Cash Payment Section -->
                <div id="cash-payment-section" style="display: none;">
                    <div style="margin-bottom: 1rem;">
                        <label style="font-weight: 600; color: #333; margin-bottom: 0.5rem; display: block;">
                            <i class="fas fa-money-bill-wave mr-2" style="color: #28a745;"></i>Jumlah Uang Diterima
                        </label>
                        <div style="position: relative;">
                            <span style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #666; font-weight: 600;">Rp</span>
                            <input type="text" id="cash-tendered-input" class="form-control" placeholder="0" style="padding-left: 45px; font-size: 1.2rem; font-weight: 600; border: 2px solid #e0e0e0; border-radius: 12px; height: 55px;">
                        </div>
                    </div>

                    <!-- Quick Cash Buttons -->
                    <div style="margin-bottom: 1.5rem;">
                        <div style="font-size: 0.85rem; color: #666; margin-bottom: 0.5rem;">
                            <i class="fas fa-bolt mr-1"></i>Nominal Cepat
                        </div>
                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.5rem;" id="quick-cash-buttons">
                            <!-- Quick cash buttons will be inserted here -->
                        </div>
                    </div>

                    <!-- Change Display -->
                    <div id="change-display" style="display: none;">
                        <div class="alert" style="border-radius: 12px; border: none; padding: 1.2rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span style="font-weight: 600;">
                                    <i class="fas fa-coins mr-2"></i>Kembalian
                                </span>
                                <span style="font-size: 1.3rem; font-weight: 700;" id="change-amount">Rp 0</span>
                            </div>
                        </div>
                    </div>

                    <!-- Insufficient Payment Warning -->
                    <div id="insufficient-warning" class="alert alert-warning" style="display: none; border-radius: 12px; border: none;">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Jumlah uang yang diterima kurang dari total pembayaran
                    </div>
                </div>

                <!-- Credit Payment Section -->
                <div id="credit-payment-section" style="display: none;">
                    <div class="alert alert-info" style="border-radius: 12px; border: none;">
                        <i class="fas fa-info-circle mr-2"></i>
                        Pastikan pembayaran kartu kredit telah berhasil
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer" style="border-top: 2px solid #f0f0f0; padding: 1.5rem;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" style="padding: 0.7rem 1.5rem; border-radius: 10px; font-weight: 600;">
                    <i class="fas fa-times mr-2"></i>Batal
                </button>
                <button type="button" id="confirm-checkout-btn" class="btn btn-success" style="padding: 0.7rem 2rem; border-radius: 10px; font-weight: 600;">
                    <i class="fas fa-print mr-2"></i>Simpan & Cetak Struk
                </button>
            </div>
        </div>
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

        cartBody.innerHTML = "";
        let total = 0;
        let totalItems = 0;

        if (cart.length === 0) {
            cartBody.innerHTML = `
                <div id="empty-cart-message" style="text-align: center; padding: 3rem; color: #999;">
                    <i class="fas fa-shopping-cart" style="font-size: 3rem; color: #ddd; margin-bottom: 1rem; display: block;"></i>
                    Keranjang masih kosong
                </div>
            `;
        } else {
            cart.forEach((item, index) => {
                const subtotal = item.price * item.quantity;
                total += subtotal;
                totalItems += item.quantity;

                const card = `
                    <div class="cart-item-card animate-fade-in">
                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.8rem;">
                            <div style="flex: 1;">
                                <div style="font-weight: 600; color: #333; font-size: 0.95rem; margin-bottom: 0.3rem;">${item.name}</div>
                                <div style="color: #667eea; font-weight: 600; font-size: 0.9rem;">Rp ${item.price.toLocaleString('id-ID')}</div>
                            </div>
                            <button class="btn btn-danger btn-sm remove-item" data-index="${index}" style="border-radius: 8px; padding: 0.3rem 0.6rem;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <button class="btn btn-sm btn-outline-secondary decrease-qty" data-index="${index}" style="border-radius: 50%; width: 32px; height: 32px; padding: 0; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-minus" style="font-size: 0.7rem;"></i>
                                </button>
                                <input type="number" min="1" value="${item.quantity}" data-index="${index}" class="cart-quantity" style="width: 50px; text-align: center; border: 2px solid #e0e0e0; border-radius: 8px; padding: 0.4rem; font-weight: 600;">
                                <button class="btn btn-sm btn-outline-secondary increase-qty" data-index="${index}" style="border-radius: 50%; width: 32px; height: 32px; padding: 0; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-plus" style="font-size: 0.7rem;"></i>
                                </button>
                            </div>
                            <div style="font-weight: 700; color: #333; font-size: 1rem;">
                                Rp ${subtotal.toLocaleString('id-ID')}
                            </div>
                        </div>
                    </div>
                `;
                cartBody.innerHTML += card;
            });
        }

        cartTotal.textContent = total.toLocaleString('id-ID');
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
        let bgGradient = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)'; // default info
        let icon = 'fa-info-circle';

        if (type === 'success') {
            bgGradient = 'linear-gradient(135deg, #11998e 0%, #38ef7d 100%)';
            icon = 'fa-check-circle';
        } else if (type === 'warning') {
            bgGradient = 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)';
            icon = 'fa-exclamation-triangle';
        } else if (type === 'error') {
            bgGradient = 'linear-gradient(135deg, #eb3349 0%, #f45c43 100%)';
            icon = 'fa-times-circle';
        }

        toast.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${bgGradient};
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            z-index: 9999;
            animation: slideInRight 0.3s ease-out;
            font-weight: 500;
        `;
        toast.innerHTML = `<i class="fas ${icon} mr-2"></i>${message}`;
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

    // Checkout Button - Open Modal
    document.getElementById("checkout-button").addEventListener("click", function() {
        // Prevent execution if cart is empty
        if (cart.length === 0) {
            showToast('Keranjang belanja masih kosong!', 'warning');
            return;
        }

        // Calculate total amount and item count
        let totalAmount = 0;
        let totalItems = 0;
        cart.forEach(item => {
            totalAmount += item.price * item.quantity;
            totalItems += item.quantity;
        });

        // Get selected payment method
        const caraBayar = document.querySelector('input[name="cara_bayar"]:checked').value;
        const paymentMethodText = caraBayar === 'cash' ? 'Cash' : 'Credit Card';

        // Populate modal cart items with animation
        const modalCartItems = document.getElementById('modal-cart-items');
        modalCartItems.innerHTML = '';
        cart.forEach((item, index) => {
            const subtotal = item.price * item.quantity;
            const itemDiv = document.createElement('div');
            itemDiv.className = 'cart-item-animate';
            itemDiv.style.cssText = 'display: flex; justify-content: space-between; padding: 0.8rem 0; border-bottom: 1px solid #e0e0e0; animation-delay: ' + (index * 0.05) + 's;';
            itemDiv.innerHTML = `
                <div style="flex: 1;">
                    <div style="font-weight: 600; color: #333;">${item.name}</div>
                    <div style="color: #666; font-size: 0.9rem;">${item.quantity} x Rp ${item.price.toLocaleString('id-ID')}</div>
                </div>
                <div style="font-weight: 600; color: #667eea;">Rp ${subtotal.toLocaleString('id-ID')}</div>
            `;
            modalCartItems.appendChild(itemDiv);
        });

        // Update modal total and items
        document.getElementById('modal-total-amount').textContent = totalAmount.toLocaleString();
        document.getElementById('modal-total-items').textContent = totalItems;
        document.getElementById('modal-payment-method').textContent = paymentMethodText;

        // Show/hide payment sections based on payment method
        const cashSection = document.getElementById('cash-payment-section');
        const creditSection = document.getElementById('credit-payment-section');
        const confirmBtn = document.getElementById('confirm-checkout-btn');

        if (caraBayar === 'cash') {
            cashSection.style.display = 'block';
            creditSection.style.display = 'none';
            confirmBtn.disabled = true; // Disable until sufficient payment entered

            // Reset cash input fields
            document.getElementById('cash-tendered-input').value = '';
            document.getElementById('change-display').style.display = 'none';
            document.getElementById('insufficient-warning').style.display = 'none';

            // Generate quick cash buttons
            generateQuickCashButtons(totalAmount);
        } else {
            cashSection.style.display = 'none';
            creditSection.style.display = 'block';
            confirmBtn.disabled = false; // Enable immediately for credit
        }

        // Store total amount for later use
        window.currentCheckoutTotal = totalAmount;

        // Open modal
        $('#checkoutModal').modal('show');
    });

    // Generate Quick Cash Buttons
    function generateQuickCashButtons(totalAmount) {
        const quickCashContainer = document.getElementById('quick-cash-buttons');
        quickCashContainer.innerHTML = '';

        // Calculate smart quick amounts
        const roundedTotal = Math.ceil(totalAmount / 1000) * 1000; // Round up to nearest thousand
        const amounts = [
            roundedTotal,
            roundedTotal + 5000,
            roundedTotal + 10000,
            50000,
            100000,
            totalAmount // Exact amount
        ];

        // Remove duplicates and sort
        const uniqueAmounts = [...new Set(amounts)].sort((a, b) => a - b).slice(0, 6);

        uniqueAmounts.forEach(amount => {
            const btn = document.createElement('div');
            btn.className = 'quick-cash-btn';
            btn.textContent = formatRupiah(amount);
            btn.onclick = function() {
                document.getElementById('cash-tendered-input').value = amount.toLocaleString('id-ID');
                document.getElementById('cash-tendered-input').dispatchEvent(new Event('input'));
            };
            quickCashContainer.appendChild(btn);
        });
    }

    // Helper function to format rupiah
    function formatRupiah(amount) {
        if (amount >= 1000000) {
            return (amount / 1000000) + ' Juta';
        } else if (amount >= 1000) {
            return (amount / 1000) + 'rb';
        }
        return 'Rp ' + amount.toLocaleString('id-ID');
    }

    // Auto-focus on cash input after modal opens
    $('#checkoutModal').on('shown.bs.modal', function() {
        const caraBayar = document.querySelector('input[name="cara_bayar"]:checked').value;
        if (caraBayar === 'cash') {
            document.getElementById('cash-tendered-input').focus();
        }
    });

    // Keyboard shortcuts for modal
    $('#checkoutModal').on('keydown', function(e) {
        // Enter key to confirm (if button is enabled)
        if (e.key === 'Enter' && !document.getElementById('confirm-checkout-btn').disabled) {
            e.preventDefault();
            document.getElementById('confirm-checkout-btn').click();
        }
        // Escape key to close modal
        if (e.key === 'Escape') {
            $('#checkoutModal').modal('hide');
        }
    });

    // Cash Tendered Input Logic - Format and Calculate Change with Enhanced UX
    document.getElementById('cash-tendered-input').addEventListener('input', function(e) {
        // Remove non-numeric characters
        let value = e.target.value.replace(/\D/g, '');

        // Format with thousand separators
        if (value) {
            const numericValue = parseInt(value);
            e.target.value = numericValue.toLocaleString('id-ID');

            // Calculate change
            const totalAmount = window.currentCheckoutTotal;
            const change = numericValue - totalAmount;

            const changeDisplay = document.getElementById('change-display');
            const changeAmount = document.getElementById('change-amount');
            const insufficientWarning = document.getElementById('insufficient-warning');
            const confirmBtn = document.getElementById('confirm-checkout-btn');
            const changeAlert = changeDisplay.querySelector('.alert');

            if (numericValue >= totalAmount) {
                // Sufficient payment - show change in green with pulse animation
                changeDisplay.style.display = 'block';
                insufficientWarning.style.display = 'none';
                changeAmount.textContent = 'Rp ' + change.toLocaleString('id-ID');
                changeAlert.className = 'alert alert-success change-pulse';
                changeAlert.style.borderRadius = '12px';
                changeAlert.style.border = 'none';
                changeAlert.style.padding = '1.2rem';
                confirmBtn.disabled = false;

                // Remove animation class after animation completes
                setTimeout(() => {
                    changeAlert.classList.remove('change-pulse');
                }, 500);

                // Visual feedback on input
                e.target.style.borderColor = '#28a745';
            } else {
                // Insufficient payment - show warning with shake animation
                changeDisplay.style.display = 'none';
                insufficientWarning.style.display = 'block';
                insufficientWarning.classList.add('warning-shake');
                confirmBtn.disabled = true;

                // Remove animation class after animation completes
                setTimeout(() => {
                    insufficientWarning.classList.remove('warning-shake');
                }, 500);

                // Visual feedback on input
                e.target.style.borderColor = '#ffc107';
            }
        } else {
            // Empty input
            document.getElementById('change-display').style.display = 'none';
            document.getElementById('insufficient-warning').style.display = 'none';
            document.getElementById('confirm-checkout-btn').disabled = true;
            e.target.style.borderColor = '#e0e0e0';
        }
    });

    // Confirm Checkout Button - Save Transaction
    document.getElementById('confirm-checkout-btn').addEventListener('click', function() {
        const caraBayar = document.querySelector('input[name="cara_bayar"]:checked').value;
        const totalAmount = window.currentCheckoutTotal;

        // Validate payment for cash
        if (caraBayar === 'cash') {
            const cashInput = document.getElementById('cash-tendered-input').value;
            const cashTendered = parseInt(cashInput.replace(/\D/g, ''));

            if (!cashTendered || cashTendered < totalAmount) {
                showToast('Jumlah uang yang diterima tidak mencukupi!', 'warning');
                return;
            }
        }

        // Prepare cart data
        const cartData = cart.map(item => ({
            id: item.id,
            quantity: item.quantity,
            price: item.price,
        }));

        // Disable button to prevent double submission
        const confirmBtn = document.getElementById('confirm-checkout-btn');
        confirmBtn.disabled = true;
        confirmBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';

        // Send POST request
        fetch("{{ route('cart.save') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
            },
            body: JSON.stringify({
                cart: cartData,
                cara_bayar: caraBayar,
            }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                // Success animation on modal
                const modalContent = document.querySelector('#checkoutModal .modal-content');
                modalContent.style.animation = 'pulse 0.3s ease-in-out';

                // Success - clear cart and close modal with delay for animation
                setTimeout(() => {
                    showToast('Transaksi berhasil disimpan!', 'success');
                    cart.length = 0;
                    updateCart();
                    $('#checkoutModal').modal('hide');

                    // Reset button
                    confirmBtn.disabled = false;
                    confirmBtn.innerHTML = '<i class="fas fa-print mr-2"></i>Simpan & Cetak Struk';

                    // Play success sound (if browser supports it)
                    playSuccessSound();
                }, 300);
            }
        })
        .catch(error => {
            console.error("Error:", error);
            showToast('Terjadi kesalahan saat menyimpan transaksi!', 'error');

            // Reset button
            confirmBtn.disabled = false;
            confirmBtn.innerHTML = '<i class="fas fa-print mr-2"></i>Simpan & Cetak Struk';
        });
    });

    // Reset modal when closed
    $('#checkoutModal').on('hidden.bs.modal', function() {
        document.getElementById('cash-tendered-input').value = '';
        document.getElementById('change-display').style.display = 'none';
        document.getElementById('insufficient-warning').style.display = 'none';

        // Reset input border color
        const cashInput = document.getElementById('cash-tendered-input');
        if (cashInput) {
            cashInput.style.borderColor = '#e0e0e0';
        }
    });

    // Play success sound function
    function playSuccessSound() {
        try {
            // Create audio context for success beep
            const audioContext = new (window.AudioContext || window.webkitAudioContext)();
            const oscillator = audioContext.createOscillator();
            const gainNode = audioContext.createGain();

            oscillator.connect(gainNode);
            gainNode.connect(audioContext.destination);

            oscillator.frequency.value = 800; // Frequency in Hz
            oscillator.type = 'sine';

            gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.3);

            oscillator.start(audioContext.currentTime);
            oscillator.stop(audioContext.currentTime + 0.3);
        } catch (e) {
            // Audio not supported, silently fail
            console.log('Audio notification not supported');
        }
    }

// Search functionality
document.getElementById('search-bar').addEventListener('input', function(e) {
    const searchQuery = e.target.value.toLowerCase().trim();

    // Get all product cards across all tabs
    const productCards = document.querySelectorAll('.product-card');

    productCards.forEach(card => {
        const productName = card.dataset.name ? card.dataset.name.toLowerCase() : '';
        const productBarcode = card.dataset.barcode ? card.dataset.barcode.toLowerCase() : '';

        // Get the parent column div (col-xl-3, col-lg-4, etc.)
        const columnDiv = card.closest('[class*="col-"]');

        // Check if search query matches product name or barcode
        if (productName.includes(searchQuery) || productBarcode.includes(searchQuery)) {
            if (columnDiv) {
                columnDiv.style.display = '';
            } else {
                card.style.display = '';
            }
        } else {
            if (columnDiv) {
                columnDiv.style.display = 'none';
            } else {
                card.style.display = 'none';
            }
        }
    });

    // If search is active, show all tabs content to display matching products
    if (searchQuery) {
        document.querySelectorAll('.tab-pane').forEach(pane => {
            pane.classList.add('show', 'active');
        });
        // Hide category tabs when searching
        document.getElementById('categoryTabs').style.display = 'none';
    } else {
        // Reset to original tab view
        document.querySelectorAll('.tab-pane').forEach(pane => {
            pane.classList.remove('show', 'active');
        });
        // Re-activate the currently selected tab
        const activeTab = document.querySelector('#categoryTabs .nav-link.active');
        if (activeTab) {
            const target = activeTab.getAttribute('href');
            document.querySelector(target)?.classList.add('show', 'active');
        }
        // Show category tabs again
        document.getElementById('categoryTabs').style.display = '';
    }
});

</script>
@endsection