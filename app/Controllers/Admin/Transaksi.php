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
        $input    = $this->request->getJSON(true);
        $id_order = $input['id_order'] ?? null;
        $id_meja  = $input['id_meja'] ?? null; // ID Meja
        $metode   = $input['metode_pembayaran'] ?? 'Cash';
        $id_admin = session()->get('id_admin');

        if (!$id_order || !$id_admin) {
            return $this->response->setJSON(['success' => false, 'message' => 'Data Invalid']);
        }

        $transaksiModel = new TransaksiModel();
        $orderModel     = new OrderModel();
        $db             = \Config\Database::connect();

        // Generate ID Transaksi (TR-DATE-XXX)
        $prefix = "TR-" . date('dmy') . "-"; 
        $lastTrx = $transaksiModel->like('id_transaksi', $prefix, 'after')
                                  ->orderBy('id_transaksi', 'DESC')->first();
        $nextNumber = $lastTrx ? intval(substr($lastTrx['id_transaksi'], -3)) + 1 : 1;
        $id_transaksi = $prefix . sprintf("%03d", $nextNumber);

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
                'status_transaksi'  => 'Selesai'
            ]);

            // B. Update Order -> Selesai
            $orderModel->update($id_order, ['status_order' => 'selesai']);

            // C. UPDATE STATUS MEJA -> 'tersedia'
            // Gunakan 'status_meja' sesuai database Anda
            if ($id_meja) {
                $db->table('meja')
                   ->where('id_meja', $id_meja)
                   ->update(['status_meja' => 'tersedia']);
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                return $this->response->setJSON(['success' => false, 'message' => 'Gagal Transaksi']);
            }

            return $this->response->setJSON(['success' => true, 'message' => 'Berhasil! ID: ' . $id_transaksi]);

        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}