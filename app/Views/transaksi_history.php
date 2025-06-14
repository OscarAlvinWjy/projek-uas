<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Riwayat Transaksi - StepUP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container py-5">
    <h2>Riwayat Transaksi Anda</h2>

    <a href="<?= base_url('/dashboard') ?>" class="btn btn-secondary mb-3">Kembali ke Dashboard</a>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <?php if (empty($orders)): ?>
        <p>Anda belum memiliki riwayat transaksi.</p>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID Pesanan</th>
                    <th>Tanggal Pesanan</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= esc($order['id']) ?></td>
                        <td><?= esc(date('d M Y H:i', strtotime($order['order_date']))) ?></td>
                        <td>Rp <?= number_format($order['total_price'], 0, ',', '.') ?></td>
                        <td><?= esc($order['status']) ?></td>
                        <td>
                            <a href="<?= base_url('/transaksi/' . $order['id']) ?>" class="btn btn-sm btn-info">Detail</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

</body>
</html>