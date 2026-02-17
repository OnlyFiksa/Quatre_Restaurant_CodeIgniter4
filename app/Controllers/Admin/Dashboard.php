<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        
        $db = \Config\Database::connect();

        // 1. PENDAPATAN HARI INI (Dari tabel transaksi yang statusnya Selesai)
        $today_income = $db->table('transaksi')
                           ->join('orders', 'orders.id_order = transaksi.id_order')
                           ->where('transaksi.tanggal_transaksi', date('Y-m-d'))
                           ->where('transaksi.status_transaksi', 'Selesai')
                           ->selectSum('orders.total_harga')
                           ->get()->getRow()->total_harga;

        // 2. TOTAL MENU (Semua menu yang ada)
        $total_menu = $db->table('menu')->countAllResults();

        // 3. PESANAN HARI INI (Order masuk hari ini)
        $today_orders = $db->table('orders')
                           ->where('tanggal_order', date('Y-m-d'))
                           ->countAllResults();

        // 4. JUMLAH STAFF (Total admin/user)
        $total_staff = $db->table('admin')->countAllResults();

        $data = [
            'today_income' => $today_income,
            'total_menu'   => $total_menu,
            'today_orders' => $today_orders,
            'total_staff'  => $total_staff
        ];

        return view('admin/dashboard', $data);
    }

    // --- FUNGSI GRAFIK (HANYA INCOME) ---
    public function chartData()
    {
        $db = \Config\Database::connect();

        // Grafik Pendapatan 7 Hari Terakhir
        $incomeData = $db->table('transaksi')
            ->select('DATE(tanggal_transaksi) as tanggal, SUM(orders.total_harga) as total')
            ->join('orders', 'orders.id_order = transaksi.id_order')
            ->where('status_transaksi', 'Selesai')
            ->groupBy('DATE(tanggal_transaksi)')
            ->orderBy('tanggal_transaksi', 'ASC')
            ->limit(7)
            ->get()
            ->getResultArray();

        return $this->response->setJSON([
            'income' => $incomeData
        ]);
    }
}