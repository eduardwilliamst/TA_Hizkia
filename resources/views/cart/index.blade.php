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
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h3 class="mb-0">
                <i class="fas fa-shopping-cart mr-2"></i>
                Keranjang Belanja
            </h3>
            <a href="{{ route('penjualan.index') }}" class="btn btn-primary" style="border-radius: 10px;">
                <i class="fas fa-plus mr-2"></i>Tambah Item
            </a>
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
                                <th style="text-align: center;"><i class="fas fa-cog mr-2"></i>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="cart-items-table">
                            @foreach($cart as $index => $item)
                                <tr class="animate-fade-in" data-index="{{ $index }}">
                                    <td style="font-weight: 600; color: #333;">{{ $item['name'] }}</td>
                                    <td style="color: #667eea; font-weight: 600;">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                                    <td style="text-align: center;">
                                        <div style="display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                                            <button class="btn btn-sm btn-outline-secondary decrease-qty-cart" data-index="{{ $index }}" style="border-radius: 50%; width: 32px; height: 32px; padding: 0;">
                                                <i class="fas fa-minus" style="font-size: 0.7rem;"></i>
                                            </button>
                                            <span class="badge item-quantity" style="background: #667eea; color: white; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.95rem; min-width: 50px;">
                                                {{ $item['quantity'] }}
                                            </span>
                                            <button class="btn btn-sm btn-outline-secondary increase-qty-cart" data-index="{{ $index }}" style="border-radius: 50%; width: 32px; height: 32px; padding: 0;">
                                                <i class="fas fa-plus" style="font-size: 0.7rem;"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td class="item-subtotal" style="font-weight: 700; color: #333; font-size: 1.1rem;">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</td>
                                    <td style="text-align: center;">
                                        <button class="btn btn-danger btn-sm remove-item-cart" data-index="{{ $index }}" style="border-radius: 8px;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
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
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                            <label style="font-weight: 600; color: #333; margin: 0;">
                                <i class="fas fa-money-bill-wave mr-2"></i>Uang yang Dibayar
                            </label>
                            <button type="button" id="toggleEditPayment" class="btn btn-sm btn-outline-primary" style="border-radius: 8px;">
                                <i class="fas fa-lock" id="lockIcon"></i>
                                <span id="lockText">Ubah</span>
                            </button>
                        </div>
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
                                   value="{{ session('uang_dibayar', 0) }}"
                                   @if(session('uang_dibayar', 0) > 0) readonly @endif
                                   style="font-size: 1.1rem; padding: 0.8rem; border: 2px solid #667eea;">
                        </div>

                        <!-- Quick Cash Buttons -->
                        <div id="quickCashSection" style="margin-bottom: 1rem; @if(session('uang_dibayar', 0) > 0) display: none; @endif">
                            <div style="font-size: 0.85rem; color: #666; margin-bottom: 0.5rem;">
                                <i class="fas fa-bolt mr-1"></i>Nominal Cepat
                            </div>
                            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.5rem;" id="quick-cash-buttons-cart">
                                <!-- Quick cash buttons will be inserted here by JavaScript -->
                            </div>
                        </div>

                        <div id="kembalianSection" style="@if(session('kembalian', 0) > 0) display: block; @else display: none; @endif padding: 1rem; background: white; border-radius: 10px; border: 2px solid #28a745; margin-top: 1rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span style="font-weight: 600; color: #333;">
                                    <i class="fas fa-hand-holding-usd mr-2"></i>Uang Kembalian:
                                </span>
                                <span id="uangKembalian" style="font-weight: 700; color: #28a745; font-size: 1.2rem;">
                                    Rp {{ number_format(session('kembalian', 0), 0, ',', '.') }}
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
        const toggleEditBtn = document.getElementById('toggleEditPayment');
        const lockIcon = document.getElementById('lockIcon');
        const lockText = document.getElementById('lockText');
        const quickCashSection = document.getElementById('quickCashSection');

        // Check if payment data already exists
        const hasPaymentData = @json(session('uang_dibayar', 0)) > 0;

        // Set initial button state
        if (hasPaymentData) {
            simpanBtn.disabled = false; // Enable if payment already entered
            lockIcon.className = 'fas fa-lock';
            lockText.textContent = 'Ubah';
        }

        // Toggle edit payment button
        toggleEditBtn.addEventListener('click', function() {
            const isReadonly = uangDibayarInput.hasAttribute('readonly');

            if (isReadonly) {
                // Unlock - allow editing
                uangDibayarInput.removeAttribute('readonly');
                uangDibayarInput.focus();
                quickCashSection.style.display = 'block';
                lockIcon.className = 'fas fa-unlock';
                lockText.textContent = 'Kunci';
                simpanBtn.disabled = true; // Disable until valid input
            } else {
                // Lock - prevent editing
                const uangDibayar = parseFloat(uangDibayarInput.value) || 0;
                if (uangDibayar >= totalPembayaran) {
                    uangDibayarInput.setAttribute('readonly', true);
                    quickCashSection.style.display = 'none';
                    lockIcon.className = 'fas fa-lock';
                    lockText.textContent = 'Ubah';
                    simpanBtn.disabled = false; // Enable if payment is sufficient
                } else {
                    alert('Uang yang dibayar harus lebih dari atau sama dengan total pembayaran!');
                }
            }
        });

        // Generate quick cash buttons
        const quickCashContainer = document.getElementById('quick-cash-buttons-cart');
        const quickAmounts = [50000, 100000, 150000, 200000, 500000];

        // Calculate smart amounts based on total
        const roundedTotal = Math.ceil(totalPembayaran / 10000) * 10000; // Round up to nearest 10k
        const smartAmounts = [
            roundedTotal,
            roundedTotal + 50000,
            roundedTotal + 100000
        ];

        // Use smart amounts if total > 100k, otherwise use fixed amounts
        const displayAmounts = totalPembayaran > 100000 ? smartAmounts : quickAmounts.slice(0, 3);

        displayAmounts.forEach(amount => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'quick-cash-btn';
            btn.textContent = 'Rp ' + (amount / 1000) + 'k';
            btn.onclick = function() {
                uangDibayarInput.value = amount;
                uangDibayarInput.dispatchEvent(new Event('input'));
            };
            quickCashContainer.appendChild(btn);
        });

        uangDibayarInput.addEventListener('input', function() {
            const uangDibayar = parseFloat(this.value) || 0;

            if (uangDibayar > 0) {
                const kembalian = uangDibayar - totalPembayaran;

                if (kembalian >= 0) {
                    // Sufficient cash - show change, hide warning, enable button
                    kembalianSection.style.display = 'block';
                    warningSection.style.display = 'none';
                    uangKembalianDisplay.textContent = 'Rp ' + kembalian.toLocaleString('id-ID');

                    // Only enable if not locked
                    if (!uangDibayarInput.hasAttribute('readonly')) {
                        simpanBtn.disabled = false;
                    }
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

    // Handle increase quantity
    document.addEventListener('click', function(e) {
        if (e.target.closest('.increase-qty-cart')) {
            const button = e.target.closest('.increase-qty-cart');
            const index = parseInt(button.dataset.index);
            cart[index].quantity += 1;
            updateCartUI();
            saveCartToSession();
        }

        // Handle decrease quantity
        if (e.target.closest('.decrease-qty-cart')) {
            const button = e.target.closest('.decrease-qty-cart');
            const index = parseInt(button.dataset.index);
            if (cart[index].quantity > 1) {
                cart[index].quantity -= 1;
                updateCartUI();
                saveCartToSession();
            }
        }

        // Handle remove item
        if (e.target.closest('.remove-item-cart')) {
            const button = e.target.closest('.remove-item-cart');
            const index = parseInt(button.dataset.index);

            if (confirm('Apakah Anda yakin ingin menghapus item ini dari keranjang?')) {
                cart.splice(index, 1);

                if (cart.length === 0) {
                    // If cart is empty, clear session and reload
                    fetch("{{ route('cart.clear') }}", {
                        method: "POST",
                        headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" }
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    updateCartUI();
                    saveCartToSession();
                }
            }
        }
    });

    // Function to update cart UI
    function updateCartUI() {
        const tbody = document.getElementById('cart-items-table');
        tbody.innerHTML = '';

        let total = 0;
        cart.forEach((item, index) => {
            const subtotal = item.price * item.quantity;
            total += subtotal;

            const row = document.createElement('tr');
            row.className = 'animate-fade-in';
            row.dataset.index = index;
            row.innerHTML = `
                <td style="font-weight: 600; color: #333;">${item.name}</td>
                <td style="color: #667eea; font-weight: 600;">Rp ${item.price.toLocaleString('id-ID')}</td>
                <td style="text-align: center;">
                    <div style="display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                        <button class="btn btn-sm btn-outline-secondary decrease-qty-cart" data-index="${index}" style="border-radius: 50%; width: 32px; height: 32px; padding: 0;">
                            <i class="fas fa-minus" style="font-size: 0.7rem;"></i>
                        </button>
                        <span class="badge item-quantity" style="background: #667eea; color: white; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.95rem; min-width: 50px;">
                            ${item.quantity}
                        </span>
                        <button class="btn btn-sm btn-outline-secondary increase-qty-cart" data-index="${index}" style="border-radius: 50%; width: 32px; height: 32px; padding: 0;">
                            <i class="fas fa-plus" style="font-size: 0.7rem;"></i>
                        </button>
                    </div>
                </td>
                <td class="item-subtotal" style="font-weight: 700; color: #333; font-size: 1.1rem;">Rp ${subtotal.toLocaleString('id-ID')}</td>
                <td style="text-align: center;">
                    <button class="btn btn-danger btn-sm remove-item-cart" data-index="${index}" style="border-radius: 8px;">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(row);
        });

        // Update total
        document.getElementById('totalPembayaran').textContent = 'Rp ' + total.toLocaleString('id-ID');

        // Recalculate total for payment validation
        totalPembayaran = total;

        // Trigger input event to recalculate change
        if (caraBayar === 'cash') {
            const uangDibayarInput = document.getElementById('uangDibayar');
            if (uangDibayarInput) {
                uangDibayarInput.dispatchEvent(new Event('input'));
            }
        }
    }

    // Function to save cart to session
    function saveCartToSession() {
        fetch("{{ route('cart.update') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
            },
            body: JSON.stringify({
                cart: cart
            }),
        })
        .then(response => response.json())
        .then(data => {
            console.log('Cart updated:', data);
        })
        .catch(error => {
            console.error("Error updating cart:", error);
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

<style>
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

    /* Animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fadeIn 0.3s ease-in-out;
    }
</style>
@endsection
