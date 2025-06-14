<!doctype html>
<html>
<head>
  <title>Checkout Berhasil - StepUP</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5 text-center">
    <h2 class="text-success">Checkout Berhasil!</h2>
    <p class="lead">Total pembayaran: <strong>Rp <?= number_format($total, 0, ',', '.') ?></strong></p>
    <a href="<?= base_url('/pembayaran/' . $transaksi_id) ?>" class="btn btn-primary mt-3">Lanjut ke Pembayaran</a>
  </div>
</body>
</html>
