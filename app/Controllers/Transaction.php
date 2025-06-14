<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\ProductModel;
use App\Models\PaymentModel;

class Transaction extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Anda harus login untuk melihat riwayat transaksi.');
        }

        $userId = session()->get('id');
        $orderModel = new OrderModel();
        $data['orders'] = $orderModel->where('user_id', $userId)
                                     ->orderBy('order_date', 'DESC')
                                     ->findAll();
        return view('transaksi_history', $data);
    }

    public function detail($orderId)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Anda harus login untuk melihat detail transaksi.');
        }

        $userId = session()->get('id');
        $orderModel = new OrderModel();
        $orderItemModel = new OrderItemModel();
        $productModel = new ProductModel();
        $paymentModel = new PaymentModel();

        $order = $orderModel->where('id', $orderId)->where('user_id', $userId)->first();
        if (!$order) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Transaksi tidak ditemukan atau Anda tidak memiliki akses.");
        }

        $orderItems = $orderItemModel->where('order_id', $orderId)->findAll();
        $productsInOrder = [];
        foreach ($orderItems as $item) {
            $product = $productModel->find($item['product_id']);
            if ($product) {
                $productsInOrder[] = array_merge($item, ['product_name' => $product['name'], 'product_image' => $product['image']]);
            }
        }

        $payment = $paymentModel->where('order_id', $orderId)->first();

        $data['order'] = $order;
        $data['order_items'] = $productsInOrder;
        $data['payment'] = $payment;

        return view('transaksi_detail', $data);
    }

}