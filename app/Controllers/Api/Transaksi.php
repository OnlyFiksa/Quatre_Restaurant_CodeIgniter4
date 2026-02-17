<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\OrderModel;
use App\Models\TransaksiModel;

class Transaksi extends ResourceController
{
    use ResponseTrait;

    // POST /api/transaksi (Kasir Simpan Pembayaran)
    public function create()
    {
        // 1. Ambil Data JSON dari Postman/Android
        $json = $this->request->getJSON();

        // Validasi input minimal
        if (!$json || !isset($json->id_order) || !isset($json->id_admin)) {
            return $this->fail('Data JSON tidak lengkap (id_order & id_admin wajib)', 400);
        }

        $orderModel = new OrderModel();
        $transaksiModel = new TransaksiModel();
        $db = \Config\Database::connect();

        // 2. Cek apakah Order Benar Ada?
        $cekOrder = $orderModel->find($json->id_order);
        if (!$cekOrder) {
            return $this->failNotFound('Order tidak ditemukan dengan ID: ' . $json->id_order);
        }

        // 3. Generate ID Transaksi (Contoh: TRX-17022026-001)
        $id_transaksi = 'TRX-' . date('dmY') . '-' . rand(100, 999);

        // 4. Mulai Transaksi Database (Biar aman)
        $db->transStart();

        try {
            // A. INSERT ke Tabel TRANSAKSI
            // Sesuai atribut kamu: id_transaksi, id_order, id_admin, tanggal, waktu, metode, status
            $dataTransaksi = [
                'id_transaksi'      => $id_transaksi,
                'id_order'          => $json->id_order,
                'id_admin'          => $json->id_admin, // Admin yang sedang login/bertugas
                'tanggal_transaksi' => date('Y-m-d'),
                'waktu_transaksi'   => date('H:i:s'),
                'metode_transaksi'  => $json->metode_transaksi ?? 'tunai', // Default tunai kalau kosong
                'status_transaksi'  => 'lunas' // Default lunas saat dibuat
            ];
            
            $transaksiModel->insert($dataTransaksi);

            // B. UPDATE Status di Tabel ORDERS
            // Ubah status_order jadi 'selesai' biar koki/pelayan tau meja ini sudah beres
            $orderModel->update($json->id_order, [
                'status_order' => 'selesai'
            ]);

            // Commit (Simpan Permanen)
            $db->transComplete();

            if ($db->transStatus() === FALSE) {
                return $this->failServerError('Gagal menyimpan transaksi');
            }

            // 5. Berhasil
            return $this->respondCreated([
                'status'   => 201,
                'message'  => 'Pembayaran Berhasil',
                'data'     => [
                    'id_transaksi' => $id_transaksi,
                    'id_order'     => $json->id_order,
                    'total_harga'  => $cekOrder['total_harga'], // Ambil info harga dari tabel order
                    'status'       => 'Lunas'
                ]
            ]);

        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    // GET /api/transaksi (Lihat History Pembayaran)
    public function index()
    {
        $model = new TransaksiModel();
        
        // Kita JOIN ke tabel orders dan admin biar datanya lengkap (siapa pelanggannya, siapa kasirnya)
        // Pastikan tabel admin kamu primary key-nya 'id_admin'
        $data = $model->select('transaksi.*, orders.nama_customer, orders.total_harga, admin.nama as nama_kasir')
                      ->join('orders', 'orders.id_order = transaksi.id_order')
                      ->join('admin', 'admin.id_admin = transaksi.id_admin', 'left') 
                      ->orderBy('id_transaksi', 'DESC')
                      ->findAll();

        return $this->respond($data);
    }
}