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

        // 2. Generate ID (ORD-XXX)
        $id_order = 'ORD-' . date('dmY') . '-' . rand(1000, 9999);

        // 3. Cek Data Meja (Handling jika kosong)
        $no_meja = $json->no_meja;
        // PENTING: Jika meja kosong atau '0', ubah jadi NULL (sesuaikan dengan DB Anda)
        // Jika DB Anda mewajibkan isi (NOT NULL), ganti null dengan ID meja default (misal '1')
        if ($no_meja == '0' || $no_meja == '') {
            $no_meja = null; 
        }

        $dataOrder = [
            'id_order'      => $id_order,
            'id_meja'       => $no_meja,
            'nama_customer' => $json->nama,
            'nomor_telepon' => $json->no_hp,
            'tanggal_order' => date('Y-m-d'),
            'waktu_order'   => date('H:i:s'),
            'total_harga'   => $json->total_harga,
            'status_order'  => 'masuk'
        ];

        // 4. Proses Simpan (Tanpa Transaksi agar Error terlihat jelas)
        try {
            // A. Simpan Order (Header)
            if (!$orderModel->insert($dataOrder)) {
                $errors = $orderModel->errors();
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Gagal simpan Order: ' . implode(', ', $errors)
                ]);
            }

            // B. Simpan Detail (Isi Keranjang)
            foreach ($json->items as $item) {
                $dataDetail = [
                    'id_order' => $id_order,
                    'id_menu'  => $item->id_menu,
                    'quantity' => $item->qty,
                    'subtotal' => $item->qty * $item->harga
                ];

                if (!$detailModel->insert($dataDetail)) {
                    $errors = $detailModel->errors();
                    // Hapus order header jika detail gagal (Manual Rollback)
                    $orderModel->delete($id_order);
                    return $this->response->setJSON([
                        'success' => false, 
                        'message' => 'Gagal simpan Menu: ' . implode(', ', $errors)
                    ]);
                }
            }

            // SUKSES
            return $this->response->setJSON(['success' => true, 'id_order' => $id_order]);

        } catch (\Exception $e) {
            // Tampilkan error SQL asli (seperti Foreign Key Error)
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'System Error: ' . $e->getMessage()
            ]);
        }
    }

    // Method untuk halaman sukses (Closing)
    public function success($id_order)
    {
        return view('user/closing', ['id_order' => $id_order]);
    }
}