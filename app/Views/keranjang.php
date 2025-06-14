<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Keranjang - StepUP</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container py-5">
  <h2>Keranjang Belanja</h2>

  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
  <?php endif; ?>

  <!-- Tombol Kembali -->
<div class="container mt-4">
  <?php if ($keranjangFrom === 'detail' && $lastProductId): ?>
    <a href="<?= base_url('/produk/' . $lastProductId) ?>" class="btn btn-secondary mb-4">← Kembali ke Detail Produk</a>
  <?php else: ?>
    <a href="<?= base_url('/dashboard') ?>" class="btn btn-secondary mb-4">← Kembali ke Dashboard</a>
  <?php endif; ?>
</div>


  <?php if (empty($cart)): ?>
    <p>Keranjang kosong.</p>
  <?php else: ?>
    <table class="table">
      <thead>
        <tr>
          <th>Gambar</th>
          <th>Produk</th>
          <th>Harga</th>
          <th>Jumlah</th>
          <th>Total</th>
          <th></th>
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
            <td><img src="<?= base_url('images/' . $item['image']) ?>" width="60" alt=""></td>
            <td><?= esc($item['name']) ?></td>
            <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
            <td><?= $item['qty'] ?></td>
            <td>Rp <?= number_format($subTotal, 0, ',', '.') ?></td>
            <td>
              <a href="<?= base_url('/keranjang/hapus/' . $item['id']) ?>" class="btn btn-sm btn-danger">Hapus</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <h4>Total: Rp <?= number_format($total, 0, ',', '.') ?></h4>
    <div class="text-end mt-4">
  <a href="<?= base_url('/checkout') ?>" class="btn btn-success">Checkout Sekarang</a>
</div>

  <?php endif; ?>
</div>

</body>
</html>
