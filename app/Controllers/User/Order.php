<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\DetailOrderModel;

class Order extends BaseController
{
    public function process()
    {
        // 1. Cek Data Masuk
        $json = $this->request->getJSON();
        if (!$json) {
            return $this->response->setJSON(['success' => false, 'message' => 'Tidak ada data dikirim']);
        }

        $orderModel = new OrderModel();
        $detailModel = new DetailOrderModel();

        // 2. Generate ID (ORD-TanggalBulanTahun-Acak)
        // Sesuai screenshot: ORD-17022026-xxxx
        $id_order = 'ORD-' . date('dmY') . '-' . rand(1000, 9999);

        // 3. Cek Data Meja
        $no_meja = $json->no_meja;
        if ($no_meja == '0' || $no_meja == '') {
            $no_meja = null; 
        }

        // 4. Siapkan Data Header
        $dataOrder = [
            'id_order'      => $id_order,
            'id_meja'       => $no_meja,
            'nama_customer' => $json->nama,
            'nomor_telepon' => $json->no_hp,
            'tanggal_order' => date('Y-m-d'),
            'waktu_order'   => date('H:i:s'),
            'total_harga'   => $json->total_harga,
            
            // ❌ KITA HAPUS BARIS INI
            // 'status_order'  => 'proses', 

            // ✅ PENJELASAN:
            // Karena di database kolom status_order sudah ada DEFAULT 'proses',
            // kita jangan kirim apa-apa dari sini. Biarkan MySQL yang otomatis mengisinya.
            // Ini menghindari typo atau error ENUM yang menolak data.
        ];

        // 5. Proses Simpan
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // A. Simpan Header via Model
            if (!$orderModel->insert($dataOrder)) {
                $errors = $orderModel->errors();
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Gagal simpan Order: ' . implode(', ', $errors)
                ]);
            }

            // B. Simpan Detail
            foreach ($json->items as $item) {
                $dataDetail = [
                    'id_order' => $id_order,
                    'id_menu'  => $item->id_menu,
                    'quantity' => $item->qty,
                    'subtotal' => $item->qty * $item->harga
                ];

                if (!$detailModel->insert($dataDetail)) {
                    $db->transRollback();
                    return $this->response->setJSON([
                        'success' => false, 
                        'message' => 'Gagal simpan detail menu.'
                    ]);
                }
            }

            $db->transComplete();

            if ($db->transStatus() === FALSE) {
                return $this->response->setJSON(['success' => false, 'message' => 'Gagal insert ke database']);
            }

            // SUKSES
            return $this->response->setJSON(['success' => true, 'id_order' => $id_order]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'System Error: ' . $e->getMessage()
            ]);
        }
    }
    
    public function success($id_order)
    {
        return view('user/closing', ['id_order' => $id_order]);
    }
}