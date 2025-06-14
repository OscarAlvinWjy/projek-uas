<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Detail Transaksi - StepUP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container py-5">
    <a href="<?= base_url('/transaksi') ?>" class="btn btn-secondary mb-3">Kembali ke Riwayat Transaksi</a>
    <h2>Detail Transaksi #<?= esc($order['id']) ?></h2>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Informasi Pesanan</h5>
            <p><strong>Tanggal Pesanan:</strong> <?= date('d M Y H:i', strtotime(esc($order['order_date']))) ?></p>
            <p><strong>Total Harga:</strong> Rp <?= number_format(esc($order['total_price']), 0, ',', '.') ?></p>
            <p><strong>Status:</strong> <?= esc(ucfirst($order['status'])) ?></p>
            <p><strong>Metode Pembayaran:</strong> <?= esc($order['payment_method'] ?? 'N/A') ?></p>
            <p><strong>Metode Pengiriman:</strong> <?= esc($order['shipping_method'] ?? 'N/A') ?> (Biaya: Rp <?= number_format($order['shipping_cost'] ?? 0, 0, ',', '.') ?>)</p>
            <p><strong>Alamat Pengiriman:</strong> <?= esc($order['shipping_address'] ?? 'N/A') ?></p>
        </div>
    </div>

    <h3>Produk dalam Pesanan</h3>
    <?php if (empty($orderItems)): ?>
        <p>Tidak ada produk dalam pesanan ini.</p>
    <?php else: ?>
        <table class="table table-striped">
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
                <?php foreach ($orderItems as $item): ?>
                    <tr>
                        <td><img src="<?= base_url('images/' . $item['product_image']) ?>" width="60" alt=""></td>
                        <td><?= esc($item['product_name']) ?></td>
                        <td>Rp <?= number_format(esc($item['price']), 0, ',', '.') ?></td>
                        <td><?= esc($item['quantity']) ?></td>
                        <td>Rp <?= number_format(esc($item['price'] * $item['quantity']), 0, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

</body>
</html>