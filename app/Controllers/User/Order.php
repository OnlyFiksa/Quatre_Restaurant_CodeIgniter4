<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\DetailOrderModel;
use App\Models\MejaModel;

class Order extends BaseController
{
    public function process()
    {
        // 1. VALIDASI
        if (!$this->validate([
            'nama'        => 'required|min_length[3]',
            'items'       => 'required', 
            'total_harga' => 'required|numeric'
        ])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data tidak lengkap.',
                'errors'  => $this->validator->getErrors()
            ]);
        }

        $json = $this->request->getJSON();
        if (!$json) return $this->response->setJSON(['success' => false, 'message' => 'No Data']);

        $orderModel  = new OrderModel();
        $detailModel = new DetailOrderModel();
        
        // 3. ID Order
        $id_order = 'ORD-' . date('dmY') . '-' . rand(1000, 9999);

        // 4. Cek Input Meja (ID Meja dari Frontend)
        $id_meja = $json->no_meja; // Asumsi frontend kirim ID meja
        if ($id_meja == '0' || $id_meja == '') {
            $id_meja = null; 
        }

        // 5. Header Order
        $dataOrder = [
            'id_order'      => $id_order,
            'id_meja'       => $id_meja, 
            'nama_customer' => $json->nama,
            'nomor_telepon' => $json->no_hp,
            'tanggal_order' => date('Y-m-d'),
            'waktu_order'   => date('H:i:s'),
            'total_harga'   => $json->total_harga,
        ];

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // A. Insert Order
            $orderModel->insert($dataOrder);

            // B. Insert Detail
            foreach ($json->items as $item) {
                $detailModel->insert([
                    'id_order' => $id_order,
                    'id_menu'  => $item->id_menu,
                    'quantity' => $item->qty,
                    'subtotal' => $item->qty * $item->harga
                ]);
            }

            // C. UPDATE STATUS MEJA -> 'terisi'
            // Gunakan 'status_meja' sesuai database Anda
            if ($id_meja) {
                $db->table('meja')
                   ->where('id_meja', $id_meja)
                   ->update(['status_meja' => 'terisi']);
            }

            $db->transComplete();

            if ($db->transStatus() === FALSE) {
                return $this->response->setJSON(['success' => false, 'message' => 'Gagal Database Transaction']);
            }

            return $this->response->setJSON(['success' => true, 'id_order' => $id_order]);

        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    
    public function success($id_order)
    {
        return view('user/closing', ['id_order' => $id_order]);
    }
}