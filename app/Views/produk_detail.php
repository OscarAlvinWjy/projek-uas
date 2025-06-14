<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Detail Produk - <?= esc($product['name']) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container py-5">
  <a href="<?= base_url('/dashboard') ?>" class="btn btn-secondary mb-3">Kembali</a>

  <div class="row">
    <div class="col-md-6">
      <img src="<?= base_url('images/' . $product['image']) ?>" class="img-fluid rounded" alt="<?= esc($product['name']) ?>">
    </div>
    <div class="col-md-6">
      <h2><?= esc($product['name']) ?></h2>
      <p class="text-muted"><?= esc($product['description']) ?></p>
      <p class="h4 fw-bold text-maroon">Rp <?= number_format($product['price'], 0, ',', '.') ?></p>
      <p><strong>Stok:</strong> <?= $product['stock'] ?></p>
      <a href="<?= base_url('/keranjang/tambah/' . $product['id'] . '?from=detail') ?>" class="btn btn-outline-secondary">Tambah ke Keranjang</a>
    </div>
  </div>
</div>

</body>
</html>
