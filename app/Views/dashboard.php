<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Dashboard - StepUP</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSS & AOS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f8f9fa;
      margin: 0;
      padding: 0;
    }

    .navbar {
      background-color: #800000;
    }

    .navbar-brand img {
      height: 40px;
      margin-right: 8px;
    }

    .navbar .nav-link, .navbar .navbar-brand {
      color: white !important;
    }

    .card-hover:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.2);
      transition: 0.3s ease-in-out;
    }

    .btn-maroon {
      background-color: #800000;
      color: white;
    }

    .btn-maroon:hover {
      background-color: #660000;
    }

    .btn-outline-maroon {
      border: 2px solid #800000;
      color: #800000;
      background-color: transparent;
    }

    .btn-outline-maroon:hover {
      background-color: #800000;
      color: #fff;
    }
  </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg sticky-top">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center fw-bold text-white" href="<?= base_url('/') ?>">
      <img src="<?= base_url('logo.png') ?>" alt="Logo" class="me-2"> StepUP
    </a>

    <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav align-items-center">
        <!-- Ikon keranjang -->
        <li class="nav-item me-3 position-relative">
          <a href="<?= base_url('/keranjang') ?>" class="nav-link text-white">
            <i class="fas fa-shopping-cart"></i>
            <?php $jumlah = session()->get('cart_count') ?? 0; ?>
            <?php if ($jumlah > 0): ?>
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark">
                <?= $jumlah ?>
              </span>
            <?php endif; ?>
          </a>
        </li>

        <!-- Dropdown user -->
        <?php if(session()->get('logged_in')): ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown">
              <?= esc(session('name')) ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="<?= base_url('/transaksi') ?>">Riwayat Transaksi</a></li>
              <li><a class="dropdown-item" href="<?= base_url('/logout') ?>">Logout</a></li>
            </ul>
          </li>
        <?php else: ?>
          <li class="nav-item me-2">
            <a href="/login" class="btn btn-outline-light rounded-pill px-4">Login</a>
          </li>
          <li class="nav-item">
            <a href="/register" class="btn btn-light text-maroon rounded-pill px-4">Daftar</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<!-- KONTEN DASHBOARD -->
<section class="py-5">
  <div class="container">
    <h2 class="fw-bold">
      Selamat Datang, <?= session()->get('name') ?? 'Pengunjung' ?>!
    </h2>
</section>

<?php helper('text'); ?>

<!-- SEMUA PRODUK -->
<section class="py-5 bg-light">
  <div class="container">
    <h2 class="text-center mb-4" data-aos="fade-up">Semua Produk</h2>
    <div class="row g-4">
      <?php foreach ($products as $i => $product): ?>
        <div class="col-md-3" data-aos="<?= $i % 2 === 0 ? 'fade-right' : 'fade-left' ?>" data-aos-delay="<?= $i * 100 ?>">
          <div class="card shadow-sm h-100 rounded-4">
            <img src="<?= base_url('images/' . $product['image']) ?>" class="card-img-top rounded-top-4" alt="<?= $product['name'] ?>">
            <div class="card-body">
              <h5 class="card-title"><?= esc($product['name']) ?></h5>
              <p class="card-text small text-muted"><?= esc(word_limiter($product['description'], 10)) ?></p>
              <p class="card-text fw-bold text-maroon">Rp <?= number_format($product['price'], 0, ',', '.') ?></p>
              <p class="card-text"><small>Stok: <?= $product['stock'] ?></small></p>
              <a href="#" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>


<!-- FOOTER -->
<?= view('footer') ?>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>AOS.init();</script>
</body>
</html>
