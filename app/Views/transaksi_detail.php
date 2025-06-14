<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Detail Transaksi - StepUP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container py-5">
    <h2>Detail Transaksi #<?= esc($order['id']) ?></h2>

    <a href="<?= base_url('/transaksi') ?>" class="btn btn-secondary mb-3">Kembali ke Riwayat Transaksi</a>

    <div class="card mb-4">
        <div class="card-header">
            Informasi Pesanan
        </div>
        <div class="card-body">
            <p><strong>Tanggal Pesanan:</strong> <?= esc(date('d M Y H:i', strtotime($order['order_date']))) ?></p>
            <p><strong>Total Harga:</strong> Rp <?= number_format($order['total_price'], 0, ',', '.') ?></p>
            <p><strong>Status:</strong> <?= esc($order['status']) ?></p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            Produk dalam Pesanan
        </div>
        <div class="card-body">
            <?php if (empty($order_items)): ?>
                <p>Tidak ada produk dalam pesanan ini.</p>
            <?php else: ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Gambar</th>
                            <th>Produk</th>
                            <th>Harga Satuan</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order_items as $item): ?>
                            <tr>
                                <td><img src="<?= base_url('images/' . $item['product_image']) ?>" width="50" alt="<?= esc($item['product_name']) ?>"></td>
                                <td><?= esc($item['product_name']) ?></td>
                                <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                                <td><?= esc($item['quantity']) ?></td>
                                <td>Rp <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            Informasi Pembayaran
        </div>
        <div class="card-body">
            <?php if ($payment): ?>
                <p><strong>Metode Pembayaran:</strong> <?= esc($payment['payment_method']) ?></p>
                <p><strong>Tanggal Pembayaran:</strong> <?= esc(date('d M Y H:i', strtotime($payment['payment_date']))) ?></p>
                <?php /* if ($payment['payment_proof']): ?>
                    <p><strong>Bukti Pembayaran:</strong> <a href="<?= base_url('uploads/payment_proofs/' . $payment['payment_proof']) ?>" target="_blank">Lihat Bukti</a></p>
                <?php else: ?>
                    <p>Belum ada bukti pembayaran diunggah.</p>
                    <form action="<?= base_url('/transaksi/upload_proof/' . $order['id']) ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label for="paymentProof" class="form-label">Upload Bukti Pembayaran</label>
                            <input class="form-control" type="file" id="paymentProof" name="payment_proof" required>
                            <small class="form-text text-muted">Hanya gambar (JPG, PNG) yang diizinkan.</small>
                        </div>
                        <button type="submit" class="btn btn-primary">Unggah Bukti</button>
                    </form>
                <?php endif; */ ?>
                <p class="text-success">Pembayaran telah berhasil dikonfirmasi.</p>
            <?php else: ?>
                <p>Belum ada informasi pembayaran untuk pesanan ini.</p>
                <p class="text-info">Silakan tunggu konfirmasi pembayaran dari sistem.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>