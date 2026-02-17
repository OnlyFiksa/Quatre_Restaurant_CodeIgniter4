<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\DetailOrderModel;

class Detail extends ResourceController
{
    use ResponseTrait;

    // GET /api/detail
    public function index()
    {
        $model = new DetailOrderModel();
        $data = $model->select('detail_orders.*, menu.nama_menu')
                      ->join('menu', 'menu.id_menu = detail_orders.id_menu')
                      ->findAll();
        return $this->respond($data);
    }

    // GET /api/detail/(:id_order) -> Menampilkan semua menu dalam 1 order
    public function show($id_order = null)
    {
        $model = new DetailOrderModel();
        $data = $model->select('detail_orders.*, menu.nama_menu, menu.harga')
                      ->join('menu', 'menu.id_menu = detail_orders.id_menu')
                      ->where('id_order', $id_order)
                      ->findAll();

        if ($data) return $this->respond($data);
        return $this->failNotFound('Detail order tidak ditemukan');
    }
}