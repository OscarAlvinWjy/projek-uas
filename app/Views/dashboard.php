<?php helper('text'); ?>

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
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f9f9f9;
    }

    .navbar {
      background-color: #800000;
      transition: all 0.3s ease;
    }

    .navbar-brand img {
      height: 40px;
      margin-right: 8px;
    }

    .navbar .nav-link, .navbar .navbar-brand {
      color: white !important;
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

    .text-maroon {
      color: #800000;
    }

    footer {
      background-color: #800000;
      color: white;
      padding: 30px 0;
      text-align: center;
    }

    .footer-links a {
      color: #f1f1f1;
      margin: 0 10px;
      text-decoration: none;
      font-size: 0.9rem;
    }

    .footer-links a:hover {
      text-decoration: underline;
    }

    #promoCarousel img {
  width: auto;
  max-width: 100%;
  height: auto;
  display: block;
  margin-left: auto;
  margin-right: auto;
  border-radius: 10px;
}

#promoCarousel {
  margin-top: 30px;
  margin-bottom: 50px;
}

.hero-text {
  max-width: 600px;
  margin: 0 auto;
}

  </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg sticky-top shadow-sm py-3 animate__animated animate__fadeInDown" style="font-size: 1.05rem; background-color: #800000;">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center fw-bold text-white" href="<?= base_url('/') ?>">
      <img src="<?= base_url('logo.png') ?>" alt="Logo" style="height: 50px; margin-right: 10px;"> StepUP
    </a>
    <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav align-items-center">

  <!-- Kategori Dropdown -->
  <li class="nav-item dropdown me-3">
    <a class="nav-link dropdown-toggle text-white fw-semibold" href="#" role="button" data-bs-toggle="dropdown">
      <i class="fas fa-tags me-1"></i> Kategori
    </a>
    <ul class="dropdown-menu animate__animated animate__fadeIn">
      <li><a class="dropdown-item" href="<?= base_url('/kategori/pria') ?>"><i class="fas fa-mars me-2"></i>Pria</a></li>
      <li><a class="dropdown-item" href="<?= base_url('/kategori/wanita') ?>"><i class="fas fa-venus me-2"></i>Wanita</a></li>
    </ul>
  </li>

  <!-- Tentang Kami -->
  <li class="nav-item me-3">
    <a class="nav-link text-white fw-semibold" href="<?= base_url('/tentang') ?>">
      <i class="fas fa-info-circle me-1"></i> Tentang
    </a>
  </li>

  <!-- Kontak -->
  <li class="nav-item me-3">
    <a class="nav-link text-white fw-semibold" href="<?= base_url('/kontak') ?>">
      <i class="fas fa-phone me-1"></i> Kontak
    </a>
  </li>

  <!-- Pesanan -->
  <li class="nav-item me-3">
    <a class="nav-link text-white fw-semibold" href="<?= base_url('/riwayat') ?>">
      <i class="fas fa-box me-1"></i> Pesanan
    </a>
  </li>

  <!-- Admin/User Dropdown -->
  <?php if(session()->get('logged_in')): ?>
    <li class="nav-item dropdown me-3">
      <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown">
        <i class="fas fa-user me-1"></i><?= esc(session('name')) ?>
      </a>
      <ul class="dropdown-menu dropdown-menu-end animate__animated animate__fadeIn">
        <li><a class="dropdown-item" href="<?= base_url('/riwayat') ?>"><i class="fas fa-clock-rotate-left me-2"></i>Riwayat</a></li>
        <li><a class="dropdown-item" href="<?= base_url('/logout') ?>"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
      </ul>
    </li>
  <?php else: ?>
    <li class="nav-item me-2">
      <a href="/login" class="btn btn-outline-light rounded-pill px-4">Login</a>
    </li>
    <li class="nav-item me-3">
      <a href="/register" class="btn btn-light text-maroon rounded-pill px-4">Daftar</a>
    </li>
  <?php endif; ?>

  <!-- Keranjang (lebih besar & setelah user) -->
  <li class="nav-item position-relative">
    <a href="<?= base_url('/keranjang?from=dashboard') ?>" class="nav-link text-white" style="font-size: 1.35rem;">
      <i class="fas fa-shopping-cart"></i>
      <?php $jumlah = session()->get('cart_count') ?? 0; ?>
      <?php if ($jumlah > 0): ?>
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark">
          <?= $jumlah ?>
        </span>
      <?php endif; ?>
    </a>
  </li>
</ul>

    </div>
  </div>
</nav>



<!-- PROMO CAROUSEL -->
<div id="promoCarousel" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <?php for ($i = 1; $i <= 4; $i++): ?>
      <div class="carousel-item <?= $i === 1 ? 'active' : '' ?>">
        <img src="<?= base_url('images/iklan' . $i . '.png') ?>" class="d-block w-100" alt="Promo <?= $i ?>">
      </div>
    <?php endfor; ?>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#promoCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#promoCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<!-- PRODUK -->
<section id="produk" class="py-5 bg-light">
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
              <a href="<?= base_url('/produk/' . $product['id']) ?>" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- FOOTER -->
<?= $this->include('footer') ?>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>AOS.init();</script>
</body>
</html>
