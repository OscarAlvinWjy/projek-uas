<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Product extends BaseController
{
    public function detail($id)
    {
        $productModel = new ProductModel();
        $product = $productModel->find($id);

        if (!$product) {
            return redirect()->to('/dashboard')->with('error', 'Produk tidak ditemukan.');
        }

        // Cari produk sebelumnya dan selanjutnya
        $prev = $productModel->where('id <', $id)->orderBy('id', 'desc')->first();
        $next = $productModel->where('id >', $id)->orderBy('id', 'asc')->first();

        return view('produk_detail', [
            'product' => $product,
            'prevProductId' => $prev ? $prev['id'] : null,
            'nextProductId' => $next ? $next['id'] : null
        ]);
    }
}
