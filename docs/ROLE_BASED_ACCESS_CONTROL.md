# Role-Based Access Control - List Sesi POS

## Implementasi Selesai ✅

Telah ditambahkan fitur **Riwayat Sesi POS** yang hanya dapat diakses oleh **Admin**.

---

## 🔐 Access Control

### Admin
- ✅ Dapat melihat semua riwayat sesi POS dari semua kasir
- ✅ Dapat melihat detail setiap sesi (transaksi, cashflow, summary)
- ✅ Menu "Riwayat Sesi" muncul di sidebar

### Kasir
- ❌ Tidak dapat melihat list sesi POS
- ❌ Menu tidak muncul di sidebar
- ❌ Jika mencoba akses langsung → Error 403 Forbidden

---

## 📁 File yang Dibuat/Dimodifikasi

### 1. Controller
**File**: `app/Http/Controllers/PosSessionController.php`

**Method Baru**:
```php
// List semua sesi (Admin only)
public function index()

// Detail sesi dengan transaksi & cashflow (Admin only)
public function getDetail($id)
```

**Authorization Check**:
```php
if (!auth()->user()->hasRole('admin')) {
    abort(403, 'Unauthorized action.');
}
```

### 2. Routes
**File**: `routes/web.php`

**Route Baru**:
```php
// List sesi POS (Admin only)
Route::get('pos-session', [PosSessionController::class, 'index'])
    ->name('pos-session.index')
    ->middleware('role:admin');

// Detail sesi (Admin only)
Route::get('pos-session/{id}/detail', [PosSessionController::class, 'getDetail'])
    ->name('pos-session.detail')
    ->middleware('role:admin');
```

**Middleware**: `role:admin` dari Spatie Laravel Permission

### 3. Views

**View Utama**: `resources/views/pos-session/index.blade.php`
- Tabel list semua sesi POS
- Informasi: ID, Tanggal, Kasir, POS Mesin, Saldo Awal/Akhir, Selisih, Status
- DataTable dengan export Excel & PDF
- Pagination
- Loader saat memuat detail
- Button untuk melihat detail setiap sesi

**View Detail**: `resources/views/pos-session/detail.blade.php`
- Modal yang menampilkan detail lengkap sesi
- Informasi Sesi (Kasir, Mesin, Tanggal, Saldo, Status)
- Ringkasan Penjualan (Total Transaksi, Cash, Card)
- Cashflow (Total Cash In/Out, Rincian)
- Daftar semua transaksi dalam sesi tersebut

### 4. Sidebar Menu
**File**: `resources/views/layouts/adminlte.blade.php`

**Menu Baru** (Hanya untuk Admin):
```blade
@if(Auth::user()->hasRole('admin'))
<li class="nav-item">
    <a href="{{ route('pos-session.index') }}" class="nav-link">
        <i class="nav-icon fas fa-history"></i>
        <p>
            Riwayat Sesi
            <span class="badge badge-primary right">Admin</span>
        </p>
    </a>
</li>
@endif
```

---

## 🎯 Fitur Detail

### List Sesi POS
1. **Kolom Informasi**:
   - ID Sesi
   - Tanggal & Waktu
   - Nama Kasir
   - Nama POS Mesin
   - Saldo Awal (warna hijau)
   - Saldo Akhir (warna hitam jika sudah ditutup, badge warning jika masih aktif)
   - Selisih (warna hijau untuk positif, merah untuk negatif)
   - Status (badge success untuk selesai, warning untuk aktif)

2. **Aksi**:
   - Button "Detail" untuk melihat detail lengkap sesi

3. **Export**:
   - Excel (semua kolom kecuali Action)
   - PDF (semua kolom kecuali Action)

4. **Pagination**: 20 data per halaman

### Detail Sesi (Modal)
1. **Informasi Sesi**:
   - Kasir yang menjalankan sesi
   - POS Mesin yang digunakan
   - Tanggal & waktu sesi
   - Saldo awal dan akhir
   - Status (Selesai/Aktif)
   - Keterangan/catatan

2. **Ringkasan Penjualan**:
   - Total Transaksi (jumlah)
   - Total Cash Sales
   - Total Card Sales
   - Grand Total Penjualan

3. **Cashflow**:
   - Total Cash In
   - Total Cash Out
   - Tabel rincian setiap cashflow (tanggal, tipe, jumlah, keterangan)

4. **Daftar Transaksi**:
   - Semua transaksi dalam sesi
   - No Transaksi, Tanggal, Total, Cara Bayar
   - Max height dengan scroll

---

## 💻 Teknologi

- **Authorization**: Spatie Laravel Permission (`hasRole('admin')`)
- **Middleware**: `role:admin` pada routes
- **ORM**: Eloquent dengan eager loading (`with(['user', 'posMesin'])`)
- **Frontend**:
  - Bootstrap 4
  - DataTables dengan buttons (Excel, PDF)
  - SweetAlert2 untuk notifications
  - LoaderUtil untuk loading overlay
  - Modal untuk detail view
- **AJAX**: jQuery untuk load detail modal

---

## 🔒 Security

### 1. Route Level Protection
```php
->middleware('role:admin')
```
Middleware mencegah akses unauthorized di level routing.

### 2. Controller Level Protection
```php
if (!auth()->user()->hasRole('admin')) {
    abort(403, 'Unauthorized action.');
}
```
Double-check di controller sebagai layer kedua.

### 3. View Level Protection
```blade
@if(Auth::user()->hasRole('admin'))
    <!-- Menu hanya muncul untuk admin -->
@endif
```
Menu tidak ditampilkan untuk kasir.

---

## 📊 Database Relationships

```php
PosSession::with(['user', 'posMesin'])
    ->orderBy('tanggal', 'desc')
    ->paginate(20);
```

**Relationships yang diload**:
- `user`: Kasir yang menjalankan sesi
- `posMesin`: Mesin POS yang digunakan

**Untuk Detail**:
- `penjualans`: Semua transaksi penjualan dalam sesi
- `cashFlows`: Semua cashflow (cash in/out) dalam sesi

---

## 🎨 User Experience

### Admin:
1. Login sebagai admin
2. Lihat menu "Riwayat Sesi" dengan badge "Admin" di sidebar (section Point of Sale)
3. Klik menu → Lihat tabel semua sesi POS
4. Klik "Detail" pada sesi tertentu → Modal detail dengan loader
5. Lihat semua informasi lengkap sesi
6. Export ke Excel/PDF jika diperlukan

### Kasir:
1. Login sebagai kasir
2. Menu "Riwayat Sesi" **TIDAK muncul** di sidebar
3. Jika mencoba akses langsung via URL → Error 403

---

## 📝 Catatan Implementasi

1. **Pagination**: Menggunakan Laravel pagination (20 per halaman)
2. **Loader**: LoaderUtil untuk loading state saat fetch detail
3. **Responsive**: Tabel responsive dengan horizontal scroll
4. **Empty State**: Pesan friendly jika belum ada sesi
5. **Styling**: Konsisten dengan theme AdminLTE & gradient modern
6. **Badge**: Color-coded untuk status dan payment method
7. **Format**: Number formatting untuk currency (Rp 1.000.000)
8. **Date**: Carbon untuk format tanggal Indonesia

---

## ✅ Testing Checklist

- [x] Admin dapat melihat list sesi
- [x] Admin dapat melihat detail sesi
- [x] Kasir tidak dapat akses (403 error)
- [x] Menu hanya muncul untuk admin
- [x] DataTable berfungsi (sort, search, pagination)
- [x] Export Excel & PDF berfungsi
- [x] Modal detail load dengan benar
- [x] Loader muncul saat loading
- [x] Semua relationship di-load dengan benar
- [x] Tampilan responsive

---

**Implementasi Selesai**: 2026-01-15
**Developer**: Claude Sonnet 4.5
**Status**: ✅ Production Ready
