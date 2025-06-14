<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id',
        'order_date',
        'total_price',
        'status',
        'shipping_address',   // <-- Tambahkan ini
        'shipping_method',    // <-- Tambahkan ini
        'shipping_cost',      // <-- Tambahkan ini
        'payment_method'      
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'order_date';
    protected $updatedField  = null; // Or 'updated_at' if you have it
}