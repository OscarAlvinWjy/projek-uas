<?php helper('text'); ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Detail Produk - <?= esc($product['name']) ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f8f9fa;
    }

    .text-maroon { color: #800000; }

    .btn-maroon {
      background-color: #800000;
      color: white;
      border: none;
      transition: 0.3s ease;
    }
    .btn-maroon:hover { background-color: #a00000; }

    .btn-buy {
      background-color: #28a745;
      color: white;
      border: none;
      transition: 0.3s ease;
    }
    .btn-buy:hover { background-color: #218838; }

    .badge-stock {
      background-color: #ffc107;
      color: #212529;
      font-size: 0.9rem;
    }

    .price-tag {
      font-size: 1.8rem;
      color: #800000;
      font-weight: 700;
    }

    .product-description {
      font-size: 1rem;
      color: #555;
    }

    .img-preview {
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      transition: transform 0.3s ease;
    }
    .img-preview:hover { transform: scale(1.03); }

    .feedback-success {
      display: none;
      color: green;
      font-weight: 500;
      margin-top: 10px;
    }

    .navbar {
      background-color: #800000;
    }

    .navbar .nav-link, .navbar .navbar-brand {
      color: white !important;
    }

    .navbar-brand img {
      height: 40px;
      margin-right: 8px;
    }

    .badge-cart {
      position: absolute;
      top: 0;
      right: -10px;
      background: yellow;
      color: black;
      border-radius: 50%;
      padding: 4px 8px;
      font-size: 0.75rem;
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
        <li class="nav-item dropdown me-3">
          <a class="nav-link dropdown-toggle text-white fw-semibold" href="#" role="button" data-bs-toggle="dropdown">
            <i class="fas fa-tags me-1"></i> Kategori
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?= base_url('/kategori/pria') ?>"><i class="fas fa-mars me-2"></i>Pria</a></li>
            <li><a class="dropdown-item" href="<?= base_url('/kategori/wanita') ?>"><i class="fas fa-venus me-2"></i>Wanita</a></li>
          </ul>
        </li>

        <li class="nav-item me-3"><a class="nav-link text-white" href="<?= base_url('/tentang') ?>"><i class="fas fa-info-circle me-1"></i> Tentang</a></li>
        <li class="nav-item me-3"><a class="nav-link text-white" href="<?= base_url('/kontak') ?>"><i class="fas fa-phone me-1"></i> Kontak</a></li>
        <li class="nav-item me-3"><a class="nav-link text-white" href="<?= base_url('/riwayat') ?>"><i class="fas fa-box me-1"></i> Pesanan</a></li>

        <?php if(session()->get('logged_in')): ?>
          <li class="nav-item dropdown me-3">
            <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">
              <i class="fas fa-user me-1"></i><?= esc(session('name')) ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="<?= base_url('/riwayat') ?>"><i class="fas fa-clock me-2"></i>Riwayat</a></li>
              <li><a class="dropdown-item" href="<?= base_url('/logout') ?>"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
            </ul>
          </li>
        <?php else: ?>
          <li class="nav-item me-2"><a href="/login" class="btn btn-outline-light rounded-pill px-4">Login</a></li>
          <li class="nav-item me-3"><a href="/register" class="btn btn-light text-maroon rounded-pill px-4">Daftar</a></li>
        <?php endif; ?>

        <li class="nav-item position-relative">
          <a href="<?= base_url('/keranjang?from=dashboard') ?>" class="nav-link text-white" style="font-size: 1.35rem;">
            <i class="fas fa-shopping-cart"></i>
            <span id="cart-count" class="badge-cart"><?= session()->get('cart_count') ?? 0 ?></span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- DETAIL PRODUK -->
<div class="container py-5">
  <div class="row g-5 align-items-center">
    <div class="col-md-6">
      <img src="<?= base_url('images/' . $product['image']) ?>" class="img-fluid img-preview" alt="<?= esc($product['name']) ?>">
    </div>
    <div class="col-md-6">
      <h2 class="fw-bold"><?= esc($product['name']) ?></h2>
      <p class="product-description"><?= esc($product['description']) ?></p>
      <p class="price-tag">Rp <?= number_format($product['price'], 0, ',', '.') ?></p>
      <p><span class="badge badge-stock">Stok Tersedia: <?= $product['stock'] ?></span></p>

      <div class="d-flex gap-3 mt-3">
        <form id="add-to-cart-form" data-product-id="<?= $product['id'] ?>">
          <button type="submit" class="btn btn-maroon">
            <i class="fas fa-cart-plus me-1"></i> Tambah ke Keranjang
          </button>
        </form>
        <a href="<?= base_url('/beli-sekarang/' . $product['id']) ?>" class="btn btn-buy">
          <i class="fas fa-bolt me-1"></i> Beli Sekarang
        </a>
      </div>

      <div id="cart-feedback" class="feedback-success">
        <i class="fas fa-check-circle"></i> Produk berhasil ditambahkan ke keranjang!
      </div>
    </div>
  </div>
</div>

<!-- FOOTER -->
<?= $this->include('footer') ?>

<!-- JS -->
<script>
  document.getElementById('add-to-cart-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const productId = this.getAttribute('data-product-id');

    fetch('<?= base_url('/keranjang/ajax-tambah') ?>/' + productId)
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          document.getElementById('cart-feedback').style.display = 'block';
          setTimeout(() => {
            document.getElementById('cart-feedback').style.display = 'none';
          }, 3000);
          if (data.cart_count !== undefined) {
            document.getElementById('cart-count').innerText = data.cart_count;
          }
        }
      });
  });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
