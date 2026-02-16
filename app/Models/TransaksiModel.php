<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table            = 'transaksi';
    protected $primaryKey       = 'id_transaksi';
    protected $allowedFields    = [
        'id_transaksi', 'id_order', 'id_admin', 'tanggal_transaksi', 
        'waktu_transaksi', 'metode_transaksi', 'status_transaksi', 'total_harga'
    ];
    // Pastikan field di database Anda sesuai, saya tambahkan total_harga jika perlu
    protected $useTimestamps = false;
}