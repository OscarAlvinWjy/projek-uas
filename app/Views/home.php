<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>StepUP - Toko Sepatu</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
    }

    .hero {
      position: relative;
      height: 80vh;
      background: url("<?= base_url('logo.png') ?>") no-repeat center center;
      background-size: cover;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      color: white;
    }

    .hero::before {
      content: "";
      position: absolute;
      inset: 0;
      background: rgba(0, 0, 0, 0.6);
      z-index: 1;
    }

    .hero .content {
      position: relative;
      z-index: 2;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.2);
      transition: 0.3s ease-in-out;
    }

    .navbar-brand img {
      height: 40px;
      margin-right: 8px;
    }

    .kategori-icon {
      font-size: 48px;
      margin-bottom: 10px;
      color: #ffc107;
    }
  .text-maroon {
    color: #800000 !important;
  }
  .btn-maroon {
    background-color: #800000;
    border: none;
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
  .btn-outline-light:hover {
    background-color: #fff;
    color: #800000;
  }
  </style>
</head>
<body>

<!-- NAVBAR DENGAN WARNA MARUN DAN PUTIH -->
<nav class="navbar navbar-expand-lg sticky-top" style="background-color: #800000;">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center text-white fw-bold" href="/">
      <img src="<?= base_url('logo.png') ?>" alt="Logo" style="height: 40px;" class="me-2">
      StepUP
    </a>

    <button class="navbar-toggler text-white border-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav me-3">
        <!-- Tambahkan item menu lain jika diperlukan -->
      </ul>
      <?php if (session()->get('isLoggedIn')): ?>
  <div class="dropdown">
    <button class="btn btn-outline-light rounded-pill dropdown-toggle px-4" type="button" data-bs-toggle="dropdown" aria-expanded="false">
      <?= esc(session()->get('user_name')) ?>
    </button>
    <ul class="dropdown-menu dropdown-menu-end">
      <li><a class="dropdown-item" href="<?= base_url('riwayat') ?>">Riwayat Transaksi</a></li>
      <li><hr class="dropdown-divider"></li>
      <li><a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">Logout</a></li>
    </ul>
  </div>
<?php else: ?>
  <div class="d-flex">
    <a href="/login" class="btn btn-outline-light me-2 rounded-pill px-4">Login</a>
    <a href="/register" class="btn btn-light text-maroon rounded-pill px-4">Daftar</a>
  </div>
<?php endif; ?>

    </div>
  </div>
</nav>

<!-- HERO -->
<section class="hero">
  <div class="content" data-aos="zoom-in">
    <h1>Selamat Datang di StepUP</h1>
    <p>Temukan sepatu pilihanmu dengan gaya terbaik!</p>
    <a href="<?= site_url('dashboard') ?>" class="btn btn-warning btn-lg">Lihat Koleksi</a>
  </div>
</section>

<!-- PRODUK UNGGULAN -->
<section class="py-5">
  <div class="container">
    <h2 class="text-center mb-4" data-aos="fade-up">Produk Unggulan</h2>
    <div class="row g-4">
      <?php
      $produk = [
        ['ADIDAS spezial men', 'sepatu6.png', 1400000],
        ['NEW BALANCE 471', 'sepatu15.png', 1500000],
        ['REEBOK CLASSICA AZ', 'sepatu17.png', 1500000],
        ['MILS RUNNING TREXIMO', 'sepatu19.png', 1200000],
        
      ];
      foreach ($produk as $i => [$nama, $gambar, $harga]): ?>
        <div class="col-md-3" data-aos="<?= $i % 2 === 0 ? 'fade-right' : 'fade-left' ?>" data-aos-delay="<?= $i * 100 ?>">
          <div class="card shadow-sm h-100 rounded-4">
            <img src="<?= base_url('images/' . $gambar) ?>" class="card-img-top rounded-top-4" alt="<?= $nama ?>">
            <div class="card-body">
              <h5 class="card-title"><?= $nama ?></h5>
              <p class="card-text text-muted">Rp <?= number_format($harga, 0, ',', '.') ?></p>
              <a href="#" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>


<!-- KATEGORI -->
<section class="py-5 bg-light">
  <div class="container text-center">
    <h2 class="mb-4" data-aos="fade-up">Kategori Sepatu</h2>
    <div class="row g-4">
      <?php 
        $kategori = [
          ['pria', '🧍‍♂️'],
          ['wanita', '🧍‍♀️'],
          ['olahraga', '🏃‍♂️'],
          ['casual', '👟']
        ];
        foreach ($kategori as $i => [$nama, $ikon]): ?>
        <div class="col-md-3" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
          <a href="<?= base_url('produk?kategori=' . $nama) ?>" class="text-decoration-none text-dark">
            <div class="card shadow rounded-4 h-100 p-4">
              <div class="kategori-icon"><?= $ikon ?></div>
              <h5 class="text-capitalize"><?= $nama ?></h5>
            </div>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>


<!-- TESTIMONI -->
<section class="py-5">
  <div class="container">
    <h2 class="text-center mb-4" data-aos="fade-up">Apa Kata Mereka?</h2>
    <div class="row g-4">
      <?php for ($i = 1; $i <= 6; $i++): ?>
        <div class="col-md-4" data-aos="zoom-in-up" data-aos-delay="<?= $i * 100 ?>">
          <div class="card shadow rounded-4 p-4 h-100">
            <p>"Sepatunya nyaman banget! Desainnya juga kekinian. Suka banget belanja di StepUP!"</p>
            <div class="d-flex align-items-center">
              <img src="https://i.pravatar.cc/40?img=<?= $i ?>" class="rounded-circle me-2" alt="User">
              <strong>Pengguna <?= $i ?></strong>
            </div>
          </div>
        </div>
      <?php endfor; ?>
    </div>
  </div>
</section>

<!-- Tambahkan view footer -->
<?= view('footer') ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>AOS.init();</script>
</body>
</html>
