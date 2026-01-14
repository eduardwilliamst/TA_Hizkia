/**
 * TEMPLATE JAVASCRIPT UNTUK MENAMBAHKAN LOADER DAN SWEETALERT
 * Copy paste script ini ke @section('javascript') di file blade Anda
 * Sesuaikan selector dan route sesuai kebutuhan
 */

// ========================================
// TEMPLATE 1: FORM TAMBAH DATA DENGAN MODAL
// ========================================
$('#modalTambahID form').on('submit', function(e) {
    e.preventDefault();

    const form = $(this);
    const formData = new FormData(this);
    const submitBtn = form.find('button[type="submit"]');

    LoaderUtil.show('Menyimpan data...'); // Ganti message sesuai konteks
    submitBtn.prop('disabled', true);

    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            LoaderUtil.hide();
            $('#modalTambahID').modal('hide'); // Ganti dengan ID modal Anda

            Toast.fire({
                icon: 'success',
                title: 'Data berhasil ditambahkan!' // Sesuaikan pesan
            });

            setTimeout(() => window.location.reload(), 1500);
        },
        error: function(xhr) {
            LoaderUtil.hide();
            submitBtn.prop('disabled', false);

            let errorMessage = 'Terjadi kesalahan saat menyimpan data';
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                const errors = xhr.responseJSON.errors;
                errorMessage = '<ul style="text-align: left; margin: 0;">';
                for (let field in errors) {
                    errors[field].forEach(error => {
                        errorMessage += `<li>${error}</li>`;
                    });
                }
                errorMessage += '</ul>';
            }

            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                html: errorMessage,
                confirmButtonColor: '#d33'
            });
        }
    });
});

// ========================================
// TEMPLATE 2: FORM EDIT DATA DENGAN MODAL (Delegated Event)
// ========================================
$(document).on('submit', '#modalEditID form', function(e) {
    e.preventDefault();

    const form = $(this);
    const formData = new FormData(this);
    const submitBtn = form.find('button[type="submit"]');

    LoaderUtil.show('Memperbarui data...'); // Ganti message
    submitBtn.prop('disabled', true);

    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            LoaderUtil.hide();
            $('#modalEditID').modal('hide'); // Ganti dengan ID modal

            Toast.fire({
                icon: 'success',
                title: 'Data berhasil diperbarui!' // Sesuaikan pesan
            });

            setTimeout(() => window.location.reload(), 1500);
        },
        error: function(xhr) {
            LoaderUtil.hide();
            submitBtn.prop('disabled', false);

            let errorMessage = 'Terjadi kesalahan saat memperbarui data';
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                const errors = xhr.responseJSON.errors;
                errorMessage = '<ul style="text-align: left; margin: 0;">';
                for (let field in errors) {
                    errors[field].forEach(error => {
                        errorMessage += `<li>${error}</li>`;
                    });
                }
                errorMessage += '</ul>';
            }

            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                html: errorMessage,
                confirmButtonColor: '#d33'
            });
        }
    });
});

// ========================================
// TEMPLATE 3: LOAD MODAL VIA AJAX
// ========================================
function loadModal(id) {
    LoaderUtil.show('Memuat data...'); // Ganti message

    $.ajax({
        type: 'POST',
        url: '/your-route-here', // Ganti dengan route Anda
        data: {
            '_token': '{{ csrf_token() }}',
            'id': id,
        },
        success: function(data) {
            LoaderUtil.hide();
            $("#modalContentID").html(data.msg); // Ganti dengan ID container modal
        },
        error: function(xhr) {
            LoaderUtil.hide();
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Gagal memuat data',
                confirmButtonColor: '#d33'
            });
        }
    });
}

// ========================================
// TEMPLATE 4: FORM TANPA MODAL (Full Page Form)
// ========================================
$('#formID').on('submit', function(e) {
    e.preventDefault();

    const form = $(this);
    const formData = new FormData(this);
    const submitBtn = form.find('button[type="submit"]');

    LoaderUtil.show('Menyimpan data...');
    submitBtn.prop('disabled', true);

    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            LoaderUtil.hide();

            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Data berhasil disimpan',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                // Redirect jika perlu
                if (response.redirect_url) {
                    window.location.href = response.redirect_url;
                } else {
                    window.location.reload();
                }
            });
        },
        error: function(xhr) {
            LoaderUtil.hide();
            submitBtn.prop('disabled', false);

            let errorMessage = 'Terjadi kesalahan';
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                const errors = xhr.responseJSON.errors;
                errorMessage = '<ul style="text-align: left; margin: 0;">';
                for (let field in errors) {
                    errors[field].forEach(error => {
                        errorMessage += `<li>${error}</li>`;
                    });
                }
                errorMessage += '</ul>';
            }

            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                html: errorMessage,
                confirmButtonColor: '#d33'
            });
        }
    });
});

// ========================================
// TEMPLATE 5: CHECKOUT / TRANSAKSI DENGAN KONFIRMASI
// ========================================
function doCheckout() {
    // Validasi data dulu
    if (!validateData()) {
        Swal.fire({
            icon: 'warning',
            title: 'Perhatian!',
            text: 'Mohon lengkapi data terlebih dahulu',
            confirmButtonColor: '#f39c12'
        });
        return;
    }

    // Konfirmasi dulu
    Swal.fire({
        title: 'Konfirmasi Transaksi',
        html: '<div class="text-left">Total: Rp XXX<br>Metode: Cash</div>', // Sesuaikan
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Proses!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            processTransaction();
        }
    });
}

function processTransaction() {
    const formData = new FormData();
    // Tambahkan data yang diperlukan
    formData.append('_token', '{{ csrf_token() }}');
    // formData.append('key', value);

    LoaderUtil.show('Memproses transaksi...');

    $.ajax({
        url: '/your-transaction-route',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            LoaderUtil.hide();

            Swal.fire({
                icon: 'success',
                title: 'Transaksi Berhasil!',
                text: response.message || 'Transaksi berhasil diproses',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                // Clear cart atau redirect
                window.location.href = response.redirect_url || '/dashboard';
            });
        },
        error: function(xhr) {
            LoaderUtil.hide();

            let errorMessage = 'Transaksi gagal diproses';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }

            Swal.fire({
                icon: 'error',
                title: 'Transaksi Gagal!',
                text: errorMessage,
                confirmButtonColor: '#d33'
            });
        }
    });
}

// ========================================
// TEMPLATE 6: SESSION OPENING/CLOSING
// ========================================
$('#formOpenSession').on('submit', function(e) {
    e.preventDefault();

    const form = $(this);
    const formData = new FormData(this);
    const submitBtn = form.find('button[type="submit"]');

    LoaderUtil.show('Membuka sesi kasir...');
    submitBtn.prop('disabled', true);

    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            LoaderUtil.hide();

            Swal.fire({
                icon: 'success',
                title: 'Sesi Kasir Dibuka!',
                text: 'Selamat bekerja!',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                window.location.href = '/dashboard';
            });
        },
        error: function(xhr) {
            LoaderUtil.hide();
            submitBtn.prop('disabled', false);

            Swal.fire({
                icon: 'error',
                title: 'Gagal Membuka Sesi!',
                text: xhr.responseJSON?.message || 'Terjadi kesalahan',
                confirmButtonColor: '#d33'
            });
        }
    });
});

// ========================================
// CATATAN PENTING:
// ========================================
// 1. Ganti semua ID modal, form, dan selector sesuai dengan file Anda
// 2. Ganti route URL sesuai dengan route Laravel Anda
// 3. Sesuaikan pesan loading dan success sesuai konteks
// 4. Pastikan CSRF token sudah benar
// 5. LoaderUtil dan Swal sudah global (dari app-utilities.js)
// 6. Toast juga sudah global (dari adminlte layout)
