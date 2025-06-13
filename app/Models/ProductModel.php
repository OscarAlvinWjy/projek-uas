<?php

namespace App\Models;
use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products'; // atau nama tabelmu
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'description', 'price', 'stock', 'image']; // daftar kolom yang bisa dimasukkan
    protected $useTimestamps = false; // atur ke true jika kamu pakai created_at & updated_at otomatis
}