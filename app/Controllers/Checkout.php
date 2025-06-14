<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ProductModel; 

class Checkout extends BaseController
{
    public function index()
    {
        $session = session();
        $cart = $session->get('cart') ?? [];

        if (empty($cart)) {
            return redirect()->to('/keranjang')->with('error', 'Keranjang belanja Anda kosong.');
        }

        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['qty'];
        }

        $data = [
            'cart' => $cart,
            'totalPrice' => $totalPrice,
            'userName' => $session->get('name'), 
        ];

        return view('checkout', $data);
    }

    public function processPayment()
{
    $session = session();
    $cart = $session->get('cart') ?? [];
    $paymentMethod = $this->request->getPost('payment_method');

    if (empty($cart)) {
        return redirect()->to('/keranjang')->with('error', 'Keranjang kosong.');
    }

    $totalPrice = 0;
    foreach ($cart as $item) {
        $totalPrice += $item['price'] * $item['qty'];
    }

    // Simpan ke tabel transaksi
    $transaksiModel = new \App\Models\TransaksiModel();
    $transaksiId = $transaksiModel->insert([
        'user_id' => $session->get('id'),
        'total' => $totalPrice,
        'tanggal' => date('Y-m-d H:i:s')
    ]);

    // Simpan detail transaksi
    $transaksiDetailModel = new \App\Models\TransaksiDetailModel();
    foreach ($cart as $item) {
        $transaksiDetailModel->insert([
            'transaksi_id' => $transaksiId,
            'produk_id' => $item['id'],
            'nama_produk' => $item['name'],
            'harga' => $item['price'],
            'qty' => $item['qty']
        ]);
    }

    // Kosongkan keranjang
    $session->remove('cart');
    $session->remove('cart_count');

    return view('payment_success', [
        'totalPrice' => $totalPrice,
        'paymentMethod' => $paymentMethod
    ]);
}

}