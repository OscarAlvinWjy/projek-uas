<!doctype html>
<html>
<head>
  <title>Pembayaran Sukses - StepUP</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light text-center">
  <div class="container mt-5">
    <h2 class="text-success">Pembayaran Berhasil!</h2>
    <p class="lead">Terima kasih telah melakukan pembayaran dengan metode <strong><?= esc($metode) ?></strong>.</p>
    <a href="<?= base_url('/dashboard') ?>" class="btn btn-primary">Kembali ke Dashboard</a>
  </div>
</body>
</html>
