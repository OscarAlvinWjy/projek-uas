<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $produk = [
            ['Sepatu Sneakers Pria', 'sepatu1.jpg', 250000],
            ['Sepatu Running Wanita', 'sepatu2.jpg', 275000],
            ['Sepatu Casual Unisex', 'sepatu3.jpg', 300000],
            ['Sepatu Olahraga Pro', 'sepatu4.jpg', 320000],
        ];

        return view('dashboard', ['produk' => $produk]);
    }
}
