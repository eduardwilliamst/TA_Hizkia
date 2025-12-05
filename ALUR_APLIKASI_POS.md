# Dokumentasi Alur Aplikasi POS

## Ringkasan Perubahan

Aplikasi POS telah diperbaiki dengan alur yang lebih jelas dan UX yang lebih baik, disesuaikan untuk penggunaan Point of Sale (POS).

---

## 🔐 Alur Login

### 1. **Halaman Login**
- User memasukkan email, password, dan **memilih Terminal POS**
- Sistem membuat POS Session otomatis saat login berhasil
- File: [resources/views/auth/login.blade.php](resources/views/auth/login.blade.php)

### 2. **Redirect Berdasarkan Role**
Setelah login berhasil, user akan diarahkan ke dashboard sesuai role:

#### **Admin** → [Dashboard Admin](#dashboard-admin)
- Route: `/admin/dashboard`
- Fokus: Analytics, Management, Overview

#### **Kasir/User** → [Dashboard Kasir](#dashboard-kasir)
- Route: `/cashier/dashboard`
- Fokus: POS Operations, Quick Actions

---

## 📊 Dashboard Admin

**Route:** `/admin/dashboard`
**Controller:** `HomeController@adminDashboard`
**View:** [resources/views/admin/dashboard.blade.php](resources/views/admin/dashboard.blade.php)

### Fitur Dashboard Admin:
1. **Welcome Banner** dengan nama user dan tanggal
2. **8 Kartu Statistik:**
   - Total Produk
   - Produk Stok Rendah
   - Penjualan Hari Ini
   - Pendapatan Hari Ini
   - Penjualan Bulan Ini
   - Pendapatan Bulan Ini
   - Total Pengguna
   - Total Sesi POS

3. **Grafik Penjualan** (7 hari terakhir)
4. **Top 5 Produk Terlaris** (bulan ini)
5. **Tabel Produk Stok Rendah**
6. **Tabel Transaksi Terbaru** (10 transaksi terakhir)

### Akses Menu Admin:
- Dashboard
- POS / Penjualan
- **Master Data** (kategori, produk, promo, supplier, tipe)
- **Pembelian**
- Riwayat Transaksi (pembelian & penjualan)
- Cashflow
- **Pengguna** (user management)

---

## 💰 Dashboard Kasir

**Route:** `/cashier/dashboard`
**Controller:** `HomeController@cashierDashboard`
**View:** [resources/views/cashier/dashboard.blade.php](resources/views/cashier/dashboard.blade.php)

### Fitur Dashboard Kasir:
1. **Welcome Banner dengan Info POS Session:**
   - Nama Terminal
   - Saldo Awal
   - Tombol Quick Action: **"Mulai Transaksi"** & **"Cashflow"**

2. **3 Kartu Statistik Personal:**
   - Transaksi Hari Ini (saya)
   - Pendapatan Hari Ini (saya)
   - Status Sesi Aktif

3. **Tabel Transaksi Terakhir Saya** (5 transaksi)
4. **Kartu Quick Actions:**
   - 🛒 Transaksi Baru → langsung ke POS
   - 🛍️ Lihat Keranjang
   - 📦 Cek Stok Produk

5. **Alert Stok Rendah** (5 produk)

### Akses Menu Kasir:
- Dashboard
- **POS / Penjualan** (prioritas dengan badge "Hot")
- **Cek Stok Produk**
- Riwayat Penjualan
- Cashflow

---

## 🎨 Navbar (Top Bar)

### Fitur Navbar Baru:
1. **Logo & Brand** → redirect ke dashboard sesuai role
2. **Quick POS Button** (khusus kasir) → langsung ke transaksi
3. **Shopping Cart Icon** dengan badge jumlah item
4. **User Menu Dropdown:**
   - Avatar dengan nama user
   - Badge role (Admin/Kasir)
   - Menu:
     - Profil Saya
     - Cashflow
     - Riwayat Transaksi (kasir)
     - Logout

5. **Sidebar Toggle** untuk buka/tutup menu

File: [resources/views/layouts/adminlte.blade.php](resources/views/layouts/adminlte.blade.php) (baris 66-155)

---

## 📱 Sidebar (Menu Samping)

### Struktur Sidebar:

#### **User Panel** (di atas)
- Avatar user dengan gradien warna
- Nama user (klik → profil)
- Badge role (Admin/Kasir)

#### **Menu untuk ADMIN:**
```
📊 Dashboard
💵 POS / Penjualan [Hot]
📁 Master Data ↓
   ├─ Kategori
   ├─ Produk
   ├─ Promo
   ├─ Supplier
   └─ Tipe Pembelian
🛒 Pembelian
📜 Riwayat Transaksi ↓
   ├─ Riwayat Pembelian
   └─ Riwayat Penjualan
💰 Cashflow
---
👥 Pengguna
```

#### **Menu untuk KASIR:**
```
📊 Dashboard
💵 POS / Penjualan [Hot]
📦 Cek Stok Produk
📜 Riwayat Transaksi ↓
   └─ Riwayat Penjualan
💰 Cashflow
```

**Perbedaan Utama:**
- ✅ Kasir **TIDAK** bisa akses: Master Data, Pembelian, User Management
- ✅ Sidebar **otomatis menyesuaikan** menu berdasarkan role
- ✅ Duplikasi menu Supplier sudah dihapus

File: [resources/views/layouts/adminlte.blade.php](resources/views/layouts/adminlte.blade.php) (baris 131-290)

---

## 🔄 Alur Kerja Kasir (Workflow)

### Langkah 1: Login
1. Masukkan email & password
2. **Pilih Terminal POS** (wajib!)
3. Klik Login
4. Sistem membuat POS Session otomatis

### Langkah 2: Dashboard Kasir
Setelah login → langsung ke `/cashier/dashboard`
- Lihat info sesi (terminal, saldo awal)
- Lihat statistik transaksi hari ini
- Klik **"Mulai Transaksi"** untuk mulai

### Langkah 3: Transaksi POS
Dari dashboard, ada beberapa cara ke POS:
1. Tombol **"Mulai Transaksi"** di banner
2. Tombol **"Transaksi Baru"** di Quick Actions
3. Menu **"POS / Penjualan"** di sidebar
4. Tombol **"POS"** di navbar (quick access)

### Langkah 4: Proses Penjualan
1. Pilih produk atau scan barcode
2. Produk masuk ke keranjang (icon cart di navbar ada badge)
3. Klik icon cart atau "Lihat Keranjang"
4. Checkout → pilih metode pembayaran
5. Transaksi selesai

### Langkah 5: Cashflow
- Catat pemasukan (Cash In) dan pengeluaran (Cash Out)
- Akses via menu Cashflow atau dropdown user

### Langkah 6: Logout
1. Klik dropdown user (kanan atas)
2. Klik **"Logout"**
3. Sistem otomatis **finalisasi POS Session**:
   - Hitung total cash in/out
   - Update balance akhir
   - Simpan summary

---

## 🎯 Design Pattern & UX Best Practices

### Color Scheme:
- **Primary:** Gradien Ungu (#667eea → #764ba2)
- **Success:** Hijau (#43e97b)
- **Info:** Biru (#4facfe)
- **Warning:** Pink (#f093fb)
- **Danger:** Merah (#f5576c)

### Typography:
- Kartu statistik menggunakan **bold numbers** untuk highlight
- Badge dengan **rounded corners** (border-radius: 10px)
- Icon dengan **gradient backgrounds**

### Animations:
- Card hover: `translateY(-5px)` untuk lift effect
- Fade-in animations dengan class `animate-fade-in-up`

### Responsive:
- Grid sistem Bootstrap 4
- Mobile-friendly dengan collapsible sidebar
- Navbar sticky di atas

---

## 📁 File-File Penting

### Routes:
- [routes/web.php](routes/web.php) → Routing utama dengan role-based redirects

### Controllers:
- [app/Http/Controllers/Auth/LoginController.php](app/Http/Controllers/Auth/LoginController.php) → Handle login & redirect
- [app/Http/Controllers/HomeController.php](app/Http/Controllers/HomeController.php) → Dashboard admin & kasir

### Views - Layouts:
- [resources/views/layouts/adminlte.blade.php](resources/views/layouts/adminlte.blade.php) → Layout utama dengan navbar & sidebar

### Views - Dashboards:
- [resources/views/admin/dashboard.blade.php](resources/views/admin/dashboard.blade.php) → Dashboard admin
- [resources/views/cashier/dashboard.blade.php](resources/views/cashier/dashboard.blade.php) → Dashboard kasir
- [resources/views/dashboard.blade.php](resources/views/dashboard.blade.php) → Dashboard umum (fallback)

---

## 🚀 Cara Test Aplikasi

### 1. Login sebagai Admin:
```
Email: admin@example.com (sesuaikan dengan database)
Password: (password admin)
Terminal: Pilih salah satu
```
**Expected:** Redirect ke `/admin/dashboard` dengan full menu

### 2. Login sebagai Kasir:
```
Email: kasir@example.com (sesuaikan dengan database)
Password: (password kasir)
Terminal: Pilih salah satu
```
**Expected:** Redirect ke `/cashier/dashboard` dengan menu terbatas

### 3. Test Navigasi:
- ✅ Klik menu sidebar → navigate dengan smooth
- ✅ Klik cart icon → badge muncul jika ada item
- ✅ Klik user dropdown → menu muncul dengan info role
- ✅ Klik logout → redirect ke login & session clear

### 4. Test POS Flow:
- ✅ Dashboard kasir → klik "Mulai Transaksi"
- ✅ Pilih produk → add to cart
- ✅ Lihat cart → badge update
- ✅ Checkout → transaksi tersimpan
- ✅ Cashflow → catat pemasukan

---

## 🔧 Konfigurasi Role

Pastikan database memiliki roles berikut (via Spatie Permission):

```sql
-- Tabel: roles
INSERT INTO roles (name, guard_name) VALUES
('admin', 'web'),
('user', 'web'); -- atau 'kasir'

-- Assign role ke user
INSERT INTO model_has_roles (role_id, model_type, model_id) VALUES
(1, 'App\Models\User', 1), -- User ID 1 = Admin
(2, 'App\Models\User', 2); -- User ID 2 = Kasir
```

---

## 📝 Catatan Penting

### ✅ Yang Sudah Diperbaiki:
1. ✅ Route `admin.dashboard` dan `user.dashboard` sudah dibuat
2. ✅ Dashboard terpisah untuk Admin & Kasir
3. ✅ Sidebar role-based (admin vs kasir)
4. ✅ Navbar dengan cart badge & quick actions
5. ✅ Duplikasi menu Supplier dihapus
6. ✅ User panel di sidebar dengan avatar & role badge
7. ✅ Design modern dengan gradien & animasi

### 🔜 Rekomendasi Peningkatan (Optional):
1. Tambahkan middleware `role:admin` untuk route admin-only
2. Implement barcode scanner integration di POS
3. Add receipt printing functionality
4. Real-time cart updates dengan AJAX
5. Session timeout warning untuk kasir
6. Keyboard shortcuts untuk POS (F2 = add product, F9 = checkout, dll)

---

## 📞 Support

Jika ada pertanyaan atau bug:
1. Check [routes/web.php](routes/web.php) untuk routing issues
2. Check console browser untuk JavaScript errors
3. Check Laravel logs di `storage/logs/laravel.log`
4. Pastikan role sudah di-assign dengan benar

---

**Last Updated:** {{ date('Y-m-d H:i:s') }}
**Version:** 2.0 - POS UX Improvement
