/**
 * Global Utilities untuk SweetAlert dan Loader
 * Digunakan untuk semua transaksi dan CRUD operations
 */

// Loader overlay utility
const LoaderUtil = {
    show: function(message = 'Memproses data...') {
        // Remove existing loader if any
        this.hide();

        const loaderHtml = `
            <div id="global-loader" style="
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.8);
                z-index: 99999;
                display: flex;
                align-items: center;
                justify-content: center;
                backdrop-filter: blur(2px);
            ">
                <div style="text-align: center; color: white; background: rgba(255,255,255,0.1); padding: 2rem; border-radius: 15px; box-shadow: 0 8px 32px rgba(0,0,0,0.3);">
                    <div class="spinner-border text-light" role="status" style="width: 3.5rem; height: 3.5rem; border-width: 4px;">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <div class="mt-3" style="font-size: 16px; font-weight: 500; letter-spacing: 0.5px;">${message}</div>
                </div>
            </div>
        `;
        $('body').append(loaderHtml);
    },

    hide: function() {
        $('#global-loader').fadeOut(300, function() {
            $(this).remove();
        });
    }
};

// Form submission dengan loader dan SweetAlert
function submitFormWithLoader(formSelector, options = {}) {
    const form = $(formSelector);

    form.on('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const url = form.attr('action');
        const method = form.attr('method') || 'POST';

        // Show loader
        LoaderUtil.show(options.loadingMessage || 'Menyimpan data...');

        // Disable submit button
        const submitBtn = form.find('button[type="submit"]');
        submitBtn.prop('disabled', true);

        $.ajax({
            url: url,
            type: method,
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                LoaderUtil.hide();

                // Show success message
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: response.message || options.successMessage || 'Data berhasil disimpan',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    // Redirect or reload
                    if (options.redirectUrl) {
                        window.location.href = options.redirectUrl;
                    } else if (options.reloadPage !== false) {
                        window.location.reload();
                    }

                    // Call success callback
                    if (options.onSuccess && typeof options.onSuccess === 'function') {
                        options.onSuccess(response);
                    }
                });
            },
            error: function(xhr) {
                LoaderUtil.hide();
                submitBtn.prop('disabled', false);

                let errorMessage = 'Terjadi kesalahan saat menyimpan data';

                if (xhr.responseJSON) {
                    if (xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.responseJSON.errors) {
                        // Validation errors
                        const errors = xhr.responseJSON.errors;
                        errorMessage = '<ul style="text-align: left; margin: 0;">';
                        for (let field in errors) {
                            errors[field].forEach(error => {
                                errorMessage += `<li>${error}</li>`;
                            });
                        }
                        errorMessage += '</ul>';
                    }
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    html: errorMessage,
                    confirmButtonColor: '#d33'
                });

                // Call error callback
                if (options.onError && typeof options.onError === 'function') {
                    options.onError(xhr);
                }
            }
        });
    });
}

// Delete confirmation dengan loader
function confirmDeleteWithLoader(url, options = {}) {
    Swal.fire({
        title: options.title || 'Apakah Anda yakin?',
        text: options.text || 'Data yang dihapus tidak dapat dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: options.confirmText || 'Ya, hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            LoaderUtil.show('Menghapus data...');

            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    LoaderUtil.hide();

                    Swal.fire({
                        icon: 'success',
                        title: 'Terhapus!',
                        text: response.message || 'Data berhasil dihapus',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        if (options.redirectUrl) {
                            window.location.href = options.redirectUrl;
                        } else {
                            window.location.reload();
                        }
                    });
                },
                error: function(xhr) {
                    LoaderUtil.hide();

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: xhr.responseJSON?.message || 'Gagal menghapus data',
                        confirmButtonColor: '#d33'
                    });
                }
            });
        }
    });
}

// AJAX request dengan loader
function ajaxWithLoader(options = {}) {
    LoaderUtil.show(options.loadingMessage || 'Memproses...');

    return $.ajax({
        url: options.url,
        type: options.method || 'GET',
        data: options.data || {},
        dataType: options.dataType || 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }).done(function(response) {
        LoaderUtil.hide();
        if (options.onSuccess && typeof options.onSuccess === 'function') {
            options.onSuccess(response);
        }
    }).fail(function(xhr) {
        LoaderUtil.hide();
        if (options.onError && typeof options.onError === 'function') {
            options.onError(xhr);
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: xhr.responseJSON?.message || 'Terjadi kesalahan',
                confirmButtonColor: '#d33'
            });
        }
    });
}
