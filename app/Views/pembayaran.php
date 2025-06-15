<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pembayaran - StepUP</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #f7f7f7;
      font-family: 'Poppins', sans-serif;
    }

    .container {
      margin-top: 50px;
    }

    .form-wrapper {
      background-color: #fff;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    }

    .title {
      color: #800000;
      font-weight: bold;
      margin-bottom: 25px;
      text-align: center;
    }

    .badge-total {
      display: inline-block;
      background-color: #fff8e1;
      color: #6c4f00;
      padding: 10px 20px;
      border-radius: 10px;
      font-size: 1.1rem;
      margin-bottom: 25px;
    }

    .form-label i {
      margin-right: 6px;
      color: #800000;
    }

    .btn-maroon {
      background-color: #800000;
      color: white;
      transition: 0.3s ease;
    }

    .btn-maroon:hover {
      background-color: #a00000;
    }

    .metode-box {
      border: 2px solid #ddd;
      border-radius: 12px;
      padding: 15px;
      text-align: center;
      cursor: pointer;
      transition: 0.3s ease;
    }

    .metode-box:hover,
    .metode-box.active {
      border-color: #800000;
      background-color: #fff3f3;
    }

    .metode-box img {
      height: 40px;
      margin-bottom: 10px;
    }

    .metode-option input[type="radio"] {
      display: none;
    }

    .table th, .table td {
  vertical-align: middle;
}

  </style>
</head>
<body>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
      <div class="form-wrapper">
        <h2 class="title"><i class="fas fa-money-check-alt me-2"></i>Pembayaran</h2>

        <div class="text-center mb-4">
          <span class="badge-total">Total Tagihan: <strong>Rp <?= number_format($transaksi['total'], 0, ',', '.') ?></strong></span>
        </div>

        <form action="<?= base_url('/proses-bayar') ?>" method="post" id="formPembayaran">
          <input type="hidden" name="transaksi_id" value="<?= $transaksi['id'] ?>">

          <div class="mb-3">
            <label for="nama" class="form-label"><i class="fas fa-user"></i>Nama Lengkap</label>
            <input type="text" class="form-control" name="nama" id="nama" required placeholder="Masukkan nama lengkap">
          </div>

          <div class="mb-3">
            <label for="telepon" class="form-label"><i class="fas fa-phone"></i>No. Telepon</label>
            <input type="text" class="form-control" name="telepon" id="telepon" required placeholder="08xxxxxxxxxx">
          </div>

          <div class="mb-3">
            <label for="alamat" class="form-label"><i class="fas fa-map-marker-alt"></i>Alamat Pengiriman</label>
            <textarea name="alamat" class="form-control" rows="3" required placeholder="Tulis alamat lengkap pengiriman"></textarea>
          </div>

          <div class="mb-3">
            <label for="catatan" class="form-label"><i class="fas fa-sticky-note"></i>Catatan Tambahan (Opsional)</label>
            <textarea name="catatan" class="form-control" rows="2" placeholder="Contoh: Tolong kirim siang, tanpa plastik, dll."></textarea>
          </div>

          <div class="mb-4">
            <label class="form-label"><i class="fas fa-wallet"></i>Metode Pembayaran</label>
            <div class="row metode-option g-3">

              <!-- BANK -->
              <div class="col-md-4">
                <label class="metode-box d-block">
                  <input type="radio" name="metode" value="Transfer Bank" required>
                  <img src="<?= base_url('icons/bank.png') ?>" alt="Bank">
                  <div>Transfer Bank</div>
                </label>
              </div>

              <!-- E-WALLET -->
              <div class="col-md-4">
                <label class="metode-box d-block">
                  <input type="radio" name="metode" value="E-Wallet" required>
                  <img src="<?= base_url('icons/e_wallet.png') ?>" alt="E-Wallet">
                  <div>E-Wallet (OVO/Dana/Gopay)</div>
                </label>
              </div>

              <!-- COD -->
              <div class="col-md-4">
                <label class="metode-box d-block">
                  <input type="radio" name="metode" value="COD" required>
                  <img src="<?= base_url('icons/cod.png') ?>" alt="COD">
                  <div>Bayar di Tempat (COD)</div>
                </label>
              </div>

            </div>
          </div>

          <div class="d-grid mt-4">
            <button type="submit" class="btn btn-maroon btn-lg">
              <i class="fas fa-check-circle me-1"></i> Bayar Sekarang
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- PRODUK YANG AKAN DIBAYAR -->
<div class="mt-5">
  <h5 class="mb-3 text-maroon text-center"><i class="fas fa-box-open me-2"></i>LIST PRODUK YANG AKAN DIBAYAR</h5>
  <div class="table-responsive">
    <table class="table table-hover table-bordered align-middle bg-white shadow-sm rounded-3">
      <thead class="table-light text-center">
        <tr>
          <th>Gambar</th>
          <th>Produk</th>
          <th>Harga</th>
          <th>Jumlah</th>
          <th>Subtotal</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($produkDibeli as $item): ?>
          <tr>
            <td class="text-center">
              <img src="<?= base_url('images/' . $item['image']) ?>" alt="<?= esc($item['nama_produk']) ?>" class="img-thumbnail rounded" style="width: 60px; height: 60px; object-fit: cover;">
            </td>
            <td><?= esc($item['nama_produk']) ?></td>
            <td class="text-end">Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
            <td class="text-center"><?= $item['qty'] ?></td>
            <td class="text-end fw-bold">Rp <?= number_format($item['harga'] * $item['qty'], 0, ',', '.') ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- JS untuk highlight pilihan metode -->
<script>
  const metodeBoxes = document.querySelectorAll('.metode-box');
  metodeBoxes.forEach(box => {
    box.addEventListener('click', () => {
      metodeBoxes.forEach(b => b.classList.remove('active'));
      box.classList.add('active');
      box.querySelector('input[type="radio"]').checked = true;
    });
  });
</script>

</body>
</html>
