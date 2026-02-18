<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\OrderModel;
use App\Models\DetailOrderModel;

class Order extends ResourceController
{
    use ResponseTrait;

    // POST /api/order (Buat Pesanan)
    public function create()
    {
        // 1. VALIDASI DATA (Security)
        if (!$this->validate([
            'nama_pelanggan' => 'required',
            'detail'         => 'required' // Harus ada array detail menu
        ])) {
            return $this->fail($this->validator->getErrors());
        }

        $json = $this->request->getJSON();
        if (!$json) return $this->fail('Data JSON Kosong', 400);

        $orderModel = new OrderModel();
        $detailModel = new DetailOrderModel();
        $db = \Config\Database::connect();

        // Generate ID Order
        $id_order = 'ORD-' . date('dm') . '-' . rand(100, 999);

        $db->transStart();

        // 2. Simpan Header Order
        $orderModel->insert([
            'id_order'      => $id_order,
            'id_meja'       => $json->id_meja ?? null,
            'nama_customer' => $json->nama_pelanggan,
            'nomor_telepon' => $json->nomor_telepon ?? '-',
            'tanggal_order' => date('Y-m-d'),
            'waktu_order'   => date('H:i:s'),
            'total_harga'   => 0, // Nanti diupdate
        ]);

        // 3. Simpan Detail
        $total_harga = 0;
        if(isset($json->detail)){
            foreach ($json->detail as $item) {
                $id_menu = (string) $item->id_menu; 

                // Ambil harga dari DB Menu
                $menu = $db->table('menu')->where('id_menu', $id_menu)->get()->getRowArray();
                
                if (!$menu) {
                     return $this->failNotFound("Menu ID '$id_menu' tidak ditemukan!");
                }

                $harga = $menu['harga'];
                $subtotal = $harga * $item->qty;
                $total_harga += $subtotal;
    
                $detailModel->insert([
                    'id_order' => $id_order,
                    'id_menu'  => $id_menu, 
                    'quantity' => $item->qty,
                    'subtotal' => $subtotal
                ]);
            }
        }

        // 4. Update Total Harga Asli
        $orderModel->update($id_order, ['total_harga' => $total_harga]);

        $db->transComplete();

        if ($db->transStatus() === FALSE) {
            return $this->failServerError('Gagal menyimpan ke database');
        }

        return $this->respondCreated([
            'status' => 201,
            'message' => 'Order Berhasil',
            'id_order' => $id_order,
            'tagihan' => $total_harga
        ]);
    }

    // GET /api/order
    public function index()
    {
        $model = new OrderModel();
        $data = $model->where('status_order !=', 'selesai')->findAll();
        return $this->respond($data);
    }
}