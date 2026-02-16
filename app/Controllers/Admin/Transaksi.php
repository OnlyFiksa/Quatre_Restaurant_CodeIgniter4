<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TransaksiModel;
use App\Models\OrderModel;
use App\Models\MejaModel;

class Transaksi extends BaseController
{
    public function proses()
    {
        // 1. Cek Login & Method
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Silakan login ulang.']);
        }

        // Ambil data JSON dari fetch/ajax
        $input = $this->request->getJSON(true); // true = return as array

        if (!$input) {
            return $this->response->setJSON(['success' => false, 'message' => 'Data tidak valid.']);
        }

        $id_order = $input['id_order'];
        $id_meja  = $input['id_meja'];
        $metode   = $input['metode_pembayaran'];
        $id_admin = session()->get('id_admin'); // Ambil dari session login CI4

        // Load Model
        $transaksiModel = new TransaksiModel();
        $orderModel     = new OrderModel();
        $mejaModel      = new MejaModel();
        $db             = \Config\Database::connect();

        // 2. Ambil Total Harga dulu
        $order = $orderModel->find($id_order);
        if (!$order) {
            return $this->response->setJSON(['success' => false, 'message' => 'Order tidak ditemukan.']);
        }

        // --- MULAI TRANSAKSI DATABASE ---
        $db->transStart();

        try {
            // A. Insert ke Tabel Transaksi
            $id_transaksi = 'tr' . rand(10000000, 99999999);
            $transaksiModel->insert([
                'id_transaksi'      => $id_transaksi,
                'id_order'          => $id_order,
                'id_admin'          => $id_admin,
                'tanggal_transaksi' => date('Y-m-d'),
                'waktu_transaksi'   => date('H:i:s'),
                'metode_transaksi'  => $metode,
                'status_transaksi'  => 'Selesai'
            ]);

            // B. Update Status Order -> Selesai
            $orderModel->update($id_order, ['status_order' => 'selesai']);

            // C. Update Status Meja -> Tersedia
            $mejaModel->update($id_meja, ['status_meja' => 'tersedia']);

            // Selesaikan Transaksi
            $db->transComplete();

            if ($db->transStatus() === false) {
                // Jika ada error database di tengah jalan
                return $this->response->setJSON(['success' => false, 'message' => 'Gagal menyimpan transaksi database.']);
            }

            // SUKSES!
            return $this->response->setJSON([
                'success' => true, 
                'message' => 'Pembayaran Berhasil! Meja sekarang tersedia.'
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}