<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Riwayat Transaksi</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f7f7f7;
    }

    .navbar {
      background-color: #800000;
    }

    .navbar-brand img {
      height: 40px;
      margin-right: 8px;
    }

    .navbar .nav-link,
    .navbar .navbar-brand {
      color: white !important;
    }

    .logo-container {
      text-align: center;
      margin-bottom: 10px;
    }

    .logo-container img {
      height: 50px;
    }

    .section-title {
      color: #800000;
      font-weight: 600;
      margin-bottom: 30px;
      text-align: center;
    }

    .card-transaksi {
      position: relative;
      background-color: rgb(176, 126, 126);
      border-left: 5px solid #800000;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      overflow: hidden;
    }

    .card-transaksi::before {
      content: '';
      background: url('<?= base_url("logo1.png") ?>') no-repeat center center;
      background-size: contain;
      opacity: 0.08;
      position: absolute;
      top: 10%;
      left: 50%;
      transform: translateX(-50%);
      width: 80%;
      height: 80%;
      pointer-events: none;
    }

    .card-transaksi:hover {
      transform: scale(1.01);
      box-shadow: 0 6px 18px rgba(0,0,0,0.1);
    }

    .produk-item {
      background-color: #fff;
      padding: 10px 16px;
      border: 1px solid #eee;
      border-radius: 8px;
      margin-bottom: 6px;
    }

    .text-maroon {
      color: #800000;
    }

    .badge-date {
      background-color: #f0f0f0;
      color: #666;
      font-size: 0.85rem;
    }

    .filter-title {
      font-size: 1rem;
      font-weight: 500;
      margin-bottom: 6px;
    }

    .transaksi-header i {
      color: #800000;
      margin-right: 6px;
    }

    .produk-item .qty {
      font-size: 0.9rem;
      color: #666;
    }

    .total-box {
      background-color: #fff8f8;
      border: 1px solid #f3dcdc;
      padding: 10px 16px;
      border-radius: 8px;
      font-weight: 500;
    }

    .btn-outline-maroon {
      border-color: #800000;
      color: #800000;
    }

    .btn-outline-maroon:hover {
      background-color: #800000;
      color: #fff;
    }

    .status-badge {
      font-size: 0.8rem;
      padding: 5px 10px;
    }
  </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg sticky-top shadow-sm py-3">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center fw-bold text-white" href="<?= base_url('/') ?>">
      <img src="<?= base_url('logo.png') ?>" alt="Logo"> StepUP
    </a>
    <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav align-items-center">

        <!-- Kategori -->
        <li class="nav-item dropdown me-3">
          <a class="nav-link dropdown-toggle text-white fw-semibold" href="#" role="button" data-bs-toggle="dropdown">
            <i class="fas fa-tags me-1"></i> Kategori
          </a>
          <ul class="dropdown-menu animate__animated animate__fadeIn">
            <li><a class="dropdown-item" href="<?= base_url('/kategori/pria') ?>"><i class="fas fa-mars me-2"></i>Pria</a></li>
            <li><a class="dropdown-item" href="<?= base_url('/kategori/wanita') ?>"><i class="fas fa-venus me-2"></i>Wanita</a></li>
          </ul>
        </li>

        <!-- Tentang -->
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

        <!-- Admin/User -->
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

        <!-- Keranjang -->
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

<!-- MAIN CONTENT -->
<div class="container py-5">
  <div class="logo-container animate__animated animate__fadeInDown mb-3">
    <img src="<?= base_url('logo.png') ?>" alt="Logo StepUP">
  </div>

  <h2 class="section-title animate__animated animate__fadeInDown"><i class="fas fa-clock-rotate-left me-1"></i> Riwayat Transaksi</h2>

  <!-- Filter Tanggal -->
  <form method="get" class="row g-3 mb-4 justify-content-center animate__animated animate__fadeIn">
    <div class="col-auto">
      <label class="filter-title">Filter Tanggal:</label>
      <input type="date" name="tanggal" class="form-control" value="<?= esc($filterTanggal) ?>">
    </div>
    <div class="col-auto align-self-end">
      <button type="submit" class="btn btn-outline-maroon">Terapkan</button>
      <a href="<?= base_url('/riwayat') ?>" class="btn btn-outline-secondary">Reset</a>
    </div>
  </form>

  <?php if (empty($transaksiList)): ?>
    <div class="alert alert-warning text-center animate__animated animate__fadeInUp">
      <i class="fas fa-exclamation-circle me-2"></i> Belum ada transaksi ditemukan.
    </div>
  <?php else: ?>
    <?php foreach ($transaksiList as $transaksi): ?>
      <div class="card card-transaksi mb-4 animate__animated animate__zoomIn">
        <div class="card-body position-relative">
          <div class="d-flex justify-content-between align-items-center transaksi-header mb-2">
            <h5 class="mb-0"><i class="fas fa-receipt"></i> #<?= $transaksi['id'] ?></h5>
            <div class="d-flex gap-2">
              <span class="badge badge-date"><?= date('d M Y, H:i', strtotime($transaksi['tanggal'])) ?></span>
              <span class="badge bg-success status-badge"><i class="fas fa-check-circle me-1"></i> Sukses</span>
            </div>
          </div>

          <div class="total-box mb-3 text-maroon">
            Total Pembayaran: Rp <?= number_format($transaksi['total'], 0, ',', '.') ?>
          </div>

          <div class="mb-2 fw-semibold">Produk Dibeli:</div>
          <div class="row">
            <?php foreach ($transaksi['items'] as $item): ?>
              <div class="col-md-6 col-lg-4">
                <div class="produk-item d-flex justify-content-between align-items-start">
                  <div>
                    <?= esc($item['nama_produk']) ?>
                    <div class="qty">x<?= $item['qty'] ?></div>
                  </div>
                  <div class="text-end">
                    <strong>Rp <?= number_format($item['harga'] * $item['qty'], 0, ',', '.') ?></strong>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

<!-- FOOTER -->
<?= $this->include('footer') ?>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
