<?php

namespace App\Controllers;

use App\Models\TransaksiModel;
use App\Models\TransaksiDetailModel;
use CodeIgniter\Controller;

class Transaksi extends Controller
{
    protected $transaksiModel;
    protected $transaksiDetailModel;

    public function __construct()
    {
        $this->transaksiModel = new TransaksiModel();
        $this->transaksiDetailModel = new TransaksiDetailModel();
    }

    public function index()
{
    $userId = session()->get('user_id');

    $filterTanggal = $this->request->getGet('tanggal');

    $builder = $this->transaksiModel->where('user_id', $userId);
    if ($filterTanggal) {
        $builder->where('DATE(tanggal)', $filterTanggal);
    }

    $transaksi = $builder->orderBy('tanggal', 'DESC')->findAll();

    // Ambil detail item untuk tiap transaksi
    $transaksiWithItems = [];
    foreach ($transaksi as $row) {
        $row['items'] = $this->transaksiDetailModel
            ->where('transaksi_id', $row['id'])->findAll();
        $transaksiWithItems[] = $row;
    }

    return view('riwayat_transaksi', [
        'transaksiList' => $transaksiWithItems,
        'filterTanggal' => $filterTanggal
    ]);
}


}
