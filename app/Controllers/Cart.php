<?php

namespace App\Controllers;

use App\Models\ProductModel;

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
}
