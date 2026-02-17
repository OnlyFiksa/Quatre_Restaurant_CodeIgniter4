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
        
        // Ambil Input
        $input = $this->request->getJSON(true);
        $id_order = $input['id_order'] ?? null;
        $id_meja  = $input['id_meja'] ?? null;
        $metode   = $input['metode_pembayaran'] ?? 'Cash'; // Default Cash
        $id_admin = session()->get('id_admin');

        if (!$id_order || !$id_admin) {
            return $this->response->setJSON(['success' => false, 'message' => 'Data tidak valid.']);
        }

        $transaksiModel = new TransaksiModel();
        $orderModel     = new OrderModel();
        $mejaModel      = new MejaModel();
        $db             = \Config\Database::connect();

        // LOGIKA BARU: GENERATE ID (TR-DDMMYY-XXX)
        // ---------------------------------------------------------
        $tanggalHariIni = date('dmy'); // Contoh: 170226
        $prefix = "TR-" . $tanggalHariIni . "-"; // TR-170226-

        // Cari transaksi terakhir yang mirip prefix hari ini
        $lastTrx = $transaksiModel->like('id_transaksi', $prefix, 'after')
                                  ->orderBy('id_transaksi', 'DESC')
                                  ->first();

        if ($lastTrx) {
            // Jika ada (misal TR-170226-001), ambil 3 angka terakhir
            $lastNumber = substr($lastTrx['id_transaksi'], -3); 
            $nextNumber = intval($lastNumber) + 1; // 1 jadi 2
        } else {
            // Jika belum ada transaksi hari ini
            $nextNumber = 1;
        }

        // Format jadi 3 digit (001, 002, 010, dst)
        $id_transaksi = $prefix . sprintf("%03d", $nextNumber);
        // Hasil Akhir: TR-170226-001
        // ---------------------------------------------------------

        $db->transStart();

        try {
            // A. Simpan Transaksi
            $transaksiModel->insert([
                'id_transaksi'      => $id_transaksi,
                'id_order'          => $id_order,
                'id_admin'          => $id_admin,
                'tanggal_transaksi' => date('Y-m-d'),
                'waktu_transaksi'   => date('H:i:s'),
                'metode_transaksi'  => $metode,
                'status_transaksi'  => 'Selesai' // Sesuai ENUM
            ]);

            // B. Update Order jadi Selesai
            $orderModel->update($id_order, ['status_order' => 'selesai']);

            // C. Kosongkan Meja
            if ($id_meja) {
                $mejaModel->update($id_meja, ['status_meja' => 'tersedia']);
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                return $this->response->setJSON(['success' => false, 'message' => 'Gagal menyimpan transaksi.']);
            }

            return $this->response->setJSON([
                'success' => true, 
                'message' => 'Pembayaran Berhasil! ID: ' . $id_transaksi
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }
}