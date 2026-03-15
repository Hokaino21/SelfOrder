# Sistem Self Order Restoran

Selamat datang! Anda telah membuat sistem **menu self-order** yang lengkap untuk sebuah restoran. Pelanggan dapat memesan makanan secara mandiri melalui antarmuka yang user-friendly.

## 🎯 Fitur Utama

### 1. **Halaman Menu** (`/menu`)
- Tampilan grid menu dengan kategori yang dapat difilter
- Setiap item menu menampilkan:
  - Nama menu
  - Deskripsi
  - Harga
  - Tombol "Tambah" untuk menambahkan ke keranjang
- Filter berdasarkan kategori (Makanan Berat, Makanan Ringan, Minuman, Dessert)
- Keranjang belanja yang dapat diinput langsung dengan tombol + dan -

### 2. **Formulir Pesanan** (`/order/create`)
- Input data pelanggan (nama, nomor telepon)
- Catatan khusus (opsional)
- Ringkasan pesanan lengkap
- Perhitungan otomatis pajak (10%)
- Total harga dihitung secara real-time

### 3. **Struk Pesanan** (`/order/{id}/receipt`)
- Menampilkan nomor pesanan unik (format: ORD-YYYYMMDD-XXXX)
- Informasi pemesan
- Detail seluruh item yang dipesan
- Total harga dengan rincian pajak
- Status pesanan saat ini
- Tombol cetak dan tracking pesanan

### 4. **Tracking Pesanan** (`/order/track/{orderNumber}`)
- Status timeline real-time:
  - ✓ Pesanan Diterima
  - ⚙️ Sedang Diproses
  - 🍽️ Sedang Disiapkan
  - ✨ Siap Diambil
  - 🎉 Selesai
- Auto-refresh setiap 10 detik untuk pesanan yang belum selesai
- Estimasi waktu tunggu

## 📱 Struktur Database

### Tabel: `menu_items`
```
- id: ID unik
- name: Nama menu
- category: Kategori (Makanan Berat, Makanan Ringan, Minuman, Dessert)
- description: Deskripsi menu
- price: Harga (decimal)
- image: Path gambar (nullable)
- is_available: Status ketersediaan
- timestamps
```

### Tabel: `orders`
```
- id: ID unik
- order_number: Nomor pesanan unik (ORD-YYYYMMDD-XXXX)
- customer_name: Nama pelanggan
- customer_phone: Nomor telepon pelanggan (nullable)
- status: Status pesanan (pending, preparing, ready, completed, cancelled)
- total_price: Total harga
- notes: Catatan khusus
- ordered_at: Waktu pemesanan
- completed_at: Waktu selesai (nullable)
- timestamps
```

### Tabel: `order_items`
```
- id: ID unik
- order_id: FK ke orders
- menu_item_id: FK ke menu_items
- quantity: Jumlah item
- price: Harga per item saat pemesanan
- notes: Catatan khusus untuk item ini
- timestamps
```

## 🎨 Desain & UX

- **Color Scheme**: Gradient ungu (dari #667eea ke #764ba2)
- **Typography**: Segoe UI untuk modern appearance
- **Styling**: Pure CSS (tidak ada framework CSS yang berat)
- **Responsive**: Fully responsive untuk desktop dan mobile
- **Animations**: Smooth transitions dan hover effects

## 🔨 Teknologi

- **Backend**: Laravel 11
- **Frontend**: Blade templates + Vanilla JavaScript
- **Database**: MySQL/MariaDB
- **Local Storage**: Untuk menyimpan keranjang belanja (client-side)

## 🚀 Cara Menggunakan

### 1. Akses Halaman Menu
```
http://localhost/c7/menu
```

### 2. Tambah Items ke Keranjang
- Klik tombol "+ Tambah" pada menu yang diinginkan
- Gunakan filter kategori untuk mempermudah pencarian
- Ubah jumlah item dalam keranjang

### 3. Checkout Pesanan
- Klik tombol "Lanjut ke Pembayaran"
- Isi data pemesan (nama, telepon)
- Tambahkan catatan khusus jika ada
- Klik "Selesaikan Pesanan" untuk konfirmasi

### 4. Lihat Status Pesanan
- Struk akan diberikan dengan nomor pesanan
- Gunakan nomor pesanan untuk tracking di `/order/track/{orderNumber}`
- Cek status secara real-time

## 📋 Menu Data yang Sudah Tersedia

### Makanan Berat
- Nasi Goreng Spesial (Rp 45.000)
- Mie Goreng (Rp 35.000)
- Nasi Kuning (Rp 40.000)
- Ayam Bakar (Rp 55.000)
- Ikan Goreng (Rp 50.000)

### Makanan Ringan
- Lumpia (Rp 20.000)
- Perkedel (Rp 15.000)
- Tahu Goreng (Rp 18.000)
- Bakso Goreng (Rp 25.000)

### Minuman
- Es Jeruk (Rp 12.000)
- Es Teh Manis (Rp 10.000)
- Es Cendol (Rp 15.000)
- Kopi Hitam (Rp 18.000)
- Susu Coklat (Rp 20.000)

### Dessert
- Pisang Goreng (Rp 22.000)
- Es Krim (Rp 18.000)
- Puding Coklat (Rp 20.000)

## 🛠️ Setup & Development

### Initial Setup
```bash
# Jalankan migrations
php artisan migrate

# Seed data menu
php artisan db:seed --class=MenuSeeder

# Start development server
php artisan serve
```

### Menambah Menu Baru
```php
// Via Tinker
php artisan tinker
>>> App\Models\MenuItem::create([
    'name' => 'Menu Baru',
    'category' => 'Makanan Berat',
    'description' => 'Deskripsi',
    'price' => 50000,
    'is_available' => true
]);
```

## 🔐 Fitur Admin (Opsional)

Untuk mengelola pesanan, Anda dapat menambahkan:

```php
// Update status pesanan
Route::post('/admin/order/{id}/status', [AdminOrderController::class, 'updateStatus']);

// Lihat semua pesanan
Route::get('/admin/orders', [AdminOrderController::class, 'index']);
```

## 💡 Tips Pengembangan

1. **Tambah Gambar Menu**: Ubah kolom `image` di menu card menjadi `<img>` tag
2. **Payment Gateway**: Integrasikan dengan Midtrans/Doku untuk pembayaran online
3. **Notification**: Gunakan Laravel Notifications untuk email/SMS konfirmasi
4. **Analytics**: Tambahkan tracking untuk melihat menu paling populer
5. **Multi-table**: Support untuk multiple table jika ingin mode "Dine-In"

## 📞 Support

Untuk pertanyaan atau masalah, silakan periksa:
- Routes: `routes/web.php`
- Controllers: `app/Http/Controllers/`
- Views: `resources/views/menu/` dan `resources/views/order/`
- Models: `app/Models/`

---

**Dibuat dengan ❤️ menggunakan Laravel**
