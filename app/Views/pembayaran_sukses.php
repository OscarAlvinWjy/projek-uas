<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pembayaran Sukses - StepUP</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Poppins', sans-serif;
    }

    .success-container {
      background: #fff;
      border-radius: 12px;
      padding: 50px;
      max-width: 600px;
      margin: 80px auto;
      box-shadow: 0 8px 30px rgba(0,0,0,0.08);
    }

    .success-icon {
      font-size: 70px;
      color: #28a745;
      margin-bottom: 20px;
    }

    .success-text {
      color: #28a745;
      font-weight: bold;
      margin-bottom: 15px;
    }

    .lead {
      font-size: 1.1rem;
      color: #555;
    }

    .btn-back {
      margin-top: 30px;
      background-color: #800000;
      color: white;
    }

    .btn-back:hover {
      background-color: #a00000;
    }
  </style>
</head>
<body>

  <div class="success-container text-center animate__animated animate__fadeInUp">
    <div class="success-icon">
      <i class="fas fa-check-circle"></i>
    </div>
    <h2 class="success-text animate__animated animate__pulse animate__delay-1s">Pembayaran Berhasil!</h2>
    <p class="lead">Terima kasih telah melakukan pembayaran dengan metode:</p>
    <p class="fs-5 fw-semibold text-maroon"><i class="fas fa-wallet me-1"></i> <?= esc($metode) ?></p>

    <a href="<?= base_url('/dashboard') ?>" class="btn btn-back px-4 py-2 rounded-pill shadow-sm">
      <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
    </a>
  </div>

</body>
</html>
