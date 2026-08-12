# Pemetaan Role & Permission (Hak Akses)

Dokumen ini mendefinisikan pemetaan *Role* (Peran) dan *Permission* (Hak Akses) untuk staf internal (`employees`) pada Sistem Informasi Layanan Publik BPKP Yogyakarta.

## 1. Daftar Role (Peran)
Terdapat 3 peran utama untuk staf internal:
*   **`admin`**: Administrator sistem (Superadmin).
*   **`operator`**: Staf operasional harian yang mengurus persetujuan, pendaftaran, dan fasilitas.
*   **`leader`**: Pimpinan yang membutuhkan akses pemantauan dan laporan.

---

## 2. Daftar Permission berdasarkan Modul

### A. Modul Pengguna (User Management)
*   `view_employees`: Melihat daftar staf/pegawai
*   `create_employees`: Menambahkan staf baru
*   `edit_employees`: Mengubah data staf
*   `delete_employees`: Menghapus data staf
*   `view_customers`: Melihat daftar pelanggan/peserta
*   `create_customers`: Mendaftarkan pelanggan secara manual
*   `edit_customers`: Mengubah data profil pelanggan
*   `delete_customers`: Menghapus data pelanggan

### B. Modul Pelatihan (Training Management)
*   `view_trainings`: Melihat daftar master pelatihan
*   `create_trainings`: Membuat jadwal/master pelatihan baru
*   `edit_trainings`: Mengubah detail pelatihan
*   `delete_trainings`: Menghapus pelatihan
*   **Registrasi & Kelulusan:**
    *   `view_registrations`: Melihat daftar pendaftaran pelatihan
    *   `verify_registrations`: Mengonfirmasi (`confirm`) atau menolak (`reject`) pendaftaran masuk
    *   `assess_graduations`: Menentukan status kelulusan peserta (`passed` / `failed`)
*   **Presensi & Sertifikat:**
    *   `manage_attendances`: Meng-generate dan mengedit presensi peserta
    *   `manage_certificates`: Meng-generate, melihat, dan mencabut sertifikat kelulusan

### C. Modul Fasilitas (Facility Management)
*   `view_facilities`: Melihat daftar master fasilitas/ruangan
*   `create_facilities`: Menambah fasilitas baru
*   `edit_facilities`: Mengubah harga/kapasitas fasilitas
*   `delete_facilities`: Menghapus data fasilitas
*   `view_facility_bookings`: Melihat riwayat sewa ruangan
*   `verify_facility_bookings`: Mengonfirmasi jadwal sewa fasilitas

### D. Modul Keuangan (Finance)
*   `view_invoices`: Melihat daftar tagihan/invoice
*   `create_invoices`: Membuat invoice secara manual
*   `edit_invoices`: Mengubah data invoice
*   `view_payments`: Melihat daftar bukti transfer/pembayaran yang diunggah *customer*
*   `verify_payments`: Memverifikasi (`verify` / `reject`) bukti bayar dari *customer*

---

## 3. Matriks Distribusi Permission

| Permission / Modul | `admin` | `operator` | `leader` |
| :--- | :---: | :---: | :---: |
| **Users** |
| `view_employees` | ✅ | ❌ | ❌ |
| `create/edit/delete_employees` | ✅ | ❌ | ❌ |
| `view_customers` | ✅ | ✅ | ❌ |
| `create/edit/delete_customers` | ✅ | ✅ | ❌ |
| **Trainings** |
| `view_trainings` | ✅ | ✅ | ✅ |
| `create/edit/delete_trainings`| ✅ | ✅ | ❌ |
| `view_registrations` | ✅ | ✅ | ✅ |
| `verify_registrations` | ✅ | ✅ | ❌ |
| `assess_graduations` | ✅ | ✅ | ❌ |
| `manage_attendances` | ✅ | ✅ | ❌ |
| `manage_certificates` | ✅ | ✅ | ❌ |
| **Facilities** |
| `view_facilities` | ✅ | ✅ | ✅ |
| `create/edit/delete_facilities`| ✅ | ✅ | ❌ |
| `view_facility_bookings` | ✅ | ✅ | ✅ |
| `verify_facility_bookings` | ✅ | ✅ | ❌ |
| **Finance** |
| `view_invoices` | ✅ | ✅ | ✅ |
| `create/edit/delete_invoices` | ✅ | ❌ | ❌ |
| `view_payments` | ✅ | ✅ | ✅ |
| `verify_payments` | ✅ | ✅ | ❌ |

> **Catatan:** Role `leader` secara umum difokuskan pada akses **Read-Only** (hanya melihat) untuk memantau kinerja operasional, tanpa bisa memodifikasi atau menyetujui transaksi. Role `operator` memiliki akses luas terhadap data transaksional, namun dibatasi dari tindakan sistem yang destruktif atau manajemen pengguna internal.
