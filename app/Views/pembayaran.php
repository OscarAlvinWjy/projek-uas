<!doctype html>
<html>
<head>
  <title>Pembayaran - StepUP</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h2 class="mb-4">Pembayaran</h2>
    <p><strong>Total yang harus dibayar:</strong> Rp <?= number_format($transaksi['total'], 0, ',', '.') ?></p>

    <form action="<?= base_url('/proses-bayar') ?>" method="post">
      <input type="hidden" name="transaksi_id" value="<?= $transaksi['id'] ?>">

      <div class="mb-3">
        <label for="metode" class="form-label">Metode Pembayaran</label>
        <select name="metode" id="metode" class="form-select" required>
          <option value="">-- Pilih --</option>
          <option value="Transfer Bank">Transfer Bank</option>
          <option value="E-Wallet">E-Wallet (Dana, OVO, Gopay)</option>
          <option value="COD">Bayar di Tempat (COD)</option>
        </select>
      </div>

      <button type="submit" class="btn btn-success">Bayar Sekarang</button>
    </form>
  </div>
</body>
</html>
