<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentModel extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'id';
    protected $allowedFields = ['order_id', 'payment_method', 'payment_date', 'payment_proof'];
    protected $useTimestamps = false; // Karena payment_date sudah diatur DEFAULT CURRENT_TIMESTAMP
}