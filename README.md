# Hilman Hadi Kusuma (2524123) lupa upload laporannya ke e-campus pak
# Dashboard Kuliner Bukittinggi — "Jelajah Rasa Bukittinggi"

UTS Bahasa Pemrograman III (PHP/MySQL) — Semester 5, PTIK FTIK
UIN Sjech M. Djamil Djambek Bukittinggi
Dosen pengampu: Ahmad Zaki, S.T., M.Kom
Presentasi: Kamis, 22 Oktober 2026

## Identitas Mahasiswa

| Nama | NIM |
|---|---|
| Hilman Hadi Kusuma | 2524123 |
| Muhammad Iksan | 2524132 |

## Tema

**Dashboard Kuliner Bukittinggi** — menampilkan 5 kuliner khas Bukittinggi. Setiap item memuat nama, foto, deskripsi singkat, kategori, dan tautan Google Maps.

| No | Kuliner | Kategori |
|---|---|---|
| 1 | Nasi Kapau Ni Lis | Makanan Berat |
| 2 | Gulai Itiak Lado Mudo Ngarai | Makanan Berat |
| 3 | Ampiang Dadiah (Bofet Miun) | Makanan Penutup |
| 4 | Pical Sikai | Makanan Berat |
| 5 | Kerupuk Sanjai Ummi Aufa Hakim | Oleh-oleh |

## Fitur

**Fitur wajib**
- Data dinamis dari array PHP (`data.php`) dan ditampilkan dengan `foreach`.
- Pencarian berdasarkan nama, deskripsi, atau kategori.
- Filter kategori (daftar kategori dibuat otomatis dari data).
- Percabangan `if ... else` yang menampilkan pesan "Kuliner Tidak Ditemukan" bila hasil kosong.
- Tata letak responsif, navigasi mudah, dan tautan Google Maps aktif.

**Fitur tambahan**
- Peta Google Maps tersemat pada kartu (Collapse) dan tombol "Buka di Google Maps".
- Penyorotan kata kunci pencarian dengan `<mark>`.
- Dark mode (pilihan tema disimpan di localStorage).
- Modal "Masuk" dengan validasi form (JavaScript dan Bootstrap).
- ScrollSpy pada navbar dan tombol kembali ke atas.
- Ringkasan statistik (total kuliner, jumlah kategori, hasil ditampilkan).
- Pengamanan keluaran dengan `htmlspecialchars` dan validasi kategori dengan `in_array`.
- Gambar cadangan bila foto tidak ditemukan.

## Komponen Bootstrap yang Digunakan

Bootstrap 5.3.2 dan Bootstrap Icons 1.11.1 (melalui CDN).

| Komponen | Kelas / Atribut | Dipakai pada |
|---|---|---|
| Navbar | `navbar`, `navbar-expand-lg`, `navbar-toggler`, `collapse` | Menu navigasi |
| Container | `container` | Seluruh bagian halaman |
| Grid System | `row`, `col-12 col-md-6 col-lg-4`, `col-md-4`, `g-3`, `g-4` | Kartu kuliner dan ringkasan |
| Card | `card`, `card-img-top`, `card-body`, `card-title`, `card-text` | Kartu kuliner |
| Button | `btn btn-danger`, `btn-outline-light`, `btn-outline-secondary` | Cari, Reset, Peta, Dark Mode, Masuk |
| Form | `form-control`, `form-select`, `input-group`, `invalid-feedback`, `was-validated` | Pencarian, filter, form masuk |
| Badge | `badge`, `rounded-pill` | Kategori dan jumlah hasil |
| Alert | `alert alert-warning`, `alert alert-success` | Pesan data tidak ditemukan dan validasi berhasil |
| Modal | `modal`, `modal-dialog`, `modal-content` | Form masuk |
| Collapse | `collapse`, `data-bs-toggle="collapse"` | Peta lokasi pada kartu |
| Ratio | `ratio ratio-16x9` | Peta tersemat |
| ScrollSpy | `data-bs-spy="scroll"` | Penanda menu aktif |

## Struktur Folder

```
UTS/
├── index.php        # halaman utama (logika, tampilan, JavaScript)
├── data.php         # data kuliner dalam array PHP
├── css/
│   └── style.css    # CSS tambahan (tema, dark mode)
└── img/             # foto kuliner, gambar header, favicon
```

## Langkah Menjalankan Aplikasi

1. Instal dan jalankan **Laragon** (atau XAMPP), lalu klik **Start All** hingga Apache berjalan.
2. Letakkan folder `UTS` di folder `www` Laragon (umumnya `C:\laragon\www\`). Untuk XAMPP, gunakan folder `htdocs`.
3. Buka folder `UTS` di **Visual Studio Code** (File, Open Folder) bila ingin melihat atau mengubah kode.
4. Buka browser dan akses:

   ```
   http://localhost/UTS/index.php
   ```

5. Pastikan perangkat terhubung ke internet karena Bootstrap, Bootstrap Icons, dan peta Google Maps dimuat secara online.

> File PHP tidak boleh dibuka langsung dari File Explorer. Aplikasi harus diakses melalui `localhost` agar kode PHP diproses oleh server.

## Catatan

- MySQL tidak digunakan (tidak diwajibkan pada UTS ini); data disimpan dalam array PHP.
- Dokumen penjelasan proyek beserta screenshot hasil program tersedia pada berkas laporan Word terpisah.
