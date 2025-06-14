<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Checkout - StepUP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
            margin-top: 50px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .table img {
            max-width: 80px;
            height: auto;
            border-radius: 4px;
        }
        .form-check-label {
            font-weight: bold;
        }
        .btn-maroon {
            background-color: #800000;
            color: white;
        }
        .btn-maroon:hover {
            background-color: #660000;
            color: white;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="mb-4">Checkout Belanja</h2>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header">
            <h4>Detail Pesanan</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart as $item): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="<?= base_url('images/' . $item['image']) ?>" class="me-3" alt="<?= esc($item['name']) ?>">
                                    <?= esc($item['name']) ?>
                                </div>
                            </td>
                            <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                            <td><?= $item['qty'] ?></td>
                            <td>Rp <?= number_format($item['price'] * $item['qty'], 0, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Total Belanja:</th>
                        <th>Rp <?= number_format($totalPrice, 0, ',', '.') ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <form action="<?= base_url('/checkout/process') ?>" method="post">
        <?= csrf_field() ?>

        <div class="card mb-4">
            <div class="card-header">
                <h4>Pilih Metode Pembayaran</h4>
            </div>
            <div class="card-body">
                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="payment_method" id="transferBank" value="Bank Transfer" required>
                    <label class="form-check-label" for="transferBank">
                        Via Transfer Bank
                    </label>
                    <small class="d-block text-muted ms-4">Transfer ke rekening BCA 1234567890 a.n. StepUP Store</small>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="payment_method" id="eWallet" value="E-Wallet">
                    <label class="form-check-label" for="eWallet">
                        Via DANA, GoPay, OVO
                    </label>
                    <small class="d-block text-muted ms-4">Pembayaran melalui aplikasi e-wallet pilihan Anda. Scan QR code setelah konfirmasi.</small>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="payment_method" id="cod" value="Cash On Delivery">
                    <label class="form-check-label" for="cod">
                        Cash On Delivery (COD)
                    </label>
                    <small class="d-block text-muted ms-4">Bayar saat barang diterima di tempat Anda.</small>
                </div>
            </div>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-maroon btn-lg">Konfirmasi Pembayaran</button>
            <a href="<?= base_url('/keranjang') ?>" class="btn btn-outline-secondary">Kembali ke Keranjang</a>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>