<?php

namespace App\Controllers;

use App\Models\ProductModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Exceptions\PageNotFoundException;

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
        $items = [];
        $subtotalProduk = 0;

        foreach ($cart as $productId => $item) {
            $product = $productModel->find($productId);
            if ($product) {
             
                if ($product['stock'] < $item['qty']) {
                    return redirect()->to('/keranjang')->with('error', 'Stok produk ' . esc($product['name']) . ' tidak mencukupi.');
                }
                $items[] = [
                    'produk' => $product,
                    'jumlah' => $item['qty']
                ];
                $subtotalProduk += $product['price'] * $item['qty'];
            }
        }
        $namaPengguna = $session->get('name');
  
        $opsi_pengiriman = [
            ['nama' => 'Reguler', 'estimasi' => '3-5 hari kerja', 'harga' => 15000],
            ['nama' => 'Ekspress', 'estimasi' => '1-2 hari kerja', 'harga' => 30000],
        ];

        $metode_pembayaran = [
            'Transfer Bank (BCA)',
            'Transfer Bank (Mandiri)',
            'OVO',
            'GoPay',
            'Dana'
        ];

        $data = [
            'nama_pengguna' => $namaPengguna, 
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

        $rules = [
            'shipping_address' => 'required|min_length[10]',
            'shipping_phone' => 'required|numeric|min_length[10]|max_length[15]',
            'metode_pembayaran' => 'required',
            'biaya_pengiriman' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $subtotalProduk = 0;
        foreach ($cart as $productId => $item) {
            $product = $productModel->find($productId);
            if ($product) {
             
                if ($product['stock'] < $item['qty']) {
                    return redirect()->to('/keranjang')->with('error', 'Stok produk ' . esc($product['name']) . ' tidak mencukupi saat proses checkout. Silakan periksa keranjang Anda.');
                }
                $subtotalProduk += $product['price'] * $item['qty'];
            }
        }

        $shippingAddress = $this->request->getPost('shipping_address');
        $shippingPhone = $this->request->getPost('shipping_phone');

        $biayaPengiriman = $this->request->getPost('biaya_pengiriman');
        $metodePembayaran = $this->request->getPost('metode_pembayaran');

        $totalHarga = $subtotalProduk + $biayaPengiriman;

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $orderData = [
                'user_id' => $userId,
                'order_date' => date('Y-m-d H:i:s'),
                'total_price' => $totalHarga,
                'status' => 'pending' 
            ];
            $orderModel->insert($orderData);
            $orderId = $orderModel->getInsertID();

            foreach ($cart as $productId => $item) {
                $product = $productModel->find($productId);
                if ($product) {
                    $orderItemData = [
                        'order_id' => $orderId,
                        'product_id' => $productId,
                        'quantity' => $item['qty'],
                        'price' => $product['price'] 
                    ];
                    $orderItemModel->insert($orderItemData);

                    $productModel->update($productId, ['stock' => $product['stock'] - $item['qty']]);
                }
            }

            $paymentData = [
                'order_id' => $orderId,
                'payment_method' => $metodePembayaran,
                'payment_date' => date('Y-m-d H:i:s'),
                
            ];
            $paymentModel->insert($paymentData);

            $db->transComplete();

            if ($db->transStatus() === false) {
                
                throw new \Exception('Gagal memproses pesanan.');
            }

            $session->remove('cart');
            $session->remove('cart_count');

            $session->setFlashdata('checkout_address', $shippingAddress);
            $session->setFlashdata('checkout_phone', $shippingPhone);

            return redirect()->to('/transaksi')->with('success', 'Pesanan Anda berhasil dibuat! Silakan lakukan pembayaran.');
        } catch (\Exception $e) {
            $db->transRollback(); 
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage());
        }
    }
}