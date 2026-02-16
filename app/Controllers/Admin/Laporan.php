<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminModel;

class Laporan extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $adminModel = new AdminModel();

        // 1. Ambil Data Kasir untuk Dropdown Filter
        $kasirList = $adminModel->orderBy('nama', 'ASC')->findAll();

        // 2. Ambil Input Filter dari URL (GET Request)
        $startDate = $this->request->getGet('start_date');
        $endDate   = $this->request->getGet('end_date');
        $kasirId   = $this->request->getGet('kasir');

        // 3. Bangun Query Laporan
        $builder = $db->table('transaksi');
        $builder->select('transaksi.*, orders.total_harga, admin.nama as nama_kasir');
        $builder->join('orders', 'transaksi.id_order = orders.id_order');
        $builder->join('admin', 'transaksi.id_admin = admin.id_admin');
        $builder->where('transaksi.status_transaksi', 'Selesai');

        // Terapkan Filter jika ada
        if (!empty($startDate)) {
            $builder->where('transaksi.tanggal_transaksi >=', $startDate);
        }
        if (!empty($endDate)) {
            $builder->where('transaksi.tanggal_transaksi <=', $endDate);
        }
        if (!empty($kasirId)) {
            $builder->where('transaksi.id_admin', $kasirId);
        }

        // Urutkan Terbaru
        $builder->orderBy('transaksi.tanggal_transaksi', 'DESC');
        $builder->orderBy('transaksi.waktu_transaksi', 'DESC');

        $laporan = $builder->get()->getResultArray();

        // 4. Hitung Total Pendapatan
        $totalPendapatan = 0;
        foreach ($laporan as $row) {
            $totalPendapatan += $row['total_harga'];
        }

        $data = [
            'laporan'   => $laporan,
            'kasirList' => $kasirList,
            'total'     => $totalPendapatan,
            'filters'   => [
                'start_date' => $startDate,
                'end_date'   => $endDate,
                'kasir'      => $kasirId
            ]
        ];

        return view('admin/laporan/index', $data);
    }
}