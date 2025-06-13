<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Product extends BaseController
{
    public function detail($id)
    {
        $model = new ProductModel();
        $product = $model->find($id);

        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Produk tidak ditemukan");
        }

        return view('produk_detail', ['product' => $product]);
    }
}
