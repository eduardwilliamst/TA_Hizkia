# List CRUD Pembelian - Implementasi Lengkap

## Status Implementasi: ✅ SELESAI

Telah dibuat halaman **Riwayat Pembelian** yang lengkap dengan fitur CRUD, detail produk, dan integrasi LoaderUtil & SweetAlert.

---

## 📋 Fitur yang Diimplementasi

### ✅ 1. List Riwayat Pembelian
- Tabel dengan DataTables
- Export Excel & PDF
- Pagination (20 item per halaman)
- Sorting & Search
- Responsive design

### ✅ 2. Informasi Lengkap
- ID Pembelian
- Tanggal Pesan
- Nama Supplier
- Tipe Pembelian (badge dengan gradient)
- Detail Produk (expandable/collapsible)
- Total Pembelian (calculated real-time)

### ✅ 3. Detail Produk (Collapsible)
- Nama Produk
- Harga Beli per unit
- Jumlah (dengan badge)
- Subtotal per item
- Dapat di-expand/collapse per pembelian

### ✅ 4. Action Buttons
- **View Detail**: Modal dengan informasi lengkap
- **Delete**: Dengan konfirmasi SweetAlert + Loader

### ✅ 5. Modal Detail Lengkap
- Informasi Pembelian (Tanggal, Supplier, Tipe, Total)
- Tabel Detail Produk (Nama, Harga, Qty, Subtotal)
- Informasi Supplier (Nama, Telepon, Alamat)
- Styling modern dengan gradient header

### ✅ 6. Empty State
- Pesan friendly jika belum ada data
- Button untuk tambah pembelian pertama

---

## 📁 File yang Dibuat/Dimodifikasi

### 1. Controller
**File**: `app/Http/Controllers/PembelianController.php`

**Method yang Diupdate**:
```php
// List dengan pagination dan eager loading
public function listData()
{
    $pembelians = Pembelian::with(['supplier', 'tipe', 'detils.produk'])
        ->orderBy('created_at', 'desc')
        ->paginate(20);

    return view('pembelian.list', compact('pembelians'));
}

// Show detail untuk modal
public function show($id)
{
    $pembelian = Pembelian::with(['supplier', 'tipe', 'detils.produk'])->findOrFail($id);

    // Calculate total
    $total = $pembelian->detils->sum(function($detil) {
        return $detil->harga * $detil->jumlah;
    });

    return view('pembelian.show', compact('pembelian', 'total'));
}
```

### 2. View List
**File**: `resources/views/pembelian/list.blade.php`

**Features**:
- Modern card layout dengan gradient header
- DataTable dengan export Excel/PDF
- Collapsible detail produk per pembelian
- Action buttons (View, Delete)
- LoaderUtil untuk loading state
- SweetAlert untuk error handling
- Pagination
- Empty state dengan call-to-action

**Key Components**:
```blade
<!-- Expandable Product Details -->
<button class="btn btn-sm btn-info" type="button" data-toggle="collapse"
    data-target="#detil{{ $pembelian->idpembelian }}">
    <i class="fas fa-eye mr-1"></i> Lihat Detail ({{ $pembelian->detils->count() }} item)
</button>
<div class="collapse mt-2" id="detil{{ $pembelian->idpembelian }}">
    <!-- Product detail table -->
</div>

<!-- Calculate Total Real-time -->
@php
    $total = $pembelian->detils->sum(function($detil) {
        return $detil->harga * $detil->jumlah;
    });
@endphp
```

### 3. View Detail Modal
**File**: `resources/views/pembelian/show.blade.php` (NEW)

**Sections**:
1. **Header**: Gradient background dengan ID pembelian
2. **Informasi Pembelian**:
   - Tanggal Pesan
   - Supplier
   - Tipe Pembelian
   - Jumlah Item
   - Total Pembelian
   - Waktu Dibuat
3. **Detail Produk**:
   - Tabel lengkap dengan numbering
   - Nama Produk & Barcode
   - Harga Beli
   - Jumlah (badge)
   - Subtotal
   - **Footer Total** (sum of all subtotals)
4. **Informasi Supplier**:
   - Nama
   - Telepon
   - Alamat

### 4. Sidebar Menu
**File**: `resources/views/layouts/adminlte.blade.php`

**Menu Update**:
```blade
<!-- Pembelian (Stock In) dengan Submenu -->
<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-dolly"></i>
        <p>Pembelian <i class="right fas fa-angle-left"></i></p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('pembelian.index') }}">
                <p>Tambah Pembelian</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('pembelian.listData') }}">
                <p>Riwayat Pembelian</p>
            </a>
        </li>
    </ul>
</li>
```

---

## 🎨 Design Features

### 1. Color Scheme
- **Primary**: #667eea (Gradient purple)
- **Success**: #11998e (Total amount)
- **Info**: #4facfe (Type badge)
- **Danger**: #eb3349 (Delete button)
- **Gray**: #666 (Secondary text)

### 2. Typography
- Headers: 600-700 weight
- Body: 500 weight
- Currency: 700 weight, larger size
- Small text: 0.85rem

### 3. Badges & Tags
- Gradient backgrounds for type
- Rounded corners (8px)
- Icon integration
- Badge sizing: 0.4rem padding

### 4. Cards
- Border: #e3e6f0
- Border-radius: 10px
- Box-shadow: subtle
- Header background: #f8f9fc

### 5. Tables
- Hover effect on rows
- Alternating header colors
- Sticky footer for totals
- Responsive overflow

---

## 💻 JavaScript Features

### 1. DataTable Configuration
```javascript
$('#pembelianTable').DataTable({
    dom: 'Bfrtip',
    buttons: ['excel', 'pdf'],
    order: [[0, 'desc']],
    pageLength: 20,
    language: {
        // Indonesian translations
    }
});
```

### 2. View Detail with Loader
```javascript
function viewDetail(pembelianId) {
    LoaderUtil.show('Memuat detail pembelian...');

    $.ajax({
        type: 'GET',
        url: '/pembelian/' + pembelianId,
        success: function(data) {
            LoaderUtil.hide();
            $('#detailContent').html(data);
            $('#detailModal').modal('show');
        },
        error: function(xhr) {
            LoaderUtil.hide();
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Gagal memuat detail pembelian'
            });
        }
    });
}
```

### 3. Delete with Confirmation
Uses global `confirmDelete()` function with LoaderUtil integration.

---

## 🗂️ Data Structure

### Relationships Loaded (Eager Loading):
```php
Pembelian::with(['supplier', 'tipe', 'detils.produk'])
```

**Models**:
- `Pembelian` (Main)
  - `supplier` → Supplier model
  - `tipe` → Tipe model
  - `detils` → PembelianDetil model
    - `produk` → Produk model

### Calculated Fields:
```php
$total = $pembelian->detils->sum(function($detil) {
    return $detil->harga * $detil->jumlah;
});
```

---

## 📱 Responsive Design

### Breakpoints:
- **Desktop**: Full table view
- **Tablet**: Horizontal scroll for table
- **Mobile**: Stacked cards (DataTable responsive)

### Features:
- Overflow-x auto for tables
- Container-fluid for full width
- Responsive buttons
- Mobile-friendly modals

---

## 🚀 User Flow

### View List:
1. User navigates to "Pembelian" → "Riwayat Pembelian" di sidebar
2. Table loads dengan semua riwayat pembelian
3. Can search, sort, export

### View Collapsed Details:
1. Click "Lihat Detail (X item)" button
2. Collapse expands showing product table
3. Shows: Product name, price, qty, subtotal

### View Full Detail Modal:
1. Click orange "Eye" icon button
2. LoaderUtil shows "Memuat detail..."
3. AJAX loads detail from `/pembelian/{id}`
4. Modal opens with complete information
5. Close button to dismiss

### Delete:
1. Click red "Trash" icon button
2. SweetAlert confirmation dialog
3. LoaderUtil shows "Menghapus data..."
4. Success/Error notification
5. Page reloads

---

## ✅ Testing Checklist

- [x] List pembelian loads correctly
- [x] DataTable sorting works
- [x] DataTable search works
- [x] Export Excel works
- [x] Export PDF works
- [x] Pagination works
- [x] Collapsible details work
- [x] View detail modal loads
- [x] Modal shows correct data
- [x] Delete confirmation works
- [x] Loader shows during AJAX
- [x] Error handling works
- [x] Empty state shows
- [x] Responsive on mobile
- [x] Sidebar menu active state
- [x] Total calculation correct

---

## 📊 Performance

- **Eager Loading**: Prevents N+1 queries
- **Pagination**: Only 20 records per page
- **Lazy Modal Loading**: Detail only loaded on demand
- **Indexed Columns**: created_at for fast sorting
- **Caching**: Browser caches assets (JS/CSS)

---

## 🎯 Benefits

1. **Better UX**: User can see purchase history at a glance
2. **Detailed Info**: Expandable sections prevent clutter
3. **Easy Export**: Excel/PDF for reporting
4. **Fast Search**: DataTable integration
5. **Clear Feedback**: Loader & SweetAlert
6. **Organized Menu**: Submenu structure
7. **Responsive**: Works on all devices
8. **Consistent Design**: Matches existing UI

---

## 📝 Notes

1. **Route**: `/pembelian/listData` → `pembelian.listData`
2. **Permission**: Currently no role restriction (dapat diakses semua user)
3. **Delete Action**: Restores stock when deleted (handled in controller)
4. **HPP Calculation**: Recalculated when delete/edit (in controller)
5. **Cash Flow**: Created when purchase saved (in controller)

---

**Implementasi Selesai**: 2026-01-15
**Developer**: Claude Sonnet 4.5
**Status**: ✅ Production Ready
