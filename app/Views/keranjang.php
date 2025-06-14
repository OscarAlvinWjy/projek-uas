<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Keranjang - StepUP</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Poppins', sans-serif;
    }

    .text-maroon {
      color: #800000;
    }

    .btn-maroon {
      background-color: #800000;
      color: white;
      border: none;
    }

    .btn-maroon:hover {
      background-color: #a00000;
    }

    .table th, .table td {
      vertical-align: middle;
    }

    .product-img {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 8px;
    }

    .back-btn {
      margin-bottom: 20px;
    }

    .total-box {
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0,0,0,0.05);
    }
  </style>
</head>
<body>

<div class="container py-5">
  <h2 class="mb-4 text-maroon fw-bold"><i class="fas fa-shopping-cart me-2"></i>Keranjang Belanja</h2>

  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
  <?php endif; ?>

  <div class="back-btn">
    <?php if ($keranjangFrom === 'detail' && $lastProductId): ?>
      <a href="<?= base_url('/produk/' . $lastProductId) ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali ke Detail Produk
      </a>
    <?php else: ?>
      <a href="<?= base_url('/dashboard') ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
      </a>
    <?php endif; ?>
  </div>

  <?php if (empty($cart)): ?>
    <div class="alert alert-info text-center py-4">
      <i class="fas fa-info-circle fa-2x mb-2"></i><br>
      Keranjang kamu masih kosong.
    </div>
  <?php else: ?>
    <div class="table-responsive mb-4">
      <table class="table table-bordered table-hover bg-white rounded shadow-sm">
        <thead class="table-light">
          <tr>
            <th>Gambar</th>
            <th>Produk</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Total</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $total = 0;
            foreach ($cart as $item):
              $subTotal = $item['price'] * $item['qty'];
              $total += $subTotal;
          ?>
            <tr>
              <td><img src="<?= base_url('images/' . $item['image']) ?>" class="product-img" alt=""></td>
              <td><?= esc($item['name']) ?></td>
              <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
              <td><?= $item['qty'] ?></td>
              <td>Rp <?= number_format($subTotal, 0, ',', '.') ?></td>
              <td>
                <a href="<?= base_url('/keranjang/hapus/' . $item['id']) ?>" class="btn btn-sm btn-danger">
                  <i class="fas fa-trash-alt"></i>
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <div class="row justify-content-end">
      <div class="col-md-6">
        <div class="total-box">
          <h5 class="mb-3">Total Belanja</h5>
          <div class="d-flex justify-content-between align-items-center">
            <strong class="text-maroon fs-4">Rp <?= number_format($total, 0, ',', '.') ?></strong>
            <a href="<?= base_url('/checkout') ?>" class="btn btn-success btn-lg">
              <i class="fas fa-credit-card me-1"></i> Checkout Sekarang
            </a>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
</div>

</body>
</html>
