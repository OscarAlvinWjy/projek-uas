<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\PaymentModel;

class Cart extends BaseController
{
public function index()
{
    $session = session();

    // Simpan asal halaman hanya kalau dikirim dari query string
    $from = $this->request->getGet('from');
    if ($from) {
        $session->set('keranjang_from', $from);
    }

    $data['cart'] = $session->get('cart') ?? [];
    $data['lastProductId'] = $session->get('last_product_id');
    $data['keranjangFrom'] = $session->get('keranjang_from') ?? 'dashboard';

    return view('keranjang', $data);
}


public function add($id)
{
    $model = new ProductModel();
    $product = $model->find($id);

    if (!$product) {
        return redirect()->back()->with('error', 'Produk tidak ditemukan.');
    }

    $session = session();
    $cart = $session->get('cart') ?? [];

    if (isset($cart[$id])) {
        $cart[$id]['qty'] += 1;
    } else {
        $cart[$id] = [
            'id' => $product['id'],
            'name' => $product['name'],
            'price' => $product['price'],
            'image' => $product['image'],
            'qty' => 1
        ];
    }

    $session->set('cart', $cart);
    $session->set('cart_count', array_sum(array_column($cart, 'qty')));
    $session->set('last_product_id', $id);

    // Simpan asal halaman jika ada
    $from = $this->request->getGet('from');
    if ($from) {
        $session->set('keranjang_from', $from);
    }

    return redirect()->to('/keranjang')->with('success', 'Produk ditambahkan ke keranjang.');
}



    public function remove($id)
    {
        $session = session();
        $cart = $session->get('cart') ?? [];

        if (isset($cart[$id])) {
            unset($cart[$id]);
            $session->set('cart', $cart);
            $session->set('cart_count', array_sum(array_column($cart, 'qty')));
        }

        return redirect()->to('/keranjang')->with('success', 'Produk dihapus dari keranjang.');
    }
   public function showCheckoutForm()
    {
        $session = session();
        $cart = $session->get('cart') ?? [];
        $user_id = $session->get('id');

        if (empty($cart)) {
            return redirect()->to('/keranjang')->with('error', 'Keranjang belanja Anda kosong.');
        }

        if (!$user_id) {
            return redirect()->to('/login')->with('error', 'Anda harus login untuk melanjutkan checkout.');
        }

        $userModel = new UserModel();
        $pengguna = $userModel->find($user_id);

        // Jika data pengguna tidak ditemukan atau tidak lengkap
        // Kita akan menggunakan placeholder atau data dari sesi jika ada
        $nama_lengkap = $pengguna['name'] ?? 'Nama Pengguna'; // Mengambil 'name' dari tabel users
        // Untuk no_telepon dan alamat, karena tidak ada di DB users,
        // kita akan menggunakan data dummy atau membiarkannya kosong.
        // Di sini saya akan menggunakan placeholder seperti pada contoh tampilan Anda.
        $no_telepon = '81234567890'; // Dummy
        $alamat = 'Jl. Dummy No. 123, Kota Contoh, Provinsi Contoh'; // Dummy


        $productModel = new ProductModel();
        $items_for_checkout = [];
        $subtotal_produk = 0;

        foreach ($cart as $item) {
            $product_detail = $productModel->find($item['id']);
            if ($product_detail) {
                $items_for_checkout[] = [
                    'produk' => [
                        'nama' => $product_detail['name'],
                        'gambar' => $product_detail['image'],
                        'harga' => $product_detail['price'],
                        'id' => $product_detail['id']
                    ],
                    'jumlah' => $item['qty']
                ];
                $subtotal_produk += ($product_detail['price'] * $item['qty']);
            }
        }

        $opsi_pengiriman = [
            ['nama' => 'Reguler', 'harga' => 15000, 'estimasi' => '3-5 hari kerja'],
            ['nama' => 'Ekspres', 'harga' => 30000, 'estimasi' => '1-2 hari kerja'],
            ['nama' => 'Cargo', 'harga' => 50000, 'estimasi' => '5-7 hari kerja'],
        ];

        $metode_pembayaran = [
            'Transfer Bank',
            'COD (Cash On Delivery)',
            'Gopay',
            'OVO'
        ];
        
        $data = [
            'pengguna' => [
                'nama_lengkap' => $nama_lengkap,
                'no_telepon' => $no_telepon,
                'alamat' => $alamat,
            ],
            'items' => $items_for_checkout,
            'subtotal_produk' => $subtotal_produk,
            'opsi_pengiriman' => $opsi_pengiriman,
            'metode_pembayaran' => $metode_pembayaran,
        ];

        return view('checkout_form', $data);
    }

    public function prosesPesanan()
    {
        $session = session();
        $cart = $session->get('cart') ?? [];
        $user_id = $session->get('id');
        $user_name = $session->get('name'); // Ambil nama pengguna dari sesi

        if (empty($cart)) {
            return redirect()->to('/keranjang')->with('error', 'Keranjang belanja Anda kosong.');
        }

        if (!$user_id) {
            return redirect()->to('/login')->with('error', 'Anda harus login untuk melanjutkan checkout.');
        }

        // Data alamat dan telepon akan diambil dari hidden input atau placeholder
        // karena tidak disimpan di tabel users
        $alamat_pengiriman = $this->request->getPost('alamat_pengiriman');
        // No telepon bisa diambil dari data dummy yang sama atau dihilangkan jika tidak relevan
        // Jika ingin menyimpan no telepon spesifik untuk pesanan, tambahkan input di form checkout
        $no_telepon_pesanan = '081234567890'; // Menggunakan dummy phone number for the order record

        $opsi_pengiriman_nama = $this->request->getPost('opsi_pengiriman');
        $biaya_pengiriman = $this->request->getPost('biaya_pengiriman');
        $metode_pembayaran = $this->request->getPost('metode_pembayaran');

        $orderModel = new OrderModel();
        $orderItemModel = new OrderItemModel();
        $productModel = new ProductModel();

        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += ($item['price'] * $item['qty']);
        }
        $totalPrice += floatval($biaya_pengiriman);

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Create a new order
            $orderData = [
                'user_id' => $user_id,
                'order_date' => date('Y-m-d H:i:s'),
                'total_price' => $totalPrice,
                'status' => 'pending',
                'shipping_address' => $alamat_pengiriman,
                'shipping_method' => $opsi_pengiriman_nama,
                'shipping_cost' => $biaya_pengiriman,
                'payment_method' => $metode_pembayaran,
            ];
            $orderModel->insert($orderData);
            $orderId = $orderModel->getInsertID();

            // Add items to order_items and update product stock
            foreach ($cart as $item) {
                $product = $productModel->find($item['id']);
                if (!$product || $product['stock'] < $item['qty']) {
                    $db->transRollback();
                    return redirect()->to('/keranjang')->with('error', 'Stok produk "' . esc($item['name']) . '" tidak mencukupi atau produk tidak ditemukan.');
                }

                $orderItemData = [
                    'order_id' => $orderId,
                    'product_id' => $item['id'],
                    'quantity' => $item['qty'],
                    'price' => $item['price'],
                ];
                $orderItemModel->insert($orderItemData);

                $newStock = $product['stock'] - $item['qty'];
                $productModel->update($item['id'], ['stock' => $newStock]);
            }

            $db->transComplete();

            if ($db->transStatus() === FALSE) {
                return redirect()->to('/keranjang')->with('error', 'Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.');
            } else {
                $session->remove('cart');
                $session->set('cart_count', 0);
                return redirect()->to('/checkout/success/' . $orderId)->with('success', 'Pesanan Anda telah berhasil ditempatkan.');
            }

        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->to('/keranjang')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}