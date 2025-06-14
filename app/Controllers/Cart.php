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
    public function checout()
    {
        $session = session();

        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Anda harus login untuk melanjutkan checkout.');
        }

        $userId = session()->get('id');
        $cart = $session->get('cart') ?? [];

        if (empty($cart)) {
            return redirect()->to('/keranjang')->with('error', 'Keranjang belanja Anda kosong.');
        }

        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += ($item['price'] * $item['qty']);
        }

        $orderModel = new OrderModel();
        $orderItemModel = new OrderItemModel();
        $productModel = new ProductModel();
        $paymentModel = new PaymentModel();

        $db = \Config\Database::connect();
        $db->transStart();

        try {
           
            $orderData = [
                'user_id' => $userId,
                'order_date' => date('Y-m-d H:i:s'),
                'total_price' => $totalPrice,
                'status' => 'completed', 
            ];
            $orderModel->insert($orderData);
            $orderId = $orderModel->getInsertID();

            foreach ($cart as $item) {
                $product = $productModel->find($item['id']);
                if (!$product || $product['stock'] < $item['qty']) {
                    $db->transRollback();
                    return redirect()->to('/keranjang')->with('error', 'Stok produk "' . esc($item['name']) . '" tidak cukup.');
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

            $paymentMethod = 'Pembayaran Instan';
            $paymentData = [
                'order_id' => $orderId,
                'payment_method' => $paymentMethod,
                'payment_date' => date('Y-m-d H:i:s'),
                'payment_proof' => null, 
            ];
            $paymentModel->insert($paymentData);

            $db->transComplete();

            if ($db->transStatus() === false) {
                return redirect()->to('/keranjang')->with('error', 'Terjadi kesalahan database saat memproses pesanan Anda. Silakan coba lagi.');
            }

            $session->remove('cart');
            $session->remove('cart_count');
            $session->remove('last_product_id');

            return redirect()->to('/transaksi/' . $orderId)->with('success', 'Pesanan Anda telah berhasil dibayar dan dikonfirmasi!');

        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Checkout failed: ' . $e->getMessage());
            return redirect()->to('/keranjang')->with('error', 'Terjadi kesalahan saat checkout: ' . $e->getMessage() . '. Silakan hubungi admin.');
        }
    }
}
     