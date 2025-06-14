<?php

namespace App\Controllers;

use App\Models\ProductModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\UserModel; // Ditambahkan untuk mengambil detail pengguna

class Checkout extends BaseController
{
    public function index(): string
    {
        $session = session();
        $userId = $session->get('id');

        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login untuk melanjutkan checkout.');
        }

        $cart = $session->get('cart') ?? [];

        if (empty($cart)) {
            return redirect()->to('/keranjang')->with('error', 'Keranjang belanja Anda kosong.');
        }

        $productModel = new ProductModel();
        $userModel = new UserModel(); // Instansiasi UserModel
        $items = [];
        $subtotalProduk = 0;

        // Ambil data lengkap pengguna, termasuk alamat dan telepon
        $pengguna = $userModel->find($userId);

        if (!$pengguna) {
            return redirect()->to('/login')->with('error', 'Informasi pengguna tidak ditemukan. Silakan login kembali.');
        }

        foreach ($cart as $productId => $item) {
            $product = $productModel->find($productId);
            if ($product) {
                // Pastikan stok mencukupi sebelum ditampilkan untuk checkout
                if ($product['stock'] < $item['qty']) {
                    return redirect()->to('/keranjang')->with('error', 'Stok produk ' . esc($product['name']) . ' tidak mencukupi. Silakan sesuaikan jumlah di keranjang.');
                }
                $items[] = [
                    'produk' => $product,
                    'jumlah' => $item['qty']
                ];
                $subtotalProduk += $product['price'] * $item['qty'];
            }
        }
        
        // Definisikan opsi pengiriman (data dummy)
        $opsi_pengiriman = [
            ['nama' => 'Reguler', 'estimasi' => '3-5 hari kerja', 'harga' => 15000],
            ['nama' => 'Ekspress', 'estimasi' => '1-2 hari kerja', 'harga' => 30000],
        ];

        // Definisikan metode pembayaran (data dummy)
        $metode_pembayaran = [
            'Transfer Bank (BCA)',
            'Transfer Bank (Mandiri)',
            'OVO',
            'GoPay',
            'Dana'
        ];

        $data = [
            'pengguna' => $pengguna, // Kirim data pengguna ke tampilan
            'items' => $items,
            'subtotal_produk' => $subtotalProduk,
            'opsi_pengiriman' => $opsi_pengiriman,
            'metode_pembayaran' => $metode_pembayaran,
            'validation' => \Config\Services::validation()
        ];

        return view('checkout', $data);
    }

    public function processOrder(): RedirectResponse
    {
        $session = session();
        $userId = $session->get('id');

        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login untuk melanjutkan.');
        }

        $cart = $session->get('cart') ?? [];

        if (empty($cart)) {
            return redirect()->to('/keranjang')->with('error', 'Keranjang belanja Anda kosong.');
        }

        $productModel = new ProductModel();
        $orderModel = new \App\Models\OrderModel();
        $orderItemModel = new \App\Models\OrderItemModel();
        $paymentModel = new \App\Models\PaymentModel();
        $userModel = new UserModel(); // Instansiasi UserModel untuk mendapatkan alamat/telepon default pengguna

        // Ambil data lengkap pengguna untuk mendapatkan alamat dan telepon default jika diperlukan
        $pengguna = $userModel->find($userId);
        if (!$pengguna) {
             return redirect()->to('/login')->with('error', 'Informasi pengguna tidak ditemukan. Silakan login kembali.');
        }

        $rules = [
            // Dihapus shipping_address dan shipping_phone dari aturan karena sekarang berasal dari profil pengguna
            'alamat_pengiriman' => 'required|min_length[10]', // Ini akan menjadi input tersembunyi dari profil
            'opsi_pengiriman' => 'required',
            'metode_pembayaran' => 'required',
            'biaya_pengiriman' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            // Flash input lama dan kesalahan kembali ke formulir
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $subtotalProduk = 0;
        foreach ($cart as $productId => $item) {
            $product = $productModel->find($productId);
            if ($product) {
                // Periksa ulang stok sebelum melanjutkan transaksi
                if ($product['stock'] < $item['qty']) {
                    return redirect()->to('/keranjang')->with('error', 'Stok produk ' . esc($product['name']) . ' tidak mencukupi saat proses checkout. Silakan periksa keranjang Anda.');
                }
                $subtotalProduk += $product['price'] * $item['qty'];
            }
        }

        // Ambil detail pengiriman dari input tersembunyi (yang berasal dari profil pengguna)
        $alamatPengiriman = $this->request->getPost('alamat_pengiriman');
        // Anda mungkin perlu mengambil nomor telepon dari objek $pengguna jika tidak dikirim sebagai bidang terpisah
        $noTeleponPengguna = $pengguna['no_telepon']; // Diasumsikan 'no_telepon' adalah nama kolom di tabel pengguna Anda

        $biayaPengiriman = $this->request->getPost('biaya_pengiriman');
        $metodePembayaran = $this->request->getPost('metode_pembayaran');

        $totalHarga = $subtotalProduk + $biayaPengiriman;

        $db = \Config\Database::connect();
        $db->transStart(); // Mulai transaksi basis data

        try {
            $orderData = [
                'user_id' => $userId,
                'order_date' => date('Y-m-d H:i:s'),
                'total_price' => $totalHarga,
                'shipping_address' => $alamatPengiriman, // Simpan alamat pengiriman
                'shipping_phone' => $noTeleponPengguna, // Simpan nomor telepon pengiriman
                'shipping_cost' => $biayaPengiriman, // Simpan biaya pengiriman
                'shipping_method' => $this->request->getPost('opsi_pengiriman'), // Simpan nama metode pengiriman
                'status' => 'pending' // Status awal
            ];
            $orderModel->insert($orderData);
            $orderId = $orderModel->getInsertID(); // Dapatkan ID pesanan yang baru saja dimasukkan

            foreach ($cart as $productId => $item) {
                $product = $productModel->find($productId);
                if ($product) {
                    $orderItemData = [
                        'order_id' => $orderId,
                        'product_id' => $productId,
                        'quantity' => $item['qty'],
                        'price' => $product['price'] // Harga produk saat pemesanan
                    ];
                    $orderItemModel->insert($orderItemData);

                    // Kurangi stok produk
                    $productModel->update($productId, ['stock' => $product['stock'] - $item['qty']]);
                }
            }

            $paymentData = [
                'order_id' => $orderId,
                'payment_method' => $metodePembayaran,
                'payment_date' => date('Y-m-d H:i:s'),
                'amount' => $totalHarga, // Jumlah total untuk pembayaran ini
                'status' => 'pending' // Status pembayaran awal
            ];
            $paymentModel->insert($paymentData);

            $db->transComplete(); // Selesaikan transaksi basis data

            if ($db->transStatus() === false) {
                // Transaksi gagal, ada yang salah
                throw new \Exception('Gagal memproses pesanan.');
            }

            // Hapus keranjang setelah pesanan berhasil
            $session->remove('cart');
            $session->remove('cart_count');

            // Flash data untuk pesan sukses di halaman berikutnya
            $session->setFlashdata('checkout_address', $alamatPengiriman);
            $session->setFlashdata('checkout_phone', $noTeleponPengguna);

            return redirect()->to('/transaksi')->with('success', 'Pesanan Anda berhasil dibuat! Silakan lakukan pembayaran.');
        } catch (\Exception $e) {
            $db->transRollback(); // Batalkan transaksi jika terjadi kesalahan
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage());
        }
    }
}