<?php

namespace App\Models;
use CodeIgniter\Model;

class TransaksiDetailModel extends Model
{
    protected $table = 'transaksi_detail';
    protected $primaryKey = 'id';
    protected $allowedFields = ['transaksi_id', 'produk_id', 'nama_produk', 'harga', 'qty'];
}
