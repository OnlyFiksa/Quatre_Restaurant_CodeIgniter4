<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MenuModel;
use App\Models\AdminModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $menuModel = new MenuModel();
        $adminModel = new AdminModel();

        // 1. HITUNG PENDAPATAN (Status = Selesai)
        $queryPendapatan = $db->table('orders')
                              ->selectSum('total_harga')
                              ->where('status_order', 'selesai')
                              ->get()
                              ->getRow();
        $pendapatan = $queryPendapatan->total_harga ?? 0;

        // 2. HITUNG TOTAL ORDER
        $count_transaksi = $db->table('orders')->countAll();

        // 3. HITUNG MENU AKTIF
        $count_menu = $menuModel->where('status_menu', 'tersedia')->countAllResults();

        // 4. HITUNG STAFF
        $count_admin = $adminModel->countAllResults();

        // KIRIM DATA KE VIEW
        $data = [
            'pendapatan'      => $pendapatan,
            'count_transaksi' => $count_transaksi,
            'count_menu'      => $count_menu,
            'count_admin'     => $count_admin
        ];

        return view('admin/dashboard', $data);
    }
}