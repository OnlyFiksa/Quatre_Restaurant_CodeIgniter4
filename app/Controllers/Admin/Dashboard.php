<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\MejaModel;
use App\Models\TransaksiModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        // 1. Hitung Pendapatan Hari Ini
        // Query Native Anda: SELECT SUM(orders.total_harga) ... JOIN ... WHERE ...
        $queryPendapatan = $db->table('transaksi')
            ->selectSum('orders.total_harga', 'total_pendapatan')
            ->join('orders', 'transaksi.id_order = orders.id_order')
            ->where('transaksi.status_transaksi', 'Selesai')
            ->where('transaksi.tanggal_transaksi', date('Y-m-d')) // Hari ini
            ->get()
            ->getRowArray();
            
        $pendapatanHariIni = $queryPendapatan['total_pendapatan'] ?? 0;

        // 2. Hitung Pesanan Baru (Status 'proses')
        $orderModel = new OrderModel();
        $pesananBaru = $orderModel->where('status_order', 'proses')->countAllResults();

        // 3. Hitung Meja Terisi (Status 'tidak tersedia')
        $mejaModel = new MejaModel();
        $mejaTerisi = $mejaModel->where('status_meja', 'tidak tersedia')->countAllResults();

        // Kirim data ke View
        $data = [
            'pendapatan_hari_ini' => $pendapatanHariIni,
            'pesanan_baru'        => $pesananBaru,
            'meja_terisi'         => $mejaTerisi
        ];

        return view('admin/dashboard', $data);
    }
}