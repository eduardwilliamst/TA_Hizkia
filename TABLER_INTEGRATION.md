# Integrasi Tabler.io Template untuk Master Data

## 📌 Overview

Aplikasi POS sekarang menggunakan **dua template** yang berbeda:
- **AdminLTE** → Dashboard, POS, Cashflow, dan halaman operasional
- **Tabler.io** → Master Data (Kategori, Produk, Promo, Supplier, Tipe Pembelian)

---

## ✨ Keunggulan Tabler.io

### 1. **Modern & Clean Design**
- UI/UX yang lebih modern dan clean
- Responsive design dengan Bootstrap 5
- Typography yang lebih baik (Inter font)
- Color palette yang konsisten

### 2. **Better Data Tables**
- DataTables terintegrasi dengan Bootstrap 5
- Export functionality (Excel, PDF, Print)
- Responsive tables
- Better search & filtering

### 3. **Professional Admin Interface**
- Clean navigation
- Better modal design
- Improved form components
- Icon integration with Font Awesome 6

---

## 📁 Struktur File

### Layout Template
```
resources/views/layouts/
├── adminlte.blade.php    → Template lama (Dashboard, POS, dll)
└── tabler.blade.php      → Template baru (Master Data)
```

### Master Data Views (menggunakan Tabler)
```
resources/views/
├── kategori/index.blade.php    ✅ Updated
├── produk/index.blade.php      ⏳ Perlu update
├── promo/index.blade.php       ⏳ Perlu update
├── supplier/index.blade.php    ⏳ Perlu update
└── tipe/index.blade.php        ⏳ Perlu update
```

---

## 🎨 Design Pattern

### Color Scheme (sama dengan AdminLTE)
- **Primary Gradient:** #667eea → #764ba2
- **Success:** #43e97b
- **Info:** #4facfe
- **Danger:** #f5576c
- **Warning:** #f093fb

### Typography
```css
Font Family: 'Inter Var', -apple-system, BlinkMacSystemFont
Font Features: "cv03", "cv04", "cv11"
```

### Animations
```css
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
```

---

## 🔧 Cara Menggunakan Layout Tabler

### 1. **Extend Layout**
```blade
@extends('layouts.tabler')
```

### 2. **Set Title**
```blade
@section('title', 'Kategori')
```

### 3. **Page Header**
```blade
@section('page-header')
    <div class="page-pretitle">
        Master Data
    </div>
    <h2 class="page-title">
        <i class="fas fa-th-large me-2"></i>
        Kategori Produk
    </h2>
@endsection
```

### 4. **Page Actions (Optional)**
```blade
@section('page-actions')
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
        <i class="fas fa-plus me-2"></i>
        Tambah Data
    </button>
@endsection
```

### 5. **Main Content**
```blade
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Data</h3>
            </div>
            <div class="card-body">
                <!-- Your content here -->
            </div>
        </div>
    </div>
</div>
@endsection
```

### 6. **Custom Scripts**
```blade
@section('scripts')
<script>
    // Your custom JavaScript
</script>
@endsection
```

---

## 📊 DataTable Configuration

### Basic Setup
```javascript
$('#myTable').DataTable({
    responsive: true,
    dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>B',
    buttons: [
        {
            extend: 'excel',
            text: '<i class="fas fa-file-excel me-1"></i> Excel',
            className: 'btn btn-success btn-sm',
            exportOptions: {
                columns: ':not(:last-child)'
            }
        },
        {
            extend: 'pdf',
            text: '<i class="fas fa-file-pdf me-1"></i> PDF',
            className: 'btn btn-danger btn-sm',
            exportOptions: {
                columns: ':not(:last-child)'
            }
        }
    ],
    language: {
        search: "Cari:",
        lengthMenu: "Tampilkan _MENU_ data per halaman",
        zeroRecords: "Data tidak ditemukan",
        info: "Menampilkan halaman _PAGE_ dari _PAGES_",
        infoEmpty: "Tidak ada data yang tersedia",
        infoFiltered: "(difilter dari _MAX_ total data)",
        paginate: {
            first: "Pertama",
            last: "Terakhir",
            next: "Selanjutnya",
            previous: "Sebelumnya"
        }
    }
});
```

---

## 🎭 Modal Design

### Tabler Modal Structure
```blade
<div class="modal modal-blur fade" id="myModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('data.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-plus-circle me-2 text-primary"></i>
                        Tambah Data
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label required">Field Name</label>
                        <input type="text" class="form-control" name="field" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
```

### Key Differences dari AdminLTE
- `data-bs-toggle` instead of `data-toggle`
- `data-bs-dismiss` instead of `data-dismiss`
- `data-bs-target` instead of `data-target`
- `btn-close` instead of `close` button
- `modal-blur` class untuk blur effect

---

## 🔄 Migration Guide

### Untuk Update View yang Ada:

#### 1. **Ganti Layout**
```blade
<!-- OLD -->
@extends('layouts.adminlte')

<!-- NEW -->
@extends('layouts.tabler')
```

#### 2. **Update Section Names**
```blade
<!-- OLD -->
@section('title')
@section('page-bar')
@section('contents')
@section('javascript')

<!-- NEW -->
@section('title', 'Page Title')  // inline style
@section('page-header')
@section('content')  // singular
@section('scripts')
```

#### 3. **Update Bootstrap Classes**
```blade
<!-- OLD (Bootstrap 4) -->
mr-2    → me-2
ml-2    → ms-2
pr-2    → pe-2
pl-2    → ps-2
float-right → float-end
float-left  → float-start
text-right  → text-end
text-left   → text-start

<!-- Modal -->
data-toggle     → data-bs-toggle
data-dismiss    → data-bs-dismiss
data-target     → data-bs-target
```

#### 4. **Update Card Structure**
```blade
<!-- OLD AdminLTE -->
<div class="card">
    <div class="card-header">
        <h3>Title</h3>
    </div>
    <div class="card-body">
        Content
    </div>
</div>

<!-- NEW Tabler (sama, tapi bisa add card-actions) -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Title</h3>
        <div class="card-actions">
            <span class="badge bg-azure-lt">Badge</span>
        </div>
    </div>
    <div class="card-body">
        Content
    </div>
</div>
```

---

## 🎯 Components Library

### 1. **Badges**
```blade
<span class="badge bg-primary">Primary</span>
<span class="badge bg-success">Success</span>
<span class="badge bg-danger">Danger</span>
<span class="badge bg-azure-lt">Light Azure</span>
```

### 2. **Buttons**
```blade
<button class="btn btn-primary">Primary</button>
<button class="btn btn-cyan">Cyan</button>
<button class="btn btn-success">Success</button>
<button class="btn btn-sm btn-danger">Small Danger</button>
```

### 3. **Avatars**
```blade
<!-- Icon Avatar -->
<span class="avatar avatar-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <i class="fas fa-folder" style="color: white;"></i>
</span>

<!-- Image Avatar -->
<span class="avatar avatar-md" style="background-image: url(...)"></span>
```

### 4. **Empty States**
```blade
<div class="empty">
    <div class="empty-icon">
        <i class="fas fa-box-open"></i>
    </div>
    <p class="empty-title">Tidak ada data</p>
    <p class="empty-subtitle text-muted">
        Data yang Anda cari tidak ditemukan
    </p>
    <div class="empty-action">
        <a href="#" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>
            Tambah Data Baru
        </a>
    </div>
</div>
```

---

## 🔍 Navigation

### Horizontal Menu (Tabler)
Template Tabler menggunakan **horizontal navigation bar** dengan dropdown untuk submenu.

**Perbedaan dengan AdminLTE:**
- AdminLTE: Sidebar kiri (vertical)
- Tabler: Navbar atas (horizontal) dengan gradient purple

**Menu Structure:**
```
Navbar (Top)
├─ Dashboard
├─ POS / Penjualan [Hot Badge]
├─ Master Data ▼
│  ├─ Kategori
│  ├─ Produk
│  ├─ Promo
│  ├─ Supplier
│  └─ Tipe Pembelian
├─ Pembelian (Admin only)
├─ Riwayat ▼
│  ├─ Riwayat Pembelian (Admin)
│  └─ Riwayat Penjualan
├─ Cashflow
└─ Pengguna (Admin only)
```

---

## 📱 Responsive Design

Tabler menggunakan Bootstrap 5, jadi semua komponen sudah responsive:

```blade
<!-- Hide on mobile, show on desktop -->
<div class="d-none d-md-block">Desktop only</div>

<!-- Show on mobile, hide on desktop -->
<div class="d-block d-md-none">Mobile only</div>

<!-- Different columns for different screen sizes -->
<div class="col-12 col-md-6 col-lg-4">
    <!-- 12 cols on mobile, 6 on tablet, 4 on desktop -->
</div>
```

---

## 🚀 CDN Resources Used

### CSS
```html
<!-- Tabler Core -->
<link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler.min.css" rel="stylesheet"/>

<!-- Font Awesome 6 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<!-- DataTables Bootstrap 5 -->
<link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">

<!-- SweetAlert2 -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet">
```

### JavaScript
```html
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Tabler Core -->
<script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/js/tabler.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
```

---

## ✅ Checklist untuk Update Views

Untuk setiap halaman master data yang perlu diupdate:

- [ ] Ganti `@extends('layouts.adminlte')` → `@extends('layouts.tabler')`
- [ ] Update section names (`contents` → `content`, `javascript` → `scripts`)
- [ ] Ganti Bootstrap 4 classes ke Bootstrap 5
- [ ] Update modal attributes (`data-toggle` → `data-bs-toggle`)
- [ ] Update button classes jika perlu
- [ ] Test DataTables export functionality
- [ ] Test responsiveness di mobile
- [ ] Test modal open/close
- [ ] Test form submit
- [ ] Test AJAX calls (jika ada)

---

## 🎓 Resources

### Dokumentasi
- **Tabler Docs:** https://tabler.io/docs
- **Tabler Demo:** https://preview.tabler.io/
- **Bootstrap 5:** https://getbootstrap.com/docs/5.2/
- **DataTables:** https://datatables.net/

### Icons
- **Font Awesome 6:** https://fontawesome.com/icons
- **Tabler Icons:** https://tabler-icons.io/

---

## 🔮 Future Improvements

1. **Update semua halaman Master Data** ke Tabler
2. **Add Tabler Charts** untuk analytics
3. **Implement Tabler Forms** dengan validation
4. **Add Loading States** dengan Tabler spinners
5. **Implement Tabler Alerts** untuk notifications

---

## 📝 Notes

- Template AdminLTE **tetap digunakan** untuk Dashboard, POS, Cashflow, dan halaman lainnya
- Template Tabler **khusus untuk Master Data** (Kategori, Produk, Promo, Supplier, Tipe)
- Kedua template bisa **beroperasi bersama** tanpa konflik
- Navigation tetap **konsisten** di kedua template
- User session dan authentication **tidak terpengaruh**

---

**Last Updated:** {{ date('Y-m-d H:i:s') }}
**Version:** 1.0 - Initial Tabler Integration
