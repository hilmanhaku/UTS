<?php
// ============================================================
// Dashboard Kuliner Bukittinggi - UTS Bahasa Pemrograman III
// ============================================================
$nama_mahasiswa = "Hilman Hadi Kusuma";
$nim_mahasiswa  = "2524123";
$nama_mahasiswa_kedua = "Muhammad Iksan";
$nim_mahasiswa_kedua  = "2524132";

// Fungsi bantu: mengamankan teks sebelum ditampilkan ke HTML
function e($teks)
{
    return htmlspecialchars((string) $teks, ENT_QUOTES, 'UTF-8');
}

function highlight_search_term($teks, $kata_kunci)
{
    $teks_aman = e($teks);
    $kata_kunci_aman = e($kata_kunci);

    if ($kata_kunci_aman === '') {
        return $teks_aman;
    }

    $hasil = preg_replace_callback(
        '/' . preg_quote($kata_kunci_aman, '/') . '/iu',
        static function ($cocok) {
            return '<mark>' . $cocok[0] . '</mark>';
        },
        $teks_aman
    );

    return $hasil === null ? $teks_aman : $hasil;
}

require_once __DIR__ . '/data.php';

// Tautan Google Maps dibuat otomatis dari query_map
foreach ($kuliner_data as $i => $item) {
    $q = urlencode($item['query_map']);
    $kuliner_data[$i]['maps_link'] = $item['maps_link'] ?? "https://www.google.com/maps/search/?api=1&query=" . $q;
    $kuliner_data[$i]['embed_map'] = "https://maps.google.com/maps?q=" . $q . "&z=15&output=embed";
}

// Daftar kategori diambil otomatis dari data (tanpa menulis manual)
$daftar_kategori = array_values(array_unique(array_column($kuliner_data, 'kategori')));

// Gambar cadangan jika file foto tidak ditemukan
$fallback_img = 'data:image/svg+xml,' . rawurlencode(
    '<svg xmlns="http://www.w3.org/2000/svg" width="600" height="400"><rect width="100%" height="100%" fill="#e9ecef"/><text x="50%" y="50%" fill="#6c757d" font-family="sans-serif" font-size="26" text-anchor="middle">Foto belum tersedia</text></svg>'
);

// 2. Logika pencarian dan filter
$search   = isset($_GET['search']) ? trim($_GET['search']) : '';
$category = isset($_GET['category']) ? trim($_GET['category']) : '';

// Kategori dari URL hanya diterima jika ada di daftar
if ($category !== '' && !in_array($category, $daftar_kategori, true)) {
    $category = '';
}

$filtered_data = [];
foreach ($kuliner_data as $item) {
    $cocok_cari = $search === ''
        || mb_stripos($item['nama'], $search) !== false
        || mb_stripos($item['deskripsi'], $search) !== false
        || mb_stripos($item['kategori'], $search) !== false;

    $cocok_kategori = $category === '' || $item['kategori'] === $category;

    if ($cocok_cari && $cocok_kategori) {
        $filtered_data[] = $item;
    }
}

$total_data   = count($kuliner_data);
$total_tampil = count($filtered_data);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kuliner - Bukittinggi</title>
    <meta name="description" content="Jelajahi kuliner khas Bukittinggi, cari berdasarkan nama dan kategori, serta lihat lokasi di Google Maps.">
    <link rel="icon" type="image/svg+xml" href="img/favicon.svg">
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body data-bs-spy="scroll" data-bs-target="#navbarNav" data-bs-root-margin="0px 0px -10%" data-bs-smooth-scroll="true" tabindex="0">

<!-- HEADER, JUDUL, & FORM PENCARIAN -->
<div class="header-hero" id="beranda">
    <nav class="navbar navbar-expand-lg py-3" data-bs-theme="dark">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4 text-white d-flex align-items-center gap-2" href="index.php">
                <span>🍲</span> Jelajah Rasa Bukittinggi
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Buka menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="#beranda">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#daftar-kuliner">Kuliner</a></li>
                    <li class="nav-item"><a class="nav-link" href="#kategori-section">Cari &amp; Filter</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tentang-section">Tentang</a></li>
                </ul>
                <div class="d-flex align-items-center gap-3 mt-3 mt-lg-0">
                    <a href="#cari-input" class="text-white fs-5 text-decoration-none" title="Pencarian"><i class="bi bi-search"></i></a>
                    <button id="darkModeToggle" type="button" class="btn btn-outline-light rounded-pill px-3 fw-bold btn-sm">🌙 Dark Mode</button>
                    <a href="#" class="btn btn-light text-danger rounded-pill px-4 fw-bold btn-sm shadow-sm" data-bs-toggle="modal" data-bs-target="#loginModal">
                        <i class="bi bi-person-fill"></i> Masuk
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Judul Header -->
    <div class="container text-center my-4">
        <h1 class="display-5 header-title mb-2">Dashboard Kuliner Khas</h1>
        <p class="lead header-subtitle m-0">Temukan cita rasa otentik dan legendaris dari Kota Jam Gadang</p>
    </div>

    <!-- Form pencarian & filter -->
    <div id="kategori-section" class="container search-wrapper mt-4">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <form action="index.php" method="GET" class="d-flex flex-column flex-md-row gap-2 p-3 glass-panel shadow-lg align-items-center">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-0 text-muted ps-2"><i class="bi bi-search"></i></span>
                        <input id="cari-input" type="text" name="search" class="form-control bg-transparent border-0 shadow-none"
                               placeholder="Cari nama, deskripsi, atau kategori..." value="<?= e($search) ?>" aria-label="Kata kunci pencarian">
                    </div>
                    <select name="category" class="form-select bg-transparent border-0 shadow-none w-auto fw-semibold" aria-label="Filter kategori" onchange="this.form.submit()">
                        <option value="">Semua Kategori</option>
                        <?php foreach ($daftar_kategori as $kat): ?>
                            <option value="<?= e($kat) ?>" <?= $category === $kat ? 'selected' : '' ?>><?= e($kat) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn btn-danger px-3 fw-bold shadow-sm rounded-3">Cari</button>
                    <a href="index.php" class="btn btn-outline-secondary shadow-sm rounded-3 px-3">Reset</a>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- KONTEN KULINER UTAMA -->
<div id="daftar-kuliner" class="container my-5 pt-3">

    <div class="d-flex flex-wrap justify-content-center align-items-center gap-2 mb-4" aria-live="polite">
        <span class="badge rounded-pill bg-danger px-3 py-2">
            Menampilkan <?= $total_tampil ?> dari <?= $total_data ?> kuliner
        </span>
        <?php if ($search !== ''): ?>
            <span class="badge rounded-pill bg-secondary px-3 py-2">Kata kunci: <?= e($search) ?></span>
        <?php endif; ?>
        <?php if ($category !== ''): ?>
            <span class="badge rounded-pill bg-secondary px-3 py-2">Kategori: <?= e($category) ?></span>
        <?php endif; ?>
    </div>

    <div class="row g-3 mb-4" aria-label="Ringkasan dashboard kuliner">
        <div class="col-12 col-md-4">
            <div class="glass-panel summary-card h-100 p-3">
                <i class="bi bi-grid-3x3-gap-fill text-danger fs-4" aria-hidden="true"></i>
                <div class="summary-count fs-2 fw-bold"><?= $total_data ?></div>
                <div class="fw-semibold">Total kuliner</div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="glass-panel summary-card h-100 p-3">
                <i class="bi bi-tags-fill text-danger fs-4" aria-hidden="true"></i>
                <div class="summary-count fs-2 fw-bold"><?= count($daftar_kategori) ?></div>
                <div class="fw-semibold">Kategori</div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="glass-panel summary-card h-100 p-3">
                <i class="bi bi-funnel-fill text-danger fs-4" aria-hidden="true"></i>
                <div class="summary-count fs-2 fw-bold"><?= $total_tampil ?></div>
                <div class="fw-semibold">Hasil ditampilkan</div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <?php if ($total_tampil > 0): ?>
            <?php foreach ($filtered_data as $index => $item): ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 glass-panel kuliner-card border-0 overflow-hidden">
                        <img src="<?= e($item['foto']) ?>" class="card-img-top" alt="<?= e($item['nama']) ?>"
                             style="height: 230px; object-fit: cover; object-position: center;"
                             onerror="this.onerror=null;this.src='<?= $fallback_img ?>';">

                        <div class="card-body d-flex flex-column p-4">
                            <h5 class="card-title fw-bold fs-4 mb-2"><?= highlight_search_term($item['nama'], $search) ?></h5>
                            <span class="badge bg-danger mb-3 align-self-start py-2 px-3 rounded-pill"><?= e($item['kategori']) ?></span>
                            <p class="card-text text-muted" style="font-size: 0.95rem; line-height: 1.6;"><?= highlight_search_term($item['deskripsi'], $search) ?></p>

                            <div class="mt-auto pt-2">
                                <button class="btn btn-danger w-100 rounded-pill fw-bold mb-2 shadow-sm py-2" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseMap<?= $index ?>"
                                        aria-expanded="false" aria-controls="collapseMap<?= $index ?>">
                                    🗺️ Tampilkan Peta Lokasi
                                </button>

                                <div class="collapse" id="collapseMap<?= $index ?>">
                                    <div class="ratio ratio-16x9 mb-2 shadow-sm rounded-4 overflow-hidden border border-danger mt-2">
                                        <iframe src="<?= e($item['embed_map']) ?>" title="Peta <?= e($item['nama']) ?>" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                    </div>
                                    <a href="<?= e($item['maps_link']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-outline-secondary btn-sm w-100 rounded-pill py-2">↗️ Buka di Google Maps</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-warning glass-panel border-0 p-5 text-center shadow" role="alert">
                    <h3 class="alert-heading fw-bold mb-3">😕 Kuliner Tidak Ditemukan</h3>
                    <p class="fs-5">Tidak ada kuliner yang cocok dengan pencarian atau filter yang dipilih. Coba kata kunci lain atau pilih "Semua Kategori".</p>
                    <hr class="my-4">
                    <a href="index.php" class="btn btn-warning btn-lg fw-bold rounded-pill shadow-sm">Tampilkan Semua Kuliner</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- FOOTER / TENTANG -->
<footer id="tentang-section" class="footer-glass py-4 text-center mt-5 shadow-lg">
    <div class="container">
        <h4 class="fw-bold text-danger mb-2">🍲 Jelajah Rasa Bukittinggi</h4>
        <p class="mb-3 text-muted">Direktori kuliner khas Bukittinggi dengan pencarian, filter kategori, dan peta lokasi.</p>
        <hr class="border-secondary opacity-25 w-75 mx-auto">
        <small class="text-muted fw-semibold">
            &copy; <?= date('Y') ?> Dashboard Kuliner Bukittinggi.
            Dikembangkan oleh <?= e($nama_mahasiswa) ?> (<?= e($nim_mahasiswa) ?>) dan <?= e($nama_mahasiswa_kedua) ?> (<?= e($nim_mahasiswa_kedua) ?>) &ndash; UTS Bahasa Pemrograman III, PTIK UIN Sjech M. Djamil Djambek Bukittinggi.
        </small>
    </div>
</footer>

<button id="backToTop" class="btn btn-danger rounded-circle back-to-top shadow" type="button" aria-label="Kembali ke atas" title="Kembali ke atas" hidden>
    <i class="bi bi-arrow-up" aria-hidden="true"></i>
</button>

<!-- Modal Masuk (simulasi + validasi form dengan JavaScript) -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content glass-panel p-3">
      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold" id="loginTitle">Masuk ke Akun</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <form id="loginForm" novalidate>
          <div class="mb-3">
            <label for="loginEmail" class="form-label">Email</label>
            <input type="email" id="loginEmail" class="form-control" placeholder="nama@email.com" required>
            <div class="invalid-feedback">Masukkan alamat email yang valid.</div>
          </div>
          <div class="mb-3">
            <label for="loginPass" class="form-label">Kata sandi</label>
            <input type="password" id="loginPass" class="form-control" placeholder="Minimal 6 karakter" minlength="6" required>
            <div class="invalid-feedback">Kata sandi minimal 6 karakter.</div>
          </div>
          <div id="loginSukses" class="alert alert-success d-none py-2">Validasi berhasil.</div>
          <button type="submit" class="btn btn-danger w-100 fw-bold rounded-pill">Masuk</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // ---- Navbar scroll tracking and back-to-top button ----
    const backToTopBtn = document.getElementById('backToTop');
    const scrollSpy = bootstrap.ScrollSpy.getOrCreateInstance(document.body);

    function syncActiveNavLink() {
        const nearTop = window.scrollY <= 1;
        const atBottom = window.innerHeight + window.scrollY >= document.documentElement.scrollHeight - 2;
        const links = [...document.querySelectorAll('#navbarNav .nav-link')];
        const activationLine = window.scrollY + window.innerHeight * 0.25;
        const currentSection = links
            .map((link) => {
                const section = document.querySelector(link.getAttribute('href'));
                return section
                    ? { href: link.getAttribute('href'), top: section.getBoundingClientRect().top + window.scrollY }
                    : null;
            })
            .filter((section) => section && section.top <= activationLine)
            .sort((a, b) => a.top - b.top)
            .pop();
        const activeTarget = nearTop
            ? '#beranda'
            : (atBottom ? '#tentang-section' : (currentSection ? currentSection.href : '#beranda'));

        links.forEach((link) => link.classList.toggle('active', link.getAttribute('href') === activeTarget));
    }

    function updateScrollControls() {
        backToTopBtn.hidden = window.scrollY < 300;
        scrollSpy.refresh();
        syncActiveNavLink();
    }

    window.addEventListener('scroll', () => {
        backToTopBtn.hidden = window.scrollY < 300;
        window.requestAnimationFrame(syncActiveNavLink);
    }, { passive: true });

    window.addEventListener('resize', () => scrollSpy.refresh());
    backToTopBtn.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
    updateScrollControls();

    // ---- Mode gelap/terang (preferensi disimpan di browser) ----
    const toggleBtn = document.getElementById('darkModeToggle');

    function setDark(aktif) {
        document.body.classList.toggle('dark-mode', aktif);
        toggleBtn.innerHTML = aktif ? '☀️ Light Mode' : '🌙 Dark Mode';
        toggleBtn.classList.toggle('btn-outline-warning', aktif);
        toggleBtn.classList.toggle('btn-outline-light', !aktif);
    }

    try { setDark(localStorage.getItem('tema') === 'gelap'); } catch (err) { setDark(false); }

    toggleBtn.addEventListener('click', () => {
        const aktif = !document.body.classList.contains('dark-mode');
        setDark(aktif);
        try { localStorage.setItem('tema', aktif ? 'gelap' : 'terang'); } catch (err) {}
    });

    // ---- Validasi form login ----
    const loginForm = document.getElementById('loginForm');
    const loginSukses = document.getElementById('loginSukses');

    loginForm.addEventListener('submit', (ev) => {
        ev.preventDefault();
        loginSukses.classList.add('d-none');
        loginForm.classList.add('was-validated');
        if (loginForm.checkValidity()) {
            loginSukses.classList.remove('d-none');
        }
    });

    document.getElementById('loginModal').addEventListener('hidden.bs.modal', () => {
        loginForm.reset();
        loginForm.classList.remove('was-validated');
        loginSukses.classList.add('d-none');
    });
</script>
</body>
</html>
