<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;

class Pesanan extends BaseController
{
    protected $orderModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
    }

    // 1. HALAMAN UTAMA (DAFTAR PESANAN)
    public function index()
    {
        $db = \Config\Database::connect();

        // Query: Ambil semua order + nomor meja, urutkan dari yang terbaru
        $orders = $db->table('orders')
            ->select('orders.*, meja.nomor_meja')
            ->join('meja', 'orders.id_meja = meja.id_meja')
            ->orderBy('orders.tanggal_order', 'DESC')
            ->orderBy('orders.waktu_order', 'DESC')
            ->get()->getResultArray();

        $data = [
            'orders' => $orders
        ];

        return view('admin/pesanan/index', $data);
    }

    // 2. HALAMAN DETAIL PESANAN
    public function detail($id_order)
    {
        $db = \Config\Database::connect();

        // Ambil Info Order Utama
        $order = $db->table('orders')
            ->select('orders.*, meja.nomor_meja')
            ->join('meja', 'orders.id_meja = meja.id_meja')
            ->where('orders.id_order', $id_order)
            ->get()->getRowArray();

        if (!$order) {
            return redirect()->to('/admin/pesanan');
        }

        // Ambil Detail Menu yang dipesan
        $items = $db->table('detail_orders')
            ->select('detail_orders.*, menu.nama_menu, menu.harga')
            ->join('menu', 'detail_orders.id_menu = menu.id_menu')
            ->where('detail_orders.id_order', $id_order)
            ->get()->getResultArray();

        $data = [
            'order' => $order,
            'items' => $items
        ];

        return view('admin/pesanan/detail', $data);
    }
}