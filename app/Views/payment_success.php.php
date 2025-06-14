<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Pembayaran Berhasil - StepUP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            text-align: center;
        }
        .success-container {
            background-color: #ffffff;
            padding: 50px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }
        .success-icon {
            font-size: 80px;
            color: #28a745; /* Green color */
            margin-bottom: 20px;
        }
        .btn-maroon {
            background-color: #800000;
            color: white;
            padding: 10px 30px;
            font-size: 1.1rem;
        }
        .btn-maroon:hover {
            background-color: #660000;
            color: white;
        }
    </style>
</head>
<body>

<div class="success-container">
    <div class="success-icon">
        <i class="fas fa-check-circle"></i>
    </div>
    <h2 class="mb-3">Pembayaran Berhasil!</h2>
    <p class="lead mb-4">Terima kasih sudah belanja di StepUP.</p>
    <p>Metode Pembayaran: <strong><?= esc($paymentMethod) ?></strong></p>
    <p>Total Pembayaran: <strong>Rp <?= number_format($totalPrice, 0, ',', '.') ?></strong></p>
    <a href="<?= base_url('/') ?>" class="btn btn-maroon mt-4">Kembali ke Beranda</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
</body>
</html>