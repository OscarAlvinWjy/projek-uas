<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\TransaksiModel;
use App\Models\TransaksiDetailModel;

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
        return $this->addToCart($id, false);
    }

    public function ajaxTambah($id)
    {
        $model = new ProductModel();
        $product = $model->find($id);

        if (!$product) {
            return $this->response->setJSON(['success' => false, 'message' => 'Produk tidak ditemukan']);
        }

        $session = session();
        $cart = $session->get('cart') ?? [];

        if (isset($cart[$id])) {
            if ($cart[$id]['qty'] < $product['stock']) {
                $cart[$id]['qty'] += 1;
            }
        } else {
            $cart[$id] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'image' => $product['image'],
                'qty' => 1,
                'stock' => $product['stock']
            ];
        }

        $session->set('cart', $cart);
        $session->set('cart_count', array_sum(array_column($cart, 'qty')));

        return $this->response->setJSON([
            'success' => true,
            'cart_count' => $session->get('cart_count')
        ]);
    }

    private function addToCart($id, $isAjax = false)
    {
        $model = new ProductModel();
        $product = $model->find($id);

        if (!$product) {
            if ($isAjax) {
                return $this->response->setJSON(['success' => false, 'message' => 'Produk tidak ditemukan.']);
            }
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        $session = session();
        $cart = $session->get('cart') ?? [];

        if (isset($cart[$id])) {
            if ($cart[$id]['qty'] < $product['stock']) {
                $cart[$id]['qty'] += 1;
            }
        } else {
            $cart[$id] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'image' => $product['image'],
                'qty' => 1,
                'stock' => $product['stock']
            ];
        }

        $session->set('cart', $cart);
        $session->set('cart_count', array_sum(array_column($cart, 'qty')));
        $session->set('last_product_id', $id);

        if ($isAjax) {
            return $this->response->setJSON(['success' => true, 'message' => 'Produk berhasil ditambahkan.']);
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

    public function update($id)
    {
        $action = $this->request->getPost('action');
        $session = session();
        $cart = $session->get('cart') ?? [];

        if (!isset($cart[$id])) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan di keranjang.');
        }

        $model = new ProductModel();
        $product = $model->find($id);
        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        $qty = $cart[$id]['qty'];
        $maxStock = $product['stock'];

        if ($action === 'increase') {
            if ($qty < $maxStock) {
                $cart[$id]['qty']++;
            }
        } elseif ($action === 'decrease') {
            if ($qty > 1) {
                $cart[$id]['qty']--;
            }
        }

        $session->set('cart', $cart);
        $session->set('cart_count', array_sum(array_column($cart, 'qty')));

        return redirect()->to('/keranjang');
    }

    public function checkout()
    {
        $session = session();
        $cart = $session->get('cart');

        if (!$cart || count($cart) === 0) {
            return redirect()->to('/keranjang')->with('error', 'Keranjang kosong.');
        }

        $userId = $session->get('user_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['qty'];
        }

        $transaksiModel = new TransaksiModel();
        $transaksiId = $transaksiModel->insert([
            'user_id' => $userId,
            'total' => $total
        ]);

        $detailModel = new TransaksiDetailModel();
        foreach ($cart as $item) {
            $detailModel->insert([
                'transaksi_id' => $transaksiId,
                'produk_id' => $item['id'],
                'nama_produk' => $item['name'],
                'harga' => $item['price'],
                'qty' => $item['qty']
            ]);
        }

        $session->remove('cart');
        $session->remove('cart_count');
        $session->remove('last_product_id');
        $session->remove('keranjang_from');

        return view('checkout_sukses', [
            'total' => $total,
            'transaksi_id' => $transaksiId
        ]);
    }

    public function pembayaran($id)
    {
        $transaksiModel = new TransaksiModel();
        $transaksi = $transaksiModel->find($id);

        if (!$transaksi) {
            return redirect()->to('/dashboard')->with('error', 'Transaksi tidak ditemukan.');
        }

        return view('pembayaran', ['transaksi' => $transaksi]);
    }

    public function prosesBayar()
    {
        $metode = $this->request->getPost('metode');
        $transaksiId = $this->request->getPost('transaksi_id');

        return view('pembayaran_sukses', ['metode' => $metode]);
    }
}
