============================================================
DASHBOARD KULINER BUKITTINGGI - "JELAJAH RASA BUKITTINGGI"
============================================================

UTS Bahasa Pemrograman III (PHP/MySQL) - Semester 5, PTIK FTIK
UIN Sjech M. Djamil Djambek Bukittinggi
Dosen pengampu : Ahmad Zaki, S.T., M.Kom
Presentasi     : Kamis, 22 Oktober 2026


IDENTITAS MAHASISWA
------------------------------------------------------------
1. Hilman Hadi Kusuma  (NIM 2524123)
2. Muhammad Iksan      (NIM 2524132)


TEMA
------------------------------------------------------------
Dashboard Kuliner Bukittinggi. Menampilkan 5 kuliner khas
Bukittinggi. Setiap item memuat nama, foto, deskripsi singkat,
kategori, dan tautan Google Maps.

  1. Nasi Kapau Ni Lis                 (Makanan Berat)
  2. Gulai Itiak Lado Mudo Ngarai      (Makanan Berat)
  3. Ampiang Dadiah (Bofet Miun)       (Makanan Penutup)
  4. Pical Sikai                       (Makanan Berat)
  5. Kerupuk Sanjai Ummi Aufa Hakim    (Oleh-oleh)


FITUR
------------------------------------------------------------
Fitur wajib:
  - Data dinamis dari array PHP (data.php), ditampilkan
    dengan foreach.
  - Pencarian berdasarkan nama, deskripsi, atau kategori.
  - Filter kategori (daftar kategori dibuat otomatis dari data).
  - Percabangan if ... else yang menampilkan pesan
    "Kuliner Tidak Ditemukan" bila hasil kosong.
  - Tata letak responsif, navigasi mudah, tautan Google Maps aktif.

Fitur tambahan:
  - Peta Google Maps tersemat pada kartu (Collapse) dan tombol
    "Buka di Google Maps".
  - Penyorotan kata kunci pencarian dengan tag <mark>.
  - Dark mode (pilihan tema disimpan di localStorage).
  - Modal "Masuk" dengan validasi form (JavaScript + Bootstrap).
  - ScrollSpy pada navbar dan tombol kembali ke atas.
  - Ringkasan statistik (total kuliner, jumlah kategori,
    hasil ditampilkan).
  - Pengamanan keluaran dengan htmlspecialchars dan validasi
    kategori dengan in_array.
  - Gambar cadangan bila foto tidak ditemukan.


KOMPONEN BOOTSTRAP YANG DIGUNAKAN
------------------------------------------------------------
Bootstrap 5.3.2 dan Bootstrap Icons 1.11.1 (melalui CDN).

  - Navbar      : navbar, navbar-expand-lg, navbar-toggler, collapse
  - Container   : container
  - Grid System : row, col-12 col-md-6 col-lg-4, col-md-4, g-3, g-4
  - Card        : card, card-img-top, card-body, card-title, card-text
  - Button      : btn btn-danger, btn-outline-light,
                  btn-outline-secondary
  - Form        : form-control, form-select, input-group,
                  invalid-feedback, was-validated
  - Badge       : badge, rounded-pill
  - Alert       : alert alert-warning, alert alert-success
  - Modal       : modal, modal-dialog, modal-content
  - Collapse    : collapse, data-bs-toggle="collapse"
  - Ratio       : ratio ratio-16x9
  - ScrollSpy   : data-bs-spy="scroll"


STRUKTUR FOLDER
------------------------------------------------------------
UTS/
  index.php        halaman utama (logika, tampilan, JavaScript)
  data.php         data kuliner dalam array PHP
  css/
    style.css      CSS tambahan (tema, dark mode)
  img/             foto kuliner, gambar header, favicon


LANGKAH MENJALANKAN APLIKASI
------------------------------------------------------------
1. Instal dan jalankan Laragon (atau XAMPP), lalu klik
   "Start All" hingga Apache berjalan.

2. Letakkan folder UTS di folder www Laragon (umumnya
   C:\laragon\www\). Untuk XAMPP, gunakan folder htdocs.

3. Buka folder UTS di Visual Studio Code (File > Open Folder)
   bila ingin melihat atau mengubah kode.

4. Buka browser dan akses alamat berikut:

       http://localhost/UTS/index.php

5. Pastikan perangkat terhubung ke internet karena Bootstrap,
   Bootstrap Icons, dan peta Google Maps dimuat secara online.

Catatan: File PHP tidak boleh dibuka langsung dari File
Explorer. Aplikasi harus diakses melalui localhost agar kode
PHP diproses oleh server.


CATATAN
------------------------------------------------------------
- MySQL tidak digunakan (tidak diwajibkan pada UTS ini); data
  disimpan dalam array PHP.
- Dokumen penjelasan proyek beserta screenshot hasil program
  tersedia pada berkas laporan Word terpisah.
