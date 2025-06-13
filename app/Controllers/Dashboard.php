<?php

namespace App\Controllers;
use App\Models\ProductModel;

class Dashboard extends BaseController
{
    public function index()
{
    $model = new ProductModel();
    $data['products'] = $model->findAll();
    
    return view('dashboard', $data);
}

}
