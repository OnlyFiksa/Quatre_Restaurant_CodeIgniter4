<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\DetailOrderModel;

class Order extends BaseController
{
    public function process()
    {
        // 1. VALIDASI INPUT (Security Requirement Modul)
        // Pastikan nama ada, items ada, dan total_harga angka
        if (!$this->validate([
            'nama'        => 'required|min_length[3]',
            'items'       => 'required', 
            'total_harga' => 'required|numeric'
        ])) {
            // Jika validasi gagal, kirim pesan error
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data tidak lengkap atau format salah.',
                'errors'  => $this->validator->getErrors()
            ]);
        }

        // 2. Ambil JSON
        $json = $this->request->getJSON();
        if (!$json) {
            return $this->response->setJSON(['success' => false, 'message' => 'Tidak ada data JSON']);
        }

        $orderModel = new OrderModel();
        $detailModel = new DetailOrderModel();

        // 3. Generate ID (ORD-TanggalBulanTahun-Acak)
        $id_order = 'ORD-' . date('dmY') . '-' . rand(1000, 9999);

        // 4. Cek Data Meja
        $no_meja = $json->no_meja;
        if ($no_meja == '0' || $no_meja == '') {
            $no_meja = null; 
        }

        // 5. Siapkan Data Header
        $dataOrder = [
            'id_order'      => $id_order,
            'id_meja'       => $no_meja,
            'nama_customer' => $json->nama,
            'nomor_telepon' => $json->no_hp,
            'tanggal_order' => date('Y-m-d'),
            'waktu_order'   => date('H:i:s'),
            'total_harga'   => $json->total_harga,
            // 'status_order' => 'proses' (Default DB)
        ];

        // 6. Proses Simpan dengan Transaksi DB
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // A. Simpan Header
            if (!$orderModel->insert($dataOrder)) {
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Gagal simpan Order Header'
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