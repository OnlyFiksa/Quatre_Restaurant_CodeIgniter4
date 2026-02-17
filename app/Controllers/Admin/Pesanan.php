<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\DetailOrderModel;
use App\Models\TransaksiModel;

class Pesanan extends BaseController
{
    // 1. DAFTAR PESANAN
    public function index()
    {
        $model = new OrderModel();
        $data['orders'] = $model->orderBy('id_order', 'DESC')->findAll();
        return view('admin/pesanan/index', $data);
    }

    // 2. DETAIL PESANAN
    public function detail($id)
    {
        $orderModel = new OrderModel();
        $detailModel = new DetailOrderModel();

        $data['order'] = $orderModel->find($id);
        
        // Join ke menu untuk ambil nama dan harga
        $data['details'] = $detailModel->select('detail_orders.*, menu.nama_menu, menu.harga')
                                       ->join('menu', 'menu.id_menu = detail_orders.id_menu')
                                       ->where('id_order', $id)
                                       ->findAll();

        return view('admin/pesanan/detail', $data);
    }

    // 3. ACTION: PROSES MASAK
    public function proses($id)
    {
        $model = new OrderModel();
        $model->update($id, ['status_order' => 'diproses']);
        return redirect()->to('admin/pesanan')->with('success', 'Pesanan sedang diproses dapur!');
    }

}