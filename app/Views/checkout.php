<?= $this->extend('layout') ?> <?= $this->section('content') ?>
    <div class="container py-5">
        <h2>Checkout</h2>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <?php if (isset($validation)): ?>
            <div class="alert alert-danger">
                <?= $validation->listErrors() ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= site_url('checkout/processOrder') ?>">
            <div class="checkout-grid">
                <div class="checkout-main">
                    <div class="checkout-section">
                        <h4>Informasi Pengiriman</h4>
                        <p class="text-muted small">Informasi ini akan digunakan untuk pengiriman pesanan Anda dan tidak disimpan di profil Anda.</p>
                        <div class="mb-3">
                            <label for="shipping_address" class="form-label">Alamat Lengkap Pengiriman</label>
                            <textarea class="form-control" id="shipping_address" name="shipping_address" rows="3" required><?= old('shipping_address') ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="shipping_phone" class="form-label">Nomor Telepon Penerima</label>
                            <input type="text" class="form-control" id="shipping_phone" name="shipping_phone" value="<?= old('shipping_phone') ?>" required>
                        </div>
                    </div>

                    <div class="checkout-section">
                        <h4>Produk Dipesan</h4>
                        <?php if (!empty($items)): ?>
                            <?php foreach($items as $item): ?>
                            <div class="product-checkout-item">
                                <img src="<?= base_url('images/' . esc($item['produk']['image'])) ?>" alt="<?= esc($item['produk']['name']) ?>">
                                <div class="product-info">
                                    <p class="product-name"><?= esc($item['produk']['name']) ?></p>
                                    <p class="product-qty">x <?= esc($item['jumlah']) ?></p>
                                </div>
                                <p class="product-price">Rp <?= number_format(esc($item['produk']['price'] * $item['jumlah']), 0, ',', '.') ?></p>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Tidak ada produk di keranjang.</p>
                        <?php endif; ?>
                    </div>

                    <div class="checkout-section">
                        <h4>Opsi Pengiriman</h4>
                        <?php if (!empty($opsi_pengiriman)): ?>
                            <?php foreach($opsi_pengiriman as $index => $opsi): ?>
                            <div class="option-item">
                                <input type="radio" name="opsi_pengiriman" id="opsi-<?= $index ?>" value="<?= esc($opsi['nama']) ?>" data-harga="<?= esc($opsi['harga']) ?>" <?= $index === 0 ? 'checked' : '' ?>>
                                <label for="opsi-<?= $index ?>">
                                    <div>
                                        <strong><?= esc($opsi['nama']) ?></strong>
                                        <p class="estimasi">Estimasi tiba: <?= esc($opsi['estimasi']) ?></p>
                                    </div>
                                    <span class="option-price">Rp <?= number_format(esc($opsi['harga']), 0, ',', '.') ?></span>
                                </label>
                            </div>
                            <?php endforeach; ?>
                            <input type="hidden" name="biaya_pengiriman" id="biaya_pengiriman" value="<?= esc($opsi_pengiriman[0]['harga']) ?>">
                        <?php else: ?>
                            <p>Opsi pengiriman tidak tersedia.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="checkout-sidebar">
                    <div class="checkout-section">
                        <h4>Metode Pembayaran</h4>
                        <select name="metode_pembayaran" class="form-select payment-select">
                        <?php if (!empty($metode_pembayaran)): ?>
                            <?php foreach($metode_pembayaran as $metode): ?>
                                <option value="<?= esc($metode) ?>" <?= old('metode_pembayaran') == $metode ? 'selected' : '' ?>><?= esc($metode) ?></option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="">Metode pembayaran tidak tersedia</option>
                        <?php endif; ?>
                        </select>
                    </div>

                    <div class="checkout-section">
                        <h4>Rincian Pembayaran</h4>
                        <div class="payment-summary">
                            <div>
                                <span>Subtotal Produk</span>
                                <span id="summary-subtotal">Rp <?= number_format(esc($subtotal_produk), 0, ',', '.') ?></span>
                            </div>
                            <div>
                                <span>Biaya Pengiriman</span>
                                <span id="summary-pengiriman">Rp <?= number_format(esc($opsi_pengiriman[0]['harga']), 0, ',', '.') ?></span>
                            </div>
                            <hr>
                            <div class="total-payment">
                                <span>Total Pembayaran</span>
                                <span id="summary-total">Rp <?= number_format(esc($subtotal_produk + $opsi_pengiriman[0]['harga']), 0, ',', '.') ?></span>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success" style="width: 100%;">Buat Pesanan</button>
                </div>
            </div>
        </form>
    </div>

    <style>
        
        .checkout-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; }
        .checkout-section { background: #fff; border: 1px solid #eee; border-radius: 5px; padding: 20px; margin-bottom: 20px; }
        .address-box { margin-bottom: 15px; } /* Tambahan margin */
        .product-checkout-item { display: flex; align-items: center; gap: 15px; margin-bottom: 10px; border-bottom: 1px solid #eee; padding-bottom: 10px;}
        .product-checkout-item:last-child { border-bottom: none; }
        .product-checkout-item img { width: 60px; height: 60px; object-fit: cover; border-radius: 5px; }
        .product-info { flex-grow: 1; }
        .product-name, .product-qty { margin: 0; }
        .product-price { font-weight: bold; }
        .option-item { margin-bottom: 10px; }
        .option-item label { display: flex; justify-content: space-between; align-items: center; border: 1px solid #ccc; padding: 15px; border-radius: 5px; cursor: pointer; }
        .option-item input[type="radio"] { display: none; }
        .option-item input[type="radio"]:checked + label { border-color: #800000; background-color: #fff0f0; } /* Warna sesuai tema Anda */
        .option-price { font-weight: bold; color: #333; }
        .estimasi { font-size: 0.9em; color: #666; margin: 0; }
        .payment-select { width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc; }
        .payment-summary > div { display: flex; justify-content: space-between; margin-bottom: 10px; }
        .payment-summary .total-payment { font-weight: bold; font-size: 1.2em; }
        @media (max-width: 992px) { .checkout-grid { grid-template-columns: 1fr; } }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const subtotalProduk = <?= $subtotal_produk ?>;
            const pengirimanRadios = document.querySelectorAll('input[name="opsi_pengiriman"]');
            
            const summaryPengiriman = document.getElementById('summary-pengiriman');
            const summaryTotal = document.getElementById('summary-total');
            const biayaPengirimanInput = document.getElementById('biaya_pengiriman');

            const initialBiaya = parseFloat(document.querySelector('input[name="opsi_pengiriman"]:checked').dataset.harga);
            summaryPengiriman.textContent = 'Rp ' + initialBiaya.toLocaleString('id-ID');
            summaryTotal.textContent = 'Rp ' + (subtotalProduk + initialBiaya).toLocaleString('id-ID');
            biayaPengirimanInput.value = initialBiaya;

            pengirimanRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    const biaya = parseFloat(this.dataset.harga);
                    const total = subtotalProduk + biaya;

                    summaryPengiriman.textContent = 'Rp ' + biaya.toLocaleString('id-ID');
                    summaryTotal.textContent = 'Rp ' + total.toLocaleString('id-ID');
                    biayaPengirimanInput.value = biaya;
                });
            });
        });
    </script>
<?= $this->endSection() ?>