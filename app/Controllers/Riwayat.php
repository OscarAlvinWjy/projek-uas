<?php

namespace App\Controllers;

use App\Models\TransaksiModel;
use App\Models\TransaksiDetailModel;

class Transaksi extends BaseController
{
    public function index()
    {
        $userId = session()->get('user_id');
        $filterTanggal = $this->request->getGet('tanggal');

        $transaksiModel = new TransaksiModel();
        $detailModel = new TransaksiDetailModel();

        $query = $transaksiModel->where('user_id', $userId);
        if ($filterTanggal) {
            $query->where('tanggal', $filterTanggal);
        }

        $transaksiList = $query->orderBy('tanggal', 'DESC')->findAll();

        foreach ($transaksiList as &$transaksi) {
            $transaksi['items'] = $detailModel
                ->where('transaksi_id', $transaksi['id'])
                ->findAll();
        }

        return view('riwayat_transaksi', [
            'transaksiList' => $transaksiList,
            'filterTanggal' => $filterTanggal
        ]);
    }

    public function detail($id)
    {
        // bisa dibuat nanti untuk menampilkan detail satu transaksi
    }
}

