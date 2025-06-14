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
        $paymentMethod = $this->request->getPost('payment_method');
        $cart = $session->get('cart') ?? [];

        if (empty($cart)) {
            return redirect()->to('/keranjang')->with('error', 'Keranjang belanja Anda kosong.');
        }

        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['qty'];
        }

        $session->remove('cart');
        $session->remove('cart_count');

        $data = [
            'totalPrice' => $totalPrice,
            'paymentMethod' => $paymentMethod,
        ];

        return view('payment_success', $data);
    }
}