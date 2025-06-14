<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>contoh cek out</title>
</head>
<body>
    <div class="container">
        <h1>Checkout</h1>
        <form action="<?= base_url('/checkout/processOrder') ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat Pengiriman</label>
                <input type="text" class="form-control" id="alamat" name="alamat" required>
            </div>
            <div class="mb-3">
                <label for="telepon" class="form-label">Nomor Telepon</label>
                <input type="text" class="form-control" id="telepon" name="telepon" required>
            </div>
            <div class="mb-3">
                <label for="pengiriman" class="form-label">Opsi Pengiriman</label>
                <select class="form-select" id="pengiriman" name="pengiriman" required>
                    <?php foreach ($opsi_pengiriman as $opsi): ?>
                        <option value="<?= esc($opsi['nama']) ?>"><?= esc($opsi['nama']) ?> - Rp <?= number_format($opsi['harga'], 0, ',', '.') ?> (<?= esc($opsi['estimasi']) ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="pembayaran" class="form-label">Metode Pembayaran</label>
                <select class="form-select" id="pembayaran" name="pembayaran" required>
                    <?php foreach ($metode_pembayaran as $metode): ?>
                        <option value="<?= esc($metode) ?>"><?= esc($metode) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Proses Pesanan</button>
        </form>
    </div>
</body>
</html>