<?php

namespace App\Controllers;
use App\Models\ProductModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();
        $products = $productModel->findAll(); // ambil semua produk

        return view('dashboard', ['products' => $products]);
    }
}
