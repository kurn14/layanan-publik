# Rencana Implementasi: Frontend Layanan (Pendaftaran Pelatihan & Pemesanan Fasilitas)

Rencana ini memuat langkah-langkah untuk membangun antarmuka publik/klien (frontend) menggunakan stack TALL (Tailwind, Alpine, Laravel, Livewire) agar klien dapat mendaftar pelatihan dan memesan fasilitas secara mandiri sesuai dengan PRD. Pendekatan yang digunakan adalah **Halaman Publik / Landing Page Murni (Livewire Kustom)**.

## ⚠️ Perubahan Arsitektur (Berdasarkan Feedback Terbaru)
1. **Halaman Detail**: Sebelum mendaftar atau memesan, pengguna harus melihat halaman detail pelatihan/fasilitas terlebih dahulu. Tombol pemesanan/pendaftaran diletakkan di halaman detail ini, tidak lagi di halaman daftar (list).
2. **Unifikasi Registrasi Customer (dengan Password)**: Proses pendaftaran pelatihan dan pemesanan fasilitas harus menggunakan form UI registrasi yang sama (menangkap data Pelanggan/Customer). Pada saat form diisi, ditambahkan kolom **Password** dan **Konfirmasi Password** agar user langsung terdaftar ke tabel `customers` dan memiliki akun untuk login. Setelah itu baru diteruskan ke pencatatan transaksi (`registrations` atau `facility_bookings`).
3. **Dashboard Pelanggan**: Menambahkan halaman Dashboard khusus Pelanggan setelah mereka berhasil login. Dashboard ini akan menampilkan Profil, Riwayat Pelatihan, dan Riwayat Pemesanan Fasilitas.

## Proposed Changes (Pendekatan: Halaman Publik / Landing Page Murni)

Berikut adalah rancangan pembuatan halaman publik menggunakan komponen Livewire standar dan layout Tailwind CSS kustom.

### 1. Struktur Layout & Konfigurasi
- **[MODIFY] `resources/views/layouts/app.blade.php`**: Layout utama publik menggunakan Tailwind CSS.
- **[MODIFY] `tailwind.config.js` & `vite.config.js`**: Memastikan aset frontend dikompilasi dengan benar.

### 2. Modul Beranda (Home / Landing Page)
- **[MODIFY] `app/Livewire/Frontend/Home.php` & view**: Menyesuaikan tautan tombol aksi agar mengarah ke halaman Detail, bukan langsung ke halaman form registrasi.

### 3. Modul Frontend Pelatihan (Training)
- **[MODIFY] `app/Livewire/Frontend/Trainings/TrainingList.php` & view**: Tombol diubah menjadi "Lihat Detail Pelatihan".
- **[NEW] `app/Livewire/Frontend/Trainings/TrainingDetail.php` & view**: Halaman detail yang menampilkan deskripsi lengkap, jadwal, syarat, dan kuota. Terdapat tombol "Daftar Pelatihan" di sini.
- **[MODIFY] `app/Livewire/Frontend/Trainings/TrainingRegistration.php` & view**: Komponen form pendaftaran Livewire. Akan direfaktor untuk menggunakan form standar registrasi `Customer` **(termasuk Password & Konfirmasi Password)** dan otomatis membuat/mencari *record* di tabel `customers` menggunakan NIK sebelum mencatat ke tabel `registrations`.

### 4. Modul Frontend Fasilitas (Facility)
- **[MODIFY] `app/Livewire/Frontend/Facilities/FacilityList.php` & view**: Tombol diubah menjadi "Lihat Detail Fasilitas".
- **[NEW] `app/Livewire/Frontend/Facilities/FacilityDetail.php` & view**: Halaman detail yang menampilkan galeri foto lengkap, deskripsi, harga, dan kapasitas. Terdapat tombol "Pesan Fasilitas" di sini.
- **[MODIFY] `app/Livewire/Frontend/Facilities/FacilityBooking.php` & view**: Komponen formulir pemesanan. Akan direfaktor menggunakan form standar registrasi `Customer` yang identik dengan pendaftaran pelatihan **(termasuk Password & Konfirmasi Password)**, lalu mencatat pemesanan ke tabel `facility_bookings`.

### 5. Modul Dashboard Pelanggan (Customer Dashboard)
- **[NEW] `app/Livewire/Frontend/Customer/Dashboard.php` & view**: Halaman area member khusus `Customer`. Memiliki 3 tab atau bagian:
  1. **Profil**: Menampilkan data diri pelanggan.
  2. **Histori Pelatihan**: Menampilkan daftar pelatihan yang pernah/sedang diikuti berserta statusnya.
  3. **Histori Fasilitas**: Menampilkan daftar pemesanan fasilitas berserta statusnya.

### 6. Routing
- **[MODIFY] `routes/web.php`**: Menambahkan *route* detail publik:
  - `/` -> `Home`
  - `/pelatihan` -> `TrainingList`
  - **[NEW]** `/pelatihan/{training}` -> `TrainingDetail`
  - `/pelatihan/{training}/daftar` -> `TrainingRegistration`
  - `/fasilitas` -> `FacilityList`
  - **[NEW]** `/fasilitas/{facility}` -> `FacilityDetail`
  - `/fasilitas/{facility}/pesan` -> `FacilityBooking`
  - **[NEW]** `/dashboard` -> `Dashboard` (Dilindungi dengan middleware `auth:customer`)

---

## ✅ Verification Plan

1. **Uji Halaman Detail**: Memastikan pengunjung diarahkan ke halaman detail pelatihan dan fasilitas saat mengklik tautan dari daftar.
2. **Uji Pembuatan Customer & Autentikasi**: Melakukan pendaftaran/pemesanan sambil mengisi Password. Pastikan data tersimpan di tabel `customers` (password terenkripsi) dan user bisa login menggunakan kredensial tersebut.
3. **Uji Pembuatan Transaksi**: Memastikan pesanan pelatihan dan fasilitas tersimpan ke tabel `registrations` dan `facility_bookings` yang terikat pada `customer_id`.
4. **Uji Dashboard Pelanggan**: Mengakses `/dashboard` sebagai pelanggan yang login, lalu memeriksa apakah Profil, Riwayat Pelatihan, dan Riwayat Fasilitas muncul dengan akurat.
5. **Validasi Aturan Bisnis**: Memastikan validasi kuota penuh (pelatihan) dan tumpang tindih tanggal (fasilitas) tetap berjalan dengan lancar.
