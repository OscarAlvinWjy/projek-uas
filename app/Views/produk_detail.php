<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Detail Produk - <?= esc($product['name']) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f8f9fa;
    }

    .text-maroon {
      color: #800000;
    }

    .btn-maroon {
      background-color: #800000;
      color: white;
      border: none;
      transition: 0.3s ease;
    }

    .btn-maroon:hover {
      background-color: #a00000;
    }

    .btn-buy {
      background-color: #28a745;
      color: white;
      border: none;
      transition: 0.3s ease;
    }

    .btn-buy:hover {
      background-color: #218838;
    }

    .btn-back {
      background-color: #6c757d;
      color: white;
      transition: 0.3s ease;
    }

    .btn-back:hover {
      background-color: #5a6268;
    }

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

    .img-preview:hover {
      transform: scale(1.03);
    }
  </style>
</head>
<body>

<div class="container py-5">
  <a href="<?= base_url('/dashboard') ?>" class="btn btn-back mb-4">
    <i class="fas fa-arrow-left"></i> Kembali
  </a>

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
        <a href="<?= base_url('/keranjang/tambah/' . $product['id'] . '?from=detail') ?>" class="btn btn-maroon">
          <i class="fas fa-cart-plus me-1"></i> Tambah ke Keranjang
        </a>
        <a href="<?= base_url('/beli-sekarang/' . $product['id']) ?>" class="btn btn-buy">
          <i class="fas fa-bolt me-1"></i> Beli Sekarang
        </a>
      </div>
    </div>
  </div>
</div>

<!-- FOOTER -->
<?= $this->include('footer') ?>

</body>
</html>
