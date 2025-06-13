<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Daftar - StepUP</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      margin: 0;
      padding: 0;
      background: linear-gradient(135deg, rgba(128,0,0,0.9), rgba(179,0,0,0.9)),
                  url("<?= base_url('logo.png') ?>") no-repeat right bottom;
      background-size: contain;
      background-attachment: fixed;
      background-position: center;
      color: #fff;
      font-family: 'Segoe UI', sans-serif;
    }

    .register-card {
      background: rgba(255, 255, 255, 0.95);
      color: #333;
      border-radius: 25px;
      padding: 2.5rem;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
      width: 100%;
      max-width: 430px;
      animation: fadeIn 1s ease-in-out;
    }

    .btn-maroon {
      background-color: #800000;
      border: none;
    }

    .btn-maroon:hover {
      background-color: #660000;
    }

    a {
      color: #800000;
      text-decoration: none;
    }

    a:hover {
      color: #660000;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>
  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="register-card">
      <h3 class="text-center mb-4 fw-bold text-maroon">Daftar Akun</h3>

      <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
      <?php endif; ?>

      <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
      <?php endif; ?>

      <form method="post" action="<?= base_url('/register') ?>">
        <?= csrf_field() ?>

        <div class="mb-3">
          <label for="name" class="form-label">Nama Lengkap</label>
          <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <div class="mb-3">
          <label for="password_confirm" class="form-label">Konfirmasi Password</label>
          <input type="password" name="password_confirm" id="password_confirm" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-maroon text-white w-100 rounded-pill">Daftar</button>
      </form>

      <p class="mt-4 text-center">Sudah punya akun? <a href="<?= base_url('/login') ?>"><strong>Login</strong></a></p>
    </div>
  </div>

  <!-- Footer -->
  <?= $this->include('footer') ?>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
